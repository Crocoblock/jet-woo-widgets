<?php

/**
 * Categories shortcode class
 */
class Jet_Woo_Widgets_Categories_Shortcode extends Jet_Woo_Widgets_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'jet-woo-widgets-categories';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {
		$columns = jet_woo_widgets_tools()->get_select_range( 6 );

		return apply_filters( 'jet-woo-widgets/shortcodes/jet-woo-categories/atts', array(
			'presets'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Category Presets', 'jetwoo-widgets-for-elementor' ),
				'default' => 'preset-1',
				'options' => $this->get_allowed_presets(),
			),
			'columns'            => array(
				'type'            => 'select',
				'responsive'      => true,
				'label'           => esc_html__( 'Columns', 'jetwoo-widgets-for-elementor' ),
				'desktop_default' => 3,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'render_type'     => 'template',
				'selectors'       => [
					'{{WRAPPER}} .jet-woo-categories .jet-woo-categories__item' => '--columns: {{VALUE}}',
				],
				'options'         => $columns,
			),
			'equal_height_cols'  => array(
				'label'        => esc_html__( 'Equal Columns Height', 'jetwoo-widgets-for-elementor' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'columns_gap'        => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'number'             => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Categories Number', 'jetwoo-widgets-for-elementor' ),
				'default'   => 3,
				'min'       => -1,
				'max'       => 30,
				'step'      => 1,
				'separator' => 'before',
			),
			'hide_empty'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Empty', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			),
			'hide_subcategories' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Subcategories', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all', 'category' ),
				),
			),
			'hide_default_cat'   => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Uncategorized', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all' ),
				),
			),
			'show_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Show by', 'jetwoo-widgets-for-elementor' ),
				'default' => 'all',
				'options' => array(
					'all'        => esc_html__( 'All', 'jetwoo-widgets-for-elementor' ),
					'parent_cat' => esc_html__( 'Parent Category', 'jetwoo-widgets-for-elementor' ),
					'cat_ids'    => esc_html__( 'Categories IDs', 'jetwoo-widgets-for-elementor' ),
					'categories' => esc_html__( 'Categories', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'parent_cat_ids'     => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set parent category ID', 'jetwoo-widgets-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'show_by' => array( 'parent_cat' ),
				),
			),
			'cat_ids'            => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Set comma seprated IDs list (10, 22, 19 etc.)', 'jetwoo-widgets-for-elementor' ),
				'default'     => '',
				'label_block' => true,
				'condition'   => array(
					'show_by' => array( 'cat_ids' ),
				),
			),
			'categories'         => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Selected category', 'jetwoo-widgets-for-elementor' ),
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'options'     => jet_woo_widgets_tools()->get_terms_array( array( 'product_cat' ) ),
				'condition'   => array(
					'show_by' => array( 'categories' ),
				),
			),
			'order'              => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'jetwoo-widgets-for-elementor' ),
				'default' => 'asc',
				'options' => array(
					'asc'  => esc_html__( 'ASC', 'jetwoo-widgets-for-elementor' ),
					'desc' => esc_html__( 'DESC', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'sort_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Sort by', 'jetwoo-widgets-for-elementor' ),
				'default' => 'name',
				'options' => array(
					'name'  => esc_html__( 'Name', 'jetwoo-widgets-for-elementor' ),
					'id'    => esc_html__( 'IDs', 'jetwoo-widgets-for-elementor' ),
					'count' => esc_html__( 'Count', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'thumb_size'         => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Featured Image Size', 'jetwoo-widgets-for-elementor' ),
				'default'   => 'woocommerce_thumbnail',
				'options'   => jet_woo_widgets_tools()->get_image_sizes(),
				'separator' => 'before',
			),
			'show_title'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Categories Title', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_count'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Count', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'count_before_text'  => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count Before Text', 'jetwoo-widgets-for-elementor' ),
				'default'   => '(',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'count_after_text'   => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count After Text', 'jetwoo-widgets-for-elementor' ),
				'default'   => ')',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'desc_length'        => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Description Words Count', 'jetwoo-widgets-for-elementor' ),
				'description' => esc_html__( 'Input -1 to show all description and 0 to hide', 'jetwoo-widgets-for-elementor' ),
				'min'         => -1,
				'default'     => 10,
			),
			'desc_after_text'    => array(
				'type'    => 'text',
				'label'   => esc_html__( 'Trimmed After Text', 'jetwoo-widgets-for-elementor' ),
				'default' => '...',
			),
		) );
	}

	/**
	 * Get list of allowed presets names
	 * 
	 * @return [type] [description]
	 */
	public function get_allowed_presets() {
		return array(
			'preset-1' => esc_html__( 'Preset 1', 'jetwoo-widgets-for-elementor' ),
			'preset-2' => esc_html__( 'Preset 2', 'jetwoo-widgets-for-elementor' ),
			'preset-3' => esc_html__( 'Preset 3', 'jetwoo-widgets-for-elementor' ),
			'preset-4' => esc_html__( 'Preset 4', 'jetwoo-widgets-for-elementor' ),
			'preset-5' => esc_html__( 'Preset 5', 'jetwoo-widgets-for-elementor' ),
		);
	}

	/**
	 * Get type template
	 *
	 * @param  [type] $name [description]
	 *
	 * @return [type]       [description]
	 */
	public function get_category_preset_template() {
		
		$base_dir        = $this->get_tag();
		$preset          = $this->get_attr( 'presets' );
		$allowed_presets = array_keys( $this->get_allowed_presets() );
		$preset          = in_array( $preset, $allowed_presets ) ? $preset : 'preset-1';

		return jet_woo_widgets()->get_template( $base_dir . '/global/presets/' . $preset . '.php' );
	}

	/**
	 * Query categories by attributes
	 *
	 * @return object
	 */
	public function query() {
		$defaults = apply_filters(
			'jet-woo-widgets/shortcodes/jet-woo-categories/query-args',
			array(
				'post_status'  => 'publish',
				'hierarchical' => 1,
			)
		);

		$cat_args = array(
			'number'     => intval( $this->get_attr( 'number' ) ),
			'orderby'    => $this->get_attr( 'sort_by' ),
			'hide_empty' => $this->get_attr( 'hide_empty' ),
			'order'      => $this->get_attr( 'order' ),
		);

		if ( $this->get_attr( 'hide_subcategories' ) ) {
			$cat_args['parent'] = 0;
		}

		if ( $this->get_attr( 'hide_default_cat' ) ) {
			$cat_args['exclude'] = get_option( 'default_product_cat', 0 );
		}

		switch ( $this->get_attr( 'show_by' ) ) {
			case 'parent_cat':
				$cat_args['child_of'] = $this->get_attr( 'parent_cat_ids' );
				break;
			case 'cat_ids' :
				$cat_args['include'] = $this->get_attr( 'cat_ids' );
				break;
			case 'categories' :
				$categories       = $this->get_attr( 'categories' );
				$cat_args['slug'] = $categories ? explode( ',', $categories ) : '';

				break;
			default:
				break;
		}

		$cat_args = wp_parse_args( $cat_args, $defaults );

		$product_categories = get_terms( 'product_cat', $cat_args );

		return $product_categories;
	}

	/**
	 * Categories shortocde function
	 *
	 * @param array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();

		if ( empty( $query ) || is_wp_error( $query ) ) {
			echo sprintf( '<h3 class="jet-woo-categories__not-found">%s</h3>', esc_html__( 'Categories not found', 'jetwoo-widgets-for-elementor' ) );

			return false;
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'jet-woo-widgets/shortcodes/jet-woo-categories/loop-start' );

		include $loop_start;

		foreach ( $query as $category ) {
			setup_postdata( $category );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'jet-woo-widgets/shortcodes/jet-woo-categories/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'jet-woo-widgets/shortcodes/jet-woo-categories/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'jet-woo-widgets/shortcodes/jet-woo-categories/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

}
