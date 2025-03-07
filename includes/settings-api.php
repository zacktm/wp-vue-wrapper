<?php
/**
 * Settings API Integration
 * Handles passing WordPress settings to the Vue app
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add settings to the page for Vue app to use
 */
function vue_wp_app_localize_settings() {
    // Only add settings on admin pages or frontend with shortcode
    if (!is_admin() && !has_shortcode(get_post()->post_content ?? '', 'vue_wp_app')) {
        return;
    }
    
    // Get current settings
    $settings = array(
        'enableFrontend' => VUE_APP_ENABLE_FRONTEND,
        'enableBackend' => VUE_APP_ENABLE_BACKEND,
        'enableBackendGlobal' => VUE_APP_ENABLE_BACKEND_GLOBAL,
        'devMode' => VUE_WP_APP_DEV_MODE,
        'debugMode' => vue_wp_app_get_env('VUE_APP_DEBUG_MODE', false),
        'menuSlug' => VUE_APP_MENU_SLUG,
        'apiUrl' => rest_url('vue-wp-app/v1'),
        'nonce' => wp_create_nonce('wp_rest')
    );
    
    // Output settings as a global JavaScript variable
    ?>
    <script>
        window.vueWpSettings = <?php echo json_encode($settings); ?>;
    </script>
    <?php
}

// Add settings before the Vue app is loaded
add_action('admin_head', 'vue_wp_app_localize_settings');
add_action('wp_head', 'vue_wp_app_localize_settings');

/**
 * Register REST API endpoints for settings
 */
function vue_wp_app_register_rest_routes() {
    register_rest_route('vue-wp-app/v1', '/settings', array(
        'methods' => 'GET',
        'callback' => 'vue_wp_app_get_settings',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));
    
    register_rest_route('vue-wp-app/v1', '/settings', array(
        'methods' => 'POST',
        'callback' => 'vue_wp_app_update_settings',
        'permission_callback' => function() {
            return current_user_can('manage_options');
        }
    ));
}
add_action('rest_api_init', 'vue_wp_app_register_rest_routes');

/**
 * Get settings for REST API
 */
function vue_wp_app_get_settings() {
    $settings = array(
        'enableFrontend' => VUE_APP_ENABLE_FRONTEND,
        'enableBackend' => VUE_APP_ENABLE_BACKEND,
        'enableBackendGlobal' => VUE_APP_ENABLE_BACKEND_GLOBAL,
        'devMode' => VUE_WP_APP_DEV_MODE,
        'debugMode' => vue_wp_app_get_env('VUE_APP_DEBUG_MODE', false)
    );
    
    return rest_ensure_response($settings);
}

/**
 * Update settings via REST API
 */
function vue_wp_app_update_settings($request) {
    // This is a simplified example - in a real implementation,
    // you would update the .env file or a WordPress option
    
    $params = $request->get_params();
    
    // Validate and sanitize input
    $settings = array(
        'enableFrontend' => isset($params['enableFrontend']) ? (bool) $params['enableFrontend'] : VUE_APP_ENABLE_FRONTEND,
        'enableBackend' => isset($params['enableBackend']) ? (bool) $params['enableBackend'] : VUE_APP_ENABLE_BACKEND,
        'enableBackendGlobal' => isset($params['enableBackendGlobal']) ? (bool) $params['enableBackendGlobal'] : VUE_APP_ENABLE_BACKEND_GLOBAL,
        'devMode' => isset($params['devMode']) ? (bool) $params['devMode'] : VUE_WP_APP_DEV_MODE,
        'debugMode' => isset($params['debugMode']) ? (bool) $params['debugMode'] : vue_wp_app_get_env('VUE_APP_DEBUG_MODE', false)
    );
    
    // In a real implementation, you would save these settings
    // For now, we'll just return them
    
    return rest_ensure_response(array(
        'success' => true,
        'settings' => $settings
    ));
} 