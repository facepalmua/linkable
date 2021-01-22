//validate inquiry url field
jQuery(document).on('change', ".gfield_list_1_cell1 input,.gfield_list_1_cell2 select", function () {
	var thisForm = jQuery(this).closest("#gform_wrapper_18");
	thisForm.find(".gfield_list_group").each(function () {
		var inputVal = jQuery(this).find(".gfield_list_1_cell1").find("input").val();
		//console.log('firing');
		// 		/console.log(inputVal);

		//validate URL
		if (inputVal.indexOf("http://") == 0 || inputVal.indexOf("https://") == 0) {
			urlValid = true;
			jQuery(this).closest("#gform_18").find(".gform_body .inq-error").remove();
			urlValid = true;
		} else {
			if (jQuery(this).closest("#gform_18").find(".gform_body").find(".inq-error").text().length == 0) {
				jQuery(this).closest("#gform_18").find(".gform_body").append("<span class='inq-error'>Please enter a valid URL beginning with http:// or https://</span>");
			}
			urlValid = false;
		}
	});
	//validate follow type
	thisForm.find(".gfield_list_group").each(function () {
		var followVal = jQuery(this).find(".gfield_list_1_cell2 select").val();
		console.log('followVal: ' + followVal);
		if (followVal == 'DoFollow' || followVal == 'NoFollow') {
			console.log('should be true');
			followValid = true;
		} else {
			console.log('should be false');
			followValid = false;
		}
	});

	console.log('follow valid: ' + followValid);
	console.log('url valid: ' + urlValid);

	if (followValid == true && urlValid == true) {
		jQuery(this).closest("#gform_18").find("#gform_submit_button_18").prop("disabled", false);
	} else {
		jQuery(this).closest("#gform_18").find("#gform_submit_button_18").attr("disabled", true);
	}
})

jQuery(document).on('click', '.add_list_item', function () {
	followValid = false;
	urlValid = false;
	jQuery(this).closest("#gform_18").find("#gform_submit_button_18").attr("disabled", true);
})


