jQuery(document).on('gform_post_render', function () {


});

jQuery(document).on("mouseenter", ".gform_footer i", function () {
    jQuery(this).closest("#gform_18").find("#gform_submit_button_18").addClass("hovered");
});

jQuery(document).on("mouseleave", ".gform_footer i", function () {
    jQuery(this).closest("#gform_18").find("#gform_submit_button_18").removeClass("hovered");
});

jQuery(document).ready(function ($) {

    var coll = document.getElementsByClassName("question");
    var i;

    for (i = 0; i < coll.length; i++) {
        console.log('this');
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            console.log(this);
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {

                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
    $(function(){
        var current = location.pathname;
        $('.dashboard-sidebar li a').each(function(){
            var $this = $(this);
            console.log($this.attr('href').indexOf(current));
            // if the current path is like this link, make it active
            if($this.attr('href').indexOf(current) !== -1){
                $this.closest('li').addClass('active');
            }
        })
    })

    // $('.landing_faq .question').on('click', function(event) {
    //   // if(jQuery(this).parent().hasClass('open')){
    //   //   // jQuery(this).parent().find('.answer').hide(300);
    //   //   jQuery(this).parent().removeClass('open');
    //   // } else {
    //   //   // jQuery('.faq_item.open').find('.answer').hide(300);
    //   //   // jQuery('.faq_item.open').removeClass('open');
    //   //   // jQuery(this).parent().find('.answer').show(300);
    //   //   //var content = this.nextElementSibling;
    //   //   if ($(this).find('.answer')){
    //   //     content.style.maxHeight = null;
    //   //   } else {
    //   //     content.style.maxHeight = content.scrollHeight + "px";
    //   //   }
    //   //   jQuery(this).parent().addClass('open');
    //   //}
    //
    // });
    $('a[href^="#"]').on('click', function (event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - $('#main_header').height()
            }, 1000);
        }
    });
    //$(".freelancer-bidding").find(".publish").eq(0).find(".new").css("top","22px");

    $("#gform_wrapper_18 .gform_footer").append("<i class='fa fa-sign-out'></i>");
    $("#gform_wrapper_11 .gform_footer").append("<i class='fa fa-sign-out'></i>");
    $("#gform_wrapper_21 .gform_footer").append("<i class='fa fa-sign-out'></i>");
    $("#field_18_1 .gfield_list_1_cell1 input").attr('placeholder', 'https://forbes.com');
    $("#gform_wrapper_18 .gform_footer").append("<span class='cm-send-note'>By clicking 'Submit', you agree and understand that you will not get paid for this job and that the client will be refunded their payment.</span>");

    $("#field_18_3 i").click(function () {
        $(this).closest("#gform_18").find(".tooltip-text").slideToggle();
    });

    $("body").on("click", ".inquire-button:not(.messaged)", function () {
        $(this).closest(".project-footer-bar").find("#gform_wrapper_18").slideToggle();
        $("#gform_wrapper_11").slideToggle();
        $('.inquire_overlay').slideToggle(0);
    });
    $("body").on("click", ".inquire_overlay", function () {
        $("body").find("#gform_wrapper_18:visible").slideToggle();
        $("#gform_wrapper_11:visible").slideToggle();
        $('.inquire_overlay').slideToggle(0);
    });

    //  $("body").on("click", ".inquire-button", function () {
    //     $("#gform_wrapper_11").slideToggle();
    //     $('.inquire_overlay').slideToggle(0);
    //     // $('.inquire_overlay').css('display', 'block');
    // });
    // $("body").on("click", ".inquire_overlay", function () {
    //     console.log(1);
    //     $("#gform_wrapper_11:visible").slideToggle();
    //     $('.inquire_overlay').slideToggle(0);
    // });

    // Document on facetwp-refresh
    $(document).on('facetwp-loaded', function () {
        var hasIcon = $("#gform_wrapper_18 .gform_footer").find('.fa-sign-out').length;
        if (!hasIcon) {
            $("#gform_wrapper_18 .gform_footer").append("<i class='fa fa-sign-out'></i>");
            $("#field_18_1 .gfield_list_1_cell1 input").attr('placeholder', 'https://forbes.com');
            $("#gform_wrapper_18 .gform_footer").append("<span class='cm-send-note'>By clicking 'Submit', you agree and understand that you will not get paid for this job and that the client will be refunded their payment.</span>");
        }
    });

    $("#input_2_6").attr("type", "url");
    $("#input_2_8").attr("type", "url");
    $("#input_2_9").attr("type", "url");


    $('#loginform input[type="text"]').attr('placeholder', 'Email');
    $('#loginform input[type="password"]').attr('placeholder', 'Password');
    $('#loginform input[type="submit"]').val('Log in');

    var remember_me_text = $('#loginform .login-remember label').html();
    if (remember_me_text) {
        $('#loginform .login-remember label').html(remember_me_text.replace(" Remember Me", " Remember me"));
    }

    $('.fre-authen-lost-pass h2').text('Reset your password');
    $('#forgot_form .fre-submit-btn').val('Send password reset');
    $('.fre-authen-footer a').text('Log in');

    if (($(window).width() > 767) && $('body').hasClass('page-template-page-reset-pass') ||
        ($(window).width() > 767) && $('body').hasClass('page-id-543')) {
        header_footer_height = $('.fre-header-wrapper').outerHeight() + $('.copyright-wrapper').outerHeight();
        console.log($('.fre-header-wrapper').outerHeight());
        console.log($('.copyright-wrapper').outerHeight());
        $('.fre-page-wrapper').css('min-height', 'calc(100% - ' + header_footer_height + 'px)');
    }

    $(window).resize(function () {
        eliteAuthorsLogosMobile();

        if (($(window).width() > 767) && $('body').hasClass('page-template-page-reset-pass') ||
            ($(window).width() > 767) && $('body').hasClass('page-id-543')) {
            header_footer_height = $('.fre-header-wrapper').outerHeight() + $('.copyright-wrapper').outerHeight();
            console.log($('.fre-header-wrapper').outerHeight());
            console.log($('.copyright-wrapper').outerHeight());
            $('.fre-page-wrapper').css('min-height', 'calc(100% - ' + header_footer_height + 'px)');
        }
    });

    function eliteAuthorsLogosMobile() {
        console.log(111111);
        var checkWidth = $(window).width();
        var eliteAuthorsLogos = $(".elite-authors-logos-wrap");
        if (checkWidth > 1023) {
            eliteAuthorsLogos.trigger('destroy.owl.carousel');
            eliteAuthorsLogos.removeClass('owl-carousel owl-theme');
        } else {
            eliteAuthorsLogos.addClass('owl-carousel owl-theme');
            eliteAuthorsLogos.owlCarousel({
                center: false,
                stagePadding: 0,
                items: 2,
                loop: true,
                margin: 10,
                 responsiveClass:true,
                itemsMobile : true,
                stagePadding: 30,
                 responsive:{
                     991:{
                         items: 2
                     }
                 }
            })
        }
    }

    eliteAuthorsLogosMobile();

    // if (($(window).width() >= 600) && ($(window).width() <= 768)) {
    //     $(".dashboard-sidebar i").click(function () {
    //         event.preventDefault();

    //         $(".dashboard-sidebar.slide-in").slideToggle();
    //     });
    // }
    $(".expires a").click(function () {
        $(this).closest(".url-expires-wrapper").find("#gform_wrapper_21").slideToggle();
    })

    $("#gform_submit_button_16").after('<i class="fas fa-arrow-circle-right"></i>');

    $("#field_15_5").each(function () {
        var footer = $(this).parent().parent().parent().find(".gform_footer");
        $(this).insertAfter(footer);
    })
    //wista
    $(".dashabord .wistia_responsive_padding").wrapAll("<div class='wista-container'></div>");

    //preview project link
    var previewText = $("#field_3_11").text();
    $("#field_3_18").after("<div class='preview-project'><label class='gfield_label'>Check it out! Here's how our authors will see your project: <i class='fa fa-question-circle'></i><div class='list-item'><div class='gfield_description preview'>" + previewText + "</div></div></div></label><div class='click-preview'><u><a href='#' data-featherlight='#mylightbox'>Preview your project</a></u></div>");

    //when owner clicks to preview listing
    $(".click-preview a").click(function () {

        //title
        var projTitle = $("#input_3_10").val();
        $(".my-proj-title").text(projTitle);

        //category
        var projCat = $('#input_3_3').find(":selected").text();
        console.log(projCat);
        $(".cat-name").text(projCat);

        //description
        var projDesc = $("#input_3_7").val();
        $(".project-description.description span").text(projDesc);

        //ideas
        var projIdeas = $("#input_3_8").val();
        $(".project-description.linkable-ideas span").text(projIdeas);

        //attribute
        var projAttribute = $("input[name=input_6]:checked").next().text();
        var projAttributeVal = $("input[name=input_6]:checked").val();

        //domains
        var projDomains = $("#input_3_15").val();
        $(".project-description.backlink-on span").text(projDomains);

        if (projAttributeVal == 191) {
            $(".project-description.link-attribute span span").text("NoFollow or DoFollow");
        } else {
            $(".project-description.link-attribute span span").text(projAttribute);

        }

        //check if author wants to publicly display URL
        var showURL = $("#choice_3_12_1:checked");
        console.log(showURL);

        //show URL
        var siteURL = $("#input_3_9").val();
        $(".project-description.owner-url span span").text(siteURL);

        if (showURL.length === 0) {

            $(".project-description.owner-url").show();

        }

        if (showURL.length !== 0) {
            $(".project-description.owner-url").hide();

        }

    });

    $("#field_5_5").addClass("exclude");

    //click to view link
    $(".view-link").click(function () {
        $(this).parent().parent().parent().find(".final-link-text").slideToggle();
    });

    //add cancel to owner delete form
    $("#gform_14 .gform_footer").append("<a class='cancel-cancel'>No</a><div class='line-break'></div><div class='delete-explanation'>Deleting a project simply <strong>unpublishes</strong> your project’s listing on Link-able so that no new authors can view or apply to it. However, all applications you have previously received will remain active and unaffected.</div>");


    $("#gform_14 .cancel-cancel").click(function () {
        //$(this).parent().parent().parent().slideToggle();
    });

    $("#gform_15 .cancel-cancel").click(function () {
        $(this).closest("#gform_wrapper_15").slideToggle();
    });

    $("#gform_15 .gform_footer").append("<a class='cancel-cancel'>No</a><div class='line-break'></div><div class='delete-explanation'>Declining a contract <strong>permanently hides</strong> it so that you will never see it again and sends a notification to the author that their contract has been declined. This action cannot be undone so make sure you really don’t want this link! </div>");


    $("#gform_15 .cancel-cancel").click(function () {
        $(this).closest(".gform_wrapper").slideUp();
    });

    jQuery('#gform_4 form').submit(function () {
        console.log("submitted");
        jQuery('input').prop('disabled', false);
    });

    //dynamic placeholder text for completion form
    var lastChar = $(".proposed-url").text().substr(-1);
    //console.log(lastChar);
    if (lastChar == '/') {
        var proposedURL = $(".proposed-url").text() + 'my-published-article-url';
    } else {
        var proposedURL = $(".proposed-url").text() + '/my-published-article-url';
    }
    $("#input_6_4").attr("placeholder", proposedURL);

    $("#menu-item-613 a").append('<i class="fa fa-sign-out"></i>');

    //replace gravatar on notifications page
    $(".page-template-page-list-notification .page-notification-wrap .notify-avatar img").hide();
    $(".page-template-page-list-notification .page-notification-wrap .notify-avatar").prepend("<i class='fa fa-exclamation-circle'></i>");

    /* show sub menu on hover */
    $("#menu-linkable-main-nav .sub-menu").prepend("<span class='up-arrow'></span>");

    /*$("#menu-linkable-main-nav > li").hover( function(){
            $("#menu-item-607 .sub-menu").slideToggle();
            }
    );*/

    /* add quotation behind testimonial name */
    $(".testimonial_rotator_author_info").append('<i class="fa fa-quote-right"></i>');

    /* open verification toggle */
    $(".add-new-website").click(function () {
        $(".verify-form").slideToggle();
    });

    /*toggle faq q&a sections*/
    $(".web-owners").click(function () {
        $(".content-author").removeClass("active");
        $(".web-owner").addClass("active");
        $(".website-owner-qa").css("display", "block");
        $(".content-author-qa").css("display", "none");
    });

    $(".content-author").click(function () {
        $(".content-author").addClass("active");
        $(".web-owner").removeClass("active");
        $(".website-owner-qa").css("display", "none");
        $(".content-author-qa").css("display", "block");
    });

    //add footer gray bar if logged in
    $(".logged-in .copyright-wrapper").prepend("<div class='footer-gray-bar'></div>");

    //tooltips for apply to project form

    $("#gform_4 .gfield_description").each(function () {
        $(this).prev().before(this);
    })


    //what domain will your link be on
    $("#field_4_1 label").append("<i class='fa fa-question-circle'></i>");
    $("#field_4_19 label").append("<i class='fa fa-question-circle'></i>");
    $("#field_21_1 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_4_21 label").append("<i class='fa fa-question-circle'></i>");

    //the link will be a
    $("#field_4_2 > label").append("<i class='fa fa-question-circle'></i>");

    //how long will it take to publish this link
    $("#field_4_3 > label").append("<i class='fa fa-question-circle'></i>");

    //how long will it take to publish this link
    $("#field_4_4 > label").append("<i class='fa fa-question-circle'></i>");

    //tooltips for post a project form
    //url of the page you want to build a link to
    $("#field_3_9 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_3_12 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_3_18 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_4_20 label").append("<i class='fa fa-question-circle'></i><div class='list-item'></div>");

    //category
    $("#field_3_3 label,#field_3_10 label,#field_3_1 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    //description
    $("#field_3_7 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    //linakble ideas
    $("#field_3_8 label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    //the link will be (follow type)
    $("#field_3_6 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_3_14 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_3_15 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_3_16 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    // Legend
    $("#field_3_1000 legend").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    $("#field_17_1 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");
    $("#field_17_2 > label").append(" <i class='fa fa-question-circle'></i><div class='list-item'></div>");

    //insert gravity form descriptions as tooltips
    var tooltipParent = jQuery(this).parent().find('.list-item');
    jQuery(".gform_wrapper:not('.gform_validation_error') .gfield_description").each(function () {
        jQuery(this).prependTo(jQuery(this).parent().find('.list-item'));

    });


    $("#field_21_1 .fa").click(function () {
        $(this).closest(".gfield").find(".list-item").slideToggle();
    });
    $("#field_4_20 .fa").click(function () {
        $(this).closest(".gfield").find(".list-item").slideToggle();
    });

    //expand project workroom question tooltips
    $(".single-bid i.fa-question-circle").click(function () {
        $(this).next().slideToggle();
    });
    $(".page-template-page-linkable-post-project i.fa-question-circle").click(function () {
        $(this).next().slideToggle();
    });
    $("#field_3_12 i.fa-question-circle").click(function () {
        $("#field_3_12").find(".list-item").slideToggle();
    });

    $("a.how-calc").click(function () {
        $(this).parent().next().slideToggle();
    });

    $(".question-mark").click(function () {
        $(this).parent().parent().parent().find(".list-item.expand-me").slideToggle();
    })
    $("#gform_page_17_1 .fa-question-circle").click(function () {
        $(this).next().slideToggle();
    });

    $(".gfield_list_1_cell2 select").on('change', function () {

        console.log($(this).val());
    })


});

jQuery.validator.addMethod("notEqualTo", function (value, element, param) {
    return this.optional(element) || value != param;
}, 'this Field is Required');

jQuery(window).load(function () {

    jQuery(".project-item").each(function () {
        var gForm = jQuery(this).find("#gform_submit_button_18");
        jQuery(gForm).prop("disabled", true);
    });
    /*
    jQuery('.inquiry_message textarea').on('keyup', function(e){
        var $form = jQuery(this).closest('form');
        var $button = $form.find('#gform_submit_button_18');
        if( "" !== jQuery(this).val() ){
            var checkEmail = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/g;
            if( checkEmail.test( jQuery(this).val() ) ) {
                $button.prop('disabled', true);
            } else {
                $button.prop('disabled', false);
            }
        } else {
            $button.prop('disabled', true);
        }
    });
     */
    // Checking inquiry form
    inquiry_message_checker('.inquiry_message textarea', '#gform_submit_button_18');
    // Checking message reply form
    inquiry_message_checker('#la_reply_msg', '.reply_button');

    jQuery(".gfield_list_1_cell2").each(function () {
        jQuery(this).find('select option:first-child').val("");
    });

    jQuery(".gform_body").each(function () {
        //console.log(this);
        //jQuery(this).find("#field_18_1").append("<div class='add-line-button'><a>+ add another</a></div>");
    })

    jQuery("#field_3_12 .list-item").appendTo("#field_3_12");
    jQuery("#field_3_12 .list-item:nth-child(3)").remove();


    jQuery("#gform_confirmation_wrapper_4").parent().addClass("form-submitted");
    jQuery(".gchoice_14_7_1").click(function () {
        jQuery(".gform_wrapper").hide();
    });


    jQuery("#field_18_1 .gfield_list_1_cell1 input").prop("required", true);
    //jQuery("#field_18_1 .gfield_list_1_cell2 select option:first-child").attr("disabled",true);


    jQuery(".add-line-button").click(function () {
        console.log('clicked');
        jQuery(this).closest("#gform_fields_18").find("table tbody tr td .add_list_item ").trigger('click');
    })

    var formBidID = jQuery(".form-bid-id").text();
    jQuery("#input_11_2").val(formBidID);
    jQuery(".form-disabled_wrapper").css("visibility", "visible");
    jQuery("#gform_wrapper_14").hide();
    jQuery("#gform_wrapper_15").hide();

    if ((jQuery(".price-value").text() !== '$0') && (!jQuery(".validation_error"))) {
        jQuery(".price-calc").css("display", "block");
    }

    jQuery("#loginform").append("<div class='forgot-password'><a href='/forgot-password/'>Forgot password?</a></div>");

    jQuery(".reset-application").click(function () {
        window.location = window.location.href.split('#')[0]
    });

    jQuery("#gform_submit_button_17").click(function () {
        window.location = window.location.href.split('#')[0]
    });

    /*home video hover*/
    jQuery(".home .wistia_click_to_play img").mouseenter(function () {
        var imageURL = globalObject.wpURL + "/images/link-able-intro-video-hover.png";
        jQuery(this).attr("src", imageURL);
    });

    jQuery(".home .wistia_click_to_play img").mouseleave(function () {
        jQuery(this).attr("src", globalObject.wpURL + "/images/link-able-intro-video.png");
    });

    /*landing video hover*/
    jQuery(".page-template-page-linkable-landing .wistia_click_to_play img").mouseenter(function () {
        jQuery(this).attr("src", globalObject.wpURL + "/images/link-able-how-it-works-video-hover.png");
    });

    jQuery(".page-template-page-linkable-landing .wistia_click_to_play img").mouseleave(function () {
        jQuery(this).attr("src", globalObject.wpURL + "/images/link-able-how-it-works-video.png");
    });

    //make gray bar same size as sidebar
    jQuery(".footer-gray-bar").css({
        'width': (jQuery(".dashboard-sidebar").outerWidth() + 'px')
    });
    jQuery("#loginform .login-remember").insertAfter("#loginform .login-submit");


});


window.addEventListener("load", function () {
    setTimeout(otherOperation, 1000);
}, false);

function otherOperation() {
    jQuery(".home video").attr("data-matomo-title", "Homepage video");
    jQuery(".home video").addClass("wistia-data-title");
    jQuery(".page-id-976 video").attr("data-matomo-title", "Content marketer landing page");
    jQuery(".page-id-978 video").attr("data-matomo-title", "Content author landing page");
}


function inquiry_message_checker(textarea, btn) {
    jQuery(textarea).on('keyup', function (e) {
        var $form = jQuery(this).closest('form');
        var $button = $form.find(btn);
        var txt = jQuery(this).val();
        var txt = txt.toLowerCase();
        if ("" !== txt) {
            var checkEmail = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/g;
            if (checkEmail.test(txt) || 'email' == txt || 'paypal' == txt) {
                $button.prop('disabled', true);
            } else {
                $button.prop('disabled', false);
            }
        } else {
            $button.prop('disabled', true);
        }
    });
}

(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    };
    $(document).ready(function () {
        // Restrict input to digits by using a regular expression filter.
        $("#input_4_20").inputFilter(function (value) {
            return /^\d*$/.test(value);
        });
        $('.freelancer-bidding:not(.author_contracts) .bid-nav a').on('click', function (e) {
            $('.author-app-popup').removeClass('author-popup-opac');
            $('#gform_12').fadeOut();
        });
    });

}(jQuery));

// document.querySelectorAll('a[href^="#"]').forEach(anchor => {
//     anchor.addEventListener('click', function (e) {
//         e.preventDefault();
//
//         document.querySelector(this.getAttribute('href')).scrollIntoView({
//             behavior: 'smooth'
//         });
//     });
// });
