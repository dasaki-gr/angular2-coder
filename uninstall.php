<?php
if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
  exit();
}

define('ANG2CODER_PATH', plugin_dir_path( __FILE__ )); // e.g. /var/www/example.com/wordpress/wp-content/plugins/angular2-coder
require_once(ANG2CODER_PATH . 'classes/ANG2Coder-false.php'); // Να σβήσω το -false ώστε να δουλέχει το Uninstall
require_once(ANG2CODER_PATH . 'classes/ANG2CoderSettings.php');

//if(WPEditorSetting::getValue('uninstall_db')) {
global $wpdb;
$prefix = ANG2Coder::getTablePrefix();
$sqlFile = WPEDITOR_PATH . 'sql/uninstall.sql';
$sql = str_replace('[prefix]', $prefix, file_get_contents($sqlFile));
$queries = explode(";\n", $sql);
foreach($queries as $sql) {
  if(strlen($sql) > 5) {
    $wpdb->query($sql);
  }
}
//}
