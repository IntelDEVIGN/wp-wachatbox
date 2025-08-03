=== WP WhatsApp Chatbox ===
Contributors: ahvega
Tags: whatsapp, chat, messaging, contact, communication
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a beautiful WhatsApp chat widget to your WordPress site and connect with your visitors instantly.

== Description ==

WP WhatsApp Chatbox adds a floating WhatsApp-style chat widget to your WordPress site, making it easy for visitors to start conversations with you directly through WhatsApp.

= Key Features =

* Beautiful WhatsApp-style chat interface
* Customizable welcome message
* Configurable account details
* Mobile-responsive design
* Auto-display options
* Custom styling options
* Shortcode support
* Performance optimized
* Accessibility compliant
* Business hours management
* Advanced security features
* Comprehensive error logging
* Enhanced responsive design

= Pro Features =

* Multiple agent support
* Advanced styling options
* Analytics and tracking
* Custom triggers
* Advanced display rules

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin dashboard
2. Navigate to 'Plugins' → 'Add New'
3. Search for "WP WhatsApp Chatbox"
4. Click 'Install Now' and then 'Activate'
5. Go to 'Settings' → 'WP WhatsApp Chatbox' to configure

= Manual Installation =

1. Download the plugin zip file
2. Log in to your WordPress admin dashboard
3. Navigate to 'Plugins' → 'Add New' → 'Upload Plugin'
4. Choose the downloaded zip file and click 'Install Now'
5. Activate the plugin after installation completes
6. Go to 'Settings' → 'WP WhatsApp Chatbox' to configure

= FTP Installation =

1. Download and extract the plugin zip file
2. Upload the `wp-whatsapp-chatbox` folder to `/wp-content/plugins/` directory via FTP
3. Log in to WordPress admin and go to 'Plugins'
4. Find 'WP WhatsApp Chatbox' and click 'Activate'
5. Go to 'Settings' → 'WP WhatsApp Chatbox' to configure

= Initial Setup =

After activation:
1. **Configure WhatsApp Number**: Enter your WhatsApp number with country code (e.g., +1234567890)
2. **Set Account Name**: Enter your business or personal name
3. **Customize Welcome Message**: Write a greeting message for visitors
4. **Choose Colors**: Customize the widget's appearance to match your site
5. **Set Business Hours** (Optional): Configure when the widget should appear
6. **Test the Widget**: Visit your site to see the chat widget in action

The widget will appear automatically on all pages unless you configure specific display rules.

== Frequently Asked Questions ==

= Does this plugin require a WhatsApp Business API? =

No, this plugin works with regular WhatsApp numbers. However, for business scaling, we recommend using a WhatsApp Business account for better professional features.

= Can I customize the appearance? =

Yes, you can customize colors, border radius, avatar images, welcome messages, and positioning through the admin panel. The plugin also supports custom CSS for advanced styling.

= Is it GDPR compliant? =

Yes, the plugin doesn't store any visitor data by default. All conversations happen directly through WhatsApp. The plugin only uses a session cookie to prevent auto-display spam, which is deleted when the browser closes.

= How do I add my WhatsApp number? =

Go to Settings → WP WhatsApp Chatbox and enter your WhatsApp number with the country code (e.g., +1234567890 for US numbers). Make sure to include the "+" symbol.

= The widget is not appearing on my site. What should I check? =

First, ensure the plugin is activated. Then check: 1) Your WhatsApp number is entered correctly with country code, 2) Business hours are not restricting display (if enabled), 3) No theme conflicts by testing with a default WordPress theme.

= Can I use this with WhatsApp Business? =

Yes, you can use any WhatsApp number including WhatsApp Business numbers. Just enter the number in the settings with the country code.

= How do I set up business hours? =

In the plugin settings, enable "Business Hours" and configure the days and times when you want the widget to appear. The widget will automatically hide outside these hours.

= Can I use the widget on specific pages only? =

Currently, the widget appears on all pages by default. You can use the shortcode `[wa_chatbox]` to display it on specific pages and disable the global display.

= Is the plugin mobile-friendly? =

Yes, the plugin is fully responsive and optimized for mobile devices with touch-friendly buttons and appropriate sizing for small screens.

= How do I change the welcome message? =

Go to Settings → WP WhatsApp Chatbox and edit the "Welcome Message" field. You can use basic HTML formatting like line breaks.

= Can I have multiple WhatsApp numbers? =

The current version supports one WhatsApp number. Multiple agent support is planned for a future pro version.

= Why is the widget not clickable? =

This usually happens due to CSS conflicts with your theme. Try switching to a default WordPress theme temporarily to test. You may need to adjust z-index values or contact support.

= How do I remove the widget temporarily? =

You can disable the widget by: 1) Deactivating the plugin, 2) Clearing the WhatsApp number in settings, or 3) Enabling business hours and setting them to times when you're unavailable.

= Does this work with caching plugins? =

Yes, the plugin works with most caching plugins. However, business hours functionality requires JavaScript, so ensure your caching plugin doesn't strip JavaScript.

= Can I translate the plugin? =

