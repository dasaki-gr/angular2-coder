<?php

class ANG2Coder {


  public function install() {

    global $wpdb;
    $prefix = $this->getTablePrefix();
    $sqlFile = ANG2CODER_PATH . 'sql/database.sql';
    $sql = str_replace('[prefix]', $prefix, file_get_contents($sqlFile));
    $queries = explode(";\n", $sql);
    $wpdb->hide_errors();
    foreach($queries as $sql) {
      if(strlen($sql) > 5) {
        $wpdb->query($sql);
      }
    }

    // Set the version number for this version of Angular2Coder
    require_once(ANG2CODER_PATH . 'classes/ANG2CoderSettings.php');
    ANG2CoderSetting::setValue('version', ANG2CODER_VERSION_NUMBER);

    if(!ANG2CoderSetting::getValue('upgrade')) {
      $this->firstInstall();
    }
  }

  public function init() {
    // Load all additional required classes
    $this->loadCoreModels();
    //echo '<pre>'.print_r('------------------------------>Point 03',true).'</pre>';
    // Verify that upgrade has been run
    if(IS_ADMIN) {
      $title01 = ANG2CoderSetting::getValue('version');
      if(version_compare(ANG2CODER_VERSION_NUMBER, ANG2CoderSetting::getValue('version'))) {
        $this->install();
      }
    }
    if(IS_ADMIN) {
      global $pagenow, $typenow;
      if ( empty( $typenow ) && !empty( $_GET['post'] ) ) {
        $post = get_post( $_GET['post'] );
        $typenow = $post->post_type;
      } elseif ( empty( $typenow ) && ( $pagenow == 'post-new.php' ) ){
        $typenow = 'post';
      }
      // $this->test($typenow);
      // Add Angular 2 Settings Page
      add_action('admin_menu', array('ANG2CoderAdmin', 'buildAdminMenu'));
      // Ajax request to save settings
      add_action( 'wp_ajax_save_ang2coder_settings', array( 'ANG2CoderAjax', 'save_settings' ) );


      add_action( 'add_meta_boxes', array($this, 'ang2_create_post_meta_box' ));
      add_action( 'save_post', array($this,'ang2_save_post_meta_box'), 10, 2 );
      // test if is page = 'ang2coder-settings' and load stylesheets and scripts
      if ( ($_GET['page'] == 'ang2coder-settings') || ($typenow == 'post') ||($typenow == 'page') ){
          // $this->test($_GET['page']);
          // ANG2CoderSetting::setValue('testMessage','initFunction');
          // Load default stylesheet
          add_action('admin_init', array($this, 'register_default_stylesheet'));
          // Load default script
          add_action('admin_init', array($this, 'register_default_script'));


          // add_action( 'edit_form_after_title', 'ang2coder_edit_form_after_title' );
          // function ang2coder_edit_form_after_title() {
          //   // $view = ANG2Coder::getView('views/editpages.php');
          //   // echo $view;
          // }

          // from https://wordpress.org/support/topic/add-an-extra-text-input-field-on-admin-post-page


        }


    }


    if (IS_PAGE) {
      // echo '<pre>'.print_r('------------------------------>Point 04',true).'</pre>';
      // add_action( 'the_post', array($this,'the_post_action'));
      add_action( 'wp_head', array($this,'Angular2coder_settings'));
    }

    if (IS_POST) {
      add_action( 'wp_head', array($this,'Angular2coder_settings'));
    }


  }

  // create meta box on admin page edit
  public function ang2_create_post_meta_box() {
    if (ANG2CoderSetting::getValue('enable_ng2_page')==1)
      add_meta_box( 'my-meta-box', 'Angular2 Options', array($this, 'ang2_post_meta_box'), 'page', 'normal', 'high' );
    if (ANG2CoderSetting::getValue('enable_ng2_post')==1)
      add_meta_box( 'my-meta-box', 'Angular2 Options', array($this, 'ang2_post_meta_box'), 'post', 'normal', 'high' );
  }

  public function ang2_post_meta_box( $object, $box ) {
      // echo '<pre>'.print_r('.... --------------------> 00001'.plugin_basename( __FILE__ ),true).'</pre>';
      $data = array(
         'plugin_basename' => plugin_basename( __FILE__ ),
         'post_meta' => wp_specialchars( get_post_meta( $object->ID, 'Angular2 Options', true ), 1 ),
         'objId' => $object->ID
      );
      // echo '<pre>'.print_r('.... --------------------> '. $data['objId'] ).'</pre>';
      $view = ANG2Coder::getView('views/page_metabox.php',$data);
      echo $view;
      wp_deregister_script( 'ang2coderjs' );
      wp_register_script('ang2coderjs', ANG2CODER_URL . '/js/ang2coder.js', false, ANG2CODER_VERSION_NUMBER);
      wp_enqueue_script('ang2coderjs');
      wp_enqueue_style('ang2codercss');
      // wp_register_style( 'bootstrap.min', ANG2CODER_URL .'/js/bootstrap/css/bootstrap.min.css' );
      // wp_enqueue_style('bootstrap.min');
      //
      // Προσοχή με το bootstap.css υπάρχει πρόβλημα με το .hidden το οποίο διορθώνεται όπως παρακάτω
      // https://wordpress.org/support/topic/wp-admincss-classhidden-bug-renders-screen-options-menu-in-admin-blank
      wp_enqueue_style('admin_css_bootstrap', ANG2CODER_URL .'/js/bootstrap/css/bootstrap.min.css', false, '1.0.0', 'all');
      ?>
        <input type="hidden" name="ang2_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
      <?php
  }

