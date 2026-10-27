<?php

class syrRecordsArchive extends FLBuilderModule
{
    public int $posts_per_page = 20;

    public function __construct()
    {
        parent::__construct(
            [
                'name' => __('SYR Records Archive'),
                'description' => __('Module to display all records.'),
                'category' => __('Records'),
                'group' => 'SYR Modules',
                'dir' => SYR_MODULES_DIR . 'modules/records-archive/',
                'url' => SYR_MODULES_URL . 'modules/records-archive/',
                'icon' => 'schedule.svg',
            ]
        );
    }

    /**
     * @method get_data
     */
    public function get_args()
    {
        return [
            'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
            'post_type' => ['mpcs-lesson'],
            'posts_per_page' => $this->posts_per_page,
        ];
    }

    /**
     * Function that renders pagination.
     *
     * @method render_pagination
     * @param WP_Query $query gets an array of query.
     */
    public function render_pagination($query)
    {
        // Get current page number.
        $permalink_structure = get_option('permalink_structure');
        $base = untrailingslashit(wp_specialchars_decode(get_pagenum_link()));
        $paged = FLBuilderLoop::get_paged();

        // Get total number of posts from query.
        $total_posts = $query->found_posts;

        $base = FLBuilderLoop::build_base_url($permalink_structure, $base);
        $format = FLBuilderLoop::paged_format($permalink_structure, $base);

        $max = $query->found_posts;

        $max = ($total_posts <= $max) ? $total_posts : $max;

        $posts_per_page = $this->posts_per_page;
        $total_pages = ceil($max / $posts_per_page);


        // Return pagination html.
        if ($total_pages > 1) {

            $current_page = $paged;
            if (!$current_page) {
                $current_page = 1;
            }

            return paginate_links(
                [
                    'base' => $base . '%_%',
                    'format' => $format,
                    'current' => $current_page,
                    'total' => $total_pages,
                    'type' => 'list',
                ]
            );
        }

        return false;
    }

    public function get_previous_link()
    {
        global $paged;

        if (!is_single()) {
            $previous_page = (int)$paged - 1;

            if ($previous_page < 1) {
                return false;
            }

            return esc_url(get_pagenum_link($previous_page));
        }

        return false;
    }

    public function get_next_link($wp_query)
    {
        global $paged;

        $max_page = $wp_query->max_num_pages;

        if ( ! $paged ) {
            $paged = 1;
        }

        $next_page = $paged + 1;

        if ( ! is_single() && ( $next_page <= $max_page ) ) {
            return next_posts( $max_page, false );
        }

        return false;
    }
}

FLBuilder::register_module('syrRecordsArchive', []);
