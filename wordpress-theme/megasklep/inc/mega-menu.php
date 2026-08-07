<?php
/**
 * Custom mega-menu Walker for WooCommerce categories.
 */
defined('ABSPATH') || exit;

class Megasklep_Walker_Nav_Menu extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="ms-nav__dropdown">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes   = empty($item->classes) ? [] : (array) $item->classes;
        $has_child = in_array('menu-item-has-children', $classes);
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);

        $li_class = 'ms-nav__item';
        if ($has_child)  $li_class .= ' has-dropdown';
        if ($is_active)  $li_class .= ' is-active';

        $output .= '<li class="' . esc_attr($li_class) . '">';

        $url    = $item->url ?: '#';
        $title  = apply_filters('the_title', $item->title, $item->ID);
        $target = $item->target ? ' target="' . esc_attr($item->target) . '"' : '';
        $noopener = ($item->target === '_blank') ? ' rel="noopener noreferrer"' : '';

        $output .= '<a href="' . esc_url($url) . '"' . $target . $noopener . ' class="ms-nav__link">';
        $output .= esc_html($title);
        if ($has_child) {
            $output .= ' <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>';
        }
        $output .= '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}
