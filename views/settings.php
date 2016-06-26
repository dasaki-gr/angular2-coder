<div id="wrapper">


  <div class="container">
    <div id="HeaderView">
      <div>
      <img src="<?php echo ANG2CODER_URL . '/images/ang2coder_150.png'?>" alt="Angular 2 Coder View" style="float: left; margin: 0px 15px 15px 0px;width:100px;">
      <h1>Angular 2 Coder</h1>
      <h4>Version : <?php echo ANG2CODER_VERSION_NUMBER; ?> </h4>
    </div>

    </div>
  	<hr>
  	<div class="row">
        <div class="col-md-8">
          <div class="panel panel-default roundBoxed">
            <div class="panel-heading"><h3>Settings</h3></div>
            <div class="panel-body">
              <p>You can use this tool to build and run Angular 2 applications in WordPress Pages or Posts.</p>

              <p><strong>Here is how it works:</strong> On Page or Post enter where you want to display the application a distinctive tag like : <span style="color:#538b01;">&lt;myapp&gt;</span> <span style="color:blue;">Ang2 ... loading... </span><span style="color:#538b01;">&lt;/myapp&gt;</span>. (see Image 01)</p>
              <div class="row">
                    <div class="col-md-6"><img src="<?php echo ANG2CODER_URL . '/images/addmedia.png'?>" alt="Add media tag" style="width:500px;"><br><span style="font-size:x-small; color:blue;">Image 01</span></div>
                    <div class="col-md-6"><img src="<?php echo ANG2CODER_URL . '/images/ang02Options.png'?>" alt="Angular 2 options " style="width:500px;"><br><span style="font-size:x-small; color:blue;">Image 02</span></div>
              </div>
              <div><p>Then on Angular 2 Options box enter on <span style="color:green;">Application directory</span> input, your application directory name after main apps directory.</br>
              For example if your application is on directory apps/app03 then you must insert: <span style="color:green;">app03</span> (see Image 02)
            </p></div>

          </br></br></br>
              <p><strong>Choose your selection below:</strong> select to run Angular 2 applications either on Pages or on Posts
                or on boths.</p>


              <p>&nbsp;</p>
              <div id="save-result"></div>
              <form action="" method="post" class="ajax-settings-form" id="settings-form">
    						<?php wp_nonce_field( 'ang2_coder_ajax_nonce_settings_main', 'ang2_coder_ajax_nonce_settings_main' ); ?>
    						<input type="hidden" name="action" value="save_ang2coder_settings" />
    						<input type="hidden" name="_success" value="Your main settings have been saved." />
                      <div class="optionBoxed">
                          <div class="form-switcher form-switcher-md-phone floatLft">
                            <input type="checkbox" name="enable_ng2_page" id="switcher01" value="<?php echo (ANG2CoderSetting::getValue('enable_ng2_page') == 1 ) ? '1' : '0'; ?>" <?php echo (ANG2CoderSetting::getValue('enable_ng2_page') == 1 ) ? 'checked="checked"' : ''; ?>>
                            <label class="switcher" for="switcher01"></label>
                          </div>
                          <p class="optionTxt"> <?php _e( 'Enable on Pages', 'ang2coderlag' ); ?></p>
                      </div>
                      <div class="optionBoxed">
                          <!-- switcher buttons from   https://github.com/oturra/ios-switcher -->
                          <div class="form-switcher form-switcher-md-phone floatLft">
                            <input type="checkbox" name="enable_ng2_post" id="switcher02" value="<?php echo (ANG2CoderSetting::getValue('enable_ng2_post') == 1 ) ? '1' : '0'; ?>" <?php echo (ANG2CoderSetting::getValue('enable_ng2_post') == 1 ) ? 'checked="checked"' : ''; ?>>
                            <label class="switcher" for="switcher02"></label>
                          </div>
                          <p class="optionTxt"> <?php _e( 'Enable on Posts', 'ang2coderlag' ); ?></p>
                      </div>
                      <div id="save-settings">
          							<ul>
          								<li>
          									<input type='submit' name='submit' class="button-primary" value="<?php _e( 'Save Settings', 'ang2coderlag' ); ?>" />
          								</li>
          							</ul>
          						</div>
                </form>
            </div>
          </div>
        </div>
      	<div class="col-md-4">
        	<div class="panel panel-default strongBoxed">
            <!-- <div class="panel-heading strongBoxHead"><h3>Hello 2.</h3></div> -->

            <div class="panel-body">
            </br>
              <img src="<?php echo ANG2CODER_URL . '/images/app03directory.png'?>" alt="app 03 directory" style="float: right;">
              <div>
                In the image on the right represented an indicative tree form that you can organize Angular 2 applications after the directory apps.
              </div>
            </div>
          </div>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-12">
        <br><br>
          <p class="pull-right"><a href="http://www.dasaki.gr">For more applications</a> &nbsp; ©Copyright 2016 dasaki<sup>.gr</sup> Brand.</p>
        <br><br>
        </div>
    </div>
</div>

</div>
