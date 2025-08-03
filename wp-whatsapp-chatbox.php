<?php
/**
 * Plugin Name:       WP WhatsApp Chatbox
 * Plugin URI:        https://github.com/ahvega/wp-wachatbox
 * Description:       Add a beautiful WhatsApp chat widget to your WordPress site with business hours management and extensive customization options.
 * Version:           1.1.0
 * Author:            Adalberto H. Vega
 * Author URI:        https://github.com/ahvega
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-whatsapp-chatbox
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Tested up to:      6.4
 * Requires PHP:      7.4
 * Network:           false
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WP_WHATSAPP_CHATBOX_VERSION', '1.1.0');
define('WP_WHATSAPP_CHATBOX_PLUGIN_NAME', 'wp-whatsapp-chatbox');

/**
 * Check minimum WordPress and PHP versions
 */
function wp_whatsapp_chatbox_check_requirements() {
    if (version_compare(get_bloginfo('version'), '5.0', '<')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>' . 
                 __('WP WhatsApp Chatbox requires WordPress 5.0 or higher.', 'wp-whatsapp-chatbox') . 
                 '</p></div>';
        });
        return false;
    }
    
    if (version_compare(PHP_VERSION, '7.4', '<')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>' . 
                 __('WP WhatsApp Chatbox requires PHP 7.4 or higher.', 'wp-whatsapp-chatbox') . 
                 '</p></div>';
        });
        return false;
    }
    
    return true;
}

/**
 * Plugin activation hook
 */
function activate_wp_whatsapp_chatbox() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-whatsapp-chatbox-activator.php';
    WP_WhatsApp_Chatbox_Activator::activate();
}

/**
 * Plugin deactivation hook
 */
function deactivate_wp_whatsapp_chatbox() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-whatsapp-chatbox-deactivator.php';
    WP_WhatsApp_Chatbox_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_whatsapp_chatbox');
register_deactivation_hook(__FILE__, 'deactivate_wp_whatsapp_chatbox');

/**
 * Load the core plugin class
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-whatsapp-chatbox.php';

/**
 * Begins execution of the plugin
 */
function run_wp_whatsapp_chatbox() {
    // Check requirements before initializing
    if (!wp_whatsapp_chatbox_check_requirements()) {
        return;
    }
    
    $plugin = new WP_WhatsApp_Chatbox();
    $plugin->run();
}
run_wp_whatsapp_chatbox();
