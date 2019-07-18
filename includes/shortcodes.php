<?php
/**
 * Registers our plugin short codes
 *
 * @copyright   Copyright (c) 2014, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
	exit;
}
function getLocalDateFormat()
{
	if (function_exists('pll_current_language')) {
		switch(pll_current_language()) {
		case 'de':
			return 'j. F Y, H:i';
		case 'fr':
			return 'j F Y, H:i';
		case 'it':
			return 'j F Y, H:i';
		default:
			return get_option('date_format', __('F j, Y, H:i', 'wpplugin-simple-post-expiration'));
		}
	}
	return get_option('date_format', __('F j, Y, H:i', 'wpplugin-simple-post-expiration'));
}
/**
 * Register the [expires] short code
 *
 * @access public
 * @since 1.0
 * @return string
 */
function pw_spe_shortcode($atts, $content = null)
{
	$atts = shortcode_atts(array(
		'expires_on'  => __('This item expires on: %s', 'wpplugin-simple-post-expiration'),
		'expired'     => __('This item expired on: %s', 'wpplugin-simple-post-expiration'),
		'date_format' => getLocalDateFormat(),
		'class'       => 'pw-spe-post-expiration',
		'id'          => 'pw-spe-post-expiration-%d',
	), $atts, 'pw_spe');

	$atts = apply_filters('pw_spe_shortcode_atts', $atts);

	$date = get_post_meta(get_the_ID(), 'pw_spe_expiration', true);

	$expires = '<div id="' . sprintf($atts['id'], get_the_ID()) . '" class="' . esc_attr($atts['class']) . '">';
	$atts['date_format'] = getLocalDateFormat();

	if (pw_spe_is_expired(get_the_ID())) {
		$text = $atts['expired'];
	} else {
		$text = $atts['expires_on'];
	}

		$expires .= sprintf($text, date_i18n($atts['date_format'], strtotime($date)));

	$expires .= '</div>';

	return $expires;
}
add_shortcode('expires', 'pw_spe_shortcode');
