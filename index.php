<?php
/**
 * @package Hello_Dolly
 * @version 1.7.1
 */
/*
Plugin Name: Pricavy and Policy
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Sevak Sargsyan
Version: 1.7.1
Author URI: http://ma.tt/
*/



require_once(plugin_dir_path(__FILE__) . '/config.php');
require_once(plugin_dir_path(__FILE__) . '/helpers.php');
require_once(PAP_ADMIN.'/html-render.php');
require_once(PAP_FRONT.'/html-render.php');

/*** enqueue js and css- ***/


function pap_enqueue($hook) {

    //only for our special plugin admin page
    if ('settings_page_' . PAP != $hook
        && 'settings_page_' . PAP . '_general' != $hook
        && 'settings_page_' . PAP . '_social' != $hook
        && 'settings_page_' . PAP . '_introductions' != $hook
        && 'settings_page_' . PAP . '_payment' != $hook
        && 'settings_page_' . PAP . '_generate' != $hook
        && 'settings_page_' . PAP . '_website' != $hook
    )
        return;
    wp_register_style('-pap-admin-css', PAP_STYLE . '/admin.css');
    wp_enqueue_style('-pap-admin-css');
    wp_enqueue_script('-pap-settings', plugins_url('/admin/js/settings.js', __FILE__), array('jquery'));
}

add_action('admin_enqueue_scripts', 'pap_enqueue');


