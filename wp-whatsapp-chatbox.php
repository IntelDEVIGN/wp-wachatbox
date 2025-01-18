<?php
/**
 * Plugin Name:       WP WhatsApp Chatbox
 * Description:       Add a beautiful WhatsApp chat widget to your WordPress site
 * Version:          1.0.0
 * Author:           Adalberto H. Vega
 * License:          GPL-2.0+
 * License URI:      http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:      wp-whatsapp-chatbox
 * Domain Path:      /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WP_WHATSAPP_CHATBOX_VERSION', '1.0.0');
define('WP_WHATSAPP_CHATBOX_PLUGIN_NAME', 'wp-whatsapp-chatbox');

/**
 * Load the core plugin class
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-whatsapp-chatbox.php';

/**
 * Begins execution of the plugin
 */
function run_wp_whatsapp_chatbox() {
    $plugin = new WP_WhatsApp_Chatbox();
    $plugin->run();
}
run_wp_whatsapp_chatbox();
