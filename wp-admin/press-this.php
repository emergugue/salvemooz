<?php
/**
 * Press This Display and Handler.
 *
 * @package WordPress
 * @subpackage Press_This
 */

define('IFRAME_REQUEST' , true);

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! current_user_can( 'edit_posts' ) || ! current_user_can( get_post_type_object( 'post' )->cap->create_posts ) )
	wp_die( __( 'Cheatin&#8217; uh?' ), 403 );

<<<<<<< HEAD
/**
 * @global WP_Press_This $wp_press_this
 */
=======
>>>>>>> 46e01415ad7554b3dbaa18b33e8007de720c8b28
if ( empty( $GLOBALS['wp_press_this'] ) ) {
	include( ABSPATH . 'wp-admin/includes/class-wp-press-this.php' );
}

$GLOBALS['wp_press_this']->html();
