<?php
/*
 Template Name: Client Recommended Links
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';
	$classes[] = 'recommended_links';

	return $classes;
}

global $user_ID;

if ( ae_user_role() == FREELANCER ) {
	wp_redirect( get_home_url() . '/dashboard' );
}

if ( ( ! is_user_logged_in() ) ) {
	$current_url = $_SERVER["SERVER_NAME"] . '/recommended-links/?' . $_SERVER["QUERY_STRING"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to="' . $current_url . '"' );
}
$page_title = get_field( 'page_intro_title' );
if ( empty( $page_title ) ) {
	$page_title = get_the_title();
}
get_header();
?>
    <style>
        .la_project_item {
            margin-bottom: 25px;
        }

        .margin-top-30 {
            margin-top: 30px !important;
        }

        .margin-bottom-0 {
            margin-bottom: 0px !important;
        }

        .dashboard-sidebar > ul > li.la_client_rec_links a {
            color: white;
            font-weight: bold;
        }

        .dashboard-sidebar > ul > li.la_client_rec_links a i {
            color: #1aad4b;
        }

        a.btn.red-text {
            color: red !important;
        }

        .cur-pointer {
            cursor: pointer;
        }

        .payment-row {
            position: relative;
        }

        .la_message_form {
            background: #fff;
            padding: 20px;
            margin: auto;
            -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
            -moz-box-shadow: 0 0 4px 0px rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 4px 0px rgba(0, 0, 0, 0.3);
        }

        #fm_author_message_modal .modal-dialog {
            max-width: 550px;
            margin: auto;
        }

        .payment-table .payment-row:first-child {
            padding-top: 10px;
        }

        .payment-row .col:nth-child(5):not(.project-header) {
            color: inherit;
            text-transform: none;
            font-weight: normal;
        }

        .payment-row .la_message_form .tooltip-text a {
            color: #1aad4b;
            text-transform: none;
        }

        .laFormClose {
            position: absolute;
            right: 8px;
            top: 8px;
            color: #ffffff !important;
            border-radius: 18px;
            text-align: center;
            padding-top: 1px;
            width: 20px;
            height: 20px;
            line-height: 14px;
            padding-left: 4px;
        }

        .fade.show {
            opacity: 1;
        }

        .modal.fade.show .modal-dialog {
            -webkit-transform: translate(0, 25%);
            -moz-transform: translate(0, 25%);
            -ms-transform: translate(0, 25%);
            -o-transform: translate(0, 25%);
            transform: translate(0, 25%);
        }

        .la_project_item .payment-row .col p {
            font-size: 14px;
        }

        #fm_author_message_modal .la_message_form.modal-body p {
            margin-bottom: 10px;
        }

        p.green.text-uppercase.margin-bottom-0.laSiteName .label {
            display: inline-block;
            transform: translate(0px, -1px);
            padding: 4px;
        }

        .payment-row > .col:nth-child(3), .payment-row > .col:nth-child(2),
        .payment-row > .col:last-child {
            flex: 10%;
        }
        .payment-row:hover {
            background-color: rgba(114, 254, 0, 0.1);
        }

        .la_category_list_holder {
            position: absolute;
            background-color: #ffffff;
            z-index: 99;
            text-align: left;
            padding: 20px;
						width: 100vw;
    				max-width: 400px !important;
            box-shadow: 0px 2px 6px 2px #00000073;
            right: 15px;
            opacity: 0;
            /*visibility: hidden;*/
            display: none;
            top: 80px;
            -webkit-transition: all 0.4s ease-in-out;
            -moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
            /*overflow: auto;*/
            /*height: 257px;*/
        }

        .la_category_list_holder.active {
            top: 30px;
            opacity: 1;
            /*visibility: visible;*/
            display: block;
        }

        form.la_category_filter_form label {
            display: block;
        }

        .la_category_list_holder.active::before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 15px;
            border-color: transparent transparent #fff transparent;
            top: -25px;
            right: 40px;
        }
        .la_project_item > .white-bg.payment-table > .payment-row:first-child:hover {
            background-color: #ffffff;
        }
        .la-project-title-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
				.la_message_form {
					display:none;
				}
				.la_message_form.show {
					display: block;
				}
				a.laMessageAuthor {
					position: relative;
				}
				.la_msg_form_popup {
				    position: absolute;
				    background: white;
				    left: -25px;
				    transform: translate(-100%, -50%);
				    /* margin-right: 15px; */
				    z-index: 2;
				    width: 436px;
				    text-transform: initial;
				    cursor: auto;
				}
				.la_msg_form_popup .tooltip-text {
				    display: none;
				}
				.la_msg_form_popup .site_url {
				  color: #1aad4b;
				  font-size: 14px;
				  text-transform: uppercase;
				  font-weight: 600;
				  margin-top: -16px;
				  margin-bottom: 10px;
					cursor: default;
				}

				.la_msg_form_popup a.btn.btn-sm.btn-danger.laFormClose {
				    display:none;
				}
				#gform_wrapper_23 .gform_footer i.fa{
					cursor: default;
				}
				.la_msg_form_popup:before {
					background-color: white;
					content: "\00a0";
					display: block;
					height: 20px;
					width: 20px;
					position: absolute;
					right: -9.5px;
					top: 50%;
					transform: rotate(-47deg) skew(5deg);
					-moz-transform: rotate(-47deg) skew(5deg);
					-ms-transform: rotate(-47deg) skew(5deg);
					-o-transform: rotate(-47deg) skew(5deg);
					-webkit-transform: rotate(-47deg) skew(5deg);
					box-shadow: 2px 2px 2px 0 rgba(178, 178, 178, .4);
				}
				.message_author_overlay {
					z-index: 2;
					position: fixed;
					left:0px;
					top: 0px;
					width: 100%;
					height: 100%;
					cursor: pointer;
					background: black;
					display:none;
			    opacity: .2;
				}
				select[name="project_select_filter"] {
					margin: 10px 0px;
					width: 100%;
					max-width: 500px;
				}
            @media only screen and (max-width: 1024px){

                .payment-row-data .payment-row:hover>div {
                    background-color: rgba(114, 254, 0, 0.1);
                }
                .payment-row:hover {
                    background-color: transparent;
                }
            }
        @media only screen and (max-width: 600px) {
            .la-project-title-filter {
                flex-wrap: wrap;
            }
            .la-project-title-filter h4 {
                width: 100%;
            }
            .la_category_list_holder, .la_category_list_holder.active::before {
                left: 15px;
            }
						.la_category_list_holder {
							width: calc(100vw - 30px);
						}
						.la_msg_form_popup {
						    left: auto;
						    right: 10;
						    transform: none;
						    right: -40px;
						    max-width: calc(100vw - 25px);
						    bottom: 20px;
						}

						.la_msg_form_popup:before {
						    top: auto;
						    bottom: -9px;
						    righT: 30px;
						    transform: rotate(45deg);
						    -moz-transform: rotate(45deg);
						    -ms-transform: rotate(45deg);
						    -o-transform: rotate(45deg);
						    -webkit-transform: rotate(45deg);
						}
        }
    </style>
