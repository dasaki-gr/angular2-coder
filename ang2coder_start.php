<?php
    /*
    Plugin Name: Angular 2 Coder
    Plugin URI: http://www.dasaki.gr
    Description: Plugin for develop code on WordPress with Angular 2
    Author: George Maras
    Version: 0.0.1
    Author URI: http://www.dasaki.gr
    */
  // help from  http://code.tutsplus.com/tutorials/create-a-custom-wordpress-plugin-from-scratch--net-2668
  if(!class_exists('ANG2Coder')) {

    ob_start();
    $wp_34 = false;
    if(version_compare(get_bloginfo('version'), '3.4', '>=')) {
      $wp_34 = true;
    }
    define('WP_34', $wp_34);

    $wp_43 = false;
    if(version_compare(get_bloginfo('version'), '4.3', '>=')) {
      $wp_43 = true;
    }
    define('WP_43', $wp_43);

    // Define the default path and URL for the this plugin
    $plugin_file = __FILE__;
    if(isset($plugin)) {
      $plugin_file = $plugin;
    }
    elseif(isset($mu_plugin)) {
      $plugin_file = $mu_plugin;
    }
    elseif(isset($network_plugin)) {
      $plugin_file = $network_plugin;
    }
    define('ANG2CODER_PATH', WP_PLUGIN_DIR . '/' . basename(dirname($plugin_file)) . '/');
    define('ANG2CODER_URL', plugin_dir_url(ANG2CODER_PATH) . basename(dirname($plugin_file)) . '/');

    // Define the Angular 2 Coder version number
    define('ANG2CODER_VERSION_NUMBER', ang2CoderVersionNumber());

    // IS_ADMIN is true when the dashboard or the administration panels are displayed
    if(!defined('IS_ADMIN')) {
      define('IS_ADMIN',  is_admin());
    }

    $windows = false;
    if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $windows = true;
    }

    define('WPWINDOWS', $windows);

    // Load the main Angular2Coder class
    require_once(ANG2CODER_PATH . 'classes/ANG2Coder.php');
    $ang2coder = new ANG2Coder();

    // Register activation hook to install Angular2Coder database tables and system code
    register_activation_hook(__FILE__, array($ang2coder, 'install'));
    // Initialize the main ANG2Coder Class
    add_action('init',  array($ang2coder, 'init'));
    ob_end_clean();

}


  function ang2CoderVersionNumber() {
    if(!function_exists('get_plugin_data')) {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    $plugin_data = get_plugin_data(ANG2CODER_PATH . '/ang2coder_start.php');
    return $plugin_data['Version'];
  }



?>
