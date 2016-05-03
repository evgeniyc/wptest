<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage MyTheme
 * @since MyTheme 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( get_post_type() == 'products' ) : 
					the_post();
					$order_link = site_url('basket');
				
				?>

				<div class="wpt-block-single">
					<div class="wpt-product">
						<h3 class="page-title screen-reader-text"><?php the_title(); ?></h1>
						<div id="post-image">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail();
							} ?>
						</div>
						<p><?php the_content(); ?></p>
					</div>
					<div class="wpt-button-block">
						<a href="<?php echo $order_link.'/?add='.get_the_ID(); ?>"><button>Заказать</button></a>
					</div>
				</div>
			<?php elseif ( is_single() ) : 
					the_post();
			?>
				<article>
					<header>
						<h1 class="page-title screen-reader-text"><?php the_title(); ?></h1>
					</header>
					<div id="post-content"><?php the_content(); ?></div>
				</article>
			<?php endif;
		else: echo 'Sorry, nothing found.';
		endif; ?>
		
		</main><!-- .site-main -->
	</div><!-- .content-area -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
