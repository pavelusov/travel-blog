<?php
//Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * After setup theme hook
 */
function travel_diary_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'travel-diary', get_stylesheet_directory() . '/languages' );
    add_image_size( 'travel-diary-slider-two', 787, 588, true );

}
add_action( 'after_setup_theme', 'travel_diary_theme_setup', 100 );

function travel_diary_customize_script(){

    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    wp_enqueue_script('travel-diary-customize', get_stylesheet_directory_uri() . '/js/child-customize.js', array('jquery', 'customize-controls'), $version, true);

}
add_action('customize_controls_enqueue_scripts', 'travel_diary_customize_script');

function travel_diary_enqueue_styles() {
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
   
    wp_enqueue_style( 'blossom-pin', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'travel-diary', get_stylesheet_directory_uri() . '/style.css', array( 'blossom-pin' ), $version );

    wp_enqueue_script( 'travel-diary', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery' ), $version, true );

    $array = array(
        'rtl'  => is_rtl(),
    );
    wp_localize_script( 'travel-diary', 'travel_diary_data', $array );

}
add_action( 'wp_enqueue_scripts', 'travel_diary_enqueue_styles', 10 );

//Remove a function from the parent theme
function travel_diary_remove_parent_filters(){ //Have to do it after theme setup, because child theme functions are loaded first
    remove_action( 'customize_register', 'blossom_pin_customizer_theme_info' );
    remove_action( 'customize_register', 'blossom_pin_customize_register_color' );
    remove_action( 'customize_register', 'blossom_pin_customize_register_appearance' );
}
add_action( 'init', 'travel_diary_remove_parent_filters' );

function travel_diary_customizer_register( $wp_customize ) {
    $wp_customize->add_section( 'theme_info', array(
        'title'       => __( 'Demo & Documentation' , 'travel-diary' ),
        'priority'    => 6,
    ) );
    
    /** Important Links */
    $wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<p>';
    $theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'travel-diary' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=travel-diary' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'travel-diary' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/travel-diary/' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p>';

    $wp_customize->add_control( new Blossom_Pin_Note_Control( $wp_customize,
        'theme_info_theme', 
            array(
                'section'     => 'theme_info',
                'description' => $theme_info
            )
        )
    );

    /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', array(
            'default'           => '#f48585',
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'travel-diary' ),
                'description' => __( 'Primary color of the theme.', 'travel-diary' ),
                'section'     => 'colors',
                'priority'    => 5,                
            )
        )
    );

    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 50,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'travel-diary' ),
            'description' => __( 'Customize Typography & Background Image', 'travel-diary' ),
        ) 
    );

    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'travel-diary' ),
            'priority' => 15,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'Inter',
            'sanitize_callback' => 'blossom_pin_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Pin_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'travel-diary' ),
                'description' => __( 'Primary font of the site.', 'travel-diary' ),
                'section'     => 'typography_settings',
                'choices'     => blossom_pin_get_all_fonts(),   
            )
        )
    );

    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Cormorant Garamond',
            'sanitize_callback' => 'blossom_pin_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Pin_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'travel-diary' ),
                'description' => __( 'Secondary font of the site.', 'travel-diary' ),
                'section'     => 'typography_settings',
                'choices'     => blossom_pin_get_all_fonts(),   
            )
        )
    );

    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 18,
            'sanitize_callback' => 'blossom_pin_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'travel-diary' ),
                'description' => __( 'Change the font size of your site.', 'travel-diary' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_pin_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Toggle_Control( 
            $wp_customize,
            'ed_localgoogle_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Load Google Fonts Locally', 'travel-diary' ),
                'description'   => __( 'Enable to load google fonts from your own server instead from google\'s CDN. This solves privacy concerns with Google\'s CDN and their sometimes less-than-transparent policies.', 'travel-diary' )
            )
        )
    );   

    $wp_customize->add_setting(
        'ed_preload_local_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_pin_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Toggle_Control( 
            $wp_customize,
            'ed_preload_local_fonts',
            array(
                'section'       => 'typography_settings',
                'label'         => __( 'Preload Local Fonts', 'travel-diary' ),
                'description'   => __( 'Preloading Google fonts will speed up your website speed.', 'travel-diary' ),
                'active_callback' => 'blossom_pin_ed_localgoogle_fonts'
            )
        )
    );   

    ob_start(); ?>
        
        <span style="margin-bottom: 5px;display: block;"><?php esc_html_e( 'Click the button to reset the local fonts cache', 'travel-diary' ); ?></span>
        
        <input type="button" class="button button-primary blossom-pin-flush-local-fonts-button" name="blossom-pin-flush-local-fonts-button" value="<?php esc_attr_e( 'Flush Local Font Files', 'travel-diary' ); ?>" />
    <?php
    $travel_diary_flush_button = ob_get_clean();

    $wp_customize->add_setting(
        'ed_flush_local_fonts',
        array(
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'ed_flush_local_fonts',
        array(
            'label'         => __( 'Flush Local Fonts Cache', 'travel-diary' ),
            'section'       => 'typography_settings',
            'description'   => $travel_diary_flush_button,
            'type'          => 'hidden',
            'active_callback' => 'blossom_pin_ed_localgoogle_fonts'
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 10;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 10;

    $wp_customize->add_section(
        'sidebar_layout_settings',
        array(
            'title'       => __( 'General Sidebar Layout', 'travel-diary' ),
            'description' => __( 'Change Page, Post and General sidebar layout from here.', 'travel-diary' ),
            'capability'  => 'edit_theme_options',
            'panel'       => 'layout_settings',
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_pin_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Pin_Radio_Image_Control(
			$wp_customize,
			'page_sidebar_layout',
			array(
				'section'	  => 'sidebar_layout_settings',
				'label'		  => __( 'Page Sidebar Layout', 'travel-diary' ),
				'description' => __( 'This is the general sidebar layout for pages. You can override the sidebar layout for individual page in respective page.', 'travel-diary' ),
				'choices'	  => array(
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
					'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_pin_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Pin_Radio_Image_Control(
			$wp_customize,
			'post_sidebar_layout',
			array(
				'section'	  => 'sidebar_layout_settings',
				'label'		  => __( 'Post Sidebar Layout', 'travel-diary' ),
				'description' => __( 'This is the general sidebar layout for posts. You can override the sidebar layout for individual post in respective post.', 'travel-diary' ),
				'choices'	  => array(
                    'centered'      => esc_url( get_template_directory_uri() . '/images/1cc.jpg' ),
					'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);

     /** Default Sidebar layout */
     $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_pin_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Pin_Radio_Image_Control(
			$wp_customize,
			'layout_style',
			array(
				'section'	  => 'sidebar_layout_settings',
				'label'		  => __( 'Default Sidebar Layout', 'travel-diary' ),
				'description' => __( 'This is the general sidebar layout for whole site.', 'travel-diary' ),
				'choices'	  => array(
					'no-sidebar'    => esc_url( get_template_directory_uri() . '/images/1c.jpg' ),
                    'left-sidebar'  => esc_url( get_template_directory_uri() . '/images/2cl.jpg' ),
                    'right-sidebar' => esc_url( get_template_directory_uri() . '/images/2cr.jpg' ),
				)
			)
		)
	);

    /**Header Layout */
    $wp_customize->add_section(
        'header_layout',
        array(
            'title'    => __( 'Header Layout', 'travel-diary' ),
            'panel'    => 'layout_settings',
            'priority' => 10,
        )
    );
    
    /**Header layout */
    $wp_customize->add_setting( 
        'header_layout_option', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'blossom_pin_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Radio_Image_Control(
            $wp_customize,
            'header_layout_option',
            array(
                'section'     => 'header_layout',
                'label'       => __( 'Header Layout', 'travel-diary' ),
                'description' => __( 'it is the layout for header.', 'travel-diary' ),
                'choices'     => array(                 
                    'one'   => get_stylesheet_directory_uri() . '/images/header/one.jpg',
                    'two'   => get_stylesheet_directory_uri() . '/images/header/two.jpg',
                )
            )
        )
    );

    /** Slider Layout Settings */
    $wp_customize->add_section(
        'slider_layout_settings',
        array(
            'title'    => __( 'Slider Layout', 'travel-diary' ),
            'priority' => 20,
            'panel'    => 'layout_settings',
        )
    );

    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'slider_layout', 
        array(
            'default'           => 'eight',
            'sanitize_callback' => 'blossom_pin_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Blossom_Pin_Radio_Image_Control(
            $wp_customize,
            'slider_layout',
            array(
                'section'     => 'slider_layout_settings',
                'label'       => __( 'Slider Layout', 'travel-diary' ),
                'description' => __( 'Choose the layout of the slider for your site.', 'travel-diary' ),
                'choices'     => array(
                    'one'     => get_stylesheet_directory_uri() . '/images/slider/one.jpg',
                    'eight'   => get_stylesheet_directory_uri() . '/images/slider/eight.jpg',
                )
            )
        )
    );
    $wp_customize->add_setting(
        'slider_banner_layout_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Note_Control( 
            $wp_customize,
            'slider_banner_layout_text',
            array(
                'section'     => 'slider_layout_settings',
                'description' => sprintf( __( '%1$sClick here%2$s to configure slider settings.', 'travel-diary' ), '<span class="text-inner-link slider_banner_layout_text">', '</span>' ),
            )
        )
    );

    $wp_customize->add_setting(
        'slider_banner_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Pin_Note_Control( 
            $wp_customize,
            'slider_banner_text',
            array(
                'section'     => 'header_image',
                'description' => sprintf( __( '%1$sClick here%2$s to select the layout of slider banner.', 'travel-diary' ), '<span class="text-inner-link slider_banner_text">', '</span>' ),
            )
        )
    );
}
add_action( 'customize_register', 'travel_diary_customizer_register', 40);

/**
 * Header Start
*/
function blossom_pin_header(){ 
    $ed_header_search = get_theme_mod( 'ed_header_search', true ); 
    $ed_cart          = get_theme_mod( 'ed_shopping_cart', true ); 
    $header_layout    = get_theme_mod( 'header_layout_option', 'two' ); ?>

    <header class="site-header header-layout-<?php echo esc_attr( $header_layout ); ?>" itemscope itemtype="http://schema.org/WPHeader">
        <?php
        if ( $header_layout == 'two' ) echo '<div class="header-t"><div class="container">';
            blossom_pin_site_branding(false); 
        if ( $header_layout == 'two' ) echo '</div></div>';
        if ( $header_layout == 'two' ) echo '<div class="header-b"><div class="container clearfix">';
        ?>
        <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'blossom_pin_primary_menu_fallback',
                ) );
            ?>
        </nav><!-- #site-navigation -->                     
        
        <div class="tools">
            <?php 
            if( blossom_pin_social_links( false, false ) ){
                blossom_pin_social_links( true, false );
                echo '<span class="separator"></span>';
            }
            
            if( $ed_header_search ) : ?>
                <div class=header-search>
                    <button aria-label="<?php esc_attr_e( 'search form toggle', 'travel-diary' ); ?>" class="search-icon search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                        <svg class="open-icon" xmlns="http://www.w3.org/2000/svg" viewBox="-18214 -12091 18 18"><path id="Path_99" data-name="Path 99" d="M18,16.415l-3.736-3.736a7.751,7.751,0,0,0,1.585-4.755A7.876,7.876,0,0,0,7.925,0,7.876,7.876,0,0,0,0,7.925a7.876,7.876,0,0,0,7.925,7.925,7.751,7.751,0,0,0,4.755-1.585L16.415,18ZM2.264,7.925a5.605,5.605,0,0,1,5.66-5.66,5.605,5.605,0,0,1,5.66,5.66,5.605,5.605,0,0,1-5.66,5.66A5.605,5.605,0,0,1,2.264,7.925Z" transform="translate(-18214 -12091)"/></svg>
                    </button>
                    <div class="search-form-holder search-modal cover-modal" data-modal-target-string=".search-modal">
                        <div class="header-search-inner-wrap">
                            <?php get_search_form();?> 
                            <button aria-label="<?php esc_attr_e( 'search form toggle', 'travel-diary' ); ?>" class="search-icon close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="10906 13031 18 18"><path id="Close" d="M23,6.813,21.187,5,14,12.187,6.813,5,5,6.813,12.187,14,5,21.187,6.813,23,14,15.813,21.187,23,23,21.187,15.813,14Z" transform="translate(10901 13026)"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="overlay"></div>
                </div>
            <?php endif;
          if( blossom_pin_is_woocommerce_activated() && $ed_cart ) blossom_pin_wc_cart_count(); 
             ?>
        </div>
        <?php if ( $header_layout == 'two' ) echo '</div></div>'; ?>
    </header>
    <?php 
}

function blossom_pin_primary_nagivation(){ ?>
    <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => 'blossom_pin_primary_menu_fallback',
                ) );
            ?>
        </nav><!-- #site-navigation -->         
<?php
}

