<?php
/**
 * Loop item thumbnail
 */

$size       = $this->get_attr( 'thumb_size' );
$thumbnail  = jet_woo_widgets_template_functions()->get_product_thumbnail( $size, true );
$sale_badge = jet_woo_widgets_template_functions()->get_product_sale_flash( $this->get_attr( 'sale_badge_text' ) );

if ( null === $thumbnail ) {
	return;
}
?>
<div class="jet-woo-product-thumbnail">
	<a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php echo wp_kses_post( $thumbnail ); ?></a>
	<div class="jet-woo-product-img-overlay"></div><?php
		if ( null != $sale_badge && 'yes' === $this->get_attr( 'show_badges' ) ) {
			echo sprintf( '<div class="jet-woo-product-badges">%s</div>', $sale_badge );
		}
	?></div>
