<?php 
function bc_promotion_register_promotion_taxonomy() {
    $labels = array(
        'name' => __( 'Promotion Category', BCDOMAIN ),
        'singular_name' => __( 'Promotion', BCDOMAIN ),
        'add_new_item' => __( 'Add New Promotion Category', BCDOMAIN ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array( 'hierarchical' => true, 'has_front' => true )
    );

    $post_types = array( 'bc_promotions');

    register_taxonomy( 'bc_promotion_category', $post_types, $args );
}

