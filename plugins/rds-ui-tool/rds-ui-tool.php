<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://your-author-domain.com
 * @since             1.0.0
 * @package           Rds_Ui_Tool
 *
 * @wordpress-plugin
 * Plugin Name:       Polaris RDS Setting
 * Description:       
 * Author:            Bluecorona
 * Author URI:        https://www.bluecorona.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rds-ui-tool
 * Domain Path:       /languages
 * Version: 2.0.1.0
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
// require_once(ABSPATH . '/version_control/plugin-update-checker/plugin-update-checker.php');
// use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('RDS_UI_TOOL_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rds-ui-tool-activator.php
 */
function activate_rds_ui_tool() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-rds-ui-tool-activator.php';
    Rds_Ui_Tool_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rds-ui-tool-deactivator.php
 */
function deactivate_rds_ui_tool() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-rds-ui-tool-deactivator.php';
    Rds_Ui_Tool_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_rds_ui_tool');
register_deactivation_hook(__FILE__, 'deactivate_rds_ui_tool');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rds-ui-tool.php';

global $wpdb;

$table_name = $wpdb->prefix . 'rds_tracking';

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name varchar(100) NOT NULL,
    data longtext NOT NULL,
    date datetime NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

// $myUpdateChecker = PucFactory::buildUpdateChecker(
// 	'https://github.com/ESBlueCorona/rds-ui-tool-test',
// 	__FILE__,
// 	'rds-ui-tool'
// );

// $myUpdateChecker->setBranch('main');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
//Footer configuration update 
add_action('admin_post_rds_footer_configuration', 'rds_footer_configuration');

function rds_footer_configuration() {
    if (isset($_POST['rdsfooterconfigNonce']) && wp_verify_nonce($_POST['rdsfooterconfigNonce'], 'rdsfooterconfigNonce')) {

        session_start();
        $array = rds_template();
        $array['globals']['footer']['variation'] = $_POST['footer_variation'];
        $array['globals']['footer']['heading'] = $_POST['footer_heading'];
        if (isset($_POST['footer_social_icon_class'])) {
            $array['globals']['footer']['data']['social_media']['items'] = array();
            $i = 0;
            foreach ($_POST['footer_social_icon_class'] as $class) {
                $array['globals']['footer']['data']['social_media']['items'][$i]['icon_class'] = $class;
                $array['globals']['footer']['data']['social_media']['items'][$i]['url'] = $_POST['footer_social_url'][$i];
                $array['globals']['footer']['data']['social_media']['items'][$i]['order'] = $_POST['footer_social_icon_order'][$i];
                $i++;
            }
        }
        $array['globals']['footer']['data']['footer_menu_1_name'] = $_POST['footer_menu_1_name'];
        $array['globals']['footer']['data']['footer_menu_1_heading'] = $_POST['footer_menu_1_heading'];
        $array['globals']['footer']['data']['footer_menu_2_name'] = $_POST['footer_menu_2_name'];
        $array['globals']['footer']['data']['footer_menu_2_heading'] = $_POST['footer_menu_2_heading'];
        $array['globals']['footer']['data']['disclaimer_text'] = stripslashes($_POST['footer_disclaimer_text']);
        $array['globals']['footer']['data']['copyright_title'] = $_POST['footer_copyright_title'];
        $array['globals']['footer']['data']['bluecorona_branding'] = isset($_POST['footer_bluecorona_brand']) ? true : false;
        $array['globals']['footer']['data']['privacy_policy_link'] = $_POST['footer_privacy_policy'];
        $update = rds_update_template_option_add_mongo_log($array);

            $_SESSION["footer_config"] = "footer_config";
            wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=footer"));
    }
}

//Header Config update statrt
add_action('admin_post_rds_header_configuration', 'rds_header_configuration');

