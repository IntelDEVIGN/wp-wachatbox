<?php
/**
 * Admin area display template
 */
if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <form method="post" action="options.php">
        <?php
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
            submit_button(__('Save Settings', 'wp-whatsapp-chatbox'), 'primary', 'submit', true);
        ?>
    </form>
</div>

<div class="postbox">
    <h3 class="hndle"><span><?php _e('Shortcode Usage', 'wp-whatsapp-chatbox'); ?></span></h3>
    <div class="inside">
        <p><?php _e('Use this shortcode to display the WhatsApp chat widget in any post or page:', 'wp-whatsapp-chatbox'); ?></p>
        <code>[wa_chatbox]</code>
    </div>
</div>