<?php
/**
 * Admin Menu and Plugin Page functionality
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu and plugin page
function vue_wp_app_admin_menu() {
    add_menu_page(
        'Vue WP App',           // Page title
        'Vue WP App',           // Menu title
        'manage_options',       // Capability required
        'vue-wp-app',           // Menu slug
        'vue_wp_app_page',      // Function to display the page
        'dashicons-admin-generic', // Icon (you can change this)
        30                      // Position in menu
    );
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