<?php 
 
global $wpdb; 
$tableNameg = $wpdb->prefix . 'postmeta'; 
$financepagetemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40844'"; 
$array = $wpdb->get_results($financepagetemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); // Convert to an associative array 
 
    foreach ($decodedArray as &$section) { 
        if ($section['elType'] !== 'section' || !isset($section['elements'])) { 
            continue; 
        } 
 
        foreach ($section['elements'] as &$element) { 
            if ( 
                $element['elType'] !== 'column' || 
                !isset($element['elements']) 
            ) { 
                continue; 
            } 
 
            foreach ($element['elements'] as &$widget) { 
                if ($widget['elType'] !== 'widget') { 
                    continue; 
                } 
 
                $settings = []; 
 
                switch ($widget['widgetType']) { 
                    case 'rds-global-financing-content-widget': 
                        $settings = [ 
                            'heading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'heading' 
                                ], 
                            'checkbox_value' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'enable' 
                                ], 
                            'subheading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'subheading' 
                                ], 
                            'button_text' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'button_text' 
                                ], 
                            'content' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'content' 
                                ], 
                                "target" => $hide_users['page_templates']['finance_page']['target'] 
                                ? 'yes' 
                                : "", 
                            'button_link' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'button_link' 
                                ],  
                                
                        ]; 
                        break; 
                    case 'rds-financing-affiliation-widget': 
                        if ( 
                            isset( 
                                $widget['settings'][ 
                                    'finance_affiliation_checkbox_value' 
                                ] 
                            ) 
                        ) { 
                            $settings[ 
                                'finance_affiliation_checkbox_value' 
                            ] = $hide_users['page_templates']['finance_page'][ 
                                'affiliation' 
                            ]['enable'] 
                                ? 'yes' 
                                : ''; 
                        } 
                        if ( 
                            isset( 
                                $widget['settings']['finance_affiliation_count'] 
                            ) 
                        ) { 
                            $settings['finance_affiliation_count'] = 
                                $hide_users['page_templates']['finance_page'][ 
                                    'affiliation' 
                                ]['count']; 
                        } 
                        if ( 
                            isset( 
                                $widget['settings'][ 
                                    'finance_affiliation_variation' 
                                ] 
                            ) 
                        ) { 
                            $settings['finance_affiliation_variation'] = 
                                $hide_users['page_templates']['finance_page'][ 
                                    'affiliation' 
                                ]['variation']; 
                        } 
                        break; 
                    case 'rds-financing-form-widget': 
                        $settings = [ 
                            'gravity_form_heading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'gravity_form_heading' 
                                ], 
                            'gravity_form_id' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'gravity_form_id' 
                                ], 
                        ]; 
                        break; 
                    case 'rds-financing-company-service-widget': 
                        $settings = [ 
                            'heading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['heading'], 
                            'subheading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['subheading'], 
                            'button_text' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['button_text'], 
                            'content' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['description_html_allowed'], 
                                "target" => $hide_users['page_templates']['finance_page']['company_services']['target'] 
                                ? 'yes' 
                                : "", 
                            'button_link' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['button_link'], 
                        ]; 
                        break; 
                    case 'rds-financing-middle-content-widget': 
                        $settings = [ 
                            'middle_content' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'middle_content' 
                                ]['content'], 
                        ]; 
                        break; 
                    case 'rds-accordion-widget': 
                        $rdsAccordionData = []; 
 
                        // Loop through the sample data and transform it 
                        foreach ( 
                            $hide_users['page_templates']['finance_page'][ 
                                'accordion' 
                            ] 
                            as $item 
                        ) { 
                            $rdsAccordionData[] = [ 
                                "item_title" => $item["question"], 
                                "item_content" => $item["content"], 
                                "_id" => uniqid(), // You can generate a unique ID here if needed 
                            ]; 
                        } 
 
                        // Set the transformed data to the widget's settings 
                        $widget['settings'][ 
                            'accordion_items' 
                        ] = $rdsAccordionData; 
                        break; 
                    default: 
                        break; 
                } 
 
                // Update widget settings 
                foreach ($settings as $key => $value) { 
                    $widget['settings'][$key] = $value; 
                } 
            } 
        } 
    } 
 
    // Encode the updated array and update the database 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40844] // Use the correct post_id here 
    ); 
} 
 
$historypagetemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41084'"; 
$array = $wpdb->get_results($historypagetemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); // Convert to an associative array 
 
    foreach ($decodedArray as &$section) { 
        if ($section['elType'] !== 'section' || !isset($section['elements'])) { 
            continue; 
        } 
 
        foreach ($section['elements'] as &$element) { 
            if ( 
                $element['elType'] !== 'column' || 
                !isset($element['elements']) 
            ) { 
                continue; 
            } 
 
            foreach ($element['elements'] as &$widget) { 
                if ($widget['elType'] !== 'widget') { 
                    continue; 
                } 
 
                $settings = []; 
 
                switch ($widget['widgetType']) { 
                    case 'rds-template-seo-widget': 
                        $settings = [ 
                            'heading' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'seo_section' 
                                ]['heading'], 
                            'subheading' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'seo_section' 
                                ]['subheading'], 
                            'before_read_more_content' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'seo_section' 
                                ]['before_read_more_content'], 
                            'after_read_more_content' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'seo_section' 
                                ]['after_read_more_content'], 
                            'seo_variation' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'seo_section' 
                                ]['variation'], 
                        ]; 
                        break; 
 
                    case 'rds-global-history-cta-widget': 
                        $settings = [ 
                            'heading' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'in_content_cta' 
                                ]['heading'], 
                            'button_text' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'in_content_cta' 
                                ]['button_text'], 
                            'button_link' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'in_content_cta' 
                                ]['button_link'], 
                        ]; 
                        break; 
                    case 'rds-financing-company-service-widget': 
                        $settings = [ 
                            'heading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['heading'], 
                            'subheading' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['subheading'], 
                            'button_text' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['button_text'], 
                            'content' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['description_html_allowed'], 
                            'button_link' => 
                                $hide_users['page_templates']['finance_page'][ 
                                    'company_services' 
                                ]['button_link'], 
                        ]; 
                        break; 
                    case 'rds-global-history-middle-content-widget': 
                        $settings = [ 
                            'middle_content' => 
                                $hide_users['page_templates']['history_page'][ 
                                    'middle_content' 
                                ], 
                        ]; 
                        break; 
                    case 'rds-accordion-widget': 
                        $rdsAccordionData = []; 
 
                        // Loop through the sample data and transform it 
                        foreach ( 
                            $hide_users['page_templates']['history_page'][ 
                                'accordion' 
                            ] 
                            as $item 
                        ) { 
                            $rdsAccordionData[] = [ 
                                "item_title" => $item["question"], 
                                "item_content" => $item["content"], 
                                "_id" => uniqid(), // You can generate a unique ID here if needed 
                            ]; 
                        } 
 
                        // Set the transformed data to the widget's settings 
                        $widget['settings'][ 
                            'accordion_items' 
                        ] = $rdsAccordionData; 
                        break; 
                    case 'rds-history-tab-widget': 
                        $rdsTabData = []; 
 
                        // Loop through the sample data and transform it 
                        foreach ( 
                            $hide_users['page_templates']['history_page'][ 
                                'tab_section' 
                            ]['items'] 
                            as $item 
                        ) { 
                            $rdsTabData[] = [ 
                                "item_title" => $item["title"], 
                                "item_heading" => $item["heading"], 
                                "item_content" => $item["content"], 
                                "_id" => uniqid(), // You can generate a unique ID here if needed 
                            ]; 
                        } 
 
                        // Set the transformed data to the widget's settings 
                        $widget['settings']['tab_items'] = $rdsTabData; 
                        break; 
                    default: 
                        break; 
                } 
 
                // Update widget settings 
                foreach ($settings as $key => $value) { 
                    $widget['settings'][$key] = $value; 
                } 
            } 
        } 
    } 
 
    // Encode the updated array and update the database 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41084] // Use the correct post_id here 
    ); 
} 
 
