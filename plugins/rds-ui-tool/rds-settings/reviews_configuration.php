<?php
    $array = rds_template();

    
    $reviews = $array['globals']['testimonial'];
    if (isset($_POST['reviews_configuration']) && isset($_POST['rdsreviewsconfignonce']) && wp_verify_nonce($_POST['rdsreviewsconfignonce'], 'rdsreviewsconfignonce')) {
        $array['globals']['testimonial']['enable'] = isset($_POST['reviews_enable']) ? true : false;
        $array['globals']['testimonial']['variation'] = $_POST['reviews_variation'];
        $array['globals']['testimonial']['heading'] = $_POST['reviews_heading'];
        $array['globals']['testimonial']['subheading'] = $_POST['reviews_subheading'];
        $array['globals']['testimonial']['button_text'] = $_POST['reviews_button_text'];
        $array['globals']['testimonial']['button_link'] = $_POST['reviews_button_link'];

        $update = rds_update_template_option_add_mongo_log($array);
        global $wpdb;
        $tableName = $wpdb->prefix . 'postmeta';
        $testimonialquery = "SELECT * FROM $tableName WHERE meta_key = '_elementor_data' AND post_id = '13225'";
        $object = $wpdb->get_results($testimonialquery)[0];

        $decodedArray = json_decode($object->meta_value, true);
        $decodedArray[0]['settings'] = array_merge(
            $decodedArray[0]['settings'],
            array(
       'testimonial_heading' => $_POST['reviews_heading'],
       'testimonial_subheading' => $_POST['reviews_subheading'],
       'testimonial_button_link' => $_POST['reviews_button_link'],
       'testimonial_button_text' => $_POST['reviews_button_text'],
       'testimonial_variation' => $_POST['reviews_variation']
    )
        );

        $object->meta_value = json_encode($decodedArray);

        $result = $wpdb->update(
            $tableName,
            array('meta_value' => $object->meta_value),
            array('meta_key' => '_elementor_data', 'post_id' => 13225)
        );
        //Set session Name
        $_SESSION["reviews_config"] = "reviews_config";
        $_SESSION['reviews_config_time_stamp'] = time();

        if ($update) {
            wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=reviews"));
        }
    }
    $status = isset($_SESSION["reviews_config"]) ? $_SESSION["reviews_config"] : '';
    $inactive = 10;
    if ($status === 'reviews_config') {
        echo "<h5 style='color: green;'>Reviews Configuration  Updated </h5>";
        $time = isset($_SESSION['reviews_config_time_stamp']) ? $_SESSION['reviews_config_time_stamp'] : 0;
        $session_life = time() - $time;
        if ($session_life > $inactive) {
            session_destroy();
        }
    }
    ?>
    <form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype=''>
        <input type="hidden" name="rdsreviewsconfignonce" value="<?= wp_create_nonce('rdsreviewsconfignonce') ?>" >
        <div class="container mt-3">
            <div class="row">
                <div class="col-3"><label>Enable Section </label></div>
                <div class="col-4">
                    <input type="checkbox" id="reviews-eanble-checkbox" class="form-control" value="true" placeholder="Enter order " name="reviews_enable" / <?= $reviews['enable'] ? "checked" : "uncheked"; ?>>
                </div>
            </div>
            <br/>
            <div id="reviews-enable-section">
                
                <div class="row">
                    <div class="col-3"><label>Select Variation</label></div>
                    <div class="col-4">
                        <select  class="form-select rds-select-variation" id="" name="reviews_variation">
                            <option value="a" <?php if ($reviews['variation'] == 'a') echo 'selected'; ?>>A</option>
                            <option value="b" <?php if ($reviews['variation'] == 'b') echo 'selected'; ?>>B</option>
                            <option value="c" <?php if ($reviews['variation'] == 'c') echo 'selected'; ?>>C</option>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-3"><label>Heading </label></div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="<?= $reviews['heading']; ?>" placeholder="Enter Heading " name="reviews_heading" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-3"><label>Subheading </label></div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="<?= $reviews['subheading']; ?>" placeholder="Enter Subheading " name="reviews_subheading" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-3"><label>Button Text </label></div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="<?= $reviews['button_text']; ?>" placeholder="Enter Button Text " name="reviews_button_text" />
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-3"><label>Button Link </label></div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="<?= $reviews['button_link']; ?>" placeholder="Enter Button Link " name="reviews_button_link" />
                    </div>
                </div>
                <br/>

            </div>
            <button type="button" style="display:none;" class="save-first btn btn-primary mt-3" disabled>Save changes</button><button type="submit" class="save-change btn btn-primary mt-3" name="reviews_configuration">Save changes</button>
        </div>  
    </form>
