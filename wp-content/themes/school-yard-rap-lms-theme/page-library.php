<?php
/**
 * Template Name: Full Width Page
 */

$children = array_keys(get_children(get_the_ID()));
$child = $children[0] ?? null;

if ($child) {
    wp_redirect(get_permalink($child));
    die;
} else {
    wp_redirect(home_url());
    die;
}