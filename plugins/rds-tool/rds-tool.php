<?php

/**
 * Plugin Name: Polaris RDS Configuration
 * Description: This plugin is used to add and update Elementor data.
 * Author: Bluecorona
 * Author URI: https://www.bluecorona.com/
 * Version: 2.0.1.0
 * Text Domain: csv
 * Domain Path: /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

// Define constants
define('RDS_API_KEY', '123456');

function enqueue_custom_scripts($hook) {
    // Load only on ?page=mypluginname
    if ($hook != 'toplevel_page_rds_tool') {
        return;
    }

    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Bootstrap CSS
    wp_register_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-css');

    // Enqueue Bootstrap JavaScript
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('jquery'), '', true);

    // Enqueue your custom script
    wp_enqueue_script('custom-plugin-script', plugins_url('/js/custom-script.js', __FILE__), array('jquery'), '', true);


    // Localize your custom script
    wp_localize_script('custom-plugin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('admin_enqueue_scripts', 'enqueue_custom_scripts');



/*function enqueue_custom_scripts($hook) {

    // Load only on ?page=mypluginname
    if($hook != 'toplevel_page_rds_tool') {
            return;
    }

    wp_enqueue_script('custom-plugin-script', plugins_url('/js/custom-script.js', __FILE__), array('jquery'), '', true);
    wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.css');
    wp_enqueue_style('prefix_bootstrap');
    wp_register_style('font-awesome', 'icon/font-awesome-4.7.0/css/font-awesome.css');
    // wp_enqueue_style('prefix_bootstrap', plugins_url('/assets/css/bootstrap.min.css', __FILE__));
    wp_localize_script('custom-plugin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}

add_action('admin_enqueue_scripts', 'enqueue_custom_scripts');*/

add_action('admin_menu', 'add_rds_tool_settings_page');
function add_rds_tool_settings_page() {
    add_menu_page('Polaris RDS Configuration', 'Polaris RDS Configuration', 'manage_options', 'rds_tool', 'rds_tool_settings_page');
    // add_action('admin_post_import_data', 'import_data_callback');
}

