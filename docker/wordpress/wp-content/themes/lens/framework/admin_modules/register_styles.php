<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 2:58 PM
 */
/**
 * Enqueue scripts and styles.
 */
function lens_scripts() {
    wp_enqueue_style( 'lens-style', get_stylesheet_uri() );

    wp_enqueue_style('lens-title-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('lens_title_font', 'Bitter') ) );

    wp_enqueue_style('lens-body-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('lens_body_font', 'Roboto Slab') ) );

    wp_enqueue_style( 'lens-fontawesome-style', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

    wp_enqueue_style( 'lens-nivo-style', get_template_directory_uri() . '/assets/css/nivo-slider.css' );

    wp_enqueue_style( 'lens-nivo-skin-style', get_template_directory_uri() . '/assets/css/nivo-default/default.css' );

    wp_enqueue_style( 'lens-bootstrap-style', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );

    wp_enqueue_style( 'lens-hover-style', get_template_directory_uri() . '/assets/css/hover.min.css' );

    wp_enqueue_style( 'lens-main-theme-style', get_template_directory_uri() . '/assets/theme-styles/css/'.get_theme_mod('lens_skin', 'default').'.css', array(), filemtime( get_template_directory() . '/assets/theme-styles/css/'.get_theme_mod('lens_skin', 'default').'.css' ) );

    wp_enqueue_script( 'bigslide-js', get_template_directory_uri() . '/js/bigSlide.min.js');

    wp_enqueue_script( 'lens-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

    wp_enqueue_script( 'lens-externaljs', get_template_directory_uri() . '/js/external.js', array('jquery') );

    wp_enqueue_script( 'lens-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script( 'lens-custom-js', get_template_directory_uri() . '/js/custom.js', array(), 1, true );
}
add_action( 'wp_enqueue_scripts', 'lens_scripts' );