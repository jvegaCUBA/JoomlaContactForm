/*
# mod_gdh_contact - Ajax based contact Module by Jorge Vega
# ------------------------------------------------------------------------
# Author    Jorge Vega jvega.perez86@gmail.com
# Copyright (C) 2015 Jorge Vega. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

(function ($) {
    $(document).ready(function() {

        $('#gdh-contact-form').submit(function() {
            var value   = $(this).serializeArray(),
            request = {
                'option' : 'com_ajax',
                'module' : 'gdh_contact',
                'data'   : value,
                'format' : 'jsonp'
            };
            $.ajax({
                type   : 'POST',
                data   : request,
                beforeSend: function(){
                    $('#gdh_qc_submit').after('<p class="gdh_qc_loading"></p>');
                },
                success: function (response) {
                    var htmlNotice = response;

                    try {
                        var jsonResponse = $.parseJSON(response);
                        $('#name').val(jsonResponse.nameCaption);
                        $('#email').val(jsonResponse.emailCaption);
                        $('#subject').val(jsonResponse.subjectCaption);
                        $('#message').val(jsonResponse.messageCaption);
                        $('#capt_token').val(jsonResponse.newCaptchaToken);
                        var $captchaField = $('#captcha');
                        $captchaField.val('');
                        $captchaField.attr("placeholder", jsonResponse.newCaptcha);

                        htmlNotice = jsonResponse.successNotice;
                    } catch (error) { }

                    $('#gdh_qc_status').hide().html(htmlNotice).fadeIn().delay(2000).fadeOut(500);
                    $('.gdh_qc_loading').fadeOut(function(){
                        $(this).remove();
                    });
                }
            });
            return false;
        });

    });
})(jQuery);