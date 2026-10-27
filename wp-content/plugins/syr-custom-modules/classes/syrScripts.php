<?php

class syrScripts
{
    /**
     * Load the class instance.
     *
     * @var static Instance.
     */
    private static $instance = null;

    /**
     * Set the plugin instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('wp_register_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        wp_register_style( 'cloudinary-video-player', 'https://cdnjs.cloudflare.com/ajax/libs/cloudinary-video-player/2.1.0/cld-video-player.min.css' );
        wp_register_script( 'cloudinary-video-player', 'https://cdnjs.cloudflare.com/ajax/libs/cloudinary-video-player/2.1.0/cld-video-player.min.js' );
    }
}