/**
 * Banner Section 
*/
function blossom_pin_banner(){
    $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
    $slider_cat     = get_theme_mod( 'slider_cat' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 7 );
    $banner_title      = get_theme_mod( 'banner_title', __( 'Wondering how your peers are using social media?', 'travel-diary' ) );
    $banner_subtitle   = get_theme_mod( 'banner_subtitle', __( 'Discover how people in the community create pins to get their attention.', 'travel-diary' ) );
    $banner_label      = get_theme_mod( 'banner_label', __( 'Discover More', 'travel-diary' ) );
    $banner_link       = get_theme_mod( 'banner_link', '#' );
    $slider_layout     = get_theme_mod( 'slider_layout', 'eight' );   
    $add_class         = ( $slider_layout == 'one' ) ? 'banner-slider ' : ''; 

    if( $slider_layout == 'one' ){
        $image_size = 'blossom-pin-slider';
    }elseif( $slider_layout == 'eight' ){
        $image_size = 'travel-diary-slider-two';
    }
    
    if( is_front_page() || is_home() ){ 
        
        if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
            <div class="banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?>">
                <?php the_custom_header_markup();
                if( $ed_banner == 'static_banner' && ( $banner_title || $banner_subtitle || ( $banner_label && $banner_link ) ) ){
                    echo '<div class="banner-caption"><div class="wrapper"><div class="banner-wrap">';
                    if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '</h2>';
                    if( $banner_subtitle ) echo '<div class="banner-content b-content">' . wpautop( wp_kses_post( $banner_subtitle ) ) . '</div>';
                    if( $banner_label && $banner_link ) echo '<a href="' . esc_url( $banner_link ) . '" class="banner-link">' . esc_html( $banner_label ) . '</a>';
                    echo '</div></div></div>';
                } ?>
            </div>
            <?php
        }elseif( $ed_banner == 'slider_banner' ){
            $args = array(
                'post_type'           => 'post',
                'post_status'         => 'publish',            
                'ignore_sticky_posts' => true
            );
            
            if( $slider_type === 'cat' && $slider_cat ){
                $args['cat']            = $slider_cat; 
                $args['posts_per_page'] = -1;  
            }else{
                $args['posts_per_page'] = $posts_per_page;
            }
                
            $qry = new WP_Query( $args );
            
            if( $qry->have_posts() ){ ?>
            <div class="banner">
        		<div class="<?php echo esc_attr( $add_class ); ?>banner-layout-<?php echo esc_attr( $slider_layout ); ?> owl-carousel">
                    <?php if( ($slider_layout === 'eight') && !wp_is_mobile() ) {
                        travel_diary_banner_slider_layout_two( $qry, $image_size);
                    } else { ?>
                        <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                        <div class="item">
                            <?php 
                            if( has_post_thumbnail() ){
                                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                            }
                            ?>                        
                            <div class="text-holder">
                                <?php
                                    blossom_pin_category();
                                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                ?>
                            </div>
        			   </div>
        			<?php } } ?>
        		</div>
        	</div>
            <?php
            }
            wp_reset_postdata();
        } 
    }    
}

