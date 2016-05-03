<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage My Theme
 * @since My Theme 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar' )  ) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
