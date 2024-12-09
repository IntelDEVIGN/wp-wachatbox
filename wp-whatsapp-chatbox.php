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
 * The core plugin class
 */
class WP_WhatsApp_Chatbox {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->version = WP_WHATSAPP_CHATBOX_VERSION;
        $this->plugin_name = WP_WHATSAPP_CHATBOX_PLUGIN_NAME;

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-wp-whatsapp-chatbox-loader.php';
        require_once plugin_dir_path(__FILE__) . 'admin/class-wp-whatsapp-chatbox-admin.php';
        require_once plugin_dir_path(__FILE__) . 'public/class-wp-whatsapp-chatbox-public.php';

        $this->loader = new WP_WhatsApp_Chatbox_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new WP_WhatsApp_Chatbox_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    private function define_public_hooks() {
        $plugin_public = new WP_WhatsApp_Chatbox_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('wp_footer', $plugin_public, 'display_chatbox');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}

/**
 * Begins execution of the plugin
 */
function run_wp_whatsapp_chatbox() {
    $plugin = new WP_WhatsApp_Chatbox();
    $plugin->run();
}
run_wp_whatsapp_chatbox();
