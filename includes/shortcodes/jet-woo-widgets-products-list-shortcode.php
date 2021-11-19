<?php

/**
 * Products list shortcode class
 */
class Jet_Woo_Widgets_Products_List_Shortcode extends Jet_Woo_Widgets_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'jet-woo-widgets-products-list';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {

		return apply_filters( 'jet-woo-widgets/shortcodes/jet-woo-products-list/atts', array(
			'products_layout'       => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Layout', 'jetwoo-widgets-for-elementor' ),
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Image Left', 'jetwoo-widgets-for-elementor' ),
					'right' => esc_html__( 'Image Right', 'jetwoo-widgets-for-elementor' ),
					'top'   => esc_html__( 'Image Top', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'number'                => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Products Number', 'jetwoo-widgets-for-elementor' ),
				'default' => 3,
				'min'     => 1,
				'max'     => 30,
				'step'    => 1,
			),
			'products_query'        => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Query products by', 'jetwoo-widgets-for-elementor' ),
				'default' => 'all',
				'options' => array(
					'all'      => esc_html__( 'All', 'jetwoo-widgets-for-elementor' ),
					'featured' => esc_html__( 'Featured', 'jetwoo-widgets-for-elementor' ),
					'sale'     => esc_html__( 'Sale', 'jetwoo-widgets-for-elementor' ),
					'tag'      => esc_html__( 'Tag', 'jetwoo-widgets-for-elementor' ),
					'category' => esc_html__( 'Category', 'jetwoo-widgets-for-elementor' ),
					'ids'      => esc_html__( 'Specific IDs', 'jetwoo-widgets-for-elementor' ),
					'viewed'   => esc_html__( 'Recently Viewed', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'products_ids'          => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'jetwoo-widgets-for-elementor' ),
				'default'     => '',
				'label_block' => true,
				'condition'   => array(
					'products_query' => array( 'ids' ),
				),
			),
			'products_cat'          => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Category', 'jetwoo-widgets-for-elementor' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_categories(),
				'condition'   => array(
					'products_query' => array( 'category' ),
				),
			),
			'products_tag'          => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Tag', 'jetwoo-widgets-for-elementor' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_tags(),
				'condition'   => array(
					'products_query' => array( 'tag' ),
				),
			),
			'products_order'        => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'jetwoo-widgets-for-elementor' ),
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Date', 'jetwoo-widgets-for-elementor' ),
					'price'   => esc_html__( 'Price', 'jetwoo-widgets-for-elementor' ),
					'rand'    => esc_html__( 'Random', 'jetwoo-widgets-for-elementor' ),
					'sales'   => esc_html__( 'Sales', 'jetwoo-widgets-for-elementor' ),
					'rated'   => esc_html__( 'Top Rated', 'jetwoo-widgets-for-elementor' ),
				),
			),
			'show_title'            => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Title', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			),
			'title_length'          => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Title Words Count', 'jetwoo-widgets-for-elementor' ),
				'min'       => 1,
				'default'   => 10,
				'condition' => array(
					'show_title' => array( 'yes' ),
				),
			),
			'show_image'            => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Featured Image', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'thumb_size'            => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Featured Image Size', 'jetwoo-widgets-for-elementor' ),
				'default'   => 'woocommerce_thumbnail',
				'options'   => jet_woo_widgets_tools()->get_image_sizes(),
				'condition' => array(
					'show_image' => array( 'yes' ),
				),
			),
			'show_cat'              => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Categories', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_price'            => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Price', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_rating'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Rating', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_button'           => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Add To Cart Button', 'jetwoo-widgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'button_use_ajax_style' => array(
				'label'        => esc_html__( 'Use default ajax add to cart styles', 'jetwoo-widgets-for-elementor' ),
				'description'  => esc_html__( 'This option enables default WooCommerce styles for \'Add to Cart\' ajax button (\'Loading\' and \'Added\' statements)', 'jetwoo-widgets-for-elementor' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'show_button' => array( 'yes' ),
				),
			),
		) );

	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_categories() {

		$categories = get_terms( 'product_cat' );

		if ( empty( $categories ) || ! is_array( $categories ) ) {
			return array();
		}

		return wp_list_pluck( $categories, 'name', 'slug' );

	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_tags() {

		$tags = get_terms( 'product_tag' );

		if ( empty( $tags ) || ! is_array( $tags ) ) {
			return array();
		}

		return wp_list_pluck( $tags, 'name', 'slug' );

	}

	/**
	 * Query products by attributes
	 *
	 * @return object
	 */
	public function query() {
		$defaults = apply_filters(
			'jet-woo-widgets/shortcodes/jet-woo-products-list/query-args',
			array(
				'post_status'   => 'publish',
				'post_type'     => 'product',
				'no_found_rows' => 1,
				'meta_query'    => array(),
				'tax_query'     => array(
					'relation' => 'AND',
				),
			)
		);

		$query_args['posts_per_page'] = intval( $this->get_attr( 'number' ) );
		$product_visibility_term_ids  = wc_get_product_visibility_term_ids();
		$viewed_products              = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? jet_woo_widgets_tools()->extract_ids_array_from_string( $_COOKIE['woocommerce_recently_viewed'] ) : array();
		$viewed_products              = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		if ( ( 'viewed' === $this->get_attr( 'products_query' ) ) && empty( $viewed_products ) ) {
			return;
		}

		switch ( $this->get_attr( 'products_query' ) ) {
			case 'category':
				if ( '' !== $this->get_attr( 'products_cat' ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => explode( ',', $this->get_attr( 'products_cat' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'tag':
				if ( '' !== $this->get_attr( 'products_tag' ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_tag',
						'field'    => 'slug',
						'terms'    => explode( ',', $this->get_attr( 'products_tag' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'ids':
				if ( '' !== $this->get_attr( 'products_ids' ) ) {
					$query_args['post__in'] = explode(
						',',
						str_replace( ' ', '', $this->get_attr( 'products_ids' ) )
					);
				}
				break;
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'sale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'viewed':
				$query_args['post__in'] = $viewed_products;
				$query_args['orderby']  = 'post__in';
				break;
		}

		switch ( $this->get_attr( 'products_order' ) ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby'] = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rated':
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby']  = 'meta_value_num';

				break;
			default :
				$query_args['orderby'] = 'date';
		}

		$query_args = wp_parse_args( $query_args, $defaults );

		return new WP_Query( $query_args );
	}

	/**
	 * Products list shortocde function
	 *
	 * @param array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();

		if ( empty( $query ) || is_wp_error( $query ) ) {
			echo sprintf( '<h3 class="jet-woo-products__not-found">%s</h3>', esc_html__( 'Products not found', 'jetwoo-widgets-for-elementor' ) );

			return false;
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		global $post;

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'jet-woo-widgets/shortcodes/jet-woo-products-list/loop-start' );

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'jet-woo-widgets/shortcodes/jet-woo-products-list/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'jet-woo-widgets/shortcodes/jet-woo-products-list/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'jet-woo-widgets/shortcodes/jet-woo-products-list/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

}
