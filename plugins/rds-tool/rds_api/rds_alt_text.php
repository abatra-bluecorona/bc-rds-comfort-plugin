<?php

function processaltData($body)
{
    // die('1234');
    print_r($body);
    // die();

    global $wpdb;
    $tableName = $wpdb->prefix . 'options';
    try {
       
        $query = "Select * from " . $tableName . " where option_name = 'rds_alt_text'";
        $queryResults = $wpdb->get_results($query);
        $queryDate = "Select * from " . $tableName . " where option_name = 'rds_alt_text_date'";
		        $formatted_date = date("m/d/Y h:m:s T"); // For "Mm/dd/yyyy hh:mm:ss TMZ"

        $queryDateResults = $wpdb->get_results($queryDate);
        if (empty($queryResults)) {

            $result = $wpdb->insert($tableName, array('option_value' => $body, 'option_name' => 'rds_alt_text'));
            $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_alt_text_date'));

            echo "<h3 style='color: green;'>Record Inserted : " . $_FILES['import_file_alt_text']['name'] . "</h3>";
        } else {
            $result = $wpdb->update($tableName, array('option_value' => $body), array('option_name' => 'rds_alt_text'));
            if (empty($queryDateResults)) {
                $result_date = $wpdb->insert($tableName, array('option_value' => $formatted_date, 'option_name' => 'rds_alt_text_date'));
            } else {
                $result_date = $wpdb->update($tableName, array('option_value' => $formatted_date), array('option_name' => 'rds_alt_text_date'));
            }
            
            echo "<h3 style='color: green;'>Record Updated : " . $_FILES['import_file_alt_text']['name'] . "</h3>";
        }
        // API START 
        mongodbAPI('POST', 'alt_text', $body);

}
catch(Exception $e) {
    // Handle exceptions here
    echo $e->getMessage();
    // Additional error handling logic can be added
    
}
}

?>