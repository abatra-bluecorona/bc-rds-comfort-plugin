<?php
function processTrackingData($body, $spec_name)
{
    global $wpdb; 
    $results_data = json_decode($body, true);
    $accTableName = $wpdb->prefix . 'rds_tracking';
    $name = 'accessibility';
    $latest_entry = $wpdb->prepare("SELECT * FROM $accTableName WHERE name = %s ORDER BY date DESC LIMIT 1", $name);
    $accResults = $wpdb->get_results($latest_entry, ARRAY_A); 
    $dbResult = $accResults[0];
    $resultsData = json_decode($dbResult['data'], true);
    if ($resultsData !== $results_data['accessibility']) {
        rds_insert_tracking_option($results_data['accessibility'], $name);
    }
    
    $tableName = $wpdb->prefix . 'options';
    try {
    // Your $body, $spec_name, $wpdb, $tableName, and other variables here.
    if (!rds_validateJson($body)) {
        $msg.= ucfirst($spec_name) . ' JSON is not valid. Please check the valid Spec file and refresh the page.';
        throw new Exception($msg);
    }


    $query = "Select * from " . $tableName . " where option_name = 'rds_tracking'";
    $queryResults = $wpdb->get_results($query);
    $queryDate = "Select * from " . $tableName . " where option_name = 'rds_tracking_date'";
    $queryDateResults = $wpdb->get_results($queryDate);
    $formatted_date = date("m/d/Y h:m:s T"); // For "Mm/dd/yyyy hh:mm:ss TMZ"
    if (empty($queryResults)) {
        $result = $wpdb->insert($tableName, array('option_value' => $body, 'option_name' => 'rds_tracking'));
        $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_tracking_date'));
        // echo "<h3 style='color: green;'>Record Inserted : " . $_FILES['import_file_tracking']['name'] . "</h3>";
        $msg.= ucfirst($spec_name) . ' Record Inserted';
    } else {
        $result = $wpdb->update($tableName, array('option_value' => $body), array('option_name' => 'rds_tracking'));
        $formatted_date = date("m/d/Y h:m:s T"); // For "Mm/dd/yyyy hh:mm:ss TMZ"
        if (empty($queryDateResults)) {
            $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_tracking_date'));
        } else {
            $result_date = $wpdb->update($tableName, array('option_value' => $formatted_date), array('option_name' => 'rds_tracking_date'));
        }
        // echo "<h3 style='color: green;'>Record Updated : " . $_FILES['import_file_tracking']['name'] . "</h3>";
        $msg.= ucfirst($spec_name) . ' Updated.';
    }
    // $template_arr = json_decode($body, TRUE);

    mongodbAPI("POST", "tracking", $body);
    if ($spec_name == 'rds_tracking') {
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