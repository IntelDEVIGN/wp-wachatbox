<?php
/**
 * The public-facing functionality of the plugin.
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
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wp-whatsapp-chatbox-public.js',
            array('jquery'),
            $this->version,
            true
        );

        // Get plugin options
        $options = get_option($this->plugin_name);

        // Prepare welcome message - preserve newlines
        $welcome_message = isset($options['wp_whatsapp_chatbox_welcome_message']) ? 
            wp_kses($options['wp_whatsapp_chatbox_welcome_message'], array('br' => array())) : 
            __('¡Hola!, ¿Cómo le podemos ayudar?', 'wp-whatsapp-chatbox');
        
        wp_localize_script(
            $this->plugin_name,
            'wpWhatsAppChatbox',
            array(
                'whatsappNumber' => isset($options['wp_whatsapp_chatbox_whatsapp_number']) ? $options['wp_whatsapp_chatbox_whatsapp_number'] : '',
                'accountName' => isset($options['wp_whatsapp_chatbox_account_name']) ? $options['wp_whatsapp_chatbox_account_name'] : '',
                'welcomeMessage' => nl2br($welcome_message), // Convert newlines to <br> tags
                'primaryColor' => isset($options['wp_whatsapp_chatbox_primary_color']) ? $options['wp_whatsapp_chatbox_primary_color'] : '#00a884',
                'displayDelay' => isset($options['wp_whatsapp_chatbox_display_delay']) ? intval($options['wp_whatsapp_chatbox_display_delay']) : 2000,
                'borderRadius' => isset($options['wp_whatsapp_chatbox_border_radius']) ? intval($options['wp_whatsapp_chatbox_border_radius']) : 15,
                'autoShowEnabled' => isset($options['wp_whatsapp_chatbox_auto_display']) && $options['wp_whatsapp_chatbox_auto_display'] === '1',
                'pluginUrl' => plugin_dir_url(__FILE__),
                'businessHoursEnabled' => isset($options['wp_whatsapp_chatbox_enable_hours']) ? 
                                        $options['wp_whatsapp_chatbox_enable_hours'] === '1' : false,
                'businessHours' => isset($options['wp_whatsapp_chatbox_business_hours']) ? 
                                 $options['wp_whatsapp_chatbox_business_hours'] : array(),
                'timezone' => wp_timezone_string()
            )
        );
    }

    /**
     * Render the chat widget.
     *
     * @since    1.0.0
     */
    public function display_chatbox() {
        include_once 'partials/wp-whatsapp-chatbox-public-display.php';
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
