
jQuery(function(){

    /** general config **/

    jQuery('#pap_general_config_form #submit').on('click',function(e) {

        let checkBoxes = jQuery('#pap_general_config_form input[type="checkbox"]');
        let formstate = jQuery('.-pap-general_config_state input[type="hidden"]');
        checkFormState(checkBoxes,formstate);
    });

    /** website config **/

    jQuery('#pap_website_config_form #submit').on('click',function(e) {

        let checkBoxes = jQuery('#pap_website_config_form input[type="checkbox"]');
        let formstate = jQuery('.-pap-website_config_state input[type="hidden"]');
        checkFormState(checkBoxes,formstate);
    });

    /** social config **/

    jQuery('#pap_social_config_form #submit').on('click',function(e) {

        let checkBoxes = jQuery('#pap_social_config_form input[type="checkbox"]');
        let formstate = jQuery('.-pap-social_config_state input[type="hidden"]');
        checkFormState(checkBoxes,formstate);
    });
    /** social config **/

    jQuery('#pap_payment_config_form #submit').on('click',function(e) {

        let checkBoxes = jQuery('#pap_payment_config_form input[type="checkbox"]');
        let formstate = jQuery('.-pap-payment_config_state input[type="hidden"]');
        checkFormState(checkBoxes,formstate);
    });

    /*** generate shortcode ***/

    jQuery('.gen-shortcode').on('click',function() {
        var data = {
            'action': 'admin_shortcode_action'
        };
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.-pap-content').html(response);
        });
    })
});


/*** helpers ***/
function checkFormState(checkBoxes,formstate) {
    let isExistValue = false;
    Array.prototype.forEach.call(checkBoxes,(item) => {
        item = jQuery(item);
        isExistValue = isExistValue || item.prop('checked');
        if(isExistValue) return;
    });
    !isExistValue? formstate.val('0'):formstate.val('1');
}

