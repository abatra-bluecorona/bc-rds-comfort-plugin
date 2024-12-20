<?php

$array = rds_template();

$site_info = $array['site_info'];
if (isset($_POST['site_info_configuration']) && isset($_POST['rdssiteinfoconfignonce']) && wp_verify_nonce($_POST['rdssiteinfoconfignonce'], 'rdssiteinfoconfignonce')) {
    $array['site_info']['company_name'] = $_POST['site_company_name'];
     $array['site_info']['address_heading'] = $_POST['address_heading'];
    $array['site_info']['hours_heading'] = $_POST['hours_heading'];
    $array['site_info']['heading'] = $_POST['footer_heading'];
    if (isset($_POST['site_address'])) {
        $array['site_info']['address'] = array();
        $i = 0;
        foreach ($_POST['site_address'] as $site_add) {
            $array['site_info']['address'][$i]['address'] = $_POST['site_address'][$i];
            $array['site_info']['address'][$i]['city'] = $_POST['site_city'][$i];
            $array['site_info']['address'][$i]['zip'] = $_POST['site_zip'][$i];
            $array['site_info']['address'][$i]['state'] = $_POST['site_state'][$i];
            $array['site_info']['address'][$i]['map_directions_link'] = $_POST['site_map_directions_link'][$i];
            $i++;
        }
    }

      if (isset($_POST['footer_social_icon_class'])) {
        $array['site_info']['social_media']['items'] = array();
        $l = 0;
        foreach ($_POST['footer_social_icon_class'] as $site_add) {
            $array['site_info']['social_media']['items'][$l]['icon_class'] = $_POST['footer_social_icon_class'][$l];
            $array['site_info']['social_media']['items'][$l]['url'] = $_POST['footer_social_url'][$l];
         
            $l++;
        }
    }



    
    if (isset($_POST['site_info_search_license_number'])) {
        $k = 0;
        $array['site_info']['license_number'] = array();
        foreach ($_POST['site_info_search_license_number'] as $site_add) {
            $array['site_info']['license_number'][$k] = $_POST['site_info_search_license_number'][$k];
            $k++;
        }
    }
    $array['site_info']['search_box']['icon_class'] = $_POST['site_info_search_icon_class'];
    $array['site_info']['search_box']['placeholder'] = $_POST['site_info_search_placeholder_text'];
    $array['site_info']['search_box']['button_text'] = $_POST['site_info_search_btn_text'];
    $array['site_info']['country_code'] = $_POST['site_info_country_code'];
    $array['site_info']['phone'] = $_POST['site_info_phone_number'];
    $array['site_info']['fax'] = $_POST['site_info_fax_number'];
    $array['site_info']['weekday_hours'] = $_POST['site_info_week_hours'];
    $array['site_info']['week_days'] = $_POST['site_week_days'];
    $array['site_info']['weekend_hours'] = $_POST['site_info_weekends_hours'];
    $array['site_info']['weekend_days'] = $_POST['site_info_weekends'];
     $array['site_info']['disclaimer_text'] = stripslashes($_POST['footer_disclaimer_text']);
    $array['site_info']['copyright_title'] = $_POST['footer_copyright_title'];
    $array['site_info']['bluecorona_branding'] = isset($_POST['footer_bluecorona_brand']) ? true : false;
    $array['site_info']['privacy_policy_link'] = $_POST['footer_privacy_policy'];
    $array['site_info']['bluecorona_link'] = $_POST['bluecorona_link'];
      $update = rds_update_template_option_add_mongo_log($array);
     global $wpdb;
    $tableNameg = $wpdb->prefix . 'postmeta';
                    $contactpagequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39942'";
    $array = $wpdb->get_results($contactpagequery);
    if (!empty($array)) {
        $object = $array[0];

        $decodedArray = json_decode($object->meta_value, true);
        $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [
            "weekday_hours" => $array['site_info']['weekday_hours'],
            "hours_heading" => $array['site_info']['hours_heading'],
            "address_heading" => $array['site_info']['address_heading'],
            "week_days" => $array['site_info']['week_days'],
            "weekend_hours" => $array['site_info']['weekend_hours'],
            "weekend_days" => $array['site_info']['weekend_days'],
            "follow_text" => $array['globals']['footer']['heading'],
        ]);
        foreach (
            $array['globals']['footer']['social_media']['items']
            as $index => $values
        ) {
            $itemExists = isset(
                $decodedArray[0]['settings']['social_items'][$index]
            );
            if ($itemExists) {
                foreach ($values as $key => $value) {
                    $item_key = 'item_' . $key;
                    $decodedArray[0]['settings']['social_items'][$index][
                        $item_key
                    ] = $value;
                }
            } else {
                // Add new data for the item
                $decodedArray[0]['settings']['social_items'][$index] = [];
                foreach ($values as $key => $value) {
                    $item_key = 'item_' . $key;
                    $decodedArray[0]['settings']['social_items'][$index][
                        $item_key
                    ] = $value;
                }
            }
        }

        foreach (
            $decodedArray[0]['settings']['social_items']
            as $index => $itemData
        ) {
            if (
                !isset(
                    $array['globals']['footer']['social_media'][
                        'items'
                    ][$index]
                )
            ) {
                unset($decodedArray[0]['settings']['social_items'][$index]);
            }
        }

        foreach ($array['site_info']['address'] as $index => $values) {
            $itemExists = isset(
                $decodedArray[0]['settings']['address_iteam'][$index]
            );
            if ($itemExists) {
                foreach ($values as $key => $value) {
                    $item_key = $key;
                    $decodedArray[0]['settings']['address_iteam'][$index][
                        $item_key
                    ] = $value;
                }
            } else {
                // Add new data for the item
                $decodedArray[0]['settings']['address_iteam'][$index] = [];
                foreach ($values as $key => $value) {
                    $item_key = $key;
                    $decodedArray[0]['settings']['address_iteam'][$index][
                        $item_key
                    ] = $value;
                }
            }
        }

        foreach (
            $decodedArray[0]['settings']['address_iteam']
            as $index => $itemData
        ) {
            if (!isset($array['site_info']['address'][$index])) {
                unset($decodedArray[0]['settings']['address_iteam'][$index]);
            }
        }

        $object->meta_value = json_encode($decodedArray);

        $result = $wpdb->update(
            $tableNameg,
            ['meta_value' => $object->meta_value],
            ['meta_key' => '_elementor_data', 'post_id' => 39942]
        );
    }
  


    //Set session Name
    $_SESSION["site_info_config"] = "site_info_config";
    $_SESSION['site_info_config_time_stamp'] = time();
    if ($update) {
        wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=site-info"));
    }
}
$status = isset($_SESSION["site_info_config"]) ? $_SESSION["site_info_config"] : '';
$inactive = 1;
if ($status === 'site_info_config') {
    echo "<h5 style='color: green;'>Site Configuration  Updated </h5>";
    // destroy session
    $time = isset($_SESSION['site_info_config_time_stamp']) ? $_SESSION['site_info_config_time_stamp'] : 0;
    $session_life = time() - $time;
    if ($session_life > $inactive) {
        session_destroy();
    }
}
?>
<form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='' id="site-info-updation">
    <input type="hidden" name="rdssiteinfoconfignonce" value="<?= wp_create_nonce('rdssiteinfoconfignonce') ?>" >
    <div class="container mt-3">
        <div class="row">
            <div class="col-3"><label><b>Company Name </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" value="<?= $site_info['company_name']; ?>" placeholder="Enter Company Name" name="site_company_name" />
            </div>
        </div>
          <div class="row mt-4">
            <div class="col-3"><label><b>Address Heading</b> </label></div>
            <div class="col-4">
                <input type="text" class="form-control" value="<?= $site_info['address_heading']; ?>" placeholder="Enter Address Heading" name="address_heading" />
            </div>
        </div>

        <div class="container-add-more mt-4">
            <!-- <div class="row">
                <div class="col-3"><h5> Primary Address</h5></div>
            </div> -->
            <h5><b>Primary Address</b></h5>
            <hr>
            <?php
            $i = 0;
            foreach ($site_info['address'] as $address) {
                ?>
                <div class="after-add-more-address mt-4">  
                    <div class="row">
                        <div class="col-3"><label><b>Address </b><span style='color:red;'>*</span></label></div>
                        <div class="col-4">
                            <textarea rows="6" cols="31" placeholder="Enter Primary Address..." name="site_address[]"><?= $address['address']; ?></textarea>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label><b>City </b><span style='color:red;'>*</span></label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder=" Enter City Name" name="site_city[]" value="<?= $address['city']; ?>" />
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label><b>State </b><span style='color:red;'>*</span></label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder=" Enter State Name" name="site_state[]" value="<?= $address['state']; ?>" />
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label><b>Zip </b><span style='color:red;'>*</span></label></div>
                        <div class="col-4">
                            <input type="text" id="" maxlength="5" class="form-control zipcode" placeholder="Enter Zipcode" name="site_zip[]" value="<?= $address['zip']; ?>" />
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label><b>Map Direction Link </b><span style='color:red;'>*</span></label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Enter Map Direction Link" name="site_map_directions_link[]" value="<?= $address['map_directions_link']; ?>" />
                        </div>
                        <div class="col-3 change">
                            <button type="button" class="btn btn-danger remove" >- Remove</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row add-change-btn">
                <div class="col-3 change">
                    <button type="button" class="btn btn-info add-more-address" >+ Add More Address</button>
                </div>
            </div>
        </div>
        <br/>
        <!-- <div class="row">
            <div class="col-3"><h5>Search Box </h5></div>
        </div>
        <br/> -->
        <h5><b>Search Box</b></h5>
            <hr>
        <div class="row">
            <div class="col-3"><label><b>Icon class </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" placeholder="Enter Icon class" name="site_info_search_icon_class" value="<?= $site_info["search_box"]['icon_class']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Placeholder Text </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" placeholder="Enter Placeholder Text" name="site_info_search_placeholder_text" value="<?= $site_info["search_box"]['placeholder']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Button text </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Button text" name="site_info_search_btn_text" value="<?= $site_info["search_box"]['button_text']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Country Code </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Country Code +91" name="site_info_country_code" value="<?= $site_info['country_code']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Phone Number </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control phone" placeholder="Enter Phone Number" name="site_info_phone_number" value="<?= $site_info['phone']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Fax Number </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Fax Number" name="site_info_fax_number" value="<?= $site_info['fax']; ?>" />
            </div>
        </div>
        <br/>
        <div class="container-add-more">
            <?php
            $i = 0;
            foreach ($site_info['license_number'] as $number) {
                ?>
                <div class="after-add-more mt-4 after-add-more-license">  
                    <div class="row">
                        <div class="col-3"><label><b>License Number </b></label></div>
                        <div class="col-4">
                            <input type="text"  class="form-control site_license" placeholder="Enter Licence Number" name="site_info_search_license_number[]" value="<?= $number; ?>" />
                        </div>
                        <div class="col-3 change">
                            <button type="button" class="btn btn-danger remove" >- Remove</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row add-change-btn">
                <div class="col-3 change">
                    <button type="button" class="btn btn-info add-more-license" >+ Add More License Number</button>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-3"><label><b>Hours Heading </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" value="<?= $site_info['hours_heading']; ?>" placeholder="Enter Address Heading" name="hours_heading" />
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-3"><label><b>Weekday Hours </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Weekday Hours" name="site_info_week_hours" value="<?= $site_info['weekday_hours']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Weekdays </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Weekdays" name="site_week_days" value="<?= $site_info['week_days']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Weekend Hours </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" name="site_info_weekends_hours" placeholder="Enter Weekend Hours" value="<?= $site_info['weekend_hours']; ?>" />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Weekend </b></label></div>
            <div class="col-4">
                <input type="text"  class="form-control" placeholder="Enter Weekend" name="site_info_weekends" value="<?= $site_info['weekend_days']; ?>" />
            </div>
        </div>
        <br/>
                    <div class="row">
                        <div class="col-3"><label><b>Social Media Heading</b> </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Enter Heading text" value="<?= $site_info['heading']; ?>" name="footer_heading">
                        </div>
                    </div>
                    <div class="container-add-more">
                        <?php foreach ($site_info['social_media']['items'] as $item) {
                            ?>
                            <div class="after-add-more-social mt-4">  
                                <div class="row">
                                    <div class="col-3"><label><b>Social Media Icon Class</b></label></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Enter Icon Class" value="<?= $item['icon_class']; ?>"  name="footer_social_icon_class[]">
                                    </div>
                                </div>
                                <br/>    
                                <div class="row">
                                    <div class="col-3"><label><b>Social Media URL</b></label></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Enter URL" value="<?= $item['url']; ?>" name="footer_social_url[]">
                                    </div>
                                    <div class="col-3 change">
                                        <button type="button" class="btn btn-danger remove" >- Remove</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row add-change-btn">
                            <div class="col-3 change float-right">
                                <button type="button" class="btn btn-info add-more-social" >+ Add More Social Media</button>
                            </div>
                        </div>
                    </div>
                    <br/>
        <div class="row">
            <div class="col-3"><label><b>Disclaimer Text </b></label></div>
            <div class="col-3"> 
                <textarea rows="6" cols="70" value="<?= $site_info['disclaimer_text']; ?>" name="footer_disclaimer_text"><?= $site_info['disclaimer_text']; ?></textarea>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Copyright Title </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" placeholder="Enter Copyright Title" value="<?= $site_info['copyright_title']; ?>" name="footer_copyright_title">
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Bluecorona brand </b></label></div>
            <div class="col-4">
                <input type="checkbox" class="form-control" placeholder="Enter Copyright Title" value="true" name="footer_bluecorona_brand" <?= $site_info['bluecorona_branding'] ? "checked" : "uncheked"; ?>>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Bluecorona link </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" placeholder="Enter Bluecorona link link" value="<?= $site_info['bluecorona_link']; ?>" name="bluecorona_link">
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-3"><label><b>Privacy Policy link </b></label></div>
            <div class="col-4">
                <input type="text" class="form-control" placeholder="Enter Privacy Policy link" value="<?= $site_info['privacy_policy_link']; ?>" name="footer_privacy_policy">
            </div>
        </div>
        <button type="button" style="display:none;" class="save-first site_info_save site_info_submit btn btn-primary mt-3" >Save changes</button><button type="submit" class="save-change site_info_save site_info_submit btn btn-primary mt-3"  name="site_info_configuration">Save changes</button>
        <!-- <div id="fillFormMessage" style="display:none; color:red;">Kindly complete all mandatory fields within the Address section before proceeding.</div> -->

    </div>  
</form>

<?php
