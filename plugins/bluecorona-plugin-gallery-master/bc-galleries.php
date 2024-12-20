<?php
/**
 * Plugin Name:       BC Galleries
 * Plugin URI:        https://github.com/nikhil-twinspark/bc-galleries
 * Description:       A simple plugin for creating custom post types for displaying galleries.
 * Version:           1.0.0
 * Author:            Blue Corona
 * Author URI:        #
 * License:           AGPL-3.0
 * License URI:       https://www.gnu.org/licenses/agpl-3.0.html
 * Text Domain:       bc-galleries
 * Domain Path:       /languages
 */

 if ( ! defined( 'WPINC' ) ) {
     die;
 }

define( 'BC_GALLERY_VERSION', '1.0.0' );
define( 'BCGALLERYDOMAIN', 'bc-galleries' );
define( 'BCGALLERYPATH', plugin_dir_path( __FILE__ ) );

require_once( BCGALLERYPATH . '/post-types/register.php' );
add_action( 'init', 'bc_gallery_register_gallery_type' );

require_once( BCGALLERYPATH . '/taxonomies/register.php' );
add_action( 'init', 'bc_gallery_register_gallery_taxonomy' );

function testimonials_load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'testimonials_load_wp_media_files' );

require_once( BCGALLERYPATH . '/custom-fields/register.php' );

function bc_gallery_rewrite_flush() {
    bc_gallery_register_gallery_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'bc_gallery_rewrite_flush' );

// plugin uninstallation
register_uninstall_hook( BCGALLERYPATH, 'bc_gallery_uninstall' );
function bc_gallery_uninstall() {
    // Removes the directory not the data
}

// Add Conditionally css & js for specific pages
add_action('admin_enqueue_scripts', 'bc_gallery_include_css_js');
function bc_gallery_include_css_js($hook){
    $current_screen = get_current_screen();
    if ( $current_screen->post_type == 'bc_galleries') {
        // Include CSS Libs
        wp_register_style('bc-gallery-plugin-css', plugins_url('assests/css/bootstrap.min.css', __FILE__), array(), '1.0.0', 'all');
        wp_enqueue_style('bc-gallery-plugin-css');

        wp_enqueue_script('bc-gallery-image-upload-js', plugin_dir_url(__FILE__).'assests/js/bc-image-upload.js', array( 'jquery'));
    }
}

// add_action( 'wp_enqueue_scripts', 'bc_gallery_include_css_frontend' );
// function bc_gallery_include_css_frontend($hook){
//     wp_register_style('bc-gallery-greyscale', plugins_url('assests/css/bc-gallery-style.css', __FILE__), array(), '1.0.0', 'all');
//     wp_enqueue_style('bc-gallery-greyscale');
// }

