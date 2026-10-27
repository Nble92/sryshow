<?php

class syrMP
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

    public static function render_custom_fields($field_keys)
    {
        add_filter('mepr_render_custom_fields', function ($custom_fields) use ($field_keys) {
            return array_filter($custom_fields, function ($custom_field) use ($field_keys) {
                return in_array($custom_field->field_key, $field_keys);
            });
        });

        MeprUsersHelper::render_custom_fields(null, 'account');

        remove_all_filters('mepr_render_custom_fields');
    }
}

syrMP::get_instance();