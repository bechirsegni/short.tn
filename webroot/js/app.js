/**
 * reCAPTCHA Stuff
 */
var captchaShort;
var captchaContact;
var captchaSignup;
var captchaForgotpassword;
var captchaShortlink;

window.onload = function () {

    if (app_vars['captcha_type'] === 'solvemedia') {
        if ($('#captchaShort').length) {
            captchaShort = ACPuzzle.create(
                app_vars['solvemedia_challenge_key'],
                'captchaShort',
                {multi: true, id: 'captchaShort'}
            );
        }

        if ($('#captchaContact').length) {
            captchaSignup = ACPuzzle.create(
                app_vars['solvemedia_challenge_key'],
                'captchaSignup',
                {multi: true, id: 'captchaContact'}
            );
        }

        if ($('#captchaSignup').length) {
            captchaContact = ACPuzzle.create(
                app_vars['solvemedia_challenge_key'],
                'captchaContact',
                {multi: true, id: 'captchaSignup'}
            );
        }

        if ($('#captchaForgotpassword').length) {
            captchaForgotpassword = ACPuzzle.create(
                app_vars['solvemedia_challenge_key'],
                'captchaForgotpassword',
                {multi: true, id: 'captchaForgotpassword'}
            );
        }

        if ($('#captchaShortlink').length) {
            captchaShortlink = ACPuzzle.create(
                app_vars['solvemedia_challenge_key'],
                'captchaShortlink',
                {multi: true, id: 'captchaShortlink'}
            );
        }
    }

};

var onloadRecaptchaCallback = function () {

    if ($('#captchaShort').length) {
        captchaShort = grecaptcha.render('captchaShort', {
            'sitekey': app_vars['reCAPTCHA_site_key']
        });
    }

    if ($('#captchaContact').length) {
        captchaContact = grecaptcha.render('captchaContact', {
            'sitekey': app_vars['reCAPTCHA_site_key']
        });
    }

    if ($('#captchaSignup').length) {
        captchaSignup = grecaptcha.render('captchaSignup', {
            'sitekey': app_vars['reCAPTCHA_site_key']
        });
    }

    if ($('#captchaForgotpassword').length) {
        captchaForgotpassword = grecaptcha.render('captchaForgotpassword', {
            'sitekey': app_vars['reCAPTCHA_site_key']
        });
    }

    if ($('#captchaShortlink').length) {
        captchaShortlink = grecaptcha.render('captchaShortlink', {
            'sitekey': app_vars['reCAPTCHA_site_key'],
            'callback': recaptchaVerifyShortlink
        });
    }

};

var recaptchaVerifyShortlink = function (response) {
    if (response === $('#captchaShortlink .g-recaptcha-response').val()) {
        $('#link-view').submit();
    }
};

$("body").one("focus", "#shorten input#url", function (e) {
    $('#shorten .form-group.captcha').slideDown("slow");
});


$(document).ready(function () {

    var url_href = window.location.href;
    if (url_href.substr(-1) === '#') {
        history.pushState("", document.title, url_href.substr(0, url_href.length - 1));
    }


    var url = window.location.href;
    $('.sidebar-menu a').filter(function () {
        return this.href === url;
        //} ).closest( 'li' ).addClass( 'active' );
    }).parents('.sidebar-menu li').addClass('active');

    function fixHeight() {
        var headerHeight = $("header.main-header").outerHeight();
        $("#frame").attr("height", (($(window).height() - 0) - headerHeight) + 'px');
    }

    $(window).resize(function () {
        fixHeight();
    }).resize();


    function populate_visitors_price() {
        /**
         * Calculate visitors
         */
            // http://stackoverflow.com/a/3087027
        var visitors = 0;
        $('input[id^=campaign-items-][id$=-purchase]').each(function (index, item) {
            var val = $(item).val();
            visitors += val * 1000;
        });
        $("#total-visitors").text(visitors);

        /**
         * Calculate price
         */
        var price = 0;
        $('input[id^=campaign-items-][id$=-advertiser-price]').each(function (index, item) {
            var val = $(item).val();
            price += val * $("#campaign-items-" + index + "-purchase").val();
            ;
        });
        $("#total-price").text(price.toFixed(2).toLocaleString(app_vars['language']));
    }

    populate_visitors_price();

    $("#campaign-create").change(function () {
        populate_visitors_price();
    });

    function shortenButton() {
        var short_box = $('.box-short');
        var short_button = $('button.shorten-button');
        if (jQuery(window).width() <= 767) {
            short_box.css("display", "block");
            short_button.css("display", "none");
        } else {
            short_box.css("display", "none");
            short_button.css("display", "block");
        }
    }

    $(window).resize(function () {
        shortenButton();
    }).resize();

    $('button.shorten-button').click(function (e) {
        e.preventDefault();
        $('.box-short').toggle("fast");
    });

});

$('button.advanced').click(function () {
    $('.advanced-div').toggle("fast");
});

/**
 * Bootstrap 3: Keep selected tab on page refresh
 */
// store the currently selected tab in the localStorage
$('#form-settings a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    var id = $(e.target).attr("href").substr(1);
    localStorage.setItem('settings_selectedTab', id);
});

