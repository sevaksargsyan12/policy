<?php

class HTMLADMIN {

    static function generate_key($key) {
        echo '<span class="-pap-key"><b>&nbsp;[['.$key.']]</b></span>';
    }

    /*** plugin admin menu ***/

    static function pap_admin_menu_view() {
        $current_screen = get_current_screen()->id;
        ?>
        <ul class="<?php echo PAP . 'admin_menu'; ?>">
            <li class="<?php echo ($current_screen == 'settings_page__pap_general') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_general'; ?>">General Settings</a>
            </li>
            <li class="<?php echo ($current_screen == 'settings_page__pap_website') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_website'; ?>">Website Settings</a>
            </li>
            <li class="<?php echo ($current_screen == 'settings_page__pap_social') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_social'; ?>">Social Settings</a>
            </li>
            <li class="<?php echo ($current_screen == 'settings_page__pap_payment') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_payment'; ?>">Payment Settings</a>
            </li>
            <li class="<?php echo ($current_screen == 'settings_page__pap_introductions') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_introductions'; ?>">Introductions</a>
            </li>
            <li class="<?php echo ($current_screen == 'settings_page__pap_generate') ? "active" : ""; ?>">
                <a href="<?php echo PAP_ADMIN_URL . '?page=_pap_generate'; ?>">Generate Shortcode</a>
            </li>
        </ul>
    <?php }


    /*** main form function VIEWS***/


    function pap_admin_general_view()
    {
        ?>
        <form method="post" action="options.php" id="pap_general_config_form" class="-pap-settings-form">
            <h1>LOOKING FOR A PRIVACY POLICY?</h1>
            <?php

            settings_fields("general_config");
            do_settings_sections("_pap_general");
            //    settings_fields("1_config");

            submit_button();
            ?>
        </form>
        <?php
    }

    function pap_admin_website_view()
    { ?>
        <form method="post" action="options.php" id="pap_website_config_form" class="-pap-settings-form">
            <h1>GENERAL INFORMATION ABOUT THE WEBSIT</h1>
            <?php

            settings_fields("website_config");
            do_settings_sections("_pap_website");

            submit_button();
            ?>
        </form>
    <?php }

    function pap_admin_social_view()
    { ?>
        <form method="post" action="options.php" id="pap_social_config_form" class="-pap-settings-form">
            <h1>CONNECTIONS TO SOCIAL MEDIA</h1>
            <?php
            settings_fields("social_config");
            do_settings_sections("_pap_social");
            submit_button();
            ?>
        </form>
    <?php }

    function pap_admin_payment_view()
    { ?>
        <form method="post" action="options.php" id="pap_payment_config_form" class="-pap-settings-form">
            <h1>USE OF PAYMENT SERVICES</h1>
            <?php
            settings_fields("payment_config");
            do_settings_sections("_pap_payment");
            submit_button();
            ?>
        </form>
        <?php
    }



}
$html_ = new HTMLADMIN;