//update existing template option and add new mongo db log
function rds_update_template_option_add_mongo_log($array) {
    $mongo_promotion = mongodbAPI('GET', 'feature', NULL);
    $mongo_promotion = json_decode($mongo_promotion, true);
    $i = 0;
    if (isset($array['globals']['promotion']['items']) && !empty($array['globals']['promotion']['items'])) {
        foreach ($array['globals']['promotion']['items'] as $mp) {
            $mongo_promotion['globals']['promotion']['items'][$i]['post_id'] = $mp['post_id'];
            $mongo_promotion['globals']['promotion']['items'][$i]['title'] = $mp['title'];
            $mongo_promotion['globals']['promotion']['items'][$i]['heading'] = $mp['heading'];
            $mongo_promotion['globals']['promotion']['items'][$i]['subheading'] = $mp['subheading'];
            $mongo_promotion['globals']['promotion']['items'][$i]['background_color_code'] = $mp['background_color_code'];
            $mongo_promotion['globals']['promotion']['items'][$i]['expiry_date'] = $mp['expiry_date'];
            $mongo_promotion['globals']['promotion']['items'][$i]['last_date_of_month'] = $mp['last_date_of_month'];
            $mongo_promotion['globals']['promotion']['items'][$i]['auto_renew'] = $mp['auto_renew'];
            $mongo_promotion['globals']['promotion']['items'][$i]['no_expiry'] = $mp['no_expiry'];
            $mongo_promotion['globals']['promotion']['items'][$i]['show_in_banner'] = $mp['show_in_banner'];
            $mongo_promotion['globals']['promotion']['items'][$i]['disclaimer'] = $mp['disclaimer'];
            $mongo_promotion['globals']['promotion']['items'][$i]['more_info'] = $mp['more_info'];
            $mongo_promotion['globals']['promotion']['items'][$i]['category'] = $mp['category'];
            $i++;
        }
    }
    global $wpdb;
    $newArr = $array;
    $newArr['globals']['promotion']['items'] = $mongo_promotion['globals']['promotion']['items'];
    $tableName = $wpdb->prefix . 'options';
    //If template not enabled
    togglePages($array);
    $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $update = $wpdb->update($tableName, array('option_value' => $json), array('option_name' => 'rds_template'));
    $json1 = json_encode($newArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    mongodbAPI('POST', 'feature', $json1);
    return $update;
}

//update existing tracking option and add new mongo db log
function rds_update_tracking_option_add_mongo_log($array) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'options';
    $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $update = $wpdb->update($tableName, array('option_value' => $json), array('option_name' => 'rds_tracking'));
    $json1 = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    mongodbAPI('POST', 'tracking', $json1);
    return $update;
}

function rds_insert_tracking_option($array, $name) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'rds_tracking';
    $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = $wpdb->insert($tableName, array('name' => $name, 'data' => $json, 'date' => current_time('mysql')));
    $json1 = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    mongodbAPI('POST', 'tracking', $json1);
    return $result;
}

function get_rds_tracking_data($name) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'rds_tracking';
    $query = $wpdb->prepare("SELECT * FROM $tableName WHERE name = %s ORDER BY date DESC LIMIT 10", $name);
    $results = $wpdb->get_results($query, ARRAY_A); 
    return $results;
}

function generate_table_html($data) {
    $html = '<table style="border-collapse: collapse; width: 100%; text-align: center;">';
    $srl_no = 1;
    foreach ($data as $data_item) {
        $data_array = json_decode($data_item['data'], true);
        if ($srl_no === 1) {
            $html .= '<tr style="border: 1px solid black; text-align: center;">';
            $html .= '<th style="border: 1px solid black; text-align: center;">S.no.</th>';
            foreach ($data_array as $key => $value) {
                $html .= '<th style="border: 1px solid black; text-align: center;">' . ucfirst($key) . '</th>';
            }
            $html .= '<th style="border: 1px solid black; text-align: center;">Date</th>';
            $html .= '</tr>';
        }
        $html .= '<tr style="border: 1px solid black; text-align: center;">';
        $html .= '<td style="border: 1px solid black; text-align: center;">' . $srl_no . '</td>';
        foreach ($data_array as $key => $value) {
            $html .= '<td style="border: 1px solid black; text-align: center;">' . (is_bool($value) ? ($value ? 'true' : 'false') : $value) . '</td>';
        }
        $html .= '<td style="border: 1px solid black; text-align: center;">' . date("m/d/Y H:i:s T", strtotime($data_item['date'])) . '</td>';
        $html .= '</tr>';
        $srl_no++;
    }
    $html .= '</table>';
    return $html;
}

function custom_admin_plugin_enqueue_scripts() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    // Register the script
    wp_register_script('custom-admin-plugin-script', plugin_dir_url(__FILE__) . 'assets/js/custom-script.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-admin-plugin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    // Enqueue the script
    wp_enqueue_script('custom-admin-plugin-script');
}
add_action('admin_enqueue_scripts', 'custom_admin_plugin_enqueue_scripts');

