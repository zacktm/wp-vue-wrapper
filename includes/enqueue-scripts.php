<?php
/**
 * Script and Style Enqueuing
 * Handles loading of Vue.js assets in WordPress
 */

// Add at the top of the file
require_once plugin_dir_path(__FILE__) . 'menu-config.php';

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles for both admin and frontend
function vue_wp_app_enqueue_scripts() {
    // If backend is not globally enabled
    if(!VUE_APP_ENABLE_BACKEND_GLOBAL) {
        // Get all menu slugs
        $menu_slugs = vue_wp_app_get_menu_slugs();
        
        // Check if the current page is one of our admin pages
        $is_plugin_page = is_admin() && 
                         isset($_GET['page']) && 
                         in_array($_GET['page'], $menu_slugs);
        
        // If not admin or not one of our pages, return
        if(!$is_plugin_page) {
            return;
        }
    }

    // Ensure settings script is enqueued first
    wp_enqueue_script('vue-wp-settings-js');
    
    if (VUE_APP_DEV_MODE) {
        // Development mode - use webpack dev server
        wp_register_script(
            'vue-wp-app-js',
            'http://localhost:8080/js/app.js',
            array('vue-wp-settings-js'), // Make settings a dependency
            null,
            true
        );
        
        wp_enqueue_script('vue-wp-app-js');

        // Add debug message to help verify script loading
        if (WP_DEBUG) {
            error_log('Vue app script enqueued in dev mode');
        }
    } else {
        // Production mode - use built files
        wp_register_script(
            'vue-wp-app-js',
            VUE_WP_APP_URL . 'dist/js/app.js',
            array('vue-wp-settings-js'), // Make settings a dependency
            '1.0.0',
            true  // Load in footer
        );
        
        wp_enqueue_script('vue-wp-app-js');

        wp_register_style(
            'vue-wp-app-css',
            VUE_WP_APP_URL . 'dist/css/app.css',
            array(),
            '1.0.0'
        );
        
        wp_enqueue_style('vue-wp-app-css');
    }

    // Add this to make sure the nonce is available in the Vue app
    wp_localize_script('vue-wp-app-js', 'wpApiSettings', array(
        'root' => esc_url_raw(rest_url()),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

// Hook for frontend
if (VUE_APP_ENABLE_FRONTEND) {
    add_action('wp_enqueue_scripts', 'vue_wp_app_enqueue_scripts');
}

// Hook for admin
if (VUE_APP_ENABLE_BACKEND) {
    add_action('admin_enqueue_scripts', 'vue_wp_app_enqueue_scripts'); 
}