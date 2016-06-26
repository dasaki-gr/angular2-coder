<?php
class ANG2CoderAdmin {

  public static function buildAdminMenu() {
    $icon = ANG2CODER_URL . '/images/ang2coder_16.png';
    $settings = add_menu_page(
                              'Angular 2 Coder Settings',     // 1. Page title
                              'Angular2 Coder',               // 2. Menu title
                              'administrator',                // 3. Capability – the user level allowed to access the page.
                              'ang2coder-settings',       // 4. Menu slug – the slug used for the page in the URL.
                              array('ANG2CoderAdmin', 'addSettingsPage'),   // 5. Function
                              $icon                       //ή 'dashicons-performance'   // 6. Icon – A url to an image or a Dashicons string
                                                              // 7. Position – The position of your item within the whole menu
                );
    // add_action('admin_print_styles-' . $settings, array('ANG2CoderAdmin', 'defaultStylesheetAndScript'));
  }



  public static function addSettingsPage() {
    $view = ANG2Coder::getView('views/settings.php');
    echo $view;
    wp_enqueue_style('admin_css_bootstrap', ANG2CODER_URL .'/js/bootstrap/css/bootstrap.min.css', false, '1.0.0', 'all');
    wp_enqueue_style('admin_css_switch', ANG2CODER_URL .'/css/switcher/css/switcher.css');
    wp_enqueue_style('admin_css_settings', ANG2CODER_URL .'/css/settings.css');
    wp_enqueue_style('ang2codercss');
    wp_enqueue_script('ang2coderjs', ANG2CODER_URL . '/js/ang2coder.js');
  }


  public static function defaultStylesheetAndScript() {
    wp_enqueue_style('ang2codercss');
    wp_enqueue_script('ang2coderjs');
  }

  public static function defaultAng2coder_settings() {

  }


}
