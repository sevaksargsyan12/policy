/*** add helper functions ***/
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};
/*** global variables  ***/
const Modal = `
  <div class="-pap-overlay" id="-pap-result-wrapper">
        <div class="-pap-html-content">
            <span class="-pap-modal-close text-center">
                  <img src="https://img.icons8.com/material/24/000000/close-window.png">
            </span>
            <h6 class="text-center">Text</h6>
            <div id="-pap-rendered-text"></div>
            <h6 class="text-center">Html code</h6>
            <div id="-pap-rendered-html">
                <textarea></textarea>
            </div>
        </div>
  </div>`;
let papObjectToReplace = {
};
/*** functions ***/
function creatObject() {

    let inputs = jQuery('.-pap-header-form form input');
    Array.prototype.forEach.call(inputs,(input)=>{
        input = jQuery(input);
        let name = input.attr('name');
        let val = input.val();
        papObjectToReplace[name] = val;
    });
    let checkBoxes = jQuery('.-pap-body-form-content form input[type="checkbox"]');
    Array.prototype.forEach.call(checkBoxes,(input)=>{
        input = jQuery(input);
        let name = input.attr('name');
        let val = (input.prop('checked'))?input.attr('data-key'):"";
        papObjectToReplace[name] = val;
    });
    return papObjectToReplace;
}

function replaceShortcodes(responseHtml) {
    for(key in creatObject()) {
        responseHtml = responseHtml.replaceAll(`[[${key}]]`,creatObject()[key]);
    };
    return responseHtml;
}

/*** rendering ***/

jQuery(function() {

    /*** generate pap html ***/
    jQuery('.generate-html').on('click',function() {
        let data = {
            'action': 'front_action',
        };
        let responseHtml;

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(MAINJS.ajaxurl, data, function(response) {
            <!-- Modal -->
            jQuery('#myModal').remove();
            jQuery('body').append(Modal);
            response = replaceShortcodes(response);
            jQuery('#-pap-rendered-text').append(response);
            jQuery('#-pap-rendered-html textarea').html(`${response}`.toString());
        });
    });

    /*** pap events ***/
    jQuery(document).on('click','.-pap-modal-close',function() {
        jQuery('#-pap-result-wrapper').remove();
    })
});