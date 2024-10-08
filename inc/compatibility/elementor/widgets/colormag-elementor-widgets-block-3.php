<?php
/**
 * ColorMag Elementor Widget Block 3.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 2.2.3
 */

namespace elementor\widgets;

use elementor\widgets\Colormag_Elementor_Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ColorMag Elementor Widget Block 3.
 *
 * Class ColorMag_Elementor_Widgets_Block_3
 */
class ColorMag_Elementor_Widgets_Block_3 extends Colormag_Elementor_Widget_Base
{

    /**
     * Post number.
     *
     * @var int
     */
    public $post_number = 3;

    /**
     * Retrieve ColorMag_Elementor_Widgets_Block_3 widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'ColorMag-Posts-Block-3';
    }

    /**
     * Retrieve ColorMag_Elementor_Widgets_Block_3 widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Block Style 3', 'colormag');
    }

    /**
     * Retrieve ColorMag_Elementor_Widgets_Block_3 widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'colormag-econs-block-3';
    }

    /**
     * Retrieve the list of categories the ColorMag_Elementor_Widgets_Block_3 widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return array('colormag-widget-blocks');
    }

    /**
     * Extra controls for post filter options.
     */
    public function posts_filter_controls_extra()
    {

        $this->add_control(
            'posts_video_display',
            array(
                'label' => esc_html__('Display featured image/video:', 'colormag'),
                'type' => Controls_Manager::SELECT,
                'default' => 'featured_image',
                'options' => array(
                    'featured_image' => esc_html__('Featured Image', 'colormag'),
                    'video' => esc_html__('Video', 'colormag'),
                ),
            )
        );

    }

    /**
     * Render ColorMag_Elementor_Widgets_Block_3 widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render()
    {

        $widget_title = $this->get_settings('widget_title');
        $posts_number = $this->get_settings('posts_number');
        $display_type = $this->get_settings('display_type');
        $offset_posts_number = $this->get_settings('offset_posts_number');
        $posts_sort_orderby = $this->get_settings('posts_sort_orderby');
        $posts_sort_order = $this->get_settings('posts_sort_order');
        $categories_selected = $this->get_settings('categories_selected');
        $tags_selected = $this->get_settings('tags_selected');
        $authors_selected = $this->get_settings('authors_selected');
        $posts_video_display = $this->get_settings('posts_video_display');
        $show_pagination = $this->get_settings('show_pagination');
        $widget_title_link = $this->get_settings('widget_title_link');
        $widget_title_link_url = $widget_title_link['url'];
        $widget_title_link_target = $widget_title_link['is_external'] ? 'target="_blank"' : '';

        // Create the posts query.
        $get_featured_posts = $this->query_posts($posts_number, $display_type, $categories_selected, $tags_selected, $authors_selected, $posts_sort_orderby, $posts_sort_order, $offset_posts_number, $show_pagination);

        if (empty($offset_posts_number)) {
            colormag_append_excluded_duplicate_posts($get_featured_posts);
        }
        ?>

        <div class="tg-module-block tg-module-block--style-3 tg-module-wrapper tg-fade-in">
            <?php
            // Displays the widget title.
            $this->widget_title($widget_title, $widget_title_link_url, $widget_title_link_target);
            ?>

            <div class="tg-row">
                <?php
                while ($get_featured_posts->have_posts()) :
                    $get_featured_posts->the_post();
                    ?>

                    <div class="tg-col-control">
                        <div class="tg_module_block">
                            <?php
                            // Check for post meta for Video Post Type.
                            $video_post_url = get_post_meta(get_the_ID(), 'video_url', true);

                            if (has_post_thumbnail() && ('featured_image' == $posts_video_display)) :
                                ?>
                                <figure class="tg-module-thumb">
                                    <?php
                                    $this->the_post_thumbnail('colormag-highlighted-post');

                                    colormag_elementor_colored_category();
                                    ?>
                                </figure>
                            <?php
                            elseif ('video' == $posts_video_display) :
                                if (!empty($video_post_url)) :
                                    ?>
                                    <div class="fitvids-video">
                                        <?php
                                        $embed_code = wp_oembed_get($video_post_url);

                                        echo $embed_code; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                        ?>
                                    </div>
                                <?php
                                endif; // Video check endif.
                            else :
                                colormag_elementor_colored_category();
                            endif;
                            ?>

                            <?php
                            // Display the post title.
                            $this->the_title();

                            // Displays the entry meta.
                            colormag_elementor_widgets_meta();
                            ?>
                        </div>
                    </div>

                <?php
                endwhile;

                // Display the pagination link if enabled.
                $this->paginate_links($show_pagination, $get_featured_posts->max_num_pages);

                // Reset the postdata.
                wp_reset_postdata();
                ?>
            </div>
        </div>

        <?php
    }

}
