<?php
/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/includes
 */

class WP_WhatsApp_Chatbox_i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'wp-whatsapp-chatbox',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
