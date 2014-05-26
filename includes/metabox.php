<?php
/**
 * Setups our metabox field for the post edit screen
 *
 * @copyright   Copyright (c) 2014, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function pw_spe_add_expiration_field() {

	global $post;
	if( ! empty( $post->ID ) ) {
		$expires = get_post_meta( $post->ID, 'pw_spe_expiration', true );
	}
	$date = ! empty( $expires ) ? date_i18n( 'Y-n-d', strtotime( $expires ) ) : __( 'none', 'pw-spe' );
?>
<div class="misc-pub-section">
	<span><span class="wp-media-buttons-icon dashicons dashicons-calendar"></span>&nbsp;<?php printf( __( 'Expires on: %s', 'pw-spe' ), $date ); ?></span>
	<a href="#" id="pw-spe-edit-expiration" class="pw-spe-edit-expiration hide-if-no-js">
		<span aria-hidden="true"><?php _e( 'Edit', 'pw-spe' ); ?></span>&nbsp;
		<span class="screen-reader-text"><?php _e( 'Edit date and time', 'pw-spe' ); ?></span>
	</a>
	<div id="pw-spe-expiration-wrap" class="hide-if-js">
		<p>
			<input type="text" name="pw-spe-expiration" id="pw-spe-expiration" value="<?php echo esc_attr( $date ); ?>" placeholder="yyyy/mm/dd"/>
		</p>
		<p>
			<a href="#" class="pw-spe-hide-expiration button secondary"><?php _e( 'OK', 'pw-spe' ); ?></a>
			<a href="#" class="pw-spe-hide-expiration cancel"><?php _e( 'Cancel', 'pw-spe' ); ?></a>
		</p>
	</div>
</div>
<?php
}
add_action( 'post_submitbox_misc_actions', 'pw_spe_add_expiration_field' );

function pw_spe_scripts() {
	
	$ui_style   = ( 'classic' == get_user_option( 'admin_color' ) ) ? 'classic' : 'fresh';
	
	wp_enqueue_style( 'jquery-ui-css', PW_SPE_ASSETS_URL . '/css/jquery-ui-' . $ui_style . '.min.css' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'pw-spe-expiration', PW_SPE_ASSETS_URL . '/js/edit.js' );
}
add_action( 'admin_enqueue_scripts', 'pw_spe_scripts' );