add_shortcode( 'bc-gallery', 'bc_gallery_shortcode' );
function bc_gallery_shortcode( $atts , $content = null ) {
    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
});?>
    <div class="container-fluid px-0 mx-0 gallery-section mt-4 mt-lg-0">
   <div class="container container-md container-lg container-xl py-lg-5 pb-5">
      <div class="row">
         <div class="col-lg-12 mb-4">
            <h1><span class="border-b2">Project Gallery</span></h1>
         </div>
         <div class="col-lg-4 col-md-6 my-4">
            <div class="input-group">
              <div class="select w-100 position-relative">
               <select class="form-control border-0 rounded-0 bc_color_tertiary_bg" onchange="location = this.value;">
                  <option value="<?php echo get_home_url();?>/photo-gallery/">All Photos</option>
                <?php 
                $cat = $_GET['cat']? $_GET['cat'] : '';
                $terms = get_terms('bc_gallery_category' );
                foreach ( $terms as $term ) {?>
                    <option <?php if($cat == $term->slug){ echo "selected"; } ?> value="<?php echo get_home_url();?>/photo-gallery/?cat=<?php echo $term->slug; ?>"><?php echo $term->name ?></option>
                <?php }?>
               </select>
               </div>
            </div>
         </div>
      </div>
      <!-- Desktop Section -->
      <div class="row mt-4 mt-lg-0 d-none d-lg-flex">
         <?php 
            $args  = array( 'post_type' => 'bc_galleries', 'order'=> 'DESC','post_status'  => 'publish','posts_per_page'=>12,'paged' => get_query_var('paged') ? get_query_var('paged') : 1,  'meta_query' => array(
                            array(
                                'key' => 'album_isprojectgallery',
                                'value' => '1',
                                'compare' => '='
                            )
                        ));
            if (!empty($cat)){
                $args  = array('tax_query' => array(
                        array(
                            'taxonomy' => 'bc_gallery_category',
                            'field' => 'slug',
                            'terms' => $cat)));
            }
            ob_start();
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
            while( $query->have_posts() ) {
            $query->the_post();
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id()), 'large' );
            $is_project_gallery = get_post_meta( get_the_id(), 'album_isprojectgallery', true );
            if ($is_project_gallery==true) {
            ?>
         <div class="col-lg-4 col-md-6 mb-4">
            <a href="<?php echo get_permalink(get_the_id());?>" class="d-block">
               <div class="card rounded-0 border-0 bc_color_white_bg gallery">
                  <div class="box-shadow card-body p-0 position-relative" style="background: url('<?php echo $large_image_url[0]; ?>'); background-size: cover; background-position: center;">
                     <!-- <img src="" class="card-img img-fluid rounded-0" alt="pg_p01_thumb"> -->
                     <div class="card-img-overlay justify-content-center d-flex">
                        <i class="far fa-search bc_text_36 bc_color_white align-self-center"></i>
                     </div>
                  </div>
                  <div class="card-footer rounded-0 py-0 mt-lg-3 mt-4 border-0 bg-transparent">
                     <span class="bc_text_16 bc_line_height_23 bc_font_default bc_color_quaternary bc_text_light">Problem:</span>
                     <span class="bc_text_26 bc_line_height_30 bc_font_default bc_color_black bc_text_light d-block mb-2"><?php echo get_post_meta( get_the_id(), 'album_problem', true ); ?></span>
                     <span  class="bc_text_16 bc_line_height_23 bc_font_default bc_color_quaternary bc_text_light d-block">Location:
                     <span class="bc_text_20 bc_color_black"> <?php echo get_post_meta( get_the_id(), 'album_location', true ); ?></span>
                     <span  class="float-right">
                     <i class="fal fa-arrow-right bc_text_26 bc_line_height_40 alt_color_three"></i>
                     </span>
                     </span>
                  </div>
               </div>
            </a>
         </div>
        <?php 
            } }
        endif; ?>
      </div>
      <div class="row  d-none d-lg-flex">
         <div class="col-12 text-center gallery-pagination">
            <?php 
               $big = 999999999; // need an unlikely integer
               echo paginate_links( array(
               'prev_text' => '<i aria-hidden="true" class="fas fa-angle-double-left bc_text_15 bc_line_height_34 bc_color_primary"></i>',
               'next_text' => '<i aria-hidden="true" class="far fa-angle-double-right bc_text_15 bc_line_height_34 bc_color_primary"></i>',
               'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
               'format' => '?paged=%#%',
               'current' => max( 1, get_query_var('paged') ),
               'total' => $query->max_num_pages
               ) );
               wp_reset_postdata(); 
               ?>  
         </div>
      </div>
      <!-- End Desktop Section -->
      <!-- mobile section -->
      <div class="row mt-4 mt-lg-0 d-lg-none">
         <?php 
            $args  = array( 'post_type' => 'bc_galleries', 'order'=> 'DESC','post_status'  => 'publish','posts_per_page'=>4,'paged' => get_query_var('paged') ? get_query_var('paged') : 1,  'meta_query' => array(
                            array(
                                'key' => 'album_isprojectgallery',
                                'value' => '1',
                                'compare' => '='
                            )
                        ));
            if (!empty($cat)){
                $args  = array('tax_query' => array(
                        array(
                            'taxonomy' => 'bc_gallery_category',
                            'field' => 'slug',
                            'terms' => $cat)));
            }
            ob_start();
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : 
            while( $the_query->have_posts() ) {
            $the_query->the_post();
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id()), 'large' );
            $is_project_gallery = get_post_meta( get_the_id(), 'album_isprojectgallery', true );
            if ($is_project_gallery==true) {
            ?>
         <div class="col-lg-4 col-md-6 mb-4">
            <a href="<?php echo get_permalink(get_the_id());?>" class="d-block">
               <div class="card rounded-0 border-0 bc_color_white_bg gallery">
                  <div class="box-shadow card-body p-0 position-relative" style="background: url('<?php echo $large_image_url[0]; ?>'); background-size: cover; background-position: center;">
                    <div class="card-img-overlay justify-content-center d-flex">
                        <i class="far fa-search bc_text_36 bc_color_white align-self-center"></i>
                    </div>
                  </div>
                  <div class="card-footer py-0 mt-lg-3 mt-4 border-0 bg-transparent">
                     <span class="bc_text_16 bc_line_height_23 bc_font_default bc_color_quaternary bc_text_light">Problem:</span>
                     <span class="bc_text_26 bc_line_height_30 bc_font_default bc_color_black bc_text_light d-block mb-2"><?php echo get_post_meta( get_the_id(), 'album_problem', true ); ?></span>
                     <span  class="bc_text_16 bc_line_height_23 bc_font_default bc_color_quaternary bc_text_light d-block">Location:
                     <span class="bc_text_20 bc_color_black"> <?php echo get_post_meta( get_the_id(), 'album_location', true ); ?></span>
                     <span  class="float-right">
                     <i class="fal fa-arrow-right bc_text_26 bc_line_height_40 alt_color_three"></i>
                     </span>
                     </span>
                  </div>
               </div>
            </a>
         </div>
         <?php }
        }
        endif; ?>
      </div>
      <div class="row d-lg-none">
         <div class="col-12 text-center gallery-pagination">
            <?php 
               $big = 999999999; // need an unlikely integer
               echo paginate_links( array(
               'prev_text' => '<i aria-hidden="true" class="fas fa-angle-double-left bc_text_15 bc_line_height_34 bc_color_primary"></i>',
               'next_text' => '<i aria-hidden="true" class="far fa-angle-double-right bc_text_15 bc_line_height_34 bc_color_primary"></i>',
               'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
               'format' => '?paged=%#%',
               'current' => max( 1, get_query_var('paged') ),
               'total' => $the_query->max_num_pages
               ) );
               wp_reset_postdata(); 
               ?>  
         </div>
      </div>
      <!-- End mobile section -->
   </div>
</div>
<?php 
$output = ob_get_clean();
return $output;
}

// Admin notice for displaying shortcode on index page
add_action('admin_notices', 'bc_gallery_general_admin_notice');
function bc_gallery_general_admin_notice(){
    global $pagenow;
    global $post;
    if ($pagenow == 'edit.php' &&  (isset($post->post_type) ? $post->post_type : null) == 'bc_galleries') { 
     echo '<div class="notice notice-success is-dismissible">
            <p><b>Shortcode Example</b> 
            All : [bc-gallery]
            Single Album  : [bc-album-style1 album_id="336"]
            Single Case Album  : [bc-album-style2 album_id="335"]
            </p>
        </div>';
    }
}

function gallery_my_pagination_rewrite() {
    add_rewrite_rule('photo-gallery/page/?([0-9]{1,})/?$', 'index.php??page_id=261&paged=$matches[1]', 'top');
}
add_action('init', 'gallery_my_pagination_rewrite');
