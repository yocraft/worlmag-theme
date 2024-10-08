<?php
/**
 * Top bar hooks.
 *
 * @package ColorMag
 *
 * TODO: @since
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================= Hooks > Header Top ==========================================*/

		$top_bar_enable                 = get_theme_mod( 'colormag_enable_top_bar', 0 );
		$breaking_news_enable           = get_theme_mod( 'colormag_enable_news_ticker', 0 );
		$breaking_news_position         = get_theme_mod( 'colormag_news_ticker_position', 'top-bar' );
		$date_display_enable            = get_theme_mod( 'colormag_date_display', 0 );
		$social_links_enable            = get_theme_mod( 'colormag_enable_social_icons', 0 );
		$social_links_header_visibility = get_theme_mod( 'colormag_enable_social_icons_header', 1 );
		$social_links_header_location   = get_theme_mod( 'colormag_social_icons_header_location', 'top-bar' );
		$top_bar_menu_enable            = get_theme_mod( 'colormag_top_bar_menu_enable', 0 );
		$random_post_icon               = get_theme_mod( 'colormag_enable_random_post', 0 );
		$search_icon                    = get_theme_mod( 'colormag_enable_search', 0 );
		$social_links_enable            = get_theme_mod( 'colormag_enable_social_icons', true );
		$social_links_header_visibility = get_theme_mod( 'colormag_enable_social_icons_header', 1 );
		$social_links_header_location   = get_theme_mod( 'colormag_social_icons_header_location', 'top-bar' );

		?>
<?php if ( 'layout-3' == get_theme_mod( 'colormag_main_header_layout', 'layout-1' ) ): ?>
	<div id="cm-header-2" class="cm-header-2">
		<nav id="cm-primary-nav" class="cm-primary-nav"<?php echo colormag_schema_markup( 'nav' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>>
			<div class="cm-container">
				<div class="cm-row">
					<?php
					if ( 'home-icon' === get_theme_mod( 'colormag_menu_icon_logo', 'none' ) ) {
						$home_icon_class = 'cm-home-icon';

						if ( is_front_page() ) {
							$home_icon_class = 'cm-home-icon front_page_on';
						}
						?>

						<div class="<?php echo esc_attr( $home_icon_class ); ?>">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
							>

								<?php colormag_get_icon( 'home' ); ?>

							</a>
						</div>
					<?php } ?>

					<?php
					if ( 'logo' === get_theme_mod( 'colormag_menu_icon_logo', 'none' ) ) {
						colormag_menu_logo();
					}

					if ( 1 == $random_post_icon || 1 == $search_icon || ( 1 == $social_links_enable && 1 == $social_links_header_visibility && 'menu' === $social_links_header_location ) ) {
						?>
						<div class="cm-header-actions">
							<?php
							// Displays the social links in header.
							if ( 1 == $social_links_header_visibility && 'menu' === $social_links_header_location ) {
								colormag_social_links();
							}

							// Displays the random post.
							if ( 1 == $random_post_icon ) {
								colormag_random_post();
							}

							// Displays the search icon.
							if ( 1 == $search_icon ) {
								?>
								<div class="cm-top-search">
									<i class="fa fa-search search-top"></i>
									<div class="search-form-top">
										<?php get_search_form(); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>

					<p class="cm-menu-toggle" aria-expanded="false">
						<?php colormag_get_icon( 'bars' ); ?>
						<?php colormag_get_icon( 'x-mark' ); ?>
					</p>
					<?php
						get_template_part( 'template-parts/header/primary-menu/main-navigation' );
					?>

				</div>
			</div>
		</nav>
	</div>
<?php
endif;
if (
			( 1 == $top_bar_enable ) && (
				( 1 == $date_display_enable ) ||
				( 1 == $breaking_news_enable && 'top-bar' === $breaking_news_position ) ||
				( 1 == $social_links_enable && 1 == $social_links_header_visibility && 'top-bar' === $social_links_header_location ) ||
				( 1 == $top_bar_menu_enable ) || 1 )
		) :
	if ( 1 == $top_bar_enable ) {
		?>
				<div class="cm-top-bar">
					<div class="cm-container <?php echo colormag_top_bar_full_width_area_class(); ?>">
						<div class="cm-row">
							<div class="cm-top-bar__1">
				<?php
				// Date.
				if ( 1 == $date_display_enable ) {
					colormag_date_display();
				}

				// Breaking news.
				if ( 1 == $breaking_news_enable && 'top-bar' === $breaking_news_position ) {
					colormag_breaking_news();
				}
				?>
							</div>

							<div class="cm-top-bar__2">
				<?php
				// Menu.
				if ( 1 == $top_bar_menu_enable ) {
					?>
									<nav class="top-bar-menu">
						<?php
						if ( has_nav_menu( 'top-bar' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'top-bar',
									'depth'          => - 1,
								)
							);
						}
						?>
									</nav>
					<?php
				}

				// Social icons.
				if ( 1 == $social_links_header_visibility && 'top-bar' === $social_links_header_location ) {
					colormag_social_links();
				}
				?>
							</div>
						</div>
					</div>
				</div>

				<?php

	}
			endif;