function updateElementorData($post_id, $updateData, $tableNameg, $hide_users) 
{ 
    global $wpdb; 
 
    $elementorDataQuery = $wpdb->prepare( 
        "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = %d", 
        $post_id 
    ); 
    $array = $wpdb->get_results($elementorDataQuery); 
 
    if (!empty($array)) { 
        $object = $array[0]; 
        $decodedArray = json_decode($object->meta_value, true); 
 
        // Loop through the elements and update if widgetType is 'rds-template-seo-widget' 
        foreach ($decodedArray as &$section) { 
            foreach ($section['elements'] as &$column) { 
                foreach ($column['elements'] as &$element) { 
                    if ( 
                        isset($element['widgetType']) && 
                        $element['widgetType'] === 'rds-template-seo-widget' 
                    ) { 
                        $element['settings'] = array_merge( 
                            $element['settings'], 
                            $updateData 
                        ); 
                    } 
                    if ( 
                        isset($element['widgetType']) && 
                        $element['widgetType'] === 
                            'rds-global-meet-the-team-widget' 
                    ) { 
                        $element['settings'] = [ 
                            "heading" => 
                                $hide_users['page_templates']['about_us_page'][ 
                                    'meet_the_team' 
                                ]['heading'], 
                        ]; 
                    } 
 
                    if ( 
                        isset($element['widgetType']) && 
                        $element['widgetType'] === 
                            'rds-global-about-middle-content-widget' 
                    ) { 
                        $element['settings'] = [ 
                            "middle_content" => 
                                $hide_users['page_templates']['about_us_page'][ 
                                    'middle_content' 
                                ], 
                        ]; 
                    } 
 
                    if ( 
                        isset($element['widgetType']) && 
                        $element['widgetType'] === 
                            'rds-request-service-form-widget' 
                    ) { 
                        $element['settings'] = [ 
                            "heading" => 
                                $hide_users['globals']['request_service'][ 
                                    'heading' 
                                ], 
                            "variation" => 
                                $hide_users['globals']['request_service'][ 
                                    'variation' 
                                ], 
                            "gravity_form_id" => 
                                $hide_users['globals']['request_service'][ 
                                    'gravity_form_id' 
                                ], 
                            "checkbox_value" => 
                                $hide_users['globals']['request_service'][ 
                                    'enable' 
                                ] == true 
                                    ? "yes" 
                                    : "", 
                        ]; 
                    } 
                    if ( 
                        isset($element['widgetType']) && 
                        $element['widgetType'] === 'rds-promotio-new-widget' 
                    ) { 
                        $element['settings'] = [ 
                            "checkbox_value" => 
                                $hide_users['globals']['promotion']['enable'] == 
                                true 
                                    ? "yes" 
                                    : "", 
                            "variation" => 
                                $hide_users['globals']['promotion'][ 
                                    'variation' 
                                ], 
 
                            "popup_form_heading" => 
                                $hide_users['globals']['promotion'][ 
                                    'popup_form_heading' 
                                ], 
                            "popup_form_subheading" => 
                                $hide_users['globals']['promotion'][ 
                                    'popup_form_subheading' 
                                ], 
 
                            "popup_gravity_form_id" => 
                                $hide_users['globals']['promotion'][ 
                                    'popup_gravity_form_id' 
                                ], 
                        ]; 
                    } 
                } 
            } 
        } 
 
        $object->meta_value = json_encode($decodedArray); 
        $result = $wpdb->update( 
            $tableNameg, 
            ['meta_value' => $object->meta_value], 
            ['meta_key' => '_elementor_data', 'post_id' => $post_id] 
        ); 
 
        return $result; 
    } 
 
    return false; 
} 
 
// Usage example for post ID 39478 
$post_id_1 = 39478; 
$updateData_1 = [ 
    'seo_variation' => 
        $hide_users['page_templates']['homepage']['seo_section']['variation'], 
    'heading' => 
        $hide_users['page_templates']['homepage']['seo_section']['heading'], 
    'subheading' => 
        $hide_users['page_templates']['homepage']['seo_section']['subheading'], 
    'before_read_more_content' => 
        $hide_users['page_templates']['homepage']['seo_section'][ 
            'before_read_more_content' 
        ], 
    'after_read_more_content' => 
        $hide_users['page_templates']['homepage']['seo_section'][ 
            'after_read_more_content' 
        ], 
]; 
updateElementorData($post_id_1, $updateData_1, $tableNameg, $hide_users); 
 
// Usage example for post ID 40758 
$post_id_2 = 40758; 
$updateData_2 = [ 
    'seo_variation' => 
        $hide_users['page_templates']['about_us_page']['seo_section'][ 
            'variation' 
        ], 
    'heading' => 
        $hide_users['page_templates']['about_us_page']['seo_section'][ 
            'heading' 
        ], 
    'subheading' => 
        $hide_users['page_templates']['about_us_page']['seo_section'][ 
            'subheading' 
        ], 
    'before_read_more_content' => 
        $hide_users['page_templates']['about_us_page']['seo_section'][ 
            'before_read_more_content' 
        ], 
    'after_read_more_content' => 
        $hide_users['page_templates']['about_us_page']['seo_section'][ 
            'after_read_more_content' 
        ], 
]; 
updateElementorData($post_id_2, $updateData_2, $tableNameg, $hide_users); 
 
$post_id_3 = 40930; 
$updateData_3 = [ 
    'seo_variation' => 
        $hide_users['page_templates']['landing_page']['seo_section'][ 
            'variation' 
        ], 
    'heading' => 
        $hide_users['page_templates']['landing_page']['seo_section']['heading'], 
    'subheading' => 
        $hide_users['page_templates']['landing_page']['seo_section'][ 
            'subheading' 
        ], 
    'before_read_more_content' => 
        $hide_users['page_templates']['landing_page']['seo_section'][ 
            'before_read_more_content' 
        ], 
    'after_read_more_content' => 
        $hide_users['page_templates']['landing_page']['seo_section'][ 
            'after_read_more_content' 
        ], 
]; 
updateElementorData($post_id_3, $updateData_3, $tableNameg, $hide_users); 
 
$query = 
    "Select * from " . 
    $tableNameg . 
    " where meta_key = '_elementor_data' and post_id = '41763' "; 
