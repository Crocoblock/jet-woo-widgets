<?php
/**
 * Loop item description
 */

$description = jet_woo_widgets_tools()->trim_text( $category->description, $this->get_attr( 'desc_length' ), 'word', $this->get_attr( 'desc_after_text' ) );

if ( '' === $description ) {
	return;
}
?>

<div class="jet-woo-category-excerpt"><?php echo wp_kses_post( $description ); ?></div>
