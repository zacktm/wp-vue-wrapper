<?php
/**
 * Environment Variable Loader
 * Provides a simple way to read variables from .env file
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load environment variables from .env file
 * 
 * @return array Array of environment variables
 */
function vue_wp_app_load_env() {
    static $env_vars = null;
    
    // Only load once
    if ($env_vars !== null) {
        return $env_vars;
    }
    
    $env_vars = array();
    $env_path = VUE_WP_APP_PATH . '.env';
    
    if (file_exists($env_path)) {
        $env_content = file_get_contents($env_path);
        $lines = preg_split('/\r\n|\r|\n/', $env_content);
        
        foreach ($lines as $line) {
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            
            // Parse variable assignments
            if (preg_match('/^\s*([\w\.]+)\s*=\s*(.*)?\s*$/', $line, $matches)) {
                $name = $matches[1];
                $value = $matches[2] ?? '';
                
                // Remove quotes if present
                if (preg_match('/^([\'"])(.*)\1$/', $value, $quote_matches)) {
                    $value = $quote_matches[2];
                }
                
                // Convert boolean strings to actual booleans
                if (strtolower($value) === 'true') {
                    $value = true;
                } elseif (strtolower($value) === 'false') {
                    $value = false;
                }
                
                $env_vars[$name] = $value;
            }
        }
    }
    
    return $env_vars;
}

/**
 * Get a specific environment variable
 * 
 * @param string $key Variable name
 * @param mixed $default Default value if variable is not found
 * @return mixed Variable value or default
 */
function vue_wp_app_get_env($key, $default = null) {
    $env_vars = vue_wp_app_load_env();
    return isset($env_vars[$key]) ? $env_vars[$key] : $default;
} 