/**
 * Update spec data.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'callPhpFunction') {
    // Call your PHP function here
    get_latest_file_alt();
    // echo json_encode(['status' => 'success']);
    exit;
}


    function get_latest_file_alt() {
        // Your array data
        $data = rds_alt_text();
         $siteName = get_bloginfo("name"); 
                $underscoredString = str_replace(' ', '_', $siteName);  
        // Set the CSV filename
        $csvFileName = $underscoredString.'-Alt-Text-RDS2.0.csv';

        // Open the CSV file for writing
        $csvFile = fopen($csvFileName, 'w');

        // Write the header
        fputcsv($csvFile, $data[0]);

        // Write the data
        for ($i = 1; $i < count($data); $i++) {
            fputcsv($csvFile, $data[$i]);
        }

        // Close the CSV file
        fclose($csvFile);

        // Set headers to force a download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        header('Pragma: public');

        // Output the file
        readfile($csvFileName);

        // Remove the file
        unlink($csvFileName);    
    }
    // get_latest_file_alt();



    function get_latest_file($attr) {
        
        $attr;
        $path = $attr . "/";
        $latest_filename = '';
        $files = array();
        $files = array_diff(scandir($path, SCANDIR_SORT_DESCENDING), array('.', '..'));
        if ($files) {
            $latest_filename = $files[0];
        }
        return $latest_filename;
    }
  

function rds_tool_settings_page() {
    // if (isset($_POST['button_import_settings'])) {
        // handle_uploaded_file();
    // }
    //Variable define  
    global $wpdb;
    global $post;
    $targetDir = str_replace('\\', '/', ABSPATH) . "wp-content/uploads/";
    $teamPostDir = get_stylesheet_directory() . "/img/meet-the-team/";
    $folderTemplateConfigration = $targetDir . 'template_configuration/';
    $folderTemplatespecs = $folderTemplateConfigration . 'template_specs';
    $folderContentspecs = $folderTemplateConfigration . 'content_specs';
    $folderDesignspecs = $folderTemplateConfigration . 'design_specs';
    $folderNavspecs = $folderTemplateConfigration . 'nav_specs';
    $folderTrackingspecs = $folderTemplateConfigration . 'tracking_specs';
    $folderAltTextspecs = $folderTemplateConfigration . 'alt_text_specs';
    $timeStamp = time() . '.jsonc';

    if (!file_exists($folderTemplateConfigration)) {
        mkdir($folderTemplateConfigration, 0755, true);
    }
    if (!file_exists($folderContentspecs)) {
        mkdir($folderContentspecs, 0755, true);
    }
    if (!file_exists($folderDesignspecs)) {
        mkdir($folderDesignspecs, 0755, true);
    }
    if (!file_exists($folderNavspecs)) {
        mkdir($folderNavspecs, 0755, true);
    }
    if (!file_exists($folderTemplatespecs)) {
        mkdir($folderTemplatespecs, 0755, true);
    }
    if (!file_exists($folderTrackingspecs)) {
        mkdir($folderTrackingspecs, 0755, true);
    }
    if (!file_exists($folderAltTextspecs)) {
        mkdir($folderAltTextspecs, 0755, true);
    }
    //Session Start
    session_start();
    // Import Jsonc
    $inactive = 1;
    ?>
    <div id="ajax-loader" style="display: none; z-index: 9999999;">
        <img src="<?php echo plugins_url('assets/images/loader.gif', __FILE__); ?>" style="width: 80px;">
    </div>
    
        <div class="container  mt-5 p-4">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg" class="branding_logo img-fluid w-auto" style="max-width: 294px; max-height: 130px;" width="294" height="59">
            <h1> Polaris RDS Websites </h1>
            <h5>Import Site Configurations</h5>
            <div class="col-md-12 mt-2">
                    
                    <div id="progress-bar" class="progress">
                        <div id="progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                    <!-- <div id="percentage">0%</div> -->
                </div>
            <div class="row mt-3">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-6 mb-4  upload-section" data-type="template">
                            <fieldset class="custom-border border-1 p-3">
                                <legend class="spec"><b> Features – Spec File 1 </b></legend>
                                <form class="file-upload-form" method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                                <div class="row ">

                                    <div class="col-md-7">
                                        <input type="file" class="form-control upload-input" name="import_file_template" data-upload-type="template" required>

                                    </div>
                                    <div class="col-md-5 pl-0">
                                        <a class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Download Default Spec File"  href="<?php echo get_home_url(); ?>/specs_files/template_configuration-RDS2.0.jsonc" download> Default</a>
                                        <a  class="btn btn-outline-primary download_spec" data-toggle="tooltip" data-placement="top" title="Download Last Processed File" href="javascript:void(0)" onclick="downloadJSON('feature');" >Latest</a>
                                        <?php if (get_latest_file($folderTemplatespecs)) { ?>
                                            <a  class="btn btn-outline-primary"  style="margin-left: 40px; display:none;"  href="<?php echo get_home_url(); ?>/wp-content/uploads/template_configuration/template_specs/<?php echo get_latest_file($folderTemplatespecs); ?>" download>Latest</a>
                        
                                    </div>
                                    <div class="col-md-12">

                                        <div class=" up mt-4 font-italic">Updated on : <?php get_date('rds_template_date'); ?>  |  Uploaded Version : <?php get_version('rds_template'); ?></div>

                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 text-right  ">
                                <input type="submit" style="cursor:pointer;" name="button_import_settings" value="Import" class=" btn-primary mt-3 font-weight-bold">
                            </div>
                            </form>
                            <!-- <div class="template-message" style="display:none;"></div> -->
                            </fieldset>
                            <div class="promotion-expiry-error">
                                <?php
                                $promotion = isset($_SESSION['promotion_error']) ? $_SESSION['promotion_error'] : "";
                                if ($promotion) {
                                    $time = isset($_SESSION['feature_time_stamp']) ? $_SESSION['feature_time_stamp'] : 0;
                                    $session_life = time() - $time;
                                    echo $promotion;
                                    if ($session_life > $inactive) {
                                        session_destroy();
                                    }
                                }
                                ?>
                            </div>
                            
                        </div>

                        <div class="col-md-6 mb-4 upload-section" data-type="design">

                            <fieldset class="custom-border border-1  p-3">
                                <legend class="spec"><b>Design  - Spec File 2</b></legend>
                                <form class="file-upload-form" method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                                <div class="row">
                                    <div class="col-md-7">

                                        <input type="file" class="form-control upload-input" name="import_file_design" data-upload-type="design" required>

                                    </div>
                                    <div class="col-md-5 pl-0">
                                        <a class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Download Default Spec File"  href="<?php echo get_home_url(); ?>/specs_files/design_config-RDS2.0.jsonc" download> Default</a>
                                        <a  class="btn btn-outline-primary download_spec" data-toggle="tooltip" data-placement="top" title="Download Last Processed File" href="javascript:void(0)" onclick="downloadJSON('design');" >Latest</a>
                                        <?php if (get_latest_file($folderTemplatespecs)) { 
                                            
                                            
                                            
                                            ?>
                                            <a  class="btn btn-outline-primary"  style="margin-left: 40px; display:none;"  href="<?php echo get_home_url(); ?>/wp-content/uploads/template_configuration/design_specs/<?php echo get_latest_file($folderTemplatespecs); ?>" download>Latest</a>
                        
                                    </div>
                                    <div class="col-md-12">

                                        <div class=" up mt-4 font-italic">Updated on : <?php get_date('rds_design_date'); ?>  |  Uploaded Version : <?php get_version('rds_design'); ?></div>

                                    </div>
                                   <?php } ?>
                                   <!-- <div class="progress-bar" id="design-progress-bar" style="width: 0%;"></div>
                                    <div class="progress-text" id="design-progress-text">0%</div> -->
                                </div>
                                <div class="col-md-12 text-right  ">
                                <input type="submit" style="cursor:pointer;" name="button_import_settings" value="Import" class=" btn-primary mt-3 font-weight-bold">
                            </div>
                            </form>
                            <!-- <div class="design-message" style="display:none;"></div> -->
                            </fieldset>
                            
                        </div>


                        <div class="col-md-6 mt-4 mb-4  ">
                            <fieldset class="custom-border h-100 p-3">
                                <legend class="spec"><b>Content – Spec File 3</b></legend>
                                <div class="row h-100 d-flex align-items-end justify-content-center">
                                    <div class="col-md-12 text-right  ">
                                        <a href="<?php echo get_home_url(); ?>/wp-admin/admin.php?import=wordpress"> <button type="submit" name="button_import_content_settings" value="Import" class=" btn-primary mt-3 font-weight-bold" style="cursor:pointer;">Import</button></a>
                                    </div>
                                </div> 
                            </fieldset>
                        </div>
                        <div class="col-md-6 mt-4 mb-4 upload-section" data-type="nav">
                            <fieldset class="custom-border border-1 p-3">
                                <legend class="spec"><b>Navigation – Spec File 4</b></legend>
                                <form class="file-upload-form" method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                                <div class="row">
                                    <div class="col-md-7">

                                        <input type="file" class="form-control upload-input" name="import_file_nav" data-upload-type="nav" required>

                                    </div>
                                    <div class="col-md-5 pl-0">
                                        <a class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Download Default Spec File"  href="<?php echo get_home_url(); ?>/specs_files/nav-RDS2.0.jsonc" download> Default</a>
                                        <a  class="btn btn-outline-primary download_spec" data-placement="top" title="Download Last Processed File" href="javascript:void(0)" onclick="downloadJSON('nav_settings');" >Latest</a>
                                        <?php if (get_latest_file($folderTemplatespecs)) { ?>
                                            <a  class="btn btn-outline-primary"  style="margin-left: 40px; display:none;"  href="<?php echo get_home_url(); ?>/wp-content/uploads/template_configuration/nav_specs/<?php echo get_latest_file($folderTemplatespecs); ?>" download>Latest</a>
                        
                                    </div>
                                    <div class="col-md-12">
                                    <?php

$checkFile =  get_latest_file($folderNavspecs);
if (!empty($checkFile)) {
    $fileUrl = get_home_url() . '/wp-content/uploads/template_configuration/nav_specs/' . get_latest_file($folderNavspecs);
    $response = wp_remote_get($fileUrl);
    $body = wp_remote_retrieve_body($response);
    if (json_validator($body) == false) {
        echo "<h3 style='color: red;'>JSON is not valid. Please check the vaild Spec file and refresh the page sdfgh.</h3>";
        exit();
    }
    $template_arr = json_decode($body, TRUE);
}
?>
<div class=" up mt-4 font-italic">Updated on : <?php get_date('rds_nav_date'); ?>  |  Uploaded Version :  <?php if (isset($template_arr) && is_array($template_arr) && isset($template_arr['spec_file']['rds_version']) && isset($template_arr['spec_file']['version'])) {
    echo $template_arr['spec_file']['rds_version'] . '.' . $template_arr['spec_file']['version'];
} ?></div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 text-right  ">
                                <input type="submit"  style="cursor:pointer;" name="button_import_settings" value="Import" class=" btn-primary mt-3 font-weight-bold">
                            </div>
                            </form>
                            <!-- <div class="nav-message" style="display:none;"></div> -->
                            </fieldset>
                            
                        </div>
                        <div class="col-md-6 mt-4 upload-section" data-type="tracking">
                            <fieldset class="custom-border border-1 p-3">
                                <legend class="spec"><b>Tracking – Spec File 5</b></legend>
                                <form class="file-upload-form" method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                                <div class="row">
                                    <div class="col-md-7">

                                        <input type="file" class="form-control upload-input" name="import_file_tracking" data-upload-type="tracking" required>

                                    </div>
                                    <div class="col-md-5 pl-0">
                                        <a class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Download Default Spec File"  href="<?php echo get_home_url(); ?>/specs_files/tracking_configuration-RDS2.0.jsonc" download> Default</a>
                                        <a  class="btn btn-outline-primary download_spec" data-placement="top" title="Download Last Processed File" href="javascript:void(0)" onclick="downloadJSON('tracking_config');" >Latest</a>
                                        <?php if (get_latest_file($folderTemplatespecs)) { ?>
                                            <a  class="btn btn-outline-primary"  style="margin-left: 40px; display:none;"  href="<?php echo get_home_url(); ?>/wp-content/uploads/template_configuration/tracking_specs/<?php echo get_latest_file($folderTemplatespecs); ?>" download>Latest</a>
                        
                                    </div>
                                    <div class="col-md-12">

                                        <div class=" up mt-4 font-italic">Updated on : <?php get_date('rds_tracking_date'); ?>  |  Uploaded Version : <?php get_version('rds_tracking'); ?></div>

                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 text-right  ">
                                <input type="submit"  style="cursor:pointer;" name="button_import_settings" value="Import" class=" btn-primary mt-3 font-weight-bold">
                            </div>
                            </form>
                            <!-- <div class="tracking-message" style="display:none;"></div> -->
                            </fieldset>

                        </div>
                        <div class="col-md-6 mt-4 upload-section" data-type="alt_text">
                            <fieldset class="custom-border h-100 border-1 p-3">
                                <legend class="spec"> <b>Alt Text – Spec File 6</b></legend>
                                <form class="file-upload-form" method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
                                <div class="row">
                                    <div class="col-md-7">

                                        <input type="file" class="form-control upload-input" name="import_file_alt_text" data-upload-type="alt_text" required>

                                    </div>
                                    <div class="col-md-5 pl-0">
                                        <a class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Download Default Spec File" href="<?php echo get_home_url(); ?>/specs_files/alt_text_configuration-RDS2.0.csv" download> Default</a>
                                        <a  class="btn btn-outline-primary download_spec" data-placement="top" title="Download Last Processed File" href="javascript:void(0)" onclick="downloadJSONALT();" >Latest</a>
                                        <?php if (get_latest_file($folderTemplatespecs)) { 
                                            
                                            ?>
                                            <a  class="btn btn-outline-primary"  style="margin-left: 40px; display:none;"  href="<?php echo get_home_url(); ?>/wp-content/uploads/template_configuration/alt_text_specs/<?php echo get_latest_file($folderTemplatespecs); ?>" download>Latest</a>
                        
                                    </div>
                                    <div class="col-md-12">

                                        <div class=" up mt-4 font-italic">Updated on : <?php get_date('rds_alt_text_date'); ?></div>

                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12 text-right  ">
                                <input type="submit"   style="cursor:pointer;" name="button_import_settings" value="Import" class=" btn-primary mt-3 font-weight-bold">
                            </div>
                            </form>
                            <!-- <div class="alt-text-message" style="display:none;"></div> -->
                            </fieldset>
                        </div>
                        <!-- <div class="col-md-12 text-right  ">
                            <input type="submit" name="button_import_settings" value="Import" class="import btn-primary mt-3 font-weight-bold">

                        </div> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="everservice-copyright">
            <p style="text-align: right;">© 2023, EverService LLC.  All Rights Reserved.</p>
        </div>


    <!-- </form> -->
    <div id="success-popup" style="display: none;">
        Successfully Uploaded!
    </div>

    
<?php 
}
function handle_uploaded_file() {

    //Variable define  
    global $wpdb;
    global $post;
    
    $targetDir = str_replace('\\', '/', ABSPATH) . "wp-content/uploads/";
    $teamPostDir = get_stylesheet_directory() . "/img/meet-the-team/";
    $folderTemplateConfigration = $targetDir . 'template_configuration/';
    $folderTemplatespecs = $folderTemplateConfigration . 'template_specs';
    $folderContentspecs = $folderTemplateConfigration . 'content_specs';
    $folderDesignspecs = $folderTemplateConfigration . 'design_specs';
    $folderNavspecs = $folderTemplateConfigration . 'nav_specs';
    $folderTrackingspecs = $folderTemplateConfigration . 'tracking_specs';
    $folderAltTextspecs = $folderTemplateConfigration . 'alt_text_specs';
    $timeStamp = time() . '.jsonc';

    if (!file_exists($folderTemplateConfigration)) {
        mkdir($folderTemplateConfigration, 0755, true);
    }
    if (!file_exists($folderContentspecs)) {
        mkdir($folderContentspecs, 0755, true);
    }
    if (!file_exists($folderDesignspecs)) {
        mkdir($folderDesignspecs, 0755, true);
    }
    if (!file_exists($folderNavspecs)) {
        mkdir($folderNavspecs, 0755, true);
    }
    if (!file_exists($folderTemplatespecs)) {
        mkdir($folderTemplatespecs, 0755, true);
    }
    if (!file_exists($folderTrackingspecs)) {
        mkdir($folderTrackingspecs, 0755, true);
    }
    if (!file_exists($folderAltTextspecs)) {
        mkdir($folderAltTextspecs, 0755, true);
    }

    

    processFile('import_file_template', $folderTemplatespecs, 'rds_template.php', 'template_specs', $timeStamp);
    processFile('import_file_design', $folderDesignspecs, 'rds_design.php', 'design_specs', $timeStamp);
    processFile('import_file_nav', $folderNavspecs, 'rds_nav_settings.php', 'nav_specs', $timeStamp);
    processFile('import_file_tracking', $folderTrackingspecs, 'rds_tracking.php', 'tracking_specs', $timeStamp);
    processFile('import_file_alt_text', $folderAltTextspecs, 'rds_alt_text.php', 'alt_text_specs', $timeStamp);

    // wp_send_json_success($data);
    wp_die();

}


add_action('wp_ajax_handle_uploaded_file', 'handle_uploaded_file');
add_action('wp_ajax_nopriv_handle_uploaded_file', 'handle_uploaded_file');


function processFile($fileType, $folder, $apiFile, $urlPath, $timeStamp) {
    // echo 'fileType=' . $fileType . '<br>';
    // echo 'folder=' . $folder . '<br>';
    // echo 'apiFile=' . $apiFile . '<br>';
    // echo 'urlPath=' . $urlPath . '<br>';
    // echo 'timeStamp=' . $timeStamp . '<br>';

    if (isset($_FILES[$fileType]) && $_FILES[$fileType]['error'] === 0) {


        if ($urlPath == 'alt_text_specs') {
            $targetFile = $folder . "/" . $timeStamp . '.csv';
            $moveUploadFile = move_uploaded_file($_FILES[$fileType]['tmp_name'], $targetFile);
            // $moveUploadFile = move_uploaded_file($_FILES["import_file_alt_text"]["tmp_name"], $targetFile);

            // echo '<pre>';
            // print_r($moveUploadFile);
            // echo '</pre>';
            // die();
            if ($moveUploadFile) {
                // File was successfully moved, now let's open and read it
                $file = fopen($targetFile, 'r');
                $fileUrl = get_home_url() . '/wp-content/uploads/template_configuration/alt_text_specs/' . time() . '.csv';
              
                
                if ($file) {
                    $body = array();
                    while (($line = fgetcsv($file)) !== FALSE) {
                        // $line is an array of the CSV elements
                        array_push($body, $line);
                    }
                    fclose($file);
                    $body = json_encode($body);
                } else {
                    // Handle the case where the file couldn't be opened
                    echo "Error opening the file for reading.";
                }
            } else {
                // Handle the case where the file couldn't be moved
                echo "Error moving the uploaded file to the target location.";
            }
        }else{
             $extension = pathinfo($_FILES[$fileType]['name'], PATHINFO_EXTENSION);
            $targetFile = $folder . '/' . $timeStamp;
            $moveUploadFile = move_uploaded_file($_FILES[$fileType]['tmp_name'], $targetFile);
            $fileUrl = get_home_url() . '/wp-content/uploads/template_configuration/' . $urlPath . '/' . $timeStamp;
            $response = wp_remote_get($fileUrl);
            $body = wp_remote_retrieve_body($response);
        }

       
        
         /*switch ($urlPath) {
            case 'design_specs':
                require_once ('rds_api/scssphp/scss.inc.php');
                require_once ('rds_api/' . $apiFile);
                processDesignData($body);
                break;
            case 'template_specs':
                require_once ('rds_api/' . $apiFile);
                processTemplateData($body);
                break;
            case 'nav_specs':
                require_once ('rds_api/' . $apiFile);
                processNavigationData($body);
                break;
            case 'tracking_specs':
                require_once ('rds_api/' . $apiFile);
                processTrackingData($body);
                break;
            default:
                break;
        }*/

        if ($urlPath == 'design_specs') {
            require_once ('rds_api/scssphp/scss.inc.php');
            require_once ('rds_api/' . $apiFile);
            processDesignData($body, $urlPath);
        }elseif ($urlPath == 'template_specs') {
            require_once ('rds_api/' . $apiFile);
            processTemplateData($body, $urlPath);
        }elseif ($urlPath == 'nav_specs') {
            require_once ('rds_api/' . $apiFile);
            processNavigationData($body, $urlPath);
        }elseif ($urlPath == 'tracking_specs') {
            require_once ('rds_api/' . $apiFile);
            processTrackingData($body, $urlPath);
        }elseif ($urlPath == 'alt_text_specs') {
            require_once ('rds_api/' . $apiFile);
            processaltData($body);
        }
        
    }
}


