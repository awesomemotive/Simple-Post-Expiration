<?php
/**
 * Plugin Name: Simple Post Expiration
 * Plugin URL: http://pippinsplugins.com/simple-post-expiration
 * Description: A simple plugin that allows you to set an expiration date on posts. Once a post is expired, "Expired" will be prefixed to the post title.
 * Version: 1.0
 * Author: Pippin Williamson
 * Author URI: http://pippinsplugins.com
 * Contributors: mordauk, rzen
*/

define( 'PW_SPE_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets' ) ;

if( is_admin() ) {

	require_once dirname( __FILE__ ) . '/includes/metabox.php';
	require_once dirname( __FILE__ ) . '/includes/settings.php';

}

/**
 * Register our plugin settings
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_filter_title( $title = '', $post_id = 0 ) {

	$expires = get_post_meta( $post_id, 'pw_spe_expiration', true );
	if( ! empty( $expires ) ) {

		// Get the current time and the post's expiration date
		$current_time = current_time( 'timestamp' );
		$expiration   = strtotime( $expires, current_time( 'timestamp' ) );

		// Determine if current time is greater than the expiration date
		if( $current_time >= $expiration ) {

			// Post is expired so attach the prefix
			$prefix = get_option( 'pw_spe_prefix', __( 'Expired:', 'pw-spe' ) );
			$title  = $prefix . '&nbsp;' . $title;

		}

	}

	return $title;

}
add_filter( 'the_title', 'pw_spe_filter_title', 100, 2 );