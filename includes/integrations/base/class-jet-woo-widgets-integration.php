<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Widgets_Integration' ) ) {

	/**
	 * Define Jet_Woo_Widgets_Integration class
	 */
	class Jet_Woo_Widgets_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Check if processing elementor widget
		 *
		 * @var boolean
		 */
		private $is_elementor_ajax = false;

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'elementor/init', array( $this, 'register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 10 );

			add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, -1 );

			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			add_action( 'template_redirect', array( $this, 'set_track_product_view' ), 20 );

		}

		/**
		 * Enqueue editor styles
		 *
		 * @return void
		 */
		public function editor_styles() {

			wp_enqueue_style(
				'jet-woo-widgets-font',
				jet_woo_widgets()->plugin_url( 'assets/css/lib/jetwoowidgets-font/css/jetwoowidgets.css' ),
				array(),
				jet_woo_widgets()->get_version()
			);

		}

		/**
		 * Track product views.
		 */
		public function set_track_product_view() {
			if ( ! is_singular( 'product' ) ) {
				return;
			}

			global $post;

			if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ){
				$viewed_products = array();
			} else{
				$viewed_products = jet_woo_widgets_tools()->extract_ids_array_from_string( $_COOKIE['woocommerce_recently_viewed'] );
			}

			if ( ! in_array( $post->ID, $viewed_products ) ) {
				$viewed_products[] = $post->ID;
			}

			if ( sizeof( $viewed_products ) > 30 ) {
				array_shift( $viewed_products );
			}

			// Store for session only
			wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
		}

		/**
		 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
		 *
		 * @return  void
		 */
		public function set_elementor_ajax() {
			$this->is_elementor_ajax = true;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @return void
		 */
		public function in_elementor() {

			$result = false;

			if ( wp_doing_ajax() ) {
				$result = $this->is_elementor_ajax;
			} elseif ( Elementor\Plugin::instance()->editor->is_edit_mode()
				|| Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				$result = true;
			}

			/**
			 * Allow to filter result before return
			 *
			 * @var bool $result
			 */
			return apply_filters( 'jet-woo-widgets/in-elementor', $result );
		}

		/**
		 * Register plugin widgets
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_widgets( $widgets_manager ) {
			$global_available_widgets = jet_woo_widgets_settings()->get( 'global_available_widgets' );

			require jet_woo_widgets()->plugin_path( 'includes/base/class-jet-woo-widgets-base.php' );

			foreach ( glob( jet_woo_widgets()->plugin_path( 'includes/widgets/global/' ) . '*.php' ) as $file ) {

				$slug    = basename( $file, '.php' );
				$enabled = isset( $global_available_widgets[ $slug ] ) ? $global_available_widgets[ $slug ] : '';

				if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $global_available_widgets ) {
					$this->register_widget( $file, $widgets_manager );
				}
			}

		}


		/**
		 * Register addon by file name
		 *
		 * @param  string $file            File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 * @return void
		 */
		public function register_widget( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\%s', $class );

			require $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Register cherry category for elementor if not exists
		 *
		 * @return void
		 */
		public function register_category() {

			$elements_manager = Elementor\Plugin::instance()->elements_manager;
			$jet_woo_widgets_cat       = 'jetwoo-widgets-for-elementor';

			$elements_manager->add_category(
				$jet_woo_widgets_cat,
				array(
					'title' => esc_html__( 'JetWoo Widgets', 'jetwoo-widgets-for-elementor' ),
					'icon'  => 'font',
				),
				2
			);
		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 * @return void
		 */
		public function add_controls( $controls_manager ) {

			$grouped = array(
				'jet-woo-widgets-box-style' => 'Jet_Woo_Widgets_Group_Control_Box_Style',
			);

			foreach ( $grouped as $control_id => $class_name ) {
				if ( $this->include_control( $class_name, true ) ) {
					$controls_manager->add_group_control( $control_id, new $class_name() );
				}
			}

		}

		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( jet_woo_widgets()->plugin_path( $filename ) ) ) {
				return false;
			}

			require jet_woo_widgets()->plugin_path( $filename );

			return true;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Woo_Widgets_Integration
 *
 * @return object
 */
function jet_woo_widgets_integration() {
	return Jet_Woo_Widgets_Integration::get_instance();
}
