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
        <svg class="wp-whatsapp-icon" viewBox="0 0 24 24" width="24" height="24">
            <path fill="#ffffff" d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/>
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
                    <p><?php echo esc_html(get_option('wp_whatsapp_chatbox_welcome_message')); ?></p>
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
