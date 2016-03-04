<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Underscores Starter
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'main-sidebar' ) ) : ?>
			
		<?php else : ?>
			<?php dynamic_sidebar('main-sidebar'); ?>
		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
