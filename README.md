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

## License

This project is licensed under the GPL v2 or later.

## Credits

Developed by TenGate and as free to use under the GPL v2 or later.

