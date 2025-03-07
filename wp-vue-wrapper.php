<?php
/**
 * Plugin Name: wp-vue-wrapper
 * Description: A WordPress plugin that wraps a Vue.js application
 * Version: 1.0.0
 * Author: TenGate
 * Author URI: https://10g8.com
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('VUE_WP_APP_PATH', plugin_dir_path(__FILE__));
define('VUE_WP_APP_URL', plugin_dir_url(__FILE__));

// Read dev mode from .env file
$env_path = dirname(__FILE__) . '/.env';
$dev_mode = true; // Default to true if .env file is not found

if (file_exists($env_path)) {
    $env_contents = file_get_contents($env_path);
    preg_match('/VUE_WP_APP_DEV_MODE=(true|false)/i', $env_contents, $matches);
    if (isset($matches[1])) {
        $dev_mode = strtolower($matches[1]) === 'true';
    }
}

define('VUE_WP_APP_DEV_MODE', $dev_mode);

// Enqueue scripts and styles for both admin and frontend
function vue_wp_app_enqueue_scripts() {
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
add_action('wp_enqueue_scripts', 'vue_wp_app_enqueue_scripts');

// Hook for admin
add_action('admin_enqueue_scripts', 'vue_wp_app_enqueue_scripts');

// Add the Vue mounting point to admin header
function vue_wp_app_admin_header() {
    ?>
    <div id="vue-wp-app"></div>
    <script>
        // Debug the script loading
        window.vueAppMountReady = true;
        console.log('Mount point added, waiting for Vue script...');
    </script>
    <?php
}

// Move this to an earlier hook to ensure the mounting point is added before scripts
add_action('admin_notices', 'vue_wp_app_admin_header');

// Add debug and initialization code
function vue_wp_app_admin_debug() {
    ?>
    <script>
        // Check if mounting point exists
        console.log('WordPress admin loaded, checking for Vue mount point:', {
            mountExists: document.getElementById('vue-wp-app') !== null,
            url: window.location.href,
            vueReady: window.vueAppMountReady
        });

        // Add event listener for Vue script load
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.getElementById('vue-wp-app')) {
                console.error('Vue mounting point not found!');
            }
        });
    </script>
    <?php
}
add_action('admin_footer', 'vue_wp_app_admin_debug');

// Frontend shortcode remains the same
function vue_wp_app_shortcode() {
    return '<div id="vue-wp-app"></div>';
}
add_shortcode('vue_wp_app', 'vue_wp_app_shortcode'); 