function rds_tracking_ajax_handler() {
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $data = get_rds_tracking_data($name);
        // echo json_encode($data);
        if ($data) {
            echo generate_table_html($data); 
        } else {
            echo "No data available"; 
        }
    }
    wp_die();
}
add_action('wp_ajax_get_tracking_data', 'rds_tracking_ajax_handler');
add_action('wp_ajax_nopriv_get_tracking_data', 'rds_tracking_ajax_handler'); 

function run_rds_ui_tool() {

    //Add admin page to the menu
    add_action('admin_menu', 'add_rds_ui_tool_admin_page');

    function add_rds_ui_tool_admin_page() {
        // add top level menu page
        add_menu_page(
                'Polaris RDS Settings', //Page Title
                // 'RDS UI Tool Settings', //Page Title
                'Polaris RDS Settings', //Menu Title
                'manage_options', //Capability
                'rds-ui-tool', //Page slug
                'rds_ui_tool' //Callback to print html
        );
    }

    //Admin page html callback
    function rds_ui_tool() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $redirectedtab = explode("tab=", $_SERVER['HTTP_REFERER']);
            $redirectedtab = isset($redirectedtab[1]) ? $redirectedtab[1] : "";
            $currenttab = explode("tab=", $_SERVER['REQUEST_URI']);
            $currenttab = isset($currenttab[1]) ? $currenttab[1] : "";
            session_start();
            if ($currenttab != $redirectedtab) {
                session_destroy();
            }
        }
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        ?>

        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />




        <?php
        //Get the active tab from the $_GET param
        $default_tab = null;
        $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
        ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Our admin page content should all be inside .wrap -->
        <div class="wrap">
            <!-- Print the page title -->
            <!-- <h1><?php //echo esc_html(get_admin_page_title()); ?></h1> -->
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/header/header-logo.webp"  srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/header/header-logo.webp 1x, <?php echo get_stylesheet_directory_uri(); ?>/img/header/header-logo@2x.webp 2x, <?php echo get_stylesheet_directory_uri(); ?>/img/header/header-logo@3x.webp 3x" class="branding_logo img-fluid w-auto" style="max-width: 294px; max-height: 130px;" width="294" height="59">
            <h1><b>Polaris RDS Websites</b></h1>
            <h5>Site Settings</h5>
            <!-- Here are our tabs -->
            <nav class="nav-tab-wrapper">
                <a href="?page=rds-ui-tool" class="nav-tab <?php if ($tab === null): ?>nav-tab-active<?php endif; ?>">Site Info</a>

                <a href="?page=rds-ui-tool&tab=service-area" class="nav-tab <?php if ($tab === 'service-area'): ?>nav-tab-active<?php endif; ?>">Service Area</a>

                 <a href="?page=rds-ui-tool&tab=tracking" class="nav-tab <?php if ($tab === 'tracking'): ?>nav-tab-active<?php endif; ?>">Tracking</a>
            </nav>
            <div class="tab-content">
                <?php
                switch ($tab) :
                    case 'service-area':
                        require_once ('rds-settings/service_area.php');
                        // service_area_configuration();
                        break;
                    case 'tracking':
                        require_once ('rds-settings/tracking.php');
                        break;
                    default:
                        require_once ('rds-settings/site_info.php');
                        break;
                endswitch;
                ?>
            </div>
        </div>
        <?php
    }
}

