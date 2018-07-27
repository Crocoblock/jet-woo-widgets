<?php
/**
 * Loop item title
 */

$count  = $category->count;
$before = $this->get_attr( 'count_before_text' );
$after  = $this->get_attr( 'count_after_text' );

if ( 'yes' !== $this->get_attr( 'show_count' ) ) {
	return;
}
?>

<?php echo sprintf( '<span class="jet-woo-category-count">%2$s%1$s%3$s</span>', $count, $before, $after ); ?>