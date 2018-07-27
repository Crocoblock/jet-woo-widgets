<?php
/**
 * Products loop item layout 3
 */
?>
<div class="jet-woo-products__thumb-wrap"><?php include $this->get_template( 'item-thumb' ); ?></div>
<div class="jet-woo-products__item-content"><?php
		include $this->get_template( 'item-categories' );
		include $this->get_template( 'item-title' );
		include $this->get_template( 'item-price' );
		include $this->get_template( 'item-content' );
		include $this->get_template( 'item-rating' );
		include $this->get_template( 'item-tags' );
	?><div class="hovered-content"><?php include $this->get_template( 'item-button' ); ?></div>
</div>