<?php

require get_stylesheet_directory() . '/customizer/customizer.php';

add_action( 'after_setup_theme', 'laboratory_pharmacy_store_after_setup_theme' );
function laboratory_pharmacy_store_after_setup_theme() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( "responsive-embeds" );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'laboratory-pharmacy-store-featured-image', 2000, 1200, true );
    add_image_size( 'laboratory-pharmacy-store-thumbnail-avatar', 100, 100, true );

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
    ) );

    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff'
    ) );

    add_theme_support( 'html5', array('comment-form','comment-list','gallery','caption',) );

    add_editor_style( array( 'assets/css/editor-style.css') );
}

/**
 * Register widget area.
 */
function laboratory_pharmacy_store_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'laboratory-pharmacy-store' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Page Sidebar', 'laboratory-pharmacy-store' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your sidebar on pages.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Sidebar 3', 'laboratory-pharmacy-store' ),
        'id'            => 'sidebar-3',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'laboratory-pharmacy-store' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here to appear in your footer.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'laboratory-pharmacy-store' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'laboratory-pharmacy-store' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 4', 'laboratory-pharmacy-store' ),
        'id'            => 'footer-4',
        'description'   => __( 'Add widgets here to appear in your footer.', 'laboratory-pharmacy-store' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'laboratory_pharmacy_store_widgets_init' );

// enqueue styles for child theme
function laboratory_pharmacy_store_enqueue_styles() {

    // Bootstrap
    wp_enqueue_style( 'bootstrap-css', get_theme_file_uri( '/assets/css/bootstrap.css' ) );

    // Theme block stylesheet.
    wp_enqueue_style( 'laboratory-pharmacy-store-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'laboratory-pharmacy-store-child-style' ), '1.0' );

    // enqueue parent styles
    wp_enqueue_style('online-pharmacy-style', get_template_directory_uri() .'/style.css');

    // enqueue child styles
    wp_enqueue_style('online-pharmacy-child-style', get_stylesheet_directory_uri() .'/style.css', array('online-pharmacy-style'));

    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
}
add_action('wp_enqueue_scripts', 'laboratory_pharmacy_store_enqueue_styles');

function laboratory_pharmacy_store_admin_scripts() {
    // Backend CSS
    wp_enqueue_style( 'laboratory-pharmacy-store-backend-css', get_theme_file_uri( '/assets/css/customizer.css' ) );
}
add_action( 'admin_enqueue_scripts', 'laboratory_pharmacy_store_admin_scripts' );

function laboratory_pharmacy_store_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

if ( ! defined( 'ONLINE_PHARMACY_PRO_THEME_NAME' ) ) {
    define( 'ONLINE_PHARMACY_PRO_THEME_NAME', esc_html__( 'Laboratory Pharmacy Pro', 'laboratory-pharmacy-store' ));
}
if ( ! defined( 'ONLINE_PHARMACY_PRO_THEME_URL' ) ) {
    define( 'ONLINE_PHARMACY_PRO_THEME_URL', 'https://www.themespride.com/themes/pharmacy-store-wordpress-theme/' );
}
if ( ! defined( 'ONLINE_PHARMACY_FREE_THEME_URL' ) ) {
	define( 'ONLINE_PHARMACY_FREE_THEME_URL', 'https://www.themespride.com/themes/free-laboratory-wordpress-theme/' );
}
if ( ! defined( 'ONLINE_PHARMACY_DEMO_THEME_URL' ) ) {
	define( 'ONLINE_PHARMACY_DEMO_THEME_URL', 'https://www.themespride.com/laboratory-pharmacy-store-pro/' );
}
if ( ! defined( 'ONLINE_PHARMACY_DOCS_THEME_URL' ) ) {
    define( 'ONLINE_PHARMACY_DOCS_THEME_URL', 'https://www.themespride.com/demo/docs/laboratory-pharmacy-store-lite/' );
}
if ( ! defined( 'ONLINE_PHARMACY_DOCS_URL' ) ) {
	define( 'ONLINE_PHARMACY_DOCS_URL', esc_url('https://www.themespride.com/demo/docs/laboratory-pharmacy-store-lite/'));
}
if ( ! defined( 'ONLINE_PHARMACY_RATE_THEME_URL' ) ) {
    define( 'ONLINE_PHARMACY_RATE_THEME_URL', 'https://wordpress.org/support/theme/laboratory-pharmacy-store/reviews/#new-post' );
}
if ( ! defined( 'ONLINE_PHARMACY_CHANGELOG_THEME_URL' ) ) {
    define( 'ONLINE_PHARMACY_CHANGELOG_THEME_URL', get_stylesheet_directory() . '/readme.txt' );
}
if ( ! defined( 'ONLINE_PHARMACY_SUPPORT_THEME_URL' ) ) {
    define( 'ONLINE_PHARMACY_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/laboratory-pharmacy-store' );
}

define('LABORATORY_PHARMACY_STORE_CREDIT',__('https://www.themespride.com/themes/free-laboratory-wordpress-theme/','laboratory-pharmacy-store') );
if ( ! function_exists( 'laboratory_pharmacy_store_credit' ) ) {
    function laboratory_pharmacy_store_credit(){
        echo "<a href=".esc_url(LABORATORY_PHARMACY_STORE_CREDIT)." target='_blank'>".esc_html__('Laboratory WordPress Theme','laboratory-pharmacy-store')."</a>";
    }
}