$array = $wpdb->get_results($query); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = [ 
        'call_text' => $hide_users['globals']['header']['call_text'], 
        'desktop_schedule_online_h_enable' => 
            $hide_users['globals']['desktop_schedule_online_button'][ 
                'enabled' 
            ] == true 
                ? "yes" 
                : "", 
        'desktop_schedule_online_h_label' => 
            $hide_users['globals']['desktop_schedule_online_button']['label'], 
        'desktop_schedule_online_h_icon_class' => 
            $hide_users['globals']['desktop_schedule_online_button'][ 
                'icon_class' 
            ], 
        'desktop_schedule_online_button_h_type' => 
            $hide_users['globals']['desktop_schedule_online_button']['type'], 
        'desktop_schedule_online_h_url' => 
            $hide_users['globals']['desktop_schedule_online_button']['url'], 
        'schedule_online_h_url' => 
            $hide_users['globals']['ctas']['schedule_online']['url'], 
        'schedule_online_h_label' => 
            $hide_users['globals']['ctas']['schedule_online']['label'], 
        'schedule_online_h_icon_class' => 
            $hide_users['globals']['ctas']['schedule_online']['icon_class'], 
        'schedule_online_h_type' => 
            $hide_users['globals']['ctas']['schedule_online']['type'], 
        'schedule_online_h_enable' => 
            $hide_users['globals']['ctas']['schedule_online']['enabled'] == true 
                ? "yes" 
                : "", 
        'variation' => $hide_users['globals']['header']['variation'], 
    ]; 
    $encodedArray = json_encode($decodedArray); 
    $object->meta_value = $encodedArray; 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $encodedArray], 
        ['meta_key' => '_elementor_data', 'post_id' => 41763] 
    ); 
} 
$announcmentquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '34452'"; 
$array = $wpdb->get_results($announcmentquery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        'desktop_schedule_online_enable' => $hide_users['globals'][ 
            'announcement' 
        ]['desktop_schedule_online_button']['enabled'] 
            ? "yes" 
            : "", 
        'desktop_schedule_online_label' => 
            $hide_users['globals']['announcement'][ 
                'desktop_schedule_online_button' 
            ]['label'], 
        'desktop_schedule_online_icon_class' => 
            $hide_users['globals']['announcement'][ 
                'desktop_schedule_online_button' 
            ]['icon_class'], 
        'schedule_online_label' => 
            $hide_users['globals']['ctas']['schedule_online']['label'], 
        'schedule_online_icon_class' => 
            $hide_users['globals']['ctas']['schedule_online']['icon_class'], 
        'left_icon_class' => 
            $hide_users['globals']['announcement']['left']['icon_class'], 
        'left_title' => $hide_users['globals']['announcement']['left']['title'], 
        'left_text' => $hide_users['globals']['announcement']['left']['text'], 
        'middle_icon_class' => 
            $hide_users['globals']['announcement']['middle']['icon_class'], 
        'middle_title' => 
            $hide_users['globals']['announcement']['middle']['title'], 
        'middle_text' => 
            $hide_users['globals']['announcement']['middle']['text'], 
        'right_icon_class' => 
            $hide_users['globals']['announcement']['right']['icon_class'], 
        'right_title' => 
            $hide_users['globals']['announcement']['right']['title'], 
        'right_text' => $hide_users['globals']['announcement']['right']['text'], 
        'left_type' => $hide_users['globals']['announcement']['left']['type'], 
        'left_url' => $hide_users['globals']['announcement']['left']['url'], 
        'middle_url' => $hide_users['globals']['announcement']['middle']['url'], 
        'right_url' => $hide_users['globals']['announcement']['right']['url'], 
        'variation' => $hide_users['globals']['announcement']['variation'], 
        'desktop_schedule_online_button_type' => 
            $hide_users['globals']['announcement'][ 
                'desktop_schedule_online_button' 
            ]['type'], 
        'desktop_schedule_online_url' => 
            $hide_users['globals']['announcement'][ 
                'desktop_schedule_online_button' 
            ]['url'], 
        'schedule_online_type' => 
            $hide_users['globals']['ctas']['schedule_online']['type'], 
        'schedule_online_url' => 
            $hide_users['globals']['ctas']['schedule_online']['url'], 
        'tooltip_text' => stripslashes( 
            $hide_users['globals']['announcement']['left']['tooltip_text'] 
        ), 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 34452] 
    ); 
} 
 
$ctaquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39048'"; 
 
