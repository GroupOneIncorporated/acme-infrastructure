<?php
/**
 * lens Theme Customizer
 *
 * @package lens
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lens_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_section( 'background_image' )->panel  = 'lens_header_panel';
    $wp_customize->get_section( 'header_image' )->panel  = 'lens_header_panel';


    //Replace Header Text Color with, separate colors for Title and Description
    //Override lens_site_titlecolor
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_setting('header_textcolor');


}
add_action( 'customize_register', 'lens_customize_register' );

//Load All Individual Settings Based on Sections/Panels.
require_once get_template_directory().'/framework/customizer/_googlefonts.php';
require_once get_template_directory().'/framework/customizer/_layouts.php';
require_once get_template_directory().'/framework/customizer/_sanitization.php';
require_once get_template_directory().'/framework/customizer/_header.php';
require_once get_template_directory().'/framework/customizer/showcase.php';
require_once get_template_directory().'/framework/customizer/aboutme.php';
require_once get_template_directory().'/framework/customizer/skins.php';
require_once get_template_directory().'/framework/customizer/slider.php';
require_once get_template_directory().'/framework/customizer/top-button.php';
require_once get_template_directory().'/framework/customizer/_social-icons.php';


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lens_customize_preview_js() {
    wp_enqueue_script( 'lens_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'lens_customize_preview_js' );
