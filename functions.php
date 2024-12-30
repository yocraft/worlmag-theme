<?php

/**
 * ColorMag functions related to adding files.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ColorMag
 *
 * @since   ColorMag 1.0.0
 */
// Exit if accessed directly.
defined('ABSPATH') || exit;
/**
 * Define constants.
 */
require get_template_directory() . '/inc/base/class-colormag-constants.php';
/**
 * Calling in the admin area for the Welcome Page as well as for the new theme notice too.
 */
if (is_admin()) {
    require get_template_directory() . '/inc/admin/class-colormag-admin.php';
    require get_template_directory() . '/inc/admin/class-colormag-dashboard.php';
    require get_template_directory() . '/inc/admin/class-colormag-welcome-notice.php';
}
/**
 * Base.
 */
// Generate WordPress filter hook dynamically.
require COLORMAG_INCLUDES_DIR . '/base/class-colormag-dynamic-filter.php';
// Generate dynamic CSS from styling options.
require_once COLORMAG_INCLUDES_DIR . '/base/class-colormag-dynamic-css.php';
// Adds classes to appropriate places.
require_once COLORMAG_INCLUDES_DIR . '/base/class-colormag-dynamic-classes.php';
// Adds classes to appropriate places.
require COLORMAG_INCLUDES_DIR . '/base/class-colormag-css-classes.php';
/**
 * Core.
 */
// ColorMag setup file, hooked for `after_setup_theme`.
require COLORMAG_INCLUDES_DIR . '/core/class-colormag-after-setup-theme.php';
// Load scripts.
require_once COLORMAG_INCLUDES_DIR . '/core/class-colormag-enqueue-scripts.php';
// Header Media.
require_once COLORMAG_INCLUDES_DIR . '/core/custom-header.php';
/**
 * Customizer.
 */
require_once COLORMAG_CUSTOMIZER_DIR . '/class-colormag-customizer.php';
/**
 * Deprecated.
 */
// Load deprecated functions.
require_once COLORMAG_INCLUDES_DIR . '/deprecated/deprecated-filters.php';
require_once COLORMAG_INCLUDES_DIR . '/deprecated/deprecated-functions.php';
require_once COLORMAG_INCLUDES_DIR . '/deprecated/deprecated-hooks.php';
/**
 * Helper.
 */
// Load utils & helper functions.
require_once COLORMAG_INCLUDES_DIR . '/helper/class-colormag-utils.php';
/**
 * Meta Boxes.
 */
// Meta boxes function and classes.
require_once COLORMAG_INCLUDES_DIR . '/meta-boxes/class-colormag-meta-boxes.php';
require_once COLORMAG_INCLUDES_DIR . '/meta-boxes/class-colormag-meta-box-page-settings.php';
/**
 * Migration
 */
// Migrating customize options.
require COLORMAG_INCLUDES_DIR . '/migration/class-colormag-options-migrate.php';
// Load demo import migration scripts.
require_once COLORMAG_INCLUDES_DIR . '/migration/demo-import-migration.php';
// Load migration scripts.
require_once COLORMAG_INCLUDES_DIR . '/migration/class-colormag-migration.php';
/**
 * Widgets
 */
// Load Widgets and Widgetized Area.
require_once COLORMAG_WIDGETS_DIR . '/class-colormag-widgets.php';
/**
 * Templates.
 */
