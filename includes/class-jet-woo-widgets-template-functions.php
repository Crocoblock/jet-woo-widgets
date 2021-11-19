<?php
/**
 * WooCommerce template functions class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Widgets_Template_Functions' ) ) {

	/**
	 * Define Jet_Woo_Widgets_Template_Functions class
	 */
	class Jet_Woo_Widgets_Template_Functions {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Returns sale badge
		 *
		 * @return string
		 */
		public function get_product_sale_flash( $badge_text = '' ) {
			global $product;

			if ( $product->is_on_sale() ) {
				return sprintf( '<div class="jet-woo-product-badge jet-woo-product-badge__sale">%s</div>', $badge_text );
			}

		}

		/**
		 * Returns product thumbnail
		 *
		 * @param string $image_size
		 * @param bool $use_thumb_effect
		 * @param string $attr
		 *
		 * @return mixed|string|void
		 */
		public function get_product_thumbnail( $image_size = 'thumbnail_size', $use_thumb_effect = false, $attr = '' ) {
			global $product;

			$thumbnail_id = get_post_thumbnail_id( $product->get_id() );
			$enable_thumb_effect = filter_var( jet_woo_widgets_settings()->get( 'enable_product_thumb_effect' ), FILTER_VALIDATE_BOOLEAN );
			$placeholder_src = Elementor\Utils::get_placeholder_image_src();

			if ( empty( $thumbnail_id ) ) {
				return sprintf( '<img src="%s" alt="">', $placeholder_src );
			}

			$html = wp_get_attachment_image( $thumbnail_id, $image_size, false, $attr );

			if ( $use_thumb_effect && $enable_thumb_effect ){
				$html = $this->add_thumb_effect( $html , $product, $image_size, $attr );
			}

			return apply_filters( 'jet-woo-widgets/template-functions/product-thumbnail', $html );
		}

		/**
		 * Add one more thumbnail for products in loop
		 *
		 * @param $html
		 * @param $product
		 * @param $image_size
		 * @param $attr
		 *
		 * @return string
		 */
		public function add_thumb_effect( $html , $product, $image_size, $attr ) {
			$thumb_effect = jet_woo_widgets_settings()->get( 'product_thumb_effect' );
			$attachment_ids = $product->get_gallery_image_ids();

			if ( empty( $attachment_ids[0] ) ) {
				return $html;
			}

			if ( empty( $thumb_effect ) ){
				$thumb_effect = 'slide-left';
			}

			$effect         = $thumb_effect;
			$additional_id  = $attachment_ids[0];
			$additional_img = wp_get_attachment_image( $additional_id, $image_size, false, $attr );

			$html = sprintf(
				'<div class="jet-woo-product-thumbs effect-%3$s"><div class="jet-woo-product-thumbs__inner">%1$s%2$s</div></div>',
				$html, $additional_img, $effect
			);

			return $html;
		}

		/**
		 * Returns category thumbnail
		 *
		 * @return string
		 */
		public function get_category_thumbnail( $category_id, $image_size = 'thumbnail_size' ) {
			$thumbnail_id = get_term_meta( $category_id, 'thumbnail_id', true );
			$placeholder_src = Elementor\Utils::get_placeholder_image_src();

			if ( empty( $thumbnail_id ) ) {
				return sprintf( '<img src="%s" alt="">', $placeholder_src );
			}

			$html = wp_get_attachment_image( $thumbnail_id, $image_size, false );

			return apply_filters( 'jet-woo-widgets/template-functions/category-thumbnail', $html );
		}

		/**
		 * Returns product title
		 *
		 * @return string
		 */
		public function get_product_title() {
			global $product;

			return get_the_title( $product->get_id() );
		}

		/**
		 * Returns product title
		 *
		 * @return string
		 */
		public function get_product_title_link() {
			global $product;

			return  esc_url( get_permalink() );
		}

		/**
		 * Returns product title
		 *
		 * @return string
		 */
		public function get_product_rating() {
			global $product;

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				return;
			}

			$format = apply_filters(
				'jet-woo-widgets/template-functions/product-rating',
				'<span class="product-rating__stars">%s</span>'
			);

			$rating = $product->get_average_rating();
			$count  = 0;
			$html   = 0 < $rating ? sprintf( $format, wc_get_star_rating_html( $rating, $count ) ) : '';

			return $html;

		}

		/**
		 * Returns product price
		 *
		 * @return string
		 */
		public function get_product_price() {
			global $product;

			$price_html = $product->get_price_html();

			return apply_filters( 'jet-woo-widgets/template-functions/product-price', $price_html );
		}

		/**
		 * Returns product excerpt
		 *
		 * @return string
		 */
		public function get_product_excerpt() {
			global $product;

			if ( ! $product->get_short_description() ) {
				return;
			}

			return apply_filters( 'jet-woo-widgets/template-functions/product-excerpt', get_the_excerpt( $product->get_id() ) );
		}

		/**
		 * Returns product add to cart button
		 *
		 * @return string
		 */
		public function get_product_add_to_cart_button( $classes = array() ) {
			global $product;

			$args = array();

			if ( $product ) {
				$defaults = apply_filters(
					'jet-woo-widgets/template-functions/product-add-to-cart-settings',
					array(
						'quantity'   => 1,
						'class'      => esc_attr( implode( ' ', array_filter( array(
							'button',
							$classes,
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
						) ) ) ),
						'attributes' => array(
							'data-product_id'  => $product->get_id(),
							'data-product_sku' => $product->get_sku(),
							'aria-label'       => $product->add_to_cart_description(),
							'rel'              => 'nofollow',
						),
					)
				);

				$args = wp_parse_args( $args, $defaults );

				wc_get_template( 'loop/add-to-cart.php', $args );
			}
		}

		/**
		 * Returns product categories list
		 *
		 * @return string
		 */
		public function get_product_categories_list() {
			global $product;

			$separator = '<span class="separator">&#44;&nbsp;</span></li><li>';
			$before    = '<ul><li>';
			$after     = '</li></ul>';

			return get_the_term_list( $product->get_id(), 'product_cat', $before, $separator, $after );
		}

		/**
		 * Returns product categories list
		 *
		 * @return string
		 */
		public function get_product_tags_list() {
			global $product;

			$separator = '<span class="separator">&#44;&nbsp;</span></li><li>';
			$before    = '<ul><li>';
			$after     = '</li></ul>';

			return get_the_term_list( $product->get_id(), 'product_tag', $before, $separator, $after );
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
 * Returns instance of Jet_Woo_Widgets_Template_Functions
 *
 * @return object
 */
function jet_woo_widgets_template_functions() {
	return Jet_Woo_Widgets_Template_Functions::get_instance();
}
