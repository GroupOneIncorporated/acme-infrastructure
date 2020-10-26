<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:09 PM
 */

function lens_customize_register_header( $wp_customize ) {
//Logo Settings
    $wp_customize->add_panel('lens_header_panel', array(
        'priority' => 2,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('Header Settings', 'lens'),


    ));
$wp_customize->add_section( 'title_tagline' , array(
    'title'      => __( 'Title, Tagline & Logo', 'lens' ),
    'priority'   => 30,
    'panel'      => 'lens_header_panel'
) );

$wp_customize->add_setting( 'lens_logo' , array(
    'default'     => '',
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'lens_logo',
        array(
            'label' => 'Upload Logo',
            'section' => 'title_tagline',
            'settings' => 'lens_logo',
            'priority' => 5,
        )
    )
);

$wp_customize->add_setting( 'lens_logo_resize' , array(
    'default'     => 100,
    'sanitize_callback' => 'lens_sanitize_positive_number',
) );
$wp_customize->add_control(
    'lens_logo_resize',
    array(
        'label' => 'Resize & Adjust Logo',
        'section' => 'title_tagline',
        'settings' => 'lens_logo_resize',
        'priority' => 6,
        'type' => 'range',
        'active_callback' => 'lens_logo_enabled',
        'input_attrs' => array(
            'min'   => 30,
            'max'   => 200,
            'step'  => 5,
        ),
    )
);

function lens_logo_enabled($control) {
    $option = $control->manager->get_setting('lens_logo');
    return $option->value() == true;
}
    $wp_customize->add_setting( 'lens_himg_align' , array(
        'default'     => true,
        'sanitize_callback' => 'lens_sanitize_himg_align'
    ) );

    /* Sanitization Function */
    function lens_sanitize_himg_align( $input ) {
        if (in_array( $input, array('center','left','right') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'lens_himg_align', array(
        'label' => __('Header Image Alignment','lens'),
        'section' => 'header_image',
        'settings' => 'lens_himg_align',
        'type' => 'select',
        'choices' => array(
            'center' => __('Center','lens'),
            'left' => __('Left','lens'),
            'right' => __('Right','lens'),
        )

    ) );

    $wp_customize->add_setting( 'lens_himg_darkbg' , array(
        'default'     => true,
        'sanitize_callback' => 'lens_sanitize_checkbox'
    ) );

    $wp_customize->add_control(
        'lens_himg_darkbg', array(
        'label' => __('Add a Dark Filter to make the text Above the Image More Clear and Easy to Read.','lens'),
        'section' => 'header_image',
        'settings' => 'lens_himg_darkbg',
        'type' => 'checkbox'

    ) );


    //Settings For Logo Area

    $wp_customize->add_setting(
        'lens_hide_title_tagline',
        array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'lens_hide_title_tagline', array(
            'settings' => 'lens_hide_title_tagline',
            'label'    => __( 'Hide Title and Tagline.', 'lens' ),
            'section'  => 'title_tagline',
            'type'     => 'checkbox',
        )
    );

    function lens_title_visible( $control ) {
        $option = $control->manager->get_setting('lens_hide_title_tagline');
        return $option->value() == false ;
    }

}
add_action( 'customize_register', 'lens_customize_register_header' );