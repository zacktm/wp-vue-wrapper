<?php
/**
 * Script and Style Enqueuing
 * Handles loading of Vue.js assets in WordPress
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles for both admin and frontend
function vue_wp_app_enqueue_scripts() {
    if(!VUE_APP_ENABLE_BACKEND_GLOBAL){
        // check if the current page is admin plugin page or not
        if(!is_admin() || !isset($_GET['page']) || $_GET['page'] != VUE_APP_MENU_SLUG){
            return;
        }
    }
    if (VUE_WP_APP_DEV_MODE) {
        // Development mode - use webpack dev server
        wp_enqueue_script(
            'vue-wp-app-js',
            'http://localhost:8080/js/app.js',
            array(),
            null,
            true
        );

        // Add CORS headers for development
        header('Access-Control-Allow-Origin: *');
        
        // Add debug message to help verify script loading
        error_log('Vue app script enqueued in dev mode');
    } else {
        // Production mode - use built files
        wp_enqueue_script(
            'vue-wp-app-js',
            VUE_WP_APP_URL . 'dist/js/app.js',
            array(),
            '1.0.0',
            false  // Changed to false to load in header
        );

        wp_enqueue_style(
            'vue-wp-app-css',
            VUE_WP_APP_URL . 'dist/css/app.css',
            array(),
            '1.0.0'
        );
    }
}

// Hook for frontend
if (VUE_APP_ENABLE_FRONTEND) {
add_action('wp_enqueue_scripts', 'vue_wp_app_enqueue_scripts');
}
if (VUE_APP_ENABLE_BACKEND) {
// Hook for admin
add_action('admin_enqueue_scripts', 'vue_wp_app_enqueue_scripts'); 
}