var sending = false;
jQuery(document).ready(function ($) {

    var liveChatting;
    var activeItem = $('.la_message_sidebar').find('.laSidebarMessage.active');
    if( activeItem.length ) {
        var project_id = activeItem.data('project');
        var author = activeItem.data('author');
        if( '' !== project_id && '' !== author ) {
            // Un-bold text
            activeItem.removeClass('strong');
            la_get_message_item(project_id, author);
            liveChatting = setInterval(function () {
                la_get_unread_item(project_id, author);
            }, 9999);
        }
    }
    $('.la_message_list .button_submit').on('click', function(e){
      var search_word = $('.search_bar input').val();
      var formData = new FormData();
      formData.append( 'action', 'la_search_messages' );
      formData.append( 'search_word', search_word);
      jQuery.ajax({
          url: pmObj.ajax_url,
          type: 'post',
          dataType: 'html',
          data: formData,
          contentType: false,
          processData: false,
          success: function (res){
            console.log(res);
              // var ajaxContainer = jQuery('#la_message_ajax_container');
              // ajaxContainer.html(res);
              // ajaxContainer.removeClass('la_is_loading');
              // // Append to that item only on mobile
              // if( jQuery(window).width() <= 600 ) {
              //     //console.log("Mobile click");
              //     var target_li = jQuery('.laSidebarMessage.active').parent();
              //     jQuery('.la_author_messages').appendTo(target_li);
              //     var msg_cont = jQuery('.la_messages_container');
              //     jQuery('#la_message_ajax_container').animate({ scrollTop: msg_cont[0].scrollHeight }, 1000);
              // }
              // la_scroll_message_container_to_bottom();

          },
          error: function (er) {
              console.log('Something is going wrong with search!');
          }
      });
    });
    $('.laSidebarMessage').on('click', function (e) {
        e.preventDefault();
        $('#la_message_ajax_container').addClass('la_is_loading');
        $('.laSidebarMessage').removeClass('active');
        $(this).addClass('active');
        var project_id = $(this).data('project');
        var author = $(this).data('author');
        la_get_message_item(project_id, author);
        // Un-bold text
        $(this).removeClass('strong');
        clearInterval(liveChatting);
        liveChatting = setInterval(function () {
            la_get_unread_item(project_id, author);
        }, 9999);
    });
    $('button.reply_button:not(.no_click)').on('click', function(e){
      $(this).addClass('no_click');
      $(this).prop('disabled', true);
      $('#la_message_reply_form').submit();
    });

    $('#la_message_reply_form').on('submit', function(e){
      e.preventDefault();
      if (sending == false) {
        sending = true;
        $(this).find('button.reply_button').prop('disabled', true);
        var form = document.getElementById('la_message_reply_form');
        la_submit_message_form(form);
        $(this).find('button.reply_button').prop('disabled', false);
        $(this).removeClass('no_click');
      } else {
        console.log('duplicate. sending message');
      }
    });
    // Reload window in mobile<>desktop if this is message page
    var currentWidth = $(window).width();
    $(window).resize(function (e) {
        var isMessagePage = $('body').hasClass('private-messages');
        if( isMessagePage ) {
            if( currentWidth <= 600 && $(window).width() >= 600 ){
                window.location.reload();
            }
            if( currentWidth >= 600 && $(window).width() <= 600 ){
                window.location.reload();
            }
        }
    });
});
var last_message = '';
// Get message item
function la_get_message_item(project_id, author){
    if (last_message == jQuery('#reply_nonce').val()) {
      console.log('duplicate');
      return;
    }
    last_message = jQuery('#reply_nonce').val();
    if( '' == project_id || '' == author ){
        return false;
    } else {
        jQuery('input[name="project_id"]').val(project_id);
        jQuery('input[name="author_id"]').val(author);

        var formData = new FormData();
        formData.append( 'action', 'get_inquiry_message_items' );
        formData.append('project_id', project_id);
        formData.append('author_id', author);
        formData.append('reply_nonce', jQuery('#reply_nonce').val());
        jQuery.ajax({
            url: pmObj.ajax_url,
            type: 'post',
            dataType: 'html',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res){
                var ajaxContainer = jQuery('#la_message_ajax_container');
                ajaxContainer.html(res);
                ajaxContainer.removeClass('la_is_loading');
                // Append to that item only on mobile
                if( jQuery(window).width() <= 600 ) {
                    //console.log("Mobile click");
                    var target_li = jQuery('.laSidebarMessage.active').parent();
                    jQuery('.la_author_messages').appendTo(target_li);
                    var msg_cont = jQuery('.la_messages_container');
                    jQuery('#la_message_ajax_container').animate({ scrollTop: msg_cont[0].scrollHeight }, 1000);
                }
                la_scroll_message_container_to_bottom();

            },
            error: function (er) {
                console.log('Something is going wrong!');
            }
        });
    }
    last_message = '';
}

// Get Unread Message
function la_get_unread_item(project_id, author){
    if( '' == project_id || '' == author ){
        return false;
    } else {
        jQuery('input[name="project_id"]').val(project_id);
        jQuery('input[name="author_id"]').val(author);

        var formData = new FormData();
        formData.append( 'action', 'get_live_messages' );
        formData.append('project_id', project_id);
        formData.append('author_id', author);
        formData.append('reply_nonce', jQuery('#reply_nonce').val());
        jQuery.ajax({
            url: pmObj.ajax_url,
            type: 'post',
            dataType: 'html',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res){
                if( res ) {
                    var cont = jQuery('#la_project_' + project_id + '_' + author);
                    if( cont.length ) {
                        cont.append(res);
                        la_scroll_message_container_to_bottom();
                    }
                }
            },
            error: function (er) {
                console.log('Something is going wrong!');
            }
        });
    }
}

// Submit message reply form
function la_submit_message_form(form) {
    var formData = new FormData(form);
    formData.append( 'action', 'la_submit_reply_message' );
    if( '' == formData.getAll('reply_message') ){
        alert('Please type a message!');
    } else {
		jQuery('.reply_button').attr('disabled',true);
        jQuery.ajax({
            url: pmObj.ajax_url,
            method: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res){
                jQuery('#la_reply_msg').val('');
                la_get_message_item(res.project_id, res.author);
                la_scroll_message_container_to_bottom();
                sending = false;
				jQuery('.reply_button').attr('disabled',false);
            },
            error: function (er) {
                console.log('Something is going wrong!');
                sending = false;
            }
        });
    }
}

// Scroll Message container to bottom
function la_scroll_message_container_to_bottom() {
    var msg_container = jQuery('.la_messages_container');
    msg_container.scrollTop(msg_container[0].scrollHeight);
}

jQuery('document').ready(function(e){
  jQuery("#profile_img #profile_img_circle").fitText(.5, {'minFontSize': '16px'});
});
