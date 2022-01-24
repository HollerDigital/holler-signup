<?php
/**
 * Plugin Name: Holler Signup
 * Description: This plugin adds the ability to add a signup from to your site :)
 * Plugin URI: http://hollerdigital.com/
 * Version: 2.11
 * Author: Holler Digital
 * Author URI: http://hollerdigital.com/
 * Text Domain: holler
 * License: GPL2
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Globals
define('HOLLER_SIGNUP_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('HOLLER_SIGNUP_PATH', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );
define("HOLLER_SIGNUP_VERSION", "2.11");

// Plugin Updater
// https://github.com/YahnisElsts/plugin-update-checker
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/HollerDigital/holler-signup',
	__FILE__,
	'holler-signup'
);
 
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

//Optional: If you're using a private repository, specify the access token like this:
//$myUpdateChecker->setAuthentication('your-token-here');

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
  
    // ajax callback function 
/*
  add_action( 'wp_ajax_holler_cm_subscribe_email', 'holler_signup' );
  add_action( 'wp_ajax_nopriv_holler_cm_subscribe_email', 'holler_signup' );
  add_action( 'wp_ajax_spyr_plugin_do_ajax_request', 'add_email_record' );
  add_action( 'wp_ajax_nopriv_spyr_plugin_do_ajax_request', 'add_email_record' );
*/

  add_action( 'elementor_pro/init', function() {
	
	// Here its safe to include our action class file
  require_once 'inc/class.php';
  require_once 'inc/settings-page.php';
  require_once 'inc/campaignmonitor/csrest_general.php';
  require_once 'inc/campaignmonitor/csrest_subscribers.php';
  require_once 'inc/campaignmonitor/csrest_clients.php';

	// Instantiate the action class
	$sendy_action = new Sendy_Action_After_Submit();

	// Register the action with form widget
	\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $sendy_action->get_name(), $sendy_action );
});
	}
}

// Instantiate Plugin Class
Plugin::instance();