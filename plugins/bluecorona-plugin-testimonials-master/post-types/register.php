<?php
function bc_testimonial_register_testimonial_type() {
    $labels = array( 
        'name' => __( 'Testimonials', BCTESTIMONIALDOMAIN ),
        'singular_name' => __( 'Testimonial', BCTESTIMONIALDOMAIN ),
        'archives' => __( 'Testimonials', BCTESTIMONIALDOMAIN ),
        'add_new' => __( 'Add New Testimonial', BCTESTIMONIALDOMAIN ),
        'add_new_item' => __( 'Add New Testimonial', BCTESTIMONIALDOMAIN ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'has_archive' => 'testimonial',
        'rewrite' => array( 'has_front' => true ),
        'menu_icon' => 'dashicons-format-quote',
        'supports' => false,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'publicly_queryable' => false,
        // 'taxonomies'  => array( 'bc_testimonial_category', ),
    );
    register_post_type( 'bc_testimonials', $args );

    register_taxonomy(
        'bc_testimonial_category',
        'bc_testimonials', 
        array(
            'label'             => 'Testimonials Category', 
            'show_admin_column' => true,
            'hierarchical'      => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'       => 'bc_testimonial_category', 
                'with_front' => false,
            ),
        )
    );

}
