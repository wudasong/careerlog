/// <reference path="jquery-1.6.2-vsdoc.js" />
var $c = {

    // Initialize the site 
    init: function () {
        $('form').placeholder({
            force: false
        });

        $.ajaxSetup({
            type: 'post',
            dataType: 'json',
            data: { ajax: true },
            error: function (jqXHR, textStatus, errorThrown) {
                //alert(textStatus);
            }
        });

        Login.init();
        Register.init();
        Publisher.init();
    },

    // Set the cookie with JavaScript
    setCookie: function (name, value) {
        var today = new Date();
        var expires = new Date();
        expires.setTime(today.getTime() + 1000 * 60 * 60 * 24 * 1000);
        document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString();
    },

    // Get the cookie with JavaScript
    getCookie: function (cookieName) {
        var search = cookieName + "=";
        if (document.cookie.length > 0) {
            offset = document.cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = document.cookie.indexOf(";", offset);
                if (end == -1) {
                    end = document.cookie.length;
                }
                return unescape(document.cookie.substring(offset, end));
            } else {
                return ("");
            }
        } else {
            return ("");
        }
    },

    // Remove the cookie with JavaScript
    removeCookie: function (cookieName) {
        var today = new Date();
        var expires = new Date();
        expires.setTime(today.getTime() - 1000 * 60 * 30);
        document.cookie = cookieName + "=; expires=" + expires.toGMTString();
    },

    // Set the htmlElementId display the ajaxLoading img
    setAjaxLoading: function (htmlElementId) {
        var absoluteLoadingImgUrl = this.getSiteUrl();
        absoluteLoadingImgUrl = absoluteLoadingImgUrl + "/Styles/i/indicator_arrows_circle.gif";
        if ($(htmlElementId) != null) {
            $(htmlElementId).html("<img src=\"" + absoluteLoadingImgUrl + "\" /><span style=\"color:#AAA;\"> Loading...</span>");
        }
    },

    // Judge if the string s is email address 
    isEmailAddress: function (s) {
        var patrn = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (!patrn.exec(s))
            return false;
        return true;
    },

    // Is date
    isDate: function (s) {
        var patrn = /^\d{4}-\d{2}-\d{2}$/;
        if (!patrn.exec(s))
            return false;
        return true;
    },

    // Judge if the string s is string 
    isCharString: function (s) {
        var patrn = /^[A-Za-z0-9]+$/;
        if (!patrn.exec(s))
            return false;
        return true;
    },

    // is integer
    isInteger: function (s) {
        var patrn = /^\d+$/;
        if (!patrn.exec(s))
            return false;
        return true;
    },

    // is plus float  
    isPlusFloat: function (s) {
        var patrn = /^\d+(\.\d+)?$/;
        if (!patrn.exec(s))
            return false;
        return true;
    },

    // Count the char counts in str
    countCharCounts: function (str, tchar) {
        var reg = new RegExp(tchar, "g")
        var count = str.match(reg);
        if (count != null)
            return count.length;
        else
            return 0;
    },

    // Extracts the link from the string
    extractLink: function (str) {
        var re = /(http:\/\/)?([A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*)/g;
        var content = 'link';
        str = str.replace(re, function (a, b, c) {
            return '[<a href="http://' + c + '" target="_blank">' + content + '</a>]';
        });
        return str;
    },

    // Submits the form data by ajax
    submitAjaxForm: function (el, callback) {
        var postData = $(el).serialize() + '&ajax=true';
        var url = $(el).attr('action');
        $.ajax({
            url: url,
            data: postData,
            success: callback
        });
    }
}



