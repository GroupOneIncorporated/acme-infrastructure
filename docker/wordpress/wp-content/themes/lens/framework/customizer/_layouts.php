<?php
/**
 * Created by PhpStorm.
 * User: Gourav
 * Date: 2/7/2018
 * Time: 3:07 PM
 */
function lens_customize_register_layouts( $wp_customize )
{
    // Layout and Design
    $wp_customize->add_panel( 'lens_design_panel', array(
        'priority'       => 3,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Design & Layout','lens'),
    ) );


    $wp_customize->add_section(
        'lens_design_options',
        array(
            'title'     => __('Blog Layout','lens'),
            'priority'  => 0,
            'panel'     => 'lens_design_panel'
        )
    );


    $wp_customize->add_setting(
        'lens_blog_layout',
        array( 'sanitize_callback' => 'lens_sanitize_blog_layout' )
    );

    function lens_sanitize_blog_layout( $input ) {
        if ( in_array($input, array('grid','lens','lens_3_col','photo_4_col') ) )
            return $input;
        else
            return '';
    }

    $wp_customize->add_control(
        'lens_blog_layout',array(
            'label' => __('Select Layout','lens'),
            'settings' => 'lens_blog_layout',
            'section'  => 'lens_design_options',
            'type' => 'select',
            'choices' => array(
                'lens' => __('Lens Layout','lens'),
                'lens_3_col' => __('Lens Layout (3 Column)','lens'),
                'grid' => __('Basic Blog Layout','lens'),
                'photo_4_col' => __('Photography (4 Column)','lens'),
            )
        )
    );

    $wp_customize->add_section(
        'lens_sidebar_options',
        array(
            'title'     => __('Sidebar Layout','lens'),
            'priority'  => 0,
            'panel'     => 'lens_design_panel'
        )
    );

    $wp_customize->add_setting(
        'lens_disable_sidebar',
        array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'lens_disable_sidebar', array(
            'settings' => 'lens_disable_sidebar',
            'label'    => __( 'Disable Sidebar Everywhere.','lens' ),
            'section'  => 'lens_sidebar_options',
            'type'     => 'checkbox',
            'default'  => false
        )
    );

    $wp_customize->add_setting(
        'lens_disable_sidebar_home',
        array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'lens_disable_sidebar_home', array(
            'settings' => 'lens_disable_sidebar_home',
            'label'    => __( 'Disable Sidebar on Blog & Archives.','lens' ),
            'section'  => 'lens_sidebar_options',
            'type'     => 'checkbox',
            'active_callback' => 'lens_show_sidebar_options',
            'default'  => false
        )
    );

    $wp_customize->add_setting(
        'lens_disable_sidebar_front',
        array( 'sanitize_callback' => 'lens_sanitize_checkbox' )
    );

    $wp_customize->add_control(
        'lens_disable_sidebar_front', array(
            'settings' => 'lens_disable_sidebar_front',
            'label'    => __( 'Disable Sidebar on Front Page.','lens' ),
            'section'  => 'lens_sidebar_options',
            'type'     => 'checkbox',
            'active_callback' => 'lens_show_sidebar_options',
            'default'  => false
        )
    );


    $wp_customize->add_setting(
        'lens_sidebar_width',
        array(
            'default' => 4,
            'sanitize_callback' => 'lens_sanitize_positive_number' )
    );

    $wp_customize->add_control(
        'lens_sidebar_width', array(
            'settings' => 'lens_sidebar_width',
            'label'    => __( 'Sidebar Width','lens' ),
            'description' => __('Min: 25%, Default: 33%, Max: 40%','lens'),
            'section'  => 'lens_sidebar_options',
            'type'     => 'range',
            'active_callback' => 'lens_show_sidebar_options',
            'input_attrs' => array(
                'min'   => 3,
                'max'   => 5,
                'step'  => 1,
                'class' => 'sidebar-width-range',
                'style' => 'color: #0a0',
            ),
        )
    );

    /* Active Callback Function */
    function lens_show_sidebar_options($control) {

        $option = $control->manager->get_setting('lens_disable_sidebar');
        return $option->value() == false ;

    }

    class Lens_Custom_CSS_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
            <?php
        }
    }

    $wp_customize-> add_section(
        'lens_custom_codes',
        array(
            'title'			=> __('Custom CSS','lens'),
            'description'	=> __('Enter your Custom CSS to Modify design.','lens'),
            'priority'		=> 11,
            'panel'			=> 'lens_design_panel'
        )
    );

    $wp_customize->add_setting(
        'lens_custom_css',
        array(
            'default'		=> '',
            'sanitize_callback'	=> 'lens_sanitize_text'
        )
    );

    $wp_customize->add_control(
        new Lens_Custom_CSS_Control(
            $wp_customize,
            'lens_custom_css',
            array(
                'section' => 'lens_custom_codes',
                'settings' => 'lens_custom_css'
            )
        )
    );

    function lens_sanitize_text( $input ) {
        return wp_kses_post( force_balance_tags( $input ) );
    }

    $wp_customize-> add_section(
        'lens_custom_footer',
        array(
            'title'			=> __('Custom Footer Text','lens'),
            'description'	=> __('Enter your Own Copyright Text.','lens'),
            'priority'		=> 11,
            'panel'			=> 'lens_design_panel'
        )
    );

    $wp_customize->add_setting(
        'lens_footer_text',
        array(
            'default'		=> '',
            'sanitize_callback'	=> 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'lens_footer_text',
        array(
            'section' => 'lens_custom_footer',
            'settings' => 'lens_footer_text',
            'type' => 'text'
        )
    );
    
}
add_action( 'customize_register', 'lens_customize_register_layouts' );