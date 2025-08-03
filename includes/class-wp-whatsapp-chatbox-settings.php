<?php
/**
 * Centralized settings management for WP WhatsApp Chatbox
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/includes
 */

class WP_WhatsApp_Chatbox_Settings {

    /**
     * Cached options to prevent multiple database calls
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $options    Cached plugin options
     */
    private static $options = null;

    /**
     * Default option values
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $defaults    Default option values
     */
    private static $defaults = [
        'wp_whatsapp_chatbox_whatsapp_number' => '',
        'wp_whatsapp_chatbox_account_name' => '',
        'wp_whatsapp_chatbox_welcome_message' => '',
        'wp_whatsapp_chatbox_auto_display' => '1',
        'wp_whatsapp_chatbox_display_delay' => 2000,
        'wp_whatsapp_chatbox_primary_color' => '#00a884',
        'wp_whatsapp_chatbox_border_radius' => 15,
        'wp_whatsapp_chatbox_avatar' => '',
        'wp_whatsapp_chatbox_avatar_border_color' => '#ffffff',
        'wp_whatsapp_chatbox_disable_avatar' => '0',
        'wp_whatsapp_chatbox_enable_hours' => '0',
        'wp_whatsapp_chatbox_business_hours' => []
    ];

    /**
     * Get a specific option value with caching
     *
     * @since    1.0.0
     * @param    string    $key       The option key
     * @param    mixed     $default   Default value if option doesn't exist
     * @return   mixed               The option value
     */
    public static function get($key, $default = null) {
        if (self::$options === null) {
            self::$options = get_option('wp-whatsapp-chatbox', []);
        }

        if (isset(self::$options[$key])) {
            return self::$options[$key];
        }

        if (isset(self::$defaults[$key])) {
            return self::$defaults[$key];
        }

        return $default;
    }

    /**
     * Get all options with caching
     *
     * @since    1.0.0
     * @return   array    All plugin options
     */
    public static function get_all() {
        if (self::$options === null) {
            self::$options = get_option('wp-whatsapp-chatbox', []);
        }

        return array_merge(self::$defaults, self::$options);
    }

    /**
     * Update an option value and clear cache
     *
     * @since    1.0.0
     * @param    string    $key      The option key
     * @param    mixed     $value    The option value
     * @return   bool               True if updated successfully
     */
    public static function update($key, $value) {
        $options = self::get_all();
        $options[$key] = $value;
        
        $result = update_option('wp-whatsapp-chatbox', $options);
        
        if ($result) {
            self::$options = $options; // Update cache
        }
        
        return $result;
    }

    /**
     * Update multiple options at once and clear cache
     *
     * @since    1.0.0
     * @param    array     $options   Array of key-value pairs
     * @return   bool                True if updated successfully
     */
    public static function update_multiple($options) {
        $current_options = self::get_all();
        $new_options = array_merge($current_options, $options);
        
        $result = update_option('wp-whatsapp-chatbox', $new_options);
        
        if ($result) {
            self::$options = $new_options; // Update cache
        }
        
        return $result;
    }

    /**
     * Clear the options cache
     *
     * @since    1.0.0
     */
    public static function clear_cache() {
        self::$options = null;
    }

    /**
     * Get defaults for a specific key or all defaults
     *
     * @since    1.0.0
     * @param    string    $key    Optional. Specific default key to get
     * @return   mixed            Default value(s)
     */
    public static function get_defaults($key = null) {
        if ($key === null) {
            return self::$defaults;
        }
        
        return isset(self::$defaults[$key]) ? self::$defaults[$key] : null;
    }
}