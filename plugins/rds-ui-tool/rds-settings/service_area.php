
<?php 
$array = rds_template();
            $service_areas = $array['globals']['footer']['service_areas'];

            if (isset($_POST['rdsserviceareaconfigNonce']) && wp_verify_nonce($_POST['rdsserviceareaconfigNonce'], 'rdsserviceareaconfigNonce')) {

            $array['globals']['footer']['enable'] = isset($_POST['service_areas_enable']) ? true : false;

            // Check if the enable status is false but retain existing service_areas data
            if ($_POST['service_areas_enable'] == false) {
                $array['globals']['footer']['enable'] = false; // Set the enable status to false
            } else {
                if (isset($_POST['service_area_ids']) && !empty($_POST['service_area_ids'])) {
                    $i = 0;
                    $array['globals']['footer']['service_areas'] = array();
                    foreach ($_POST['service_area_ids'] as $page_ids) {
                        if (empty($page_ids['page_ids']) || empty($page_ids['location_ids'])) {
                            unset($array['globals']['footer']['service_areas'][$i]);
                        } else {
                            $array['globals']['footer']['service_areas'][$i]['page_ids'] = isset($page_ids['page_ids']) ? $page_ids['page_ids'] : 0;
                            $array['globals']['footer']['service_areas'][$i]['location_ids'] = isset($page_ids['location_ids']) ? $page_ids['location_ids'] : 0;
                        }
                        $i++;
                    }
                }
            }

            $update = rds_update_template_option_add_mongo_log($array);
            if ($update) {
                // Set session Name
                $_SESSION["service_areas_config"] = "service_areas_config";
                $_SESSION["service_areas_config_time_stamp"] = time();
                wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=service-area"));
                exit();
            }
        }

            
            /*if (isset($_POST['rdsserviceareaconfigNonce']) && wp_verify_nonce($_POST['rdsserviceareaconfigNonce'], 'rdsserviceareaconfigNonce')) {

                $array['globals']['footer']['enable'] = isset($_POST['service_areas_enable']) ? true : false;
                if ($_POST['service_areas_enable'] == false) {
                         $array['globals']['footer']['service_areas'] = array();
                }else{
                if (isset($_POST['service_area_ids']) && !empty($_POST['service_area_ids'])) {
                    $i = 0;
                    $array['globals']['footer']['service_areas'] = array();
                    foreach ($_POST['service_area_ids'] as $page_ids) {
                        if (empty($page_ids['page_ids']) || empty($page_ids['location_ids'])){
                            unset($array['globals']['footer']['service_areas'][$i]); 
                        }else{
                        $array['globals']['footer']['service_areas'][$i]['page_ids'] = isset($page_ids['page_ids']) ? $page_ids['page_ids'] : 0;
                        $array['globals']['footer']['service_areas'][$i]['location_ids'] = isset($page_ids['location_ids']) ? $page_ids['location_ids'] : 0;
                    }
                        $i++;
                    }
                }
                }
                $update = rds_update_template_option_add_mongo_log($array);
                if ($update) {
                    //Set session Name
                    $_SESSION["service_areas_config"] = "service_areas_config";
                    $_SESSION["service_areas_config_time_stamp"] = time();
                    wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=service-area"));
                    exit();
                }
            }*/
            $status = isset($_SESSION['service_areas_config']) ? $_SESSION['service_areas_config'] : '';
            $inactive = 1;
            if ($status === 'service_areas_config') {
                echo "<h5 style='color: green;'>Service Area Configuration  Updated </h5>";
                // destroy session
                $time = isset($_SESSION['service_areas_config_time_stamp']) ? $_SESSION['service_areas_config_time_stamp'] : 0;
                $session_life = time() - $time;
                if ($session_life > $inactive) {
                    session_destroy();
                }
            }
            $pages = get_pages();
            ?>
            <style>
                input[type=checkbox], input[type=radio] {
                    margin: 0.25rem 0.50rem 0 0 !important;
                }
            </style>
            <form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='' id="form-sevice">
                <input type="hidden" name="rdsserviceareaconfigNonce"   value="<?= wp_create_nonce('rdsserviceareaconfigNonce') ?>"/>
                <div class="container mt-3">
                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="checkbox" id="reviews-eanble-checkbox" class="form-control" value="true" placeholder="Enter finance page enable " name="service_areas_enable"  <?= $array['globals']['footer']['enable'] ? "checked" : "uncheked"; ?>>

                        <label for="reviews-eanble-checkbox"><b>Enable Service Area</b></label>
                        </div>
                    </div>
                    <!-- <div class="row">

                            
                        
                    </div> -->
                    <div id="reviews-enable-section">
                        <div class="container-add-more">
                            <?php
                            $m = 0;
                            
                            if (!empty($service_areas)) {
                                foreach ($service_areas as $area) {

                                    if (!empty($area['location_ids'])) {

                                        ?>

                                        <div class="after-add-more-service-area mt-4">  
                                        <div class="row">
                                        <div class="col-5">
                                        <div class="row rds-page-location">
                                            <div class="col-12 mb-3"><label><b>SELECT PAGE</b></label></div>
                                            <div class="col-12">
                                                <div class="dropdown show ">
                                                    <ul class="dropdown-menu rdsMatchPageName 123"  style="max-height: 384.612px; overflow: hidden; position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform; ">
                                                        <input type="serach" value="" class="form-control rdsSearchThePageId" placeholder="Search Ids"/>
                                                        <div  style="max-height: 485.388px; overflow-y: auto;">                                                       
                                                            <?php
                                                            $p_selected = array();
                                                            foreach ($pages as $location) {
                                                                if (!empty($area['page_ids']) && in_array($location->ID, $area['page_ids'])) {
                                                                    $p_selected[]['name'] = get_the_title($location->ID);
                                                                    $p_selected[]['id'] = $location->ID;
                                                                    echo ' <li class="dropdown-item rdsPageName" style="cursor:pointer; font-size: 14px;"><label><input   name="service_area_ids[' . $m . '][page_ids][]" type="radio" value="' . $location->ID . '" checked class="service_area_page_ids service_area_p_ids" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '"> ' . $location->post_title .'('.$location->ID .') </li></label>';
                                                                } else {
                                                                    echo ' <li class="dropdown-item rdsPageName" style="cursor:pointer; font-size: 14px;"><label><input name="service_area_ids[' . $m . '][page_ids][]"  type="radio" value="' . $location->ID . '" class="service_area_page_ids service_area_p_ids" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '"> ' . $location->post_title .'('.$location->ID .')</li></label>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </ul>
                                                    <button type="button" class="btn btn-secondary dropdown-toggle rds_selected_service_area page-title-class"  role="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="word-wrap: break-word; max-width:400px">
                                                        <?php  if (!empty($p_selected[0]['name'])){
                                                          
                                                        echo $p_selected[0]['name']; }?>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <br/> 
                                        <div class="col-7">
                                        <div class="row">
                                            <div class="col-12 mb-3"><label><b>SELECT SERVICE AREA PAGES</b></label></div>
                                            <div class="col-9">
                                                <div class="dropdown show ">
                                                    <ul class="dropdown-menu  rdsMatchPageName 123456"  style="max-height: 384.612px; overflow: hidden; min-height: 158px; min-width: 260px; position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform; ">
                                                        <input type="serach" value="" class="form-control rdsSearchThePageId" placeholder="Search Ids"/>
                                                        <div  style="max-height: 485.388px; overflow-y: auto; min-height: 96px;">                                                       
                                                            <?php
                                                            $l_selected = array();
                                                             
                                                            foreach ($pages as $location) {
                                                                // echo $location->ID;
                                                                if (!empty(get_post_meta($location->ID, 'location', TRUE))) {
                                                                 
                                                                
                                                                if ( !empty($area['location_ids']) && in_array($location->ID, $area['location_ids'])) {
                                                                    $l_selected[] = get_the_title($location->ID);
                                                                  
                                                                    echo ' <li class="dropdown-item rdsPageName" style="cursor:pointer; font-size: 14px;"><label><input  name="service_area_ids[' . $m . '][location_ids][]" type="checkbox" value="' . $location->ID . '" checked class="service_area_page_ids service_area_l_ids" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '" > ' . $location->post_title .'('.$location->ID .')</label></li>';
                                                                } else {
                                                                    echo ' <li class="dropdown-item rdsPageName" style="cursor:pointer; font-size: 14px;"><label><input  name="service_area_ids[' . $m . '][location_ids][]" type="checkbox" value="' . $location->ID . '" class="service_area_page_ids service_area_l_ids" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '" > ' . $location->post_title .'('.$location->ID .') </label></li>';
                                                                }
                                                            }
                                                            }
                                                            ?>
                                                        </div>
                                                    </ul>
                                                    <button type="button" class="btn btn-secondary dropdown-toggle rds_selected_service_area service-title-class"  role="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="word-wrap: break-word;">
                                                        <?php if (!empty($l_selected)){  ?>
                                                        <ul style="padding-left: 0rem;" class="mb-0">
                                                         <?php foreach ($pages as $location) {
                                                                if ( !empty($area['location_ids']) && in_array($location->ID, $area['location_ids'])) {
                                                                    $l_selected['name'][] = get_the_title($location->ID);
                                                                    $l_selected['id'][] = $location->ID;
                                                                    echo ' <li style="text-align: left;" class="mb-0">'.get_the_title($location->ID).'</li>';
                                                              }
                                                          }
                                                            ?>
                                                        </ul>
                                                    <?php }else{
                                                        echo "<label>SELECT SERVICE AREA PAGES</label>";
                                                    } ?>
                                                      
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-3 change text-end">
                                                <button type="button" class="btn btn-danger remove" >- Remove</button>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                    </div>

                                        <?php
                                    }    

                                    ?>
                                    
                                    <?php
                                    $m++;
                                }
                                
                            } else {
                                
                                ?>
                                <div class="after-add-more-service-area mt-4">  
                                    <div  class="row">
                                    <div  class="col-5">
                                    <div class="row rds-page-location">
                                        <div class="col-12 mb-3"><label>SELECT PAGE</label></div>
                                        <div class="col-12">
                                            <div class="dropdown show ">
                                                <ul class="dropdown-menu rdsMatchPageName 123456789"  style="max-height: 384.612px; overflow: hidden; min-width: 260px; position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform; ">
                                                    <input type="serach" value="" class="form-control rdsSearchThePageId" placeholder="Search Ids"/>
                                                    <div  style="max-height: 485.388px; overflow-y: auto;">                                                       
                                                        <?php
                                                        $p_selected = array();
                                                        foreach ($pages as $location) {
                                                            echo ' <li class="dropdown-item rdsPageName" style="cursor:pointer; font-size: 14px;"><input name="service_area_ids[' . $m . '][page_ids][]" type="radio" id="page' . $location->ID . '" value="' . $location->ID . '" class="service_area_page_ids service_area_p_ids m-0" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '"><label for="page' . $location->ID . '" style=" padding-left: 10px; width: 100%; "> ' . $location->post_title .' ('. $location->ID .')'.'</label></li>';
                                                        }
                                                        ?>
                                                    </div>
                                                </ul>
                                                <button type="button" class="btn btn-secondary dropdown-toggle rds_selected_service_area page-title-class"  role="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="word-wrap: break-word; max-width:400px">PAGE TITLE</button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <br/> 
                                    <div  class="col-7">
                                    <div class="row">
                                        <div class="col-12 mb-3"><label>SELECT SERVICE AREA PAGES</label></div>
                                        <div class="col-9">
                                            <div class="dropdown show ">
                                                <ul class="dropdown-menu  rdsMatchPageName"  style="max-height: 384.612px; overflow: hidden; min-height: 158px; min-width: 467px; position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform; ">
                                                    <input type="serach" value="" class="form-control rdsSearchThePageId" placeholder="Search Ids"/>
                                                    <div  style="max-height: 485.388px; overflow-y: auto; min-height: 96px;">                                                       
                                                        <?php
                                                        $l_selected = array();
                                                        foreach ($pages as $location) {
                                                             if (!empty(get_post_meta($location->ID, 'location', TRUE))) {
                                                            echo ' <li class="dropdown-item rdsPageName" data-checkbox-id="checkbox1" style="cursor:pointer; font-size: 14px;" ><input name="service_area_ids[' . $m . '][location_ids][]" type="checkbox" id="checkbox'.$location->ID.'" value="' . $location->ID . '" class="service_area_page_ids service_area_l_ids m-0" data-title="' . $location->post_title . '" data-page-id="' . $location->ID . '" ><label for="checkbox'.$location->ID.'" style=" padding-left: 10px; width: 100%; "> ' . $location->post_title .' ('. $location->ID .')'.'</label></li>';
                                                        }
                                                    }
                                                        ?>


                                                    </div>
                                                </ul>
                                                <button type="button" class="btn btn-secondary dropdown-toggle rds_selected_service_area service-title-class"  role="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="word-wrap: break-word; max-width:400px">SERVICE AREA PAGE TITLE</button>
                                            </div>
                                        </div>
                                        <div class="col-3 change">
                                            <button type="button" class="btn btn-danger remove" >- Remove</button>
                                        </div>
                                    </div> 
                                    </div>
                                    </div>

                                </div>
                                <?php
                            }
                            ?>
                            <div class="row add-change-btn">
                                <div class="col-12 change  text-end mt-4">
                                    <button type="button" class="btn btn-info add-more-service-area copy" >Copy</button>
                                    <button type="button" class="btn btn-info add-more-service-area add-new-button" >+ Add New Page</button>

                                </div>
                            </div>
                          <!--   <div class="row add-change-btn">
                                <div class="col-12 change  text-end mt-4">
                                    <button type="button" class="btn btn-info add-more copy" >Copy</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <button type="button" style="display:none;" class=" btn btn-primary mt-3" disabled>Save changes</button><button type="submit" class=" btn btn-primary mt-3 sevice-equire">Save changes</button>
                </div>  
            </form>