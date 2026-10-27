<?php

class CustomMenuWalker extends Walker_Nav_Menu
{
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $args   = (object) $args;

        $class_names = '';
        $value       = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $submenu = $args->has_children ? ' fl-has-submenu' : '';

        // Get custom menu icon.
        $menu_icon = get_field('menu_icon', $item);

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = ' class="' . esc_attr( $class_names ) . $submenu . '"';

        $item_id = apply_filters( 'fl_builder_menu_item_id', 'menu-item-' . $item->ID, $item, $depth );
        $output .= $indent . '<li id="' . $item_id . '"' . $value . $class_names . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $item_output  = $args->has_children ? '<div class="fl-has-submenu-container">' : '';
        $item_output .= $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $menu_icon ? wp_get_attachment_image($menu_icon, ['64', '64']) : '';
        $item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
        $item_output .= '</a>';

        if ( $args->has_children ) {
            $item_output .= '<span class="fl-menu-toggle"></span>';
        }

        $item_output .= $args->after;
        $item_output .= $args->has_children ? '</div>' : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset( $args->menu_logo_image_src ) && 0 == (int) $item->menu_item_parent ) {
            $this->walk_counter++;

            $total_menu_items = $args->total_top_lvl_items;
            $logo_position    = ceil( $total_menu_items / 2 );

            if ( 'left' == $args->menu_logo_odd_position && 0 != $total_menu_items % 2 ) {
                $logo_position = $logo_position - 1;
            }

            if ( $this->walk_counter == $logo_position ) {
                $alt     = $args->menu_logo_image_alt ? "alt='$args->menu_logo_image_alt' " : '';
                $output .= "</li><li class='fl-menu-logo'><a href='$args->menu_logo_link' itemprop='url'>";
                $output .= "<img data-no-lazy='1' class='fl-logo-img' src='$args->menu_logo_image_src' $alt/>";
                $output .= '</a></li>';
            } else {
                $output .= '</li>';
            }
        } else {
            $output .= '</li>';
        }
    }

    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}