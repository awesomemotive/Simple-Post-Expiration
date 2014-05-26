<?php
/**
 * Registers our plugin settings
 *
 * @copyright   Copyright (c) 2014, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register our plugin settings
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_register_settings() {
	register_setting( 'reading', 'pw_spe_prefix', 'sanitize_text_field' );
	add_settings_field( 'pw_spe_prefix', __( 'Expired Item Prefix', 'pw-spe' ), 'pw_spe_settings_field', 'reading', 'default' );
}
add_action( 'admin_init', 'pw_spe_register_settings' );

/**
 * Render our settings field
 *
 * @access public
 * @since 1.0
 * @return void
 */
function pw_spe_settings_field() {
	$prefix = get_option( 'pw_spe_prefix', __( 'Expired:', 'pw-spe' ) );
	echo '<input type="text" name="pw_spe_prefix" value="' . esc_attr( $prefix ) . '" class="regular-text"/><br/>';
	echo '<p class="description">' . __( 'Enter the text you would like prepended to expired items.', 'pw-spe' ) . '</p>';
}