<?php
$link_categories = get_terms( [
	'taxonomy'   => 'industry',
	'hide_empty' => true
] );
// if ( ! isset( $project_id ) ) {
//     global $project_id;
// }

?>
        <div class="message_author_overlay"></div>
        <div class="message_filter_overlay"></div>
    <div class="entry-content landing-entry-content">
		<?php get_template_part( 'dashboard-side-nav' ); ?>
        <div class="main-dashboard-content dashboard-landing inner-dashboard">
            <h1 class="entry-title"><?= $page_title; ?></h1>
            <p class="optional-text"><?php
				echo get_field( 'page_intro_text' );
				// echo '</p>';
				?>
            </p>
            <div class="la_manage_sites margin-top-0">
				<?php
				wp_nonce_field( '_client_projects', 'csrf-token' );

				$projects = get_posts( array(
					'post_type'      => 'project',
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
					'author'         => get_current_user_id()
				) );
				$css = '';
				if ( count( $projects ) > 0 ) {
					foreach ( $projects as $project ) { 
                        $links_cat = la_get_client_recommended_links(  $project->ID, '' );

                        $link_categories_active = la_get_categories_recommended_links($links_cat);
                        //var_dump($link_categories_active);

                        ?>

                        <div class="la_project_item" data-project="<?= $project->ID; ?>" style="<?= $css ?>">
													<?php $css = 'display:none;'; ?>
                            <div class="la-project-title-filter">
                                <!-- <h4 class="margin-bottom-10"><?= $project->post_title; ?></h4> -->
																<select class="margin-bottom-10" name="project_select_filter">
																	<?php
																	foreach ( $projects as $proj ) {
																		?>
																		<option value="<?= $proj->ID; ?>"><?= $proj->post_title; ?></option>
																		<?php
																	}
																	?>
																</select>
                                <div class="row text-right">
                                    <div class="filter_by_category col-md-12">
                                        <a class="link_category_filter_toggle" href="javascript:void(0)" style="color: inherit; font-weight: bold; display: inline-block; margin-right: 15px;"><?php _e( 'Filter results', 'linkable' ); ?>
                                            <i class="fa fa-filter"></i>
                                        </a>
                                        <div class="la_category_list_holder">
                                            <p><?php _e( 'Select the industries you want to see shown:', 'linkable' ); ?></p>
                                            <form class="la_category_filter_form" data-project="<?= $project->ID; ?>">
												<?php foreach ( $link_categories as $link_category ) { ?>
                                                    <?php if( in_array($link_category->name, $link_categories_active)){
                                                        $checked = 'checked';
                                                    } else{
                                                        $checked = '';
                                                    } ?>
                                                    <label>
                                                        <input name="link_category" type="checkbox" value="<?= $link_category->term_id; ?>" <?php echo $checked; ?> > <?= $link_category->name; ?>
                                                    </label>
												<?php } ?>
                                                <button type="submit" class="btn la_btn_default"><?php _e( 'Submit', 'linkable' ); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="clients_rec_links_<?= $project->ID; ?>" class="white-bg payment-table">
                                <div class="payment-row payment-row-header">
                                    <div class="col project-header text-uppercase">Domain</div>
                                    <div class="col project-header text-uppercase cur-pointer laSortBy AuthorityWidth <?= @$order_da; ?>"
                                         data-sort="da">Domain Authority <span class="fa fa-sort"></span></div>
                                    <div class="col project-header text-uppercase AverageWidth">Average Cost</div>
                                    <div class="col project-header text-uppercase cur-pointer laSortBy industryWidth <?= @$order_ind; ?>"
                                         data-sort="industry">Industry <span class="fa fa-sort"></span></div>
                                    <div class="col project-header text-uppercase">Connect with the author</div>
                                </div>
                                <div class="payment-row-data">
									<?php
									$project_id = $project->ID;
									locate_template( 'template/recommended-links.php', true, false );
									?>
                                </div>
                            </div>
                        </div>
						<?php
					}
				} else { ?>
                    <div class="fre-profile-box">
                        <h5 class="text-center"><i class="fa fa-search"></i> You have no active projects posted yet!
                        </h5>
                    </div>
				<?php } ?>
            </div>
            <p class="optional-text margin-top-30"><?php
				echo get_field( 'quick_tips' );
				echo '</p>';
				?>
            </p>
        </div>
        <div id="fm_author_message_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="la_message_form modal-body">
						<?php
						echo do_shortcode( '[gravityform id=23 title=false description=false ajax=false tabindex=49 field_values="inquiry-proj-id=0&inquiry-link-id="]' );
						?>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {

            // Show filter form
            $('.link_category_filter_toggle').on('click', function (e) {
                e.preventDefault();
                $(this).next('.la_category_list_holder').toggleClass('active');
                $(".message_filter_overlay").toggleClass('active')
            });

            $('.btn.la_btn_default').on('click', function (e) {
                $(".message_filter_overlay").removeClass('active')
            });

            

            $(document).on("click", function(e) {
                let container = $('.la_category_list_holder')
                console.log(e.target)
                if(!container.is(e.target) && container.has(e.target).length === 0 && $(e.target).is(".link_category_filter_toggle") === false) {
                    $(".la_category_list_holder").removeClass("active");
                    $(".message_filter_overlay").removeClass("active");
                }
            });

            $('body').on('click', '.laMessageAuthor .la_message_form_inner', function (e) {
								e.preventDefault();
								if ($(this).parent().find('.la_message_form').hasClass('show')) {
									$('.la_msg_form_popup.show').removeClass('show');
									$('.message_author_overlay').hide();
									return;
								}
								$('.la_msg_form_popup.show').removeClass('show');
								$('.message_author_overlay').hide();
                e.preventDefault();
                var project_id = $(this).parent().data('project');
                var domain = $(this).parent().data('domain');

                if ('' == project_id || '' == domain) {
                    return;
                }
                $(this).parent().find('#input_23_2').val(project_id);
                $(this).parent().find('#input_23_5').val(domain);
								$(this).parent().find('.site_url').html(domain);
                $(this).parent().find('.la_message_form').addClass('show');
								$('.message_author_overlay').show();
                $(this).parent().find('#gform_submit_button_23').attr('disabled', true);
            });
						$('.message_author_overlay').click(function(e){
							$('.la_msg_form_popup.show').removeClass('show');
							$('.message_author_overlay').hide();
						});

            $('#field_23_3 i.fa.fa-question-circle').on('click', function (e) {
                e.preventDefault();
                $(this).parent().next('.tooltip-text').slideToggle(200);
            });

            $('body').on('click', '.laFormClose', function (e) {
                e.preventDefault();
                $('#fm_author_message_modal').removeClass('show');
                $('#input_23_4').val('');
            });

            // Customizing the form
            customize_the_forms();

            $(document).on('keyup', '#input_23_4', function (e) {
							console.log("keyup_23_4")
                if ('' == $(this).val()) {
                  $('.la_message_form.la_msg_form_popup').find('input[type="submit"]').attr('disabled', true);
									$('.la_message_form.la_msg_form_popup').find('.gform_footer').find('i').css('cursor', 'default');
                } else {
									$('.la_message_form.la_msg_form_popup').find('input[type="submit"]').attr('disabled', false);
                    //$('body').find('#gform_submit_button_23').attr('disabled', false);
									$('.la_message_form.la_msg_form_popup').find('.gform_footer').find('i').css('cursor', 'pointer');
								}
            });
            // Sorting
            $('body').on('click', '.laSortBy', function (e) {
                e.preventDefault();
                var icon = $(this).find('.fa');
                var sort_by = $(this).data('sort');
                var project_id = $(this).closest('.la_project_item').data('project');
                var isDesc = $(this).hasClass('desc');

                // Check if terms selected
                var filterForm = $(this).closest('.la_project_item').find('.la_category_filter_form');
                var formValue = filterForm.serializeArray();
                var terms = [];
                if (formValue.length > 0) {
                    $.each(formValue, function (i, el) {
                        if ('link_category' == el.name) {
                            terms.push(el.value)
                        }
                    });
                }

                load_links_item(project_id, sort_by, isDesc, icon, terms);
                $(this).toggleClass('desc');
            });


            // On form submit
            //$('.la_category_filter_form').on('submit', function (e) {
						$(document).on('submit','.la_category_filter_form',function(e){
						    e.preventDefault();
                var button = $(this).find('button[type="submit"]');
                button.attr('disabled', true);
                button.html('Please wait...');
                var projectId = $(this).data('project');

                var formValue = $(this).serializeArray();
                if (formValue.length > 0) {
                    var terms = [];
                    $.each(formValue, function (i, el) {
                        if ('link_category' == el.name) {
                            terms.push(el.value)
                        }
                    });

                    load_links_item(projectId, '', true, '', terms);

                    button.attr('disabled', false);
                    button.html('Submit');
                    $('.la_category_list_holder').removeClass('active');
                } else {
                    window.location.reload();
                    // button.attr('disabled', false);
                    // button.html('Submit');
                }
            });


            // On form submit
            $('#gform_23').on('submit', function (e) {
                $('.la_message_form.la_msg_form_popup').find('input[type="submit"]').attr('disabled', true);
								//$('.la_message_form.la_msg_form_popup').find('input[type="submit"]')
                $('.la_message_form.la_msg_form_popup').find('input[type="submit"]')
                    .find('.fa')
                    .removeClass('fa-sign-out')
                    .addClass('fa-spinner fa-spin');
            });
						$( 'select[name="project_select_filter"]' ).change(function() {
							$("select[name='project_select_filter']").val($(this).find('option:selected').attr('value'));
						  var proj_id = $(this).find('option:selected').attr('value');
							$(".la_project_item").hide();
							$(".la_project_item[data-project=" + proj_id + "]").show();
						});
        });

        // Get posts by sorting
        function load_links_item(project, sort_by, desc = true, icon = $, terms = []) {
            var $ = jQuery;
            if (icon) {
                icon.removeClass('fa-sort').addClass('fa-spinner fa-spin');
            }
            desc = desc ? 'yes' : 'no';
            var $holder = $('#clients_rec_links_' + project + ' .payment-row-data');
            var fd = new FormData();
            fd.append('action', 'la_get_sorted_projects');
            fd.append('token', $('#csrf-token').val());
            fd.append('project_id', project);
            fd.append('sort_by', sort_by);
            fd.append('desc', desc);
            fd.append('terms', terms);

            $.ajax({
                url: example_ajax_obj.ajaxurl,
                method: 'post',
                dataType: 'html',
                contentType: false,
                processData: false,
                data: fd,
                success: function (res) {
                    if (icon) {
                        icon.removeClass('fa-spinner fa-spin').addClass('fa-sort');
                    }
                    // console.log(res);
                    $holder.html(res);
                    customize_the_forms('#clients_rec_links_' + project);
                    // icon.removeClass('fa-sort').addClass('fa-spinner fa-spin');
                    let copyText = $('.click-to-copy');
                    let toolTip = $('<span class="copy-tooltip">Copy to clipboard</span>');
                    copyText.parent().append(toolTip);
                },
                error: function (err) {
                    console.log('Something going wrong!');
                    icon.removeClass('fa-spinner fa-spin').addClass('fa-sort');
                }
            })
        }

        // Customize the form
        function customize_the_forms(elem = '') {
            var $ = jQuery;
            var icon_elem = '.la_message_form .gform_wrapper';
            var has_icon = "#gform_wrapper_23 .gform_footer";
            if ('' !== elem) {
                icon_elem = elem + " " + icon_elem;
                has_icon = elem + " " + has_icon;
            }
            $(icon_elem).prepend('<a class="btn btn-sm btn-danger laFormClose"><i class="fa fa-close"></i></a>');
            var hasIcon = $(has_icon).find('.fa-sign-out').length;
            if (!hasIcon) {
                $(has_icon).append("<i class='fa fa-sign-out'></i>");
                $(has_icon).append("<span class='cm-send-note'><strong>QUICK TIP:</strong> Most authors typically reply back if they feel that you are sincere about working with them.</span>");
            }
        }
    </script>
<?php
get_footer();
