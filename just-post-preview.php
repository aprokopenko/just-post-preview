<?php
/*
Plugin Name: Just Post Preview Widget
Description: Widget to easy add any content preview block with different layouts, specified in the theme.
Tags: post preview, widget, layouts, developer
Version: 1.0
Author: Alexander Prokopenko 
Author URI: http://justcoded.com/
*/

define('JPP_PATH', dirname(__FILE__));
define('JPP_URL', WP_PLUGIN_URL . '/'. basename(JPP_PATH) . '/' );
require_once( JPP_PATH . '/just-post-preview.widget.php' );

// print helper function
if( ! function_exists('pa') ) :
function pa($mixed, $stop = false) {
	$ar = debug_backtrace(); $key = pathinfo($ar[0]['file']); $key = $key['basename'].':'.$ar[0]['line'];
	$print = array($key => $mixed); print( '<pre>'.(print_r($print,1)).'</pre>' );
	if($stop == 1) exit();
}
endif;

/**
 * init widget
 */
function jpp_register_widgets() {
	register_widget( 'JPP_Widget_Post_Preview' );
	add_action( 'wp_ajax_jpp_widget_post_preview_autocomplete', array('JPP_Widget_Post_Preview', 'ajax_post_autocomplete') );
}
add_action( 'widgets_init', 'jpp_register_widgets' );

/**
 * add ajac callback for widget autocomplete field
 */
add_action( 'admin_print_scripts', array('JPP_Widget_Post_Preview', 'admin_scripts') );

/**
 * Duplicate excerpt function, because it doesn't have param for ID
 * @param WP_Post $post
 * @return string
 */
function jpp_trim_excerpt( WP_Post $post ) {
	$raw_excerpt = $text = $post->post_excerpt;
	if ( '' == $text ) {
		$text = strip_shortcodes( $post->post_content );
		$text = apply_filters( 'wpautop', $text );
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
}