jQuery(document).ready(function ($) {
	var urlValid = false;
	var followValid = false;
	//disable inquiry button until validation is passed
	$("#gform_submit_button_18").attr("disabled", true);

	$(".pricing-bids.guar a").click(function () {

		$(this).closest(".bid-section-details").find(".guarantee-big-text").slideToggle();
	})

	$(".decline-toggle").click(function () {
		$(this).next().slideToggle();
	})

	//$("#field_18_1 .gfield_list_1_cell2 select").prop("required",true);
	//$("#field_18_1 .gfield_list_1_cell2 select option:first-child").prop("disabled",true);

	//$(".page-template-page-dashboard .dashboard-landing").wrapInner("<div class='video-wrapper'></div>");

	var securePass = false;

	$(".accept-app").click(function () {
		$(this).parent().parent().find('input[name="add-bid-to-cart"]').trigger('click');
		$(this).toggleClass("active");

		if ($(this).hasClass("active")) {
			$(this).find("span").text("Selected");
		} else {
			$(this).find("span").text("Accept");
		}
	})

	$(".decline-app").click(function () {
		// $(this).parent().parent().parent().parent().find('.owner-deletion').trigger('click');
		// console.log($(this).parent().parent().parent().parent().find('.delete-hide-menu'));
		$(this).parent().find(".gform_wrapper").slideToggle();
	})



	//validate password
	$('input#new_password').focusout(function () {

		var securePass = false;
		var data = $(this).val();
		var regx = /^[0-9]+$/;
		var upperCaseRegex = /[A-Z]+/;
		var numberRegex = /[0-9]+/
		var specialCharRegex = /[\!\@\#\$\%\^\&\*\?\_\~\-\(\)]+/;

		//console.log( data + ' patt:'+ data.match(regx));
		console.log(data.length);

		if (data.length >= 8) {
			console.log("length");

			if (data.match(upperCaseRegex)) {
				console.log("upper case");

				if (data.match(numberRegex)) {
					console.log("number");

					if (data.match(specialCharRegex)) {
						console.log("character");

						securePass = true;
					}

				}
			}
		}

		if (securePass == true) {
			$('.amt_err').fadeOut('slow');
			$('button').removeProp('disabled');
		}
		else if (securePass == false) {
			$('button').prop('disabled', true);
			$('.amt_err').text('Your password must contain at least 8 characters, one uppercase letter, one number and one special character.').fadeIn('fast');
		}



		console.log(securePass);
	});


	//link post title field for post project
	$("#input_3_10").keyup(function () {
		$("#input_3_1").val($(this).val());
	});


	$("#gform_4 i.fa-question-circle").click(function () {
		$(this).parent().parent().find(".gfield_description").slideToggle();
	})

	$(".employer .project-sub-nav li").remove();

	$(".employer-project-nav .fre-tabs li").each(function () {
		$(this).clone().appendTo(".project-sub-nav");
	});


	var totalPrice = 0;
	var selectedItem = 0;

	$(".add-to-cart input[name='add-bid-to-cart']").click(function () {

		$(this).parent().toggleClass("active");
		var price = $(this).next().next().text();
		//price = parseInt(price);
		price = parseFloat(price.replace(/,/g, ''));


		if ($(this).parent().hasClass('active')) {
			totalPrice = totalPrice + price;
		} else {
			totalPrice = totalPrice - price;
		}


		//totalPrice = totalPrice.replace(/^0+/, '');

		$("#input_5_4").val(totalPrice);

		console.log(totalPrice);

		$(".total-price").text('$' + totalPrice);



		selectedItem = $(this).parent().find(".bid-id").text();
		var itemChecked = $(":checkbox[value=" + selectedItem + "]").prop("checked");

		if (itemChecked == true) {
			$(":checkbox[value=" + selectedItem + "]").prop("checked", false);
		} else {
			$(":checkbox[value=" + selectedItem + "]").prop("checked", "true");
		}

		var totalChecked = $('.add-to-cart').find('input:checked[name="add-bid-to-cart"]').length;

		$(".num-selected span.num").text(totalChecked);
		var selected_text = $(".num-selected").html();
		if (totalChecked == 1) {
			selected_text = selected_text.replace("contracts selected", "contract selected");
		} else {
			selected_text = selected_text.replace("contract selected", "contracts selected");
		}
		$('.num-selected').html(selected_text);

		if (totalChecked > 0) {
			//$(".cart-banner").css("display","flex");
			$(".cart-banner").addClass('show_cart');
		} else if (totalChecked == 0) {
			//$(".cart-banner").hide();
			$(".cart-banner").removeClass('show_cart');
		}

		var projectNum = $(".container h1").text();
		projectNum = projectNum.replace("Project", 'Contract');
		projectNum = projectNum.replace("Workroom", '');
		var cartList = $(this).parent().parent().find('.info-for-cart');

		var projectID = $(this).parent().find(".bid-id").text();


		if ($(this).prop("checked") == true) {
			$(".selected-project-names").append('<li></li>');
			$(".selected-project-names li:last-child").addClass(projectID);
			$(".selected-project-names li:last-child").append((cartList).clone());
			//$(".selected-project-names li:last-child .info-for-cart").prepend(projectNum);

		} else {
			$(".selected-project-names li").each(function () {

				if ($(this).hasClass(projectID)) { $(this).remove(); }
			})
		}



	});


	$(".freelancer-bidding.author_contracts .bid-nav a").click(function () {
		if ($(this).hasClass('active')) {

		} else {

			var select_value = $(".project_filter option:selected").attr('value');
			display_contracts_with_filter($(this).attr('data-tab'), select_value);
			$('.freelancer-bidding.author_contracts .bid-nav a.active').removeClass('active');
			$(this).addClass('active');
		}
	});

	$('.project_filter').change(function () {
		var select_value = $(".project_filter option:selected").attr('value');
		display_contracts_with_filter(jQuery('.freelancer-bidding.author_contracts .bid-nav a.active').attr('data-tab'), select_value);
		// var select_index_selector = '';
		// if (select_value && select_value != 0) {
		// 	select_index_selector = '[data-id="' + select_value + '"]';
		// }
		// if ($('.bid-nav a.active').hasClass('accepted-bids_ac')) {
		// 	$('.author_contracts_table_wrapper .payment-project-row').hide();
		// 	$('.author_contracts_table_wrapper .la_status_accept').show();
		// }
		// if ($('.bid-nav a.active').hasClass('complete-bids_ac')) {
		// 	$('.author_contracts_table_wrapper .payment-project-row').hide();
		// 	$('.author_contracts_table_wrapper .la_status_pending-completion').show();
		// }
		// if ($('.bid-nav a.active').hasClass('cancelled-bids_ac')) {
		// 	$('.author_contracts_table_wrapper .payment-project-row').hide();
		// 	$('.author_contracts_table_wrapper .la_status_cancelled').show();
		// }
		// if ($('.bid-nav a.active').hasClass('pending-bids_ac')) {
		// 	$('.project-detail-box.bid-box.ie-bid-box.publish').hide();
		// 	if (select_value) {
		// 		$('.project-detail-box.bid-box.ie-bid-box.publish[data-id="' + select_value + '"]').show();
		// 	} else {
		// 		$('.project-detail-box.bid-box.ie-bid-box.publish').show();
		// 	}
		// }
		// if(select_value) {
		// 	$('.payment-project-row:visible:not([data-id="' + select_value + '"])').hide(200);
		//
		// 	var numpending = $('.project-detail-box.bid-box.ie-bid-box.publish[data-id="' + select_value + '"]').length;
		// 	var numactive = $('.payment-row.payment-project-row.la_status_accept[data-id="' + select_value + '"]').length;
		// 	var numcomplete = $('.payment-row.payment-project-row.la_status_pending-completion[data-id="' + select_value + '"]').length;
		// 	var numcancelled = $('.payment-row.payment-project-row.la_status_cancelled[data-id="' + select_value + '"]').length;
		//
		// 	$(".pending-count").text(numpending);
		// 	$(".accepted-count").text(numactive);
		// 	$(".completed-count").text(numcomplete);
		// 	$(".cancelled-count").text(numcancelled);
		// 	update_param_url('ac_project', select_value);
		// } else {
		// 	var numpending = $('.project-detail-box.bid-box.ie-bid-box.publish').length;
		// 	var numactive = $('.payment-row.payment-project-row.la_status_accept').length;
		// 	var numcomplete = $('.payment-row.payment-project-row.la_status_pending-completion').length;
		// 	var numcancelled = $('.payment-row.payment-project-row.la_status_cancelled').length;
		//
		// 	$(".pending-count").text(numpending);
		// 	$(".accepted-count").text(numactive);
		// 	$(".completed-count").text(numcomplete);
		// 	$(".cancelled-count").text(numcancelled);
		// 	update_param_url('ac_project', 0);
		// }
		//recalculate_contracts(select_value);
	});

	function display_contracts_with_filter(tab_class, select_value) {
		var select_index_selector = '';
		$('.author_contracts_table_wrapper.no_border').removeClass('no_border');
		if (select_value && select_value != 0) {
			select_index_selector = '[data-id="' + select_value + '"]';
		}
		if (tab_class == 'pending-bids_ac') {
			$('.no_contracts_msg').hide();
			$('.author_contracts_table_wrapper').hide(0);
			$('.project-detail-box.publish' + select_index_selector).show(0);
		} else {
			$('.no_contracts_msg').hide();
			$('.project-detail-box.publish').hide(0);
			$('.author_contracts_table_wrapper').show(0);
			if (tab_class == 'accepted-bids_ac') {
				$('.author_contracts_table_wrapper .payment-project-row').hide(0);
				if ($('.author_contracts_table_wrapper .la_status_accept' + select_index_selector).length) {
					$('.author_contracts_table_wrapper .la_status_accept' + select_index_selector).show(0);
					$('.author_contracts_table_wrapper .la_status_accept' + select_index_selector).last().addClass('no_border');
				} else {
					$('.no_contracts_msg').hide();
					$('.no_contracts_msg.no_contracts_cancelled').show();
					$('.author_contracts_table_wrapper').hide(0);
				}
			}
			if (tab_class == 'complete-bids_ac') {
				$('.author_contracts_table_wrapper .payment-project-row').hide(0);
				if ($('.author_contracts_table_wrapper .la_status_pending-completion' + select_index_selector).length) {
					$('.author_contracts_table_wrapper .la_status_pending-completion' + select_index_selector).show(0);
					$('.author_contracts_table_wrapper .la_status_pending-completion' + select_index_selector).last().addClass('no_border');
				} else {
					$('.no_contracts_msg').hide();
					$('.no_contracts_msg.no_contracts_completed').show();
					$('.author_contracts_table_wrapper').hide(0);
				}
			}
			if (tab_class == 'cancelled-bids_ac') {
				$('.author_contracts_table_wrapper .payment-project-row').hide(0);
				if ($('.author_contracts_table_wrapper .la_status_cancelled' + select_index_selector).length) {
					$('.author_contracts_table_wrapper .la_status_cancelled' + select_index_selector).show(0);
					$('.author_contracts_table_wrapper .la_status_cancelled' + select_index_selector).last().addClass('no_border');
				} else {
					$('.no_contracts_msg').hide();
					$('.no_contracts_msg.no_contracts_cancelled').show();
					$('.author_contracts_table_wrapper').hide(0);
				}
			}
		}

		var numpending = $('.project-detail-box.bid-box.ie-bid-box.publish' + select_index_selector).length;
		var numactive = $('.payment-row.payment-project-row.la_status_accept' + select_index_selector).length;
		var numcomplete = $('.payment-row.payment-project-row.la_status_pending-completion' + select_index_selector).length;
		var numcancelled = $('.payment-row.payment-project-row.la_status_cancelled' + select_index_selector).length;

		$(".pending-count").text(numpending);
		$(".accepted-count").text(numactive);
		$(".completed-count").text(numcomplete);
		$(".cancelled-count").text(numcancelled);
		update_param_url('ac_project', select_value);
		update_param_url('ac_tab', $('.freelancer-bidding.author_contracts .bid-nav a[data-tab="' + tab_class + '"]').attr('data-value'));
	}
	//accepted vs pending bid nav
	$(".pending-bids").click(function () {
		if ($(this).hasClass('active')) {

		} else {
			$(this).addClass('active');
			$(".accepted-bids").removeClass('active');
			$(".complete-bids").removeClass('active');
			$(".cancelled-bids").removeClass('active');
			$("#project-detail-bidding").addClass('pending');
			$("#project-detail-bidding").removeClass('accepted');
			$("#project-detail-bidding").removeClass('cancelled');
			$("#project-detail-bidding").removeClass('complete');
			$("#project-detail-bidding").removeClass('pending-completion');
		}
	});

	$(".accepted-bids").click(function () {
		if ($(this).hasClass('active')) {

		} else {
			$(this).addClass('active');
			$(".pending-bids").removeClass('active');
			$(".complete-bids").removeClass('active');
			$(".cancelled-bids").removeClass('active');
			$("#project-detail-bidding").removeClass('pending');
			$("#project-detail-bidding").removeClass('cancelled');
			$("#project-detail-bidding").removeClass('complete');
			$("#project-detail-bidding").removeClass('pending-completion');
			$("#project-detail-bidding").addClass('accepted');
		}
	});

	$(".complete-bids").click(function () {
		if ($(this).hasClass('active')) {

		} else {
			$(this).addClass('active');
			$(".pending-bids").removeClass('active');
			$(".accepted-bids").removeClass('active');
			$(".cancelled-bids").removeClass('active');
			$("#project-detail-bidding").removeClass('pending');
			$("#project-detail-bidding").removeClass('accepted');
			$("#project-detail-bidding").removeClass('cancelled');
			$("#project-detail-bidding").addClass('pending-completion');
			$("#project-detail-bidding").addClass('complete');
		}
	});

	$(".cancelled-bids").click(function () {
		if ($(this).hasClass('active')) {

		} else {
			$(this).addClass('active');
			$(".pending-bids").removeClass('active');
			$(".accepted-bids").removeClass('active');
			$(".complete-bids").removeClass('active');
			$("#project-detail-bidding").removeClass('pending');
			$("#project-detail-bidding").removeClass('accepted');
			$("#project-detail-bidding").removeClass('complete');
			$("#project-detail-bidding").removeClass('pending-completion');
			$("#project-detail-bidding").addClass('cancelled');
		}
	});


	var numpending = $('.project-detail-box.bid-box.publish').length;
	var numactive = $('.project-detail-box.bid-box.accept').length + $('.project-detail-box.bid-box.admin-review').length;
	var numcomplete = $('.project-detail-box.bid-box.pending-completion').length + $('.project-detail-box.bid-box.complete').length;
	var numcancelled = $('.project-detail-box.bid-box.cancelled').length;

	$(".pending-count").text(numpending);
	$(".accepted-count").text(numactive);
	$(".completed-count").text(numcomplete);
	$(".cancelled-count").text(numcancelled);

	if (numpending == 0) {
		$(".freelancer-bidding .bid-nav").after("<p class='empty-bid empty-pending project-detail-box bid-box publish'>You currently have no pending contracts to show.</p>");
	}

	if (numactive == 0) {
		$(".freelancer-bidding .bid-nav").after("<p class='empty-bid empty-accept project-detail-box bid-box accept'>Any contracts for this project that that you have accepted/purchased would show up here. However, it currently looks like you do not have any yet for us to display here.</p>");
	}

	if (numcomplete == 0) {
		$(".freelancer-bidding .bid-nav").after("<p class='empty-bid empty-completed project-detail-box bid-box completed'>Any contracts for this project that have been completed would show up here. However, it currently looks like you do not have any yet for us to display here.</p>");
	}

	if (numcancelled == 0) {
		$(".freelancer-bidding .bid-nav").after("<p class='empty-bid empty-cancelled project-detail-box bid-box cancelled'>Any contracts for this project that have been cancelled would show up here. However, it currently looks like you do not have any yet for us to display here.</p>");
	}

	//add project number to top of employer project page
	//var title = $(".dashboard-sidebar.static .owner-project-link-list > li.active").text();
	//$(".employer .container h1").text(title);

	$("#gform_wrapper_8").append("<span class='cancel-profile-change'>Cancel</span>");
	$("#gform_wrapper_9").append("<span class='cancel-profile-change'>Cancel</span>");

	//edit profile popup
	$(".employer-info-edit.account-info").click(function () {
		$(this).find(".edit-ellipses-popup").slideToggle();
	});
	$(".employer-info-edit.my-author-info-edit").click(function () {
		$(this).find(".edit-ellipses-popup").slideToggle();
	});
	$("#edit-account-info").click(function () {
		$("#gform_wrapper_8").slideToggle();
		$(this).parent().parent().parent().parent().parent().find(".cancel-profile-change").show();
	});

	$(".cancel-profile-change").click(function () {
		window.location = window.location.href;
		$(this).parent().slideToggle();
		$(this).hide();
		$("#cnt-profile-default").css("display", "block");
		$(".current-paypal-info").css("display", "block");


	});

	$(".paypal-info").click(function () {
		$(this).find(".edit-ellipses-popup").slideToggle();
	});

	$(".set-up-paypal").click(function () {
		$("#gform_wrapper_9").slideToggle();
	});

	$("#edit-paypal-info").click(function () {
		$("#gform_wrapper_9").slideToggle();
		$(".current-paypal-info").slideToggle();
		$(this).parent().parent().parent().parent().find(".cancel-profile-change").show();
	});

	//lock application fields to avoid user messing up price


	//active classes for checkbox
	$('#input_10_1 input:checked').each(function () {
		$(this).parent().addClass('checked');
	});


	$('#input_10_1 input:checkbox').change(function () {
		if ($(this).is(":checked")) {
			$(this).parent().addClass('checked');
		} else {
			$(this).parent().removeClass('checked');
		}
	});
	//populate review form
	//var author_id = $(".author-id").text();
	//$("#input_12_2").val(author_id);

	//var project_id = $(".project-id").text();
	//$("#input_12_3").val(project_id);

	$(".show-review-form").click(function () {
		$(this).closest('.application-status').find('.author-app-popup').toggleClass('author-popup-opac');
		$(this).parent().parent().parent().parent().find("#gform_12").fadeToggle();
	});

	if ($(".page-template-page-my-project-no-app .fre-current-table-rows .fre-table-row.no-app").length == 0) {
		//$(".page-template-page-my-project-no-app .fre-table").append("There are no projects to display here yet.");
	}

	if ($(".page-template-page-accepted-app .fre-current-table-rows .fre-table-row").length == 0) {
		//$(".page-template-page-accepted-app #current-project-tab").append("There are no projects to display here yet.");
	}

	//only show dot noficiation if there is a new alert
	//alert($(".fre-notify-new").contents());
	/*var obj = $(".fre-notify-new");
	for (var key in obj) {
		alert('key: ' + key + '\n' + 'value: ' + obj[key]);
	}*/
	//alert($(".fre-notify-new"));
	if ($(".fre-notify-new").length) {

	} else {
		$(".dot-noti").hide();
	}

	//make apply inactive until calculate price
	if ($(".price-value").text() == '$0') {
		$("#gform_submit_button_4").attr("disabled", "disabled");
		$("#gform_submit_button_4").addClass("disabled");
		//$("#gform_submit_button_4").val("You must first calculate price");
	};

	$("#gform_wrapper_4 input").change(function () {
		//console.log('changed it');
		/*console.log($("#input_4_4").val());
		if( ($("#input_4_1").val() != '') && ( $("#input_4_4").val() != '') ) {
			console.log('not empty');
		}*/
	});

	//sync project navigation
	$(".project-sub-nav li:first-child").click(function () {
		$(".nav-tabs-my-work li").removeClass("active");
		$(".nav-tabs-my-work li:first-child").addClass("active");
	});

	$(".project-sub-nav li:nth-child(2)").click(function () {
		$(".nav-tabs-my-work li").removeClass("active");
		$(".nav-tabs-my-work li:nth-child(2)").addClass("active");
	});

	$(".project-sub-nav li:nth-child(3)").click(function () {
		$(".nav-tabs-my-work li").removeClass("active");
		$(".nav-tabs-my-work li:nth-child(3)").addClass("active");
	});

	$(".project-sub-nav li:nth-child(4)").click(function () {
		$(".nav-tabs-my-work li").removeClass("active");
		$(".nav-tabs-my-work li:nth-child(4)").addClass("active");
	});

	$(".project-sub-nav li:nth-child(5)").click(function () {
		$(".nav-tabs-my-work li").removeClass("active");
		$(".nav-tabs-my-work li:nth-child(5)").addClass("active");
	});

	$(".nav-tabs-my-work li:nth-child(1)").click(function () {
		$(".project-sub-nav li").removeClass("active");
		$(".project-sub-nav li:nth-child(1)").addClass("active");
	});

	$(".nav-tabs-my-work li:nth-child(2)").click(function () {
		$(".project-sub-nav li").removeClass("active");
		$(".project-sub-nav li:nth-child(2)").addClass("active");
	});

	$(".nav-tabs-my-work li:nth-child(3)").click(function () {
		$(".project-sub-nav li").removeClass("active");
		$(".project-sub-nav li:nth-child(3)").addClass("active");
	});

	$(".nav-tabs-my-work li:nth-child(4)").click(function () {
		$(".project-sub-nav li").removeClass("active");
		$(".project-sub-nav li:nth-child(4)").addClass("active");
	});

	$(".nav-tabs-my-work li:nth-child(5)").click(function () {
		$(".project-sub-nav li").removeClass("active");
		$(".project-sub-nav li:nth-child(5)").addClass("active");
	});

	jQuery(".pending-completion .hidden.project-id").each(function () {
		var bidID = $(this).text();
		jQuery(this).parent().find("#input_12_3").val(bidID);

		//populate review form
		var author_id = $(this).next().text();
		$("#input_12_2").val(author_id);
	});

	jQuery(".complete .hidden.project-id").each(function () {
		var bidID = $(this).text();
		jQuery(this).parent().find("#input_12_3").val(bidID);

		//populate review form
		var author_id = $(this).next().text();
		$("#input_12_2").val(author_id);
	});

	//allow owner to delet project
	$(".owner-deletion").click(function (e) {
		$(this).parent().find(".gform_wrapper").slideToggle();
	});

	$(".hidden-id").each(function () {
		var proj_id = $(this).text();
		$(this).parent().find("#input_14_3").val(proj_id);
	});

	$(".employer .fre-table-row").each(function () {
		var get_cls = $(this).attr("class");
		var answer = get_cls.split(" ").pop();
		//var answer = get_cls.split(" ");
		//console.log(answer);
		$(this).find("#input_14_5").val(answer);
	});

	$("#gform_wrapper_14").hide();


	//add target blank to Content Marketer invoices
	$(".gravitypdf-download-link").attr("target", "_blank");


	//submit project filter on change
	$(".select2-results__options li").click(function () {
		alert('changed');
		//$(".beautiful-taxonomy-filters-button").trigger("click");
	});


	$("#select2-select-project_category-container").text("All Categories");
	$("#select2-select-project-follow-type-container").text("All Link Attributes");

	$("#select2-select-project_category-container").on('DOMSubtreeModified', function () {
		$(".beautiful-taxonomy-filters-button").trigger('click');

	});



	$("#select2-select-project-follow-type-container").on('DOMSubtreeModified', function () {
		$(".beautiful-taxonomy-filters-button").trigger('click');
	});


	//show owner deletion menu
	$(".delete-hide-menu .owner-delete-bid").click(function () {
		$(this).parent().next().slideToggle();
	});

	$('#loginform').prepend('<h2>Log into your account</h2>');

	$('#gform_submit_button_18').click(function (e) {
		$(this).val('Sending');
		$(this).parent().find('i.fa').removeClass('fa-sign-out').addClass('fa-redo fa-spin');
	})


	jQuery("#input_15_4 > li").click(function () {
		//console.log($(this).find("input").attr('checked'));
		jQuery("#choice_15_4_1").each(function () {
			jQuery.each(this.attributes, function () {
				// this.attributes is not a plain object, but an array
				// of attribute nodes, which contain both the name and value
				if (this.specified) {
					console.log(this.name, this.value);
				}
			});
		});
	});

	//only let buy now after checking terms box
	$("#gform_submit_button_5").prop('disabled', true);
	$("#gform_submit_button_5").addClass('disabled');

	jQuery("#choice_5_8_1").click(function () {
		//do something
		if (jQuery(this).prop('checked')) {
			console.log('choise change');
			jQuery("#gform_submit_button_5").prop('disabled', false);
			jQuery("#gform_submit_button_5").removeClass('disabled');
		} else {
			jQuery("#gform_submit_button_5").prop('disabled', true);
			jQuery("#gform_submit_button_5").addClass('disabled');
		}
	});
	$('.sort_eta_button').click(function () {
		$(this).toggleClass('invert');
		var list, i, switching, b, shouldSwitch;
		list = document.getElementsByClassName("author_contracts_table_result")[0];
		switching = true;
		/* Make a loop that will continue until
		no switching has been done: */
		while (switching) {
			// Start by saying: no switching is done:
			switching = false;
			b = list.getElementsByClassName("payment-row");
			// Loop through all list items:
			for (i = 0; i < (b.length - 1); i++) {
				// Start by saying there should be no switching:
				shouldSwitch = false;
				/* Check if the next item should
				switch place with the current item: */
				if ($(this).hasClass('invert')) {
					if (parseInt(b[i].getAttribute('data-eta')) > parseInt(b[i + 1].getAttribute('data-eta'))) {
						/* If next item is alphabetically lower than current item,
						mark as a switch and break the loop: */
						shouldSwitch = true;
						break;
					}
				} else {
					if (parseInt(b[i].getAttribute('data-eta')) < parseInt(b[i + 1].getAttribute('data-eta'))) {
						/* If next item is alphabetically lower than current item,
						mark as a switch and break the loop: */
						shouldSwitch = true;
						break;
					}
				}
			}
			if (shouldSwitch) {
				/* If a switch has been marked, make the switch
				and mark the switch as done: */
				b[i].parentNode.insertBefore(b[i + 1], b[i]);
				switching = true;
			}
		}
	});

});
var prevLeft = 0;
jQuery(document).ready(function () {
	jQuery('#authors_contracts').on('scroll', author_contracts_scroll);
});

jQuery('.fre-tabs a[href="#active"]').click(function (e) {
	e.preventDefault();
	jQuery('div[id="project_deleted"]').hide();
	jQuery('div[id="project_active"]').show();
	jQuery(".fre-tabs li.active_nav").removeClass("active_nav");
	jQuery(this).parent().addClass("active_nav");
});
jQuery('.fre-tabs a[href="#inactive"]').click(function (e) {
	e.preventDefault();
	jQuery('div[id="project_deleted"]').show();
	jQuery('div[id="project_active"]').hide();
	jQuery(".fre-tabs li.active_nav").removeClass("active_nav");
	jQuery(this).parent().addClass("active_nav");
});

jQuery('.place_order_setting_item input[type="range"]:not(.yes_no_range)').change(function () {
	var newval = jQuery(this).val();
	jQuery(this).parent().find('label').find('span').html(newval);
	recalculate_order_la();
});
jQuery('.place_order_setting_item input[type="range"]:not(.yes_no_range)').on('input', function () {
	var newval = jQuery(this).val();
	jQuery(this).parent().find('label').find('span').html(newval);
	recalculate_order_la();
});

jQuery('.place_order_setting_item input.yes_no_range[type="range"]').change(function () {
	var newval = jQuery(this).val();
	if (newval == 0) {
		newval = 'Yes';
	} else {
		newval = 'No';
	}
	jQuery(this).parent().find('label').find('span').html(newval);
	recalculate_order_la();
});
jQuery('.place_order_setting_item input.yes_no_range[type="range"]').on('input', function () {
	var newval = jQuery(this).val();
	if (newval == 0) {
		newval = 'Yes';
	} else {
		newval = 'No';
	}
	jQuery(this).parent().find('label').find('span').html(newval);
	recalculate_order_la();
});

function recalculate_order_la() {
	console.log('recalc');
	var da_value = jQuery('#range_da').val();
	jQuery('.da_value').html(da_value);
	var anchor_text_range = jQuery('#anchor_text_range').val();
	if (anchor_text_range == 0) {
		jQuery('#anchor_text_choice').show(300);
	} else {
		jQuery('#anchor_text_choice').hide(300);
	}
	//target_url_choice
	//target_url_range
	var target_url_range = jQuery('#target_url_range').val();
	if (target_url_range == 0) {
		jQuery('#target_url_choice').show(300);
	} else {
		jQuery('#target_url_choice').hide(300);
	}

	var range_quantity = jQuery('#range_quantity').val();
	console.log(range_quantity);
	var price_per_link = jQuery('.order_total_inner .price').attr('price_per_link');
	var off_text = '0% OFF!';
	if (range_quantity == 1) {
		jQuery('.order_total_inner .price').find('span').html(Math.round(price_per_link * range_quantity));
		console.log('change_span');
	}
	if (range_quantity == 2) {
		off_text = '2% OFF!';
		jQuery('.order_total_inner .price').find('span').html(Math.round((price_per_link * range_quantity) * 0.98));
	}
	if (range_quantity == 3) {
		off_text = '5% OFF!';
		jQuery('.order_total_inner .price').find('span').html(Math.round((price_per_link * range_quantity) * 0.95));
	}
	if (range_quantity == 4) {
		off_text = '7% OFF!';
		jQuery('.order_total_inner .price').find('span').html(Math.round((price_per_link * range_quantity) * 0.93));
	}
	if (range_quantity == 5) {
		off_text = '10% OFF!';
		jQuery('.order_total_inner .price').find('span').html(Math.round((price_per_link * range_quantity) * 0.9));
	}
	jQuery('.order_total_inner .price').find('.price_absolute').html(off_text);
}
function author_contracts_scroll() {
	//console.log('scroll');
	var currentLeft = jQuery(this).scrollLeft();
	if (prevLeft != currentLeft) {
		//console.log(currentLeft);
		//var width = jQuery(this).parent().width();
		var inner_width = jQuery(this).width();
		var fw_width = jQuery(this).find('.payment-row').first().width();
		if ((fw_width - currentLeft - 10) <= inner_width) {
			jQuery(this).parent().addClass('scrolled_max');
		} else {
			jQuery(this).parent().removeClass('scrolled_max');
		}
	}
	else {
		prevLeft = currentLeft;
	}
}

// add/update get params on author contracts page
function update_param_url(param_name, param_value) {
	var currentUrl = window.location.href;
	var url = new URL(currentUrl);
	url.searchParams.set(param_name, param_value);
	var newUrl = url.href;
	window.history.pushState({ path: newUrl }, '', newUrl);

	update_param_view_details();
}

function update_param_view_details() {
	var url_string = window.location.href;
	var url = new URL(url_string);
	var tab = url.searchParams.get("ac_tab");
	var project = url.searchParams.get("ac_project");
	//jQuery('#authors_contracts a.col_view_details').attr('href');
	jQuery("#authors_contracts a.col_view_details").each(function () {
		var view_url = jQuery(this).attr("href");
		var view_url_obj = new URL(view_url);
		if (tab) {
			view_url_obj.searchParams.set('ac_tab', tab);
		}
		if (project) {
			view_url_obj.searchParams.set('ac_project', project);
		}
		var newUrl = view_url_obj.href;
		jQuery(this).attr('href', newUrl);
	});
}
function get_param_url() {
	var url_string = window.location.href;
	var url = new URL(url_string);
	var tab = url.searchParams.get("ac_tab");
	console.log(tab);
	var project = url.searchParams.get("ac_project");
	console.log(project);
	if (project) {
		if (project != 0) {
			jQuery(".project_filter").prop('selectedIndex', jQuery('.project_filter').find("option[value='" + project + "']").index());
		}
	}
	if (tab) {
		jQuery('.freelancer-bidding.author_contracts a[data-value="' + tab + '"]').click();
	}

}


// fit text

(function( $ ){

  $.fn.fitText = function( kompressor, options ) {

    // Setup options
    var compressor = kompressor || 1,
        settings = $.extend({
          'minFontSize' : Number.NEGATIVE_INFINITY,
          'maxFontSize' : Number.POSITIVE_INFINITY
        }, options);

    return this.each(function(){

      // Store the object
      var $this = $(this);

      // Resizer() resizes items based on the object width divided by the compressor * 10
      var resizer = function () {
        $this.css('font-size', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
      };

      // Call once to set.
      resizer();

      // Call on resize. Opera debounces their resize by default.
      $(window).on('resize.fittext orientationchange.fittext', resizer);

    });

  };

})( jQuery );
