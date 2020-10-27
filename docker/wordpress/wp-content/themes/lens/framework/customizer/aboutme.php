<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:14 PM
 */
function lens_customize_register_aboutme( $wp_customize )
{
//ABOUT ME
    $wp_customize->add_section(
        'lens_aboutme_sec',
        array(
            'title' => __('About Me Section', 'lens'),
            'priority' => 38,
        ));

    $wp_customize->add_setting(
        'lens_main_aboutme_enable',
        array('sanitize_callback' => 'lens_sanitize_checkbox')
    );

    $wp_customize->add_control(
        'lens_main_aboutme_enable', array(
            'settings' => 'lens_main_aboutme_enable',
            'label' => __('Enable About Me Section.', 'lens'),
            'section' => 'lens_aboutme_sec',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'lens_aboutme_title',
        array('sanitize_callback' => 'sanitize_text_field')
    );

    $wp_customize->add_control(
        'lens_aboutme_title', array(
            'settings' => 'lens_aboutme_title',
            'label' => __('Section Title', 'lens'),
            'description' => __('e.g "About Me" or "About Us"', 'lens'),
            'section' => 'lens_aboutme_sec',
            'type' => 'text',
            'active_callback' => 'lens_aboutme_enabled'
        )
    );

    $wp_customize->add_setting(
        'lens_aboutme_img',
        array('sanitize_callback' => 'esc_url_raw')
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'lens_aboutme_img',
            array(
                'label' => __('Your Avatar or Company Logo', 'lens'),
                'section' => 'lens_aboutme_sec',
                'settings' => 'lens_aboutme_img',
                'active_callback' => 'lens_aboutme_enabled'
            )
        )
    );

    $wp_customize->add_setting(
        'lens_aboutme_name',
        array('sanitize_callback' => 'sanitize_text_field')
    );

    $wp_customize->add_control(
        'lens_aboutme_name', array(
            'settings' => 'lens_aboutme_name',
            'label' => __('Author/Company Name', 'lens'),
            'section' => 'lens_aboutme_sec',
            'type' => 'text',
            'active_callback' => 'lens_aboutme_enabled'
        )
    );

    $wp_customize->add_setting(
        'lens_aboutme_desc',
        array('sanitize_callback' => 'sanitize_text_field')
    );

    $wp_customize->add_control(
        'lens_aboutme_desc', array(
            'settings' => 'lens_aboutme_desc',
            'label' => __(' Description', 'lens'),
            'section' => 'lens_aboutme_sec',
            'type' => 'textarea',
            'active_callback' => 'lens_aboutme_enabled'
        )
    );


    $wp_customize->add_setting(
        'lens_aboutme_bgimg',
        array('sanitize_callback' => 'esc_url_raw')
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'lens_aboutme_bgimg',
            array(
                'label' => __('Background Image', 'lens'),
                'description' => __('Use a Large Image', 'lens'),
                'section' => 'lens_aboutme_sec',
                'settings' => 'lens_aboutme_bgimg',
                'active_callback' => 'lens_aboutme_enabled'
            )
        )
    );

    function lens_aboutme_enabled($control)
    {
        $option = $control->manager->get_setting('lens_main_aboutme_enable');
        return $option->value() == true;
    }
}
add_action( 'customize_register', 'lens_customize_register_aboutme' );