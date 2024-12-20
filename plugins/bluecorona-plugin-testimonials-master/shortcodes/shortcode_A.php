<?php 

add_shortcode( 'bc-testimonial-type-a', 'bc_testimonial_type_a_shortcode' );
function bc_testimonial_type_a_shortcode ( $atts , $content = null) {
if(bc_get_theme_mod('bc_theme_options', 'testimonial', 'type') == 'type_a'){

    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
    ?>
        <script>
        jQuery(document).ready(function(){
        var testimonial_swiper<?php echo $count ?> = new Swiper('#bc_testimonial_swiper_a_<?php echo $count ?>', {
            loop: true,
            speed: 400,
            autoplay: true,
            navigation: {
                nextEl: '.swiper-button-next.testimonials ',
                prevEl: '.swiper-button-prev.testimonials ',
            },
            pagination: {
                el: '.swiper-pagination.testimonials',
                clickable: true,
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
 <div class="container-fluid pb-lg-4 p-0 bc_mt_n13">
        <div class="container max-width-100 bc_color_white_bg bc_shadow py-4 pl-lg-5 pr-lg-5 pb-5 text-center border-top mb-lg-5">
         <div class="bc_color_yellow d-block mb-3 mx-auto pt-lg-2">
            <i class="fas fa-star bc_text_25 bc_sm_text_15 mr-2"></i>
            <i class="fas fa-star bc_text_25 bc_sm_text_15 mr-2"></i>
            <i class="fas fa-star bc_text_25 bc_sm_text_15 mr-2"></i>
            <i class="fas fa-star bc_text_25 bc_sm_text_15 mr-2"></i>
            <i class="fas fa-star bc_text_25 bc_sm_text_15"></i>
        </div>
        <h5>Don’t take our word for it</h5>
        <h4 class="mb-4 pl-3 pr-3 p-lg-0">See What Your Neighbors Are Saying</h4>
        <div id="bc_testimonial_swiper_a_<?php echo $count;?>" class="swiper-container pt-2 testimonials">
            <div class="swiper-wrapper">
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
                        <p class="pl-lg-5 pr-lg-5 mr-lg-5 ml-lg-5">
                           <?php 
                           if (strlen($message) > 200){
                            $message = substr($message, 0, 200) . '...';
                            echo $message; 
                        }else{
                            echo $message;
                        }
                        ?></p>
                        <strong class="d-block mt-2 mb-5 mb-lg-0 bc_font_alt_3"><?php echo $name;?></strong>
                    </div> 
                    <?php
                endwhile; 
                wp_reset_query();
            endif;?>                  
        </div>
        <div class="swiper-button-next testimonials d-none d-lg-block"><i
            class="fas fa-chevron-right bc_text_16 alternate_color34 bc_color_secondary_hover"></i></div>
            <div class="swiper-button-prev testimonials d-none d-lg-block"><i
                class="fas fa-chevron-left bc_text_16 alternate_color34 bc_color_secondary_hover"></i></div>
                <div class="swiper-pagination black-dots testimonials d-lg-none"></div>
            </div>
            <a href="#" class="btn btn-primary mt-5 mb-lg-2">
                Read our reviews <i class="far fa-arrow-right"></i>
            </a>
        </div>
    </div> 

<?php 
    $output = ob_get_clean();
    return $output;
    }
}