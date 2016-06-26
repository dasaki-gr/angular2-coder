<?php
class ANG2CoderAjax {

	public static function save_settings() {
		ANG2CoderSetting::setValue('testMessage','Inside save_settings');
		if ( ! check_ajax_referer( 'ang2_coder_ajax_nonce_settings_main', 'ang2_coder_ajax_nonce_settings_main', false ) ) {
			die;
		}

		$error = '';

		foreach ( $_REQUEST as $key => $value ) {
			if ( $key[0] != '_' && $key != 'action' && $key != 'submit' ) {
				if ( is_array( $value ) ) {
					$value = implode( '~', $value );
				}
				ANG2CoderSetting::setValue( $key, trim( stripslashes( $value ) ) );
			}
		}


		if ( $error ) {
			$result[0] = 'ANG2CoderAjaxError';
			$result[1] = '<h3>' . __( 'Warning','ang2coderlag' ) . "</h3><p>$error</p>";
		}
		else {
			$result[0] = 'ANG2CoderAjaxSuccess';
			$result[1] = '<h3>' . __( 'Success', 'ang2coderlag' ) . '</h3><p>' . $_REQUEST['_success'] . '</p>';
		}

		echo wp_json_encode( $result );
		die();

	}

	public static function test_settings() {
		ANG2CoderSetting::setValue('testMessage','test2_settings');
	}

}
