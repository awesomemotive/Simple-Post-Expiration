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

/**
 * Render the metabox options in the main Publish box
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_add_expiration_field() {

	global $post;

	if( ! empty( $post->ID ) ) {
		$expires = get_post_meta( $post->ID, 'pw_spe_expiration', true );
	}

	$label = ! empty( $expires ) ? date_i18n( 'Y-n-d', strtotime( $expires ) ) : __( 'never', 'pw-spe' );
	$date  = ! empty( $expires ) ? date_i18n( 'Y-n-d', strtotime( $expires ) ) : '';
?>
	<div id="pw-spe-expiration-wrap" class="misc-pub-section">
		<span>
			<span class="wp-media-buttons-icon dashicons dashicons-calendar"></span>&nbsp;
			<?php _e( 'Expires:', 'pw-spe' ); ?>
			<b id="pw-spe-expiration-label"><?php echo $label; ?></b>
		</span>
		<a href="#" id="pw-spe-edit-expiration" class="pw-spe-edit-expiration hide-if-no-js">
			<span aria-hidden="true"><?php _e( 'Edit', 'pw-spe' ); ?></span>&nbsp;
			<span class="screen-reader-text"><?php _e( 'Edit date and time', 'pw-spe' ); ?></span>
		</a>
		<div id="pw-spe-expiration-field" class="hide-if-js">
			<p>
				<input type="text" name="pw-spe-expiration" id="pw-spe-expiration" value="<?php echo esc_attr( $date ); ?>" placeholder="yyyy-mm-dd"/>
			</p>
			<p>
				<a href="#" class="pw-spe-hide-expiration button secondary"><?php _e( 'OK', 'pw-spe' ); ?></a>
				<a href="#" class="pw-spe-hide-expiration cancel"><?php _e( 'Cancel', 'pw-spe' ); ?></a>
			</p>
		</div>
		<?php wp_nonce_field( 'pw_spe_edit_expiration', 'pw_spe_expiration_nonce' ); ?>
	</div>
<?php
}
add_action( 'post_submitbox_misc_actions', 'pw_spe_add_expiration_field' );

/**
 * Save the posts's expiration date
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_save_expiration( $post_id = 0 ) {

	if( empty( $_POST['pw_spe_expiration_nonce'] ) ) {
		return;
	}

	if( ! wp_verify_nonce( $_POST['pw_spe_expiration_nonce'], 'pw_spe_edit_expiration' ) ) {
		return;
	}

	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
		return;
	}

	$expiration = ! empty( $_POST['pw-spe-expiration'] ) ? sanitize_text_field( $_POST['pw-spe-expiration'] ) : false;

	if( $expiration ) {

		update_post_meta( $post_id, 'pw_spe_expiration', $expiration );

	} else {

		delete_post_meta( $post_id, 'pw_spe_expiration' );

	}

}
add_action( 'save_post', 'pw_spe_save_expiration' );

/**
 * Load our JS and CSS files
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_scripts() {
	wp_enqueue_style( 'jquery-ui-css', PW_SPE_ASSETS_URL . '/css/jquery-ui-fresh.min.css' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'jquery-ui-slider' );
	wp_enqueue_script( 'pw-spe-expiration', PW_SPE_ASSETS_URL . '/js/edit.js' );
}
add_action( 'load-post-new.php', 'pw_spe_scripts' );
add_action( 'load-post.php', 'pw_spe_scripts' );