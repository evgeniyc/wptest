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

		<?php if ( have_posts() ) : the_post();?>
			<article>
					<header>
						<h3<?php the_title(); ?></h3>
					</header>
					<div id="post-content"><?php the_content(); ?></div>
				</article>
		<?php
		else: echo 'Sorry, nothing found.';
		endif; 
		?>
		
		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