Yes, the plugin is translation-ready with the text domain 'wp-whatsapp-chatbox'. You can use tools like Loco Translate or create .po/.mo files for your language.

== Troubleshooting ==

= Widget Not Appearing =

**Check these common issues:**

1. **Plugin Activation**: Ensure the plugin is activated in Plugins → Installed Plugins
2. **WhatsApp Number**: Verify your number includes the country code with + symbol (e.g., +1234567890)
3. **Business Hours**: If enabled, make sure current time falls within your configured hours
4. **Theme Conflicts**: Switch to Twenty Twenty-Four theme temporarily to test
5. **JavaScript Errors**: Check browser console (F12) for JavaScript errors
6. **Caching**: Clear any caching plugins or CDN cache

= Widget Appears But Not Clickable =

**Common CSS Conflicts:**

1. **Z-Index Issues**: Your theme might have elements covering the widget
2. **Position Conflicts**: Some themes override position fixed elements
3. **CSS Conflicts**: Try adding this to your theme's Additional CSS:
   ```css
   #wp-whatsapp-chatbox {
       z-index: 999999 !important;
   }
   ```

= Business Hours Not Working =

**Timezone and Configuration Issues:**

1. **WordPress Timezone**: Ensure WordPress timezone is set correctly in Settings → General
2. **Time Format**: Use 24-hour format (e.g., 09:00, 17:30)
3. **Day Configuration**: Make sure you've enabled the days you want the widget to appear
4. **Caching**: Business hours use JavaScript, ensure it's not being cached or minified incorrectly

= WhatsApp Link Not Working =

**URL and Number Issues:**

1. **Country Code**: Must include + and country code (e.g., +1 for US, +44 for UK)
2. **No Spaces**: Remove any spaces, dashes, or special characters from the number
3. **Valid Number**: Ensure the WhatsApp number is active and can receive messages
4. **Mobile Users**: Some mobile browsers may not have WhatsApp installed

= Plugin Conflicts =

**Common Plugin Conflicts:**

1. **Security Plugins**: Some security plugins may block the widget
2. **Popup Plugins**: Other popup/chat plugins may interfere
3. **Page Builders**: Elementor, Visual Composer may have CSS conflicts
4. **Performance Plugins**: Minification may break JavaScript functionality

**Debugging Steps:**
1. Deactivate all other plugins temporarily
2. Test with default WordPress theme
3. Enable WordPress debug mode to see error messages
4. Check browser console for JavaScript errors

= Performance Issues =

**Optimization Steps:**

1. **Conditional Loading**: Widget only loads when needed
2. **Caching Compatibility**: Works with most caching plugins
3. **Minification**: Ensure JavaScript minification doesn't break functionality
4. **CDN**: Should work with CDNs, but test business hours functionality

= Getting Help =

If you're still experiencing issues:

1. **Check Browser Console**: Press F12 and look for errors in the Console tab
2. **Test Environment**: Try on a staging site with default theme and no other plugins
3. **WordPress Version**: Ensure you're running WordPress 5.0 or higher with PHP 7.4+
4. **Support Forums**: Visit the WordPress.org plugin support forum
5. **Documentation**: Check the complete setup guide on the plugin homepage

**When Reporting Issues, Include:**
- WordPress version
- PHP version  
- Active theme name
- List of active plugins
- Browser console errors (if any)
- Steps to reproduce the issue

== Screenshots ==

1. Chat widget on frontend
2. Admin settings panel
3. Customization options
4. Mobile view

== Changelog ==

= 1.1.0 =
* **Security Enhancements**: Added CSRF protection with nonce verification
* **Security**: Enhanced input validation for phone numbers and avatar URLs
* **Security**: Fixed XSS vulnerabilities in welcome message output
* **Security**: Improved cookie security with SameSite and Secure attributes
* **Performance**: Implemented centralized settings management (50-60% reduction in database queries)
* **Performance**: Optimized JavaScript with caching and throttled scroll events
* **Performance**: Added GPU-accelerated CSS animations
* **Performance**: Conditional business hours checking
* **Accessibility**: Enhanced ARIA support and keyboard navigation
* **Accessibility**: Added screen reader announcements and focus management
* **Accessibility**: Improved mobile responsiveness with multiple breakpoints
* **WordPress Compliance**: Added proper activation/deactivation hooks
* **WordPress Compliance**: Enhanced plugin header with complete metadata
* **WordPress Compliance**: Fixed duplicate hook registration issues
* **Code Quality**: Added comprehensive error handling and logging system
* **Code Quality**: Implemented WP_WhatsApp_Chatbox_Logger for debugging
* **Code Quality**: Enhanced internationalization support
* **Bug Fixes**: Fixed broken shortcode and footer hook method references
* **UI/UX**: Added reduced motion support and high contrast mode
* **UI/UX**: Enhanced responsive design for better mobile experience

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.1.0 =
Major security, performance, and accessibility improvements. Enhanced WordPress compliance and code quality. Recommended update for all users.

= 1.0.0 =
Initial release of WP WhatsApp Chatbox
