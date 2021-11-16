<?php
/**
 * Loop item price
 */

$rating = jet_woo_widgets_template_functions()->get_product_rating();

if ( 'yes' !== $this->get_attr( 'show_rating' ) || '' === $rating ) {
	return;
}
?>

<div class="jet-woo-product-rating"><?php echo wp_kses_post( $rating ); ?></div>
