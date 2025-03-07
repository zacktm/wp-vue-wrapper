<?php
/**
 * Menu Configuration
 * Centralized menu configuration for the plugin
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get menu configuration
 * @return array Menu configuration
 */
function vue_wp_app_get_menu_config() {
    return array(
        array(
            'title' => 'Dashboard',
            'slug' => '',  // Empty for main page
            'route' => '/',
            'icon' => 'dashicons-dashboard'
        ),
        array(
            'title' => 'Settings',
            'slug' => '-settings',
            'route' => '/settings',
            'icon' => 'dashicons-admin-settings'
        ),
        array(
            'title' => 'Tools',
            'slug' => '-tools',
            'route' => '/tools',
            'icon' => 'dashicons-admin-tools'
        )
        // Add more menu items here
    );
}

/**
 * Get all menu slugs
 * @return array Array of menu slugs
 */
function vue_wp_app_get_menu_slugs() {
    $menu_items = vue_wp_app_get_menu_config();
    $slugs = array();
    
    foreach ($menu_items as $item) {
        $slugs[] = VUE_APP_MENU_SLUG . $item['slug'];
    }
    
    return $slugs;
} 