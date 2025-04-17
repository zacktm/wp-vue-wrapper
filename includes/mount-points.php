<?php
/**
 * Vue App Mount Points
 * Controls where the Vue app is mounted in the WordPress admin
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Add the Vue mounting point to admin header (default location)
function vue_wp_app_admin_header() {
    echo '<div id="vue-wp-app"></div>';
    
    // Add an inline script to indicate mount point is ready
    wp_register_script('vue-wp-app-mount-js', false);
    wp_enqueue_script('vue-wp-app-mount-js');
    wp_add_inline_script('vue-wp-app-mount-js', '
        window.vueAppMountReady = true;
        console.log("Mount point added, waiting for Vue script...");
    ');
}

// By default, mount on admin notices
// Comment this out if you only want the app on the plugin settings page
if(VUE_APP_ENABLE_BACKEND_GLOBAL){
    add_action('admin_notices', 'vue_wp_app_admin_header');
}

// Add debug and initialization code
function vue_wp_app_admin_debug() {
    // Register and enqueue a script for debugging
    wp_register_script('vue-wp-app-debug-js', false);
    wp_enqueue_script('vue-wp-app-debug-js');
    wp_add_inline_script('vue-wp-app-debug-js', '
        // Check if mounting point exists
        console.log("WordPress admin loaded, checking for Vue mount point:", {
            mountExists: document.getElementById("vue-wp-app") !== null,
            url: window.location.href,
            vueReady: window.vueAppMountReady
        });

        // Add event listener for Vue script load
        document.addEventListener("DOMContentLoaded", function() {
            if (!document.getElementById("vue-wp-app")) {
                console.error("Vue mounting point not found!");
            }
        });
    ');
}

if(VUE_APP_ENABLE_DEBUG){
    add_action('admin_footer', 'vue_wp_app_admin_debug');
}

// Frontend shortcode
function vue_wp_app_shortcode() {
    // Ensure settings script is enqueued first
    wp_enqueue_script('vue-wp-settings-js');
    
    // Then enqueue Vue app scripts
    wp_enqueue_script('vue-wp-app-js');
    wp_enqueue_style('vue-wp-app-css');
    
    return '<div id="vue-wp-app"></div>';
}

if (VUE_APP_ENABLE_FRONTEND) {
    add_shortcode('vue_wp_app', 'vue_wp_app_shortcode');
}