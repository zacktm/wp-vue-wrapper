<?php
/**
 * Admin Menu and Plugin Page functionality
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Include menu configuration
require_once plugin_dir_path(__FILE__) . '../includes/menu-config.php';

// Add admin menu and plugin page
function vue_wp_app_admin_menu() {
    $menu_items = vue_wp_app_get_menu_config();
    $first_item = reset($menu_items);

    // Add main menu page
    add_menu_page(
        esc_html__('Vue WP App', 'wp-vue-wrapper'),           // Page title
        esc_html__('Vue WP App', 'wp-vue-wrapper'),           // Menu title
        'manage_options',       // Capability required
        VUE_APP_MENU_SLUG,     // Menu slug
        'vue_wp_app_page',     // Callback function
        'dashicons-admin-generic', // Icon
        30                     // Position
    );

    // Add submenu pages
    foreach ($menu_items as $item) {
        $slug = VUE_APP_MENU_SLUG . $item['slug'];
        
        // Skip the main page as it's already added
        if ($slug !== VUE_APP_MENU_SLUG) {
            add_submenu_page(
                VUE_APP_MENU_SLUG,    // Parent slug
                esc_html($item['title']),        // Page title
                esc_html($item['title']),        // Menu title
                'manage_options',       // Capability
                $slug,                 // Menu slug
                'vue_wp_app_page'      // Callback function
            );
        }
    }
}
add_action('admin_menu', 'vue_wp_app_admin_menu');

/**
 * Callback function to display the plugin page
 */
function vue_wp_app_page() {
    // Ensure settings script is enqueued first
    wp_enqueue_script('vue-wp-settings-js');
    
    // Then enqueue Vue app scripts
    wp_enqueue_script('vue-wp-app-js');
    wp_enqueue_style('vue-wp-app-css');
    
    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('Vue WP App', 'wp-vue-wrapper') . '</h1>';
    echo '<div id="vue-wp-app-container">';
    echo '<!-- Vue app will mount here -->';
    echo '<div id="vue-wp-app"></div>';
    echo '</div>'; // Close container
    echo '</div>'; // Close wrap
} 