// Template functions files.
require COLORMAG_INCLUDES_DIR . '/template-tags.php';
require COLORMAG_INCLUDES_DIR . '/template-functions.php';
// Svg icon class.
require COLORMAG_INCLUDES_DIR . '/class-colormag-svg-icons.php';
//Template hooks.
require COLORMAG_PARENT_DIR . '/template-parts/hooks/hook-functions.php';
require COLORMAG_PARENT_DIR . '/template-parts/hooks/header/header.php';
require COLORMAG_PARENT_DIR . '/template-parts/hooks/header/header-main.php';
require COLORMAG_PARENT_DIR . '/template-parts/hooks/header/top-bar.php';
require COLORMAG_PARENT_DIR . '/template-parts/hooks/content/content.php';
require COLORMAG_PARENT_DIR . '/template-parts/hooks/footer/footer.php';
/** Schema markup file include. */
require_once COLORMAG_INCLUDES_DIR . '/schema-markup.php';
/** WP_Query functions files. */
require COLORMAG_INCLUDES_DIR . '/colormag-wp-query.php';
/** Breadcrumb class. */
require_once COLORMAG_INCLUDES_DIR . '/class-breadcrumb-trail.php';
/** Load functions */
require_once COLORMAG_INCLUDES_DIR . '/ajax.php';
/** Add the JetPack plugin support */
if (defined('JETPACK__VERSION')) {
    require_once COLORMAG_INCLUDES_DIR . '/compatibility/jetpack/jetpack.php';
}
/** Add the WooCommerce plugin support */
if (class_exists('WooCommerce')) {
    require_once COLORMAG_INCLUDES_DIR . '/compatibility/woocommerce/woocommerce.php';
}
/** Add the Elementor compatibility file */
if (defined('ELEMENTOR_VERSION')) {
    require_once COLORMAG_ELEMENTOR_DIR . '/elementor.php';
    require_once COLORMAG_ELEMENTOR_DIR . '/elementor-functions.php';
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since ColorMag 3.0.0
 */
function cm_customize_preview_js()
{
    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min');
    wp_enqueue_script(
        'colormag-customizer-pre',
        get_assets_url() . '/inc/customizer/assets/js/cm-customize-preview.js',
        array('customize-preview'),
        COLORMAG_THEME_VERSION,
        true
    );
}

function get_assets_url()
{
    // Get correct URL and path to wp-content.
    $content_url = untrailingslashit(dirname(dirname(get_stylesheet_directory_uri())));
    $content_dir = wp_normalize_path(untrailingslashit(WP_CONTENT_DIR));
    $url = str_replace($content_dir, $content_url, wp_normalize_path(__DIR__));
    $url = set_url_scheme($url);
    return $url;
}

add_action('customize_preview_init', 'cm_customize_preview_js');
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function colormag_set_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('colormag_set_content_width', 800);
}

add_action('after_setup_theme', 'colormag_set_content_width', 0);
/**
 * $content_width global variable adjustment as per layout option.
 */
function colormag_content_width()
{
    global $post;
    global $content_width;
    if ($post) {
        $layout_meta = get_post_meta($post->ID, 'colormag_page_layout', true);
    }
    if (is_home()) {
        $queried_id = get_option('page_for_posts');
        $layout_meta = get_post_meta($queried_id, 'colormag_page_layout', true);
    }
    if (empty($layout_meta) || is_archive() || is_search()) {
        $layout_meta = 'default_layout';
    }
    $colormag_default_sidebar_layout = get_theme_mod('colormag_default_sidebar_layout', 'right_sidebar');
    $colormag_page_sidebar_layout = get_theme_mod('colormag_page_sidebar_layout', 'right_sidebar');
    $colormag_default_post_layout = get_theme_mod('colormag_post_sidebar_layout', 'right_sidebar');
    if ('default_layout' === $layout_meta) {
        if (is_page()) {
            if ('no_sidebar_full_width' === $colormag_page_sidebar_layout) {
                $content_width = 1140;
                /* pixels */
            }
        } elseif (is_single()) {
            if ('no_sidebar_full_width' === $colormag_default_post_layout) {
                $content_width = 1140;
                /* pixels */
            }
        } else {
            if ('no_sidebar_full_width' === $colormag_default_sidebar_layout) {
                $content_width = 1140;
                /* pixels */
            }
        }
    } else {
        if ('no_sidebar_full_width' === $layout_meta) {
            $content_width = 1140;
            /* pixels */
        }
    }
}

