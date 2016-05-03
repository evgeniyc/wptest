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

		<?php 
			if(have_posts()):
				if(get_post_type() == 'products'):
					$order_link = site_url('basket');
					// Start the loop.
					while ( have_posts() ) : the_post(); 
					$link = get_permalink(); ?>
						<div class="wpt-block">
							<div class="wpt-product">
								<h3><?php the_title(); ?></h3>
								<?php the_content(); ?>
							</div>
							<div class="wpt-button-block">
								<a href="<?php echo $link; ?>"><button>Просмотреть</button></a>
								<a href="<?php echo $order_link.'/?add='.get_the_ID(); ?>"><button>Заказать</button></a>
							</div>
						</div>	
				<?php endwhile;
				else:
					while ( have_posts() ) : the_post(); ?>
					<h3><?php the_title(); ?></h3>
					<div><?php the_content(); ?></div>	
				<?php endwhile;
				endif;
			else: echo 'Sorry, nothing found.';
			endif; 
		?>
		
		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
