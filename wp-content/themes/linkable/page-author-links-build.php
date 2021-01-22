<?php
/*
 Template Name: Author Links you can build
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';
	$classes[] = 'author_links_build';

	return $classes;
}

global $user_ID;

if ( ae_user_role() == EMPLOYER ) {
	wp_redirect( get_home_url() . '/my-projects/' );
}

if ( ( ! is_user_logged_in() ) ) {
	$current_url = $_SERVER["SERVER_NAME"] . '/links-you-can-build/?' . $_SERVER["QUERY_STRING"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to="' . $current_url . '"' );
}
$page_title = get_field( 'page_intro_title' );
if( empty( $page_title ) ) {
    $page_title = get_the_title();
}
get_header();  ?>
    <style>
        .la_add_sites .fre-profile-box {
            padding: 20px;
        }
        .margin-top-30 {
            margin-top: 30px !important;
        }
        .margin-bottom-0 {
            margin-bottom: 0 !important;
        }
        .dashboard-sidebar > ul > li.la_author_link_build a {
            color: white;
            font-weight: bold;
        }
        .dashboard-sidebar > ul > li.la_author_link_build a i {
            color: #1aad4b;
        }
        a.btn.red-text {
            color: red !important;
        }
        div#authors_build_links p {
            font-size: 14px;
        }
        a.btn.laEditSite, a.btn.laDeleteSite {
            padding: 0 10px;
        }
        a.btn.laEditSite i, a.btn.laDeleteSite i {
            display: inline-block;
        }
        #authors_build_links .payment-row .col:nth-child(5) {
            flex: 60px;
        }
        .author_links_build .payment-row .col:first-child span {
            display: inline-block;
        }
        @media screen and (max-width: 991px ) {
            input[name="site_name"] {
                margin-bottom: 15px;
            }
        }
        @media screen and (max-width: 600px ) {
            div#authors_build_links p{
                font-size: 11px;
            }
            .payment-row .col:first-child {
                min-width: 85px;
            }
            .col.text-uppercase.laIndustryId {
                text-transform: none;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                padding: 0 5px;
            }
        }
    </style>
<div class="entry-content landing-entry-content">
	<?php get_template_part( 'dashboard-side-nav'); ?>
	<div class="main-dashboard-content dashboard-landing inner-dashboard">
		<h1 class="entry-title"><?= $page_title; ?></h1>
		<p class="optional-text"><?php
			echo get_field( 'page_intro_text' );
			echo '</p>';
			?>
		</p>
        <div id="la_add_sites_section" class="la_add_sites">
            <h4 class="margin-bottom-10"><?php _e('Add new site:', 'linkable'); ?></h4>
            <div class="fre-profile-box">
                <form action="" id="la_author_build_link_form">
                    <?php wp_nonce_field( '_build_links_token', 'csrf_token' ); ?>
                    <input type="hidden" id="previous_site_id" name="previous_site">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="ex. https://forbes.com" name="site_name">
                        </div>
                        <div class="col-md-4">
                            <?php
                                $industries = get_terms( array(
                                        'taxonomy'   => 'industry',
                                        'hide_empty' => false,
                                        'items'      => 0
                                ));
                            ?>
                            <select name="site_category"
                                    id="site_category"
                                    class="form-control">
                                <option value="">-- Select the most appropriate category --</option>
                                <?php foreach ( $industries as $industry ) {
                                    printf( '<option value="%s">%s</option>',
                                        $industry->term_id,
                                        $industry->name
                                    );
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn la_btn_default">Add Site <span class="fa fa-chevron-circle-right"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="la_manage_sites margin-top-30">
            <h4 class="margin-bottom-10"><?php _e('Manage your sites:', 'linkable' ); ?></h4>
            <div id="authors_build_links" class="white-bg payment-table">
                <?php
                locate_template('template/author-links.php', true );
                ?>
            </div>
        </div>
        <p class="optional-text margin-top-30"><?php
			echo get_field( 'quick_tips' );
			echo '</p>';
			?>
        </p>
	</div>
</div>
    <script>
        jQuery(document).ready(function ($) {
            $('#la_author_build_link_form').on('submit', function(e){
                e.preventDefault();
                var $form = $(this);
                var site_name = $('input[name="site_name"]');
                var site_category = $('select[name="site_category"]');

                if( ! site_name.val() || ! validateUrl( site_name.val() ) ) {
                    site_name.parent().addClass('has-error');
                }
                if( ! site_category.val() ) {
                    site_category.parent().addClass('has-error');
                }
                if( ! validateUrl( site_name.val() ) || "" == site_name.val() || "" == site_category.val() ) {
                    // return;
                } else {
                    var button = $form.find('button[type="submit"]');
                    button.html('Please wait <span class="fa fa-spinner fa-spin"></span>');
                    button.attr('disabled', true);
                    var token = $('#csrf_token').val();
                    var fd = new FormData();
                    fd.append('action', 'la_author_link_build');
                    fd.append( 'site_name', site_name.val() );
                    fd.append( 'site_category', site_category.val() );
                    fd.append( 'previous_site', $('#previous_site_id').val() );
                    fd.append( 'token', token );
                    $.ajax({
                        url: example_ajax_obj.ajaxurl,
                        method: 'POST',
                        dataType: 'JSON',
                        contentType: false,
                        processData: false,
                        data: fd,
                        success: function(res) {
                            // console.log(res);
                            if(res.status){
                                site_name.val('');
                                site_category.val('');
                                button.html('Add Site <span class="fa fa-chevron-circle-right"></span>');
                                button.next('.btn').remove();
                                $('#previous_site_id').val('');
                                reload_site_lists();
                                button.attr('disabled', false);
                            } else {
                                alert(res.message);
                                button.html('Add Site <span class="fa fa-chevron-circle-right"></span>');
                                button.attr('disabled', false);
                            }
                        },
                        error: function (er) {
                            console.log("something going wrong!");
                            button.attr('disabled', false);
                        }
                    })
                }
            });
            // Error class remove
            $('input[name="site_name"], select[name="site_category"]').on('change', function (e) {
                $(this).parent().removeClass('has-error');
            });

            // Link Update/Edit
            $('body').on('click', '.laEditSite', function (e) {
                e.preventDefault();
                // Get Info
                var itemRoot = $(this).closest('.payment-row');
                var siteName = itemRoot.find('.laSiteName').data('value');
                var industryId = itemRoot.find('.laIndustryId').data('value');

                // Set Info
                $('input[name="site_name"').val(siteName);
                $('#site_category').val(industryId);
                $('#previous_site_id').val(itemRoot.data('site'));

                // Button text change
                var button = $('#la_author_build_link_form').find('button[type="submit"]');
                button.html('Update site <span class="fa fa-pencil"></span>');
                var hasCancel = button.parent().find('a.btn-default').length;
                if(! hasCancel ) {
                    button.after('<a class="btn btn-default" onclick="window.location.reload()" style="margin-top: 15px; margin-left: 10px;">Cancel</a>');
                }

                $('html, body').animate({
                    scrollTop: $('#la_add_sites_section').offset().top - 70
                });
            });

            // Link Remove / Delete
            $('body').on('click', '.laDeleteSite', function (e) {
                e.preventDefault();
                var icon = $(this).find('.fa');
                icon.removeClass('fa-trash').addClass('fa-spinner fa-spin');
                var token = jQuery('#csrf_token').val();
                var itemRoot = $(this).closest('.payment-row');
                var siteId = itemRoot.data('site');
                $.post(
                    example_ajax_obj.ajaxurl,
                    {
                        'action'  : 'la_del_users_links',
                        'token'   : token,
                        'link_id' : siteId
                    },
                    function(res){
                        if(res.status) {
                            reload_site_lists();
                        } else {
                            alert(res.message);
                            icon.removeClass('fa-spinner fa-spin').addClass('fa-trash');
                        }
                    }
                );
            })
        });
        // Reload the site lists
        function reload_site_lists() {
            var token = jQuery('#csrf_token').val();
            jQuery.post(
                example_ajax_obj.ajaxurl,
                {
                    'action': 'la_get_users_links',
                    'token' : token
                },
                function(res){
                    if(res) {
                        jQuery('#authors_build_links').html(res);
                    }
                }
            );
        }
        // URL Validator
        function validateUrl(value) {
            return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value);
        }
    </script>
<?php
get_footer();