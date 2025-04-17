<?php
/**
 * Plugin Name: wp-vue-wrapper
 * Description: A WordPress plugin that wraps a Vue.js application
 * Version: 1.0.0
 * Author: TenGate
 * Author URI: https://10g8.com
 * Text Domain: wp-vue-wrapper
 * Domain Path: /languages
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('VUE_WP_APP_PATH', plugin_dir_path(__FILE__));
define('VUE_WP_APP_URL', plugin_dir_url(__FILE__));

/**
 * Plugin Settings
 * These settings are defined here instead of using a .env file
 * which is not a WordPress best practice.
 */
define('VUE_APP_ENABLE_FRONTEND', false);        // Enable Vue on the frontend
define('VUE_APP_ENABLE_BACKEND', true);          // Enable Vue in the admin area
define('VUE_APP_ENABLE_BACKEND_GLOBAL', true);   // Enable Vue globally in admin
define('VUE_APP_DEV_MODE', true);                // Development mode
define('VUE_APP_ENABLE_DEBUG', false);            // Enable debug logging
define('VUE_APP_MENU_SLUG', 'vue-wp-app');       // Main menu slug

/**
 * Load text domain for internationalization
 */
function vue_wp_app_load_textdomain() {
    load_plugin_textdomain('wp-vue-wrapper', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'vue_wp_app_load_textdomain');

// Include plugin components
require_once VUE_WP_APP_PATH . 'admin/admin-menu.php';
require_once VUE_WP_APP_PATH . 'includes/enqueue-scripts.php';
require_once VUE_WP_APP_PATH . 'includes/mount-points.php';
require_once VUE_WP_APP_PATH . 'includes/settings-api.php';
require_once VUE_WP_APP_PATH . 'includes/custom-fields.php';