// Publisher functions
var Publisher = {
    init: function () {

        if (View == null || View != 'site/index')
            return;

        this.getLatestPosts();

        $("#publisher input[name='date']").datepicker({
            "dateFormat": "yy-mm-dd",
            beforeShow: function (input, inst) {
                //alert('ok');
            }
        });

        $("#publisher ul.dropdown-menu li a").click(function () {
            $("#publisher #category").html($(this).html());
            $("#publisher input[name='category']").val($(this).parent().attr('dt'));
            $("#publisher ul.dropdown-menu li").removeClass('selected');
            $(this).parent().addClass('selected');
        });

        $("div.item a.remove").live("click", function () {

            if (!confirm(txt_confirm_to_delete_item))
                return;

            var myObj = $(this);
            var postId = myObj.parent().attr("pi");
            $.ajax({
                url: '/post/delete',
                data: { id: postId },
                success: function (ret) {
                    myObj.parent().remove();
                }
            });
        });

        $("div.todo input[type='checkbox']").live("change", function () {

            var hasCompleted = this.checked;
            var myObj = $(this);
            var postId = myObj.parent().attr("pi");
            $.ajax({
                url: '/post/complete',
                data: { id: postId, complete: hasCompleted },
                success: function (ret) {
                    //myObj.parent().remove();
                }
            });
        });

        $("#publisher").submit(function () {
            Publisher.submitPublisherForm();
            return false;
        });
    },

    // Submits the publisher form data to server
    submitPublisherForm: function () {
        var date = $("#publisher input[name='date']").val();
        var cnode = $("#publisher input[name='content']");
        var content = cnode.val();

        if (!$c.isDate(date)) {
            alert(txt_invalid_date_format);
            return false;
        }

        if ($.trim(content) == '') {
            cnode.addClass("error");
            setTimeout(function () {
                cnode.removeClass("error");
            }, 200);
            return false;
        }

        $("#publisher input[type='submit']").attr('disabled', 'true');
        $c.submitAjaxForm($('#publisher'), function (ret) {
            $("#publisher input[type='submit']").removeAttr('disabled');
            cnode.val("");
            Publisher.getLatestPosts();
            //var set = $.parseJSON(ret.setting);
            //alert(set.complete);
        });
    },

    // Get latest posts
    getLatestPosts: function () {
        $.ajax({
            url: '/post/index',
            success: function (posts) {
                if (posts == null)
                    return;
                var cdate = '';
                var pe = $("#posts");
                pe.html("");
                for (i = 0; i < posts.length; i++) {
                    var p = posts[i];
                    if (cdate != p.create_date.substr(0, 10)) {
                        cdate = p.create_date.substr(0, 10);
                        var html = '<h2>' + cdate + '</h2>' +
                                    '<div dt="' + cdate + '" class="well">' +
                                    ' <div class="todo"></div>' +
                                    ' <div class="note"></div>' +
                                    ' <div class="read"></div>' +
                                    ' <div class="idea"></div>' +
                                    '</div>';
                        pe.append(html);
                    }

                    Publisher.renderItemHtml(p);
                }
            }
        });
    },

    // Render the post to Html
    renderItemHtml: function (p) {
        var pe = $("#posts");
        var cdate = p.create_date.substr(0, 10);
        var ce = pe.find('div[dt="' + cdate + '"]').find('div.' + p.category.toLowerCase());
        if (ce.find('h3').length == 0) {
            ce.append('<h3>' + p.category + '</h3><div class="c"></div>');
        }

        var html = '<div pi="' + p.id + '" class="item">';

        if (p.category == 'Todo') {
            var setting = $.parseJSON(p.setting);
            var checked = setting.complete == "true" ? 'checked="true"' : '';
            html += '<input ' + checked + ' type="checkbox" > ' + p.content;
        }

        if (p.category == 'Note') {
            html += p.content;
        }

        if (p.category == 'Read') {
            var str = $c.extractLink(p.content);
            html += str;
        }

        if (p.category == 'Idea') {
            html += p.content;
        }

        html += '<a class="remove">x</a></div>';

        ce.find('div.c').append(html);
    }

}

// Login functions
var Login = {
    init: function () {

        if (View == null || View != 'site/login')
            return;

        $('#login-form').live('submit', function () {
            var valid = true;
            $(this).find('input').each(function () {
                if ($(this).val() == '') {
                    $(this).parent('div').addClass('error');
                    valid = false;
                }
            });
            return valid;
        });

        $('#login-form input').focus(function () {
            $(this).parent('div').removeClass('error');
        });

        $('#reset-password').click(function () {
            $('#reset-password-modal').modal('show')
        });
    }
}

