<?php

namespace Syr\Account\Shortcode;

class Shortcode
{
    public string $tag = '';

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_shortcode_scripts']);
    }

    public function enqueue_shortcode_scripts()
    {
        global $post;

        if (!empty($this->tag) && is_a($post, 'WP_Post') && has_shortcode($post->post_content, $this->tag)) {
            if (method_exists($this, 'enqueue_scripts')) {
                $this->enqueue_scripts();
            }
        }
    }

    public function render($atts, $content = null) {
        return '';
    }

    public function register()
    {
        add_shortcode($this->tag, [$this, 'render']);
    }
}