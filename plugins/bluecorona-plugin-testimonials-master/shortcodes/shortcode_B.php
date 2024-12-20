<?php 

add_shortcode( 'bc-testimonial-type-b', 'bc_testimonial_type_b_shortcode' );
function bc_testimonial_type_b_shortcode ( $atts , $content = null) {
if(bc_get_theme_mod('bc_theme_options', 'testimonial', 'type') == 'type_b'){

    static $count = 0;
    $count++;
    add_action( 'wp_footer' , function() use($count){
    ?>
        <script>
        jQuery(document).ready(function(){
        var testimonial_swiper<?php echo $count ?> = new Swiper('#bc_testimonial_swiper_b_<?php echo $count ?>', {
             navigation: {
                nextEl: '.testimonial-a-btn-next',
                prevEl: '.testimonial-a-btn-prev',
            },
            slidesPerView: 1,
            loop: true,
            speed: 400,
            autoplay: true,
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
 <div class="container-fluid m-0 mobile_testimonial_A bg-lg-transparent py-4 pt-5 pt-lg-0 px-0">
        <div class="container position-relative border-lg-top bg-lg-white mb-5 mt-lg-n13 shadow-lg shadow-none p-lg-5">

            <div class="row no-gutters">
                <div class="testimonial-a-btn-prev col-md-2 text-right pr-5 d-none d-lg-block align-self-center"
                tabindex="0" aria-label="Previous slide" role="button">
                <i class="fas fa-chevron-left bc_text_16 d-block mx-auto"></i>
            </div>
            <div class="col-lg-8">
                <span
                class="testimonial_heading d-block text-center bc_font_default bc_color_secondary bc_text_36 bc_line_height_36 bc_text_bold mt-n1">Our
            Reviews</span>
            <div id="bc_testimonial_swiper_b_<?php echo $count;?>" class="swiper-container reviews_swiper_a">
                <div class="swiper-wrapper pb-3">
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
                            <div class="reviews-slide py-4 pl-lg-3">
                                <div class="text-center text-lg-left pb-3">
                                    <i
                                    class="fas fa-quote-left bc_text_48 bc_letter_spacing_10 bc_line_height_0 bc_sm_text_35"></i>
                                    &nbsp;
                                    <i class="fas fa-star bc_text_20 bc_sm_text_15"></i>
                                    <i class="fas fa-star bc_text_20 bc_sm_text_15"></i>
                                    <i class="fas fa-star bc_text_20 bc_sm_text_15"></i>
                                    <i class="fas fa-star bc_text_20 bc_sm_text_15"></i>
                                    <i class="fas fa-star bc_text_20 bc_sm_text_15"></i>
                                </div>
                                <span
                                class="testimonial_detail d-block text-center  text-lg-left my-3 bc_font_alt_1 bc_text_28 bc_line_height_40 bc_sm_text_20 bc_sm_line_height_24 pr-lg-5 pb-lg-3">
                                <?php 
                                if (strlen($message) > 200){
                                    $message = substr($message, 0, 200) . '...';
                                    echo $message; 
                                }else{
                                    echo $message;
                                }
                                ?>
                            </span>
                            <span
                            class="client_name d-block text-center text-lg-left bc_line_height_0 bc_font_alt_1 mt-4 py-2"><?php echo $name;?></span>
                        </div>
                    </div>

                    <?php
                endwhile; 
                wp_reset_query();
            endif;?>     

        </div>
        <div class="swiper-pagination reviews_a_pagination d-lg-none black-dots"></div>


    </div>
    <div class="text-center">
        <a href="#" class="btn btn-primary mt-lg-0 mt-4">Read our reviews <i
            class="far fa-arrow-right"></i></a>
        </div>
    </div>
    <div class="testimonial-a-btn-next col-md-2 text-left d-none d-lg-block align-self-center" tabindex="0"
    aria-label="Next slide" role="button">
    <i class="fas fa-chevron-right bc_text_16 d-block mx-auto"></i>
</div>

</div>

</div>
</div>
<?php 
    $output = ob_get_clean();
    return $output;
    }
}