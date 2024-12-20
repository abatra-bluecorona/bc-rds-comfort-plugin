<?php
function processNavigationData($body, $spec_name)
{
    global $wpdb;
    $tableName = $wpdb->prefix . 'options';
    $msg = "";

    try {
        // Your $body, $spec_name, $wpdb, $tableName, and other variables here.

        if (!rds_validateJson($body)) {
            throw new Exception(ucfirst($spec_name) . ' JSON is not valid. Please check the valid Spec file and refresh the page.');
        }

        $queryDate = "Select * from " . $tableName . " where option_name = 'rds_nav_date'";
        $queryDateResults = $wpdb->get_results($queryDate);
        $query = "Select * from " . $tableName . " where option_name = 'rds_nav_settings'";
        $queryResults = $wpdb->get_results($query);
        $formatted_date = date("m/d/Y h:m:s T");
        if (empty($queryResults)) {

            $result = $wpdb->insert($tableName, array('option_value' => $body, 'option_name' => 'rds_nav_settings'));
            $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_nav_date'));

            $msg .= ucfirst($spec_name) . ' Record Inserted';
        } else {
            $result = $wpdb->update($tableName, array('option_value' => $body), array('option_name' => 'rds_nav_settings'));
            if (empty($queryDateResults)) {
                $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_nav_date'));
            } else {
                $result_date = $wpdb->update($tableName, array('option_value' => $formatted_date), array('option_name' => 'rds_nav_date'));
            }
            $msg .= ucfirst($spec_name) . ' Updated.';
        }

        $template_arr = json_decode($body, TRUE);

        // Delete existing menus and create new ones
        foreach ($template_arr['nav'] as $value) {
            $name = $value['label'];

            // Delete existing menu
            $menu_exists = wp_get_nav_menu_object($name);

            $menu_items = wp_get_nav_menu_items($menu_exists->term_id);
           
            if ($menu_exists) {
               // wp_delete_nav_menu($menu_exists->term_id);
               // Example usage:
               $locations = get_nav_menu_locations();
               $locations['primary-menu'] = $menu_exists;
               set_theme_mod('nav_menu_locations', $locations);
               foreach ($menu_items as $menu_item) {
                wp_delete_post($menu_item->ID, true);
            }
               // Loop through each menu item and delete it               
               create_menu_item_recursive($menu_exists->term_id, $value['items']);
            }else{
                $menu_id = wp_create_nav_menu($name);

                // Set primary menu mobile/desktop
                $locations = get_nav_menu_locations();
                $locations['primary-menu'] = $menu_id;
                set_theme_mod('nav_menu_locations', $locations);
    
                if (isset($value['items'])) {
                    create_menu_item_recursive($menu_id, $value['items']);
                }
            }

            // Create new menu
           
        }

        // API call
        mongodbAPI('POST', 'nav_setting', $body);

        if ($spec_name == 'rds_nav_settings') {
            return $msg;
        }

    } catch (Exception $e) {
        // Handle exceptions here
        echo $e->getMessage();
        // Additional error handling logic can be added
    }
}

function create_menu_item_recursive($menu_id, $items, $parent_id = 0)
{
    foreach ($items as $item) {
        $custom = ($item['custom'] == true) ? $item['slug'] : home_url($item['slug']);
        $menu_item_args = array(
            'menu-item-title' => __($item['label']),
            'menu-item-url' => $custom,
            'menu-item-status' => 'publish',
            'menu-item-target' => $item['target'],
            'menu-item-parent-id' => $parent_id,
            'menu-item-classes' => $item['class']
        );
        $menu_item_id = wp_update_nav_menu_item($menu_id, 0, $menu_item_args);
        if (isset($item['items'])) {
            create_menu_item_recursive($menu_id, $item['items'], $menu_item_id);
        }
    }
}
?>