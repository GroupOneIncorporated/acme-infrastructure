<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:21 PM
 */
function lens_customize_register_topbtn( $wp_customize ) {


//TOP BUTTONS
$wp_customize->add_section(
    'lens_btn_sec',
    array(
        'title'     => 'Top Buttons',
        'priority'  => 30,
        'description' => __('This is used to Display 2 Custom Buttons in Top Right Corner of the Site. In the Icon Field, Enter the <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a> Icon Name.', 'lens'),
        'panel'      => 'lens_header_panel'

    )
);

for ( $i = 1 ; $i < 3; $i++ ) {
    $wp_customize->add_setting(
        'lens_btn_title'.$i,
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'lens_btn_title'.$i, array(
            'settings' => 'lens_btn_title'.$i,
            'label'    => __( 'Button ','lens' ).$i,
            'section'  => 'lens_btn_sec',
            'type'     => 'text',
        )
    );

    $wp_customize->add_setting(
        'lens_btn_icon'.$i,
        array( 'sanitize_callback' => 'sanitize_text_field' )
    );

    $wp_customize->add_control(
        'lens_btn_icon'.$i, array(
            'settings' => 'lens_btn_icon'.$i,
            'label'    => __( 'Icon','lens' ),
            'section'  => 'lens_btn_sec',
            'type'     => 'text',
        )
    );


    $wp_customize->add_setting(
        'lens_btn_url'.$i,
        array( 'sanitize_callback' => 'esc_url_raw' )
    );

    $wp_customize->add_control(
        'lens_btn_url'.$i, array(
            'settings' => 'lens_btn_url'.$i,
            'label'    => __( 'Target URL','lens' ),
            'section'  => 'lens_btn_sec',
            'type'     => 'url',
        )
    );
}
}
add_action( 'customize_register', 'lens_customize_register_topbtn' );