  public function ang2_save_post_meta_box( $post_id, $post ) {

      if ( !wp_verify_nonce( $_POST['ang2_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
        return $post_id;

      if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;


      // ang2coder_options('Angular2_Selector','angular2-selector');
      // ang2coder_options('Bootstrap_File','bootstrap-file');
      $ang2meta_name = 'Angular2_Selector';
      $ang2field_name = 'angular2-selector';

      // function ang2coder_options($ang2meta_name, $ang2field_name) {
          $ang2meta_value = get_post_meta( $post_id, $ang2meta_name, true );
          $ang2new_meta_value = stripslashes( $_POST[$ang2field_name] );

          if ( $ang2new_meta_value && '' == $ang2meta_value )
            add_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value, true );

          elseif ( $ang2new_meta_value != $ang2meta_value )
            update_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value );

          elseif ( '' == $ang2new_meta_value && $ang2meta_value )
            delete_post_meta( $post_id, $ang2meta_name, $ang2meta_value );
      // }

      $ang2meta_name = 'Bootstrap_File';
      $ang2field_name = 'bootstrap-file';

      // function ang2coder_options($ang2meta_name, $ang2field_name) {
          $ang2meta_value = get_post_meta( $post_id, $ang2meta_name, true );
          $ang2new_meta_value = stripslashes( $_POST[$ang2field_name] );

          if ( $ang2new_meta_value && '' == $ang2meta_value )
            add_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value, true );

          elseif ( $ang2new_meta_value != $ang2meta_value )
            update_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value );

          elseif ( '' == $ang2new_meta_value && $ang2meta_value )
            delete_post_meta( $post_id, $ang2meta_name, $ang2meta_value );
      // }

      $ang2meta_name = 'Bootstrap_Dir';
      $ang2field_name = 'bootstrap-dir';

      // function ang2coder_options($ang2meta_name, $ang2field_name) {
          $ang2meta_value = get_post_meta( $post_id, $ang2meta_name, true );
          $ang2new_meta_value = stripslashes( $_POST[$ang2field_name] );

