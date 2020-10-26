<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:19 PM
 */
function lens_customize_register_slider( $wp_customize ) {
// SLIDER PANEL
    $wp_customize->add_panel( 'lens_slider_panel', array(
        'priority'       => 35,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => 'Main Slider',
    ) );

    $wp_customize->add_section(
        'lens_sec_slider_options',
        array(
            'title'     => 'Enable/Disable',
            'priority'  => 0,
            'panel'     => 'lens_slider_panel'
        )
    );


    $wp_customize->add_setting(
        'lens_main_slider_enable',
        array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'lens_main_slider_enable', array(
            'settings' => 'lens_main_slider_enable',
            'label'    => __( 'Enable Slider.', 'lens' ),
            'section'  => 'lens_sec_slider_options',
            'type'     => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'lens_main_slider_count',
        array(
            'default' => '0',
            'sanitize_callback' => 'lens_sanitize_positive_number'
        )
    );

    // Select How Many Slides the User wants, and Reload the Page.
    $wp_customize->add_control(
        'lens_main_slider_count', array(
            'settings' => 'lens_main_slider_count',
            'label'    => __( 'No. of Slides(Min:0, Max: 10)' ,'lens'),
            'section'  => 'lens_sec_slider_options',
            'type'     => 'number',
            'description' => __('Enter a Value, and Hit Save above to Configure Slides.','lens'),

        )
    );


    //Render Slides Sec
    for ( $i = 1 ; $i <= 10 ; $i++ ) :

        //Create the settings Once, and Loop through it.
        static $x = 0;
        $wp_customize->add_section(
            'lens_slide_sec'.$i,
            array(
                'title'     => 'Slide '.$i,
                'priority'  => $i,
                'panel'     => 'lens_slider_panel',
                'active_callback' => 'lens_show_slide_sec'

            )
        );

        $wp_customize->add_setting(
            'lens_slide_img'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'lens_slide_img'.$i,
                array(
                    'label' => '',
                    'section' => 'lens_slide_sec'.$i,
                    'settings' => 'lens_slide_img'.$i,
                )
            )
        );

        $wp_customize->add_setting(
            'lens_slide_title'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'lens_slide_title'.$i, array(
                'settings' => 'lens_slide_title'.$i,
                'label'    => __( 'Slide Title','lens' ),
                'section'  => 'lens_slide_sec'.$i,
                'type'     => 'text',
            )
        );

        $wp_customize->add_setting(
            'lens_slide_desc'.$i,
            array( 'sanitize_callback' => 'sanitize_text_field' )
        );

        $wp_customize->add_control(
            'lens_slide_desc'.$i, array(
                'settings' => 'lens_slide_desc'.$i,
                'label'    => __( 'Slide Description','lens' ),
                'section'  => 'lens_slide_sec'.$i,
                'type'     => 'text',
            )
        );


        $wp_customize->add_setting(
            'lens_slide_url'.$i,
            array( 'sanitize_callback' => 'esc_url_raw' )
        );

        $wp_customize->add_control(
            'lens_slide_url'.$i, array(
                'settings' => 'lens_slide_url'.$i,
                'label'    => __( 'Target URL','lens' ),
                'section'  => 'lens_slide_sec'.$i,
                'type'     => 'url',
            )
        );

    endfor;


    //active callback to see if the slide section is to be displayed or not
    function lens_show_slide_sec( $control ) {
        $option = $control->manager->get_setting('lens_main_slider_count');
        global $x;
        if ( $x < $option->value() ){
            $x++;
            return true;
        }
    }

}
add_action( 'customize_register', 'lens_customize_register_slider' );