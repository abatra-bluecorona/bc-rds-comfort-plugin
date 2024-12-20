<?php

            $array = rds_tracking();

            $invoca = $array['invoca'];
            $chat = $array['chat'];
            $tracking = $array['tracking'];
            $scheduler = $array['scheduler'];
            $hotjar = $array['Hotjar'];
            $accessibility = $array['accessibility'];
            // $facebookPixel = $array['tracking']['Facebook_Pixel'];

            $Google_Ads_Conversion_Codes = $array['Google_Ads_Conversion_Codes'];

            if (isset($_POST['rdschatserviceconfignonce']) && wp_verify_nonce($_POST['rdschatserviceconfignonce'], 'rdschatserviceconfignonce')) {
                // Handle chat configuration
                $array['chat']['enable'] = isset($_POST['chat_enable']) ? true : false;
                $array['chat']['position'] = $_POST['chat_position'];
                $array['chat']['Scheduler'] = $_POST['chat_scheduler'];
                $array['chat']['id'] = $_POST['chat_id'];
                $array['chat']['content'] = stripslashes($_POST['chat_script']);
                $array['chat']['schedule_engine_info']['initial_message'] = $_POST['chat_scheduler_init'];
                $array['chat']['schedule_engine_info']['logo_url'] = $_POST['chat_scheduler_logo'];
                $array['chat']['schedule_engine_info']['title'] = $_POST['chat_scheduler_title'];
                $array['chat']['schedule_engine_info']['auto_open'] = $_POST['chat_scheduler_open'];
                $array['chat']['schedule_engine_info']['auto_open_mobile'] = $_POST['chat_scheduler_mobile'];
                $array['chat']['schedule_engine_info']['button_text'] = $_POST['chat_scheduler_button'];
                $array['chat']['schedule_engine_info']['position'] = $_POST['chat_scheduler_position'];

                // Handle tracking configuration
            /* if (isset($_POST['tracking_enable'])) {
                    $tracking['enable'] = true;
                } else {
                    $tracking['enable'] = false;
                }*/

                $array['tracking']['enable'] = isset($_POST['tracking_enable']) ? true : false;
                $array['tracking']['Google']['enable'] = isset($_POST['google_enable']) ? true : false;
                $array['tracking']['Google']['order'] = $_POST['google_order'];
                $array['tracking']['Google']['name'] = $_POST['google_name'];
                $array['tracking']['Google']['GA4_CODE'] = $_POST['google_GA4'];
                $array['tracking']['Google']['UA_CODE'] = $_POST['google_UA'];
                $array['tracking']['Google']['AW_CODE'] = $_POST['google_AW'];

                $array['tracking']['Google_Tag_Manager']['enable'] = isset($_POST['google_tag_manager_enable']) ? true : false;
                $array['tracking']['Google_Tag_Manager']['order'] = $_POST['google_tag_manager_order'];
                $array['tracking']['Google_Tag_Manager']['name'] = $_POST['google_tag_manager_name'];
                $array['tracking']['Google_Tag_Manager']['GTM_CODE'] = $_POST['google_tag_manager_GTM'];

                $array['tracking']['Google_Search_Console']['enable'] = isset($_POST['google_search_console_enable']) ? true : false;
                $array['tracking']['Google_Search_Console']['order'] = $_POST['google_search_console_order'];

                $array['tracking']['Google_Search_Console']['name'] = $_POST['google_search_console_name'];
                $array['tracking']['Google_Search_Console']['GSC_CODE'] = $_POST['google_search_console_GSC'];

                $array['tracking']['Facebook_Pixel']['enable'] = isset($_POST['facebook_pixel_enable']) ? true : false;
                $array['tracking']['Facebook_Pixel']['order'] = $_POST['facebook_pixel_order'];
                $array['tracking']['Facebook_Pixel']['name'] = $_POST['facebook_pixel_name'];
                $array['tracking']['Facebook_Pixel']['FACEBOOK_ID'] = $_POST['facebook_pixel_ID'];
                // if ($facebookPixel !== $array['tracking']['Facebook_Pixel']) {
                //     $facebookPixelData = $array['tracking']['Facebook_Pixel'];
                //     $keys = array_keys($array['tracking']);
                //     $keyName = $keys[4];
                //     rds_insert_tracking_option($facebookPixelData, $keyName);
                // }
                $array['tracking']['Bing_Ads_Pixel']['enable'] = isset($_POST['bing_ads_pixel_enable']) ? true : false;
                $array['tracking']['Bing_Ads_Pixel']['order'] = $_POST['bing_ads_pixel_order'];
                $array['tracking']['Bing_Ads_Pixel']['name'] = $_POST['bing_ads_pixel_name'];
                $array['tracking']['Bing_Ads_Pixel']['BING_ID'] = $_POST['bing_ads_pixel_BING_ID'];

                $array['Hotjar']['enable'] = isset($_POST['hotjar_enable']) ? true : false;
                $array['Hotjar']['order'] = $_POST['hotjar_order'];
                $array['Hotjar']['id'] = $_POST['hotjar_Hotjar_ID'];

                $array['accessibility']['enable'] = isset($_POST['accessibility_enable']) ? true : false;
                $array['accessibility']['name'] = $_POST['accessibility_name'];
                $array['accessibility']['id'] = $_POST['accessibility_Hotjar_ID'];

                if ($accessibility !== $array['accessibility']) {
                    $accessibilityData = $array['accessibility'];
                    $keys = array_keys($array);
                    $keyName = $keys[9];
                    rds_insert_tracking_option($accessibilityData, $keyName);
                }  

                $array['Google_Ads_Conversion_Codes']['enable'] = isset($_POST['google_ads_conversion_codes_enable']) ? true : false;
                $array['Google_Ads_Conversion_Codes']['order'] = $_POST['google_ads_conversion_codes_order'];
                $array['Google_Ads_Conversion_Codes']['name'] = $_POST['google_ads_conversion_codes_name'];
            
                $array['Google_Ads_Conversion_Codes']['items'] = array();
                $i = 0;
                foreach ($_POST['google_ads_conversion_codes_page_id'] as $class) {
                    $array['Google_Ads_Conversion_Codes']['items'][$i]['page_id'] = $_POST['google_ads_conversion_codes_page_id'][$i];
                    $array['Google_Ads_Conversion_Codes']['items'][$i]['AW_CODE'] = $_POST['google_ads_conversion_codes_AW_CODE'][$i];
                    $array['Google_Ads_Conversion_Codes']['items'][$i]['CONVERSION_CODE'] = $_POST['google_ads_conversion_codes_conversion_code'][$i];
                    $i++;
                }


                $array['scheduler']['enable'] = isset($_POST['scheduler_enable']) ? true : false;
                $array['scheduler']['position'] = $_POST['scheduler_position'];
                $array['scheduler']['Scheduler'] = $_POST['scheduler_scheduler'];
                $array['scheduler']['id'] = $_POST['scheduler_id'];
                $array['scheduler']['content'] = stripslashes($_POST['scheduler_script']);
                $array['scheduler']['zocdoc_content'] = stripslashes($_POST['zocdoc_id']);
                $array['scheduler']['nexhealth_content'] = stripslashes($_POST['nexhealth_id']);
                $array['scheduler']['clearwave_content'] = stripslashes($_POST['clearwave_id']);


                $array['invoca']['enable'] = isset($_POST['invoca_enable']) ? true : false;
                $array['invoca']['id'] = $_POST['invoca_id'];
                $array['invoca']['invoca_id'] = stripslashes($_POST['invoca_script']);



                $update = rds_update_tracking_option_add_mongo_log($array);

                // Set session name
                $_SESSION["chat_tracking_config"] = "chat_tracking_config";

                if ($update) {
                    wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=tracking"));
                            exit();
                }
            }

            $chatStatus = isset($_SESSION["chat_tracking_config"]) ? $_SESSION["chat_tracking_config"] : '';

            if ($chatStatus === 'chat_tracking_config') {
                echo "<h5 style='color:green;'>Chat, Tracking, and Scheduler Configuration Updated</h5>";
                unset($_SESSION["chat_tracking_config"]);
            }
            ?>
            <style>
                input[type=checkbox], input[type=radio] {
                    margin: 0.25rem 0.50rem 0 0 !important;
                }
            </style>
            <form id="tracking_config_form" method='post' action='<?=$_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                <input type="hidden" name="rdschatserviceconfignonce" value="<?=wp_create_nonce('rdschatserviceconfignonce') ?>">
                <!-- Chat Configuration Fields -->
                <div class="container mt-3">
                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="checkbox" id="tracking-enable" class="form-control" value="true" name="tracking_enable" <?=$tracking['enable'] ? "checked" : "unchecked"; ?>>
                            <label for="tracking-enable"><b>Enable Tracking</b></label>
                        </div>
                    </div>
                    <h5><b>Digital Marketing Tracking</b></h5>
                    <hr>
                    

                    <div id="tracking-section">
                            <!-- <div class="row" > -->
                                <div class="row mb-3">
                                <div class="col-3">
                                    <input type="checkbox" id="google-eanble-checkbox" class="form-control" value="true"  name="google_enable" / <?=$tracking['Google']['enable'] ? "checked" : "uncheked"; ?>>
                                    <!-- <label><b>Google Analytics</b> </label> -->
                                    <label for="google-eanble-checkbox"><b>Google Analytics</b></label>

                                </div>

                                </div>
                                <div id="google" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$tracking['Google']['order']; ?>" placeholder="Enter order " name="google_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="textarea" class="form-control" value="<?=$tracking['Google']['name']; ?>" placeholder="Enter Name " name="google_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>GA4 CODE </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google']['GA4_CODE']; ?>" placeholder="Enter GA4 CODE " name="google_GA4" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>UA CODE </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google']['UA_CODE']; ?>" placeholder="Enter UA CODE " name="google_UA" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>AW CODE </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google']['AW_CODE']; ?>" placeholder="Enter AW CODE " name="google_AW" />
                                </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row"> -->
                                <div class="row mb-3">
                                <div class="col-3"><input type="checkbox" id="google-search-console-eanble-checkbox" class="form-control" value="true"  name="google_search_console_enable" / <?=$tracking['Google_Search_Console']['enable'] ? "checked" : "uncheked"; ?>><label for="google-search-console-eanble-checkbox"><b>Google Search Console</b></label></div>

                                </div>
                                <div id="google-search-console" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$tracking['Google_Search_Console']['order']; ?>" placeholder="Enter order " name="google_search_console_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google_Search_Console']['name']; ?> " placeholder="Enter Name " name="google_search_console_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>GSC CODE </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google_Search_Console']['GSC_CODE']; ?> " placeholder="Enter GSC CODE " name="google_search_console_GSC" />
                                </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row"> -->
                                <div class="row mb-3">
                                <div class="col-3"><input type="checkbox" id="google-ads-conversion-codes-eanble-checkbox" class="form-control" value="true"  name="google_ads_conversion_codes_enable" / <?=$Google_Ads_Conversion_Codes['enable'] ? "checked" : "uncheked"; ?>><label for="google-ads-conversion-codes-eanble-checkbox"><b>Google Ads Conversion Codes</b></label></div>

                                </div>
                                <div id="google-ads-conversion-codes" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$Google_Ads_Conversion_Codes['order']; ?>" placeholder="Enter order " name="google_ads_conversion_codes_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$Google_Ads_Conversion_Codes['name']; ?> " placeholder="Enter Name " name="google_ads_conversion_codes_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="container-add-more">
                                <?php if (!empty($Google_Ads_Conversion_Codes['items'])) {
                                    foreach ($Google_Ads_Conversion_Codes['items'] as $item) {
                                ?>
                                    <div class="after-add-more-google-ads mt-4">  
                                        <div class="row">
                                            <div class="col-3"><label>PAGE ID</label><span style='color:red;'>*</span></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter Page ID" value="<?=$item['page_id']; ?>"  name="google_ads_conversion_codes_page_id[]">
                                            </div>
                                        </div>
                                        <br/> 
                                        <div class="row">
                                            <div class="col-3"><label>AW CODE</label><span style='color:red;'>*</span></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter AW Code" value="<?=$item['AW_CODE']; ?>" name="google_ads_conversion_codes_AW_CODE[]">
                                            </div>
                                        </div>
                                        <br/>    
                                        <div class="row">
                                            <div class="col-3"><label>CONVERSION CODE</label><span style='color:red;'>*</span></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter CONVERSION CODE" value="<?=$item['CONVERSION_CODE']; ?>" name="google_ads_conversion_codes_conversion_code[]">
                                            </div>
                                            <div class="col-3 change">
                                                <button type="button" class="btn btn-danger remove" >- Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    } else { ?>
                                <div class="after-add-more mt-4">  
                                        <div class="row">
                                            <div class="col-3"><label>PAGE ID</label></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter Page ID" value=""  name="google_ads_conversion_codes_page_id[]">
                                            </div>
                                        </div>
                                        <br/> 
                                        <div class="row">
                                            <div class="col-3"><label>AW CODE</label></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter AW Code" value="" name="google_ads_conversion_codes_AW_CODE[]">
                                            </div>
                                        </div>
                                        <br/>    
                                        <div class="row">
                                            <div class="col-3"><label>CONVERSION CODE</label></div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Enter CONVERSION CODE" value="" name="google_ads_conversion_codes_conversion_code[]">
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
                                        <button type="button" class="btn btn-info add-more-google-ads" >+ Add More Google Ads Conversion Codes</button>
                                    </div>
                                </div>
                            </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row"> -->
                            
                                <div class="row mb-3">
                                <div class="col-3"><input type="checkbox" id="google-tag-manager-eanble-checkbox" class="form-control" value="true"  name="google_tag_manager_enable" / <?=$tracking['Google_Tag_Manager']['enable'] ? "checked" : "uncheked"; ?>><label for="google-tag-manager-eanble-checkbox"><b>Google Tag Manager</b> </label></div>

                                </div>
                                <div id="google-tag-manager" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$tracking['Google_Tag_Manager']['order']; ?>" placeholder="Enter order " name="google_tag_manager_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google_Tag_Manager']['name']; ?>" placeholder="Enter Name " name="google_tag_manager_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>GTM CODE </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Google_Tag_Manager']['GTM_CODE']; ?>" placeholder="Enter GTM CODE " name="google_tag_manager_GTM" />
                                </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row"> -->
                                
                                <div class="row mb-3">
                                <div class="col-3"><input type="checkbox" id="bing-ads-pixel-eanble-checkbox" class="form-control" value="true"  name="bing_ads_pixel_enable" / <?=$tracking['Bing_Ads_Pixel']['enable'] ? "checked" : "uncheked"; ?>><label for="bing-ads-pixel-eanble-checkbox"><b>Bing Ads Pixel </b></label></div>

                                </div>
                                <div id="bing-ads-pixel" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$tracking['Bing_Ads_Pixel']['order']; ?>" placeholder="Enter order " name="bing_ads_pixel_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Bing_Ads_Pixel']['name']; ?>" placeholder="Enter Name " name="bing_ads_pixel_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>BING ID </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Bing_Ads_Pixel']['BING_ID']; ?>" placeholder="Enter BING ID " name="bing_ads_pixel_BING_ID" />
                                </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row"> -->
                                
                                <div class="row mb-3">
                                <div class="col-3"><input type="checkbox" id="facebook-pixel-eanble-checkbox" class="form-control" value="true"  name="facebook_pixel_enable" / <?=$tracking['Facebook_Pixel']['enable'] ? "checked" : "uncheked"; ?>><label for="facebook-pixel-eanble-checkbox"><b>Facebook Ads Pixel</b> </label></div>

                                </div>
                                <div id="facebook-pixel" style="text-align: center;">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$tracking['Facebook_Pixel']['order']; ?>" placeholder="Enter order " name="facebook_pixel_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>Name </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Facebook_Pixel']['name']; ?>" placeholder="Enter Name " name="facebook_pixel_name" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>FACEBOOK ID </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$tracking['Facebook_Pixel']['FACEBOOK_ID']; ?>" placeholder="Enter FACEBOOK ID " name="facebook_pixel_ID" />
                                </div>
                                </div>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="row">
                                <h5>Web Analytics</h5>
                                <hr>
                                <div class="row mb-3">
                                <div class="col-3">
                                    <input type="checkbox" id="hotjar-eanble-checkbox" class="form-control" value="true"  name="hotjar_enable" / <?=$hotjar['enable'] ? "checked" : "uncheked"; ?>>
                                    <label>Hotjar </label>
                                </div>
                                
                                </div>
                                <div id="hotjar">
                                <div class="row mb-3">
                                <div class="col-3"><label>Order </label></div>
                                <div class="col-4">
                                    <input type="number" min="1" class="form-control" value="<?=$hotjar['order']; ?>" placeholder="Enter order " name="hotjar_order" />
                                </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-3"><label>ID </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$hotjar['id']; ?>" placeholder="Enter Hotjar ID " name="hotjar_Hotjar_ID" />
                                </div>
                                </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="accessibility-section">
                                    <h5><b>Web Accessibility </b></h5>
                                </div>
                                <hr>
                              
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <input type="checkbox" id="accessibility-eanble-checkbox" class="form-control" value="true" name="accessibility_enable" <?=$accessibility['enable'] ? "checked" : "unchecked"; ?>>
                                        <label>Enable Web Accessibility Widget for ADA and WCAG Compilance </label>
                                    </div>
                                   
                                </div>
                                <div id="accessibility">
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label>Name </label>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" value="<?=$accessibility['name']; ?>" placeholder="Enter Name " name="accessibility_name" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label>ID </label>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" value="<?=$accessibility['id']; ?>" placeholder="Enter Accessibility ID " name="accessibility_Hotjar_ID" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <label>Logs: </label>
                                        </div>
                                        <div class="col-4">
                                            <button class="logButton" style="border: none; background: none; color: #0d6efd; text-decoration: underline;">View Logs</button>
                                        </div>
                                        <div id="loader"  style="display: none;">Loading...</div>
                                         <div id="tableSection"  class="mt-3 "  style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                    <!-- Service Area Configuration Fields -->
                    <h5><b>Engagement Tracking </b></h5>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="checkbox" id="invoca-eanble-checkbox" class="form-control" value="true" placeholder="Enter order " name="invoca_enable" <?=$invoca['enable'] ? "checked" : "uncheked"; ?>>
                            <label for="invoca-eanble-checkbox"><b>Phone</b></label>
                        </div>
                        
                    </div>

                    <div id="invoca-enable-section" style="text-align: center;">
                            <div class="row mb-3" id="invoca_script">
                                <div class="col-3"><label>Invoca ID</label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$invoca['invoca_id']; ?>" placeholder="Enter ID " name="invoca_script" />
                                    <!-- <textarea  rows="6" cols="70"  name="invoca_script" placeholder="Enter JS Script "><?=$invoca['invoca_id']; ?></textarea> -->
                                </div>
                            </div>
                        </div>


                    <div class="row mb-3">

                        <div class="col-3">
                            <input type="checkbox" id="chat-eanble-checkbox" class="form-control" value="true" name="chat_enable" <?=$chat['enable'] ? "checked" : "unchecked"; ?>>
                            <label for="chat-eanble-checkbox"><b>Chat</b></label>
                        </div>
                        
                    </div>
                    <div id="chat-enable-section" style="text-align: center;">
                        <div class="row mb-3">
                            <div class="col-3"><label>Position </label></div>
                            <div class="col-4">
                                <select  class="form-select rds-select-variation" id="" name="chat_position">
                                    <option value="head_top" <?php if ($chat['position'] == 'head_top') echo 'selected'; ?>>Head Top</option>
                                    <option value="head_bottom" <?php if ($chat['position'] == 'head_bottom') echo 'selected'; ?>>Head Bottom</option>
                                    <option value="footer_top" <?php if ($chat['position'] == 'footer_top') echo 'selected'; ?>>Footer Top</option>
                                    <option value="footer_bottom" <?php if ($chat['position'] == 'footer_bottom') echo 'selected'; ?>>Footer Bottom</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-3"><label>Select Scheduler </label></div>
                            <div class="col-4">
                                <select  class="form-select rds-select-variation" id="rds-chat-variation" name="chat_scheduler">
                                    <option value="zyra" <?php if ($chat['Scheduler'] == 'zyra') echo 'selected'; ?>>Zyra</option>
                                    <option value="podium" <?php if ($chat['Scheduler'] == 'podium') echo 'selected'; ?>>Podium</option>
                                    <option value="service_titan" <?php if ($chat['Scheduler'] == 'service_titan') echo 'selected'; ?>>Service Titan</option>
                                    <option value="schedule_engine" <?php if ($chat['Scheduler'] == 'schedule_engine') echo 'selected'; ?>>Schedule Engine</option>
                                    <option value="others" <?php if ($chat['Scheduler'] == 'others') echo 'selected'; ?>>Others</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3" id="chat_id">
                            <div class="col-3"><label>API KEY (ID) </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['id']; ?>" placeholder="Enter ID " name="chat_id" />
                            </div>
                        </div>
                        
                        <div id="chat_scheduler_info">
                            <div class="row">
                            <div class="col-3"><label>Initial Message </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['initial_message']; ?>" placeholder="Enter Initial Message " name="chat_scheduler_init" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Logo URL </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['logo_url']; ?>" placeholder="Enter Logo URL " name="chat_scheduler_logo" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Title </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['title']; ?>" placeholder="Enter Title " name="chat_scheduler_title" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Auto Open </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['auto_open']; ?>" placeholder="Enter Auto Open " name="chat_scheduler_open" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Auto Open Mobile </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['auto_open_mobile']; ?>" placeholder="Enter Auto Open Mobile " name="chat_scheduler_mobile" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Position </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['position']; ?>" placeholder="Enter Position " name="chat_scheduler_position" />
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="col-3"><label>Button Text </label></div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="<?=$chat['schedule_engine_info']['button_text']; ?>" placeholder="Enter Button Text " name="chat_scheduler_button" />
                            </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3" id="chat_script">
                            <div class="col-3"><label>JS Script </label></div>
                            <div class="col-4">
                                <textarea  rows="6" cols="70"  name="chat_script" placeholder="Enter JS Script "><?=$chat['content']; ?></textarea>
                            </div>
                        </div>
                        

                    </div>
                    <!-- ... Other Chat Configuration Fields ... -->

                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="checkbox" id="scheduler-eanble-checkbox" class="form-control" value="true" placeholder="Enter order " name="scheduler_enable" / <?=$scheduler['enable'] ? "checked" : "uncheked"; ?>>
                            <label for="scheduler-eanble-checkbox"><b>Scheduler</b></label>
                        </div>
                        
                    </div>
                <div id="scheduler-enable-section" style="text-align: center;">
                            <div class="row mb-3">
                                <div class="col-3"><label>Position </label></div>
                                <div class="col-4">
                                    <select  class="form-select rds-select-variation" id="" name="scheduler_position">
                                        <option value="head_top" <?php if ($scheduler['position'] == 'head_top') echo 'selected'; ?>>Head Top</option>
                                        <option value="head_bottom" <?php if ($scheduler['position'] == 'head_bottom') echo 'selected'; ?>>Head Bottom</option>
                                        <option value="footer_top" <?php if ($scheduler['position'] == 'footer_top') echo 'selected'; ?>>Footer Top</option>
                                        <option value="footer_bottom" <?php if ($scheduler['position'] == 'footer_bottom') echo 'selected'; ?>>Footer Bottom</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-3"><label>Select Scheduler </label></div>
                                <div class="col-4">
                                    <select  class="form-select rds-select-variation" id="rds-scheduler-variation" name="scheduler_scheduler">

                                        <option value="schedule_engine" <?php if ($scheduler['Scheduler'] == 'schedule_engine') echo 'selected'; ?>>Schedule Engine</option>
                                        <option value="service_titan" <?php if ($scheduler['Scheduler'] == 'service_titan') echo 'selected'; ?>>Service Titan</option>
                                        <option value="zocdoc" <?php if ($scheduler['Scheduler'] == 'zocdoc') echo 'selected'; ?>>Zocdoc</option>
                                        <option value="nexhealth" <?php if ($scheduler['Scheduler'] == 'nexhealth') echo 'selected'; ?>>Nexhealth</option>
                                        <option value="clearwave" <?php if ($scheduler['Scheduler'] == 'clearwave') echo 'selected'; ?>>Clearwave</option>
                                        <option value="others" <?php if ($scheduler['Scheduler'] == 'others') echo 'selected'; ?>>Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3" id="scheduler_id">
                                <div class="col-3"><label>ID </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$scheduler['id']; ?>" placeholder="Enter ID " name="scheduler_id" />
                                </div>
                            </div>
                            
                            <div class="row mb-3" id="scheduler_script">
                                <div class="col-3"><label>JS Script </label></div>
                                <div class="col-4">
                                    <textarea  rows="6" cols="70"  name="scheduler_script" placeholder="Enter JS Script "><?=$scheduler['content']; ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3" id="zocdoc_id">
                                <div class="col-3"><label>ID </label></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="<?=$scheduler['zocdoc_content']; ?>" placeholder="Enter ID " name="zocdoc_id" />
                                </div>
                            </div>

                            <div class="row mb-3" id="nexhealth_id">
                                <div class="col-3"><label>Nexhealth Script </label></div>
                                <div class="col-4">
                                    <textarea  rows="6" cols="70"  name="nexhealth_id" placeholder="Enter JS Script "><?=$scheduler['nexhealth_content']; ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3" id="clearwave_id">
                                <div class="col-3"><label>Clearwave Script </label></div>
                                <div class="col-4">
                                    <textarea  rows="6" cols="70"  name="clearwave_id" placeholder="Enter JS Script "><?=$scheduler['clearwave_content']; ?></textarea>
                                </div>
                            </div>
                            

                        </div>

                            

                    <!-- Submit Button for Chat, Tracking, and Service Area -->
                    <button type="submit"  class="save-change-btn google-save-changes btn btn-primary mt-3" name="rdschatserviceconfig">Save Changes</button>
                    <!-- <div id="GoogleFormMessage" style="display:none; color:red;">Kindly complete all mandatory fields within the Google Ads Convertion section before proceeding.</div> -->

                </div>
            </form>
            <script>
                jQuery(document).ready(function($) {
                    $(".logButton").click(function(e) {
                        e.preventDefault();
                        
                        $('#tableSection').toggle();
                        if ($('#tableSection').is(':visible')) {
                            $('#tableSection').hide();
                            $('#loader').show();
                            $.ajax({
                                url: ajax_object.ajax_url,
                                type: 'POST',
                                data: {
                                    action: 'get_tracking_data',
                                    name: 'accessibility'
                                },
                                beforeSend: function() {
                                    $('#loader').show();
                                },
                                success: function(response) {
                                    $('#loader').hide();
                                    $('#tableSection').show();
                                    $('#tableSection').html(response);
                                },
                                error: function(xhr, status, error) {
                                    $('#loader').hide();
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });
                </script>
            <?php
            // $keys = array_keys($array);
            // $keyName = $keys[9];
            // // $keys = array_keys($array['tracking']);
            // // $keyName = $keys[4];
            // $accessibility_data = get_rds_tracking_data($keyName);
            // if ($accessibility_data) {
            //     echo '<h2>RDS Accessibility Data</h2>';
            //     echo '<table border=1>';
            //     $srl_no = 1;
            //     foreach ($accessibility_data as $data) {
            //         $data_array = json_decode($data['data'], true);
            //         if( $srl_no < 2){
            //         echo '<tr>';
            //         echo '<th>S.no.</th>';
                    
            //         foreach ($data_array as $key => $value) {
            //             echo '<th>' . ucfirst($key) . '</th>';
            //         }
            //         echo '<th>Date</th>';
            //         echo '</tr>';
            //          }
            //         echo '<tr>';
            //         echo '<td>'. $srl_no.'</td>';
            //         foreach ($data_array as $key => $value) {
            //                 echo '<td>'.(is_bool($value) ? ($value ? 'true' : 'false') : $value).'</td>';
            //         }
            //         echo '<td>' . date("m/d/Y H:i:s T", strtotime($data['date'])) . '</td>';
            //         echo '</tr>';
            //         $srl_no++;
            //     }
            //     echo '</table>';
            // }
            ?>

           
