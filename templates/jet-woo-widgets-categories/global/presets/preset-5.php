<?php
/**
 * Categories loop item layout 5
 */

?>

<div class="jet-woo-categories-thumbnail__wrap"><?php include $this->get_template( 'item-thumb' ); ?></div>
<div class="jet-woo-categories-content">
	<div class="jet-woo-category-content__inner">
	  <?php
	  include $this->get_template( 'item-title' );
	  include $this->get_template( 'item-description' );
	  ?>
	</div>
	<div class="jet-woo-category-count__wrap"><?php include $this->get_template( 'item-count' ); ?></div>
</div>