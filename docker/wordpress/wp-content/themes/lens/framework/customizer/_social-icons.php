<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:13 PM
 */
function lens_customize_register_social( $wp_customize ) {
// Social Icons
$wp_customize->add_section('lens_social_section', array(
    'title' => __('Social Icons','lens'),
    'priority' => 44 ,
    'panel'      => 'lens_header_panel'
));

$social_networks = array( //Redefinied in Sanitization Function.
    'none' => __('-','lens'),
    'facebook' => __('Facebook','lens'),
    'twitter' => __('Twitter','lens'),
    'google-plus' => __('Google Plus','lens'),
    'instagram' => __('Instagram','lens'),
    'rss' => __('RSS Feeds','lens'),
    'vimeo-square' => __('Vimeo','lens'),
    'youtube' => __('Youtube','lens'),
    'pinterest' => __('Pinterest','lens'),
    'linkedin' => __('Linkedin','lens')
);

$social_count = count($social_networks);

for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

    $wp_customize->add_setting(
        'lens_social_'.$x, array(
        'sanitize_callback' => 'lens_sanitize_social',
        'default' => 'none'
    ));

    $wp_customize->add_control( 'lens_social_'.$x, array(
        'settings' => 'lens_social_'.$x,
        'label' => __('Icon ','lens').$x,
        'section' => 'lens_social_section',
        'type' => 'select',
        'choices' => $social_networks,
    ));

    $wp_customize->add_setting(
        'lens_social_url'.$x, array(
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control( 'lens_social_url'.$x, array(
        'settings' => 'lens_social_url'.$x,
        'description' => __('Icon ','lens').$x.__(' Url','lens'),
        'section' => 'lens_social_section',
        'type' => 'url',
        'choices' => $social_networks,
    ));

endfor;

function lens_sanitize_social( $input ) {
    $social_networks = array(
        'none' ,
        'facebook',
        'twitter',
        'google-plus',
        'instagram',
        'rss',
        'vimeo-square',
        'youtube',
        'pinterest',
        'linkedin'
    );
    if ( in_array($input, $social_networks) )
        return $input;
    else
        return '';
}
}
add_action( 'customize_register', 'lens_customize_register_social' );