/**
 * Add settings page to the menu.
 */
function togglePages($get_rds_template) {
    get_page_template_enable(get_page_by_template("page-templates/rds-homepage.php"), $get_rds_template["page_templates"]["homepage"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-subpage-sidebar.php"), $get_rds_template["page_templates"]["subpage_sidebar"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-subpage-withoutsidebar.php"), $get_rds_template["page_templates"]["subpage"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-service-subpage-sidebar.php"), $get_rds_template["page_templates"]["service_subpage"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-thankyou.php"), $get_rds_template["page_templates"]["thankyou_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-gallery.php"), $get_rds_template["page_templates"]["gallery_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-review.php"), $get_rds_template["page_templates"]["testimonial_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-promotion.php"), $get_rds_template["page_templates"]["promotions"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-team.php"), $get_rds_template["page_templates"]["team_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-schedule-services.php"), $get_rds_template["page_templates"]["schedule_service_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-free-estimate.php"), $get_rds_template["page_templates"]["free_estimate_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-financing.php"), $get_rds_template["page_templates"]["finance_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-history.php"), $get_rds_template["page_templates"]["history_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-careers.php"), $get_rds_template["page_templates"]["career_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-contactpage.php"), $get_rds_template["page_templates"]["contact_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-about-us.php"), $get_rds_template["page_templates"]["about_us_page"]["enable"]);
    get_page_template_enable(get_page_by_template("page-templates/rds-landing.php"), $get_rds_template["page_templates"]["landing_page"]["enable"]);
}

/**
 * Perform MongoDB API request.
 */
function mongodbAPI($method, $specfile, $content) {
    $current_user = wp_get_current_user();
    $url = "https://bluecorona2.fullstackondemand.com/bc-rds-mongo/";
    // Data to be sent as POST request body
    $data = ["created_user" => $current_user->user_login, "modified_user" => $current_user->user_login, "created_date" => date(get_option("date_format")), "modified_date" => date(get_option("date_format")), "site_name" => get_bloginfo("name"), "site_url" => get_site_url(), "specfile" => $specfile, "email" => $current_user->user_email, "content" => $content, "method" => $method, ];
    // Initialize cURL
    $ch = curl_init($url);
    // Set cURL options
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true); // set the HTTP method to POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // set the request body
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the response instead of outputting it
    // Execute the cURL request
    $response = curl_exec($ch);
    // Check for errors
    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
    }
    // Close the cURL handle
    curl_close($ch);
    // Output the response
    if ($method == "GET") {
        return $response;
    }
}

