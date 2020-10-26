<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:34 PM
 */
function lens_customize_register_skins( $wp_customize )
{
$wp_customize->add_setting('lens_site_titlecolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'lens_site_titlecolor', array(
        'label' => __('Site Title Color','lens'),
        'section' => 'colors',
        'settings' => 'lens_site_titlecolor',
        'type' => 'color'
    ) )
);

$wp_customize->add_setting('lens_header_desccolor', array(
    'default'     => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'lens_header_desccolor', array(
        'label' => __('Site Tagline Color','lens'),
        'section' => 'colors',
        'settings' => 'lens_header_desccolor',
        'type' => 'color'
    ) )
);





    //Select the Default Theme Skin
    $wp_customize->add_section(
        'lens_skin_options',
        array(
            'title' => __('Theme Skins', 'lens'),
            'priority' => 39,
            'panel'   => 'lens_design_panel'
        )
    );

    $wp_customize->add_setting(
        'lens_skin',
        array(
            'default' => 'default',
            'sanitize_callback' => 'lens_sanitize_skin'
        )
    );

    $skins = array('default' => __('Default(Green)', 'lens'),
        'red' => __('Roman', 'lens'),
        'pink' => __('Sweet Pink', 'lens'),
        'caribbean-green' => __('Caribbean Green', 'lens'),

    );

    $wp_customize->add_control(
        'lens_skin', array(
            'settings' => 'lens_skin',
            'section' => 'lens_skin_options',
            'label' => __('Choose from the Skins Below', 'lens'),
            'type' => 'select',
            'choices' => $skins,
        )
    );

    function lens_sanitize_skin($input)
    {
        if (in_array($input, array('default', 'red', 'caribbean-green','pink')))
            return $input;
        else
            return '';
    }



}
add_action( 'customize_register', 'lens_customize_register_skins' );