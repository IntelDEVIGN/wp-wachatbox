<?php
/**
 * The admin-specific functionality of the plugin.
 */
class WP_WhatsApp_Chatbox_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_filter('plugin_action_links_' . $this->plugin_name . '/' . $this->plugin_name . '.php', array($this, 'add_action_links'));
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/wp-whatsapp-chatbox-admin.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style('wp-color-picker');
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wp-whatsapp-chatbox-admin.js',
            array('jquery', 'wp-color-picker'),
            $this->version,
            true
        );

        wp_localize_script(
            $this->plugin_name,
            'wpWhatsAppChatbox',
            array(
                'defaultAvatar' => plugin_dir_url(dirname(__FILE__)) . 'public/images/default-avatar.png'
            )
        );

        wp_enqueue_media();
    }

    public function add_plugin_admin_menu() {
        add_options_page(
            'WP WhatsApp Chatbox Settings',
            'WP WhatsApp Chatbox',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
    }

    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', 'wp-whatsapp-chatbox') . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    public function register_settings() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate_settings'));

        add_settings_section(
            'wp_whatsapp_chatbox_general',
            __('General Settings', 'wp-whatsapp-chatbox'),
            array($this, 'render_settings_section'),
            $this->plugin_name
        );

        // Avatar Image
        add_settings_field(
            'wp_whatsapp_chatbox_avatar',
            __('Profile Avatar', 'wp-whatsapp-chatbox'),
            array($this, 'render_avatar_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Avatar Border Color
        add_settings_field(
            'wp_whatsapp_chatbox_avatar_border_color',
            __('Avatar Border Color', 'wp-whatsapp-chatbox'),
            array($this, 'render_avatar_border_color_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // WhatsApp Number
        add_settings_field(
            'wp_whatsapp_chatbox_whatsapp_number',
            __('WhatsApp Number', 'wp-whatsapp-chatbox'),
            array($this, 'render_whatsapp_number_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Account Name
        add_settings_field(
            'wp_whatsapp_chatbox_account_name',
            __('Account Name', 'wp-whatsapp-chatbox'),
            array($this, 'render_account_name_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Welcome Message
        add_settings_field(
            'wp_whatsapp_chatbox_welcome_message',
            __('Welcome Message', 'wp-whatsapp-chatbox'),
            array($this, 'render_welcome_message_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Primary Color
        add_settings_field(
            'wp_whatsapp_chatbox_primary_color',
            __('Primary Color', 'wp-whatsapp-chatbox'),
            array($this, 'render_primary_color_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Auto Display
        add_settings_field(
            'wp_whatsapp_chatbox_auto_display',
            __('Auto Display', 'wp-whatsapp-chatbox'),
            array($this, 'render_auto_display_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Display Delay
        add_settings_field(
            'wp_whatsapp_chatbox_display_delay',
            __('Display Delay (ms)', 'wp-whatsapp-chatbox'),
            array($this, 'render_display_delay_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Border Radius
        add_settings_field(
            'wp_whatsapp_chatbox_border_radius',
            __('Border Radius (px)', 'wp-whatsapp-chatbox'),
            array($this, 'render_border_radius_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_general'
        );

        // Add Business Hours section
        add_settings_section(
            'wp_whatsapp_chatbox_business_hours',
            __('Business Hours', 'wp-whatsapp-chatbox'),
            array($this, 'render_business_hours_section'),
            $this->plugin_name
        );

        // Enable Business Hours
        add_settings_field(
            'wp_whatsapp_chatbox_enable_hours',
            __('Enable Business Hours', 'wp-whatsapp-chatbox'),
            array($this, 'render_enable_hours_field'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_business_hours'
        );

        // Business Hours Settings
        add_settings_field(
            'wp_whatsapp_chatbox_business_hours_settings',
            __('Set Business Hours', 'wp-whatsapp-chatbox'),
            array($this, 'render_business_hours_fields'),
            $this->plugin_name,
            'wp_whatsapp_chatbox_business_hours'
        );
    }

    public function validate_settings($input) {
        $valid = array();

        // Validate WhatsApp Number
        $valid['wp_whatsapp_chatbox_whatsapp_number'] = sanitize_text_field($input['wp_whatsapp_chatbox_whatsapp_number']);

        // Validate Account Name
        $valid['wp_whatsapp_chatbox_account_name'] = sanitize_text_field($input['wp_whatsapp_chatbox_account_name']);

        // Validate Welcome Message
        $valid['wp_whatsapp_chatbox_welcome_message'] = sanitize_textarea_field($input['wp_whatsapp_chatbox_welcome_message']);

        // Validate Primary Color
        $valid['wp_whatsapp_chatbox_primary_color'] = sanitize_hex_color($input['wp_whatsapp_chatbox_primary_color']);

        // Validate Auto Display
        $valid['wp_whatsapp_chatbox_auto_display'] = isset($input['wp_whatsapp_chatbox_auto_display']) ? '1' : '0';

        // Validate Display Delay
        $display_delay = absint($input['wp_whatsapp_chatbox_display_delay']);
        $valid['wp_whatsapp_chatbox_display_delay'] = $display_delay > 0 ? $display_delay : 2000;

        // Validate Border Radius
        $border_radius = absint($input['wp_whatsapp_chatbox_border_radius']);
        $valid['wp_whatsapp_chatbox_border_radius'] = $border_radius >= 0 ? $border_radius : 15;

        // Validate Avatar
        $valid['wp_whatsapp_chatbox_avatar'] = sanitize_text_field($input['wp_whatsapp_chatbox_avatar']);

        // Validate Avatar Border Color
        $valid['wp_whatsapp_chatbox_avatar_border_color'] = sanitize_hex_color($input['wp_whatsapp_chatbox_avatar_border_color']);

        // Validate Enable Hours
        $valid['wp_whatsapp_chatbox_enable_hours'] = isset($input['wp_whatsapp_chatbox_enable_hours']) ? '1' : '0';

        // Validate Business Hours
        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
        $valid['wp_whatsapp_chatbox_business_hours'] = array();

        foreach ($days as $day) {
            $valid['wp_whatsapp_chatbox_business_hours'][$day] = array(
                'enabled' => isset($input['wp_whatsapp_chatbox_business_hours'][$day]['enabled']) ? '1' : '0',
                'start' => sanitize_text_field($input['wp_whatsapp_chatbox_business_hours'][$day]['start']),
                'end' => sanitize_text_field($input['wp_whatsapp_chatbox_business_hours'][$day]['end'])
            );
        }

        return $valid;
    }

    public function render_settings_section() {
        echo '<p>' . __('Configure your WhatsApp chat widget settings below.', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_avatar_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_avatar']) ? $options['wp_whatsapp_chatbox_avatar'] : '';
        $default_avatar = plugin_dir_url(dirname(__FILE__)) . 'public/images/default-avatar.png';
        $avatar_url = !empty($value) ? $value : $default_avatar;
        
        echo '<div class="avatar-field-wrapper">';
        echo '<div class="avatar-preview" style="margin-bottom: 10px;">';
        echo '<img src="' . esc_url($avatar_url) . '" alt="Profile Avatar" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">';
        echo '</div>';
        echo '<input type="hidden" id="wp_whatsapp_chatbox_avatar" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_avatar]" value="' . esc_attr($value) . '" />';
        echo '<button type="button" class="button wp-whatsapp-chatbox-upload-btn">' . __('Select Image', 'wp-whatsapp-chatbox') . '</button> ';
        echo '<button type="button" class="button wp-whatsapp-chatbox-remove-btn">' . __('Remove Image', 'wp-whatsapp-chatbox') . '</button>';
        echo '<p class="description">' . __('Recommended size: 100x100 pixels. The image will be displayed as a circle.', 'wp-whatsapp-chatbox') . '</p>';
        echo '</div>';
    }

    public function render_avatar_border_color_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_avatar_border_color']) ? $options['wp_whatsapp_chatbox_avatar_border_color'] : '#ffffff';
        echo '<input type="text" class="color-picker" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_avatar_border_color]" value="' . esc_attr($value) . '" />';
        echo '<p class="description">' . __('Select the border color for the avatar image', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_whatsapp_number_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_whatsapp_number']) ? $options['wp_whatsapp_chatbox_whatsapp_number'] : '';
        echo '<input type="text" class="regular-text" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_whatsapp_number]" value="' . esc_attr($value) . '" />';
        echo '<p class="description">' . __('Enter your WhatsApp number with country code (e.g., 14155552671)', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_account_name_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_account_name']) ? $options['wp_whatsapp_chatbox_account_name'] : '';
        echo '<input type="text" class="regular-text" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_account_name]" value="' . esc_attr($value) . '" />';
    }

    public function render_welcome_message_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_welcome_message']) ? $options['wp_whatsapp_chatbox_welcome_message'] : '';
        echo '<textarea class="large-text" rows="3" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_welcome_message]">' . esc_textarea($value) . '</textarea>';
    }

    public function render_primary_color_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_primary_color']) ? $options['wp_whatsapp_chatbox_primary_color'] : '#00a884';
        echo '<input type="text" class="color-picker" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_primary_color]" value="' . esc_attr($value) . '" />';
    }

    public function render_auto_display_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_auto_display']) ? $options['wp_whatsapp_chatbox_auto_display'] : '0';
        echo '<input type="checkbox" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_auto_display]" value="1" ' . checked('1', $value, false) . ' />';
        echo '<p class="description">' . __('Automatically display the chat widget after page load', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_display_delay_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_display_delay']) ? $options['wp_whatsapp_chatbox_display_delay'] : 2000;
        echo '<input type="number" class="small-text" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_display_delay]" value="' . esc_attr($value) . '" min="0" step="100" />';
        echo '<p class="description">' . __('Delay in milliseconds before displaying the chat widget', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_border_radius_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_border_radius']) ? $options['wp_whatsapp_chatbox_border_radius'] : 15;
        echo '<input type="number" class="small-text" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_border_radius]" value="' . esc_attr($value) . '" min="0" max="50" />';
        echo '<p class="description">' . __('Border radius in pixels for the chat widget', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_business_hours_section() {
        echo '<p>' . __('Configure when the WhatsApp chat widget should be visible based on your business hours.', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_enable_hours_field() {
        $options = get_option($this->plugin_name);
        $value = isset($options['wp_whatsapp_chatbox_enable_hours']) ? $options['wp_whatsapp_chatbox_enable_hours'] : '0';
        
        echo '<input type="checkbox" name="' . $this->plugin_name . '[wp_whatsapp_chatbox_enable_hours]" value="1" ' . checked('1', $value, false) . ' />';
        echo '<p class="description">' . __('Enable time-based visibility for the chat widget', 'wp-whatsapp-chatbox') . '</p>';
    }

    public function render_business_hours_fields() {
        $options = get_option($this->plugin_name);
        $business_hours = isset($options['wp_whatsapp_chatbox_business_hours']) ? $options['wp_whatsapp_chatbox_business_hours'] : array();
        $days = array(
            'monday' => __('Monday', 'wp-whatsapp-chatbox'),
            'tuesday' => __('Tuesday', 'wp-whatsapp-chatbox'),
            'wednesday' => __('Wednesday', 'wp-whatsapp-chatbox'),
            'thursday' => __('Thursday', 'wp-whatsapp-chatbox'),
            'friday' => __('Friday', 'wp-whatsapp-chatbox'),
            'saturday' => __('Saturday', 'wp-whatsapp-chatbox'),
            'sunday' => __('Sunday', 'wp-whatsapp-chatbox')
        );

        echo '<div class="business-hours-container">';
        foreach ($days as $day_key => $day_label) {
            $day_settings = isset($business_hours[$day_key]) ? $business_hours[$day_key] : array();
            $enabled = isset($day_settings['enabled']) ? $day_settings['enabled'] : '0';
            $start = isset($day_settings['start']) ? $day_settings['start'] : '09:00';
            $end = isset($day_settings['end']) ? $day_settings['end'] : '17:00';

            echo '<div class="business-hours-day">';
            echo '<label class="day-label">' . $day_label . '</label>';
            echo '<input type="checkbox" 
                         name="' . $this->plugin_name . '[wp_whatsapp_chatbox_business_hours][' . $day_key . '][enabled]" 
                         value="1" ' . checked('1', $enabled, false) . ' 
                         class="day-enabled" />';
            echo '<input type="time" 
                         name="' . $this->plugin_name . '[wp_whatsapp_chatbox_business_hours][' . $day_key . '][start]" 
                         value="' . esc_attr($start) . '" 
                         class="time-input" />';
            echo '<span class="time-separator">to</span>';
            echo '<input type="time" 
                         name="' . $this->plugin_name . '[wp_whatsapp_chatbox_business_hours][' . $day_key . '][end]" 
                         value="' . esc_attr($end) . '" 
                         class="time-input" />';
            echo '</div>';
        }
        echo '</div>';
    }

    public function display_plugin_setup_page() {
        include_once 'partials/wp-whatsapp-chatbox-admin-display.php';
    }
}