// Register functions
var Register = {
    usernameValid: false,
    emailValid: false,
    passwordValid: false,
    init: function () {

        if (View == null || View != 'site/register')
            return;
        /*
        $('a.register').click(function () {
        $('#register-modal').modal('show')
        });
        */
        $('#reg-form input[type=text],#reg-form input[type=password]').each(function () {
            $(this).attr('value', '');
        });
        $('#reg-form input[tabindex=1]').focus();

        $('#reg-form').live('submit', function () {
            return Register.submitRegisterForm();
        });

        $('#reg-form input').bind('keydown', function (e) {
            var key = e.which;
            var el = $(this);
            if (key == 13) {
                e.preventDefault();
                var nextTabindex = el.attr('tabindex') + 1;
                $('#reg-form input[tabindex=' + nextTabindex + ']').focus();
            }
        });

        $('#reg-form input').focus(function () {
            var el = $(this);
            var elp = el.parent('div');
            elp.parent('div').removeClass('error');
            el.next('.help-inline').remove();
        });

        $('#reg-form input').focusout(function () {
            var el = $(this);
            Register.fieldValidation(el);
        });
    },

    // validate the field
    fieldValidation: function (el) {
        var elp = el.parent('div');
        var ival = el.val();
        if ($.trim(ival) == '') {
            elp.parent('div').addClass('error');
            return;
        }

        var iname = el.attr('name');
        var error_message = '';
        if (iname == 'username') {
            var patrn = /^[A-Za-z0-9.]+$/;
            if (!patrn.exec(ival))
                error_message = txt_invalid_username_format;
            else if (ival.length < 5)
                error_message = txt_invalid_username_length;
            else {
                elp.append('<span class="help-inline"><img src="/img/min-loading.gif" /></span>');
                $.ajax({
                    url: '/user/check',
                    data: { username: ival, check: true },
                    success: function (ret) {
                        if (ret.isvalid) {
                            elp.find('img').attr('src', '/img/right.png');
                            Register.usernameValid = true;
                        }
                        else {
                            elp.parent('div').addClass('error');
                            elp.find('span').html('* ' + ret.error);
                            Register.usernameValid = false;
                        }
                    }
                });
            }
        }

        if (iname == 'password') {
            if (ival.length < 6)
                error_message = txt_invalid_password_length;
        }


        if (iname == 'password2') {
            if ($('#reg-form input[name=password]').val() != ival) {
                error_message = txt_passwords_not_matched;
                Register.passwordValid = false;
            }
            else
                Register.passwordValid = true;
        }

        if (iname == 'email') {
            if (!$c.isEmailAddress(ival)) {
                error_message = txt_invalid_email;
            }
            else {
                elp.append('<span class="help-inline"><img src="/img/min-loading.gif" /></span>');
                $.ajax({
                    url: '/user/check',
                    data: { email: ival, check: true },
                    success: function (ret) {
                        if (ret.isvalid) {
                            elp.find('img').attr('src', '/img/right.png');
                            Register.emailValid = true;
                        }
                        else {
                            elp.parent('div').addClass('error');
                            elp.find('span').html('* ' + ret.error);
                            Register.emailValid = false;
                        }
                    }
                });
            }
        }

        if (error_message != '') {
            elp.parent('div').addClass('error');
            elp.append('<span class="help-inline">* ' + error_message + '</span>');
        }
    },

    submitRegisterForm: function () {
        var valid = true;
        $('#reg-form').find('input').each(function () {
            if ($(this).val() == '') {
                $(this).parent('div').parent('div').addClass('error');
                valid = false;
            }
        });

        if (!valid || !Register.usernameValid || !Register.passwordValid || !Register.emailValid)
            return false;

        $('#reg-submit').attr('disabled', 'true');
        $c.submitAjaxForm($('#reg-form'), function (ret) {
            $('#reg-submit').removeAttr('disabled');
            if (ret.errors != null) {
                if (ret.errors.username != null) {
                    var el = $('#reg-form input[name=username]');
                    var elp = el.parent('div');
                    elp.append('<div class="help-inline error">* ' + ret.errors.username + '</div>');
                }

                if (ret.errors.email != null) {
                    var el = $('#reg-form input[name=email]');
                    var elp = el.parent('div');
                    elp.append('<div class="help-inline error">* ' + ret.errors.email + '</div>');
                }
            }
        });
    }
}

$(document).ready(function () {
    $c.init();
});

