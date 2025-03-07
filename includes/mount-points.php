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
    ?>
    <div id="vue-wp-app"></div>
    <script>
        // Debug the script loading
        window.vueAppMountReady = true;
        console.log('Mount point added, waiting for Vue script...');
    </script>
    <?php
}

// By default, mount on admin notices
// Comment this out if you only want the app on the plugin settings page
if(VUE_APP_ENABLE_BACKEND_GLOBAL){
    add_action('admin_notices', 'vue_wp_app_admin_header');
}

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

// Frontend shortcode
function vue_wp_app_shortcode() {
    return '<div id="vue-wp-app"></div>';
}
if (VUE_APP_ENABLE_FRONTEND) {
add_shortcode('vue_wp_app', 'vue_wp_app_shortcode'); 
}