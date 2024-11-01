<?php

/*
 * IRCode CCaptcha Picture Selection: Handle Admin functions
 */

class IRCODE_CCAPTCHA_PS_Admin {

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


	public function __construct() {
		add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', [ $this, 'settings_menu' ], 99 );
		add_action( 'admin_init', [ $this, 'settings_fields' ] );
	}

	public function settings_menu() {
		$parent_page_title = __( 'CCaptcha Settings', IRCODE_CCAPTCHA_PS_DOMAIN );
		$parent_menu_title = __( 'CCaptcha', IRCODE_CCAPTCHA_PS_DOMAIN );
		$parent_menu_slug  = 'ircode-ccaptcha-rewrite';

		$page_title = __( 'CCaptcha Picture Selection Settings', IRCODE_CCAPTCHA_PS_DOMAIN );
		$menu_title = __( 'CCaptcha Picture Selection', IRCODE_CCAPTCHA_PS_DOMAIN );
		$capability = 'administrator';
		$menu_slug  = 'ircode-ccaptcha-picture-selection';
		$function   = [ $this, 'settings_page' ];
		$icon_url   = IRCODE_CCAPTCHA_PS_IMAGES . '/icon.png';

		$is_rw_active = class_exists( 'IRCODE_CCAPTCHA_RW' );

		if ( $is_rw_active ) {
			add_submenu_page( $parent_menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		} else {
			$parent_page_title = __( 'CCaptcha Picture Selection Settings', IRCODE_CCAPTCHA_PS_DOMAIN );
			$parent_menu_slug  = 'ircode-ccaptcha-picture-selection';
			add_menu_page( $parent_page_title, $parent_menu_title, $capability, $parent_menu_slug, $function, $icon_url );
		}

	}

	public function settings_page() { ?>
        <div class="wrap ircode-ccaptcha">
            <h1 class="wp-heading-inline"><?= __( 'CCaptcha Picture Selection Settings', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></h1>
			<?php settings_errors(); ?>
            <form method="post" action="options.php">
				<?php settings_fields( 'ircode-ccaptcha-picture-selection' ); ?>
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content">
                            <div class="postbox">
                                <h2 class="hndle"><span><?= __( 'Authentication', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                <div class="inside">
                                    <p><?= __( 'Register your website with CCaptcha to get required API Code and Secret Code and enter theme below.', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></p>
                                    <table class="form-table">
                                        <tr valign="top">
                                            <th scope="row"><label for="ircode_ccaptcha_ps[api_code]"><?= __( 'API Code', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></label></th>
                                            <td><input type="text" class="regular-text" id="ircode_ccaptcha_ps[api_code]" name="ircode_ccaptcha_ps[api_code]" value="<?= esc_attr( ircode_ccaptcha_ps()->CORE->get_option( 'api_code' ) ); ?>"/></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><label for="ircode_ccaptcha_ps[secret_code]"><?= __( 'Secret Code', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></label></th>
                                            <td><input type="text" class="regular-text" id="ircode_ccaptcha_ps[secret_code]" name="ircode_ccaptcha_ps[secret_code]" value="<?= esc_attr( ircode_ccaptcha_ps()->CORE->get_option( 'secret_code' ) ); ?>"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox">
                                <h2 class="hndle"><span><?= __( 'General', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tr valign="top">
                                            <th scope="row"><?= __( 'Enable CCaptcha Picture Selection for', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></th>
                                            <td>
                                                <hr>
                                                <h5 class="ircode-legend"><?= __( 'Wordpress Defaults', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></h5>
                                                <p><label for="ircode_ccaptcha_ps[forms][login]">
                                                        <input type="hidden" name="ircode_ccaptcha_ps[forms][login]" value="false"/>
                                                        <input type="checkbox" id="ircode_ccaptcha_ps[forms][login]" name="ircode_ccaptcha_ps[forms][login]" value="true" <?php checked( ircode_ccaptcha_ps()->CORE->get_option( 'forms.login', true ), true ) ?>/>
														<?= __( 'Login form', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>
                                                    </label></p>
                                                <p><label for="ircode_ccaptcha_ps[forms][register]">
                                                        <input type="hidden" name="ircode_ccaptcha_ps[forms][register]" value="false"/>
                                                        <input type="checkbox" id="ircode_ccaptcha_ps[forms][register]" name="ircode_ccaptcha_ps[forms][register]" value="true" <?php checked( ircode_ccaptcha_ps()->CORE->get_option( 'forms.register', true ), true ) ?>/>
														<?= __( 'Registration form', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>
                                                    </label></p>
                                                <p><label for="ircode_ccaptcha_ps[forms][lost_password]">
                                                        <input type="hidden" name="ircode_ccaptcha_ps[forms][lost_password]" value="false"/>
                                                        <input type="checkbox" id="ircode_ccaptcha_ps[forms][lost_password]" name="ircode_ccaptcha_ps[forms][lost_password]" value="true" <?php checked( ircode_ccaptcha_ps()->CORE->get_option( 'forms.lost_password', true ), true ) ?>/>
														<?= __( 'Reset password form', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>
                                                    </label></p>
                                                <p><label for="ircode_ccaptcha_ps[forms][comments]">
                                                        <input type="hidden" name="ircode_ccaptcha_ps[forms][comments]" value="false"/>
                                                        <input type="checkbox" id="ircode_ccaptcha_ps[forms][comments]" name="ircode_ccaptcha_ps[forms][comments]" value="true" <?php checked( ircode_ccaptcha_ps()->CORE->get_option( 'forms.comments', true ), true ) ?>/>
														<?= __( 'Comments form', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>
                                                    </label></p>
                                                <hr>
                                                <h5 class="ircode-legend"><?= __( 'External Plugins', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></h5>
												<?php
												$cf7_slug    = 'contact-form-7';
												$cf7_file    = 'contact-form-7/wp-contact-form-7.php';
												$cf7_checker = '';

												if ( current_user_can( 'install_plugins' ) ) {

													$cf7_checker = '<a href="%s" target="_blank">%s</a>';

													if ( !IRCODE_CCAPTCHA_PS_CF7_IS_INSTALL ) {
														$cf7_checker = sprintf( $cf7_checker, wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $cf7_slug ), 'install-plugin_' . $cf7_slug ), 'Install Now' );
													} elseif ( !IRCODE_CCAPTCHA_PS_CF7_IS_ACTIVE ) {
														$cf7_checker = sprintf( $cf7_checker, wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . urlencode( $cf7_file ), 'activate-plugin_' . $cf7_file ), 'Activate Plugin' );
													} else {
														$cf7_checker = '';
													}
												}
												?>
                                                <p><label for="ircode_ccaptcha_ps[forms][cf7]">
                                                        <input type="hidden" name="ircode_ccaptcha_ps[forms][cf7]" value="false"/>
                                                        <input type="checkbox" id="ircode_ccaptcha_ps[forms][cf7]" name="ircode_ccaptcha_ps[forms][cf7]" value="true" <?= !IRCODE_CCAPTCHA_PS_CF7_IS_ACTIVE ? 'disabled' : checked( ircode_ccaptcha_ps()->CORE->get_option( 'forms.cf7', false ), true, false ) ?>/>
														<?= __( 'Contact Form 7', IRCODE_CCAPTCHA_PS_DOMAIN ) ?> <?= $cf7_checker ?>
                                                    </label></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox">
                                <h2 class="hndle"><span><?= __( 'Messages', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tr valign="top">
                                            <th scope="row"><label for="ircode_ccaptcha_ps[messages][no_answer]"><?= __( 'Captcha Field is Empty', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></label></th>
                                            <td><input type="text" class="regular-text" id="ircode_ccaptcha_ps[messages][no_answer]" name="ircode_ccaptcha_ps[messages][no_answer]" value="<?= esc_attr( ircode_ccaptcha_ps()->CORE->get_option( 'messages.no_answer' ) ); ?>"/></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><label for="ircode_ccaptcha_ps[messages][wrong_answer]"><?= __( 'Captcha is Incorrect', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></label></th>
                                            <td><input type="text" class="regular-text" id="ircode_ccaptcha_ps[messages][wrong_answer]" name="ircode_ccaptcha_ps[messages][wrong_answer]" value="<?= esc_attr( ircode_ccaptcha_ps()->CORE->get_option( 'messages.wrong_answer' ) ); ?>"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="postbox-container-1" class="postbox-container">
                            <div id="submitdiv" class="postbox ">
                                <h2 class="hndle"><span><?= __( 'Information', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                <div class="inside">
                                    <div class="submitbox" id="submitpost">
                                        <div id="minor-publishing">
                                            <div id="misc-publishing-actions">
                                                <div class="misc-pub-section">
													<?= __( 'Version', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>: <span id="post-status-display"><?= IRCODE_CCAPTCHA_PS_VERSION ?></span>
                                                </div>
                                                <div class="misc-pub-section">
													<?= __( 'Status', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>: <span id="post-status-display"><?= __( 'Active', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span>
                                                </div>

                                                <div class="misc-pub-section">
													<?= __( 'CCaptcha Type', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>: <span id="post-status-display"><?= __( 'Picture Selection', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span>
                                                </div>
                                                <div class="misc-pub-section">
													<?= __( 'Developer', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>: <span id="post-status-display"><a href="https://ircode.pro" title="IRCode.PRO" target="_blank">IRCode.PRO</a></span>
                                                </div>
                                                <div class="misc-pub-section">
													<?= __( 'Need Help?', IRCODE_CCAPTCHA_PS_DOMAIN ) ?> <a href="https://ccaptcha.com/wiki.html"><?= __( 'Visit Help Center', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></a>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div id="major-publishing-actions">
                                            <div id="publishing-action">
												<?php submit_button( null, 'primary', 'submit', false ); ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle"><span><?= __( 'CCaptcha Picture Selection Shortcode', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                <div class="inside">
                                    <span class="notice-warning notice">
                                        <p><strong><?= sprintf( __( 'If you use Short Code you need to do the validation steps yourself. You can use below function to validate Captcha.<br>%s', IRCODE_CCAPTCHA_PS_DOMAIN ), '<code>ircode_ccaptcha_ps_verify()</code>' ) ?></strong></p>
                                    </span>
                                    <p><?= __( 'Add CCaptcha Picture Selection to your posts or pages using the following shortcode', IRCODE_CCAPTCHA_PS_DOMAIN ) ?>:</p>
                                    <input type="text" readonly value="[IRCODE_CCAPTCHA_PS]" dir="ltr" onfocus="this.select()">
                                </div>
                            </div>
							<?php if ( !empty( ircode_ccaptcha_ps()->CORE->get_option( 'api_code' ) ) ): ?>
                                <div class="postbox ">
                                    <h2 class="hndle"><span><?= __( 'Demo', IRCODE_CCAPTCHA_PS_DOMAIN ) ?></span></h2>
                                    <div class="inside">
										<?php ircode_ccaptcha_ps()->CORE->get_captcha_html(); ?>
                                    </div>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                    <br class="clear">
                </div>
				<?php submit_button( null, 'primary', 'submit', false ); ?>
            </form>
        </div>

        <style>
            .notice {
                display: block;
            }

            #post-body-content {
                margin-bottom: 0;
            }

            .ircode-legend {
                margin: -14px 0 0;
            }

            .js .postbox .hndle {
                cursor: default !important;
            }

            input[type="text"][readonly] {
                width: 100%;
            }
        </style>

	<?php }

	public function settings_fields() {
		// Register our setting so that $_POST handling is done for us and
		// our callback function just has to echo the <input>
		register_setting( 'ircode-ccaptcha-picture-selection', 'ircode_ccaptcha_ps' );
	}

}

/**
 * @return IRCODE_CCAPTCHA_PS_Admin
 */
function ircode_ccaptcha_ps_admin() {
	return IRCODE_CCAPTCHA_PS_Admin::init();
}