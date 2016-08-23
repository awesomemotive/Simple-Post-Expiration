<?php
/**
 * Registers our plugin's widget
 *
 * @copyright   Copyright (c) 2014, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register Widgets
 *
 * @since 1.0
 * @return void
 */
function pw_spe_register_widgets() {
	register_widget( 'PW_SPE_Widget' );
}
add_action( 'widgets_init', 'pw_spe_register_widgets' );

/**
 * Expired posts widget
 *
 * This widget can show recently expired posts or posts that have not yet expired.
 *
 * @since 1.0
 * @return void
*/
class PW_SPE_Widget extends WP_Widget {

	/** Constructor */
	function __construct() {
		parent::__construct( false, __( 'Expired / Expiring Posts', 'pw-spe' ), array( 'description' => __( 'Display a list of expired or expiring soon posts', 'pw-spe' ) ) );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance[ 'title' ], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$compare = 'expiring' == $instance['type'] ? '>=' : '<';

		$query_args = array(
			'post_type'       => 'any',
			'orderby'         => 'meta_value',
			'meta_key'        => 'pw_spe_expiration',
			'posts_per_page'  => $instance['number'],
			'meta_query'      => array(
				array(
					'key'     => 'pw_spe_expiration',
					'value'   => date( 'Y-n-d', current_time( 'timestamp' ) ),
					'compare' => $compare,
					'type'    => 'DATETIME'
				)
			)
		);

		$items = get_posts( $query_args );

		if( $items ) {

			remove_filter( 'the_title', 'pw_spe_filter_title', 100 );

			echo '<ul class="pw-spe-items">';

			foreach( $items as $item ) {

				echo '<li>';

					echo '<a href="' . esc_url( get_permalink( $item->ID ) ) . '" title="' . esc_attr( get_the_title( $item->ID ) ) . '">' . get_the_title( $item->ID ) . '</a>';

				echo '</li>';

			}

			echo '</ul>';

			add_filter( 'the_title', 'pw_spe_filter_title', 100, 2 );

		}

		echo $args['after_widget'];

	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {

		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['type']   = strip_tags( $new_instance['type'] );
		$instance['number'] = absint( strip_tags( $new_instance['number'] ) );

		return $instance;

	}

	/** @see WP_Widget::form */
	function form( $instance ) {

		$title  = isset( $instance[ 'title' ] )  ? $instance[ 'title' ]  : '';
		$type   = isset( $instance[ 'type' ] )   ? $instance[ 'type' ]   : 'expiring';
		$number = isset( $instance[ 'number' ] ) ? $instance[ 'number' ] : 10;
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'pw-spe' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<span><?php _e( 'Type:', 'pw-spe' ); ?></span><br/>
			<label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" type="radio" value="expiring"<?php checked( 'expiring', $type ); ?>/>
				<?php _e( 'Expiring Soon', 'pw-spe' ); ?>
			</label><br/>
			<label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" type="radio" value="expired"<?php checked( 'expired', $type ); ?>/>
				<?php _e( 'Expired', 'pw-spe' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number to Show:', 'pw-spe' ); ?></label>
			<input class="tinytext" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo absint( $number ); ?>"/>
		</p>

<?php
	}
}
