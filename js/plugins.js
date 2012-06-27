/// <reference path="jquery-1.6.2-vsdoc.js" />

/**
 * jquery.placeholder.fix.js
 * @author: kidh0
 * @version: 1.0
 * @update: Dasong 
 */
(function ($) {
    $.fn.placeholder = function (options) {
        var opts = $.extend({}, $.fn.placeholder.defaults, options);
        var support = true;
        //have placeholder support?
        //create a new input and check if has placeholder attribute
        elem = document.createElement('input');
        if (elem.placeholder == undefined) {
            support = false;
        }

        //if there is no support to placeholder attribute, 
        //or force option true apply the fix
        if (!support || opts.force) {
            return $('[placeholder]', this).each(function () {
                //on the focus event, clean the placeholder value
                //if is blank, turn the placeholder on again
                $(this).focus(function () {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                        input.removeClass('placeholder');
                    }
                }).blur(function () {
                    var input = $(this);
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.addClass('placeholder');
                        input.val(input.attr('placeholder'));
                    }
                }).blur();

                //fix to avoid to send the placeholder as an input value
                $(this).parents('form').submit(function () {
                    $(this).find('[placeholder]').each(function () {
                        var input = $(this);
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    })
                });
            });
        }
    };

    $.fn.placeholder.defaults = {
        force: false //force to use plugin placeholder
    };

})(jQuery);


