<?php
/*
 * Plugin Name:       Auth Block & Shortcode
 * Plugin URI:        https://thenorth.tech/wp-plugins/auth-block-shortcode/
 * Description:       A plugin for adding blocks to a theme.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Requires PHP:      8.1
 * Author:            The North Tech
 * Author URI:        https://thenorth.tech/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       auth-block-shortcode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Check if the 'add_action' function exists
if (!function_exists('add_action')) {
    // If 'add_action' doesn't exist, it's likely that the file has been accessed outside of WordPress, because 'add_action' is a core WordPress function.
    // Display a message to the person trying to access the file directly
    echo 'Seems like you stumbled here by accident.';

    exit;
}


// Setup Section

// Define 'ABS_PLUGIN_DIR' to store the absolute path to the plugin directory. 
// 'plugin_dir_path' is a WordPress function that returns the filesystem directory path for the current file.
define('ABS_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Define 'ABS_PLUGIN_FILE' to store the full path to the main plugin file. 
// '__FILE__' is a PHP magic constant that contains the full path and filename of the current (i.e., this) PHP file.
define('ABS_PLUGIN_FILE', __FILE__);

// Includes Section

// Use the PHP glob function to collect all PHP files from the 'includes' directory at the root level.
// This will not include files in subdirectories.
$rootFiles = glob(ABS_PLUGIN_DIR . 'includes/*.php');

// Use the PHP glob function to collect all PHP files from all subdirectories under the 'includes' directory.
// '**' is a glob pattern that matches any number of directories and subdirectories.
$subdirectoryFiles = glob(ABS_PLUGIN_DIR . 'includes/**/*.php');

// Merge the arrays containing file paths from the root 'includes' directory and its subdirectories into a single array.
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

// Iterate through the array of file paths.
foreach ($allFiles as $filename) {
    // Include each file only once to avoid function redeclaration or other duplicate errors.
    // 'include_once' ensures that the file is included just once. If the code from the file was already included, it will not be included again.
    include_once($filename);
}


// Bootstrap CDN styles
function bootstrap_plugin_scripts()
{
    // Enqueue Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css', // Handle
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css', // Source
        array(), // Dependencies
        '5.3.0', // Version
        'all' // Media
    );

    // Enqueue Bootstrap Bundle JS (includes Popper)
    wp_enqueue_script(
        'bootstrap-js', // Handle
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', // Source
        array('jquery'), // Dependencies
        '5.3.0', // Version
        true // In Footer
    );

    // Enqueue Bootstrap Icons CSS
    wp_enqueue_style(
        'bootstrap-icons', // Handle
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css', // Source
        array(), // Dependencies
        '1.10.3', // Version
        'all' // Media
    );
}
// adds bootstrap to admin backend
add_action('admin_enqueue_scripts', 'bootstrap_plugin_scripts');
// adds bootstrap to front-end
add_action('wp_enqueue_scripts', 'bootstrap_plugin_scripts');

//disable admin bar
function auth_block_shortcode_disable_admin_bar_for_specific_roles() {
    if (!current_user_can('administrator')) { // Adjust per your needs
        add_filter('show_admin_bar', '__return_false');
    }
}
add_action('after_setup_theme', 'auth_block_shortcode_disable_admin_bar_for_specific_roles');

// Hooks
add_action('init', 'abs_register_blocks');
add_action('rest_api_init', 'abs_rest_api_init');
add_action('wp_enqueue_scripts', 'abs_enqueue_scripts');
