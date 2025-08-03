/**
 * Public-facing JavaScript functionality
 * Handles chat widget interactions, visibility, and business hours logic
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Cache jQuery selectors for better performance
        const $chatbox = $('#wp-whatsapp-chatbox');
        const $chatboxPopup = $('.wp-whatsapp-chatbox-popup');
        const $chatboxButton = $('.wp-whatsapp-chatbox-button');
        const $chatboxClose = $('.wp-whatsapp-chatbox-close');
        const $chatboxForm = $('.wp-whatsapp-chatbox-input-form');
        const $window = $(window);
        const $document = $(document);
        let isVisible = false;

        /**
         * Toggles the chat popup visibility with animation
         * 
         * @param {boolean} show Whether to show or hide the popup
         * @returns {void}
         */
        function toggleChat(show) {
            isVisible = show;
            $chatboxPopup.attr('aria-hidden', !show);

            if (show) {
                $chatboxPopup.css('display', 'block');
                // Use requestAnimationFrame for smoother animations
                requestAnimationFrame(() => {
                    $chatboxPopup.css({
                        'opacity': '1',
                        'transform': 'translateY(0) scale(1)'
                    });
                });
                // Set button expanded state for accessibility
                $chatboxButton.attr('aria-expanded', 'true');
            } else {
                $chatboxPopup.css({
                    'opacity': '0',
                    'transform': 'translateY(20px) scale(0.9)'
                });
                // Wait for transition to complete before hiding
                setTimeout(() => {
                    $chatboxPopup.css('display', 'none');
                }, 300);
                // Set button expanded state for accessibility
                $chatboxButton.attr('aria-expanded', 'false');
            }
        }

        // Button click handler
        $chatboxButton.on('click', function(e) {
            e.preventDefault();
            toggleChat(!isVisible);
            updateWelcomeMessage();
        });

        // Close button handler
        $chatboxClose.on('click', function(e) {
            e.preventDefault();
            toggleChat(false);
        });

        // Form submit handler
        $chatboxForm.on('submit', function(e) {
            e.preventDefault();
            const input = $(this).find('.wp-whatsapp-chatbox-input');
            const message = input.val().trim();

            if (message) {
                const whatsappNumber = wpWhatsAppChatbox.whatsappNumber;
                const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
                input.val('');
                toggleChat(false);
            }
        });

        // Click outside to close
        $document.on('click', function(e) {
            if (isVisible && !$(e.target).closest('.wp-whatsapp-chatbox').length) {
                toggleChat(false);
            }
        });

        // Auto-show logic with cookie and throttling
        if (wpWhatsAppChatbox.autoShowEnabled && !getCookie('wp_whatsapp_chatbox_session')) {
            let hasShown = false;
            let ticking = false;
            const $footer = $('footer, .footer, #footer').first();

            // Throttled scroll handler for better performance
            function handleScroll() {
                if (!ticking && !hasShown && $footer.length) {
                    requestAnimationFrame(function() {
                        const footerTop = $footer.offset().top;
                        const scrollPosition = $window.scrollTop() + $window.height();

                        if (scrollPosition >= footerTop) {
                            hasShown = true;
                            toggleChat(true);
                            // Set a secure session cookie to prevent auto-showing again
                            const isSecure = window.location.protocol === 'https:' ? '; Secure' : '';
                            document.cookie = "wp_whatsapp_chatbox_session=true; path=/; SameSite=Strict" + isSecure;
                            // Remove scroll handler after use for better performance
                            $window.off('scroll', handleScroll);
                        }
                        ticking = false;
                    });
                    ticking = true;
                }
            }

            $window.on('scroll', handleScroll);
            }
        }

        /**
         * Gets a cookie by name
         * 
         * @param {string} name The name of the cookie
         * @returns {string|null} The cookie value or null if not found
         */
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Handle escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && isVisible) {
                toggleChat(false);
            }
        });

        /**
         * Checks if current time falls within configured business hours
         * 
         * @returns {boolean} True if within business hours, false otherwise
         */
        function isWithinBusinessHours() {
            if (!wpWhatsAppChatbox.businessHoursEnabled) {
                return true;
            }

            // Create date object in site's timezone
            const siteTimezone = wpWhatsAppChatbox.timezone;
            const now = new Date().toLocaleString("en-US", { timeZone: siteTimezone });
            const nowDate = new Date(now);

            // Get day and time in site's timezone
            const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const currentDay = days[nowDate.getDay()];
            const currentTime = nowDate.getHours() * 60 + nowDate.getMinutes();

            const businessHours = wpWhatsAppChatbox.businessHours[currentDay];

            // First check if the current day is enabled and has business hours set
            if (!businessHours || businessHours.enabled !== '1') {
                return false;
            }

            // Then check if current time is within business hours
            const [startHour, startMinute] = businessHours.start.split(':').map(Number);
            const [endHour, endMinute] = businessHours.end.split(':').map(Number);

            const startTime = startHour * 60 + startMinute;
            const endTime = endHour * 60 + endMinute;

            return currentTime >= startTime && currentTime <= endTime;
        }

        /**
         * Updates widget visibility based on business hours
         * Hides widget outside business hours if enabled
         * 
         * @returns {void}
         */
        function updateWidgetVisibility() {
            const shouldShow = isWithinBusinessHours();
            $chatbox.toggle(shouldShow);
        }

        // Initial check
        updateWidgetVisibility();

        // Only run business hours check if business hours are enabled for better performance
        if (wpWhatsAppChatbox.businessHoursEnabled) {
            setInterval(updateWidgetVisibility, 60000);
        }

        // Update welcome message display
        function updateWelcomeMessage() {
            const $welcomeMessage = $('.wp-whatsapp-chatbox-welcome-message');
            if ($welcomeMessage.length) {
                // Use text() to prevent XSS, or safely handle pre-sanitized HTML from server
                // Since the content is already sanitized server-side with wp_kses_post, we can use html()
                // but this requires trust in server-side sanitization
                $welcomeMessage.html(wpWhatsAppChatbox.welcomeMessage);
            }
        }

        // Keyboard navigation and accessibility
        function initializeAccessibility() {
            // Enhanced focus management
            $chatboxButton.on('click', function() {
                if (!isVisible) {
                    setTimeout(() => {
                        $chatboxForm.find('.wp-whatsapp-chatbox-input').focus();
                    }, 350); // Wait for animation
                }
            });
            
            // Escape key handling
            $document.on('keydown', function(e) {
                if (e.key === 'Escape' && isVisible) {
                    e.preventDefault();
                    toggleChat(false);
                    $chatboxButton.focus();
                }
            });
            
            // Tab trap within popup for keyboard users
            $chatboxPopup.on('keydown', function(e) {
                if (e.key === 'Tab') {
                    const focusableElements = $chatboxPopup.find('button, input, [tabindex="0"]');
                    const firstElement = focusableElements.first();
                    const lastElement = focusableElements.last();
                    
                    if (e.shiftKey && e.target === firstElement[0]) {
                        e.preventDefault();
                        lastElement.focus();
                    } else if (!e.shiftKey && e.target === lastElement[0]) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            });
            
            // Announce state changes to screen readers
            $chatboxButton.on('click', function() {
                const announcement = isVisible ? 
                    'Chat window closed' : 
                    'Chat window opened';
                announceToScreenReader(announcement);
            });
        }
        
        // Announce content to screen readers
        function announceToScreenReader(message) {
            const announcement = $('<div>')
                .attr('aria-live', 'polite')
                .attr('aria-atomic', 'true')
                .addClass('sr-only')
                .text(message);
            
            $('body').append(announcement);
            
            // Remove after announcement
            setTimeout(() => {
                announcement.remove();
            }, 1000);
        }

        // Initialize accessibility features
        initializeAccessibility();
        
        // Call it initially
        updateWelcomeMessage();
    });

})(jQuery);