(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color picker
        if ($.fn.wpColorPicker) {
            $('.color-picker').wpColorPicker();
        }

        // Phone number validation
        $('#wp_whatsapp_chatbox_whatsapp_number').on('change', function() {
            let number = $(this).val().replace(/[^0-9+]/g, '');
            $(this).val(number);
        });

        // Display delay validation
        $('#wp_whatsapp_chatbox_display_delay').on('change', function() {
            let delay = parseInt($(this).val());
            if (isNaN(delay) || delay < 0) {
                $(this).val(2000);
            }
        });

        // Border radius validation
        $('#wp_whatsapp_chatbox_border_radius').on('change', function() {
            let radius = parseInt($(this).val());
            if (isNaN(radius) || radius < 0) {
                $(this).val(15);
            }
        });

        // Media Uploader
        let mediaUploader;

        $('.wp-whatsapp-chatbox-upload-btn').on('click', function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'Select Profile Avatar',
                button: {
                    text: 'Use this image'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#wp_whatsapp_chatbox_avatar').val(attachment.url);
                $('.avatar-preview img').attr('src', attachment.url);
            });

            mediaUploader.open();
        });

        // Remove avatar
        $('.wp-whatsapp-chatbox-remove-btn').on('click', function() {
            const defaultAvatar = wpWhatsAppChatbox.defaultAvatar;
            $('#wp_whatsapp_chatbox_avatar').val('');
            $('.avatar-preview img').attr('src', defaultAvatar);
        });
    });

})(jQuery);