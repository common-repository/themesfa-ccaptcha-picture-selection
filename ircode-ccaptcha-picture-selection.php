<?php
/**
 * Plugin Name: IRCode - CCaptcha Picture Selection
 * Plugin URI: https://ccaptcha.com/
 * Description: Protect WordPress website forms from spam entries with CCaptcha Picture Selection.
 * Version: 1.0
 * Author: IRCode
 * Author URI: https://ircode.pro/
 * License: GPL2
 * TextDomain: ircode-ccaptcha-picture-selection
 */

/**
 * @author IRCode.PRO <info@ircode.pro>
 */
class IRCODE_CCAPTCHA_PS {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * @var IRCODE_CCAPTCHA_PS_Core
	 */
	public $CORE;

	/**
	 * @var IRCODE_CCAPTCHA_PS_Admin
	 */
	public $ADMIN;

	/**
	 * @var IRCODE_CCAPTCHA_PS_Shortcodes
	 */
	public $SHORTCODES;


	/**
	 * Constructor for the IRCODE_CCAPTCHA_PS class
	 * Sets up all the appropriate hooks and actions
	 * within our plugin.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->defined();
		$this->includes();

		$this->CORE       = IRCODE_CCAPTCHA_PS_Core::init();
		$this->SHORTCODES = IRCODE_CCAPTCHA_PS_Shortcodes::init();

		if ( is_admin() ) {
			$this->ADMIN = IRCODE_CCAPTCHA_PS_Admin::init();
		}

		$this->load_hooks();

		add_action( 'init', array( $this, 'localization_setup' ) );
	}

	/**
	 * Initializes the IRCODE_CCAPTCHA_PS() class
	 * Checks for an existing IRCODE_CCAPTCHA_PS() instance
	 * and if it doesn't find one, creates it.
	 */
	public static function init() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Placeholder for activation function
	 * Nothing being called here yet.
	 */
	public static function activate() {
	}


	/**
	 * Define all pro module constant
	 *
	 * @return void
	 */
	public function defined() {
		define( 'IRCODE_CCAPTCHA_PS_FILE', __FILE__ );
		define( 'IRCODE_CCAPTCHA_PS_VERSION', $this->version );
		define( 'IRCODE_CCAPTCHA_PS_DOMAIN', 'ircode-ccaptcha-picture-selection' );
		define( 'IRCODE_CCAPTCHA_PS_DIR', dirname( IRCODE_CCAPTCHA_PS_FILE ) );
		define( 'IRCODE_CCAPTCHA_PS_INC', IRCODE_CCAPTCHA_PS_DIR . '/includes' );
		define( 'IRCODE_CCAPTCHA_PS_ASSETS', plugins_url( 'assets', IRCODE_CCAPTCHA_PS_FILE ) );
		define( 'IRCODE_CCAPTCHA_PS_CSS', plugins_url( 'assets/css', IRCODE_CCAPTCHA_PS_FILE ) );
		define( 'IRCODE_CCAPTCHA_PS_IMAGES', plugins_url( 'assets/images', IRCODE_CCAPTCHA_PS_FILE ) );
		define( 'IRCODE_CCAPTCHA_PS_CF7_IS_ACTIVE', class_exists( 'WPCF7' ) );
		define( 'IRCODE_CCAPTCHA_PS_CF7_IS_INSTALL', is_dir( WP_PLUGIN_DIR . '/contact-form-7' ) );
	}


	/**
	 * Load all includes file
	 *
	 * @return void
	 */
	public function includes() {
		require_once IRCODE_CCAPTCHA_PS_INC . '/ircode.class.core.php';
		require_once IRCODE_CCAPTCHA_PS_INC . '/ircode.class.shortcodes.php';

		if ( is_admin() ) {
			require_once IRCODE_CCAPTCHA_PS_INC . '/ircode.class.admin.php';
		}
	}


	/**
	 * Load all hooks
	 *
	 * @return void
	 */
	public function load_hooks() {
		require_once IRCODE_CCAPTCHA_PS_INC . '/ircode.hooks.php';
		require_once IRCODE_CCAPTCHA_PS_INC . '/ircode.functions.php';
	}


	/**
	 * Initialize plugin for localization
	 *
	 * @uses load_plugin_textdomain()
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'ircode-ccaptcha-picture-selection', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

}

/**
 * Load plugin
 *
 * @return IRCODE_CCAPTCHA_PS
 * */
function ircode_ccaptcha_ps() {
	 

	return $GLOBALS['hi guys'];
}

ircode_ccaptcha_ps();

register_activation_hook( __FILE__, array( 'IRCODE_CCAPTCHA_PS', 'activate' ) );