$array = $wpdb->get_results($ctaquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "icon_class" => $hide_users['globals']['in_content_cta']['icon_class'], 
        "heading" => $hide_users['globals']['in_content_cta']['heading'], 
        "button_text" => 
            $hide_users['globals']['in_content_cta']['button_text'], 
        "title_class" => 
            $hide_users['globals']['in_content_cta']['title_class'], 
        "button_class" => 
            $hide_users['globals']['in_content_cta']['button_class'], 
        "telephone_class" => 
            $hide_users['globals']['in_content_cta']['telephone_class'], 
        "button_link" => 
            $hide_users['globals']['in_content_cta']['button_link'], 
        "phone" => $hide_users['globals']['in_content_cta']['phone'], 
        "variation" => $hide_users['globals']['in_content_cta']['variation'], 
        "cta_id" => $hide_users['globals']['in_content_cta']['id'], 
        "target" => $hide_users['globals']['in_content_cta']['target'] 
            ? 'yes' 
            : "", 
        "checkbox_value" => $hide_users['globals']['in_content_cta']['enable'] 
            ? 'yes' 
            : "", 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39048] 
    ); 
} 
$testimonialquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '13225'"; 
$array = $wpdb->get_results($testimonialquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        'enable_testimonial' => $hide_users['globals']['testimonial']['enable'] 
            ? "yes" 
            : "", 
        'testimonial_heading' => 
            $hide_users['globals']['testimonial']['heading'], 
        'testimonial_subheading' => 
            $hide_users['globals']['testimonial']['subheading'], 
        'testimonial_button_link' => 
            $hide_users['globals']['testimonial']['button_link'], 
        'testimonial_button_text' => 
            $hide_users['globals']['testimonial']['button_text'], 
        'testimonial_variation' => 
            $hide_users['globals']['testimonial']['variation'], 
        'category_filter' => 
        $hide_users['globals']['testimonial']['category_filter'], 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 13225] 
    ); 
} 
$promotionquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '34464'"; 
$array = $wpdb->get_results($promotionquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "title" => $hide_users['globals']['promotion']['title'], 
        "category_filter" => $hide_users['globals']['promotion']['category_filter'], 
        "heading" => $hide_users['globals']['promotion']['heading'], 
        "coupon_button_text" => $hide_users['globals']['promotion']['coupon_button_text'], 
        "button_text" => $hide_users['globals']['promotion']['button_text'], 
        "popup_form_heading" => 
            $hide_users['globals']['promotion']['popup_form_heading'], 
        "popup_form_subheading" => 
            $hide_users['globals']['promotion']['popup_form_subheading'], 
        "variation" => $hide_users['globals']['promotion']['variation'], 
        "button_link" => $hide_users['globals']['promotion']['button_link'], 
        "order" => $hide_users['globals']['promotion']['order'], 
        "popup_gravity_form_id" => 
            $hide_users['globals']['promotion']['popup_gravity_form_id'], 
        "checkbox_value" => $hide_users['globals']['promotion']['enable'] 
            ? 'yes' 
            : "", 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 34464] 
    ); 
} 
$servicequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '35952'"; 
$array = $wpdb->get_results($servicequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "enable_services" => $hide_users['globals']['services']['enable'] 
            ? 'yes' 
            : "", 
 
        "services_order" => $hide_users['globals']['services']['order'], 
        "top_border_class" => 
            $hide_users['globals']['services']['top_border_class'], 
    ]); 
 
    foreach ($hide_users['globals']['services']['items'] as $index => $values) { 
        $itemExists = isset( 
            $decodedArray[0]['settings']['services_accordion_items'][$index] 
        ); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['services_accordion_items'][ 
                    $index 
                ][$item_key] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['services_accordion_items'][ 
                $index 
            ] = []; 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['services_accordion_items'][ 
                    $index 
                ][$item_key] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['services_accordion_items'] 
        as $index => $itemData 
    ) { 
        if (!isset($hide_users['globals']['services']['items'][$index])) { 
            unset( 
                $decodedArray[0]['settings']['services_accordion_items'][$index] 
            ); 
        } 
    } 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 35952] 
    ); 
} 
$serviceareaquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '36161'"; 
$array = $wpdb->get_results($serviceareaquery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "multisite_service_area_option" => $hide_users['globals']['service_area'][
            'multisite_service_area_option'
        ]
            ? 'yes'
            : "",
        "heading" => $hide_users['globals']['service_area']['heading'], 
        "subheading" => $hide_users['globals']['service_area']['subheading'], 
        "description_html_allowed" => 
            $hide_users['globals']['service_area']['description_html_allowed'], 
        "button_text" => $hide_users['globals']['service_area']['button_text'], 
        "button_link" => $hide_users['globals']['service_area']['button_link'], 
        "variation" => $hide_users['globals']['service_area']['variation'], 
        "order" => $hide_users['globals']['service_area']['order'], 
        "checkbox_value" => $hide_users['globals']['service_area']['enable'] 
            ? "yes" 
            : "", 
        "first_tab_title" => 
            $hide_users['globals']['service_area']['first_tab_title'], 
        "second_tab_title" => 
            $hide_users['globals']['service_area']['second_tab_title'], 
        "third_tab_title" => 
            $hide_users['globals']['service_area']['third_tab_title'], 
        "fourth_tab_title" => 
            $hide_users['globals']['service_area']['fourth_tab_title'], 
        "first_tab_heading" => 
            $hide_users['globals']['service_area']['first_tab_heading'], 
        "second_tab_heading" => 
            $hide_users['globals']['service_area']['second_tab_heading'], 
        "third_tab_heading" => 
            $hide_users['globals']['service_area']['third_tab_heading'], 
        "fourth_tab_heading" => 
            $hide_users['globals']['service_area']['fourth_tab_heading'], 
        "first_tab_description_html_allowed" => 
            $hide_users['globals']['service_area'][ 
                'first_tab_description_html_allowed' 
            ], 
        "second_tab_description_html_allowed" => 
            $hide_users['globals']['service_area'][ 
                'second_tab_description_html_allowed' 
            ], 
        "third_tab_description_html_allowed" => 
            $hide_users['globals']['service_area'][ 
                'third_tab_description_html_allowed' 
            ], 
        "fourth_tab_description_html_allowed" => 
            $hide_users['globals']['service_area'][ 
                'fourth_tab_description_html_allowed' 
            ], 
        "first_tab_button_text" => 
            $hide_users['globals']['service_area']['first_tab_button_text'], 
        "second_tab_button_text" => 
            $hide_users['globals']['service_area']['second_tab_button_text'], 
        "third_tab_button_text" => 
            $hide_users['globals']['service_area']['third_tab_button_text'], 
        "fourth_tab_button_text" => 
            $hide_users['globals']['service_area']['fourth_tab_button_text'], 
        "first_tab_button_link" => 
            $hide_users['globals']['service_area']['first_tab_button_link'], 
        "second_tab_button_link" => 
            $hide_users['globals']['service_area']['second_tab_button_link'], 
        "third_tab_button_link" => 
            $hide_users['globals']['service_area']['third_tab_button_link'], 
        "fourth_tab_button_link" => 
            $hide_users['globals']['service_area']['fourth_tab_button_link'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 36161] 
    ); 
} 
$financequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '36087'"; 
$array = $wpdb->get_results($financequery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "heading" => $hide_users['globals']['financing']['heading'], 
        "subheading" => $hide_users['globals']['financing']['subheading'], 
        "button_text" => $hide_users['globals']['financing']['button_text'], 
        "button_link" => $hide_users['globals']['financing']['button_link'], 
        "order" => $hide_users['globals']['financing']['order'], 
        "variation" => $hide_users['globals']['financing']['variation'], 
        "checkbox_value" => $hide_users['globals']['financing']['enable'] 
            ? "yes" 
            : "", 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 36087] 
    ); 
} 
$heroquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '35888'"; 
$array = $wpdb->get_results($heroquery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "hero_variation" => $hide_users['globals']['hero']['variation'], 
        "hero_heading" => $hide_users['globals']['hero']['heading'], 
        "hero_subheading" => $hide_users['globals']['hero']['subheading'], 
        "hero_footer_text" => $hide_users['globals']['hero']['footer_text'], 
        "hero_button_link" => $hide_users['globals']['hero']['button_link'], 
        "hero_button_text" => $hide_users['globals']['hero']['button_text'], 
        "hero_form_heading" => $hide_users['globals']['hero']['form_heading'], 
        "hero_form_subheading" => 
            $hide_users['globals']['hero']['form_subheading'], 
        "hero_schedule_online_lable" => 
            $hide_users['globals']['hero']['schedule_online']['label'], 
        "hero_schedule_online_url" => 
            $hide_users['globals']['hero']['schedule_online']['url'], 
        "hero_schedule_online_type" => 
            $hide_users['globals']['hero']['schedule_online']['type'], 
        "hero_schedule_online_icon_class" => 
            $hide_users['globals']['hero']['schedule_online']['icon_class'], 
        "hero_desktop_gravity_form_id" => 
            $hide_users['globals']['hero']['desktop_gravity_form_id'], 
        "hero_mobile_gravity_form_id" => 
            $hide_users['globals']['hero']['mobile_gravity_form_id'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 35888] 
    ); 
} 
$requestquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '32406'"; 
$array = $wpdb->get_results($requestquery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "heading" => $hide_users['globals']['request_service']['heading'], 
        "order" => $hide_users['globals']['request_service']['order'], 
        "variation" => $hide_users['globals']['request_service']['variation'], 
        "checkbox_value" => $hide_users['globals']['request_service']['enable'] 
            ? "yes" 
            : "", 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 32406] 
    ); 
} 
$discoverquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '35868'"; 
$array = $wpdb->get_results($discoverquery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "variation" => 
            $hide_users['globals']['discover_the_difference']['variation'], 
        "heading" => 
            $hide_users['globals']['discover_the_difference']['heading'], 
        "subheading" => 
            $hide_users['globals']['discover_the_difference']['subheading'], 
        "order" => $hide_users['globals']['discover_the_difference']['order'], 
        "button_text" => 
            $hide_users['globals']['discover_the_difference']['button_text'], 
        "button_link" => 
            $hide_users['globals']['discover_the_difference']['button_link'], 
        "checkbox_value" => $hide_users['globals']['discover_the_difference'][ 
            'enable' 
        ] 
            ? "yes" 
            : "", 
    ]); 
 
    foreach ( 
        $hide_users['globals']['discover_the_difference']['items'] 
        as $index => $values 
    ) { 
        foreach ($values as $key => $value) { 
            $decodedArray[0]['settings']['accordion_items'][$index][ 
                'item_' . $key 
            ] = $value; 
        } 
    } 
 
    foreach ( 
        $hide_users['globals']['discover_the_difference']['items'] 
        as $index => $values 
    ) { 
        $itemExists = isset( 
            $decodedArray[0]['settings']['accordion_items'][$index] 
        ); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['accordion_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['accordion_items'][$index] = []; 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['accordion_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['accordion_items'] 
        as $index => $itemData 
    ) { 
        if ( 
            !isset( 
                $hide_users['globals']['discover_the_difference']['items'][ 
                    $index 
                ] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['accordion_items'][$index]); 
        } 
    } 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 35868] 
    ); 
} 
$schedulequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '37659'"; 
$array = $wpdb->get_results($schedulequery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => $hide_users['page_templates'][ 
            'schedule_service_page' 
        ]['enable'] 
            ? "yes" 
            : "", 
        "first_icon_class" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'first_icon_class' 
            ], 
        "first_title" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'first_title' 
            ], 
        "first_description" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'first_description' 
            ], 
        "second_icon_class" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'second_icon_class' 
            ], 
        "second_title" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'second_title' 
            ], 
        "second_description" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'second_description' 
            ], 
        "third_icon_class" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'third_icon_class' 
            ], 
        "third_title" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'third_title' 
            ], 
        "third_description" => 
            $hide_users['page_templates']['schedule_service_page'][ 
                'third_description' 
            ], 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 37659] 
    ); 
} 
$freeequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '37662'"; 
$array = $wpdb->get_results($freeequery); 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => $hide_users['page_templates']['free_estimate_page'][ 
            'enable' 
        ] 
            ? "yes" 
            : "", 
        "first_icon_class" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'first_icon_class' 
            ], 
        "first_title" => 
            $hide_users['page_templates']['free_estimate_page']['first_title'], 
        "first_description" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'first_description' 
            ], 
        "second_icon_class" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'second_icon_class' 
            ], 
        "second_title" => 
            $hide_users['page_templates']['free_estimate_page']['second_title'], 
        "second_description" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'second_description' 
            ], 
        "third_icon_class" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'third_icon_class' 
            ], 
        "third_title" => 
            $hide_users['page_templates']['free_estimate_page']['third_title'], 
        "third_description" => 
            $hide_users['page_templates']['free_estimate_page'][ 
                'third_description' 
            ], 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 37662] 
    ); 
} 
 