/**
 * Validate JSON data.
 */
function json_validator($data) {
    if (!empty($data)) {
        return is_string($data) && is_array(json_decode($data, true)) ? true : false;
    }
    return false;
}

/**
 * Get pages by template.
 */
function get_page_by_template($template = "") {
    $args = ["post_status" => ["publish", "draft"], "meta_key" => "_wp_page_template", "meta_value" => $template, ];
    return get_pages($args);
}

/**
 * Enable or disable page templates.
 */
function get_page_template_enable($template_arr, $status) {
    $array_object = json_decode(json_encode($template_arr), true);
    $status = $status ? "publish" : "draft";
    foreach ($array_object as $value) {
        if (!empty($value["ID"])) {
            $post = ["ID" => $value["ID"], "post_status" => $status];
            wp_update_post($post);
        }
    }
}

/**
 * Register REST API routes.
 */
function register_rds_rest_routes() {
    register_rest_route('rds/v1', '/spec/(?P<spec_name>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'rds_get_spec_data',
        'permission_callback' => 'rds_api_permission_check',
    ));

    register_rest_route('rds/v1', '/spec/(?P<spec_name>[a-zA-Z0-9_-]+)', array(
        'methods' => 'POST',
        'callback' => 'rds_update_spec_data',
        'permission_callback' => 'rds_api_permission_check',
    ));
}
// Hook for registering REST API routes
add_action('rest_api_init', 'register_rds_rest_routes');

/**
 * Check API key for permission.
 */
function rds_api_permission_check($request) {
    $api_key = $request->get_header('API-Key');
    $valid_api_key = RDS_API_KEY;
    if ($api_key === $valid_api_key) {
        return true;
    } else {
        return new WP_Error('rest_forbidden', esc_html__('Authentication failed.', 'text-domain'), array('status' => 401));
    }
}

function rds_update_spec_data($request) {
    global $wpdb;
    global $post;
    $tableName = $wpdb->prefix . "options";
    $targetDir = str_replace("\\", "/", ABSPATH) . "wp-content/uploads/";
    $teamPostDir = get_stylesheet_directory() . "/img/meet-the-team/";
    $folderTemplateConfigration = $targetDir . "template_configuration/";
    $folderTemplatespecs = $folderTemplateConfigration . "template_specs";
    $folderContentspecs = $folderTemplateConfigration . "content_specs";
    $folderDesignspecs = $folderTemplateConfigration . "design_specs";
    $folderNavspecs = $folderTemplateConfigration . "nav_specs";
    $folderTrackingspecs = $folderTemplateConfigration . "tracking_specs";
    $folderAltTextspecs = $folderTemplateConfigration . "alt_text_specs";
    $timeStamp = time() . ".jsonc";
    if (!file_exists($folderTemplateConfigration)) {
        mkdir($folderTemplateConfigration, 0755, true);
    }
    if (!file_exists($folderContentspecs)) {
        mkdir($folderContentspecs, 0755, true);
    }
    if (!file_exists($folderDesignspecs)) {
        mkdir($folderDesignspecs, 0755, true);
    }
    if (!file_exists($folderNavspecs)) {
        mkdir($folderNavspecs, 0755, true);
    }
    if (!file_exists($folderTemplatespecs)) {
        mkdir($folderTemplatespecs, 0755, true);
    }
    if (!file_exists($folderTrackingspecs)) {
        mkdir($folderTrackingspecs, 0755, true);
    }
    if (!file_exists($folderAltTextspecs)) {
        mkdir($folderAltTextspecs, 0755, true);
    }

    $spec_name = $request['spec_name'];
    $params = $request->get_json_params();
    $body = json_encode($params);
    $msg = '';
    if ($spec_name === "rds_template") {
        $start_time = microtime(true);
        require_once ('rds_api/rds_template.php');
         $msg = processTemplateData($body, $spec_name);
         // echo json_encode($msg);
        $end_time = microtime(true);
    } else if ($spec_name === "rds_design") {
        $start_time = microtime(true);
        require_once ('rds_api/scssphp/scss.inc.php');
        require_once ('rds_api/rds_design.php');
        $msg = processDesignData($body, $spec_name);
        $end_time = microtime(true);
    } else if ($spec_name === "rds_nav_settings") {
        $start_time = microtime(true);
        require_once ('rds_api/rds_nav_settings.php');
        $msg = processNavigationData($body, $spec_name);
        $end_time = microtime(true);
    } else if ($spec_name === 'rds_tracking') {
        $start_time = microtime(true);
        require_once ('rds_api/rds_tracking.php');
         $msg = processTrackingData($body, $spec_name);
        $end_time = microtime(true);
    } else {
        $msg.= ucfirst($spec_name) . ' data NOT updated. ';
    }
    $execution_time = $end_time - $start_time;
    $time = number_format($execution_time, 2);
    $response_data = ['execution_time' => $time, 'message' => $msg, ];
    header('Content-Type: application/json');
    echo json_encode($response_data);
    // return $msg;
}

/**
 * Get spec data.
 */
function rds_get_spec_data($data) {
    return json_decode(get_option($data['spec_name']));
}


function rds_validateJson($json) {
    return json_decode($json) !== null;
}
function rds_getSetting($wpdb, $tableName, $optionName) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM $tableName WHERE option_name = %s", $optionName);
    return $wpdb->get_results($query);
}
function rds_updateSetting($wpdb, $tableName, $optionName, $optionValue) {
    global $wpdb;
    $result = $wpdb->update($tableName, array('option_value' => $optionValue), array('option_name' => $optionName));
    return $result;
}


// Add Conditionally css & js for specific pages
add_action('admin_enqueue_scripts', 'bc_csv_include_css_js');

function bc_csv_include_css_js($hook) {
    $current_screen = get_current_screen();
    // echo "jhjdfhdsgfjdgfds";

        wp_register_style('bc-csv-greyscale', plugins_url('assets/css/bc-csv-style.css', __FILE__), array(), '1.0.0', 'all');
        wp_enqueue_style('bc-csv-greyscale');
        rds_download_spec_data();
    
    require_once('rds_api/scssphp/scss.inc.php');
}

function rds_template() {
    $rdsTemplate = get_option('rds_template');
    return json_decode($rdsTemplate, TRUE);
}

function rds_alt_text() {
    $rdsAltText = get_option('rds_alt_text');
    // print_r($rdsAltText);
    return json_decode($rdsAltText, TRUE);
}

function rds_tracking() {
    $rdsTracking = get_option('rds_tracking');
    return json_decode($rdsTracking, TRUE);
}