          if ( $ang2new_meta_value && '' == $ang2meta_value )
            add_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value, true );

          elseif ( $ang2new_meta_value != $ang2meta_value )
            update_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value );

          elseif ( '' == $ang2new_meta_value && $ang2meta_value )
            delete_post_meta( $post_id, $ang2meta_name, $ang2meta_value );
      // }


      $ang2meta_name = 'External_Plugin';
      $ang2field_name = 'external-plugin';

      // function ang2coder_options($ang2meta_name, $ang2field_name) {
          $ang2meta_value = get_post_meta( $post_id, $ang2meta_name, true );
          $ang2new_meta_value = stripslashes( $_POST[$ang2field_name] );

          if ( $ang2new_meta_value && '' == $ang2meta_value )
            add_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value, true );

          elseif ( $ang2new_meta_value != $ang2meta_value )
            update_post_meta( $post_id, $ang2meta_name, $ang2new_meta_value );

          elseif ( '' == $ang2new_meta_value && $ang2meta_value )
            delete_post_meta( $post_id, $ang2meta_name, $ang2meta_value );
      // }

  }


  public function the_post_action( $post ) {
     // modify post object here
    //  echo '<pre>'.print_r('------------------->'.$post->post_name,true).'</pre>';
     switch($post->post_name)
         {
             // case 'home':
             //     wp_enqueue_script('home');
             //     break;
             // case 'about':
             //     wp_enqueue_script('about');
             //     break;
             case 'angular2notes':
                //  wp_enqueue_script('es6-shim');
                 // wp_enqueue_script('system-polyfills');
                 // wp_enqueue_script('angular2-polyfills');
                 // wp_enqueue_script('system');
                 // wp_enqueue_script('Rx');
                 // wp_enqueue_script('angular2');
                 // wp_enqueue_script('angular2-router');
                 // wp_enqueue_script('angular2-http');

                 $this->test();

                //  wp_enqueue_script(
                //    'system-start',
                //    ANG2CODER_URL .'/functions/dist/system-start.js',
                //    array('es6-shim', 'system-polyfills', 'angular2-polyfills', 'system', 'Rx', 'angular2', 'angular2-router', 'angular2-http')
                //  );
                 //
                //  wp_localize_script(
                //    'system-start',
                //    'baseUrl',
                //    trailingslashit(ANG2CODER_URL)
                //  );


                 break;
         }
  }

  public function test($testMessage){
    echo '<pre>'.print_r('------------------------------>'.$testMessage,true).'</pre>';
    echo '<pre>'.print_r('------------------------------~',true).'</pre>';
  }

  public function firstInstall() {
    // Set the database to upgrade instead of first time install
    ANG2CoderSetting::setValue('upgrade', true);

    // Check if the post editor has been enabled and enable if not
    ANG2CoderSetting::setValue('enable_ng2_page', true);
    ANG2CoderSetting::setValue('enable_ng2_post', false);
  }

  public function loadCoreModels() {
    require_once(ANG2CODER_PATH . 'classes/ANG2CoderAdmin.php');
    require_once(ANG2CODER_PATH . 'classes/ANG2CoderAjax.php');
    require_once(ANG2CODER_PATH . 'classes/ANG2CoderSettings.php');
    require_once(ANG2CODER_PATH . 'classes/ANG2CoderPages.php');
    // ANG2CoderAjax::test_settings(); // Για να κάνουμε έλεγχο αν φορτώνετε κάποια κλάση

  }

  public function register_default_stylesheet() {
    // echo '<pre>'.print_r('___________________> point 01:'.ANG2CODER_PATH . 'css/ang2coder.css',true).'</pre>';
    wp_register_style('ang2codercss', ANG2CODER_URL . 'css/ang2coder.css', false, ANG2CODER_VERSION_NUMBER);
    //wp_register_style('fancybox', ANG2CODER_PATH . '/extensions/fancybox/jquery.fancybox-1.3.4.css', false, ANG2CODER_VERSION_NUMBER);

  }

  public function register_default_script() {
    wp_deregister_script( 'ang2coderjs' );
    // echo '<pre>'.print_r('___________________> point 02:'.ANG2CODER_URL. 'js/ang2coder.js',true).'</pre>';
    wp_register_script('ang2coderjs', ANG2CODER_URL . '/js/ang2coder.js', false, ANG2CODER_VERSION_NUMBER);
  }

  private function register_vendor_script($script, $path) {
    wp_register_script($script, ANG2CODER_URL .'node_modules/'.$path);
    // echo '<pre>'.print_r('>: '.$script,true).', '.ANG2CODER_URL .'node_modules/'.$path.'</pre>';
  }

  public function Angular2coder_settings() {
    global $post;
    $pagename = get_query_var('pagename');

    $ang2_dir_post_meta = get_post_meta( $post->ID, 'Bootstrap_Dir', true );

    // check if is set bootstrap_dir meta variable before load angular 2 libraries
    $checkedpath = is_dir(ANG2CODER_PATH .'apps/'.$ang2_dir_post_meta);
    if($checkedpath && $ang2_dir_post_meta!=''){
      if (ANG2CoderSetting::getValue('enable_ng2_page')==1){
          if ( is_page()){
            $this->loadAngular2coder_settings($ang2_dir_post_meta);
          }
      }
      if (ANG2CoderSetting::getValue('enable_ng2_post')==1) {
          if ( is_single()){
            $this->loadAngular2coder_settings($ang2_dir_post_meta);
          }
      }
        // check if is single post


    }
  }

  // load Angular 2 libraries on current page or post (if is_single)
  public function loadAngular2coder_settings($ang2_dir_post_meta) {
    $this->register_vendor_script('es6-shim', 'es6-shim/es6-shim.min.js');
    $this->register_vendor_script('system-polyfills', 'systemjs/dist/system-polyfills.js');
    $this->register_vendor_script('angular2-polyfills', 'angular2/bundles/angular2-polyfills.js');
    $this->register_vendor_script('system', 'systemjs/dist/system.src.js');
    $this->register_vendor_script('typescript', 'typescript/lib/typescript.js');
    $this->register_vendor_script('Rx', 'rxjs/bundles/Rx.js');
    $this->register_vendor_script('angular2', 'angular2/bundles/angular2.dev.js');
    $this->register_vendor_script('angular2-router', 'angular2/bundles/router.dev.js');
    $this->register_vendor_script('angular2-http', 'angular2/bundles/http.dev.js');

    wp_enqueue_script(
       'system-start',
       ANG2CODER_URL .'apps/'.$ang2_dir_post_meta.'/system-start.js',
       array('es6-shim', 'system-polyfills', 'angular2-polyfills', 'system', 'Rx', 'angular2', 'angular2-router', 'angular2-http')
    );

    wp_localize_script(
       'system-start',
       'baseUrl',
       trailingslashit(ANG2CODER_URL)
    );
  }

  public static function getView($filename, $data=null) {
    $filename = ANG2CODER_PATH . "/$filename";
    ob_start();
    include $filename;
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
    public static function getLastView(){
      return 'getLastView !!!';
    }

  public static function getTableName($name){
    return ANG2Coder::getTablePrefix() . $name;
  }

  public static function getTablePrefix(){
    global $wpdb;
    return $wpdb->prefix . 'ang2coder_';
  }
}
