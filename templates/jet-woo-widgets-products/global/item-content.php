<?php
/**
 * Loop item content
 */
$excerpt = jet_woo_widgets_tools()->trim_text( jet_woo_widgets_template_functions()->get_product_excerpt(), $this->get_attr( 'excerpt_length' ), 'word', '...' );

if ( 'yes' !== $this->get_attr( 'show_excerpt' ) || null === $excerpt ) {
	return;
}
?>

<div class="jet-woo-product-excerpt"><?php echo $excerpt; ?></div>