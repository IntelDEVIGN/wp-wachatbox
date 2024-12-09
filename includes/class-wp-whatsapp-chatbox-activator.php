<?php
/**
 * Fired during plugin activation.
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/includes
 */

class WP_WhatsApp_Chatbox_Activator {

    /**
     * Initialize plugin default settings on activation.
     *
     * @since    1.0.0
     */
    public static function activate() {
        $default_options = array(
            'whatsapp_number' => '',
            'account_name' => get_bloginfo('name'),
            'welcome_message' => '¡Hola!, ¿Cómo le podemos ayudar?',
            'auto_display' => true,
            'display_delay' => 2000,
            'primary_color' => '#25D366',
            'font_family' => 'inherit',
            'border_radius' => '15',
            'box_shadow' => '0 2px 15px rgba(0,0,0,0.1)',
        );

        foreach ($default_options as $key => $value) {
            if (get_option('wp_whatsapp_chatbox_' . $key) === false) {
                add_option('wp_whatsapp_chatbox_' . $key, $value);
            }
        }
    }
}
