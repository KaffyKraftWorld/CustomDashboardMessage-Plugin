<?php
/*
Plugin Name: Custom Dashboard Welcome Message
Plugin URI: /#
Description: Customize the default WordPress dashboard welcome message for your site's users.
Version: 1.0.0
Author: Kafayat Faniran
Author URI: https://www.linkedin.com/in/kafayatfaniran
License: GPL2
*/

if(! defined( 'ABSPATH' )) {
  exit('Get lost!');
}

register_activation_hook(__FILE__, 'custom_dashboard_welcome_message_activate');
register_deactivation_hook(__FILE__, 'custom_dashboard_welcome_message_deactivate');

function custom_dashboard_welcome_message_activate() {
    // .
}

function custom_dashboard_welcome_message_deactivate() {
    // .
}

class CustomDashboardWelcomeMessage {

    public function __construct() {
        
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_filter('welcome_panel', array($this, 'customize_dashboard_welcome_message'));
    }

    // Registering the plugin settings
    public function register_settings() {
        register_setting('general', 'custom_dashboard_welcome_message', 'sanitize_text_field');
        add_settings_field(
            'custom_dashboard_welcome_message',
            'Custom Dashboard Welcome Message',
            array($this, 'render_settings_field'),
            'general',
            'default'
        );
    }

    // Rendering settings field in the General Settings page
    public function render_settings_field() {
        $message = get_option('custom_dashboard_welcome_message');
        ?>
        <textarea id="custom_dashboard_welcome_message" name="custom_dashboard_welcome_message" rows="5" cols="50"><?php echo esc_textarea($message); ?></textarea>
        <?php
    }

    // Adding settings page link in the admin menu
    public function add_settings_page() {
        add_options_page(
            'Custom Dashboard Welcome Message',
            'Dashboard Welcome Message',
            'manage_options',
            'custom-dashboard-welcome-message',
            array($this, 'render_settings_page')
        );
    }

    // Rendering settings page content
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Custom Dashboard Welcome Message</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('general');
                do_settings_sections('general');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Customizing the dashboard welcome message
    public function customize_dashboard_welcome_message($content) {
        $custom_message = get_option('custom_dashboard_welcome_message');
        if (!empty($custom_message)) {
            $content = wpautop($custom_message);
        }
        return $content;
    }
}

new CustomDashboardWelcomeMessage();
