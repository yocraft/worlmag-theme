<?php
/**
 * Custom functions to be used within Elementor plugin.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 2.2.3
 */

if ( ! function_exists( 'colormag_elementor_categories' ) ) :

	/**
	 * Return the values of all the categories of the posts present in the site.
	 *
	 * @return array of category ids and its respective names.
	 *
	 * @since ColorMag 2.2.3
	 */
	function colormag_elementor_categories() {
		$output     = array();
		$categories = get_categories();

		foreach ( $categories as $category ) {
			$output[ $category->term_id ] = $category->name;
		}

		return $output;
	}

endif;

if ( ! function_exists( 'colormag_elementor_tags' ) ) :

	/**
	 * Return the values of all the tags of the posts present in the site.
	 *
	 * @return array of tags ids and its respective names.
	 *
	 * @since ColorMag 2.2.7
	 */
	function colormag_elementor_tags() {
		$output = array();
		$tags   = get_tags();

		foreach ( $tags as $tag ) {
			$output[ $tag->term_id ] = $tag->name;
		}

		return $output;
	}

endif;

if ( ! function_exists( 'colormag_elementor_authors' ) ) :

	/**
	 * Return the available authors in the site.
	 *
	 * @return array of author ids and its respective names.
	 *
	 * @since ColorMag 2.2.7
	 */
	function colormag_elementor_authors() {
		$output  = array();
		$authors = get_users(
			array(
				'capability' => 'authors',
			)
		);

		foreach ( $authors as $author ) {
			$output[ $author->ID ] = $author->display_name;
		}

		return $output;
	}

endif;

/**
 * Colormag_Elementor required setups.
 *
 * Particularly used for registering post thumbnail size and others.
 *
 * Hooked in after_setup_theme.
 *
 * @since ColorMag 2.2.3
 */
function colormag_elementor_setup() {

	// Cropping the images to different sizes to be used in the theme for Elementor.
	// For the block widgets.
	add_image_size( 'colormag-elementor-block-extra-large-thumbnail', 1155, 480, true );

	// For the grid widgets.
	add_image_size( 'colormag-elementor-grid-large-thumbnail', 600, 417, true );
	add_image_size( 'colormag-elementor-grid-small-thumbnail', 285, 450, true );
	add_image_size( 'colormag-elementor-grid-medium-large-thumbnail', 575, 198, true );

}

add_action( 'after_setup_theme', 'colormag_elementor_setup' );

if ( ! function_exists( 'colormag_elementor_widgets_meta' ) ) :

	/**
	 * Display the posts meta for use within Elementor widgets
	 *
	 * @since ColorMag 2.2.3
	 */
	function colormag_elementor_widgets_meta( $meta = array() ) {

		$meta_orders = get_theme_mod(
			'colormag_post_meta_structure',
			array(
				'categories',
				'date',
				'author',
			)
		);

		$human_diff_time = '';

		if ( get_theme_mod( 'colormag_post_meta_date_style', 'style-1' ) == 'style-2' ) {
			$human_diff_time = 'human-diff-time';
		}
		?>

		<div class="tg-module-meta <?php echo esc_attr( $human_diff_time ); ?>">
			<?php

			foreach ( $meta_orders as $key => $meta_order ) {

				if ( 'date' === $meta_order ) {
					colormag_elementor_date_meta_markup();
				}

				if ( 'author' === $meta_order ) {
					colormag_elementor_author_meta_markup( $meta );
				}

				if ( 'comments' === $meta_order ) {
					colormag_elementor_comment_meta_markup( $meta );
				}

				if ( 'read-time' === $meta_order ) {
					colormag_elementor_read_time_meta_markup( $meta );
				}
			}

			?>

		</div>

		<?php
	}

endif;

