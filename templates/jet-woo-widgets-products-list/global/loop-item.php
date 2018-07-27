<?php
/**
 * Products list loop item template
 */
?>
<li class="jet-woo-products-list__item">
	<div class="jet-woo-products-list__inner-box">
		<div class="jet-woo-products-list__item-img"><?php  include $this->get_template( 'item-thumb' ); ?></div>
	 <div class="jet-woo-products-list__item-content"><?php
	   include $this->get_template( 'item-categories' );
	   include $this->get_template( 'item-title' );
	   include $this->get_template( 'item-price' );
	   include $this->get_template( 'item-button' );
	   include $this->get_template( 'item-rating' );
	   ?></div>
	</div>
</li>