function pap_enqueue_front() {

    wp_register_style('-pap-bootstrap-css', PAP_STYLE_FRONT . '/bootstrap.css');
    wp_register_style('-pap-style-css', PAP_STYLE_FRONT . '/style.css');
    wp_enqueue_style('-pap-bootstrap-css');
    wp_enqueue_style('-pap-style-css');
    wp_enqueue_script('-pap-bootstrap', PAP_JS_FRONT. '/bootstrap.js',array('jquery'));
    wp_enqueue_script('-pap-main', PAP_JS_FRONT. '/main.js',array('jquery'));
    wp_localize_script('-pap-main', 'MAINJS', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

}
add_action( 'wp_enqueue_scripts', 'pap_enqueue_front' );

/*** add Privacy and Policy plugin's menu to settings ***/


function pap_add_menu() {
    add_submenu_page("options-general.php", "Privacy and Policy", "Privacy and Policy", "manage_options", PAP, "_pap_general_settings");
    // menu in admin
    add_submenu_page("", "", "", "manage_options", PAP . "_website", "_pap_website_settings");
    add_submenu_page("", "", "", "manage_options", PAP . "_social", "_pap_social_settings");
    add_submenu_page("", "", "", "manage_options", PAP . "_general", "_pap_general_settings");
    add_submenu_page("", "", "", "manage_options", PAP . "_payment", "_pap_payment_settings");
    add_submenu_page("", "", "", "manage_options", PAP . "_introductions", "_pap_introductions");
    add_submenu_page("", "", "", "manage_options", PAP . "_generate", "_pap_generate_shortcode");
}

add_action("admin_menu", "pap_add_menu");


/*** ADMIN PAGES ***/


function _pap_general_settings() {

    global $html_;
    echo PAP_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    $html_->pap_admin_general_view();

}

function _pap_website_settings() {

    global $html_;
    echo PAP_WEBSITE_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    $html_->pap_admin_website_view();

}

function _pap_social_settings() {

    global $html_;
    echo PAP_SOCIAL_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    $html_->pap_admin_social_view();

}

function _pap_payment_settings() {

    global $html_;
    echo PAP_PAYMENT_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    $html_->pap_admin_payment_view();

}

function _pap_introductions() {

    echo PAP_INTRO_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    ?>
    <div class="-pap-introductions-wrapper" style="width: 97%;font-size: 14px;">
        <h1>
            Privacy and Policy introductions
        </h1>
        <p style="width: 96%;line-height: 2;">
            Where does it come from?
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
            literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
            College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and
            going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum
            comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by
            Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance.
            The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections
            1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original
            form, accompanied by English versions from the 1914 translation by H. Rackham.
        </p>
    </div>
    <?php
}

function _pap_generate_shortcode() {

    echo PAP_INTRO_HEADER;
    HTMLADMIN::pap_admin_menu_view();
    ?>
    <div class="-pap-shortcode-wrapper">
        <h1>
            Generate shortcode
        </h1>
        <div class="-pap-header">
            <button class="gen-shortcode">Generate Shortcode</button>
            <button class="gen-page">Generate Page</button>
        </div>
        <div style="width: 97%;min-height: 250px;background: #fff;margin: 10px;border: 1px solid #ccc;" class="-pap-content">
            <div></div>
        </div>
    </div>
    <?php
}


/*** form settings ***/

function pap_field_settings() {

    add_settings_section("general_config", "", null, "_pap_general");
        add_settings_field("company_name", "Company Name", "company_name_callback", "_pap_general", "general_config");
        add_settings_field("address_data", "Street & House Number", "address_data_callback", "_pap_general", "general_config");
        add_settings_field("city", "City", "city_callback", "_pap_general", "general_config");
        add_settings_field("country", "Country", "country_callback", "_pap_general", "general_config");
        add_settings_field("email", "Email", "email_callback", "_pap_general", "general_config");
        add_settings_field("zip", "Zip code", "zip_callback", "_pap_general", "general_config");
        add_settings_field("phone", "Phone", "phone_callback", "_pap_general", "general_config");
        add_settings_field("general_text", "General text", "general_text_callback_editor", "_pap_general", "general_config");
        add_settings_field("general_config_state", "", "general_config_state_callback", "_pap_general", "general_config");
        register_setting("general_config", "-pap-company_name");
        register_setting("general_config", "-pap-address_data");
        register_setting("general_config", "-pap-city");
        register_setting("general_config", "-pap-country");
        register_setting("general_config", "-pap-email");
        register_setting("general_config", "-pap-company_name-state");
        register_setting("general_config", "-pap-address_data-state");
        register_setting("general_config", "-pap-city-state");
        register_setting("general_config", "-pap-country-state");
        register_setting("general_config", "-pap-email-state");
        register_setting("general_config", "-pap-general_config-text");
        register_setting("general_config", "-pap-general_config_state");
        register_setting("general_config", "-pap-zip");
        register_setting("general_config", "-pap-phone");
        register_setting("general_config", "-pap-zip-state");
        register_setting("general_config", "-pap-phone-state");
    add_settings_section("website_config", "1.General", null, "_pap_website");
        add_settings_field("cookies", "We use cookies.", "cookies_callback", "_pap_website", "website_config");
        add_settings_field("register", "Customers can register with us.", "register_callback", "_pap_website", "website_config");
        add_settings_field("website_text", "1.General text", "website_text_callback_editor", "_pap_website", "website_config");
        add_settings_field("website_config_state", "", "website_config_state_callback", "_pap_website", "website_config");
        register_setting("website_config", "-pap-cookies");
        register_setting("website_config", "-pap-register");
        register_setting("website_config", "-pap-website_config-text");
        register_setting("website_config", "-pap-website_config_state");
    add_settings_section("social_config", "2.Social Media", null, "_pap_social");
        add_settings_field("facebook", "Facebook", "facebook_callback", "_pap_social", "social_config");
        add_settings_field("instagram", "Instagram", "instagram_callback", "_pap_social", "social_config");
        add_settings_field("social_text", "2.General text", "social_text_callback_editor", "_pap_social", "social_config");
        add_settings_field("social_config_state", "", "social_config_state_callback", "_pap_social", "social_config");
        register_setting("social_config", "-pap-facebook");
        register_setting("social_config", "-pap-instagram");
        register_setting("social_config", "-pap-social_config-text");
        register_setting("social_config", "-pap-social_config_state");
    add_settings_section("payment_config", "3.Payment Options", null, "_pap_payment");
        add_settings_field("paypal", "Paypal", "paypal_callback", "_pap_payment", "payment_config");
        add_settings_field("klarna", "Klarna", "klarna_callback", "_pap_payment", "payment_config");
        add_settings_field("payment_text", "3.General text", "payment_text_callback_editor", "_pap_payment", "payment_config");
        add_settings_field("payment_config_state", "", "payment_config_state_callback", "_pap_payment", "payment_config");
        register_setting("payment_config", "-pap-paypal");
        register_setting("payment_config", "-pap-klarna");
        register_setting("payment_config", "-pap-payment_config-text");
        register_setting("payment_config", "-pap-payment_config_state");

}

add_action("admin_init", "pap_field_settings");


/*** form field functions ***/


function general_config_state_callback() {
    ?>
    <div class="general_config -pap-general_config_state">
        <input type="hidden" name="-pap-general_config_state">
    </div>
    <?php
}

function company_name_callback() {

    $state = get_option('-pap-company_name-state');
    ?>
    <div class="general_config -pap-company_name">
        <input type="checkbox" name="-pap-company_name-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-company_name"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-company_name'))); ?>"/><?php HTMLADMIN::generate_key('-pap-company_name');?>

    </div>
    <?php
}

function address_data_callback() {

    $state = get_option('-pap-address_data-state');
    ?>
    <div class="general_config -pap-address_data">
        <input type="checkbox" name="-pap-address_data-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-address_data"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-address_data'))); ?>"/><?php HTMLADMIN::generate_key('-pap-address_data');?>
    </div>
    <?php
}

function city_callback() {

    $state = get_option('-pap-city-state');
    ?>
    <div class="general_config -pap-city">
        <input type="checkbox" name="-pap-city-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-city"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-city'))); ?>"/><?php HTMLADMIN::generate_key('-pap-city');?>
    </div>
    <?php
}

function country_callback() {

    $state = get_option('-pap-country-state');
    ?>
    <div class="general_config -pap-country">
        <input type="checkbox" name="-pap-country-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-country"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-country'))); ?>"/><?php HTMLADMIN::generate_key('-pap-country');?>
    </div>
    <?php
}

function email_callback() {

    $state = get_option('-pap-email-state');
    ?>
    <div class="general_config -pap-email">
        <input type="checkbox" name="-pap-email-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="email" name="-pap-email"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-email'))); ?>"/><?php HTMLADMIN::generate_key('-pap-email');?>
    </div>
    <?php
}
function zip_callback() {

    $state = get_option('-pap-zip-state');
    ?>
    <div class="general_config -pap-zip">
        <input type="checkbox" name="-pap-zip-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-zip"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-zip'))); ?>"/><?php HTMLADMIN::generate_key('-pap-zip');?>
    </div>
    <?php
}
function phone_callback() {

    $state = get_option('-pap-phone-state');
    ?>
    <div class="general_config -pap-phone">
        <input type="checkbox" name="-pap-phone-state" <?php echo ($state == "on") ? "checked" : ""; ?>>
        <input type="text" name="-pap-phone"
               value="<?php
               echo stripslashes_deep(esc_attr(get_option('-pap-phone'))); ?>"/><?php HTMLADMIN::generate_key('-pap-phone');?>
    </div>
    <?php
}

function general_text_callback_editor() {
    global $DEFAULT_TEXTS;

    $content = get_option('-pap-general_config-text');
    if(!$content)
        $content = $DEFAULT_TEXTS['general_text'];
    wp_editor($content, '-pap-general_config-text');
}

/*** website form callbacks ***/

function website_config_state_callback() {
    ?>
    <div class="website_config -pap-website_config_state">
        <input type="hidden" name="-pap-website_config_state">
    </div>
    <?php
}
function cookies_callback() {

    $state = get_option('-pap-cookies');
    ?>
    <div class="website_config -pap-cookies">
        <input type="checkbox" name="-pap-cookies" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-cookies');?>
    </div>
    <?php
}

function register_callback() {

    $state = get_option('-pap-register');
    ?>
    <div class="website_config -pap-register">
        <input type="checkbox" name="-pap-register" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-register');?>
    </div>
    <?php
}

function website_text_callback_editor() {

    $content = get_option('-pap-website_config-text');
    wp_editor($content, '-pap-website_config-text');
}


/*** social form callbacks ***/

function social_config_state_callback() {
    ?>
    <div class="social_config -pap-social_config_state">
        <input type="hidden" name="-pap-social_config_state">
    </div>
    <?php
}

function instagram_callback()
{
    $state = get_option('-pap-instagram');
    ?>
    <div class="social_config -pap-instagram">
        <input type="checkbox" name="-pap-instagram" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-instagram');?>
    </div>
    <?php
}

function facebook_callback() {

    $state = get_option('-pap-facebook');
    ?>
    <div class="website_config -pap-facebook">
        <input type="checkbox" name="-pap-facebook" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-facebook');?>
    </div>
    <?php
}

function social_text_callback_editor() {

    $content = get_option('-pap-social_config-text');
    wp_editor($content, '-pap-social_config-text');
}

/*** payment form callbacks ***/

function payment_config_state_callback() {
    ?>
    <div class="payment_config -pap-payment_config_state">
        <input type="hidden" name="-pap-payment_config_state">
    </div>
    <?php
}
function paypal_callback() {

    $state = get_option('-pap-paypal');
    ?>
    <div class="payment_config -pap-paypal">
        <input type="checkbox" name="-pap-paypal" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-paypal');?>
    </div>
    <?php
}

function klarna_callback() {

    $state = get_option('-pap-klarna');
    ?>
    <div class="payment_config -pap-klarna">
        <input type="checkbox" name="-pap-klarna" <?php echo ($state == "on") ? "checked" : ""; ?>><?php HTMLADMIN::generate_key('-pap-klarna');?>
    </div>
    <?php
}

function payment_text_callback_editor() {

    $content = get_option('-pap-payment_config-text');
    wp_editor($content, '-pap-payment_config-text');
}


/*** -shortcodes- ***/


add_shortcode('privacy', 'privacy_front_callback_function');

function privacy_front_callback_function($atts) {

    global $help;
    global $html;
    ob_start();
    $general = $help->is_flag( 'gen', $atts )?$general = true:false;
    $social = $help->is_flag( 'soc', $atts )?$general = true:false;
    $website = $help->is_flag( 'web', $atts )?$general = true:false;
    $payment = $help->is_flag( 'pay', $atts )?$general = true:false;
    $html->createFrontHtml(
            $general,
            $website,
            $social,
            $payment

    );
    return  ob_get_clean();
}


/*** AJAX REQUESTS FROM ADMIN ***/


function generate_shortcode_admin() {

    $general = get_option('-pap-general_config_state')?' gen':"";
    $website = get_option('-pap-website_config_state')?' web':"";
    $social = get_option('-pap-social_config_state')?' soc':"";
    $payment = get_option('-pap-social_config_state')?' pay':"";
    $str = '[privacy '.$general.$social.$website.$payment.']';
    echo $str;
    wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_admin_shortcode_action', 'generate_shortcode_admin' );


/*** AJAX  REQUESTS FROM FRONT END ***/

function gen_front_html_ajax() {

    $textGeneral = get_option('-pap-general_config-text');
    $textWebsite= get_option('-pap-website_config-text');
    $textSocial= get_option('-pap-social_config-text');
    $textPayment = get_option('-pap-payment_config-text');
    echo $textGeneral.'<div></div>'.$textWebsite.'<div></div>'.$textSocial.'<div></div>'.$textPayment;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_front_action', 'gen_front_html_ajax' );
add_action( 'wp_ajax_nopriv_front_action', 'gen_front_html_ajax' );


/*** create privacy policy page ***/

//function add_my_custom_page() {
//    // Create post object
//    $my_post = array(
//        'post_title'    => wp_strip_all_tags( 'Privacy and Policy' ),
//        'post_content'  => do_shortcode('[privacy_front]'),
//        'post_status'   => 'publish',
//        'post_author'   => 1,
//        'post_type'     => 'page',
//    );
//
//    // Insert the post into the database
//    wp_insert_post( $my_post );
//}
//
//register_activation_hook(__FILE__, 'add_my_custom_page');