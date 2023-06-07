<?php

function laboratory_pharmacy_store_remove_customize_register() {
    global $wp_customize;
    $wp_customize->remove_section( 'online_pharmacy_color_option' );
}
add_action( 'customize_register', 'laboratory_pharmacy_store_remove_customize_register', 11 );

function laboratory_pharmacy_store_customize_register( $wp_customize ) {

    // About Product
    $wp_customize->add_section('laboratory_pharmacy_store_about_section',array(
        'title' => __('About Product Settings','laboratory-pharmacy-store'),
        'priority'  => 7,
        'panel' => 'online_pharmacy_panel_id'
    ));

    $wp_customize->add_setting('laboratory_pharmacy_store_about_title',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('laboratory_pharmacy_store_about_title',array(
        'label' => __('Title','laboratory-pharmacy-store'),
        'section'=> 'laboratory_pharmacy_store_about_section',
        'type'=> 'text'
    ));

    $laboratory_pharmacy_store_args = array(
        'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories($laboratory_pharmacy_store_args);
    $cat_posts = array();
    $m = 0;
    $cat_posts[]='Select';
    foreach($categories as $category){
    if($m==0){
        $default = $category->slug;
            $m++;
        }
        $cat_posts[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('laboratory_pharmacy_store_best_product_category',array(
        'default'   => 'select',
        'sanitize_callback' => 'laboratory_pharmacy_store_sanitize_select',
    ));
    $wp_customize->add_control('laboratory_pharmacy_store_best_product_category',array(
        'type'    => 'select',
        'choices' => $cat_posts,
        'label' => __('Select category to display products ','laboratory-pharmacy-store'),
        'section' => 'laboratory_pharmacy_store_about_section',
    ));
}
add_action( 'customize_register', 'laboratory_pharmacy_store_customize_register' );
