<?php 
 
function processTemplateData($body, $spec_name) 
{ 
 
    session_start(); 
    $importErrorMessage = ''; 
    global $wpdb; 
    $tableName = $wpdb->prefix . 'options'; 
    try { 
 
    if (json_validator($body) == false) { 
        $msg.= ucfirst($spec_name) . ' JSON is not valid. Please check the valid Spec file and refresh the page.'; 
        exit(); 
    } 
    // Insert or update records 
    $query = "Select * from " . $tableName . " where option_name = 'rds_template'"; 
    $queryResults = $wpdb->get_results($query); 
    $queryDate = "Select * from " . $tableName . " where option_name = 'rds_template_date'"; 
    $queryDateResults = $wpdb->get_results($queryDate); 
    $formatted_date = date("m/d/Y h:m:s T"); // For "Mm/dd/yyyy hh:mm:ss TMZ" 
    if (empty($queryResults)) { 
        $result = $wpdb->insert($tableName, array('option_value' => $body, 'option_name' => 'rds_template')); 
 
        $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_template_date')); 
 
        $msg .= ucfirst($spec_name) . ' Record Inserted'; 
    } else { 
        $result = $wpdb->update($tableName, array('option_value' => $body), array('option_name' => 'rds_template')); 
        if (empty($queryDateResults)) { 
            $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_template_date')); 
        } else { 
            $result_date = $wpdb->update($tableName, array('option_value' => $formatted_date), array('option_name' => 'rds_template_date')); 
        } 
 
        $msg .= ucfirst($spec_name) . ' Updated.'; 
    } 
    $template_arr = json_decode($body, true); 
    togglePages($template_arr); 
    /*if(isset($template_arr['globals']['testimonial']['data']) && is_array($template_arr['globals']['testimonial']['data'])){ 
        foreach (array_reverse($template_arr['globals']['testimonial']['data']) as $value) { 
            $testimonial_heading = $value['city']; 
            if (!empty($value['state']) && !empty($value['city'])) { 
                $testimonial_heading = $value['city'] . ", " . $value['state']; 
            } elseif (empty($value['state']) && !empty($value['city'])) { 
                $testimonial_heading = $value['city']; 
            } elseif (!empty($value['state']) && empty($value['city'])) { 
                $testimonial_heading = $value['state']; 
            } 
 
            $args = array( 
                'post_title' => $value['name'], 
                'post_status' => 'publish', 
                'post_type' => 'bc_testimonials', 
                'post_author' => get_current_user_id(), 
                'meta_input' => array( 
                    'testimonial_name' => $value['name'], 
                    'testimonial_city' => $value['city'], 
                    'testimonial_state' => $value['state'], 
                    'testimonial_title' => $value['title'], 
                    'testimonial_message' => $value['description'], 
                    'testimonial_heading' => $testimonial_heading, 
                    'testimonial_custom_image' => '#' 
                ) 
            ); 
             
            $check_if_post_exits = get_page_by_title($value['name'], 'OBJECT', 'bc_testimonials'); 
            if (isset($check_if_post_exits->post_title) && !empty($check_if_post_exits->post_title) && $check_if_post_exits->post_title == $value['name']) { 
                echo "update"; 
                $args['ID'] = $check_if_post_exits->ID; 
                $postId = wp_update_post($args); 
            } else if (isset($value['name']) && !empty($value['name']) && empty($value['post_id'])) { 
                $postId = wp_insert_post($args); 
            } 
 
             
            $testimonial_arr = array(); 
             
                foreach ($value['category'] as $category_value) { 
                    $term_id = term_exists($category_value, 'bc_testimonial_category'); 
                    if (empty($term_id)) { 
                        $term_id = wp_insert_term($category_value, 'bc_testimonial_category'); 
                    } 
                    array_push($testimonial_arr, $term_id['term_id']); 
                } 
                wp_set_post_terms($postId, $testimonial_arr, 'bc_testimonial_category'); 
                $testimonial_categry = get_the_terms($postId, 'bc_testimonial_category'); 
                $testimonial_cat_array = array(); 
                if (!empty($testimonial_categry)) { 
                    foreach ($testimonial_categry as $pcat) { 
                        $testimonial_cat_array[] = $pcat->name; 
                    } 
                } 
 
                $template_arr['globals']['testimonial']['data'][$i]['name'] = get_the_title($postId); 
                $template_arr['globals']['testimonial']['data'][$i]['post_id'] = $postId; 
                $template_arr['globals']['testimonial']['data'][$i]['city'] = get_post_meta($postId, 'testimonial_city', true); 
                $template_arr['globals']['testimonial']['data'][$i]['state'] = get_post_meta($postId, 'testimonial_state', true); 
                $template_arr['globals']['testimonial']['data'][$i]['description'] = get_post_meta($postId, 'testimonial_message', true); 
                $template_arr['globals']['testimonial']['data'][$i]['category'] = $testimonial_cat_array; 
                $i++; 
 
                // print_r($testimonial_cat_array); 
        } 
    } 
    */ 
    //Insert testimonila Start 
    foreach (array_reverse($template_arr['globals']['testimonial']['data']) as $value) { 
        $testimonial_heading = $value['city']; 
        if (!empty($value['state']) && !empty($value['city'])) { 
            $testimonial_heading = $value['city'] . ", " . $value['state']; 
        } elseif (empty($value['state']) && !empty($value['city'])) { 
            $testimonial_heading = $value['city']; 
        } elseif (!empty($value['state']) && empty($value['city'])) { 
            $testimonial_heading = $value['state']; 
        } 
        $args = array('post_title' => $value['name'], 'post_status' => 'publish', 'post_type' => 'bc_testimonials', 'post_author' => get_current_user_id(), 'meta_input' => array('testimonial_name' => $value['name'], 'testimonial_title' => $value['title'], 'testimonial_message' => $value['description'], 'testimonial_heading' => $testimonial_heading, 'testimonial_custom_image' => '#')); 
        $check_if_post_exits = get_page_by_title($value['name'], 'OBJECT', 'bc_testimonials'); 
        if (isset($check_if_post_exits->post_title) && !empty($check_if_post_exits->post_title) && $check_if_post_exits->post_title == $value['name']) { 
            $args['ID'] = $check_if_post_exits->ID; 
            wp_update_post($args); 
        } else if (isset($value['name']) && !empty($value['name'])) { 
            wp_insert_post($args); 
        } 
    } 
    //Insert testimonila End 
    //Insert Promotion Start 
    $args_coupons = array('post_type' => 'bc_promotions', 'posts_per_page' => - 1); 
    $arr_coupon_unique_id = array(); 
    $query_coupon = new WP_Query($args_coupons); 
    if ($query_coupon->have_posts()): 
        while ($query_coupon->have_posts()): 
            $query_coupon->the_post(); 
            $coupon_unique_id = get_post_meta(get_the_ID(), 'promotion_unique_id', TRUE); 
            $arr_coupon_unique_id[$coupon_unique_id] = get_the_ID(); 
        endwhile; 
        wp_reset_query(); 
    endif; 
    $p = 0; 
    if (isset($template_arr['globals']['promotion']['items']) && is_array($template_arr['globals']['promotion']['items'])) { 
        $expiredPromotions = []; 
        $expiredPromotionTitles = []; 
        foreach (array_reverse($template_arr['globals']['promotion']['items']) as $value) { 
            $current_date = date("m/d/Y", strtotime(date("m/d/Y"))); 
            $exp_date = strtotime($value['expiry_date']); 
            $current_date_timestamp = strtotime($current_date); 
            if ($exp_date < $current_date_timestamp) { 
                $expiredPromotions[] = $value['title']; 
                $expiredPromotionTitles[] = $value['title']; 
                continue; 
            } 
            /*if ($exp_date < $current_date_timestamp) { 
                
                $expiredPromotions[] = $value['title']; 
                $_SESSION["promotion_error"] = "<h3 style='color: red; font-size: 13px; margin-top: 5px;'>Could not import " . $value['title'] . " promotion as it had an expiry date in the past.Please check the file and try again.</h3>"; 
                // echo "<h3 style='color: red;'>Could not import " . $value['title'] . " promotion as it had an expiry date in the past.Please check the file and try again.</h3>"; 
                continue; 
            }*/ 
            if ($value['last_date_of_month']) { 
                $value['expiry_date'] = date("m/t/Y", strtotime(date("m/d/Y"))); 
            } 
            $args_promotion = array('post_title' => $value['title'], 'post_status' => 'publish', 'post_type' => 'bc_promotions', 'post_author' => get_current_user_id(), 'meta_input' => array('promotion_title1' => $value['title'], 'promotion_color' => $value['background_color_code'], 'promotion_expiry_date1' => $value['expiry_date'], 'promotion_subheading' => $value['subheading'], 'request_button_title' => $value['button_label'], 'request_button_link' => $value['button_link'], 'promotion_heading' => $value['heading'], 'promotion_more_info' => $value['more_info'], 'promotion_footer_heading' => $value['disclaimer'], 'promotion_open_new_tab' => $value['open_new_tab'], 'promotion_expiry_enddate' => $value['last_date_of_month'], 'promotion_default_checkbox' => true, 'promotion_recurring_setting' => $value['auto_renew'], 'promotion_show_banner_setting' => $value['show_in_banner'], 'promotion_noexpiry' => $value['no_expiry'], 'promotion_type' => 'Builder', 
            //                            'promotion_unique_id' => $value['unique_id'] 
            )); 
            //                    $check_if_promotion_exits = get_page_by_title($value['title'], 'OBJECT', 'bc_promotions'); 
            if (isset($value['post_id']) && !empty($value['post_id']) && get_post($value['post_id'])) { 
                $args_promotion['ID'] = intval($value['post_id']); 
                $postId = wp_update_post($args_promotion); 
            } else if (isset($value['title']) && !empty($value['title']) && empty($value['post_id'])) { 
                $postId = wp_insert_post($args_promotion); 
            } elseif (isset($value['post_id']) && !empty($value['post_id']) && !get_post($value['post_id'])) { 
                $postId = wp_insert_post($args_promotion); 
            } 
            $taxonomy_arr = array(); 
            //create taxonomy 
            if (empty($value['category'])) { 
                // Set default category to "all" 
                $category_value = 'all'; 
                 
                // Check if the term exists 
                $term_id = term_exists($category_value, 'bc_promotion_category'); 
                 
                // If the term doesn't exist, create it 
                if (empty($term_id)) { 
                    $term_id = wp_insert_term($category_value, 'bc_promotion_category'); 
                } 
                 
                // Add the term ID to the taxonomy array 
                array_push($taxonomy_arr, $term_id['term_id']); 
            } else { 
                // Category array is not empty 
                foreach ($value['category'] as $category_value) { 
                    $term_id = term_exists($category_value, 'bc_promotion_category'); 
                     
                    if (empty($term_id)) { 
                        $term_id = wp_insert_term($category_value, 'bc_promotion_category'); 
                    } 
                     
                    array_push($taxonomy_arr, $term_id['term_id']); 
                } 
            } 
            wp_set_post_terms($postId, $taxonomy_arr, 'bc_promotion_category'); 
            $pr_categry = get_the_terms($postId, 'bc_promotion_category'); 
            $pr_cat_array = array(); 
            if (!empty($pr_categry)) { 
                foreach ($pr_categry as $pcat) { 
                    $pr_cat_array[] = $pcat->name; 
                } 
            } 
            $template_arr['globals']['promotion']['items'][$p]['title'] = get_the_title($postId); 
            $template_arr['globals']['promotion']['items'][$p]['post_id'] = $postId; 
            $template_arr['globals']['promotion']['items'][$p]['heading'] = get_post_meta($postId, 'promotion_heading', true); 
            $template_arr['globals']['promotion']['items'][$p]['subheading'] = get_post_meta($postId, 'promotion_subheading', true); 
            $template_arr['globals']['promotion']['items'][$p]['button_label'] = get_post_meta($postId, 'request_button_title', true); 
            $template_arr['globals']['promotion']['items'][$p]['button_link'] = get_post_meta($postId, 'request_button_link', true); 
            $template_arr['globals']['promotion']['items'][$p]['background_color_code'] = get_post_meta($postId, 'promotion_color', true); 
            $template_arr['globals']['promotion']['items'][$p]['expiry_date'] = get_post_meta($postId, 'promotion_expiry_date1', true); 
            $template_arr['globals']['promotion']['items'][$p]['last_date_of_month'] = get_post_meta($postId, 'promotion_expiry_enddate', true); 
            $template_arr['globals']['promotion']['items'][$p]['open_new_tab'] = get_post_meta($postId, 'promotion_open_new_tab', true); 
            $template_arr['globals']['promotion']['items'][$p]['auto_renew'] = get_post_meta($postId, 'promotion_recurring_setting', true); 
            $template_arr['globals']['promotion']['items'][$p]['no_expiry'] = get_post_meta($postId, 'promotion_noexpiry', true); 
            $template_arr['globals']['promotion']['items'][$p]['show_in_banner'] = get_post_meta($postId, 'promotion_show_banner_setting', true); 
            $template_arr['globals']['promotion']['items'][$p]['disclaimer'] = get_post_meta($postId, 'promotion_footer_heading', true); 
            $template_arr['globals']['promotion']['items'][$p]['more_info'] = get_post_meta($postId, 'promotion_more_info', true); 
            $template_arr['globals']['promotion']['items'][$p]['category'] = $pr_cat_array; 
            $p++; 
        } 
        if (!empty($expiredPromotions)) { 
            $expiredPromotionCount = count($expiredPromotions); 
            $errorMessage = "<h3 style='color: red; font-size: 13px; margin-top: 5px;'>Could not import "; 
 
            if ($expiredPromotionCount === 1) { 
                $errorMessage .= implode(', ', $expiredPromotionTitles) . " promotion as it had expired in the past.</h3>"; 
            } else { 
                $lastItem = array_pop($expiredPromotionTitles); 
                $errorMessage .= implode(', ', $expiredPromotionTitles) . ", and " . $lastItem . " promotions as they had expired in the past.</h3>"; 
            } 
 
            $_SESSION["promotion_error"] = $errorMessage; 
        } 
    } 
    $x = 0; 
    $_arr = array(); 
    $dups = array(); 
    $mongo_promotion = mongodbAPI('GET', 'feature', NULL); 
    $mongo_promotion = json_decode($mongo_promotion, true); 
    if (isset($template_arr['globals']['promotion']['items']) && is_array($template_arr['globals']['promotion']['items'])) { 
        foreach (array_reverse($template_arr['globals']['promotion']['items']) as $value) { 
            if (!in_array($value['post_id'], $dups)) { 
                $pr_categry = get_the_terms($value['post_id'], 'bc_promotion_category'); 
                $pr_cat_array = array(); 
                if (!empty($pr_categry)) { 
                    foreach ($pr_categry as $pcat) { 
                        $pr_cat_array[] = $pcat->name; 
                    } 
                } 
                $current_user = wp_get_current_user(); 
                $dups[] = $value['post_id']; 
                $mongo_post_id = isset($mongo_promotion['globals']['promotion']['items'][$x]['post_id']) ? $mongo_promotion['globals']['promotion']['items'][$x]['post_id'] : 0; 
                $mongo_post_id_key = isset($mongo_promotion['globals']['promotion']['items'][$x]['post_id']) ? array_search($value['post_id'], array_column($mongo_promotion['globals']['promotion']['items'], 'post_id')) : null; 
                if (!empty($mongo_post_id) && $mongo_post_id == $value['post_id'] && !$mongo_post_id_key) { 
                    $key = array_search($value['post_id'], array_column($mongo_promotion['globals']['promotion']['items'], 'post_id')); 
                    $created_user = $mongo_promotion['globals']['promotion']['items'][$key]['created_user']; 
                    $created_date = $mongo_promotion['globals']['promotion']['items'][$key]['created_date']; 
                    $modified_user = $current_user->user_login; 
                    $modified_date = date(get_option('date_format')); 
                } else { 
                    $created_user = $current_user->user_login; 
                    $created_date = date(get_option('date_format')); 
                    $modified_date = ""; 
                    $modified_user = ""; 
                } 
                $status = get_post_status($value['post_id']); 
                $_arr['globals']['promotion']['items'][$x]['created_user'] = $created_user; 
                $_arr['globals']['promotion']['items'][$x]['modified_user'] = $modified_user; 
                $_arr['globals']['promotion']['items'][$x]['created_date'] = $created_date; 
                $_arr['globals']['promotion']['items'][$x]['modified_date'] = $modified_date; 
                $_arr['globals']['promotion']['items'][$x]['status'] = $status; 
                $_arr['globals']['promotion']['items'][$x]['title'] = get_the_title($value['post_id']); 
                $_arr['globals']['promotion']['items'][$x]['post_id'] = $value['post_id']; 
                $_arr['globals']['promotion']['items'][$x]['heading'] = get_post_meta($value['post_id'], 'promotion_heading', true); 
                $_arr['globals']['promotion']['items'][$x]['subheading'] = get_post_meta($value['post_id'], 'promotion_subheading', true); 
                $_arr['globals']['promotion']['items'][$x]['button_label'] = get_post_meta($value['post_id'], 'request_button_title', true); 
                $_arr['globals']['promotion']['items'][$x]['button_link'] = get_post_meta($value['post_id'], 'request_button_link', true); 
                $_arr['globals']['promotion']['items'][$x]['background_color_code'] = get_post_meta($value['post_id'], 'promotion_color', true); 
                $_arr['globals']['promotion']['items'][$x]['expiry_date'] = get_post_meta($value['post_id'], 'promotion_expiry_date1', true); 
                $_arr['globals']['promotion']['items'][$x]['last_date_of_month'] = get_post_meta($value['post_id'], 'promotion_expiry_enddate', true); 
                $_arr['globals']['promotion']['items'][$x]['open_new_tab'] = get_post_meta($value['post_id'], 'promotion_open_new_tab', true); 
                $_arr['globals']['promotion']['items'][$x]['auto_renew'] = get_post_meta($value['post_id'], 'promotion_recurring_setting', true); 
                $_arr['globals']['promotion']['items'][$x]['no_expiry'] = get_post_meta($value['post_id'], 'promotion_noexpiry', true); 
                $_arr['globals']['promotion']['items'][$x]['show_in_banner'] = get_post_meta($value['post_id'], 'promotion_show_banner_setting', true); 
                $_arr['globals']['promotion']['items'][$x]['disclaimer'] = get_post_meta($value['post_id'], 'promotion_footer_heading', true); 
                $_arr['globals']['promotion']['items'][$x]['more_info'] = get_post_meta($value['post_id'], 'promotion_more_info', true); 
                $_arr['globals']['promotion']['items'][$x]['category'] = $pr_cat_array; 
                $x++; 
            } 
        } 
    }     
    $template_arr['globals']['promotion']['items'] = $_arr['globals']['promotion']['items']; 
    //Delete post if not exist in template spec file Start 
    $SQLquery = "SELECT $wpdb->posts.ID FROM $wpdb->posts WHERE $wpdb->posts.post_type = 'bc_promotions' AND ( ( $wpdb->posts.post_status = 'publish' ) OR ( $wpdb->posts.post_status = 'trash' ) OR ( $wpdb->posts.post_status = 'draft' )) "; 
    $promotion_ids = $wpdb->get_results($SQLquery, ARRAY_A); 
    foreach ($promotion_ids as $p_id) { 
        if (!in_array($p_id['ID'], $dups)) { 
            $wpdb->delete($wpdb->posts, array('id' => $p_id['ID'])); 
            $wpdb->delete($wpdb->postmeta, array('post_id' => $p_id['ID'])); 
            $wpdb->delete($wpdb->term_relationships, array('object_id' => $p_id['ID'])); 
        } 
    } 
    //Delete post if not exist in template spec file End 
    //Insert Team Post Start 
    function Generate_Featured_Image($image_url, $post_id) { 
        $upload_dir = wp_upload_dir(); 
        $image_data = file_get_contents($image_url); 
        $filename = basename($image_url); 
        if (wp_mkdir_p($upload_dir['path'])) { 
            $file = $upload_dir['path'] . '/' . $filename; 
        } else { 
            $file = $upload_dir['basedir'] . '/' . $filename; 
        } 
        file_put_contents($file, $image_data); 
        $wp_filetype = wp_check_filetype($filename, null); 
        $attachment = array('post_mime_type' => $wp_filetype['type'], 'post_title' => sanitize_file_name($filename), 'post_content' => '', 'post_status' => 'inherit'); 
        $attach_id = wp_insert_attachment($attachment, $file, $post_id); 
        require_once (ABSPATH . 'wp-admin/includes/image.php'); 
        $attach_data = wp_generate_attachment_metadata($attach_id, $file); 
        $res1 = wp_update_attachment_metadata($attach_id, $attach_data); 
        $res2 = set_post_thumbnail($post_id, $attach_id); 
    } 
    $i = 1; 
    $args_team = array('post_type' => 'bc_teams', 'posts_per_page' => - 1); 
    $arr_team_unique_id = array(); 
    $query_team = new WP_Query($args_team); 
    if ($query_team->have_posts()): 
        while ($query_team->have_posts()): 
            $query_team->the_post(); 
            $team_unique_id = get_post_meta(get_the_ID(), 'team_unique_id', TRUE); 
            $arr_team_unique_id[$team_unique_id] = get_the_ID(); 
        endwhile; 
        wp_reset_query(); 
    endif; 
    foreach (array_reverse($template_arr['page_templates']['team_page']['posts']) as $value) { 
        $args = array('post_title' => $value['title'], 'post_status' => 'publish', 'post_type' => 'bc_teams', 'post_content' => $value['content'], 'post_author' => get_current_user_id(), 'meta_input' => array('team_position' => $value['position'], 'team_unique_id' => $value['unique_id'])); 
        $post_id = ''; 
        if (isset($arr_team_unique_id[$value['unique_id']])) { 
            $args['ID'] = $arr_team_unique_id[$value['unique_id']]; 
            $post_id = wp_update_post($args); 
        } else if (isset($value['title']) && !empty($value['title'])) { 
            $post_id = wp_insert_post($args); 
        } 
        $attachments = get_attached_media('image', $post_id); 
        foreach ($attachments as $attachment) { 
            wp_delete_attachment($attachment->ID, false); 
        } 
        $team_image_png = get_theme_file_path('img/meet-the-team/team_member_' . $i . '.png'); 
        $team_image_webp = get_theme_file_path('img/meet-the-team/team_member_' . $i . '.webp'); 
        if (file_exists($team_image_png)) { 
            Generate_Featured_Image($team_image_png, $post_id); 
        } elseif (file_exists($team_image_webp)) { 
            Generate_Featured_Image($team_image_webp, $post_id); 
        } 
        $i++; 
    } 
    //Insert Team Post End 
    //Insert Postion Post Start 
    global $wpdb; 
    $table_name = $wpdb->prefix . 'posts'; 
    $post_type = 'bc_position'; 
    // Delete existing posts of the specified post type 
    $wpdb->delete($table_name, array('post_type' => $post_type)); 
    $template_positions = array_reverse($template_arr['page_templates']['career_page']['position']['posts']); 
    $current_user_id = get_current_user_id(); 
    foreach ($template_positions as $value) { 
        if (isset($value['title']) && !empty($value['title'])) { 
            $args = array('post_title' => $value['title'], 'post_status' => 'publish', 'post_type' => 'bc_position', 'post_content' => $value['content'], 'post_author' => $current_user_id, 'meta_input' => array('team_position' => $value['location'], 'team_custom_content' => $value['custom_content'],),); 
            $post_id = wp_insert_post($args); 
        } 
    } 
    //Insert Postion Post End 
    $json = str_replace("\/", "/", json_encode($template_arr, JSON_PRETTY_PRINT)); 
    $hide_users = $template_arr; 
    $l = 0; 
    foreach ($hide_users['globals']['promotion']['items'] as $user) { 
        unset($hide_users['globals']['promotion']['items'][$l]['created_user']); 
        unset($hide_users['globals']['promotion']['items'][$l]['modified_user']); 
        unset($hide_users['globals']['promotion']['items'][$l]['created_date']); 
        unset($hide_users['globals']['promotion']['items'][$l]['modified_date']); 
        unset($hide_users['globals']['promotion']['items'][$l]['status']); 
        $l++; 
    } 
    $json1 = str_replace("\/", "/", json_encode($hide_users, JSON_PRETTY_PRINT)); 
    $result = $wpdb->update($tableName, array('option_value' => $json1), array('option_name' => 'rds_template')); 
    require_once ('elementor/rds_template.php'); 
    // Example usage: 
    // insertOrUpdateRecord($wpdb, $tableName, 'rds_template_date', date("d/m/Y")); 
    // API call 
    mongodbAPI('POST', 'feature', json_encode($template_arr, JSON_PRETTY_PRINT)); 
    // echo $msg; 
 
    // echo $spec_name; 
    // echo "<br>"; 
    // echo "sdsdsds"; 
   /* if (!empty($importErrorMessage)) { 
        return $importErrorMessage; 
    }*/ 
 
    $_SESSION["feature_time_stamp"] = time(); 
 
    if ($spec_name == 'rds_template') { 
        return $msg; 
    } 
     
} 
 
catch(Exception $e) { 
    // Handle exceptions here 
    echo $e->getMessage(); 
    // Additional error handling logic can be added 
     
} 
} 
 
?>