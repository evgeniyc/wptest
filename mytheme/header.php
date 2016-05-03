<?php
/* @package WordPress
 * @subpackage MyTheme
 * @since MyTheme 1.0
 */
 ?>
 <!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-branding">
		<div id="custom-logo"><?php mytheme_the_custom_logo(); ?></div>
		<div id="site-tytle">		
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div>	
		<div id="site-descr" class="clearfix">
			<?php $description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<?php echo $description; ?>
				<?php endif; ?>
		</div>		
	</div><!-- .site-branding -->
	<?php if ( has_nav_menu( 'primary' )) : ?>
	<div id="site-header-menu" class="site-header-menu">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php
				wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'primary-menu',
				) );
			?>
		</nav><!-- .main-navigation -->
	<?php endif; ?>
	</div><!-- #site-header-menu -->
	<div id="content" class="site-content">