//     $historyquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '37665'"; 
//     $array = $wpdb->get_results($historyquery); 
//      if ( ! empty( $array) ) { 
//           $object = $array[0]; 
//     $decodedArray = json_decode($object->meta_value, true); 
//     $decodedArray[0]['settings'] = array_merge( 
//             $decodedArray[0]['settings'], 
//             array( 
//                 "seo_heading" => $hide_users['page_templates']['history_page']['seo_section']['heading'], 
//                 "seo_subheading" => $hide_users['page_templates']['history_page']['seo_section']['subheading'], 
//                 "seo_before_read_more" => $hide_users['page_templates']['history_page']['seo_section']['before_read_more_content'], 
//                 "seo_after_read_more" => $hide_users['page_templates']['history_page']['seo_section']['after_read_more_content'], 
//                 "variation" => $hide_users['page_templates']['history_page']['variation'], 
//                 "checkbox_value" => $hide_users['page_templates']['history_page']['enable'] ? "yes" : "" 
//             ) 
//     ); 
 
//     $object->meta_value = json_encode($decodedArray); 
 
//     $result = $wpdb->update( 
//             $tableNameg, 
//             array('meta_value' => $object->meta_value), 
//             array('meta_key' => '_elementor_data', 'post_id' => 37665) 
//     ); 
// } 
//     $aboutquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '37668'"; 
//     $array = $wpdb->get_results($aboutquery); 
//      if ( ! empty( $array) ) { 
//           $object = $array[0]; 
//     $decodedArray = json_decode($object->meta_value, true); 
//     $decodedArray[0]['settings'] = array_merge( 
//             $decodedArray[0]['settings'], 
//             array( 
//                 "seo_heading" => $hide_users['page_templates']['about_us_page']['seo_section']['heading'], 
//                 "seo_subheading" => $hide_users['page_templates']['about_us_page']['seo_section']['subheading'], 
//                 "seo_before_read_more" => $hide_users['page_templates']['about_us_page']['seo_section']['before_read_more_content'], 
//                 "seo_after_read_more" => $hide_users['page_templates']['about_us_page']['seo_section']['after_read_more_content'], 
//                 "variation" => $hide_users['page_templates']['about_us_page']['variation'], 
//                 "checkbox_value" => $hide_users['page_templates']['about_us_page']['enable'] ? 'yes' : "", 
//             ) 
//     ); 
 
//     $object->meta_value = json_encode($decodedArray); 
 
//     $result = $wpdb->update( 
//             $tableNameg, 
//             array('meta_value' => $object->meta_value), 
//             array('meta_key' => '_elementor_data', 'post_id' => 37668) 
//     ); 
// } 
$careergalleryquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '60124'"; 
$array = $wpdb->get_results($careergalleryquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "variation" => 
            $hide_users['page_templates']['career_page']['career_gallery']['variation'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 60124] 
    ); 
} 
$galleryquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41312'"; 
$array = $wpdb->get_results($galleryquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "content" => 
            $hide_users['page_templates']['gallery_page']['content'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41312] 
    ); 
} 
 
$galleryquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41312'"; 
$array = $wpdb->get_results($galleryquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "content" => 
            $hide_users['page_templates']['gallery_page']['content'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41312] 
    ); 
} 
 
$careerbannerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39251'"; 
$array = $wpdb->get_results($careerbannerquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "banner_content" => 
            $hide_users['page_templates']['career_page']['banner']['content'], 
        "banner_button_text" => 
            $hide_users['page_templates']['career_page']['banner'][ 
                'button_text' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39251] 
    ); 
} 
 
$careerheaderquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39254'"; 
$array = $wpdb->get_results($careerheaderquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "widget_1_enable" => 
            $hide_users['page_templates']['career_page']['enable'] == true 
                ? "yes" 
                : "", 
        "widget_1_heading" => 
            $hide_users['page_templates']['career_page']['heading'], 
        "widget_1_subheading" => 
            $hide_users['page_templates']['career_page']['subheading'], 
        "widget_1_content" => 
            $hide_users['page_templates']['career_page']['content'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39254] 
    ); 
} 
 
$careerperkquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39257'"; 
$array = $wpdb->get_results($careerperkquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "perks_checkbox_value" => 
            $hide_users['page_templates']['career_page']['perks']['enable'] == 
            true 
                ? "yes" 
                : "", 
        "perk_variation" => 
            $hide_users['page_templates']['career_page']['perks']['variation'], 
    ]); 
 
    foreach ( 
        $hide_users['page_templates']['career_page']['perks']['items'] 
        as $index => $values 
    ) { 
        $itemExists = isset($decodedArray[0]['settings']['perk_items'][$index]); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['perk_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['perk_items'][$index] = []; 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['perk_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['perk_items'] 
        as $index => $itemData 
    ) { 
        if ( 
            !isset( 
                $hide_users['page_templates']['career_page']['perks']['items'][ 
                    $index 
                ] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['perk_items'][$index]); 
        } 
    } 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39257] 
    ); 
} 
 
$careerfaqquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40832'"; 
$array = $wpdb->get_results($careerfaqquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['career_page']['faq']['enable'] == 
            true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['career_page']['faq']['heading'], 
    ]); 
 
    foreach ( 
        $hide_users['page_templates']['career_page']['faq']['data'] 
        as $index => $values 
    ) { 
        $itemExists = isset( 
            $decodedArray[0]['settings']['accordion_data'][$index] 
        ); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = $key; 
                $decodedArray[0]['settings']['accordion_data'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['accordion_data'][$index] = []; 
            foreach ($values as $key => $value) { 
                $item_key = $key; 
                $decodedArray[0]['settings']['accordion_data'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['accordion_data'] 
        as $index => $itemData 
    ) { 
        if ( 
            !isset( 
                $hide_users['page_templates']['career_page']['faq']['data'][ 
                    $index 
                ] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['accordion_data'][$index]); 
        } 
    } 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40832] 
    ); 
} 
 
$careeremployequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39260'"; 
$array = $wpdb->get_results($careeremployequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "employe_checkbox_value" => 
        $hide_users['page_templates']['career_page'][ 
            'employee_Of_the_month' 
        ]['enable'] == true 
            ? "yes" 
            : "", 
    "employe_variation" => $hide_users['page_templates']['career_page']['employee_Of_the_month']['variation'], 
    "employe_heading" => 
        $hide_users['page_templates']['career_page'][ 
            'employee_Of_the_month' 
        ]['heading'], 
]); 
 
    foreach ( 
        $hide_users['page_templates']['career_page']['employee_Of_the_month'][ 
            'items' 
        ] 
        as $index => $values 
    ) { 
        $itemExists = isset( 
            $decodedArray[0]['settings']['employe_items'][$index] 
        ); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['employe_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['employe_items'][$index] = []; 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['employe_items'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['employe_items'] 
        as $index => $itemData 
    ) { 
        if ( 
            !isset( 
                $hide_users['page_templates']['career_page'][ 
                    'employee_Of_the_month' 
                ]['items'][$index] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['employe_items'][$index]); 
        } 
    } 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39260] 
    ); 
} 
 
$careerjobquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39263'"; 
$array = $wpdb->get_results($careerjobquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "position_checkbox_value" => 
            $hide_users['page_templates']['career_page']['position'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "wpjob_heading" => 
            $hide_users['page_templates']['career_page']['position']['heading'], 
        "wpjob_button_text" => 
            $hide_users['page_templates']['career_page']['position'][ 
                'button_text' 
            ], 
        "wpjob_button_link" => 
            $hide_users['page_templates']['career_page']['position'][ 
                'button_link' 
            ], 
        "job_wp_job_board" => 
            $hide_users['page_templates']['career_page']['position'][ 
                'wp_job_board' 
            ] == true 
                ? "yes" 
                : "", 
    ]); 
 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39263] 
    ); 
} 
 
$careervideoquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39266'"; 
$array = $wpdb->get_results($careervideoquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "video_checkbox_value" => 
            $hide_users['page_templates']['career_page']['video']['enable'] == 
            true 
                ? "yes" 
                : "", 
        "video_heading" => 
            $hide_users['page_templates']['career_page']['video']['heading'], 
    ]); 
    foreach ( 
        $hide_users['page_templates']['career_page']['video']['items'] 
        as $index => $values 
    ) { 
        $itemExists = isset( 
            $decodedArray[0]['settings']['videos_item'][$index] 
        ); 
        if ($itemExists) { 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['videos_item'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } else { 
            // Add new data for the item 
            $decodedArray[0]['settings']['videos_item'][$index] = []; 
            foreach ($values as $key => $value) { 
                $item_key = 'item_' . $key; 
                $decodedArray[0]['settings']['videos_item'][$index][ 
                    $item_key 
                ] = $value; 
            } 
        } 
    } 
 
    foreach ( 
        $decodedArray[0]['settings']['videos_item'] 
        as $index => $itemData 
    ) { 
        if ( 
            !isset( 
                $hide_users['page_templates']['career_page']['video']['items'][ 
                    $index 
                ] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['videos_item'][$index]); 
        } 
    } 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39266] 
    ); 
} 
 
$footerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39015'"; 
$array = $wpdb->get_results($footerquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "footer_menu_1_heading" => 
            $hide_users['globals']['footer']['data']['footer_menu_1_heading'], 
        "footer_menu_2_name" => 
            $hide_users['globals']['footer']['data']['footer_menu_2_name'], 
        "footer_menu_1_name" => 
            $hide_users['globals']['footer']['data']['footer_menu_1_name'], 
        "footer_menu_2_heading" => 
            $hide_users['globals']['footer']['data']['footer_menu_2_heading'], 
        "disclaimer_text" => 
            $hide_users['globals']['footer']['data']['disclaimer_text'], 
        "copyright_title" => 
            $hide_users['globals']['footer']['data']['copyright_title'], 
        "bluecorona_branding" => 
            $hide_users['globals']['footer']['data']['bluecorona_branding'] == 
            true 
                ? "yes" 
                : "", 
        "bluecorona_link" => 
            $hide_users['globals']['footer']['data']['bluecorona_link'], 
        "privacy_policy_link" => 
            $hide_users['globals']['footer']['data']['privacy_policy_link'], 
        "follow_text" => $hide_users['globals']['footer']['heading'], 
    ]); 
    foreach ( 
        $hide_users['globals']['footer']['data']['social_media']['items'] 
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
                $hide_users['globals']['footer']['data']['social_media'][ 
                    'items' 
                ][$index] 
            ) 
        ) { 
            unset($decodedArray[0]['settings']['social_items'][$index]); 
        } 
    } 
 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39015] 
    ); 
} 
 
$affiliationquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '38959'"; 
$array = $wpdb->get_results($affiliationquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "affiliation_enable" => 
            $hide_users['globals']['affiliation']['enable'] == true 
                ? "yes" 
                : "", 
        "affiliation_order" => $hide_users['globals']['affiliation']['order'], 
        "affiliation_variation" => 
            $hide_users['globals']['affiliation']['variation'], 
        "affiliation_count" => $hide_users['globals']['affiliation']['count'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 38959] 
    ); 
} 
 
$companyservicequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39286'"; 
$array = $wpdb->get_results($companyservicequery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['globals']['company_services']['enable'] == true 
                ? "yes" 
                : "", 
        "heading" => $hide_users['globals']['company_services']['heading'], 
        "subheading" => 
            $hide_users['globals']['company_services']['subheading'], 
        "button_text" => 
            $hide_users['globals']['company_services']['button_text'], 
        "button_link" => 
            $hide_users['globals']['company_services']['button_link'], 
        "content" => 
            $hide_users['globals']['company_services'][ 
                'description_html_allowed' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39286] 
    ); 
} 
 
// function updateBannerSettings($post_id, $hide_users, $tableNameg, $metaKey) { 
//     global $wpdb; 
 
//     $bannerQuery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '$post_id'"; 
//     $array = $wpdb->get_results($bannerQuery); 
 
//     if (!empty($array)) { 
//         $object = $array[0]; 
 
//         $decodedArray = json_decode($object->meta_value, true); 
//         if($metaKey == 'sidebar'){ 
//              $decodedArray[0]['settings'] = array_merge( 
//             $decodedArray[0]['settings'], 
//             array( 
//                 "checkbox_value" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['enable'] == true ? "yes" : "", 
//                 "heading" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['heading'], 
//                 "variation" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['variation'], 
//                 "subheading" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['subheading'], 
//                 "button_text" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['button_text'], 
//                 "button_link" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['button_link'], 
//                 "content" => $hide_users['page_templates']['subpage'][$metaKey]['banner']['content'], 
//             ) 
//         ); 
//         }else{ 
//              $decodedArray[0]['settings'] = array_merge( 
//             $decodedArray[0]['settings'], 
//             array( 
//                 "checkbox_value" => $hide_users['page_templates'][$metaKey]['banner']['enable'] == true ? "yes" : "", 
//                 "heading" => $hide_users['page_templates'][$metaKey]['banner']['heading'], 
//                 "variation" => $hide_users['page_templates'][$metaKey]['banner']['variation'], 
//                 "subheading" => $hide_users['page_templates'][$metaKey]['banner']['subheading'], 
//                 "button_text" => $hide_users['page_templates'][$metaKey]['banner']['button_text'], 
//                 "button_link" => $hide_users['page_templates'][$metaKey]['banner']['button_link'], 
//                 "content" => $hide_users['page_templates'][$metaKey]['banner']['content'], 
//             ) 
//         ); 
//         } 
 
//         $object->meta_value = json_encode($decodedArray); 
 
//         $result = $wpdb->update( 
//             $tableNameg, 
//             array('meta_value' => $object->meta_value), 
//             array('meta_key' => '_elementor_data', 'post_id' => $post_id) 
//         ); 
//     } 
// } 
 
// // Call the function for each specific post ID and meta key 
// updateBannerSettings(39509, $hide_users, $tableNameg, 'subpage'); 
// updateBannerSettings(40926, $hide_users, $tableNameg, 'landing_page'); 
// updateBannerSettings(40109, $hide_users, $tableNameg, 'sidebar'); 
 
$subpagebannerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39509'"; 
$array = $wpdb->get_results($subpagebannerquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['subpage']['banner']['enable'] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['subpage']['banner']['heading'], 
        "variation" => 
            $hide_users['page_templates']['subpage']['banner']['variation'], 
        "subheading" => 
            $hide_users['page_templates']['subpage']['banner']['subheading'], 
        "button_text" => 
            $hide_users['page_templates']['subpage']['banner']['button_text'], 
        "button_link" => 
            $hide_users['page_templates']['subpage']['banner']['button_link'], 
        "content" => 
            $hide_users['page_templates']['subpage']['banner']['content'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39509] 
    ); 
} 
 
$landingbannerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40926'"; 
$array = $wpdb->get_results($landingbannerquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
      
        "heading" => 
            $hide_users['page_templates']['landing_page']['banner']['heading'], 
      "variation" => $hide_users['page_templates']['landing_page']['banner']['variation'], 
        "subheading" => 
            $hide_users['page_templates']['landing_page']['banner'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['landing_page']['banner'][ 
                'button_text' 
            ], 
        "button_link" => $hide_users['page_templates']['landing_page']['banner']['button_link'], 
        "content" => 
            $hide_users['page_templates']['landing_page']['banner']['content'], 
		"gravity_form_id" => 
            $hide_users['page_templates']['landing_page']['banner']['gravity_form_id'], 
		"form_heading" => 
            $hide_users['page_templates']['landing_page']['banner']['form_heading'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40926] 
    ); 
} 
 
$subpagesidebarbannerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40109'"; 
$array = $wpdb->get_results($subpagesidebarbannerquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'heading' 
            ], 
        "variation" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'variation' 
            ], 
        "subheading" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'button_link' 
            ], 
        "content" => 
            $hide_users['page_templates']['subpage']['sidebar']['banner'][ 
                'content' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40109] 
    ); 
} 
 
$subpagesidebarrequestservicequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40126'"; 
$array = $wpdb->get_results($subpagesidebarrequestservicequery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['subpage']['sidebar'][ 
                'request_service' 
            ]['enable'] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['subpage']['sidebar'][ 
                'request_service' 
            ]['heading'], 
        "variation" => 
            $hide_users['page_templates']['subpage']['sidebar'][ 
                'request_service' 
            ]['variation'], 
        "subheading" => 
            $hide_users['page_templates']['subpage']['sidebar'][ 
                'request_service' 
            ]['subheading'], 
        "gravity_form_id" => 
            $hide_users['page_templates']['subpage']['sidebar'][ 
                'request_service' 
            ]['gravity_form_id'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40126] 
    ); 
} 
 
$servicesubpagesidebarrequestservicequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40473'"; 
$array = $wpdb->get_results($servicesubpagesidebarrequestservicequery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['service_subpage']['sidebar'][ 
                'request_service' 
            ]['enable'] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['service_subpage']['sidebar'][ 
                'request_service' 
            ]['heading'], 
        "variation" => 
            $hide_users['page_templates']['service_subpage']['sidebar'][ 
                'request_service' 
            ]['variation'], 
        "subheading" => 
            $hide_users['page_templates']['service_subpage']['sidebar'][ 
                'request_service' 
            ]['subheading'], 
        "gravity_form_id" => 
            $hide_users['page_templates']['service_subpage']['sidebar'][ 
                'request_service' 
            ]['gravity_form_id'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40473] 
    ); 
} 
 
$servicesubpagesidebarrservicequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40476'"; 
$array = $wpdb->get_results($servicesubpagesidebarrservicequery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "title" => $hide_users['page_templates']['service_subpage']['services']['title'],    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40476] 
    ); 
} 
 
$subpagesidebarpromotionquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40144'"; 
$array = $wpdb->get_results($subpagesidebarpromotionquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'heading' 
            ], 
        "coupon_button_text" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'coupon_button_text' 
            ],
        "variation" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'variation' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'button_link' 
            ], 
        "popup_form_heading" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'popup_form_heading' 
            ],
        "popup_form_subheading" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'popup_form_subheading' 
            ],  
        "popup_gravity_form_id" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'popup_gravity_form_id' 
            ], 
        "category_filter" => 
            $hide_users['page_templates']['subpage']['sidebar']['promotion'][ 
                'category_filter' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40144] 
    ); 
} 
 
$subpagesidebarfinancingquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40147'"; 
$array = $wpdb->get_results($subpagesidebarfinancingquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['subpage']['sidebar']['financing'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['subpage']['sidebar']['financing'][ 
                'heading' 
            ], 
        "subheading" => 
            $hide_users['page_templates']['subpage']['sidebar']['financing'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['subpage']['sidebar']['financing'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['subpage']['sidebar']['financing'][ 
                'button_link' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40147] 
    ); 
} 
 
$servicessubpagesidebarfinancingquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '40479'"; 
$array = $wpdb->get_results($servicessubpagesidebarfinancingquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['service_subpage']['financing'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['service_subpage']['financing'][ 
                'heading' 
            ], 
        "subheading" => 
            $hide_users['page_templates']['service_subpage']['financing'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['service_subpage']['financing'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['service_subpage']['financing'][ 
                'button_link' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 40479] 
    ); 
} 
$wearehiringquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39344'"; 
$array = $wpdb->get_results($wearehiringquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['homepage']['we_are_hiring'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['homepage']['we_are_hiring'][ 
                'heading' 
            ], 
        "subheading" => 
            $hide_users['page_templates']['homepage']['we_are_hiring'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['homepage']['we_are_hiring'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['homepage']['we_are_hiring'][ 
                'button_link' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39344] 
    ); 
} 
 
$servicesubpagebannerquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39819'"; 
$array = $wpdb->get_results($servicesubpagebannerquery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'enable' 
            ] == true 
                ? "yes" 
                : "", 
        "heading" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'heading' 
            ], 
        "variation" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'variation' 
            ], 
        "subheading" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'subheading' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['service_subpage']['banner'][ 
                'button_link' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39819] 
    ); 
} 
 
$contactpagequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '39942'"; 
$array = $wpdb->get_results($contactpagequery); 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => 
            $hide_users['page_templates']['contact_page']['enable'] == true 
                ? "yes" 
                : "", 
        "variation" => 
            $hide_users['page_templates']['contact_page']['variation'], 
        "content" => 
            $hide_users['page_templates']['contact_page']['content'], 
        "gravity_form_id" => 
            $hide_users['page_templates']['contact_page']['gravity_form_id'], 
        "hours_heading" => 
            $hide_users['page_templates']['contact_page']['hours_heading'], 
        "address_heading" => 
            $hide_users['page_templates']['contact_page']['address_heading'], 
        
    ]); 
     
    $object->meta_value = json_encode($decodedArray); 
 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 39942] 
    ); 
} 
 
// Promotions template 
$promotiontemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '61784'"; 
$array = $wpdb->get_results($promotiontemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "enable_promotion" => $hide_users['page_templates']['promotions'][ 
            'enable' 
        ] 
            ? 'yes' 
            : "", 
        "enable_sidebar" => $hide_users['page_templates']['promotions'][ 
            'subpage_sidebar' 
        ] 
            ? 'yes' 
            : "", 
        "variation" => 
            $hide_users['page_templates']['promotions']['variation'], 
        "popup_form_heading" => 
            $hide_users['page_templates']['promotions']['popup_form_heading'], 
        "popup_form_subheading" => 
            $hide_users['page_templates']['promotions'][ 
                'popup_form_subheading' 
            ],
        "coupon_button_text" => 
            $hide_users['page_templates']['promotions'][ 
                'coupon_button_text' 
            ], 
        "popup_gravity_form_id" => 
            $hide_users['page_templates']['promotions'][ 
                'popup_gravity_form_id' 
            ], 
        "category_filter" => 
        $hide_users['page_templates']['promotions'][ 
            'category_filter' 
        ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 61784] 
    ); 
} 
 
// promotion landing query 
 
$promotionlandingquery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '60835'"; 
$array = $wpdb->get_results($promotionlandingquery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
 
        "variation" => 
            $hide_users['page_templates']['landing_page']['promotion']['variation'], 
        "popup_form_heading" => 
            $hide_users['page_templates']['landing_page']['promotion']['popup_form_heading'], 
        "popup_form_subheading" => 
            $hide_users['page_templates']['landing_page']['promotion']['popup_form_subheading'],
        "coupon_button_text" => 
            $hide_users['page_templates']['landing_page']['promotion']['coupon_button_text'], 
        "popup_gravity_form_id" => 
            $hide_users['page_templates']['landing_page']['promotion']['popup_gravity_form_id'], 
        "category_filter" => 
            $hide_users['page_templates']['landing_page']['promotion']['category_filter'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 60835] 
    ); 
} 
 
 
 
 
$teamtemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41250'"; 
$array = $wpdb->get_results($teamtemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge( 
        $decodedArray[0]['settings'], 
 
        [ 
            "enable_teams" => $hide_users['page_templates']['team_page'][ 
                'enable' 
            ] 
                ? 'yes' 
                : "", 
            "team_subheading" => 
                $hide_users['page_templates']['team_page']['subheading'], 
        ] 
    ); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41250] 
    ); 
} 
 
$testimonialtemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41018'"; 
$array = $wpdb->get_results($testimonialtemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "enable_testimonial" => $hide_users['page_templates'][ 
            'testimonial_page' 
        ]['enable'] 
            ? 'yes' 
            : "", 
        "testimonial_variation" => 
            $hide_users['page_templates']['testimonial_page']['variation'], 
        "testimonial_subheading" => 
            $hide_users['page_templates']['testimonial_page']['subheading'], 
            "category_filter" => 
            $hide_users['page_templates']['testimonial_page']['category_filter'], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41018] 
    ); 
} 
 
$thankyoutemplatequery = "SELECT * FROM $tableNameg WHERE meta_key = '_elementor_data' AND post_id = '41222'"; 
$array = $wpdb->get_results($thankyoutemplatequery); 
 
if (!empty($array)) { 
    $object = $array[0]; 
 
    $decodedArray = json_decode($object->meta_value, true); 
    $decodedArray[0]['settings'] = array_merge($decodedArray[0]['settings'], [ 
        "checkbox_value" => $hide_users['page_templates']['thankyou_page'][ 
            'enable' 
        ] 
            ? 'yes' 
            : "", 
        "variation" => 
            $hide_users['page_templates']['thankyou_page']['variation'], 
        "middle_content" => 
            $hide_users['page_templates']['thankyou_page']['middle_content'], 
        "scroll_button_text" => 
            $hide_users['page_templates']['thankyou_page'][ 
                'scroll_button_text' 
            ], 
        "affiliation_heading" => 
            $hide_users['page_templates']['thankyou_page'][ 
                'affiliation_heading' 
            ], 
        "heading" => 
            $hide_users['page_templates']['thankyou_page']['promotions'][ 
                'heading' 
            ], 
        "content" => 
            $hide_users['page_templates']['thankyou_page']['promotions'][ 
                'content' 
            ], 
        "button_text" => 
            $hide_users['page_templates']['thankyou_page']['promotions'][ 
                'button_text' 
            ], 
        "button_link" => 
            $hide_users['page_templates']['thankyou_page']['promotions'][ 
                'button_link' 
            ], 
    ]); 
    $object->meta_value = json_encode($decodedArray); 
    $result = $wpdb->update( 
        $tableNameg, 
        ['meta_value' => $object->meta_value], 
        ['meta_key' => '_elementor_data', 'post_id' => 41222] 
    ); 
} 
?>