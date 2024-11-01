<?php

/*
 * IRCode CCaptcha Picture Selection: Handle Core functions
 */

class IRCODE_CCAPTCHA_PS_Core {

	/**
	 * Returns an instance of this class.
	 */
	public static function init() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}


	/**
	 * Get options
	 *
	 * @param string $key
	 * @param bool   $default
	 * @return mixed
	 */
	public function get_option( $key, $default = false ) {
		$options = get_option( 'ircode_ccaptcha_ps', [] );
		$options = wp_parse_args( $options, $this->default_options() );
		$explode = explode( '.', $key );
		$value   = $default;

		if ( is_array( $options ) ) {
			if ( isset( $options[$explode[0]], $explode[1] ) ) {
				$value = isset( $options[$explode[0]][$explode[1]] ) ? $options[$explode[0]][$explode[1]] : $default;
			} elseif ( isset( $options[$key] ) ) {
				$value = $options[$key];
			}
		}

		return $this->maybe_bool( $value );
	}

	public function default_options() {
		return [
			'api_code'    => '',
			'secret_code' => '',
			'forms'       => [
				'login'         => true,
				'register'      => true,
				'lost_password' => true,
				'comments'      => true,
				'csf7'          => false,
			],
			'messages'    => [
				'no_answer'    => __( 'Please complete the captcha.', IRCODE_CCAPTCHA_PS_DOMAIN ),
				'wrong_answer' => __( 'Please enter correct captcha value.', IRCODE_CCAPTCHA_PS_DOMAIN ),
			],
		];
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function maybe_bool( $value ) {

		if ( empty( $value ) ) {
			return false;
		}

		if ( is_string( $value ) ) {

			if ( in_array( $value, array( 'on', 'true', 'yes' ) ) ) {
				return true;
			}

			if ( in_array( $value, array( 'off', 'false', 'no' ) ) ) {
				return false;
			}
		}

		return $value;
	}

	/**
	 * Render CCaptcha Picture Selection HTML
	 *
	 * @return void
	 */
	public function get_captcha_html() { ?>
        <script type="text/javascript">
            var filepath = "https://widget.ccaptcha.com/js/ccaptcha_version2_M9.js";
            if (document.querySelectorAll('head script[src="' + filepath + '"]').length <= 0) {
                var ele = document.createElement('script');
                ele.setAttribute("type", "text/javascript");
                ele.setAttribute("src", filepath);
                document.head.appendChild(ele);
            }
        </script>
        <div id="ccaptcha_M9" data_ccaptcha_apicode="<?= $this->get_option( 'api_code' ) ?>"></div>
	<?php }


	/**
	 * Verifying CCaptcha Picture Selection
	 *
	 * @return bool
	 */
	public function verify() {
		$wrong_answer = ircode_ccaptcha_ps()->CORE->get_option( 'messages.wrong_answer' );
		$no_answer    = ircode_ccaptcha_ps()->CORE->get_option( 'messages.no_answer' );

		if ( !array_key_exists( 'ccaptcha_token_input', $_POST ) ) {
			return $no_answer;
		}

        $args         = [];
        $args['body'] = [
            'Token'       => sanitize_text_field( $_POST['ccaptcha_token_input'] ),
            'Secret_Code' => $this->get_option( 'secret_code' ),
        ];

        $url = "https://api.ccaptcha.com/api/Validate9/ValidationPost";

        $response = wp_remote_post( $url, $args );
        $body     = wp_remote_retrieve_body( $response );

		return $body == '"true"' ? true : $wrong_answer;
	}


}

/**
 * @return IRCODE_CCAPTCHA_PS_Core
 */
function ircode_ccaptcha_ps_core() {
	return IRCODE_CCAPTCHA_PS_Core::init();
}
