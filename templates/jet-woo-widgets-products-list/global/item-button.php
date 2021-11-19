<?php
/**
 * Loop add to cart button
 */

if ( 'yes' !== $this->get_attr( 'show_button' ) ) {
	return;
}

$classes = array(
	'jet-woo-product-button',
);

if ( 'yes' === $this->get_attr( 'button_use_ajax_style' ) ){
	array_push( $classes, 'is--default' );
}

?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php jet_woo_widgets_template_functions()->get_product_add_to_cart_button(); ?></div>
