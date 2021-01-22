;(function ($) {
    $(document).on('ready', function () {

        const singleExpendBtn = $('.single-bid .project-detail-box h2 span');
        const singleProjectDes = $('.single-project-des-collapse');
        singleExpendBtn.on('click', function (e) {
            singleProjectDes.slideToggle();
        });
        // My Author Information Save
        $('#my_author_info_save').on('submit', function (e) {
            e.preventDefault();
            var $button = $(this).find('input[type="submit"]');
            $button.val('Please wait');
            $button.prop('disabled', true);
            var $form = $(this);
            var form = document.getElementById('my_author_info_save');
            var $formData = new FormData(form);
            $formData.append('action', 'la_save_my_author_info');

            $.ajax({
                url: example_ajax_obj.ajaxurl,
                method: 'post',
                dataType: 'json',
                data: $formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.status) {
                        $form.prepend('<p class="alert alert-success">' + res.msg + '!</p>');
                        window.location.reload();
                    } else {
                        $form.prepend('<p class="alert alert-danger">' + res.msg + '!</p>');
                        window.location.reload();
                    }
                },
                error: function (er) {
                    console.log('Something going wrong!');
                    $button.val('Submit');
                    $button.prop('disabled', false);
                }
            });
        }); // #my_author_info_save submit

        // Author Rating customize
        var gform = $('.gform_fields');
        if (gform.length) {
            gform.each(function (i, el) {
                var f_id = $(el).attr('id');
                if ('gform_fields_12' == f_id) {
                    $(el).find('#field_12_1 .ginput_container_radio').append('<div class="la_editable_rating"></div><span class="la_editable_rating_score"></span>');
                }
            });
        }
        $('.la_editable_rating').raty();
        $('.la_editable_rating').click(function () {
            var score = $(this).find('input[name="score"]').val();
            $(this).next('.la_editable_rating_score').text(score + ' out 5');
            var inp_id = '#choice_12_1_' + (score - 1);
            var choiceHolder = $(this).prev('.gfield_radio').find(inp_id);
            choiceHolder.prop('checked', true);
            $(this).closest('form').find('#gform_submit_button_12').prop('disabled', false);
        });
        $('.gform_footer .gform_button').each(function (i, el) {
            var f_id = $(el).attr('id');
            if ('gform_submit_button_12' == f_id) {
                $(this).prop('disabled', true);
            }
        });

        // Notes toggle
        $('.toggleNotes').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).data('target'));
            console.log(target);
            if (!target.length) {
                target = $(this).parent().next('.la_notes_container');
            }
            if (target.length) {
                target.slideToggle(300);
            }
        });

        // Testimonial Section
        let testimonial = $('#testimonial-wrapper');
        if (testimonial.length > 0) {
            testimonial.owlCarousel({
                items: 1,
                nav: true,
                dots: false,
                loop: true,
                autoHeight: true,
                navText: ['<span class="fa fa-angle-left">', '<span class="fa fa-angle-right"></span>'],
                smartSpeed: 1500,
            });
        }

        // Home Icon Box Slide Under 980px
        function responsive_slider_two() {
            var desktop_destroy = $('#icon-boxes');
            if ($(window).width() <= 980) {
                $('#icon-boxes').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: false,
                    autoplay: false,
                    dots: true,
                    smartSpeed: 1000,
                    items: 3,
                    lazyLoad: true,
                    autoHeight: false,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        768: {
                            items: 3,
                        },
                    }
                });
            } else {
                desktop_destroy.owlCarousel('destroy');
            }
        }

        function responsive_slider_one() {
            var desktop_destroy = $('#author-steps-with-count');
            if ($(window).width() <= 767) {
                $('#author-steps-with-count').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: false,
                    autoplay: false,
                    dots: true,
                    smartSpeed: 1000,
                    items: 1,
                    lazyLoad: true,
                    autoHeight: false,
                });
            } else {
                desktop_destroy.owlCarousel('destroy');
            }
        }

        // Author-Steps-With-Count 767px
        responsive_slider_one();
        responsive_slider_two();

        $(window).on('resize', function (event) {
            responsive_slider_one();
            responsive_slider_two();
        });

        // Copy to Clipboard
        let copyText = $('.click-to-copy');
        let toolTip = $('<span class="copy-tooltip">Copy to clipboard</span>');
        copyText.parent().append(toolTip);

        // copyText.on('mouseout', function (ee) {
        $('body').on('mouseout', '.click-to-copy', function (ee) {
            $(this).parent().find('.copy-tooltip').html('Copy to clipboard');
        });

        // copyText.on('click', function (e) {
        $('body').on('click', '.click-to-copy', function (e) {
            let $temp = $('<input type="text">');
            $('body').append($temp);
            $temp.val($(this).text()).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).parent().find('.copy-tooltip').html('Copied to clipboard');
        });

        // Max characters count
        $('.laHasCounter').each(function (i, el) {
            var text = $(el).val();
            var textLength = text.length;
            var maxCount = $(el).data('maxlength');
            var counterHolder = $(el).next('.la_ginput_counter');
            counterHolder.text(textLength + ' of ' + maxCount + ' max characters');

            $(el).on('keypress keyup change paste', function (e) {
                text = $(this).val();
                textLength = text.length;
                if (text.length >= maxCount) {
                    $(this).val(text.substr(0, maxCount));
                    textLength = $(this).val().length;
                    e.preventDefault();
                }
                counterHolder.text(textLength + ' of ' + maxCount + ' max characters');
            });
        });


        //let repeaterInput = $('#field_3_1000 input');
        $(document).on('blur', '#field_3_1000 input', function (e) {
            if ('' !== $(this).val()) {
                let validationMessage = $('.url_validate_message');
                validationMessage.remove();
                let url = $(this).val();
                // url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                url_validate = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
                if (!url_validate.test(url)) {
                    $('#gform_submit_button_3').prop('disabled', true);
                    $(this).after('<div class="url_validate_message validation_message">Please enter a valid url.</div>');
                } else {
                    $('#gform_submit_button_3').prop('disabled', false);
                }
            } else {
                $('#gform_submit_button_3').prop('disabled', false);
            }
        });

        // $('#field_3_1000 input').each(function (i, el) {
        //     $(el).on('blue', function (e) {
        //         console.log($(this).val());
        //     });
        // });


    });// Document Ready Function
})(jQuery);