// Register Custom Post Type for News
function create_news_post_type()
{

    $labels = array(
        'name'                  => _x('News', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('News', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('News', 'text_domain'),
        'name_admin_bar'        => __('News', 'text_domain'),
        'archives'              => __('News Archives', 'text_domain'),
        'attributes'            => __('News Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent News:', 'text_domain'),
        'all_items'             => __('All News', 'text_domain'),
        'add_new_item'          => __('Add New News', 'text_domain'),
        'add_new'               => __('Add News', 'text_domain'),
        'new_item'              => __('New News', 'text_domain'),
        'edit_item'             => __('Edit News', 'text_domain'),
        'update_item'           => __('Update News', 'text_domain'),
        'view_item'             => __('View News', 'text_domain'),
        'view_items'            => __('View All News', 'text_domain'),
        'search_items'          => __('Search News', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into news', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this news', 'text_domain'),
        'items_list'            => __('News list', 'text_domain'),
        'items_list_navigation' => __('News list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter news list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('News', 'text_domain'),
        'description'           => __('News and Updates', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-media-document', // Choose a relevant icon from the WordPress Dashicons library
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // Enables archive page for the news post type
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable block editor support (Gutenberg)
    );
    register_post_type('news', $args);
}
add_action('init', 'create_news_post_type', 0);


// Register Custom Post Type for Music 
function create_music_post_type()
{

    $labels = array(
        'name'                  => _x('Music', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Music', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Music', 'text_domain'),
        'name_admin_bar'        => __('Music', 'text_domain'),
        'archives'              => __('Music Archives', 'text_domain'),
        'attributes'            => __('Music Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Music:', 'text_domain'),
        'all_items'             => __('All Music', 'text_domain'),
        'add_new_item'          => __('Add New Music', 'text_domain'),
        'add_new'               => __('Add Music', 'text_domain'),
        'new_item'              => __('New Music', 'text_domain'),
        'edit_item'             => __('Edit Music', 'text_domain'),
        'update_item'           => __('Update Music', 'text_domain'),
        'view_item'             => __('View Music', 'text_domain'),
        'view_items'            => __('View All Music', 'text_domain'),
        'search_items'          => __('Search Music', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into music', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this music', 'text_domain'),
        'items_list'            => __('Music list', 'text_domain'),
        'items_list_navigation' => __('Music list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter music list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Music', 'text_domain'),
        'description'           => __('Music and Updates', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-playlist-audio', // Choose a relevant icon from the WordPress Dashicons library
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // Enables archive page for the news post type
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable block editor support (Gutenberg)
    );
    register_post_type('music', $args);
}
add_action('init', 'create_music_post_type', 0);

// Register Custom Post Type for Music 
function create_videos_post_type()
{

    $labels = array(
        'name'                  => _x('Videos', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Video', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Videos', 'text_domain'),
        'name_admin_bar'        => __('Videos', 'text_domain'),
        'archives'              => __('Videos Archives', 'text_domain'),
        'attributes'            => __('Videos Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Videos:', 'text_domain'),
        'all_items'             => __('All Videos', 'text_domain'),
        'add_new_item'          => __('Add New Video', 'text_domain'),
        'add_new'               => __('Add Video', 'text_domain'),
        'new_item'              => __('New Video', 'text_domain'),
        'edit_item'             => __('Edit Video', 'text_domain'),
        'update_item'           => __('Update Video', 'text_domain'),
        'view_item'             => __('View Video', 'text_domain'),
        'view_items'            => __('View All Videos', 'text_domain'),
        'search_items'          => __('Search Videos', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into Video', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this music', 'text_domain'),
        'items_list'            => __('Videos list', 'text_domain'),
        'items_list_navigation' => __('Videos list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter videos list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Videos', 'text_domain'),
        'description'           => __('Videos and Updates', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-video', // Choose a relevant icon from the WordPress Dashicons library
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true, // Enables archive page for the news post type
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable block editor support (Gutenberg)
    );
    register_post_type('videos', $args);
}
add_action('init', 'create_videos_post_type', 0);



add_action('template_redirect', 'colormag_content_width');
/**
 * Detect plugin. For use on Front End only.
 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';
#--------------------------------------------------------------------------------
#region Freemius
#--------------------------------------------------------------------------------
class FS_ThemeGrill
{
    /**
     * Instance.
     *
     * @var Freemius
     */
    private static $fs;

    /**
     * Self instance.
     *
     * @return Freemius
     */
    public static function freemius()
    {
        return self::$fs;
    }

    /**
     * Constructor.
     *
     * FS_ThemeGrill constructor.
     */
    private function __construct() {}

    /**
     * Init freemius.
     *
     * @param string $id         The id of the product.
     * @param string $slug       The slug of the product.
     * @param string $public_key The public key of the product.
     * @param string $name       The product name.
     *
     * @return \Freemius
     * @throws \Freemius_Exception Thrown when an API call returns an exception.
     */
    public static function init(
        $id,
        $slug,
        $public_key,
        $name = ''
    ) {
        if (!isset(self::$fs)) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';
            self::$fs = fs_dynamic_init(array(
                'id'              => $id,
                'slug'            => $slug,
                'premium_slug'    => "{$slug}-pro",
                'type'            => 'theme',
                'public_key'      => $public_key,
                'is_premium'      => true,
                'is_premium_only' => true,
                'premium_suffix'  => 'Pro',
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'menu'            => array(
                    'slug'    => 'themegrill_submenu',
                    'support' => false,
                    'parent'  => array(
                        'slug' => 'options-general.php',
                    ),
                ),
                'is_live'         => true,
            ));
            // Signal that SDK was initiated.
            do_action("{$slug}_fs_loaded");
            require_once dirname(__FILE__) . '/inc/freemius-migration.php';
            if (empty($name)) {
                $name = ucwords(str_replace('-', ' ', $slug));
            }
            new FS_ThemeGrill_License_Menu($name, $slug);
            new FS_ThemeGrill_License_Migration(self::$fs, "api_manager_theme_{$slug}", $slug);
        }
        return self::$fs;
    }
}

FS_ThemeGrill::init(
    '4212',
    'colormag',
    'pk_414d89e1f7eda2dd7de41050ab418',
    'ColorMag'
);

function enqueue_theme_styles()
{
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/custom.css');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

function include_custom_posts_in_category_archive($query)
{
    // Check if we're on a category archive page and it's the main query
    if ($query->is_category() && $query->is_main_query() && !is_admin()) {
        // Include the 'music' custom post type in the query
        $query->set('post_type', array('post', 'music', 'news', 'videos'));
    }
}
add_action('pre_get_posts', 'include_custom_posts_in_category_archive');

function custom_remove_menus()
{
    // Get current user's role
    if (current_user_can('editor')) {
        // Remove for Editor role
        remove_menu_page('index.php');
        remove_menu_page('edit.php?post_type=page');
        remove_menu_page('tools.php');           // Tools
        remove_menu_page('options-general.php');
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php'); // Settings
        remove_menu_page('upload.php');
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('profile.php');
        remove_menu_page('edit.php?post_type=elementor_library');
        remove_menu_page('qsm_dashboard');
        remove_menu_page('wpcf7');
        remove_menu_page('wpseo_workouts');
        remove_menu_page('admin.php?page=sib_page_home');
        remove_menu_page('sib_page_home');
        remove_menu_page('edit.php?post_type=product');
    }
    if (current_user_can('subscriber')) {
        // Remove for Subscriber role
        remove_menu_page('edit.php');            // Posts
        remove_menu_page('upload.php');          // Media
        remove_menu_page('edit-comments.php');   // Comments
    }
}
add_action('admin_menu', 'custom_remove_menus', 9999);



add_filter('walker_nav_menu_start_el', function ($item_output, $item, $depth, $args) {
    // Allow iframes in menu items
    return $item_output;
}, 10, 4);

#endregion
