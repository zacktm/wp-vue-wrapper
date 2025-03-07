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
        'Vue WP App',           // Page title
        'Vue WP App',           // Menu title
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
                $item['title'],        // Page title
                $item['title'],        // Menu title
                'manage_options',       // Capability
                $slug,                 // Menu slug
                'vue_wp_app_page'      // Callback function
            );
        }
    }
}
add_action('admin_menu', 'vue_wp_app_admin_menu');

// Callback function to display the plugin page
function vue_wp_app_page() {
    ?>
    <div class="wrap">
        <h1>Vue WP App</h1>
        <div id="vue-wp-app-container">
            <!-- Vue app will mount here -->
            <div id="vue-wp-app"></div>
        </div>
    </div>
    <?php
} 