<?php
/**
 * Plugin Name:       BC Testimonials
 * Plugin URI:        https://github.com/nikhil-twinspark/bc-testimonials
 * Description:       A simple plugin for creating custom post types for displaying testimonials.
 * Version:           1.0.0
 * Author:            Blue Corona
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bc-testimonials
 * Domain Path:       /languages
 */

 if ( ! defined( 'WPINC' ) ) {
     die;
 }

define( 'BC_TESTIMONIAL_VERSION', '1.0.0' );
define( 'BCTESTIMONIALDOMAIN', 'bc-testimonials' );
define( 'BCTESTIMONIALPATH', plugin_dir_path( __FILE__ ) );

require_once( BCTESTIMONIALPATH . '/post-types/register.php' );
add_action( 'init', 'bc_testimonial_register_testimonial_type' );

require_once( BCTESTIMONIALPATH . '/custom-fields/register.php' );

function bc_testimonial_rewrite_flush() {
    bc_testimonial_register_testimonial_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'bc_testimonial_rewrite_flush' );

// plugin uninstallation
register_uninstall_hook( BCTESTIMONIALPATH, 'bc_testimonial_uninstall' );
function bc_testimonial_uninstall() {
    // Removes the directory not the data
}
 
// Add Conditionally css & js for specific pages
add_action('admin_enqueue_scripts', 'bc_testimonil_include_css_js');
function bc_testimonil_include_css_js($hook){
    $current_screen = get_current_screen();
    if ( $current_screen->post_type == 'bc_testimonials') {
        // Include CSS Libs
        wp_register_style('bc-plugin-css', plugins_url('assests/css/bootstrap.min.css', __FILE__), array(), '1.0.0', 'all');
        wp_enqueue_style('bc-plugin-css');

        wp_enqueue_script('bc-testimonials-image-upload-js', plugin_dir_url(__FILE__).'assests/js/bc-image-upload.js', array( 'jquery'));
    } 
}

add_shortcode( 'mobile_testimonial_A', 'mobile_testimonial_A_shortcode' );
function mobile_testimonial_A_shortcode ( $atts , $content = null) {
    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
    ?>

    <script>
    jQuery(document).ready(function() {
    var testimonialSwiper<?php echo $count ?> = new Swiper('#bc_testimonial_swiper_a_<?php echo $count ?>', {
        navigation: {
            nextEl: '.testimonial-a-btn-next',
            prevEl: '.testimonial-a-btn-prev',
        },
            slidesPerView: 1,
            loop: true,
            speed: 400,
            // autoplay: true,
            paginationClickable: true,
            spaceBetween: 50,
            pagination: {
              el: '.reviews_a_pagination',
              type: 'bullets',
              clickable: true,
            },
            breakpoints: {
              640: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
              1024: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
            }
        });
    });
    </script>

    <?php });
    $Ids = null;
    $args  = array( 'post_type' => 'bc_testimonials', 'posts_per_page' => -1, 'order'=> 'DESC','post_status'  => 'publish');
    if(isset($atts['id'])) {
        $Ids = explode(',', $atts['id']);
        $postIds = $Ids;
        $args['post__in'] = $postIds;
    } 
    ob_start();
    ?>
<div class="container-fluid m-0 mobile_testimonial_A my-5 py-4 px-0">
    <div class="container">
        <div class="row no-gutters">
            <div class="testimonial-a-btn-prev col-md-1 text-center d-none d-md-block align-self-center" tabindex="0" aria-label="Previous slide" role="button">
                <i class="far fa-chevron-left d-block mx-auto"></i>
            </div>

            
            <div class="col-lg-10">

                <span class="testimonial_heading d-block text-center">Our Reviews</span>
                <div class="swiper-container reviews_swiper_a" id="bc_testimonial_swiper_a_<?php echo $count;?>">
                    <div class="swiper-wrapper pb-5">
    <?php
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
    while($query->have_posts()) : $query->the_post();
    $name = get_post_meta( get_the_ID(), 'testimonial_name', true );
    $title = get_post_meta( get_the_ID(), 'testimonial_title', true );
    $message = get_post_meta( get_the_ID(), 'testimonial_message', true );
    $image = get_post_meta( get_the_ID(), 'testimonial_custom_image', true );
    ?>
        <div class="swiper-slide">
            <div class="reviews-slide py-2">
                <div class="text-center">
                    <i class="fas fa-quote-left"></i> &nbsp;
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span class="testimonial_detail d-block text-center my-3"> 
                <?php 
                if (strlen($message) > 165){
                $message = substr($message, 0, 165) . '...';
                    echo $message; 
                }else{
                    echo $message;
                }
                ?>
                </span>
                <span class="client_name d-block text-center"><?php echo $name;?></span>
            </div>
        </div>
        <?php
            endwhile; 
            wp_reset_query();
        endif;?>
                    </div>
                    <div class="swiper-pagination reviews_a_pagination d-md-none"></div>


                </div>
            </div>
            <div class="testimonial-a-btn-next col-md-1 text-center d-none d-md-block align-self-center" tabindex="0" aria-label="Next slide" role="button">
            <i class="far fa-chevron-right d-block mx-auto"></i>
            </div>
        </div>
    </div>
