<?php
/**
 * My Theme functions and definitions
 *
 * @package WordPress
 * @subpackage MyTheme
 * @since MyTheme 1.0
 */

function mytheme_setup() {
	
	add_theme_support( 'post-thumbnails');
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-width' => true,
	) );
	

}
add_action( 'after_setup_theme', 'mytheme_setup' );
function mytheme_the_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}

function my_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'mytheme' ),
		'id'            => 'sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'mytheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'my_widgets_init' );

register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'mytheme' ),
	) );

/**
 * Enqueues scripts and styles.
 *
*/
function mytheme_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'mytheme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mytheme_scripts' );
