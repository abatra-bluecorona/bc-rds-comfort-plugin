<?php
function bc_gallery_register_gallery_type() {
    $labels = array( 
        'name' => __( 'Album', BCGALLERYDOMAIN ),
        'singular_name' => __( 'Album', BCGALLERYDOMAIN ),
        'archives' => __( 'Album', BCGALLERYDOMAIN ),
        'add_new' => __( 'Add New Album', BCGALLERYDOMAIN ),
        'add_new_item' => __( 'Add New Album', BCGALLERYDOMAIN ),
    );
    $args = array( 
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(  'with_front' => false, 'slug' => 'gallery'),
        'taxonomies' => array( 'bc_gallery_category' ),
        'menu_icon' => 'dashicons-images-alt2',
        // 'supports' => false,
        'supports'  => array( 'editor', 'thumbnail','title'),
        'show_in_rest' => true,
        "query_var" => true,
        'publicly_queryable' => true,
    );
    register_post_type( 'bc_galleries', $args );
}