<?php
/**
 * Products loop start template
 */

$classes = array(
	'jet-woo-products',
	'jet-woo-products--' . $this->get_attr( 'presets' ),
	'col-row',
	jet_woo_widgets_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'jet-equal-cols';
}

?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