</div>
<?php 
$output = ob_get_clean();
return $output;
}

add_shortcode( 'mobile_testimonial_B', 'mobile_testimonial_B_shortcode' );
function mobile_testimonial_B_shortcode ( $atts , $content = null) {
    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
    ?>
    <script>
    jQuery(document).ready(function() {
    var testimonialSwiper<?php echo $count ?> = new Swiper('#bc_testimonial_swiper_b_<?php echo $count ?>', {
            navigation: {
            nextEl: '.testimonial-b-btn-next',
            prevEl: '.testimonial-b-btn-prev',
            },
            slidesPerView: 1,
            loop: true,
            speed: 400,
            // autoplay: true,
            paginationClickable: true,
            spaceBetween: 50,
            pagination: {
              el: '.reviews_a_pagination',
              type: 'bullets',
              clickable: true,
            },
            breakpoints: {
              640: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
              1024: {
                slidesPerView: 1,
                spaceBetween: 20,
              },
            }
        });
    });
    </script>

    <?php });
    $Ids = null;
    $args  = array( 'post_type' => 'bc_testimonials', 'posts_per_page' => -1, 'order'=> 'DESC','post_status'  => 'publish');
    if(isset($atts['id'])) {
        $Ids = explode(',', $atts['id']);
        $postIds = $Ids;
        $args['post__in'] = $postIds;
    } 
    ob_start();
    ?>
<div class="container-fluid m-0 mobile_testimonial_B my-5 py-4 px-0">
    <div class="container">
        <div class="row no-gutters">
            <div class="testimonial-b-btn-prev col-md-1 text-center d-none d-md-block align-self-center" tabindex="0" aria-label="Previous slide" role="button">
                <i class="far fa-chevron-left d-block mx-auto"></i>
            </div>
            <div class="col-lg-10">

                <div class="text-center">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span class="testimonial_heading d-block text-center mb-2">What Our Clients Are Saying</span>

                <div class="swiper-container reviews_swiper_b" id="bc_testimonial_swiper_b_<?php echo $count;?>" >
                    <div class="swiper-wrapper pb-5">
            <?php
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
            while($query->have_posts()) : $query->the_post();
            $name = get_post_meta( get_the_ID(), 'testimonial_name', true );
            $title = get_post_meta( get_the_ID(), 'testimonial_title', true );
            $message = get_post_meta( get_the_ID(), 'testimonial_message', true );
            $image = get_post_meta( get_the_ID(), 'testimonial_custom_image', true );
            $get_image_id = attachment_url_to_postid($image);
            $alt = get_post_meta ( $get_image_id, '_wp_attachment_image_alt', true );
            ?>
            <div class="swiper-slide bg-white py-2">
                <div class="reviews-slide py-2">
                    <div class="client_img m-auto">
                    <?php 
                    if(isset($image) && !empty($image)){
                        echo '<img src="'.$image.'" class="img-fluid" alt="'.$alt.'">';
                    } 
                    ?>
                    </div>
                    <span class="testimonial_detail d-block text-center my-3"> <?php 
                        if (strlen($message) > 165){
                            $message = substr($message, 0, 165) . '...';
                            echo $message; 
                        }else{
                            echo $message;
                        }
                        ?></span>
                    <span class="client_name d-block text-center"><?php echo $name;?></span>
                </div>
            </div>
            <?php
            endwhile; 
            wp_reset_query();
            endif;?>        
                    </div>
                    <div class="swiper-pagination reviews_a_pagination d-md-none"></div>
                </div>
            </div>
            <div class="testimonial-b-btn-next col-md-1 text-center d-none d-md-block align-self-center" tabindex="0" aria-label="Next slide" role="button">
            <i class="far fa-chevron-right d-block mx-auto"></i>
            </div>
        </div>
    </div>
</div>
<?php 
$output = ob_get_clean();
return $output;
}

add_shortcode( 'bc-testimonial', 'bc_testimonial_shortcode' );
function bc_testimonial_shortcode ( $atts , $content = null) {
    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
    ?>
        <script>
        jQuery(document).ready(function() {
        var testimonialSwiper<?php echo $count ?> = new Swiper('#bc_testimonial_swiper_<?php echo $count ?>', {
            pagination: false,
            navigation: {
                nextEl: '.bc_testimonial_swiper_next',
                prevEl: '.bc_testimonial_swiper_prev',
            },
        });
        });
        </script>
    <?php });
    $Ids = null;
    $args  = array( 'post_type' => 'bc_testimonials', 'posts_per_page' => -1, 'order'=> 'DESC','post_status'  => 'publish');
    if(isset($atts['id'])) {
        $Ids = explode(',', $atts['id']);
        $postIds = $Ids;
        $args['post__in'] = $postIds;
    } 
    ob_start();
    ?>
