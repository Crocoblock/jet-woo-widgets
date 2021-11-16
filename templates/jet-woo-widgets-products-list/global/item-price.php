<?php
/**
 * Loop item price
 */

$price = jet_woo_widgets_template_functions()->get_product_price();

if ( 'yes' !== $this->get_attr( 'show_price' ) || '' === $price ) {
	return;
}
?>

<div class="jet-woo-product-price"><?php echo wp_kses_post( $price ); ?></div>
