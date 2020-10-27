<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:04 PM
 */
function lens_customize_register_fonts( $wp_customize )
{
    $wp_customize->add_section(
        'lens_typo_options',
        array(
            'title'     => __('Google Web Fonts','lens'),
            'priority'  => 41,
            'description' => __('Defaults: Roboto Slab, Open Sans.','lens'),
            'panel'     => 'lens_design_panel'

        )
    );

    $font_array = array('Roboto Slab','Open Sans','Bitter','Raleway','Khula','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','Ubuntu','Lobster','Arimo','Bitter','Noto Sans');
    $fonts = array_combine($font_array, $font_array);

    $wp_customize->add_setting(
        'lens_title_font',
        array(
            'default'=> 'Roboto Slab',
            'sanitize_callback' => 'lens_sanitize_gfont'
        )
    );

    function lens_sanitize_gfont( $input ) {
        if ( in_array($input, array('Roboto Slab','Open Sans','Bitter','Raleway','Khula','Droid Sans','Droid Serif','Roboto','Roboto Condensed','Lato','Bree Serif','Oswald','Slabo','Lora','Source Sans Pro','PT Sans','Ubuntu','Lobster','Arimo','Bitter','Noto Sans') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'lens_title_font',array(
            'label' => __('Title','lens'),
            'settings' => 'lens_title_font',
            'section'  => 'lens_typo_options',
            'type' => 'select',
            'choices' => $fonts,
        )
    );

    $wp_customize->add_setting(
        'lens_body_font',
        array(	'default'=> 'Open Sans',
            'sanitize_callback' => 'lens_sanitize_gfont' )
    );

    $wp_customize->add_control(
        'lens_body_font',array(
            'label' => __('Body','lens'),
            'settings' => 'lens_body_font',
            'section'  => 'lens_typo_options',
            'type' => 'select',
            'choices' => $fonts
        )
    );
}
add_action( 'customize_register', 'lens_customize_register_fonts' );