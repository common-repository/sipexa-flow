<?php
/**
 * @package sipexa-flow
 * @version 1.0.5
 */
/*
Plugin Name: Sipexa Flow
Plugin URI: http://wordpress.org/plugins/sipexa-flow/
Description: Add web forms from your Sipexa Flow account to your WordPress website or blog. This form builder plugin requires a Sipexa Flow account. You can sign up for free at: <a href="https://sipexaflow.com">https://sipexaflow.com</a>.
Author: sipexa.com
Version: 1.0.5
Author URI: https://sipexaflow.com
*/
add_filter('mce_external_plugins', "sipexa_flow_register");
add_filter('mce_buttons', 'sipexa_flow_add_button', 0);

register_activation_hook(__FILE__, 'sipexa_flow_activation_hook');
function sipexa_flow_activation_hook() {
    set_transient('sipexa-flow-activation-notice', true, 5);
}

add_action('admin_notices', 'sipexa_flow_activation_notice');

function sipexa_flow_activation_notice() {
    if (get_transient('sipexa-flow-activation-notice')) {
        echo "<div class=\"updated notice is-dismissible\">
            <p>Thank you for using Sipexa Flow! <strong>Please watch videos at <a href=\"" . admin_url('options-general.php?page=sipexa-flow-plugin') . "\">admin section</a></strong> and <strong>register</strong> through <a href=\"https://sipexaflow.com\" target=\"_blank\">https://sipexaflow.com</a>.</p>
        </div>";
        delete_transient('sipexa-flow-activation-notice');
    }
}

add_action('admin_menu', function () {
    $page_title = 'Sipexa Flow : Howto';
    $menu_title = 'Sipexa Flow';
    $capability = 'manage_options';
    $menu_slug  = 'sipexa-flow-plugin';
    $function   = 'sipexa_flow_plugin_tutorial';
    $icon_url   = 'dashicons-media-code';
    $position   = 4;

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

    $parent_slug = 'sipexa-flow-plugin';
    $page_title = 'sipexa-flow-plugin';
    $menu_title = 'Create Workspace';       //https://www.sipexaflow.com/get-started/email-details
    $capability = 'manage_options';
    $menu_slug  = 'sipexa-flow-create-workspace';
    $function   = 'sipexa_flow_plugin_create_workspace';

    add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

    $parent_slug = 'sipexa-flow-plugin';
    $page_title = 'sipexa-flow-plugin';
    $menu_title = 'Sign in to Workspace';       //https://www.sipexaflow.com/signin
    $capability = 'manage_options';
    $menu_slug  = 'sipexa-flow-sign-in-to-workspace';
    $function   = 'sipexa_flow_plugin_signin_workspace';

    add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
});

function sipexa_flow_plugin_tutorial() {
    echo "<div class=\"wrap\">
        <h3>SIPEXA FLOW</h3>
        <b>Creating a form</b><br><br>

        1. Sign up for a free Sipexa Flow account. You have 2 options:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;a. Create a workspace through <a href=\"https://sipexaflow.com\" target=\"_blank\">https://sipexaflow.com</a><br>
            &nbsp;&nbsp;&nbsp;&nbsp;b. Create a workspace from left menu in Wordpress<br><br>
        2. Start building your web form or survey using the user-friendly drag & drop interface.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;a. Click \"Design Your Form\" menu item<br>
            &nbsp;&nbsp;&nbsp;&nbsp;b. In \"Data Entry Settings\" tab, drag and drop \"New Row\" from right menu to left panel.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;c. Add any component into added row by drag and drop.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;d. Save your form.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;e. Enter your form in edit mode.<br><br>
        3. Configure your web form in the General Settings section.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;a. Open \"General Settings\" tab.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;b. Click \"Do you wish to embed this form into your web page?\" checkbox.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;c. Copy \"WordPress Key\" for using in your Wordpress Blog.<br>
            &nbsp;&nbsp;&nbsp;&nbsp;d. Paste \"WordPress Key\" into content of any page in Wordpress Blog.<br>
        <br><hr><br>
        <iframe width=\"100%\" height=\"570\" src=\"https://www.youtube.com/embed/?listType=playlist&list=PLYSCIJwXtSq1xaQlpbMs7nO0IzkCjZmhv\" frameborder=\"0\" allowfullscreen>
    </div>";
}

function sipexa_flow_plugin_create_workspace() {
    echo "<iframe width=\"100%\" height=\"100%\" src=\"https://www.sipexaflow.com/get-started/email-details\" frameborder=\"0\" allowfullscreen style='height: calc(100vh - 42px);'>";
}

function sipexa_flow_plugin_signin_workspace() {
    echo "<iframe width=\"100%\" height=\"100%\" src=\"https://www.sipexaflow.com/signin\" frameborder=\"0\" allowfullscreen style='height: calc(100vh - 42px);'>";
}

function sipexa_flow_add_button($buttons) {
    array_push($buttons, "separator", "sipexaflow");
    return $buttons;
}

function sipexa_flow_register($plugin_array) {
    $url = trim(get_bloginfo('url'), "/") . "/wp-content/plugins/sipexa-flow/editor_plugin.js";
    $plugin_array['sipexaflow'] = $url;
    return $plugin_array;
}

function sipexa_flow_short_code($atts) {
    $oData = "";
    if (array_key_exists("key", $atts)) {
        $lstKey = explode("-", $atts["key"]);
        if (array_key_exists("height", $atts)) {
            $oData = "<iframe src=\"https://" . $lstKey[0] . ".sipexaflow.com/external-data-entry/" . $lstKey[1] . "\" width=\"100%\" height=\"" . $atts["height"] . "\" frameBorder=\"0\"></iframe>";
        } else {
            $oData = "<iframe src=\"https://" . $lstKey[0] . ".sipexaflow.com/external-data-entry/" . $lstKey[1] . "\" width=\"100%\" height=\"98%\" frameBorder=\"0\"></iframe>";
        }
    }
    return $oData;
}

add_shortcode('sipexa-flow', 'sipexa_flow_short_code');

?>