function travel_diary_banner_slider_layout_two( $qry, $image_size ) { 

    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 7 );
    $count = ( $slider_type == 'latest_posts' ) ? $posts_per_page : $qry->found_posts;
    $count = $count - ( $count % 3 );
    $index = 1;
    ?>
    <div class="item">
        <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
        <div class="holder">
            <?php 
            if( has_post_thumbnail() ){
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
            }
            
             ?>                        
            <div class="text-holder">
                <?php
                    blossom_pin_category();
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                ?>
            </div>
        </div>
        <?php 
        $count--; 
        
        if( $index % 3 == 0 && $count > 0 ){
            echo '</div><div class="item">';
        }elseif( $count == 0 ){
            break;
        }
        $index++; 
        } ?>
    </div>
<?php }

/** Typography */
function blossom_pin_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Inter' );
    $ig_primary_font    = blossom_pin_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'Cormorant Garamond' );
    $ig_secondary_font  = blossom_pin_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'Cormorant Garamond', 'variant'=>'regular' ) );
    $ig_site_title_font = blossom_pin_is_google_font( $site_title_font['font-family'] );
        
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'travel-diary' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'travel-diary' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'travel-diary' );
    
    
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = blossom_pin_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = blossom_pin_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . blossom_pin_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    if( get_theme_mod( 'ed_localgoogle_fonts', false ) ) {
        $fonts_url = blossom_pin_get_webfont_url( add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
    }
     
    return esc_url_raw( $fonts_url );
}

