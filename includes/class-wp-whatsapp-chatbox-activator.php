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
        try {
            $default_options = array(
                'wp_whatsapp_chatbox_whatsapp_number' => '',
                'wp_whatsapp_chatbox_account_name' => get_bloginfo('name'),
                'wp_whatsapp_chatbox_welcome_message' => __('Hello! How can we help you?', 'wp-whatsapp-chatbox'),
                'wp_whatsapp_chatbox_auto_display' => '1',
                'wp_whatsapp_chatbox_display_delay' => 2000,
                'wp_whatsapp_chatbox_primary_color' => '#25D366',
                'wp_whatsapp_chatbox_border_radius' => '15',
                'wp_whatsapp_chatbox_avatar' => '',
                'wp_whatsapp_chatbox_avatar_border_color' => '#ffffff',
                'wp_whatsapp_chatbox_enable_hours' => '0',
                'wp_whatsapp_chatbox_business_hours' => array(),
            );

            if (get_option('wp-whatsapp-chatbox') === false) {
                $result = add_option('wp-whatsapp-chatbox', $default_options);
                if (!$result) {
                    WP_WhatsApp_Chatbox_Logger::error('Failed to create default settings during activation');
                } else {
                    WP_WhatsApp_Chatbox_Logger::log_lifecycle_event('activation');
                }
            }
        } catch (Exception $e) {
            WP_WhatsApp_Chatbox_Logger::error('Plugin activation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
