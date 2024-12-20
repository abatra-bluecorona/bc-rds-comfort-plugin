
<?php
function processDesignData($body, $spec_name)
{
    global $wpdb;
    $tableName = $wpdb->prefix . 'options';
    try {
    // Your $body, $spec_name, $wpdb, $tableName, and other variables here.
    if (!rds_validateJson($body)) {
        $msg.= ucfirst($spec_name) . ' JSON is not valid. Please check the valid Spec file and refresh the page.';
        throw new Exception($msg);
    }
    $queryDateResults = rds_getSetting($wpdb, $tableName, 'rds_design_date');
    $queryResults = rds_getSetting($wpdb, $tableName, 'rds_design');
    if (empty($queryResults)) {
        $result = $wpdb->insert($tableName, array('option_value' => $body, 'option_name' => 'rds_design'));
        $msg.= ucfirst($spec_name) . ' Record Inserted';
    } else {
        $result = rds_updateSetting($wpdb, $tableName, 'rds_design', $body);
        $formatted_date = date("m/d/Y h:m:s T"); // For "Mm/dd/yyyy hh:mm:ss TMZ"
        if (empty($queryDateResults)) {
            $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_design_date'));
        } else {
            $result_date = rds_updateSetting($wpdb, $tableName, 'rds_design_date', $formatted_date);
        }
        $msg.= ucfirst($spec_name) . ' Updated.';
    }
    $design_arr = json_decode($body, true);
    $variables = [];
    $color_key = [];
    $font_key = [];
    $inital = 1;
    foreach ($design_arr["defaults"]["colors"] as $key => $value) {
        if ($inital < 5) {
            $variables[$key . "_color"] = $value;
        } else {
            $variables[$key] = $value;
        }
        $color_key[$key] = $value;
        $inital++;
    }
    foreach ($design_arr["defaults"]["fonts"] as $key => $value) {
        $variables[$key] = $value;
        $font_key[$key] = $value;
    }
    function processDesignArray($design_arr, &$variables, $color_key, $font_key, $prefix = '') {
        foreach ($design_arr as $key => $value) {
            if (substr($prefix, 0, 1) === "_") {
                $prefix = substr($prefix, 1);
            }
            if ($prefix == "display_1" || $prefix == "display_2") {
                $new_prefix = $key . '_' . $prefix;
            } elseif ($prefix == "hero_mobile_display_1" || $prefix == "hero_mobile_display_2") {
                $position = strpos($prefix, "display_1");
                $position2 = strpos($prefix, "display_2");
                if ($position !== false) {
                    $charactersBefore = substr($prefix, 0, $position);
                    $new_prefix = $charactersBefore . $key . '_display_1';
                }
                if ($position2 !== false) {
                    $charactersBefore2 = substr($prefix, 0, $position2);
                    $new_prefix = $charactersBefore2 . $key . '_display_2';
                }
            } else {
                $new_prefix = $prefix . '_' . $key;
            }
            if (is_array($value)) {
                processDesignArray($value, $variables, $color_key, $font_key, $new_prefix);
            } else {
                $variables_key = $new_prefix;
                $variables[$variables_key] = $value;
                if (array_key_exists($variables[$variables_key], $color_key)) {
                    $variables[$variables_key] = $color_key[$variables[$variables_key]];
                }
                if (array_key_exists($variables[$variables_key], $font_key)) {
                    $variables[$variables_key] = $font_key[$variables[$variables_key]];
                }
            }
        }
    }
     // calling function design spec to elementor Start

     do_action('rds_design', $design_arr);
     // calling function design spec to elementor End
     
    processDesignArray($design_arr["defaults"]["typography"], $variables, $color_key, $font_key);
    // require  plugin_dir_url( __FILE__ ). "/scssphp/scss.inc.php";
    $compiler = new ScssPhp\ScssPhp\Compiler();
echo    $source_scss = get_template_directory() . "/src/sass/theme.scss";

    $scssContents = file_get_contents($source_scss);
    $import_path = get_template_directory() . "/src/sass";
   $target_css = get_template_directory() . "/css/theme.min.css";
    $theme_styles  = "/css/theme{$suffix}.css";
    $target_map = get_template_directory() . "/css/theme.min.css.map";
    $compiler->addImportPath($import_path);
    $compiler->setVariables($variables);
    $css = $compiler->compile($scssContents);
    if (!empty($css) && is_string($css)) {
        file_put_contents($target_css, $css);
    }
    // API START
    mongodbAPI("POST", "design", $body);
    if ($spec_name == 'rds_design') {
        return $msg;
    }
    
    // if ($result) {
        //Set session Name
        $_SESSION["design"] = $_FILES['import_file_design']['name'];

        wp_redirect(admin_url("admin.php?page=rds_tool"));
    // }
}
catch(Exception $e) {
    // Handle exceptions here
    echo $e->getMessage();
    // Additional error handling logic can be added
    
}
}
?>