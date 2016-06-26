<p>
    <label for="angular2-selector">Please insert Angular2 Selector Options:</label>
  <br />
  <div class="row">
      <div class="col-md-4 optionDiv">
        Angular2 Selector: <input type="text" name="angular2-selector" id="angular2-selector" value="<?php echo wp_specialchars( get_post_meta( $data['objId'], 'Angular2_Selector', true ), 1 ); ?>">
      </div>
      <div class="col-md-4 optionDiv">
        Application directory  : <input type="text" name="bootstrap-dir" id="bootstrap-dir" value="<?php echo wp_specialchars( get_post_meta( $data['objId'], 'Bootstrap_Dir', true ), 1 ); ?>">
      </div>
      <div class="col-md-4 optionDiv">
        Bootstrap file   : <input type="text" name="bootstrap-file" id="bootstrap-file" value="<?php echo wp_specialchars( get_post_meta( $data['objId'], 'Bootstrap_File', true ), 1 ); ?>">
      </div>
    </div>
    <div class="row">
        <div class="col-md-4 optionDiv">
          External Apps Plugin  : <input type="text" name="external-plugin" id="external-plugin" value="<?php echo wp_specialchars( get_post_meta( $data['objId'], 'External_Plugin', true ), 1 ); ?>">
        </div>
    </div>



</p>
