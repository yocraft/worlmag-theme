<?php
/**
 * 300x250 Advertisement Ads Widget.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 300x250 Advertisement Ads Widget.
 *
 * Class colormag_300x250_advertisement_widget
 */
class colormag_300x250_advertisement_widget extends ColorMag_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->widget_cssclass    = 'widget_300x250_advertisement';
		$this->widget_description = esc_html__( 'Add your 300x250 Advertisement here', 'colormag' );
		$this->widget_name        = esc_html__( 'TG: 300x250 Advertisement', 'colormag' );
		$this->settings           = array(
			'title'                => array(
				'type'    => 'text',
				'default' => '',
				'label'   => esc_html__( 'Title:', 'colormag' ),
			),
			'image_addition_label' => array(
				'type'    => 'custom',
				'default' => '',
				'label'   => esc_html__( 'Add your Advertisement 300x250 Images Here', 'colormag' ),
			),
			'300x250_image_link'   => array(
				'type'    => 'url',
				'default' => '',
				'label'   => esc_html__( 'Advertisement Image Link ', 'colormag' ),
			),
			'300x250_image_url'    => array(
				'type'    => 'image',
				'default' => '',
				'label'   => esc_html__( 'Advertisement Image ', 'colormag' ),
			),
			'rel_value'            => array(
				'type'    => 'checkbox',
				'default' => '0',
				'label'   => esc_html__( 'Check to make dofollow link.', 'colormag' ),
			),
		);

		parent::__construct();

	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {

		$title      = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$rel_value  = ! empty( $instance['rel_value'] ) ? true : false;
		$image_link = isset( $instance['300x250_image_link'] ) ? $instance['300x250_image_link'] : '';
		$image_url  = isset( $instance['300x250_image_url'] ) ? $instance['300x250_image_url'] : '';

		// For WPML plugin compatibility, register string.
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'ColorMag Pro', 'TG: 300x250 Image Link' . $this->id, $image_link );
			icl_register_string( 'ColorMag Pro', 'TG: 300x250 Image URL' . $this->id, $image_url );
		}

		// For WPML plugin compatibility, assign variable to converted string.
		if ( function_exists( 'icl_t' ) ) {
			$image_link = icl_t( 'ColorMag Pro', 'TG: 300x250 Image Link' . $this->id, $image_link );
			$image_url  = icl_t( 'ColorMag Pro', 'TG: 300x250 Image URL' . $this->id, $image_url );
		}

		$this->widget_start( $args );
		?>

		<div class="advertisement_300x250">
			<?php if ( ! empty( $title ) ) { ?>
				<div class="cm-advertisement-title">
					<?php echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] ); ?>
				</div>
				<?php
			}

			$output = '';

			if ( ! empty( $image_url ) ) {
				$image_id  = attachment_url_to_postid( $image_url );
				$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

				$output .= '<div class="cm-advertisement-content">';
				if ( ! empty( $image_link ) ) {
					$value = $rel_value ? '' : 'rel="nofollow"';

					$output .= '<a href="' . $image_link . '" class="single_ad_300x250" target="_blank" ' . $value . '>';
					$output .= '<img src="' . $image_url . '" width="300" height="250" alt="' . $image_alt . '">';
					$output .= '</a>';
				} else {
					$output .= '<img src="' . $image_url . '" width="300" height="250" alt="' . $image_alt . '">';
				}
				$output .= '</div>';

				echo $output; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>

		<?php
		$this->widget_end( $args );

	}

}

