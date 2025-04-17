<?php
/**
 * Custom Fields Manager for WP Vue Wrapper
 * 
 * Handles registration, storage, and retrieval of custom fields
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

class vue_wp_app_Custom_Fields {
    
    private static $instance = null;
    private $option_name = '';
    private $fields = array();
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // Set option name using the defined menu slug
        $this->option_name = VUE_APP_MENU_SLUG . '_custom_fields';
        
        // Define fields
        $this->fields = array(
            array('name' => 'email', 'type' => 'string', 'default' => 'dummyEmail@gmail.com'),
            array('name' => 'sites', 'type' => 'string', 'default' => 10),
            array('name' => 'api_key', 'type' => 'string', 'default' => 'dummyApiKey'),
            array('name' => 'is_guest', 'type' => 'boolean', 'default' => true),
            array('name' => 'license', 'type' => 'string', 'default' => 'dummyLicense')
        );
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Register REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting(
            VUE_APP_MENU_SLUG . '_options',
            $this->option_name,
            array(
                'type' => 'array',
                'description' => 'Custom fields for ' . esc_html(VUE_APP_MENU_SLUG),
                'sanitize_callback' => array($this, 'sanitize_custom_fields'),
                'default' => $this->get_default_fields(),
            )
        );
    }
    
    /**
     * Get default fields
     */
    public function get_default_fields() {
        $defaults = array();
        foreach ($this->fields as $field) {
            $defaults[$field['name']] = $field['default'];
        }
        return $defaults;
    }
    
    /**
     * Sanitize custom fields
     */
    public function sanitize_custom_fields($fields) {
        if (!is_array($fields)) {
            return $this->get_default_fields();
        }
        
        $sanitized = array();
        
        // Sanitize each field based on type
        foreach ($this->fields as $field) {
            $key = $field['name'];
            if (isset($fields[$key])) {
                switch ($field['type']) {
                    case 'boolean':
                        $sanitized[$key] = (bool) $fields[$key];
                        break;
                    case 'integer':
                        $sanitized[$key] = (int) $fields[$key];
                        break;
                    case 'string':
                        $sanitized[$key] = sanitize_text_field($fields[$key]);
                        break;
                    default:
                        $sanitized[$key] = $fields[$key];
                }
            } else {
                $sanitized[$key] = $field['default'];
            }
        }
        
        return $sanitized;
    }
    
    /**
     * Get all custom fields
     */
    public function get_fields() {
        $fields = get_option($this->option_name);
        $needs_update = false;
        
        // Initialize with defaults if not an array
        if (!$fields || !is_array($fields)) {
            $fields = $this->get_default_fields();
            $needs_update = true;
        } else {
            // Check for missing fields and add them with default values
            foreach ($this->fields as $field_def) {
                $field_name = $field_def['name'];
                if (!array_key_exists($field_name, $fields)) {
                    $fields[$field_name] = $field_def['default'];
                    $needs_update = true;
                }
            }
        }
        
        // Update the database if we added any fields
        if ($needs_update) {
            update_option($this->option_name, $fields);
        }
        
        return $fields;
    }
    
    /**
     * Get a specific field
     */
    public function get_field($key, $default = '') {
        $fields = $this->get_fields();
        return isset($fields[$key]) ? $fields[$key] : $default;
    }
    
    /**
     * Update multiple fields
     */
    public function update_fields($new_fields) {
        $fields = $this->get_fields();
        foreach ($new_fields as $key => $value) {
            if (array_key_exists($key, $fields)) {
                $fields[$key] = $value;
            }
        }
        update_option($this->option_name, $fields);
        return true;
    }
    
    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route(VUE_APP_MENU_SLUG.'/v1', '/custom-fields', array(
            array(
                'methods' => 'GET',
                'callback' => array($this, 'api_get_fields'),
                'permission_callback' => array($this, 'api_permissions_check'),
            ),
            array(
                'methods' => 'POST',
                'callback' => array($this, 'api_update_fields'),
                'permission_callback' => array($this, 'api_permissions_check'),
            ),
        ));
    }
    
    /**
     * API permissions check
     */
    public function api_permissions_check() {
        return current_user_can('manage_options');
    }
    
    /**
     * API callback for getting fields
     */
    public function api_get_fields() {
        return rest_ensure_response($this->get_fields());
    }
    
    /**
     * API callback for updating fields
     */
    public function api_update_fields($request) {
        $fields = $request->get_json_params();
        if (!is_array($fields)) {
            return new WP_Error(
                'invalid_fields', 
                esc_html__('Fields must be provided as an object', 'wp-vue-wrapper'), 
                array('status' => 400)
            );
        }
        
        $this->update_fields($fields);
        return rest_ensure_response($this->get_fields());
    }
}

// Initialize the class
vue_wp_app_Custom_Fields::get_instance();

// Helper function to get custom fields
function vue_wp_app_get_custom_field($key, $default = '') {
    return vue_wp_app_Custom_Fields::get_instance()->get_field($key, $default);
} 