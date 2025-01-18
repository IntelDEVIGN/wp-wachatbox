<?php
/**
 * Public-facing view template
 *
 * @since      1.0.0
 * @package    WP_WhatsApp_Chatbox
 * @subpackage WP_WhatsApp_Chatbox/public/partials
 */
?>

<div id="wp-whatsapp-chatbox" class="wp-whatsapp-chatbox" aria-label="<?php esc_attr_e('WhatsApp Chat Widget', 'wp-whatsapp-chatbox'); ?>">
    <!-- Floating Action Button -->
    <button class="wp-whatsapp-chatbox-button" aria-label="<?php esc_attr_e('Open WhatsApp Chat', 'wp-whatsapp-chatbox'); ?>">
        <svg class="wp-whatsapp-icon" viewBox="0 0 1000 1000" width="60" height="60">
            <path class="cls-1" d="M733.9,267.2c-62-62.1-144.6-96.3-232.5-96.4-181.1,0-328.6,147.4-328.6,328.6,0,57.9,15.1,114.5,43.9,164.3l-46.6,170.3,174.2-45.7c48,26.2,102,40,157,40h.1c181.1,0,328.5-147.4,328.6-328.6.1-87.8-34-170.4-96.1-232.5ZM501.5,772.8h-.1c-49,0-97.1-13.2-139-38.1l-10-5.9-103.4,27.1,27.6-100.8-6.5-10.3c-27.3-43.5-41.8-93.7-41.8-145.4.1-150.6,122.6-273.1,273.3-273.1,73,0,141.5,28.5,193.1,80.1s80,120.3,79.9,193.2c0,150.7-122.6,273.2-273.1,273.2ZM651.3,568.2c-8.2-4.1-48.6-24-56.1-26.7s-13-4.1-18.5,4.1c-5.5,8.2-21.2,26.7-26,32.2s-9.6,6.2-17.8,2.1c-8.2-4.1-34.7-12.8-66-40.8-24.4-21.8-40.9-48.7-45.7-56.9-4.8-8.2-.5-12.7,3.6-16.8,3.7-3.7,8.2-9.6,12.3-14.4,4.1-4.8,5.5-8.2,8.2-13.7s1.4-10.3-.7-14.4-18.5-44.5-25.3-61c-6.7-16-13.4-13.8-18.5-14.1-4.8-.2-10.3-.3-15.7-.3s-14.4,2.1-21.9,10.3c-7.5,8.2-28.7,28.1-28.7,68.5s29.4,79.5,33.5,84.9c4.1,5.5,57.9,88.4,140.3,124,19.6,8.5,34.9,13.5,46.8,17.3,19.7,6.3,37.6,5.4,51.7,3.3,15.8-2.4,48.6-19.9,55.4-39,6.8-19.2,6.8-35.6,4.8-39-2-3.4-7.5-5.4-15.7-9.6Z"/>
        </svg>
    </button>

    <!-- Chat Box -->
    <div class="wp-whatsapp-chatbox-popup" aria-hidden="true">
        <!-- Header -->
        <?php
        $options = get_option('wp-whatsapp-chatbox');
        $avatar_url = isset($options['wp_whatsapp_chatbox_avatar']) && !empty($options['wp_whatsapp_chatbox_avatar']) 
            ? $options['wp_whatsapp_chatbox_avatar'] 
            : plugins_url('images/default-avatar.png', dirname(__FILE__));
        $account_name = isset($options['wp_whatsapp_chatbox_account_name']) 
            ? $options['wp_whatsapp_chatbox_account_name'] 
            : get_bloginfo('name');
        $avatar_border_color = isset($options['wp_whatsapp_chatbox_avatar_border_color']) 
            ? $options['wp_whatsapp_chatbox_avatar_border_color'] 
            : '#ffffff';
        ?>
        <div class="wp-whatsapp-chatbox-header" style="--wp-whatsapp-avatar-border-color: <?php echo esc_attr($avatar_border_color); ?>">
            <div class="wp-whatsapp-chatbox-avatar">
                <img src="<?php echo esc_url($avatar_url); ?>" 
                     alt="<?php echo esc_attr($account_name); ?>"
                     width="45" height="45">
            </div>
            <div class="wp-whatsapp-chatbox-header-info">
                <h3 class="wp-whatsapp-chatbox-title">
                    <?php echo esc_html($account_name); ?>
                </h3>
                <p class="wp-whatsapp-chatbox-status">
                    <?php esc_html_e('Online', 'wp-whatsapp-chatbox'); ?>
                </p>
            </div>
            <button class="wp-whatsapp-chatbox-close" aria-label="<?php esc_attr_e('Close chat', 'wp-whatsapp-chatbox'); ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Messages -->
        <div class="wp-whatsapp-chatbox-messages">
            <div class="wp-whatsapp-chatbox-message received">
                <div class="wp-whatsapp-chatbox-message-content">
                    <div class="wp-whatsapp-chatbox-welcome-message">
                        <?php 
                        $options = get_option($this->plugin_name);
                        $welcome_message = isset($options['wp_whatsapp_chatbox_welcome_message']) ? 
                            nl2br(esc_html($options['wp_whatsapp_chatbox_welcome_message'])) : 
                            __('¡Hola!, ¿Cómo le podemos ayudar?', 'wp-whatsapp-chatbox');
                        echo $welcome_message;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="wp-whatsapp-chatbox-footer">
            <form class="wp-whatsapp-chatbox-input-form" action="#" method="post">
                <input type="text" 
                       class="wp-whatsapp-chatbox-input" 
                       placeholder="<?php esc_attr_e('Type a message...', 'wp-whatsapp-chatbox'); ?>"
                       aria-label="<?php esc_attr_e('Type a message', 'wp-whatsapp-chatbox'); ?>">
                <button type="submit" class="wp-whatsapp-chatbox-send" aria-label="<?php esc_attr_e('Send message', 'wp-whatsapp-chatbox'); ?>">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
