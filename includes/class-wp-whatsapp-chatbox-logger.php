<?php
/**
 * Logger utility for WP WhatsApp Chatbox
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/includes
 */

class WP_WhatsApp_Chatbox_Logger {

    /**
     * Log levels
     */
    const ERROR = 'error';
    const WARNING = 'warning';
    const INFO = 'info';
    const DEBUG = 'debug';

    /**
     * Log an error message
     *
     * @since    1.0.0
     * @param    string    $message    Error message
     * @param    array     $context    Additional context data
     */
    public static function error($message, $context = []) {
        self::log(self::ERROR, $message, $context);
    }

    /**
     * Log a warning message
     *
     * @since    1.0.0
     * @param    string    $message    Warning message
     * @param    array     $context    Additional context data
     */
    public static function warning($message, $context = []) {
        self::log(self::WARNING, $message, $context);
    }

    /**
     * Log an info message
     *
     * @since    1.0.0
     * @param    string    $message    Info message
     * @param    array     $context    Additional context data
     */
    public static function info($message, $context = []) {
        self::log(self::INFO, $message, $context);
    }

    /**
     * Log a debug message
     *
     * @since    1.0.0
     * @param    string    $message    Debug message
     * @param    array     $context    Additional context data
     */
    public static function debug($message, $context = []) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            self::log(self::DEBUG, $message, $context);
        }
    }

    /**
     * Log a message with specified level
     *
     * @since    1.0.0
     * @param    string    $level      Log level
     * @param    string    $message    Log message
     * @param    array     $context    Additional context data
     */
    private static function log($level, $message, $context = []) {
        // Only log if WP_DEBUG is enabled or level is error/warning
        if (!defined('WP_DEBUG') || (!WP_DEBUG && !in_array($level, [self::ERROR, self::WARNING]))) {
            return;
        }

        $timestamp = current_time('Y-m-d H:i:s');
        $log_entry = sprintf('[%s] [%s] WP WhatsApp Chatbox: %s', 
                           $timestamp, 
                           strtoupper($level), 
                           $message);

        if (!empty($context)) {
            $log_entry .= ' | Context: ' . json_encode($context);
        }

        error_log($log_entry);

        // Also add admin notice for critical errors
        if ($level === self::ERROR && is_admin()) {
            add_action('admin_notices', function() use ($message) {
                echo '<div class="notice notice-error"><p>';
                echo '<strong>WP WhatsApp Chatbox Error:</strong> ' . esc_html($message);
                echo '</p></div>';
            });
        }
    }

    /**
     * Log plugin activation/deactivation events
     *
     * @since    1.0.0
     * @param    string    $event    Event type (activation/deactivation)
     */
    public static function log_lifecycle_event($event) {
        self::info("Plugin {$event} completed", [
            'wp_version' => get_bloginfo('version'),
            'php_version' => PHP_VERSION,
            'plugin_version' => WP_WHATSAPP_CHATBOX_VERSION
        ]);
    }

    /**
     * Log settings changes
     *
     * @since    1.0.0
     * @param    array    $old_settings    Previous settings
     * @param    array    $new_settings    New settings
     */
    public static function log_settings_change($old_settings, $new_settings) {
        $changes = [];
        
        foreach ($new_settings as $key => $value) {
            if (!isset($old_settings[$key]) || $old_settings[$key] !== $value) {
                $changes[$key] = [
                    'old' => isset($old_settings[$key]) ? $old_settings[$key] : null,
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            self::info('Settings updated', ['changes' => $changes]);
        }
    }

    /**
     * Log security events
     *
     * @since    1.0.0
     * @param    string    $event      Security event type
     * @param    array     $context    Event context
     */
    public static function log_security_event($event, $context = []) {
        $context['user_id'] = get_current_user_id();
        $context['user_ip'] = self::get_user_ip();
        $context['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
        self::warning("Security event: {$event}", $context);
    }

    /**
     * Get user IP address
     *
     * @since    1.0.0
     * @return   string    User IP address
     */
    private static function get_user_ip() {
        $ip_fields = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ip_fields as $field) {
            if (!empty($_SERVER[$field])) {
                $ip = $_SERVER[$field];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
    }
}