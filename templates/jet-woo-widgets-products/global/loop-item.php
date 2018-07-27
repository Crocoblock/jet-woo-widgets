<?php
/**
 * Products loop item template
 */

$classes = array(
	jet_woo_widgets_tools()->col_classes( array(
		'desk' => $this->get_attr( 'columns' ),
		'tab'  => $this->get_attr( 'columns_tablet' ),
		'mob'  => $this->get_attr( 'columns_mobile' ),
	) )
);

$enable_thumb_effect = filter_var( jet_woo_widgets_settings()->get( 'enable_product_thumb_effect' ), FILTER_VALIDATE_BOOLEAN );

if ( $enable_thumb_effect ){
	array_push( $classes, 'jet-woo-thumb-with-effect' );
}
?>
<div class="jet-woo-products__item <?php echo implode( ' ', $classes ); ?>">
	<div class="jet-woo-products__inner-box"><?php include $this->get_product_preset_template(); ?></div>
</div>