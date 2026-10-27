<?php

class Menu
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
        add_filter( 'wp_nav_menu_args', [$this, 'add_header_menu_walker'] );
    }

    public function add_header_menu_walker( $args ) {
        return array_merge( $args, array(
            'walker' => new CustomMenuWalker()
        ) );
    }
}

Menu::get_instance();