/** Dynamic Css */
function blossom_pin_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Inter' );
    $primary_fonts   = blossom_pin_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Cormorant Garamond' );
    $secondary_fonts = blossom_pin_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 18 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Cormorant Garamond', 'variant'=>'regular' ) );
    $site_title_fonts     = blossom_pin_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    
    $primary_color = get_theme_mod( 'primary_color', '#f48585' );
    
    $rgb = blossom_pin_hex2rgb( blossom_pin_sanitize_hex_color( $primary_color ) );
     
    $custom_css = '';
    $custom_css .= '
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : ' . wp_kses_post( $primary_fonts['font'] ) . ';
        font-size   : ' . absint( $font_size ) . 'px;        
    }
    
    .site-header .site-branding .site-title,
    .single-header .site-branding .site-title,
    .mobile-header .mobile-site-header .site-branding .site-title{
        font-family : ' . wp_kses_post( $site_title_fonts['font'] ) . ';
        font-weight : ' . esc_html( $site_title_fonts['weight'] ) . ';
        font-style  : ' . esc_html( $site_title_fonts['style'] ) . ';
    }

    .blog #primary .format-quote .post-thumbnail blockquote cite, 
    .newsletter-section .blossomthemes-email-newsletter-wrapper .text-holder h3,
    .newsletter-section .blossomthemes-email-newsletter-wrapper.bg-img .text-holder h3, 
    #primary .post .entry-content blockquote cite,
    #primary .page .entry-content blockquote cite{
        font-family : ' . wp_kses_post( $primary_fonts['font'] ) . ';
    }

    .banner-slider .item .text-holder .entry-title, 
    .banner .banner-caption .banner-title, 
    .banner-layout-two .text-holder .entry-title,
    .blog #primary .post .entry-header .entry-title, 
    .blog #primary .format-quote .post-thumbnail .blockquote-holder, 
    .search #primary .search-post .entry-header .entry-title,
    .archive #primary .post .entry-header .entry-title, 
    .single .post-entry-header .entry-title, 
    #primary .post .entry-content blockquote,
    #primary .page .entry-content blockquote, 
    #primary .post .entry-content .pull-left,
    #primary .page .entry-content .pull-left, 
    #primary .post .entry-content .pull-right,
    #primary .page .entry-content .pull-right, 
    .single-header .title-holder .post-title, 
    .recommended-post .post .entry-header .entry-title, 
    .widget_bttk_popular_post ul li .entry-header .entry-title,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-title, 
    .blossomthemes-email-newsletter-wrapper.bg-img .text-holder h3, 
    .widget_recent_entries ul li a, 
    .widget_recent_comments ul li a, 
    .widget_bttk_posts_category_slider_widget .carousel-title .title, 
    .single .navigation .post-title, 
    .single-blossom-portfolio .post-navigation .nav-previous,
    .single-blossom-portfolio .post-navigation .nav-next, 
    .site-main .blossom-portfolio .entry-title {
        font-family : ' . wp_kses_post( $secondary_fonts['font'] ) . ';
    }
    
    /*Color Scheme*/
    a, 
    .main-navigation ul li a:hover,
    .main-navigation ul .current-menu-item > a,
    .main-navigation ul li:hover > a, 
    .site-header .site-branding .site-title a:hover, 
    .site-header .social-networks ul li a:hover, 
    .banner-slider .item .text-holder .entry-title a:hover, 
    .blog #primary .post .entry-header .entry-title a:hover, 
    .blog #primary .post .entry-footer .read-more:hover, 
    .blog #primary .post .entry-footer .edit-link a:hover, 
    .blog #primary .post .bottom .posted-on a:hover, 
    .newsletter-section .social-networks ul li a:hover, 
    .instagram-section .profile-link:hover, 
    .search #primary .search-post .entry-header .entry-title a:hover,
     .archive #primary .post .entry-header .entry-title a:hover, 
     .search #primary .search-post .entry-footer .posted-on a:hover,
     .archive #primary .post .entry-footer .posted-on a:hover, 
     .single #primary .post .holder .meta-info .entry-meta a:hover, 
    .single-header .site-branding .site-title a:hover, 
    .single-header .social-networks ul li a:hover, 
    .comments-area .comment-body .text-holder .top .comment-metadata a:hover, 
    .comments-area .comment-body .text-holder .reply a:hover, 
    .recommended-post .post .entry-header .entry-title a:hover, 
    .error-wrapper .error-holder h3, 
    .widget_bttk_popular_post ul li .entry-header .entry-title a:hover,
     .widget_bttk_pro_recent_post ul li .entry-header .entry-title a:hover, 
     .widget_bttk_popular_post ul li .entry-header .entry-meta a:hover,
     .widget_bttk_pro_recent_post ul li .entry-header .entry-meta a:hover,
     .widget_bttk_popular_post .style-two li .entry-header .cat-links a:hover,
     .widget_bttk_pro_recent_post .style-two li .entry-header .cat-links a:hover,
     .widget_bttk_popular_post .style-three li .entry-header .cat-links a:hover,
     .widget_bttk_pro_recent_post .style-three li .entry-header .cat-links a:hover, 
     .widget_recent_entries ul li:before, 
     .widget_recent_entries ul li a:hover, 
    .widget_recent_comments ul li:before, 
    .widget_bttk_posts_category_slider_widget .carousel-title .cat-links a:hover, 
    .widget_bttk_posts_category_slider_widget .carousel-title .title a:hover, 
    .site-footer .footer-b .footer-nav ul li a:hover, 
    .single .navigation a:hover .post-title, 
    .page-template-blossom-portfolio .portfolio-holder .portfolio-sorting .is-checked, 
    .portfolio-item a:hover, 
    .single-blossom-portfolio .post-navigation .nav-previous a:hover,
     .single-blossom-portfolio .post-navigation .nav-next a:hover, 
     .mobile-header .mobile-site-header .site-branding .site-title a:hover, 
    .mobile-menu .main-navigation ul li:hover svg, 
    .mobile-menu .main-navigation ul ul li a:hover,
    .mobile-menu .main-navigation ul ul li:hover > a, 
    .mobile-menu .social-networks ul li a:hover, 
    .site-main .blossom-portfolio .entry-title a:hover, 
    .site-main .blossom-portfolio .entry-footer .posted-on a:hover, 
    .widget_bttk_social_links ul li a:hover, 
    #crumbs a:hover, #crumbs .current a,
    .entry-content a:hover,
    .entry-summary a:hover,
    .page-content a:hover,
    .comment-content a:hover,
    .widget .textwidget a:hover {
        color: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ';
    }

    .comments-area .comment-body .text-holder .reply a:hover svg {
        fill: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ';
     }

    button:hover,
    input[type="button"]:hover,
    input[type="reset"]:hover,
    input[type="submit"]:hover, 
    .banner-slider .item, 
    .banner-slider .item .text-holder .category a, 
    .banner .banner-caption .banner-link:hover, 
    .blog #primary .post .entry-header .category a, 
    .newsletter-section, 
    .search #primary .search-post .entry-header .category a,
    .archive #primary .post .entry-header .category a, 
    .single .post-entry-header .category a, 
    .single #primary .post .holder .meta-info .entry-meta .byline:after, 
    .single #primary .post .entry-footer .tags a, 
    .single-header .progress-bar, 
    .recommended-post .post .entry-header .category a, 
    .error-wrapper .error-holder .btn-home a:hover, 
    .widget .widget-title:after, 
    .widget_bttk_author_bio .readmore:hover, 
    .widget_bttk_custom_categories ul li a:hover .post-count, 
    .widget_blossomtheme_companion_cta_widget .text-holder .button-wrap .btn-cta, 
    .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:hover, 
    .widget_bttk_icon_text_widget .text-holder .btn-readmore:hover, 
    .widget_bttk_image_text_widget ul li .btn-readmore:hover, 
    .back-to-top, 
    .single .post-entry-header .share .social-networks li a:hover {
        background: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ';
    }

    button:hover,
    input[type="button"]:hover,
    input[type="reset"]:hover,
    input[type="submit"]:hover, 
    .error-wrapper .error-holder .btn-home a:hover {
        border-color: ' .  blossom_pin_sanitize_hex_color( $primary_color ) . ';
    }

    .blog #primary .post .entry-footer .read-more:hover, 
    .blog #primary .post .entry-footer .edit-link a:hover {
        border-bottom-color: ' .  blossom_pin_sanitize_hex_color( $primary_color ) . ';
    }

    @media screen and (max-width: 1024px) {
        .main-navigation ul ul li a:hover, 
        .main-navigation ul ul li:hover > a, 
        .main-navigation ul ul .current-menu-item > a, 
        .main-navigation ul ul .current-menu-ancestor > a, 
        .main-navigation ul ul .current_page_item > a, 
        .main-navigation ul ul .current_page_ancestor > a {
            color: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ' !important;
        }
    }';


    if( blossom_pin_is_woocommerce_activated() ) { 
        $custom_css .='
        .woocommerce ul.products li.product .added_to_cart:hover,
        .woocommerce ul.products li.product .added_to_cart:focus, 
        .woocommerce ul.products li.product .add_to_cart_button:hover,
        .woocommerce ul.products li.product .add_to_cart_button:focus,
        .woocommerce ul.products li.product .product_type_external:hover,
        .woocommerce ul.products li.product .product_type_external:focus,
        .woocommerce ul.products li.product .ajax_add_to_cart:hover,
        .woocommerce ul.products li.product .ajax_add_to_cart:focus, 
        .woocommerce div.product .entry-summary .variations_form .single_variation_wrap .button:hover,
        .woocommerce div.product .entry-summary .variations_form .single_variation_wrap .button:focus, 
        .woocommerce div.product form.cart .single_add_to_cart_button:hover,
        .woocommerce div.product form.cart .single_add_to_cart_button:focus,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:hover,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:focus, 
        .woocommerce .woocommerce-message .button:hover,
        .woocommerce .woocommerce-message .button:focus, 
        .woocommerce-cart #primary .page .entry-content table.shop_table td.actions .coupon input[type="submit"]:hover,
        .woocommerce-cart #primary .page .entry-content table.shop_table td.actions .coupon input[type="submit"]:focus, 
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:hover,
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:focus, 
        .woocommerce-checkout .woocommerce form.woocommerce-form-login input.button:hover,
        .woocommerce-checkout .woocommerce form.woocommerce-form-login input.button:focus,
        .woocommerce-checkout .woocommerce form.checkout_coupon input.button:hover,
        .woocommerce-checkout .woocommerce form.checkout_coupon input.button:focus,
        .woocommerce form.lost_reset_password input.button:hover,
        .woocommerce form.lost_reset_password input.button:focus,
        .woocommerce .return-to-shop .button:hover,
        .woocommerce .return-to-shop .button:focus,
        .woocommerce #payment #place_order:hover,
        .woocommerce-page #payment #place_order:focus, 
        .woocommerce #secondary .widget_shopping_cart .buttons .button:hover,
        .woocommerce #secondary .widget_shopping_cart .buttons .button:focus, 
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:hover,
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:focus {
            background: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ';
        }

        .woocommerce #secondary .widget .product_list_widget li .product-title:hover,
        .woocommerce #secondary .widget .product_list_widget li .product-title:focus,
        .woocommerce div.product .entry-summary .product_meta .posted_in a:hover,
        .woocommerce div.product .entry-summary .product_meta .posted_in a:focus,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:hover,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:focus, 
        .woocommerce-cart #primary .page .entry-content table.shop_table td.product-name a:hover, .woocommerce-cart #primary .page .entry-content table.shop_table td.product-name a:focus{
            color: ' . blossom_pin_sanitize_hex_color( $primary_color ) . ';
        }

        .woocommerce div.product .product_title, 
        .woocommerce div.product .woocommerce-tabs .panel h2 {
            font-family : ' . wp_kses_post( $secondary_fonts['font'] ) . ';
        }';
    }
           
    wp_add_inline_style( 'blossom-pin', $custom_css );
}

function blossom_pin_footer_bottom(){ ?>
    <div class="footer-b">
        <div class="container">
            <div class="site-info">            
            <?php
                blossom_pin_get_footer_copyright();
                esc_html_e( ' Travel Diary | Developed By ', 'travel-diary' );
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">'. esc_html__( 'Blossom Themes', 'travel-diary' ) . '</a>.';
                
                printf( esc_html__( ' Powered by %s', 'travel-diary' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'travel-diary' ) ) .'" target="_blank">WordPress</a>. ' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
            <?php blossom_pin_secondary_navigation(); ?>
        </div>
    </div>
    <?php
}