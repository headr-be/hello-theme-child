<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);
	
    wp_enqueue_script( 
		'custom-script', 
		get_stylesheet_directory_uri() . '/script.js?v=1', 
		['jquery'], 
		null, 
		true 
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );




// Display PHP errors for admins
if ( current_user_can('administrator') && !wp_doing_ajax() ) {
	ini_set('display_errors', 1); 
}

// SVG Uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Disable title in Hello Elementor theme
add_filter( 'hello_elementor_page_title', '__return_false' );


// Year shortcode for footer
function display_year() {
    return date('Y');
}
add_shortcode('year', 'display_year');


// Disable fullscreen editor
function disable_editor_fullscreen_mode() {
  $script = "window.onload = function() { 
    const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); 
    if ( isFullscreenMode ) { 
      wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); 
    } 
  }";
  wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'disable_editor_fullscreen_mode' );

// Move Yoast SEO Box to bottom
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );
