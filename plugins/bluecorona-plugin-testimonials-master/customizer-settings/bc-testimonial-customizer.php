<?php 
function bc_customize_testimonial($wp_customize){
    // Panel
   $wp_customize->add_section('bc_testimonial_scheme', array(
        'title'    => __('Testimonial', 'bc'),
        'description' => '',
        'priority' => 120,
    ));

    $wp_customize->add_setting('bc_theme_options[testimonial][type]', array(
       
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
    ));
 
    $wp_customize->add_control('bc_theme_options[testimonial][type]', array(
        'label'      => __('Testimonial Type', 'bc'),
        'section'    => 'bc_testimonial_scheme',
        'settings'   => 'bc_theme_options[testimonial][type]',
        'default'        => 'type_a',
        'type'       => 'radio',
        'choices'    => array(
            'type_a' => 'Type A',
            'type_b' => 'Type B',
            'type_c' => 'Type C',
        ),
    ));
}
add_action('customize_register', 'bc_customize_testimonial');