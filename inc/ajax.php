<?php
/**
 * Localize load more scripts.
 *
 * @package ColorMag
 *
 * @since   ColorMag 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Localizing the load more button text to add nonce and ajax url.
 */
function colormag_register_load_more_scripts() {
	wp_localize_script(
		'colormag-custom',
		'colormag_load_more',
		array(
			'tg_nonce' => wp_create_nonce( 'tg_nonce' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'colormag_register_load_more_scripts' );

/**
 * Ajax load more posts
 */
function colormag_get_ajax_results() {

	if ( ! isset( $_POST['tg_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['tg_nonce'] ), 'tg_nonce' ) ) {
		die( esc_html__( 'Permissions check failed.', 'colormag' ) );
	}

	$tg_pagenumber     = isset( $_POST['tg_pagenumber'] ) ? wp_unslash( $_POST['tg_pagenumber'] ) : 0;
	$tg_category       = isset( $_POST['tg_category'] ) ? wp_unslash( $_POST['tg_category'] ) : '-1';
	$tg_number         = isset( $_POST['tg_number'] ) ? wp_unslash( $_POST['tg_number'] ) : 0;
	$tg_random         = isset( $_POST['tg_random'] ) ? wp_unslash( $_POST['tg_random'] ) : 'false';
	$tg_child_category = isset( $_POST['tg_child_category'] ) ? wp_unslash( $_POST['tg_child_category'] ) : 'false';
	$tg_tag            = isset( $_POST['tg_tag'] ) ? wp_unslash( $_POST['tg_tag'] ) : '-1';
	$tg_author         = isset( $_POST['tg_author'] ) ? wp_unslash( $_POST['tg_author'] ) : '-1';
	$tg_type           = isset( $_POST['tg_type'] ) ? wp_unslash( $_POST['tg_type'] ) : 'latest';

	global $post;
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $tg_number,
		'paged'          => $tg_pagenumber,
		'post_status'    => 'publish',
	);

	// Display post from choosen category.
	if ( 'category' == $tg_type && '-1' != $tg_category && 1 != $tg_child_category ) {
		$args['category__in'] = $tg_category;
	}

	// Display post from choosen parent category.
	if ( 'category' == $tg_type && 1 == $tg_child_category && '-1' != $tg_category ) {
		$args['cat'] = $tg_category;
	}

	// Display random post.
	if ( 'true' == $tg_random ) {
		$args['orderby'] = 'rand';
	}

	// Display post from choosen tag.
	if ( 'tag' == $tg_type && '-1' != $tg_tag ) {
		$args['tag__in'] = $tg_tag;
	}

	// Display post from choosen author.
	if ( 'author' == $tg_type && '-1' != $tg_author ) {
		$args['author__in'] = $tg_author;
	}

	$featured_ajax_posts = new WP_Query( $args );

	if ( $featured_ajax_posts->have_posts() ) :
		?>
		<div class="cm-posts">
			<?php
			while ( $featured_ajax_posts->have_posts() ) :
				$featured_ajax_posts->the_post();
				?>

				<div class="cm-post">
					<?php
					if ( has_post_thumbnail() ) {
						$image           = '';
						$thumbnail_id    = get_post_thumbnail_id( $post->ID );
						$image_alt_text  = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						$title_attribute = get_the_title( $post->ID );
						$image_alt_text  = empty( $image_alt_text ) ? $title_attribute : $image_alt_text;

						$image .= '<figure>';
						$image .= '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
						$image .= get_the_post_thumbnail(
							$post->ID,
							'colormag-featured-post-small',
							array(
								'title' => esc_attr( $title_attribute ),
								'alt'   => esc_attr( $image_alt_text ),
							)
						);
						$image .= '</a>';
						$image .= '</figure>';

						echo wp_kses_post( $image );
					}
					?>

					<div class="cm-post-content">
						<h3 class="cm-entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>

						<?php colormag_entry_meta( false, true ); ?>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<?php
	endif;
}

add_action( 'wp_ajax_get_ajax_results', 'colormag_get_ajax_results' );        // For logged in users.
add_action( 'wp_ajax_nopriv_get_ajax_results', 'colormag_get_ajax_results' ); // For logged out users.

/**
 * Localize script for load more button.
 */
function colormag_load_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'colormag-loadmore', get_template_directory_uri() . '/assets/js/loadmore' . $suffix . '.js', array(), COLORMAG_THEME_VERSION, true );
	wp_localize_script(
		'colormag-loadmore',
		'colormag_script_vars',
		array(
			'no_more_posts' => esc_html__( 'No more post', 'colormag' ),
		)
	);

}

add_action( 'wp_enqueue_scripts', 'colormag_load_scripts' );

function colormag_next_post_load_response() {

	check_ajax_referer( 'colormag_infinite_scroll_nonce', 'nonce' );

	global $post;

	$cur_post__id                 = ( isset( $_POST['cur_post_id'] ) ) ? (int) wp_unslash( $_POST['cur_post_id'] ) : $post->ID; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$query_vars['post_type']      = 'post';
	$query_vars['paged']          = ( isset( $_POST['page_no'] ) ) ? wp_unslash( $_POST['page_no'] ) : 1; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$query_vars['post_status']    = 'publish';
	$query_vars['posts_per_page'] = 1;
	$query_vars['post__not_in']   = array( $cur_post__id );
	$query_vars['category__in']   = ( isset( $_POST['cat_id'] ) ) ? $_POST['cat_id'] : null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$query                        = new WP_Query( $query_vars );

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {

			$query->the_post();

			$comments = get_comments( array( 'post_id' => get_the_ID() ) );

			if ( ! empty( $comments ) ) {
				$query->comments      = $comments;
				$query->comment_count = count( $comments );
			}

			$backup = $post;

			get_template_part( 'template-parts/content', 'single' );

			if ( true === apply_filters( 'colormag_single_post_page_navigation_filter', true ) ) :
				if ( 1 == get_theme_mod( 'colormag_enable_post_navigation', 1 ) ) :
					colormag_ajax_single_post_navigation();
				endif;
			endif;

			do_action( 'colormag_action_after_single_post_content' );

			$post = $backup; // phpcs:ignore

			colormag_ajax_single_post_comments( $query, $comments );

		}
	}

	$query->reset_postdata();
	wp_die();
}
add_action( 'wp_ajax_colormag_next_post_load_response', 'colormag_next_post_load_response' );
add_action( 'wp_ajax_nopriv_colormag_next_post_load_response', 'colormag_next_post_load_response' );


/**
 * Navigation for single post that loads on scroll on single post page.
 */
function colormag_ajax_single_post_navigation() {

	if ( is_attachment() ) :
		?>
		<ul class="default-wp-page">
			<li class="previous"><?php previous_image_link( false, esc_html__( '&larr; Previous', 'colormag' ) ); ?></li>
			<li class="next"><?php next_image_link( false, esc_html__( 'Next &rarr;', 'colormag' ) ); ?></li>
		</ul>
		<?php
	else :

		if ( 'style-2' === get_theme_mod( 'colormag_post_navigation_style', 'default' ) ) :

			// For previous post.
			$prev_thumb_image = '';
			$prev_post        = get_previous_post();

			if ( $prev_post ) {
				$prev_thumb_image = get_the_post_thumbnail( $prev_post->ID, 'colormag-featured-post-small' );
			}

			// For next post.
			$next_thumb_image = '';
			$next_post        = get_next_post();

			if ( $next_post ) {
				$next_thumb_image = get_the_post_thumbnail( $next_post->ID, 'colormag-featured-post-small' );
			}
			?>

			<ul class="default-wp-page thumbnail-pagination">
				<?php if ( get_previous_post_link() ) { ?>
					<li class="previous">
						<?php previous_post_link( $prev_thumb_image . '%link', '<span class="meta-nav">' . esc_html_x( '&larr; Previous', 'Previous post link', 'colormag' ) . '</span> %title' ); ?>
					</li>
				<?php } ?>

				<?php if ( get_next_post_link() ) { ?>
					<li class="next">
						<?php next_post_link( '%link' . $next_thumb_image, '%title <span class="meta-nav">' . esc_html_x( 'Next &rarr;', 'Next post link', 'colormag' ) . '</span>' ); ?>
					</li>
				<?php } ?>
			</ul>

			<?php
		elseif ( 'style-3' === get_theme_mod( 'colormag_post_navigation_style', 'default' ) ) :

			// For previous post.
			$prev_thumb_image = '';
			$prev_post        = get_previous_post();

			if ( $prev_post ) {
				$prev_thumb_image = get_the_post_thumbnail( $prev_post->ID, 'colormag-featured-post-medium' );
			}

			// For next post.
			$next_thumb_image = '';
			$next_post        = get_next_post();

			if ( $next_post ) {
				$next_thumb_image = get_the_post_thumbnail( $next_post->ID, 'colormag-featured-post-medium' );
			}
			?>

			<ul class="default-wp-page thumbnail-background-pagination">
				<?php if ( get_previous_post_link() ) { ?>
					<li class="previous">
						<?php previous_post_link( $prev_thumb_image . '%link', '<span class="meta-nav">' . esc_html_x( '&larr; Previous', 'Previous post link', 'colormag' ) . '</span> %title' ); ?>
					</li>
				<?php } ?>

				<?php if ( get_next_post_link() ) { ?>
					<li class="next">
						<?php next_post_link( '%link' . $next_thumb_image, '<span class="meta-nav">' . esc_html_x( 'Next &rarr;', 'Next post link', 'colormag' ) . '</span> %title' ); ?>
					</li>
				<?php } ?>
			</ul>

		<?php else : ?>

			<ul class="default-wp-page">
				<li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . esc_html_x( '&larr;', 'Previous post link', 'colormag' ) . '</span> %title' ); ?></li>
				<li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . esc_html_x( '&rarr;', 'Next post link', 'colormag' ) . '</span>' ); ?></li>
			</ul>

			<?php
		endif;
	endif;
}


/**
 * Comments section for single post that loads on scroll on single post page.
 */
function colormag_ajax_single_post_comments( $query, $comments ) {
	?>

	<div id="comments" class="comments-area">

		<?php

		if ( $query->have_comments() ) {
			$query->the_comment();
			?>

		<h3 class="comments-title">

			<?php
			$comment_count = get_comments_number();

			if ( '1' === $comment_count ) {

				printf(
					/* Translators: %1$s: Post title */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'colormag' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {

				printf(
				/* Translators: %1$s: Comment count, %2$s: Post title */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'colormag' ) ),
					number_format_i18n( $comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>

		</h3>

		<ul class="comment-list">

			<?php
			wp_list_comments(
				array(
					'callback'          => 'colormag_comment',
					'short_ping'        => true,
					'reverse_top_level' => true,
				),
				$comments
			);
			?>

		</ul><!-- .comment-list -->

			<?php

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
				?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'colormag' ); ?></p>
				<?php
			}
		}
		comment_form();
}
