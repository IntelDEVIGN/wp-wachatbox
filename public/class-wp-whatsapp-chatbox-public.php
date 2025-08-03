<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Handles all front-end operations including:
 * - Widget rendering
 * - Asset loading
 * - Business hours visibility
 * - Shortcode registration
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/public
 */

class WP_WhatsApp_Chatbox_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    private $options;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name       The name of the plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        // Options are now handled through centralized settings class
        // No need to fetch here as we'll use WP_WhatsApp_Chatbox_Settings::get()
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/wp-whatsapp-chatbox-public.css',
            [],
            $this->version,
            'all'
        );
    }

    /**
     * Enqueues the JavaScript with localized data
     * Includes business hours, welcome message, and styling options
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wp-whatsapp-chatbox-public.js',
            ['jquery'],
            $this->version,
            true
        );

        // Use centralized settings management for better performance
        $welcome_message = WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_welcome_message', 
            __('Hello! How can we help you?', 'wp-whatsapp-chatbox'));
        
        // Sanitize welcome message
        $welcome_message = wp_kses($welcome_message, array('br' => array()));

        wp_localize_script(
            $this->plugin_name,
            'wpWhatsAppChatbox',
            array(
                'whatsappNumber' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_whatsapp_number', ''),
                'accountName' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_account_name', ''),
                'welcomeMessage' => nl2br($welcome_message),
                'primaryColor' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_primary_color', '#00a884'),
                'displayDelay' => intval(WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_display_delay', 2000)),
                'borderRadius' => intval(WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_border_radius', 15)),
                'autoShowEnabled' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_auto_display', '1') === '1',
                'pluginUrl' => plugin_dir_url(__FILE__),
                'businessHoursEnabled' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_enable_hours', '0') === '1',
                'businessHours' => WP_WhatsApp_Chatbox_Settings::get('wp_whatsapp_chatbox_business_hours', array()),
                'timezone' => wp_timezone_string()
            )
        );
    }

    /**
     * Renders the chat widget HTML
     * Includes avatar, messages, and input area
     *
     * @since  1.0.0
     * @return void
     */
    public function display_chatbox() {
        include_once 'partials/wp-whatsapp-chatbox-public-display.php';
    }

    /**
     * Renders the chat widget HTML (alias for display_chatbox)
     * Used by main plugin class and footer hook
     *
     * @since  1.0.0
     * @return void
     */
    public function render_chat_widget() {
        $this->display_chatbox();
    }

    /**
     * Register shortcodes.
     *
     * @since    1.0.0
     */
    public function register_shortcodes() {
        add_shortcode('wa_chatbox', array($this, 'display_chatbox'));
    }
}
