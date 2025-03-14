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

// Include environment loader
require_once VUE_WP_APP_PATH . 'includes/env-loader.php';

// Set development mode from .env
define('VUE_APP_DEV_MODE', vue_wp_app_get_env('VUE_APP_DEV_MODE', true));
define('VUE_APP_ENABLE_FRONTEND', vue_wp_app_get_env('VUE_APP_ENABLE_FRONTEND', true));
define('VUE_APP_ENABLE_BACKEND', vue_wp_app_get_env('VUE_APP_ENABLE_BACKEND', true));
define('VUE_APP_ENABLE_BACKEND_GLOBAL', vue_wp_app_get_env('VUE_APP_ENABLE_BACKEND_GLOBAL', false));
define('VUE_APP_MENU_SLUG', vue_wp_app_get_env('VUE_APP_MENU_SLUG', 'vue-wp-app'));
define('VUE_APP_ENABLE_DEBUG', vue_wp_app_get_env('VUE_APP_ENABLE_DEBUG', true));
// Include plugin components
require_once VUE_WP_APP_PATH . 'admin/admin-menu.php';
require_once VUE_WP_APP_PATH . 'includes/enqueue-scripts.php';
require_once VUE_WP_APP_PATH . 'includes/mount-points.php';
require_once VUE_WP_APP_PATH . 'includes/settings-api.php'; 
require_once VUE_WP_APP_PATH . 'includes/custom-fields.php'; 
