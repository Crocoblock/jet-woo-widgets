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

if ( ! class_exists( 'Jet_Woo_Widgets_Settings' ) ) {

	/**
	 * Define Jet_Woo_Widgets_Settings class
	 */
	class Jet_Woo_Widgets_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * [$key description]
		 * @var string
		 */
		public $key = 'jet-woo-widgets-settings';

		/**
		 * [$widgets description]
		 * @var null
		 */
		public $widgets  = null;

		/**
		 * [$settings description]
		 * @var null
		 */
		public $settings = null;

		/**
		 * Global Available Widgets array
		 *
		 * @var array
		 */
		public $global_available_widgets = array();

		/**
		 * Init page
		 */
		public function init() {

			add_action( 'admin_enqueue_scripts', array( $this, 'init_widgets' ), 0 );
			add_action( 'admin_menu', array( $this, 'register_page' ), 99 );
			add_action( 'init', array( $this, 'save' ), 40 );
			add_action( 'admin_notices', array( $this, 'saved_notice' ) );

			foreach ( glob( jet_woo_widgets()->plugin_path( 'includes/widgets/global/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->global_available_widgets[ $slug] = $data['name'];
			}

		}

		/**
		 * Initialize page widgets module if reqired
		 *
		 * @return [type] [description]
		 */
		public function init_widgets() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			$widgets_data = jet_woo_widgets()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

			$this->widgets = new CX_Interface_Builder(
				array(
					'path' => $widgets_data['path'],
					'url'  => $widgets_data['url'],
				)
			);

		}

		/**
		 * Show saved notice
		 *
		 * @return bool
		 */
		public function saved_notice() {

			if ( ! isset( $_GET['settings-saved'] ) ) {
				return false;
			}

			$message = esc_html__( 'Settings saved', 'jetwoo-widgets-for-elementor' );

			printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message );

			return true;

		}

		/**
		 * Save settings
		 *
		 * @return void
		 */
		public function save() {

			if ( empty( $_REQUEST['_nonce'] ) || ! wp_verify_nonce( $_REQUEST['_nonce'], 'jetwoo-widgets-for-elementor-save' ) ) {
				return;
			}

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			if ( ! isset( $_REQUEST['action'] ) || 'save-settings' !== $_REQUEST['action'] ) {
				return;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$current = get_option( $this->key, array() );
			$data    = $_REQUEST;

			unset( $data['action'] );

			foreach ( $data as $key => $value ) {
				$current[ $key ] = is_array( $value ) ? $value : esc_attr( $value );
			}

			update_option( $this->key, $current );

			$redirect = add_query_arg(
				array( 'dialog-saved' => true ),
				$this->get_settings_page_link()
			);

			wp_redirect( $redirect );
			die();

		}

		/**
		 * Return settings page URL
		 *
		 * @return string
		 */
		public function get_settings_page_link() {

			return add_query_arg(
				array(
					'page' => $this->key,
				),
				esc_url( admin_url( 'admin.php' ) )
			);

		}

		public function get( $setting, $default = false ) {

			if ( null === $this->settings ) {
				$this->settings = get_option( $this->key, array() );
			}

			return isset( $this->settings[ $setting ] ) ? $this->settings[ $setting ] : $default;

		}

		/**
		 * Register add/edit page
		 *
		 * @return void
		 */
		public function register_page() {

			add_submenu_page(
				'elementor',
				esc_html__( 'JetWoo Widgets Settings', 'jetwoo-widgets-for-elementor' ),
				esc_html__( 'JetWoo Widgets Settings', 'jetwoo-widgets-for-elementor' ),
				'manage_options',
				$this->key,
				array( $this, 'render_page' )
			);

		}

		/**
		 * Render settings page
		 *
		 * @return void
		 */
		public function render_page() {

			foreach ( $this->global_available_widgets as $key => $value ) {
				$default_global_available_widgets[ $key ] = 'true';
			}

			$this->widgets->register_section(
				array(
					'jet_woo_widgets_settings' => array(
						'type'   => 'section',
						'scroll' => false,
						'title'  => esc_html__( 'JetWoo Widgets Settings', 'jetwoo-widgets-for-elementor' ),
					),
				)
			);

			$this->widgets->register_form(
				array(
					'jet_woo_widgets_settings_form' => array(
						'type'   => 'form',
						'parent' => 'jet_woo_widgets_settings',
						'action' => add_query_arg(
							array( 'page' => $this->key, 'action' => 'save-settings' ),
							esc_url( admin_url( 'admin.php' ) )
						),
					),
				)
			);

			$this->widgets->register_settings(
				array(
					'settings_top' => array(
						'type'   => 'settings',
						'parent' => 'jet_woo_widgets_settings_form',
					),
					'settings_bottom' => array(
						'type'   => 'settings',
						'parent' => 'jet_woo_widgets_settings_form',
					),
				)
			);

			$this->widgets->register_component(
				array(
					'jet_woo_widgets_tab_vertical' => array(
						'type'   => 'component-tab-vertical',
						'parent' => 'settings_top',
					),
				)
			);

			$this->widgets->register_settings(
				array(
					'available_widgets_options' => array(
						'parent'      => 'jet_woo_widgets_tab_vertical',
						'title'       => esc_html__( 'Available Widgets', 'jetwoo-widgets-for-elementor' ),
					),
				)
			);

			$this->widgets->register_control(
				array(
					'global_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'global_available_widgets',
						'name'        => 'global_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'global_available_widgets', $default_global_available_widgets ),
						'options'     => $this->global_available_widgets,
						'title'       => esc_html__( 'Global Available Widgets', 'jetwoo-widgets-for-elementor' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the page', 'jetwoo-widgets-for-elementor' ),
						'class'       => 'jet_woo_widgets_settings_form__checkbox-group'
					),
				)
			);

			$this->widgets->register_settings(
				array(
					'product_thumb_effect_options' => array(
						'parent' => 'jet_woo_widgets_tab_vertical',
						'title'  => esc_html__( 'Product Thumb Effect', 'jetwoo-widgets-for-elementor' ),
					),
				)
			);

			$this->widgets->register_control(
				array(
					'enable_product_thumb_effect' => array(
						'type'        => 'switcher',
						'id'          => 'enable_product_thumb_effect',
						'name'        => 'enable_product_thumb_effect',
						'parent'      => 'product_thumb_effect_options',
						'title'       => esc_html__( 'Enable Thumbnails Effect', 'jetwoo-widgets-for-elementor' ),
						'description' => esc_html__( 'Enable thumbnails switch on hover', 'jetwoo-widgets-for-elementor' ),
						'value'       => $this->get( 'enable_product_thumb_effect' ),
						'toggle'      => array(
							'true_toggle'  => 'On',
							'false_toggle' => 'Off',
						),
					),
				)
			);

			$this->widgets->register_control(
				array(
					'product_thumb_effect' => array(
						'type'    => 'select',
						'id'      => 'product_thumb_effect',
						'name'    => 'product_thumb_effect',
						'parent'  => 'product_thumb_effect_options',
						'value'   => $this->get( 'product_thumb_effect', 'slide-left' ),
						'options' => array(
							'slide-left'     => esc_html__( 'Slide Left', 'jetwoo-widgets-for-elementor' ),
							'slide-right'    => esc_html__( 'Slide Right', 'jetwoo-widgets-for-elementor' ),
							'slide-top'      => esc_html__( 'Slide Top', 'jetwoo-widgets-for-elementor' ),
							'slide-bottom'   => esc_html__( 'Slide Bottom', 'jetwoo-widgets-for-elementor' ),
							'fade'           => esc_html__( 'Fade', 'jetwoo-widgets-for-elementor' ),
							'fade-with-zoom' => esc_html__( 'Fade With Zoom', 'jetwoo-widgets-for-elementor' ),
						),
						'title'   => esc_html__( 'Thumbnails Effect:', 'jetwoo-widgets-for-elementor' ),
					)
				)
			);

			$this->widgets->register_html(
				array(
					'save_button' => array(
						'type'   => 'html',
						'parent' => 'settings_bottom',
						'class'  => 'cx-component dialog-save',
						'html'   => '<button type="submit" class="button button-primary">' . esc_html__( 'Save', 'jetwoo-widgets-for-elementor' ) . '</button>',
					),
					'_nonce' => array(
						'type'   => 'html',
						'parent' => 'settings_bottom',
						'class'  => 'cherry-control hidden-row',
						'html'   => '<input type="hidden" name="_nonce" value="' . esc_attr( wp_create_nonce( 'jetwoo-widgets-for-elementor-save' ) ) . '">',
					),
				)
			);

			echo '<div class="jet-woo-widgets-settings-page">';
				$this->widgets->render();
				$this->render_banner_html();
			echo '</div>';
		}

		/**
		 * Render banner html.
		 */
		public function render_banner_html() {
			$html = '<div class="jet-woo-widgets-banner">
						<a class="jet-woo-widgets-banner__link" href="https://crocoblock.com/plugins/jetwoobuilder/?_refer=crocoblock&utm_source=wpadmin&utm_medium=banner&utm_campaign=jetwoowidgets" target="_blank">
							<img class="jet-woo-widgets-banner__img" src="%1$s" alt="%2$s">
						</a>
					</div>';
			printf( $html, jet_woo_widgets()->plugin_url( 'assets/images/banner.png' ), esc_attr__( 'Crocoblock', 'jetwoo-widgets-for-elementor' ) );
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

/**
 * Returns instance of Jet_Woo_Widgets_Settings
 *
 * @return object
 */
function jet_woo_widgets_settings() {
	return Jet_Woo_Widgets_Settings::get_instance();
}
