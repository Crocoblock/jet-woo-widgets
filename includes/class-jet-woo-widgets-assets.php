<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Widgets_Assets' ) ) {

	/**
	 * Define Jet_Woo_Widgets_Assets class
	 */
	class Jet_Woo_Widgets_Assets {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', array( 'WC_Frontend_Scripts', 'localize_printed_scripts' ), 5 );
			add_action( 'admin_enqueue_scripts',  array( $this, 'admin_enqueue_styles' ) );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {
			$font_path   = WC()->plugin_url() . '/assets/fonts/';
			$inline_font = '@font-face {
			font-family: "WooCommerce";
			src: url("' . $font_path . 'WooCommerce.eot");
			src: url("' . $font_path . 'WooCommerce.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype"),
				url("' . $font_path . 'WooCommerce.svg#WooCommerce") format("svg");
			font-weight: normal;
			font-style: normal;
			}';

			wp_enqueue_style(
				'jetwoo-widgets-for-elementor',
				jet_woo_widgets()->plugin_url( 'assets/css/jet-woo-widgets.css' ),
				false,
				jet_woo_widgets()->get_version()
			);

			wp_add_inline_style(
				'jetwoo-widgets-for-elementor',
				$inline_font
			);

		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			wp_enqueue_script(
				'jetwoo-widgets-for-elementor',
				jet_woo_widgets()->plugin_url( 'assets/js/jet-woo-widgets.js' ),
				array( 'jquery', 'elementor-frontend' ),
				jet_woo_widgets()->get_version(),
				true
			);

			wp_localize_script(
				'jetwoo-widgets-for-elementor',
				'jetWooWidgetsData',
				apply_filters( 'jet-woo-widgets/frontend/localize-data', array() )
			);

			if ( ! wp_script_is( 'jquery-slick' ) ) {
				wp_enqueue_script(
					'jquery-slick',
					jet_woo_widgets()->plugin_url( 'assets/lib/slick/slick.min.js' ),
					[ 'jquery' ],
					'1.8.1',
					true
				);
			}

		}

		/**
		 * Enqueue admin styles
		 *
		 * @return void
		 */
		public function admin_enqueue_styles() {
			$screen = get_current_screen();
			// Jet setting page check
			if ( 'elementor_page_jet-woo-widgets-settings' === $screen->base ) {
				wp_enqueue_style(
					'jet-widgets-admin-css',
					jet_woo_widgets()->plugin_url( 'assets/css/jet-woo-widgets-admin.css' ),
					false,
					jet_woo_widgets()->get_version()
				);
			}
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
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

/**
 * Returns instance of Jet_Woo_Widgets_Assets
 *
 * @return object
 */
function jet_woo_widgets_assets() {
	return Jet_Woo_Widgets_Assets::get_instance();
}