<style type="text/css">
.circular--landscape {
  display: inline-block !important;
  position: relative;
  width: 100px;
  height: 100px;
  overflow: hidden;
  border-radius: 50%;
}

.circular--landscape img {
  width: auto;
  height: 100%;
  margin-left: 0px;
}
@media only screen and (max-width: 600px) {
    .bc_moblie_p{
        font-size:16px;
        line-height:30px;
        font-weight:400;
    }
} 
</style>
<div class="container-fluid bc_testimonials_container bc_home_section_bg py-5  text-center" style="background-image:url('<?php echo get_template_directory_uri();?>/img/testimonial_bg.png'); background-position:center;">
    <div class="text-center"><h2 class="bc_font_alt_1 pb-4 text-capitalize">Testimonials</h2></div>
    <div class="container">
<div id="bc_testimonial_swiper_<?php echo $count;?>" class="bc_testimonial_swiper swiper-container">
    <div class="swiper-wrapper text-center">
        <?php
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
            while($query->have_posts()) : $query->the_post();
        $title = get_post_meta( get_the_ID(), 'testimonial_title', true );
        $message = get_post_meta( get_the_ID(), 'testimonial_message', true );
        $image = get_post_meta( get_the_ID(), 'testimonial_custom_image', true );
        $get_image_id = attachment_url_to_postid($image);
        $alt = get_post_meta ( $get_image_id, '_wp_attachment_image_alt', true );
        ?>
        <div class="swiper-slide">
            <div class="swiper-slide-container">
                <div class="swiper-slide-content">

                    <div class="circular--landscape d-none d-md-block">
                      <img src="<?php echo $image;?>" alt="<?php echo $alt;?>" /> 
                    </div> 
                    <!-- <div class="d-none d-md-block">
                        <img src="<?php echo $image;?>" class="w-25 rounded-circle img-responsive" />
                    </div>  -->
                    <div>
                        <p class="bc_moblie_p">
                        <?php 
                        if (strlen($message) > 165){
                            $message = substr($message, 0, 165) . '...';
                            echo $message; 
                        }else{
                            echo $message;
                        }
                        ?>
                        </p>
                    </div>
                    <div class="mt-2 d-none d-md-block">
                        <span class="bc_alternate_font_blue m-0 bc_text_18">- <?php the_title(); ?></span>
                        <p class="m-0"><?php echo $title;?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endwhile; 
            wp_reset_query();
        endif;?>
    </div>
    <div class="bc_testimonial_swiper_next swiper-button-next d-none d-lg-block"><em class="fa fa-chevron-circle-right"></em></div>
    <div class="bc_testimonial_swiper_prev swiper-button-prev d-none d-lg-block"><em class="fa fa-chevron-circle-left"></em></div>
</div>
 </div>
    <br>
    <button class="btn bc_color_primary_bg mt-2 mb-2 px-4 text-white " type="button">Read Testimonials</button>
    <br>
</div>
<?php 
$output = ob_get_clean();
return $output;
}

/** ADMIN COLUMN - HEADERS*/
add_filter('manage_edit-bc_testimonials_columns', 'add_new_testimonials_columns');
function add_new_testimonials_columns($columns) {
    return array(
                'cb' => $columns['cb'],
                'title' => $columns['title'],
                'name' => __('From'),
                'taxonomy_testimonials_category' => __('Categories'),
                'updated' => __('Updated'),
                'date' => 'Status',
            ); 
}

/** ADMIN COLUMN - CONTENT*/
add_action('manage_bc_testimonials_posts_custom_column', 'manage_testimonials_columns', 10, 2);
function manage_testimonials_columns($column_name, $id) {
    global $post;
    switch ($column_name) {
        case 'name':
            echo get_post_meta( $post->ID , 'testimonial_title' , true );
            break;
        case 'taxonomy_testimonials_category':
            $list_tax =  get_the_terms( $post->ID , 'bc_testimonial_category' , true );
            if(isset($list_tax) && !empty($list_tax)){
                foreach ($list_tax as $key => $value) {
                    echo $value->name.",";
                }
            }else{
                echo "-";
            }
            break;    
        case 'updated':
            $updated_day = get_the_modified_time('m/d/Y');
            echo $updated_day;
            break;
        default:
            break;
    } // end switch
}


// Admin notice for displaying shortcode on index page
add_action('admin_notices', 'bc_testimonials_general_admin_notice');
function bc_testimonials_general_admin_notice(){
    global $pagenow;
    global $post;
    if ($pagenow == 'edit.php' &&  (isset($post->post_type) ? $post->post_type : null) == 'bc_testimonials') { 
     echo '<div class="notice notice-success is-dismissible">
            <p><b>Shortcode Example</b> All : [bc-testimonial] Specific : [bc-testimonial id="1,2,3"]</p>
         </div>';
    }
}
