<?php
/**
 * Loop item categories
 */

$categories = jet_woo_widgets_template_functions()->get_product_categories_list();

if ( 'yes' !== $this->get_attr( 'show_cat' ) || false === $categories ) {
	return;
}
?>

<div class="jet-woo-product-categories"><?php echo wp_kses_post( $categories ); ?></div>
