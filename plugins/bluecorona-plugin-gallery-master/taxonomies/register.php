<?php 
function bc_gallery_register_gallery_taxonomy() {
    $labels = array(
        'name' => __( 'Topic', BCGALLERYDOMAIN ),
        'singular_name' => __( 'Topic', BCGALLERYDOMAIN ),
        'add_new_item' => __( 'Add New Topic', BCGALLERYDOMAIN ),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array( 'hierarchical' => true, 'has_front' => true )
    );
    $post_types = array( 'bc_galleries');
    register_taxonomy( 'bc_gallery_category', $post_types, $args );
}