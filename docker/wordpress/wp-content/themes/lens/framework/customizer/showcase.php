<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:16 PM
 */
function lens_customize_register_showcase( $wp_customize ) {
//Showcase
$wp_customize->add_panel( 'lens_showcase_panel', array(
    'priority'       => 37,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Custom Showcase',
) );

$wp_customize->add_section(
    'lens_sec_showcase_options',
    array(
        'title'     => 'Enable/Disable',
        'priority'  => 0,
        'panel'     => 'lens_showcase_panel'
    )
);


$wp_customize->add_setting(
    'lens_main_showcase_enable',
    array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
);

$wp_customize->add_control(
    'lens_main_showcase_enable', array(
        'settings' => 'lens_main_showcase_enable',
        'label'    => __( 'Enable showcase.', 'lens' ),
        'section'  => 'lens_sec_showcase_options',
        'type'     => 'checkbox',
    )
);

$wp_customize->add_setting(
    'lens_main_showcase_title',
    array(
        'default' => __('My Featured Work','lens'),
        'sanitize_callback' => 'sanitize_text_field'
    )
);

$wp_customize->add_control(
    'lens_main_showcase_title',
    array(
        'settings' => 'lens_main_showcase_title',
        'label'    => __( 'Showcase Title.', 'lens' ),
        'section'  => 'lens_sec_showcase_options',
        'type'     => 'text',
        'active_callback' => 'lens_sc_enabled'
    )
);



for ( $i = 1 ; $i <= 3 ; $i++ ) :

    //Create the settings Once, and Loop through it.

    $wp_customize->add_section(
        'lens_showcase_sec'.$i,
        array(
            'title'     => 'Showcase '.$i,
            'priority'  => $i,
            'panel'     => 'lens_showcase_panel',
            'active_callback' => 'lens_sc_enabled',
        )
    );



    $wp_customize->add_setting(
        'lens_showcase_img'.$i,
        array( 'sanitize_callback' => 'esc_url_raw' )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'lens_showcase_img'.$i,
            array(
                'label' => '',
                'section' => 'lens_showcase_sec'.$i,
                'settings' => 'lens_showcase_img'.$i,
                'description' => __('For Better Performance (Image Size 542 x 340)', 'lens'),
            )
        )
    );

    $wp_customize->add_setting(
        'lens_showcase_title'.$i,
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'lens_showcase_title'.$i, array(
            'settings' => 'lens_showcase_title'.$i,
            'label'    => __( 'Showcase Title','lens' ),
            'section'  => 'lens_showcase_sec'.$i,
            'type'     => 'text',
        )
    );

    $wp_customize->add_setting(
        'lens_showcase_desc'.$i,
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'lens_showcase_desc'.$i, array(
            'settings' => 'lens_showcase_desc'.$i,
            'label'    => __( ' Description','lens' ),
            'section'  => 'lens_showcase_sec'.$i,
            'type'     => 'text',
        )
    );


    $wp_customize->add_setting(
        'lens_showcase_url'.$i,
        array( 'sanitize_callback' => 'esc_url_raw' )
    );

    $wp_customize->add_control(
        'lens_showcase_url'.$i, array(
            'settings' => 'lens_showcase_url'.$i,
            'label'    => __( 'Target URL','lens' ),
            'section'  => 'lens_showcase_sec'.$i,
            'type'     => 'url',
        )
    );

endfor;

function lens_sc_enabled( $control ) {
    $option = $control->manager->get_setting('lens_main_showcase_enable');
    return $option->value() == true ;
}
}
add_action( 'customize_register', 'lens_customize_register_showcase' );