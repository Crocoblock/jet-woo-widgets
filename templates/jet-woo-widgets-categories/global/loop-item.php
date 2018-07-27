<?php
/**
 * Categories loop item template
 */
?>
<div class="jet-woo-categories__item <?php echo jet_woo_widgets_tools()->col_classes( array(
	'desk' => $this->get_attr( 'columns' ),
	'tab'  => $this->get_attr( 'columns_tablet' ),
	'mob'  => $this->get_attr( 'columns_mobile' ),
) ); ?>">
	<div class="jet-woo-categories__inner-box"><?php include $this->get_category_preset_template(); ?></div>
</div>