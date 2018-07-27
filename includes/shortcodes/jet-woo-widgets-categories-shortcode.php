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
			'presets'             => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Category Presets', 'jet-woo-widgets' ),
				'default' => 'preset-1',
				'options' => array(
					'preset-1' => esc_html__( 'Preset 1', 'jet-woo-widgets' ),
					'preset-2' => esc_html__( 'Preset 2', 'jet-woo-widgets' ),
					'preset-3' => esc_html__( 'Preset 3', 'jet-woo-widgets' ),
					'preset-4' => esc_html__( 'Preset 4', 'jet-woo-widgets' ),
					'preset-5' => esc_html__( 'Preset 5', 'jet-woo-widgets' ),
				),
			),
			'columns'            => array(
				'type'       => 'select',
				'responsive' => true,
				'label'      => esc_html__( 'Columns', 'jet-woo-widgets' ),
				'default'    => 3,
				'options'    => $columns,
			),
			'columns_tablet'     => array(
				'default' => 2,
			),
			'columns_mobile'     => array(
				'default' => 1,
			),
			'equal_height_cols'  => array(
				'label'        => esc_html__( 'Equal Columns Height', 'jet-woo-widgets' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'columns_gap'        => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'number'             => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Categories Number', 'jet-woo-widgets' ),
				'default'   => 3,
				'min'       => - 1,
				'max'       => 30,
				'step'      => 1,
				'separator' => 'before'
			),
			'hide_empty'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Empty', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
			),
			'hide_subcategories' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Subcategories', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all', 'cat_ids' ),
				),
			),
			'hide_default_cat'   => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Hide Uncategorized', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_by' => array( 'all' ),
				),
			),
			'show_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Show by', 'jet-woo-widgets' ),
				'default' => 'all',
				'options' => array(
					'all'        => esc_html__( 'All', 'jet-woo-widgets' ),
					'parent_cat' => esc_html__( 'Parent Category', 'jet-woo-widgets' ),
					'cat_ids'    => esc_html__( 'Categories IDs', 'jet-woo-widgets' ),
				),
			),
			'parent_cat_ids'     => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set parent category ID', 'jet-woo-widgets' ),
				'default'   => '',
				'condition' => array(
					'show_by' => array( 'parent_cat' ),
				),
			),
			'cat_ids'            => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma seprated IDs list (10, 22, 19 etc.)', 'jet-woo-widgets' ),
				'default'   => '',
				'condition' => array(
					'show_by' => array( 'cat_ids' ),
				),
			),
			'order'              => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'jet-woo-widgets' ),
				'default' => 'asc',
				'options' => array(
					'asc'  => esc_html__( 'ASC', 'jet-woo-widgets' ),
					'desc' => esc_html__( 'DESC', 'jet-woo-widgets' ),
				),
			),
			'sort_by'            => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Sort by', 'jet-woo-widgets' ),
				'default' => 'name',
				'options' => array(
					'name'  => esc_html__( 'Name', 'jet-woo-widgets' ),
					'id'    => esc_html__( 'IDs', 'jet-woo-widgets' ),
					'count' => esc_html__( 'Count', 'jet-woo-widgets' ),
				),
			),
			'thumb_size'         => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Featured Image Size', 'jet-woo-widgets' ),
				'default'   => 'woocommerce_thumbnail',
				'options'   => jet_woo_widgets_tools()->get_image_sizes(),
				'separator' => 'before'
			),
			'show_title'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Categories Title', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_count'         => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Count', 'jet-woo-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'count_before_text'  => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count Before Text', 'jet-woo-widgets' ),
				'default'   => '(',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'count_after_text'   => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Count After Text', 'jet-woo-widgets' ),
				'default'   => ')',
				'condition' => array(
					'show_count' => array( 'yes' ),
				),
			),
			'desc_length'        => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Description Words Count', 'jet-woo-widgets' ),
				'description'     => esc_html__( 'Input -1 to show all description and 0 to hide', 'jet-woo-widgets' ),
				'min' => -1,
				'default'   => 10,
			),
			'desc_after_text'    => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Trimmed After Text', 'jet-woo-widgets' ),
				'default'   => '...',
			),
		) );
	}

	/**
	 * Get type template
	 *
	 * @param  [type] $name [description]
	 *
	 * @return [type]       [description]
	 */
	public function get_category_preset_template() {
		return jet_woo_widgets()->get_template( $this->get_tag() . '/global/presets/' . $this->get_attr( 'presets' ) . '.php' );
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
				'hierarchical' => 1
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
	 * @param  array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();

		if ( empty( $query ) || is_wp_error( $query ) ) {
			echo sprintf( '<h3 class="jet-woo-categories__not-found">%s</h3>', esc_html__( 'Categories not found', 'jet-woo-widgets' ) );

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
