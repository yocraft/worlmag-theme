<?php

/**
 * The template used for displaying single post content in single-music.php
 *
 * @package ColorMag
 *
 * @since   ColorMag 1.0.0
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

$image_popup_id  = get_post_thumbnail_id();
$image_popup_url = wp_get_attachment_url($image_popup_id);
$featured_img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php echo colormag_schema_markup('entry'); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped 
																														?>>
	<?php
	/**
	 * Hook: colormag_before_post_content.
	 */
	do_action('colormag_before_post_content');

	/**
	 * Hook: colormag_before_single_post_page_loop.
	 */
	do_action('colormag_before_single_post_page_loop');
	?>

	<?php if ('position-1' === get_theme_mod('colormag_featured_image_position', 'position-2')) : ?>
		<div class="single-title-above">
			<?php colormag_colored_category(); ?>

			<header class="cm-entry-header">
				<h1 class="cm-entry-title" <?php echo colormag_schema_markup('entry_title'); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped 
																		?>>
					<?php the_title(); ?>
				</h1>
			</header>

			<?php colormag_entry_meta(); ?>
		</div>
	<?php endif; ?>

	<?php
	if (! has_post_format(array('gallery', 'video'))) :

		if (true == get_theme_mod('colormag_enable_featured_image', true) && has_post_thumbnail()) :
	?>
			<?php if (1 == get_theme_mod('colormag_enable_featured_image_caption', 0) && get_post(get_post_thumbnail_id())->post_excerpt) : ?>
				<span class="featured-image-caption">
					<?php echo wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt); ?>
				</span>
			<?php
			endif;
			?>
		<?php
		endif;
	endif;

	if (has_post_format('video')) :
		$video_post_url = get_post_meta($post->ID, 'video_url', true);

		if (! empty($video_post_url)) :
		?>
			<div class="fitvids-video">
				<?php
				$embed_code = wp_oembed_get($video_post_url);

				echo $embed_code;
				?>
			</div>
	<?php
		endif;
	endif;
	?>

	<div class="cm-post-content">
		<!-- </?php
		if (get_post_format() && ! has_post_format('video')) :
			get_template_part('template-parts/content/post-formats');
		endif;

		if ('position-2' === get_theme_mod('colormag_featured_image_position', 'position-2')) :
			colormag_colored_category();
		?>

			</?php get_template_part('template-parts/entry/entry', 'header'); ?>

		</?php
			colormag_entry_meta();
		endif;
		?> -->
		<header class="cm-entry-header">
			<h1 class="cm-entry-title" <?php echo colormag_schema_markup('entry_title'); ?>>
				<?php the_title(); ?>
			</h1>
		</header>
		<?php if (get_field('album_info')): ?>
			<p><?php echo wp_kses_post(get_field('album_info')); ?></p>
		<?php endif; ?>
		<?php if (get_field('tracklist')): ?>
			<div class="album-wrapper">
				<div class="cover-art" style="background-image: url('<?php echo $featured_img_url ?>')"></div>
				<div class="tracklist">
					<h4>Tracklist</h4>
					<?php echo wp_kses_post(get_field('tracklist')); ?>
					<?php if (get_field('stream_link')): ?>
						<h5>Stream and Download</h5>
						<div class="links">
							<a href"><button>Stream</button></a>
							<?php if (get_field('stream_link')): ?>
								<a href""><button>Download</button></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		<?php endif; ?>



	</div>

	<?php colormag_post_view_setup(get_the_ID()); ?>

	<?php
	/**
	 * Hook: colormag_after_single_post_page_loop.
	 */
	do_action('colormag_after_single_post_page_loop');

	/**
	 * Hook: colormag_after_post_content.
	 */
	do_action('colormag_after_post_content');
	?>
</article>