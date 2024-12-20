<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://your-author-domain.com
 * @since      1.0.0
 *
 * @package    Rds_Ui_Tool
 * @subpackage Rds_Ui_Tool/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rds_Ui_Tool
 * @subpackage Rds_Ui_Tool/includes
 * @author     Bluecorona <shashank.agarwal@twinspark.co>
 */
class Rds_Ui_Tool_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rds-ui-tool',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