// on load of the page: switch to the currently selected tab
var selectedTab = localStorage.getItem('settings_selectedTab');

if ($('#form-settings').length && selectedTab !== null) {
    $('#form-settings a[data-toggle="tab"][href="#' + selectedTab + '"]').tab('show');
} else {
    $('#form-settings a[data-toggle="tab"]:first').tab('show');
}


/**
 *  Member Area Shorten
 */
$(".shorten-member #shorten").on("submit", function (e) {
    e.preventDefault();
    var shortenForm = $(this);
    var shortenContainer = shortenForm.closest('.box-short');
    var submitButton = shortenForm.find('button.btn-submit');
    var submitButtoHTML = submitButton.html();

    $.ajax({
        dataType: 'json', // The type of data that you're expecting back from the server.
        type: 'POST', // he HTTP method to use for the request
        url: shortenForm.attr('action'),
        data: shortenForm.serialize(), // Data to be sent to the server.
        beforeSend: function (xhr) {

            submitButton.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin"></i>');
            $('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>').insertAfter(shortenContainer.find('.box-body'));

        },
        success: function (result, status, xhr) {

            if (result.url) {
                var short_url_html = '<div class="form-group"><div class="input-group"><input class="form-control input-lg" value="' + result.url + '" readonly onfocus="javascript:this.select()" ><div class="input-group-addon copy-it" data-clipboard-text="' + result.url + '" data-toggle="tooltip" data-placement="left" title="' + app_vars['copy'] + '"><i class="fa fa-clone"></i></div></div></div>';
                $(".shorten.add-link-result").html(short_url_html).slideDown();
                $('[data-toggle="tooltip"]').tooltip();
            } else {
                var success_message = '<div class="form-group"><p></p><div class="alert alert-danger" role="alert">' + result.message + '</div></div>';
                $(".shorten.add-link-result").html(success_message).slideDown();
                //alert( result.message );
            }

        },
        error: function (xhr, status, error) {

            alert("An error occured: " + xhr.status + " " + xhr.statusText);

        },
        complete: function (xhr, status) {

            shortenContainer.find('.overlay').remove();
            submitButton.removeAttr("disabled").html(submitButtoHTML);

        }
    });
});

/**
 * Home Page Shorten
 */
$(".shorten #shorten").on("submit", function (e) {
    e.preventDefault();
    if (app_vars['user_id'] == '' && app_vars['home_shortening_register'] === 'yes') {
        window.location.href = app_vars['base_url'] + 'auth/signup';
        return;
    }
    var shortenForm = $(this);
    var submitButton = shortenForm.find('button');
    var submitButtoHTML = submitButton.html();

    $.ajax({
        dataType: 'json', // The type of data that you're expecting back from the server.
        type: 'POST', // he HTTP method to use for the request
        url: shortenForm.attr('action'),
        data: shortenForm.serialize(), // Data to be sent to the server.
        beforeSend: function (xhr) {
            submitButton.attr("disabled", "disabled");
            $('<div class="shorten loader"></div>').insertAfter(shortenForm);
        },
        success: function (result, status, xhr) {
            //console.log( result );
            if (result.url) {
                shortenForm.slideUp();
                var short_url_html = '<div class="form-group"><div class="input-group"><input class="form-control input-lg" value="' + result.url + '" readonly onfocus="javascript:this.select()" ><div class="input-group-addon copy-it" data-clipboard-text="' + result.url + '" data-toggle="tooltip" data-placement="bottom" title="' + app_vars['copy'] + '"><i class="fa fa-clone"></i></div><div class="input-group-addon reshort" data-toggle="tooltip" data-placement="bottom" title="Reshort"><i class="fa fa-refresh"></i></div></div></div>';
                $(".shorten.add-link-result").html(short_url_html).slideDown();
            } else {
                shortenForm.slideUp();
                var success_message = '<div class="form-group"><div class="input-group"><input class="form-control input-lg" value="' + result.message + '" readonly ><div class="input-group-addon reshort" data-toggle="tooltip" data-placement="bottom" title="Reshort"><i class="fa fa-refresh"></i></div></div></div>';
                $(".shorten.add-link-result").html(success_message).slideDown();
            }
        },
        error: function (xhr, status, error) {
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        },
        complete: function (xhr, status) {
            $('[data-toggle="tooltip"]').tooltip();
            submitButton.removeAttr("disabled");
            $('.shorten.loader').remove();
            shortenForm[0].reset();
            try{
                grecaptcha.reset(captchaShort);
            } catch(e) {
            }
            try{
                ACPuzzle.reload('captchaShort');
            } catch(e) {
            }
        }
    });
});


$("header.shorten").on('click', '.reshort', function (e) {
    $(".shorten.add-link-result").html('').slideUp();
    $(".shorten #shorten").slideDown();
});

// Tooltip

$('[data-toggle="tooltip"]').tooltip();

// Clipboard

var clipboard = new Clipboard('.copy-it');

clipboard.on('success', function (e) {
    setTooltip(e.trigger, app_vars['copied']);
});

function setTooltip(btn, message) {
    $(btn).attr('data-original-title', message).tooltip('show');
}
