<?php
/**
 * Plugin Name: JetWidgets for Elementor and WooCommerce
 * Description: Set of modules for WooCommerce based on Elementor Page Builder
 * Version:     1.1.8
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jetwoo-widgets-for-elementor
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Woo_Widgets` doesn't exists yet.
if ( ! class_exists( 'Jet_Woo_Widgets' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Woo_Widgets {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.1.8';

		/**
		 * Framework loader instance
		 *
		 * @var object
		 */
		public $framework;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'load_framework' ), -20 );

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), -999 );
			// Load files.
			add_action( 'init', array( $this, 'init' ), -999 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Load plugin framework
		 */
		public function load_framework() {

			require $this->plugin_path( 'framework/loader.php' );

			$this->framework = new Jet_Woo_Widgets_CX_Loader( array(
				$this->plugin_path( 'framework/interface-builder/cherry-x-interface-builder.php' ),
			) );

		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			if ( class_exists( 'WooCommerce' ) ) {

				$this->load_files();

				jet_woo_widgets_assets()->init();
				jet_woo_widgets_integration()->init();

				jet_woo_widgets_settings()->init();
				jet_woo_widgets_shortocdes()->init();

			}

			if ( is_admin() ) {
				if ( ! $this->has_elementor() ) {
					$this->required_plugins_notice();
				}
			}

		}

		/**
		 * Show recommended plugins notice.
		 *
		 * @return void
		 */
		public function required_plugins_notice() {
			require $this->plugin_path( 'includes/lib/class-tgm-plugin-activation.php' );
			add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
		}

		/**
		 * Register required plugins
		 *
		 * @return void
		 */
		public function register_required_plugins() {

			$plugins = array(
				array(
					'name'     => 'Elementor',
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'     => 'WooCommerce',
					'slug'     => 'woocommerce',
					'required' => true,
				),
			);

			$config = array(
				'id'           => 'jetwoo-widgets-for-elementor',
				'default_path' => '',
				'menu'         => 'jet-woo-widgets-install-plugins',
				'parent_slug'  => 'plugins.php',
				'capability'   => 'manage_options',
				'has_notices'  => true,
				'dismissable'  => true,
				'dismiss_msg'  => '',
				'is_automatic' => false,
				'strings'      => array(
					'notice_can_install_required'     => _n_noop(
						'JetWoo Widgets for Elementor requires the following plugin: %1$s.',
						'JetWoo Widgets for Elementor requires the following plugins: %1$s.',
						'jetwoo-widgets-for-elementor'
					),
					'notice_can_install_recommended'  => _n_noop(
						'JetWoo Widgets for Elementor recommends the following plugin: %1$s.',
						'JetWoo Widgets for Elementor recommends the following plugins: %1$s.',
						'jetwoo-widgets-for-elementor'
					),
				),
			);

			tgmpa( $plugins, $config );

		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Returns utility instance
		 *
		 * @return object
		 */
		public function utility() {
			$utility = $this->get_core()->modules['cherry-utility'];
			return $utility->utility;
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require $this->plugin_path( 'includes/class-jet-woo-widgets-assets.php' );
			require $this->plugin_path( 'includes/class-jet-woo-widgets-tools.php' );

			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-widgets-integration.php' );

			require $this->plugin_path( 'includes/class-jet-woo-widgets-template-functions.php' );
			require $this->plugin_path( 'includes/class-jet-woo-widgets-shortcodes.php' );

			require $this->plugin_path( 'includes/settings/class-jet-woo-widgets-settings.php' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}

		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'jetwoo-widgets-for-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-woo-widgets/template-path', 'jet-woo-widgets/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

if ( ! function_exists( 'jet_woo_widgets' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_woo_widgets() {
		return Jet_Woo_Widgets::get_instance();
	}
}

jet_woo_widgets();
