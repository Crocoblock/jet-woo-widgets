<?php
/**
 * Categories loop item layout 2
 */


?>

<?php include $this->get_template( 'item-thumb' ); ?>
<div class="jet-woo-categories-content"><?php
	include $this->get_template( 'item-title' );
	include $this->get_template( 'item-description' );
	?><div class="jet-woo-category-count__wrap"><?php include $this->get_template( 'item-count' ); ?></div>
</div>
