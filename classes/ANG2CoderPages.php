<?php
class ANG2CoderPages {

  public static function setValue($page, $selector) {
    global $wpdb;
    $pagesTable = ANG2Coder::getTableName('pages');

    if(!empty($page)) {
      $dbKey = $wpdb->get_var("SELECT `page` from $pagesTable where `page`='$page'");
      if($dbKey) {
        if(!empty($selector) || $selector !== 0) {
          $wpdb->update($pagesTable,
            array('page'=>$page, 'selector'=>$selector),
            array('page'=>$page),
            array('%s', '%s'),
            array('%s')
          );
        }
        else {
          $wpdb->query("DELETE from $pagesTable where `page`='$page'");
        }
      }
      else {
        if(!empty($selector) || $selector !== 0) {
          $wpdb->insert($pagesTable,
            array('page'=>$page, 'selector'=>$selector),
            array('%s', '%s')
          );
        }
      }
    }

  }

  public static function getValue($page, $entities=false) {
    $selector = false;
    global $wpdb;
    $pagesTable = ANG2Coder::getTableName('pages');
    $selector = $wpdb->get_var("SELECT `selector` from $pagesTable where `page`='$page'");

    if(!empty($selector) && $entities) {
      $selector = htmlentities($selector);
    }

    return $selector;
  }

}