if ( ! function_exists( 'colormag_elementor_styles' ) ) :

	/**
	 * Loads styles on elementor editor.
	 *
	 * @since ColorMag 2.2.3
	 */
	function colormag_elementor_styles() {
		wp_enqueue_style( 'colormag-econs', get_template_directory_uri() . '/inc/elementor/assets/css/colormag-econs.css', false, '1.0' );
	}

endif;

add_action( 'elementor/editor/after_enqueue_styles', 'colormag_elementor_styles' );


if ( ! function_exists( 'colormag_elementor_colored_category' ) ) :

	/**
	 * Display/Returns the category names for Elementor widgets.
	 *
	 * @param bool $display The option to display or echo the value.
	 *
	 * @return mixed
	 *
	 * @since ColorMag 2.2.3
	 */
	function colormag_elementor_colored_category( $display = 1 ) {
		global $post;
		$categories = get_the_category();
		$separator  = '&nbsp;';
		$output     = '';

		if ( $categories ) {
			$output .= '<div class="tg-cm-post-categories">';

			foreach ( $categories as $category ) {
				$color_code = colormag_category_color( get_cat_id( $category->cat_name ) );
				if ( ! empty( $color_code ) ) {
					$output .= '<a href="' . get_category_link( $category->term_id ) . '" style="background:' . colormag_category_color( get_cat_id( $category->cat_name ) ) . '" class="tg-post-category" rel="category tag">' . $category->cat_name . '</a>';
				} else {
					$output .= '<a href="' . get_category_link( $category->term_id ) . '" class="tg-post-category" rel="category tag">' . $category->cat_name . '</a>';
				}
			}

			$output .= '</div>';

			if ( 0 == $display ) {
				$output = trim( $output );
			}

			if ( 1 == $display ) {
				echo trim( $output); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}

		if ( 0 == $display ) {
			return $output;
		}
	}

endif;

if ( ! function_exists( 'colormag_elementor_date_meta_markup' ) ) :

	function colormag_elementor_date_meta_markup() {

		// Displays the same published and updated date if the post is never updated.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		// Displays the different published and updated date if the post is updated.
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		?>

		<?php if ( empty( $meta ) || in_array( 'date', $meta, true ) ) : ?>

			<span class="tg-post-date entry-date">
				<?php echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
			</span>

			<?php
			if ( 'style-2' === get_theme_mod( 'colormag_post_meta_date_style', 'style-1' ) ) {
				printf(
					/* Translators: %s human-readable time difference */
					_x( '<span class="tg-post-date cm-post-date human-diff-time-display">%s ago</span>', '%s = human-readable time difference', 'colormag' ),
					human_time_diff(
						get_the_time( 'U' ),
						current_time( 'timestamp' )
					)
				); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}

		endif;
	}

endif;

if ( ! function_exists( 'colormag_elementor_author_meta_markup' ) ) :

	function colormag_elementor_author_meta_markup( $meta ) {

		if ( empty( $meta ) || in_array( 'author', $meta, true ) ) {
			?>
			<span class="tg-post-auther-name author vcard">
				<?php echo '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'; ?>
			</span>
			<?php
		}
	}

endif;

if ( ! function_exists( 'colormag_elementor_comment_meta_markup' ) ) :

	function colormag_elementor_comment_meta_markup( $meta ) {

		if ( empty( $meta ) || in_array( 'comment', $meta, true ) ) {

			if ( ! post_password_required() && comments_open() ) {
				?>
				<span class="tg-module-comments">
					<?php comments_popup_link( '0', '1', '%' ); ?>
				</span>
				<?php
			}
		}
	}

endif;

if ( ! function_exists( 'colormag_elementor_read_time_meta_markup' ) ) :

	function colormag_elementor_read_time_meta_markup( $meta ) {

		if ( empty( $meta ) || in_array( 'reading_time', $meta, true ) ) {

			echo '<span class="cm-reading-time"> ' . colormag_get_icon( 'hourglass', false ) . ' ' . esc_html( colormag_reading_time() ) . '
			</span> ';
		}
	}

endif;