//scheduler
$rds_scheduler_tracking = rds_tracking();
if (!empty($rds_scheduler_tracking['scheduler']['enable'])) {
    add_action('rds_' . $rds_scheduler_tracking['scheduler']['position'], 'rds_scheduler');

    function rds_scheduler() {
        $rds_scheduler_tracking = rds_tracking();
        if ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'schedule_engine') {
            ?>
            <script data-api-key='<?php echo $rds_scheduler_tracking['scheduler']['id'] ?>' id='se-widget-embed' src='https://embed.scheduleengine.net/schedule-engine-v3.js'></script>
        <?php } elseif ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'service_titan') { ?>
                        <script> (function (q, w, e, r, t, y, u) {
                            q[t] = q[t] || function () {
                                (q[t].q = q[t].q || []).push(arguments)
                            };
                            q[t].l = 1 * new Date();
                            y = w.createElement(e);
                            u = w.getElementsByTagName(e)[0];
                            y.async = true;
                            y.src = r;
                            u.parentNode.insertBefore(y, u);
                            q[t]('init', '<?php echo $rds_scheduler_tracking['scheduler']['id'] ?>');
                        })(window, document, 'script', 'https://static.servicetitan.com/webscheduler/shim.js', 'STWidgetManager');</script><?php
        } elseif ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'others') {
            echo $rds_scheduler_tracking['scheduler']['content'];
        } elseif ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'nexhealth') {
            ?>
            <iframe src="<?php echo $rds_scheduler_tracking['scheduler']['nexhealth_content'] ?>"></iframe>
            <?php
        } elseif ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'zocdoc') {
            ?>
            <script>(function (d) {var script = d.createElement('script'); script.type = 'text/javascript'; script.async = true; script.src = 'https://offsiteschedule.zocdoc.com/plugin/embed';var s = d.getElementsByTagName('script')[0]; s.parentNode.insertBefore(script, s);})(document);</script>
            <?php
        } elseif ($rds_scheduler_tracking['scheduler']['Scheduler'] == 'clearwave') {
            
            echo $rds_scheduler_tracking['scheduler']['clearwave_content'];

        }
    }

}
//chat
//scheduler
$rds_chat_tracking = rds_tracking();
if (!empty($rds_chat_tracking['chat']['enable'])) {
    add_action('rds_' . $rds_chat_tracking['chat']['position'], 'rds_chat');

    function rds_chat() {
        $rds_chat_tracking = rds_tracking();
        if ($rds_chat_tracking['chat']['Scheduler'] == 'zyra') {
            ?><script id="chatBT" chatKey="<?php echo $rds_chat_tracking['chat']['id'] ?>" src="https://www.zyrachat.com/contractorschatbot/js/botdistribution.min.js" type="text/javascript"></script> <?php } elseif ($rds_chat_tracking['chat']['Scheduler'] == 'podium') { ?>
            <script data-api-token='<?php echo $rds_chat_tracking['chat']['id'] ?>' id='podium-widget' src='https://connect.podium.com/widget.js#API_TOKEN=<?php echo $rds_chat_tracking['chat']['id'] ?>' defer></script><?php } elseif ($rds_chat_tracking['chat']['Scheduler'] == 'service_titan') { ?><script>  (function (q, w, e, r, t, y, u) {
                            q[t] = q[t] || function () {
                                (q[t].q = q[t].q || []).push(arguments)
                            };
                            q[t].l = 1 * new Date();
                            y = w.createElement(e);
                            u = w.getElementsByTagName(e)[0];
                            y.async = true;
                            y.src = r;
                            u.parentNode.insertBefore(y, u);
                            q[t]('init', '<?php echo $rds_chat_tracking['chat']['id'] ?>');
                        })(window, document, 'script', 'https://static.servicetitan.com/text2chat/shim.js', 'T2CWidgetManager');</script><?php
        } elseif ($rds_chat_tracking['chat']['Scheduler'] == 'others') {
            echo $rds_chat_tracking['chat']['content'];
        } elseif ($rds_chat_tracking['chat']['Scheduler'] == 'schedule_engine'){ ?>
            <script src="https://webchat.scheduleengine.net/webchat-v1.js"></script>
            <script>

              WebChat.loadChat({

                "apiKey": "<?php echo $rds_chat_tracking['chat']['id'] ?>",

                "initialMessage":"<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['initial_message'] ?>",

                "initialResponses":[],

                "logoUrl":"<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['logo_url'] ?>",

                "title":"<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['title'] ?>",

                "primaryAccentColor":"#FF0000",

                "primaryAccentTextColor":"#FFFFFF",

                "backgroundColor":"#FFFFFF",

                "agentBubbleBackgroundColor":"#FF0000",

                "agentBubbleTextColor":"#FFFFFF",

                "bubbleBackgroundColor":"#F1F1F1",

                "bubbleTextColor":"#000000",

                "sendButtonBackgroundColor":"#FF0000",

                "sendButtonTextColor":"#FFFFFF",

                "suggestedResponseColor":"#FF0000",

                "autoOpen":<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['auto_open'] ?>,

                "autoOpenMobile":<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['auto_open_mobile'] ?>,

                "position":"<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['position'] ?>",

                "buttonBackgroundColor":"#3c425c",

                "buttonText":"<?php echo $rds_chat_tracking['chat']['schedule_engine_info']['button_text'] ?>",

                "buttonTextColor":"#FFFFFF"

              });

            </script>
        <?php }
    }

}
run_rds_ui_tool();