function rds_design() {
    $rdsDesign = get_option('rds_design');
    return json_decode($rdsDesign, TRUE);
}

function rds_nav_settings() {
    $rdsNav = get_option('rds_nav_settings');
    return json_decode($rdsNav, TRUE);
}

function get_version($template) {
    $GetTemplate = get_option($template);
    if (!empty($GetTemplate)) {
        $decodedTemplate = json_decode($GetTemplate, TRUE);
        if (isset($decodedTemplate['spec_file']['rds_version']) && isset($decodedTemplate['spec_file']['version'])) {
            print_r($decodedTemplate['spec_file']['rds_version'] . '.');
            print_r($decodedTemplate['spec_file']['version']);
        }
    }
}
/*function get_version($template) {

    $GetTemplate = get_option($template);
    if(!empty($GetTemplate)){
    print_r((json_decode($GetTemplate, TRUE))['spec_file']['rds_version'].'.');
    print_r((json_decode($GetTemplate, TRUE))['spec_file']['version']);
}
}*/
function get_date($template) {

    $GetDateTemplate = get_option($template);
    print_r($GetDateTemplate);
}





//download script
function rds_download_spec_data() {
    ob_start();
    ?>
   
        <script>
    function downloadJSONALT() {
         <?php $siteName = get_bloginfo("name"); 
                $underscoredString = str_replace(' ', '_', $siteName);  ?>
            // Your data retrieval logic
            // Example data, replace this with your actual data
            console.log();

            var data  = <?php echo json_encode(rds_alt_text()); ?>;

            // Create a CSV string
            var csvContent = "";

            data.forEach(function (rowArray) {
                var row = rowArray.join(",");
                csvContent += row + "\r\n";
            });

            // Create a Blob object
            var blob = new Blob([csvContent], { type: 'text/csv' });

            // Create a download link
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "<?= $underscoredString; ?>-Alt-Text-RDS2.0.csv";

            // Append the link to the body
            document.body.appendChild(link);

            // Trigger a click on the link to start the download
            link.click();

            // Remove the link from the body
            document.body.removeChild(link);

            // Attach the function to the button click event
            document.getElementById("downloadCsvButton").addEventListener("click", downloadCsv);
            }
            function downloadJSON(spec_file_type) {
                <?php $siteName = get_bloginfo("name"); 
                $underscoredString = str_replace(' ', '_', $siteName);  ?>
                var data = "";
                if (spec_file_type == "feature") {
                    data = <?php echo json_encode(rds_get_template_settings()) ?>;
                } else if (spec_file_type == "design") {
                    data = <?php echo json_encode(rds_design()); ?>;
                } else if (spec_file_type == "content") {
                    data = "";
                }  else if (spec_file_type == "nav_settings") {
                    data = <?php echo json_encode(rds_nav_settings()); ?>;
                } else if (spec_file_type == "tracking_config") {
                    data = <?php echo json_encode(rds_tracking()); ?>;
                }
                const titleCase = (s) => s.replace(/\b\w/g, c => c.toUpperCase()); 
                var json = JSON.stringify(data, null, 4);
                var version = data.spec_file.version;
                console.log('version>>>>>',version)
                var blob = new Blob([json], {type: 'application/json'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = "<?= $underscoredString; ?>-" + titleCase(spec_file_type) + '-' + version + '-RDS2.0.json';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        </script>
    <?php
}

// Hook into the wp_trash_post hook to check when a post is trashed
add_action('wp_trash_post', 'rds_post_trashed_promotion');

//
function rds_get_template_settings() {
    $array = rds_template();
    $k = 0;
    $l = 0;
    // Output the response
    if (!empty($array['globals']['promotion']['items'])) {
        foreach ($array['globals']['promotion']['items'] as $item) {
            if (get_post_status($item['post_id']) !== "publish") {
                unset($array['globals']['promotion']['items'][$l]);
            }
            $l++;
        }
        $new_arr = $array;
        foreach ($new_arr['globals']['promotion']['items'] as $item) {
            $post_id = $item['post_id'];
            $pr_categry = get_the_terms($post_id, 'bc_promotion_category');
            $pr_cat_array = array();
            if (!empty($pr_categry)) {
                foreach ($pr_categry as $pcat) {
                    $pr_cat_array[] = $pcat->name;
                }
            }
            $new_arr['globals']['promotion']['items'][$k]['title'] = get_the_title($post_id);
            $new_arr['globals']['promotion']['items'][$k]['post_id'] = $post_id;
            $new_arr['globals']['promotion']['items'][$k]['heading'] = get_post_meta($post_id, 'promotion_heading', true);
            $new_arr['globals']['promotion']['items'][$k]['subheading'] = get_post_meta($post_id, 'promotion_subheading', true);
            $new_arr['globals']['promotion']['items'][$k]['button_label'] = get_post_meta($post_id, 'request_button_title', true);
            $new_arr['globals']['promotion']['items'][$k]['button_link'] = get_post_meta($post_id, 'request_button_link', true);
            $new_arr['globals']['promotion']['items'][$k]['background_color_code'] = get_post_meta($post_id, 'promotion_color', true);
            $new_arr['globals']['promotion']['items'][$k]['expiry_date'] = get_post_meta($post_id, 'promotion_expiry_date1', true);
            $new_arr['globals']['promotion']['items'][$k]['last_date_of_month'] = get_post_meta($post_id, 'promotion_expiry_enddate', true);
            $new_arr['globals']['promotion']['items'][$k]['open_new_tab'] = get_post_meta($post_id, 'promotion_open_new_tab', true);
            $new_arr['globals']['promotion']['items'][$k]['auto_renew'] = get_post_meta($post_id, 'promotion_recurring_setting', true);
            $new_arr['globals']['promotion']['items'][$k]['no_expiry'] = get_post_meta($post_id, 'promotion_noexpiry', true);
            $new_arr['globals']['promotion']['items'][$k]['show_in_banner'] = get_post_meta($post_id, 'promotion_show_banner_setting', true);
            $new_arr['globals']['promotion']['items'][$k]['disclaimer'] = get_post_meta($post_id, 'promotion_footer_heading', true);
            $new_arr['globals']['promotion']['items'][$k]['more_info'] = get_post_meta($post_id, 'promotion_more_info', true);
            $new_arr['globals']['promotion']['items'][$k]['category'] = $pr_cat_array;
            $k++;
        }
    }
    return $array;
}



// Hook into the wp_trash_post hook to check when a post is trashed
add_action('wp_trash_post', 'rds_post_trashed_promotion');

function rds_post_trashed_promotion($post_id) {
    // Check if the post is being trashed
    if (get_post_type($post_id) == "bc_promotions") {
        rds_post_trashed_and_restored("trashed", $post_id);
    }
}



//function for trashed and draft 
function rds_post_trashed_and_restored($status, $promotion_id) {
    $array = rds_template();
    $k = 0;
    $new_arr = array();
    $current_user = wp_get_current_user();
    $mongo_promotion = mongodbAPI('GET', 'feature', NULL);
    $mongo_promotion = json_decode($mongo_promotion, true);
    $promotions = get_posts(['post_type' => 'bc_promotions', "posts_per_page" => -1]);
    // Output the response
    if (!empty($array['globals']['promotion']['items']) && !empty($mongo_promotion['globals']['promotion']['items'])) {
        foreach ($array['globals']['promotion']['items'] as $item) {
            $created_user = $mongo_promotion['globals']['promotion']['items'][$k]["created_user"];
            $modified_user = $mongo_promotion['globals']['promotion']['items'][$k]["modified_user"];
            $created_date = $mongo_promotion['globals']['promotion']['items'][$k]['created_date'];
            $modified_date = $mongo_promotion['globals']['promotion']['items'][$k]['modified_date'];
            $st = get_post_status($item['post_id']);
            if ($promotion_id == $item['post_id']) {
                $postID = $promotion_id;
                $st = $status;
                $modified_user = $current_user->user_login;
                $modified_date = date(get_option("date_format"));
            }
            if ($mongo_promotion['globals']['promotion']['items'][$k]['post_id'] === $item['post_id']) {
                $postID = $item['post_id'];
            }
            $user_info = array('create_user' => $created_user, "modified_user" => $modified_user, "status" => $st, "created_date" => $created_date, "modified_date" => $modified_date);
            $new_arr = rds_promotion_array($new_arr, $k, $postID, $user_info);

            $k++;
        }
    } else if (empty($array['globals']['promotion']['items']) && empty($mongo_promotion['globals']['promotion']['items']) && !empty(get_posts(['post_type' => 'bc_promotions', "posts_per_page" => -1]))) {
        $q = 0;
        foreach ($promotions as $promotion) {
            $created_user = $current_user->user_login;
            $modified_user = "";
            $created_date = date(get_option("date_format"));
            $modified_date = "";
            $st = get_post_status($promotion->ID);
            $postID = $promotion->ID;
            $user_info = array('create_user' => $created_user, "modified_user" => $modified_user, "status" => $st, "created_date" => $created_date, "modified_date" => $modified_date);
            $new_arr = rds_promotion_array($new_arr, $q, $postID, $user_info);
            $q++;
        }
    }
    rds_update_mongo_db($array, $new_arr);
}



//Get Promotions Array
function rds_promotion_array($new_arr, $k, $post_id, $user_info) {
    $pr_categry = get_the_terms($post_id, 'bc_promotion_category');
    $pr_cat_array = array();
    if (!empty($pr_categry)) {
        foreach ($pr_categry as $pcat) {
            $pr_cat_array[] = $pcat->name;
        }
    }
    $new_arr['globals']['promotion']['items'][$k]['status'] = $user_info['status'];
    $new_arr['globals']['promotion']['items'][$k]['created_user'] = $user_info['create_user'];
    $new_arr['globals']['promotion']['items'][$k]['modified_user'] = $user_info['modified_user'];
    $new_arr['globals']['promotion']['items'][$k]['created_date'] = $user_info['created_date'];
    $new_arr['globals']['promotion']['items'][$k]['modified_date'] = $user_info['modified_date'];
    $new_arr['globals']['promotion']['items'][$k]['title'] = get_the_title($post_id);
    $new_arr['globals']['promotion']['items'][$k]['post_id'] = $post_id;
    $new_arr['globals']['promotion']['items'][$k]['heading'] = get_post_meta($post_id, 'promotion_heading', true);
    $new_arr['globals']['promotion']['items'][$k]['subheading'] = get_post_meta($post_id, 'promotion_subheading', true);
    $new_arr['globals']['promotion']['items'][$k]['button_label'] = get_post_meta($post_id, 'request_button_title', true);
    $new_arr['globals']['promotion']['items'][$k]['button_link'] = get_post_meta($post_id, 'request_button_link', true);
    $new_arr['globals']['promotion']['items'][$k]['background_color_code'] = get_post_meta($post_id, 'promotion_color', true);
    $new_arr['globals']['promotion']['items'][$k]['expiry_date'] = get_post_meta($post_id, 'promotion_expiry_date1', true);
    $new_arr['globals']['promotion']['items'][$k]['last_date_of_month'] = get_post_meta($post_id, 'promotion_expiry_enddate', true);
    $new_arr['globals']['promotion']['items'][$k]['open_new_tab'] = get_post_meta($post_id, 'promotion_open_new_tab', true);
    $new_arr['globals']['promotion']['items'][$k]['auto_renew'] = get_post_meta($post_id, 'promotion_recurring_setting', true);
    $new_arr['globals']['promotion']['items'][$k]['no_expiry'] = get_post_meta($post_id, 'promotion_noexpiry', true);
    $new_arr['globals']['promotion']['items'][$k]['show_in_banner'] = get_post_meta($post_id, 'promotion_show_banner_setting', true);
    $new_arr['globals']['promotion']['items'][$k]['disclaimer'] = get_post_meta($post_id, 'promotion_footer_heading', true);
    $new_arr['globals']['promotion']['items'][$k]['more_info'] = get_post_meta($post_id, 'promotion_more_info', true);
    $new_arr['globals']['promotion']['items'][$k]['category'] = $pr_cat_array;
    return $new_arr;
}


function rds_update_mongo_db($array, $new_arr) {
    $i = 0;
    $array['globals']['promotion']['items'] = $new_arr['globals']['promotion']['items'];
    $arr = $array;
    foreach ($array['globals']['promotion']['items'] as $user) {
        unset($array['globals']['promotion']['items'][$i]['modified_user']);
        unset($array['globals']['promotion']['items'][$i]['created_user']);
        unset($array['globals']['promotion']['items'][$i]['created_date']);
        unset($array['globals']['promotion']['items'][$i]['modified_date']);
        unset($array['globals']['promotion']['items'][$i]['status']);
        $i++;
    }
    global $wpdb;
    $tableName = $wpdb->prefix . 'options';
    $json = str_replace("\/", "/", json_encode($array, JSON_PRETTY_PRINT));
    $json1 = str_replace("\/", "/", json_encode($arr, JSON_PRETTY_PRINT));
//        echo"<pre>";
//        print_r($json1);
//        echo"<pre>";
//        print_r($json);
//        exit;
    $wpdb->update($tableName, array('option_value' => $json), array('option_name' => 'rds_template'));
    mongodbAPI('POST', 'feature', $json1);
}



add_action('wp_head', 'rds_font_family_script');

function rds_font_family_script() {
    $get_rds_design = rds_design();
    ?>
        <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="<?php //echo $get_rds_design['defaults']['fonts']['default_font_family_url']; ?>" rel="stylesheet">
        <link href="<?php //echo $get_rds_design['defaults']['fonts']['alternate_font_family_1_url']; ?>" rel="stylesheet">
        <link href="<?php //echo $get_rds_design['defaults']['fonts']['alternate_font_family_2_url']; ?>" rel="stylesheet">
        <link href="<?php //echo $get_rds_design['defaults']['fonts']['alternate_font_family_3_url']; ?>" rel="stylesheet"> -->


    <?php
}

//tracking code implement
$get_rds_tracking = rds_tracking();
if (isset($get_rds_tracking)) {
if ($get_rds_tracking['tracking']['enable'] == true) {


    add_action('rds_head_top', 'rds_head_top_tracking_code');

    function rds_head_top_tracking_code() {
        $tracking_script = ["Google_Tag_Manager" => "tracking-script/google-tag-manager.php", "Google" => "tracking-script/google-analytics-and-google-ads.php", "Google_Search_Console" => "tracking-script/google-search-console.php", "Google_Ads_Conversion_Codes" => "tracking-script/google-ads-conversion-codes.php", "Facebook_Pixel" => "tracking-script/facebook-pixel.php", "Bing_Ads_Pixel" => "tracking-script/bing-ads-pixel.php"];
        $get_rds_tracking = rds_tracking();
        $rds_head_top_arr = array();
        if ($get_rds_tracking['tracking']['enable'] == true) {
            foreach ($get_rds_tracking['tracking'] as $key => $value) {
                if (is_array($value) && !empty($value) && $value['enable'] == true) {
                    $rds_head_top_arr[$key] = $value;
                }
            }
        }
        foreach ($get_rds_tracking['custom']['head_top'] as $key => $value) {

            if (is_array($value) && !empty($value) && $value['enable'] == true)
                $rds_head_top_arr['custom' . $value['order']] = $value;
        }

        $tracking_order = array_column($rds_head_top_arr, 'order');
        array_multisort($tracking_order, SORT_ASC, $rds_head_top_arr);

        foreach ($rds_head_top_arr as $key => $value) {
            if (array_key_exists($key, $tracking_script)) {
                require_once($tracking_script[$key]);
            } else {
                if (isset($rds_head_top_arr[$key]['page_ids']) && count($rds_head_top_arr[$key]['page_ids']) > 0) {
                    foreach ($rds_head_top_arr[$key]['page_ids'] as $values) {
                        if (is_page($values)) {
                            echo $value['content'];
                        }
                    }
                } elseif ($rds_head_top_arr[$key]['enable'] == true && isset($value['content'])) {
                    echo $value['content'];
                }
            }
        }
    }

    if (sizeof(array_column($get_rds_tracking['custom']['head_bottom'], 'order')) > 0) {
        add_action('rds_head_bottom', 'rds_head_bottom_tracking_code');
    }

    function rds_head_bottom_tracking_code() {
        $get_rds_tracking = rds_tracking();
        if ($get_rds_tracking['tracking']['enable'] == true) {
        $rds_head_bottom_arr = $get_rds_tracking['custom']['head_bottom'];

        $tracking_order = array_column($rds_head_bottom_arr, 'order');
        array_multisort($tracking_order, SORT_ASC, $rds_head_bottom_arr);

        foreach ($rds_head_bottom_arr as $key => $value) {

            if (count($value['page_ids']) > 0) {

                foreach ($value['page_ids'] as $values) {
                    if (is_page($values)) {
                        echo $value['content'];
                    }
                }
            } elseif ($value['enable'] == true) {

                echo $value['content'];
            }
        }
    }
    }

    if (sizeof(array_column($get_rds_tracking['custom']['footer_top'], 'order')) > 0) {
        add_action('rds_footer_top', 'rds_footer_top_tracking_code');
    }

    function rds_footer_top_tracking_code() {
        $get_rds_tracking = rds_tracking();
        $rds_footer_top_arr = $get_rds_tracking['custom']['footer_top'];

        $tracking_order = array_column($rds_footer_top_arr, 'order');
        array_multisort($tracking_order, SORT_ASC, $rds_footer_top_arr);

        foreach ($rds_footer_top_arr as $key => $value) {

            if (count($value['page_ids']) > 0) {

                foreach ($value['page_ids'] as $values) {
                    if (is_page($values)) {
                        echo $value['content'];
                    }
                }
            } elseif ($value['enable'] == true) {

                echo $value['content'];
            }
        }
        if ($get_rds_tracking['Hotjar']['enable'] == true) {

            require_once('tracking-script/hot-jar.php');
        }
        if ($get_rds_tracking['accessibility']['enable'] == true) {

            require_once('tracking-script/accessibility.php'); 
        }
    }

    if (sizeof(array_column($get_rds_tracking['custom']['footer_bottom'], 'order')) > 0) {
        add_action('rds_footer_bottom', 'rds_footer_bottom_tracking_code');
    }

    function rds_footer_bottom_tracking_code() {

        $get_rds_tracking = rds_tracking();
        $rds_footer_bottom_arr = $get_rds_tracking['custom']['footer_bottom'];
        $tracking_order = array_column($rds_footer_bottom_arr, 'order');
        array_multisort($tracking_order, SORT_ASC, $rds_footer_bottom_arr);

        foreach ($rds_footer_bottom_arr as $key => $value) {

            if (count($value['page_ids']) > 0) {

                foreach ($value['page_ids'] as $values) {
                    if (is_page($values)) {
                        echo $value['content'];
                    }
                }
            } elseif ($value['enable'] == true) {

                echo $value['content'];
            }
        }
        $rds_schema = $get_rds_tracking['schema'];
        if ($rds_schema['enable']) {
            unset($rds_schema['enable']);
            echo('<script type="application/ld+json">' . str_replace("\/", "/", json_encode($rds_schema, JSON_PRETTY_PRINT)) . "</script>");
        }
        //Call Schema meta box start
        $id = get_queried_object_id();
        $schema_meta = get_post_meta($id, "rds_schema", true);
        if (!empty($schema_meta)) {
            echo ('<script type="application/ld+json">' . $schema_meta . '</script>');
        }
        //Call Schema meta box End
    }

    if ($get_rds_tracking['tracking']['Google_Tag_Manager']['enable'] == true) {
        add_action('rds_body', 'rds_global_body_tracking_code', $get_rds_tracking['tracking']['Google_Tag_Manager']['order']);

        function rds_global_body_tracking_code() {
            require_once('tracking-script/google-tag-manager-body.php');
        }

    }

    if ($get_rds_tracking['Google_Ads_Conversion_Codes']['enable'] == true) {
        add_action('wp_footer', 'add_this_script_footer');

        function add_this_script_footer() {
            require_once("tracking-script/google-ads-conversion-codes.php");
        }

    }

    if ($get_rds_tracking['invoca']['enable'] == true) {
        add_action('wp_footer', 'add_invoca_script_footer');

        function add_invoca_script_footer() {
            require_once('tracking-script/invoca-script.php');
        }

    }
}
}

// Add an action to check for new/updated posts
add_action('save_post', 'check_for_new_post');

function check_for_new_post($promotion_id) {
    // Get the status of the post
    if (get_post_status($promotion_id) == 'publish' && get_post_type($promotion_id) == "bc_promotions" && !isset($_POST['button_import_template_settings'])) {
        $array = rds_template();
        
        // Check if $array['globals']['promotion']['items'] is defined and not null
        if (isset($array['globals']['promotion']['items']) && is_array($array['globals']['promotion']['items'])) {
            $j = count($array['globals']['promotion']['items']);
        } else {
            $j = 0; // Set $j to 0 if the array is not defined or null
        }
        
        $k = 0;
        $mongo_promotion = mongodbAPI('GET', 'feature', NULL);
        $mongo_promotion = json_decode($mongo_promotion, true);
        $post_ids = array();
        $created_user = "";
        $current_user = wp_get_current_user();
        $new_arr = array();
        // Output the response
        $promotions = get_posts(['post_type' => 'bc_promotions', "posts_per_page" => -1]);
        foreach ($promotions as $item) {
            if (!empty($mongo_promotion) && isset($mongo_promotion['globals']['promotion']['items'])) {
                $created_user = $mongo_promotion['globals']['promotion']['items'][$k]["created_user"];
                $modified_user = $mongo_promotion['globals']['promotion']['items'][$k]["modified_user"];
            }
            if (isset($item->ID) && $item->ID == $promotion_id) {
                $post_ids[] = $promotion_id;
                $post_id = $promotion_id;
                $created_user = $created_user;
                $create_date = $mongo_promotion['globals']['promotion']['items'][$k]['created_date'];
                $modified_date = date(get_option('date_format'));
                $status = get_post_status($item->ID);
                $modified_user = $current_user->user_login;
            } else {
                $created_user = $created_user;
                $create_date = $mongo_promotion['globals']['promotion']['items'][$k]['created_date'];
                $modified_date = $mongo_promotion['globals']['promotion']['items'][$k]['modified_date'];
                $status = get_post_status($item->ID);
                $modified_user = $modified_user;
                $post_id = $item->ID;
                $post_ids[] = $post_id;
            }
            $user_info = array(
                'create_user' => $created_user,
                "modified_user" => $modified_user,
                "status" => $status, "created_date" => $create_date,
                "modified_date" => $modified_date
            );
            $new_arr = rds_promotion_array($new_arr, $k, $post_id, $user_info);

            $k++;
        }
        if (!in_array($promotion_id, $post_ids)) {
            $created_user = $current_user->user_login;
            $modified_user = "";
            $create_date = date(get_option('date_format'));
            $modified_date = "";
            $status = get_post_status($promotion_id);
            $user_info = array(
                'create_user' => $created_user,
                "modified_user" => $modified_user,
                "status" => $status, "created_date" => $create_date,
                "modified_date" => $modified_date
            );
            $new_arr = rds_promotion_array($new_arr, $j, $promotion_id, $user_info);
        }
        rds_update_mongo_db($array, $new_arr);
    }
}
/*add_action('save_post', 'check_for_new_post');

function check_for_new_post($promotion_id) {
    // Get the status of the post
    if (get_post_status($promotion_id) == 'publish' && get_post_type($promotion_id) == "bc_promotions" && !isset($_POST['button_import_template_settings'])) {
        $array = rds_template();
        $j = count($array['globals']['promotion']['items']);
        $k = 0;
        $mongo_promotion = mongodbAPI('GET', 'feature', NULL);
        $mongo_promotion = json_decode($mongo_promotion, true);
        $post_ids = array();
        $created_user = "";
        $current_user = wp_get_current_user();
        $new_arr = array();
        // Output the response
        $promotions = get_posts(['post_type' => 'bc_promotions', "posts_per_page" => -1]);
        foreach ($promotions as $item) {
            if (!empty($mongo_promotion) && isset($mongo_promotion['globals']['promotion']['items'])) {
                $created_user = $mongo_promotion['globals']['promotion']['items'][$k]["created_user"];
                $modified_user = $mongo_promotion['globals']['promotion']['items'][$k]["modified_user"];
            }
            if (isset($item->ID) && $item->ID == $promotion_id) {
                $post_ids[] = $promotion_id;
                $post_id = $promotion_id;
                $created_user = $created_user;
                $create_date = $mongo_promotion['globals']['promotion']['items'][$k]['created_date'];
                $modified_date = date(get_option('date_format'));
                $status = get_post_status($item->ID);
                $modified_user = $current_user->user_login;
            } else {
                $created_user = $created_user;
                $create_date = $mongo_promotion['globals']['promotion']['items'][$k]['created_date'];
                $modified_date = $mongo_promotion['globals']['promotion']['items'][$k]['modified_date'];
                $status = get_post_status($item->ID);
                $modified_user = $modified_user;
                $post_id = $item->ID;
                $post_ids[] = $post_id;
            }
            $user_info = array(
                'create_user' => $created_user,
                "modified_user" => $modified_user,
                "status" => $status, "created_date" => $create_date,
                "modified_date" => $modified_date
            );
            $new_arr = rds_promotion_array($new_arr, $k, $post_id, $user_info);

            $k++;
        }
        if (!in_array($promotion_id, $post_ids)) {
            $created_user = $current_user->user_login;
            $modified_user = "";
            $create_date = date(get_option('date_format'));
            $modified_date = "";
            $status = get_post_status($promotion_id);
            $user_info = array(
                'create_user' => $created_user,
                "modified_user" => $modified_user,
                "status" => $status, "created_date" => $create_date,
                "modified_date" => $modified_date
            );
            $new_arr = rds_promotion_array($new_arr, $j, $promotion_id, $user_info);
        }
        rds_update_mongo_db($array, $new_arr);
    }
}*/


// Hook into the before_delete_post hook to check when a post is being permanently deleted
add_action('before_delete_post', 'rds_before_delete_promotion_post');

function rds_before_delete_promotion_post($post_id) {
    // Check if the post is being permanently deleted
    $array = rds_template();
    $k = 0;
    $new_arr = array();
    $mongo_promotion = mongodbAPI('GET', 'feature', NULL);
    $mongo_promotion = json_decode($mongo_promotion, true);

    if (get_post_type($post_id) == "bc_promotions" && !empty($array['globals']['promotion']['items'])) {
        // Post is being trashed
        $key = array_search($post_id, array_column($array['globals']['promotion']['items'], 'post_id'));
        unset($array['globals']['promotion']['items'][$key]);
        // Output the response
        if (!empty($array['globals']['promotion']['items'])) {
            foreach ($array['globals']['promotion']['items'] as $item) {
                if ($mongo_promotion['globals']['promotion']['items'][$k]['post_id'] === $item['post_id']) {
                    $postID = $item['post_id'];
                    $user_info = array('create_user' => $mongo_promotion['globals']['promotion']['items'][$k]['create_user'],
                        "modified_user" => $mongo_promotion['globals']['promotion']['items'][$k]['modified_user'],
                        "status" => $mongo_promotion['globals']['promotion']['items'][$k]['status'],
                        "created_date" => $mongo_promotion['globals']['promotion']['items'][$k]['created_date'],
                        "modified_date" => $mongo_promotion['globals']['promotion']['items'][$k]['modified_date']
                    );
                    $new_arr = rds_promotion_array($new_arr, $k, $postID, $user_info);
                    $k++;
                }
            }
        }
        rds_update_mongo_db($array, $new_arr);
    }
}

add_action('untrashed_post', 'rds_post_post_untrashed');

function rds_post_post_untrashed($post_id) {
    // Custom code to execute when a post is restored from the trash
    if (get_post_type($post_id) == "bc_promotions") {
        rds_post_trashed_and_restored("draft", $post_id);
    }
}



function get_latest_specific_post_type($post_id) {
    $post = get_post($post_id);
    
    if ($post->post_type === 'bc_position') {
        $args = array(
            'post_type' => 'bc_position',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
        );
        $latest_posts = new WP_Query($args);
        $posts_data = array(); // Array to store post data

        if ($latest_posts->have_posts()) {
            while ($latest_posts->have_posts()) {
                $latest_posts->the_post();

                $post_data = array(
                    'title' => get_the_title(),
                    'location' => get_post_meta(get_the_ID(), 'team_position', true),
                    'content' => get_the_content(),
                    'custom_content' => get_post_meta(get_the_ID(), 'team_custom_content', true),
                );

                $posts_data[] = $post_data;
            }
            wp_reset_postdata();
        }
        if (!empty( $posts_data)) {

            $array1 = rds_template();
            $array2 = array('posts' => $posts_data);
            $array1['page_templates']['career_page']['position']['posts'] = $array2['posts'];


            $merged_json = json_encode($array1, JSON_PRETTY_PRINT);
             global $wpdb;
             $tableName = $wpdb->prefix . 'options';
             $result = $wpdb->update($tableName, array('option_value' => $merged_json), array('option_name' => 'rds_template'));
         }
        
    }

     if ($post->post_type === 'bc_teams') {
        $args = array(
            'post_type' => 'bc_teams',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
        );
        $latest_posts = new WP_Query($args);
        $posts_data = array(); // Array to store post data

        if ($latest_posts->have_posts()) {
            while ($latest_posts->have_posts()) {
                $latest_posts->the_post();

                $post_data = array(
                    'title' => get_the_title(),
                    'position' => get_post_meta(get_the_ID(), 'team_position', true),
                    'content' => get_the_content(),
                );

                $posts_data[] = $post_data;
            }
            wp_reset_postdata();
        }
        if (!empty( $posts_data)) {

            $array1 = rds_template();
            $array2 = array('posts' => $posts_data);
            $array1['page_templates']['team_page']['posts'] = $array2['posts'];
            $merged_json = json_encode($array1, JSON_PRETTY_PRINT);
             global $wpdb;
             $tableName = $wpdb->prefix . 'options';
             $result = $wpdb->update($tableName, array('option_value' => $merged_json), array('option_name' => 'rds_template'));
         }
        
    }

     if ($post->post_type === 'bc_testimonials') {
        $args = array(
            'post_type' => 'bc_testimonials',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
        );
        $latest_posts = new WP_Query($args);
        $posts_data = array(); // Array to store post data

        if ($latest_posts->have_posts()) {
            while ($latest_posts->have_posts()) {
                $latest_posts->the_post();
                
                $pr_categry = get_the_terms(get_the_ID(), 'bc_testimonial_category');
                
                $pr_cat_array = array();
                if (!empty($pr_categry)) {
                    foreach ($pr_categry as $pcat) {
                        $pr_cat_array[] = $pcat->name;
                    }
                }

                
                $post_data = array(
                    'name' => get_post_meta(get_the_ID(), 'testimonial_name', true),
                    // 'title' => get_post_meta(get_the_ID(), 'testimonial_title', true),
                    'city' => get_post_meta(get_the_ID(), 'testimonial_city', true),
                    'state' => get_post_meta(get_the_ID(), 'testimonial_state', true),
                    'description' => get_post_meta(get_the_ID(), 'testimonial_message', true),
                    'post_id' => $post_id,
                    'category' => $pr_cat_array,
                );
                
                $posts_data[] = $post_data;
            }
            wp_reset_postdata();
        }
        
        if (!empty( $posts_data)) {

            $array1 = rds_template();
            $array2 = array('posts' => $posts_data);
            $array1['globals']['testimonial']['data'] = $array2['posts'];
            $merged_json = json_encode($array1, JSON_PRETTY_PRINT);
             global $wpdb;
             $tableName = $wpdb->prefix . 'options';
             $result = $wpdb->update($tableName, array('option_value' => $merged_json), array('option_name' => 'rds_template'));
         }
        
    }



     
}
add_action('save_post', 'get_latest_specific_post_type');