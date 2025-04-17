# WordPress Vue.js Wrapper

A WordPress plugin that seamlessly integrates Vue.js applications into WordPress sites.

## Description

This plugin allows you to embed Vue.js applications within WordPress pages and posts using a simple shortcode. It handles all the necessary script loading and provides a clean integration between WordPress and Vue.js.

## Features

- Simple shortcode integration
- Automatic script and style loading
- Environment variable support
- Customizable container element
- WordPress hooks for extending functionality

## Installation

1. Upload the plugin files to the `/wp-content/plugins/wp-vue-wrapper` directory, or install the plugin through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the shortcode `[vue-wp-app]` in your posts or pages to embed the Vue application.

## Usage

### Basic Usage

Simply add the shortcode to any post or page: 

### Advanced Usage

You can customize the container element and pass additional attributes: 
[vue-app id="custom-app-id" class="custom-class"]

## Configuration

The plugin uses environment variables for configuration. Create a `.env` file in the plugin root directory with your settings:

## CLI Tool

The plugin includes a command-line tool for easy customization of the plugin name and prefixes. This tool allows you to quickly rename the plugin and update all function names, constants, and text domains to match your branding.

### Usage

From the plugin directory, run:

```bash
./wpvue init "Your Plugin Name"
```

For example:

```bash
./wpvue init "Customer Portal"
```

### What the CLI Tool Does

The tool will:

1. Generate appropriate prefixes based on your plugin name:
   - Function prefix (e.g., `customer_portal_`)
   - Text domain (e.g., `customer_portal`)
   - Constants prefix (e.g., `CUSTOMER_PORTAL_`)
   - App constants prefix (e.g., `CUSTOMER_PORTAL_APP_`)

2. Replace all occurrences of the default prefixes:
   - Default function prefix: `vue_wp_app_`
   - Default text domain: `wp-vue-wrapper`
   - Default constants prefix: `VUE_WP_APP_`
   - Default app constants prefix: `VUE_APP_`

3. Rename the main plugin file to match your new prefix

### Confirmation

Before making any changes, the tool will display a summary of all replacements and ask for confirmation. This gives you a chance to review the changes before they are applied.

## Development

### Prerequisites

- Node.js and npm
- WordPress development environment

### Setup

1. Clone this repository to your WordPress plugins directory
2. Run `npm install` to install dependencies
3. Run `npm run dev` for development mode with hot-reload
4. Run `npm run build` to build for production

### File Structure

- `wp-vue-wrapper.php` - Main plugin file with WordPress integration
- `src/` - Vue.js application source files
- `dist/` - Compiled Vue.js application (generated after build)
- `.env` - Environment configuration

## Hooks

The plugin provides several WordPress filters and actions for extending functionality:

- `wp_vue_wrapper_shortcode_atts` - Filter shortcode attributes
- `wp_vue_wrapper_container` - Filter the container HTML


## Credits

Developed by TenGate and as free to use under the GPL v2 or later.

