<?php
/**
 * Loop item thumbnail
 */

$size      = $this->get_attr( 'thumb_size' );
$thumbnail = jet_woo_widgets_template_functions()->get_category_thumbnail( $category->term_id, $this->get_attr( 'thumb_size' ) );

if ( null === $thumbnail ) {
	return;
}
?>
<div class="jet-woo-category-thumbnail">
	<a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" rel="bookmark"><?php echo wp_kses_post( $thumbnail ); ?></a>
	<div class="jet-woo-category-img-overlay"></div>
	<div class="jet-woo-category-img-overlay__hover"></div>
</div>
