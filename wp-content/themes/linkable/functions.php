<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css?v=5.5', '1.682' );
    $parent_style = 'parent-style';
    wp_enqueue_style( 'linkable-fonts', get_template_directory_uri() . '/fonts/fonts.css' );

    //wp_enqueue_style( 'linkable-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:200,300,400,400i,500,700', false );
    //wp_enqueue_style( 'linkable-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300');
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css' );
    wp_register_script( 'custom-js', get_stylesheet_directory_uri() . '/js/linkable-custom1.js', array( 'jquery' ), '1.851', true );
    wp_register_script( 'custom-js2', get_stylesheet_directory_uri() . '/js/linkable-custom2.js', array( 'jquery' ), '1.6452', true );
    wp_register_script( 'intercom-js', get_stylesheet_directory_uri() . '/js/intercom.js', array( 'jquery' ), '1.65', true );
    wp_register_script( 'jquery-validate', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js', array( 'jquery' ) );
    wp_register_script( 'jquery-validate-extras', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js', array( 'jquery' ) );

    wp_enqueue_style( 'responsive', get_stylesheet_directory_uri() . '/responsive.css', array( 'child-style' ) );
    wp_enqueue_style( 'ie-css', get_stylesheet_directory_uri() . '/ie-css.css', null, time(), 'all' );
//	wp_enqueue_style( 'child-style',
//		get_stylesheet_directory_uri() . '/style.css',
//		array( $parent_style ),
//		1.67
//	);
    wp_enqueue_script( 'ie-custom-js', get_stylesheet_directory_uri() . '/js/ie-custom.js', array( 'jquery' ), time(), true );
    wp_enqueue_script( 'custom-js' );
    wp_enqueue_script( 'custom-js2' );
    wp_enqueue_script( 'intercom-js' );
    wp_enqueue_script( 'jquery-validate' );
    wp_enqueue_script( 'jquery-validate-extras' );
    wp_localize_script(
        'custom-js',
        'example_ajax_obj',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
    );
    wp_localize_script(
        'custom-js',
        'globalObject',
        array(
            'wpURL'      => get_stylesheet_directory_uri(),
            'commission' => get_field( 'commission_rate_%', 'option' )
        )
    );

    if ( is_page_template( 'template-new-home.php' ) ) {
        wp_enqueue_style( 'home-css', get_stylesheet_directory_uri() . '/css/home.css?v=1.9', null, time(), 'all' );
    }
    if ( is_page_template( 'template-author-new.php' ) ) {
        wp_enqueue_style( 'author-css', get_stylesheet_directory_uri() . '/css/author.css', null, time(), 'all' );
    }
}

add_action( 'init', 'custom_login' );

function my_deregister_scripts() {
    wp_dequeue_script( 'wp-embed' );
}

add_action( 'wp_footer', 'my_deregister_scripts' );

//add facetwp labels
function fwp_add_facet_labels() {
    ?>
    <script>
        var facetLoaded = false;
        (function ($) {
            $(document).on('facetwp-loaded', function () {

                $('.facetwp-facet').each(function () {
                    var $facet = $(this);
                    var facet_name = $facet.attr('data-name');
                    var facet_label = FWP.settings.labels[facet_name];


                    if ($facet.closest('.facet-wrap').length < 1) {
                        $facet.wrap('<div class="facet-wrap"></div>');
                        $facet.before('<div class="facet-label-wrap"><h3 class="facet-label">' + facet_label + '</h3><i class="fa fa-question-circle"></i></div>');
                    }


                });

                var mobileTooltips = $(".search-tooltips.mobile").css('display');

                if (facetLoaded == false) {
                    if (mobileTooltips == 'none') {

                        //search tooltips desktop
                        jQuery(".project-filters .facet-wrap:first-child .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips > div:not(.keyword)").hide();
                            jQuery(".search-tooltips .keyword").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(3) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips > div:not(.domain)").hide();
                            jQuery(".search-tooltips .domain").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(5) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips > div:not(.follow)").hide();
                            jQuery(".search-tooltips .follow").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(7) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips > div:not(.category)").hide();
                            jQuery(".search-tooltips .category").slideToggle();
                        });
                    } else {
                        //search tooltips mobile
                        jQuery(".project-filters .facet-wrap:first-child .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips.mobile > div:not(.keyword)").hide();
                            jQuery(".search-tooltips.mobile .keyword").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(3) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips.mobile > div:not(.domain)").hide();
                            jQuery(".search-tooltips.mobile .domain").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(5) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips.mobile > div:not(.follow)").hide();
                            jQuery(".search-tooltips.mobile .follow").slideToggle();
                        });

                        jQuery(".project-filters .facet-wrap:nth-child(7) .facet-label-wrap i.fa.fa-question-circle").click(function () {
                            jQuery(".search-tooltips.mobile > div:not(.category)").hide();
                            jQuery(".search-tooltips.mobile .category").slideToggle();
                        });
                    }

                }
                facetLoaded = true;

            });
        })(jQuery);
    </script>
    <?php
}

add_action( 'wp_head', 'fwp_add_facet_labels', 100 );


// Change the message/body of the email
function wpse_custom_retrieve_password_message( $message, $key ) {
    return "Your custom email content";
}

add_filter( 'retrieve_password_message', 'wpse_custom_retrieve_password_message', 10, 2 );


function custom_login() {
    global $pagenow;
    if ( 'wp-login.php' == $pagenow && $_GET['action'] != "logout" ) {
        wp_redirect( get_home_url() . '/login/' );
    }
}

//facetwp icons
add_action( 'wp_head', function () {
    ?>
    <script>
        (function ($) {
            $(document).on('facetwp-loaded', function () {
                jQuery(".search-contain .facetwp-type-dropdown").append("<i class='fas fa-caret-down'></i>");
                var searchHeight = $(".facetwp-type-search").height();
                //console.log(searchHeight);
                //jQuery(".project-filters button").height(searchHeight);
            });
        })(jQuery);
    </script>
    <?php
}, 100 );

//time conversion
function seconds2human( $ss ) {
    $s = $ss % 60;
    $m = floor( ( $ss % 3600 ) / 60 );
    $h = floor( ( $ss % 86400 ) / 3600 );
    $d = floor( ( $ss % 2592000 ) / 86400 );
    $M = floor( $ss / 2592000 );

    return "$M months, $d days, $h hours, $m minutes, $s seconds";
}

//disable admin password reset email
if ( ! function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification() {
    }
}


//restrict downloads to selected author
function nstrm_golf_access( $post, $download ) {

    $user    = wp_get_current_user();
    $user_id = $user->ID;

    $download_id = $download->post->ID;

    $selected_author = get_field( 'invoice_author', $download_id );


    //var_dump($selected_author);
    //die();

    if ( $selected_author == $user_id ) {
        //if ( $user->ID == 64) {
        //if ( $download->post->ID == 2244) {
        $can_download = true;
    } else {
        $can_download = false;
    }

    return $can_download;
}

add_filter( 'dlm_can_download', 'nstrm_golf_access', 1, 2 );

add_action( 'gform_after_submission_1', 'logging_errors', 10, 2 );
function logging_errors( $entry, $form ) {

    //print_r($entry);

    GFCommon::log_debug( 'gform_after_submission: entry => ' . print_r( $entry, true ) );
}

//password reset link
add_filter( 'gform_pre_replace_merge_tags', function ( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
    GFCommon::log_debug( __METHOD__ . '(): form => ' . print_r( $entry, true ) );

    if ( $form['id'] == 2 || $form['id'] == 1 ) {
        $merge_tag = '{set_password_url}';
        $user_id   = gf_user_registration()->get_user_by_entry_id( $entry['id'], true );
        $user_info = get_userdata( $user_id );
        if ( $user_info ) {
            $user_login = $user_info->user_login;

            $user_data = get_user_by( 'ID', $user_id );

            /*
        $user_id = $entry['created_by'];
        $user       = new WP_User( $user_id );
        $user_email = $user->user_email;
        $user_login = $user->user_login;
        */
            $key = get_password_reset_key( $user_data );


            //$pass_url = print_r($entry);
            $pass_url = get_site_url() . '/reset-pass/?user_login=' . $user_login . '&key=' . $key;
        }

    }

    //$pass_url = $user_id;
    //return $text;

    if ( $form['id'] == 2 || $form['id'] == 1 ) {
        return str_replace( $merge_tag, $pass_url, $text );
    } else {
        return $text;
    }

    //return str_replace( 'wp-login.php?action=rp&', 'reset-pass/?', $text );
}, 10, 7 );


//key for owners
/*add_filter( 'gform_pre_send_email', function ( $email, $message_format, $notification, $entry ) {
    if ( ($notification['name'] != 'Owner Registration') && ($notification['name'] !== 'Content Author Registration') ) {
        return $email;
    }

	$merge_tag = '{set_password_url}';
    $user_id = gf_user_registration()->get_user_by_entry_id( $entry['id'], true );
    $user_info = get_userdata($user_id);
    $user_login = $user_info->user_login;

    $user_data = get_user_by( 'ID', $user_id );

    $key = get_password_reset_key( $user_data );

    $pass_url = 'https://wordpress-257790-935760.cloudwaysapps.com/reset-pass/?user_login='.$user_login.'&key=' . $key;

    $email['message'] = str_replace( $merge_tag, $pass_url, $email['message'] );

	return $email;

	//$email['message'] = str_replace( 'wp-login.php?action=rp&', 'reset-pass/?', $email['message'] );
	//$email['message'] = str_replace( '&login', '&user_login', $email['message'] );

    //return $email;
}, 10, 4 );*/

//author dropdown
add_filter( 'wp_dropdown_users_args', 'display_administrators_and_subscribers_in_author_dropdown', 10, 2 );
function display_administrators_and_subscribers_in_author_dropdown( $query_args, $r ) {

    $query_args['role__in'] = array( 'administrator', 'freelancer', 'employer' );
    $query_args['show']     = 'user_login';

    return $query_args;
}

add_filter( 'wp_dropdown_users_args', 'add_subscribers_to_dropdown', 1, 2 );
function add_subscribers_to_dropdown( $query_args, $r ) {

    $query_args['who']  = '';
    $query_args['show'] = 'user_login';

    return $query_args;

}


/* Filter Email Change Email Text */

// Function to change email address

function wpb_sender_email( $original_email_address ) {
    return 'noreply@link-able.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Link-able';
}

//add nonce to logout
function change_menu( $items ) {
    foreach ( $items as $item ) {
        if ( $item->title == "Logout" ) {
            $item->url = $item->url . "&_wpnonce=" . wp_create_nonce( 'log-out' );
        }
    }

    return $items;

}

add_filter( 'wp_nav_menu_objects', 'change_menu' );


add_action( 'wp_logout', 'auto_redirect_after_logout' );
function auto_redirect_after_logout() {
    wp_redirect( home_url() );
    exit();
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

function so43532474_custom_change_email_address_change( $email_change, $user, $userdata ) {

    // $new_message_txt = __( 'Change the text here, use ###USERNAME###, ###ADMIN_EMAIL###, ###EMAIL###, ###SITENAME###, ###SITEURL### tags.' );

    $new_message_txt         = 'This notice confirms that your password was changed on Link-able. If you did not change your password, please contact Link-able support.';
    $email_change['message'] = $new_message_txt;

    return $email_change;

}

add_filter( 'password_change_email', 'so43532474_custom_change_email_address_change', 10, 3 );

//hide facet counts
add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' );

//validate price calc url
add_filter( 'gform_field_validation_4_1', 'use_url_in_price_calc', 10, 4 );
function use_url_in_price_calc( $result, $value, $form, $field ) {

    if ( filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
        $result["is_valid"] = false;
        $result['message']  = 'Please enter a valid website URL beginning with HTTP or HTTPS.';
    }

    //echo filter_var($value, FILTER_VALIDATE_URL);
    return $result;

}

//don't let user applying to project mess with the price!
add_action( 'gform_post_paging_4', 'lock_price', 10, 3 );
function lock_price( $form, $source_page_number, $current_page_number ) {
    if ( $current_page_number == 2 ) {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                jQuery("#input_4_1").attr("readonly", "readonly");
                //$("#choice_4_2_0").prop("disabled","disabled");
                //$("#choice_4_2_1").prop("disabled","disabled");
                jQuery('#input_4_2 input:not(:checked)').attr('disabled', true);

            });
        </script> <?php }
}


//filter show all text
function modify_categories_dropdown( $args, $taxonomy ) {

    if ( $taxonomy == 'project_category' ) {
        $args['show_option_all'] = "Category";
    } else if ( $taxonomy == 'project-follow-type' ) {
        $args['show_option_all'] = "Link Attribute";
    }

    return $args;
}

add_filter( 'beautiful_filters_dropdown_categories', 'modify_categories_dropdown', 10, 2 );

// button shortcode
function Button( $atts, $content = null ) {
    extract( shortcode_atts( array( 'link' => '#', 'target' => '', 'rel' => '' ), $atts ) );

    return '<a class="button shortcode-button" href="' . $link . '" target="' . $target . '"	rel="' . $rel . '"><span>' . do_shortcode( $content ) . '</span><i class="fa fa-chevron-circle-right"></i></a>';
}

add_shortcode( 'button', 'Button' );

function new_contracts_code( $atts, $content = null ) {
  if (is_there_new_contracts()) {
  	return '<span class="new_nav">NEW!</span>';
  }
}

add_shortcode( 'new_contracts', 'new_contracts_code' );

function new_messages_code( $atts, $content = null ) {
  if (is_there_new_messages($return_bool = true)) {
  	return '<span class="new_nav">NEW!</span>';
  }
}

add_shortcode( 'new_messages', 'new_messages_code' );


add_filter( 'nav_menu_item_title', 'filter_nav_menu_item_title', 10, 4 );
function filter_nav_menu_item_title( $title, $item, $args, $depth ) {
	$title = do_shortcode( $title );

	return $title;
}

//green box full width shortcode
function green_row( $atts, $content = null ) {
    return '<div class="full-width green-row"><div class="container page-container"><div class="row">' . do_shortcode( $content ) . '</div></div></div>';
}

add_shortcode( 'green_row', 'green_row' );

//dynamic total calc for Content Marketer checkout
add_filter( 'gform_product_info_5', function ( $product_info, $form, $entry ) {

    $product_info = array(
        'products' => array(
            array(
                'name'     => 'Link-able Checkout',
                'price'    => rgar( $entry, 4 ),
                'quantity' => 1,
            ),
        ),
    );


    return $product_info;
}, 10, 3 );


//footer nav menus

function wpb_custom_new_menu() {
    register_nav_menus(
        array(
            'footer-nav-menu'    => __( 'Footer Nav Menu' ),
            'footer-social-menu' => __( 'Footer Social Menu' ),
            // 'academy-header-menu' => __( 'Academy Header Menu' ),
            // 'academy-footer-menu' => __( 'Academy Footer Menu' ),
        )
    );
}

add_action( 'init', 'wpb_custom_new_menu' );

/* dynamically populate post title for projects */
add_filter( 'gform_field_value_project-title', 'my_custom_population_function' );
function my_custom_population_function( $value ) {
    $current_use  = wp_get_current_user();
    $current_date = date( "d/m/Y" );
    $return_value = $current_use->user_login . ' ' . $current_date;

    return $return_value;
}

add_filter( 'gform_field_value_user-info', 'my_custom_population_function2' );
function my_custom_population_function2( $value ) {
    $current_use  = wp_get_current_user();
    $current_date = date( "d/m/Y" );
    $return_value = $current_use->user_login . ' ' . $current_date;

    return $return_value;
}

add_filter( 'gform_field_value_current-post-id', 'my_custom_population_function3' );
function my_custom_population_function3( $value ) {
    $current_id = get_the_ID();

    return $current_id;
}

add_filter( 'gform_field_value_todays-date', 'my_custom_population_function4' );
function my_custom_population_function4( $value ) {
    $current_date = date( "m/d/Y" );

    return $current_date;
}

add_filter( 'gform_field_value_cancellation-bid-id', 'my_custom_population_function55' );
function my_custom_population_function55( $value ) {
    return 'boom!';
}

//dynamically populate cancel project form
add_filter( 'gform_field_value_cancel-project-id', 'insert_proj_id' );
function insert_proj_id( $value ) {
    return wp_get_post_parent_id( get_the_ID() );
}


//author user id
add_filter( 'gform_field_value_cancel-author-user-id', 'insert_author_id' );
function insert_author_id( $value ) {

    return get_current_user_ID();
}


//populate owner deletion form
add_filter( 'gform_field_value_delete-status', 'deletion_status' );
function deletion_status( $value ) {

    return 'test';
}

//populate hide & delete bid it
add_filter( 'gform_field_value_hide-delete-bid-id', 'hide_delete_value' );
function hide_delete_value( $value ) {
    return get_the_ID();
}

//populate hide & delete project
add_filter( 'gform_field_value_hide-delete-proj-id', 'hide_delete_value2' );
function hide_delete_value2( $value ) {
    return wp_get_post_parent_id( get_the_ID() );
}

/* add nofollow dofollow taxonomy to Projects */

add_action('admin_head', 'my_custom_fonts'); // admin_head is a hook my_custom_fonts is a function we are adding it to the hook

function my_custom_fonts() {
  echo '<style>
    #acf-group_5d3e3ca9c5343{
        display: none !important;
    }
  </style>';
}

add_action( 'init', 'project_follow' );
function project_follow() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'          => _x( 'Preffered Link Attribute', 'taxonomy general name', 'textdomain' ),
        'singular_name' => _x( 'Preffered Link Attribute', 'taxonomy singular name', 'textdomain' ),
        'search_items'  => __( 'Search Follow Type', 'textdomain' ),
        'all_items'     => __( 'All Attributes', 'textdomain' ),
        'edit_item'     => __( 'Edit Follow Type', 'textdomain' ),
        'update_item'   => __( 'Update Follow Type', 'textdomain' ),
        'add_new_item'  => __( 'Add New Follow Type', 'textdomain' ),
        'new_item_name' => __( 'New Follow Type Name', 'textdomain' ),
        'menu_name'     => __( 'Follow Type', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'public'            => false,
        'rewrite'           => false,
    );

    register_taxonomy( 'project-follow-type', array( 'project' ), $args );
}

//moz api call ajax
/*

add_action('admin_head', 'my_action_javascript');

function my_action_javascript() {
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

    $('.moz-api').click(function(){
        var data = {
            action: 'my_action',
            whatever: 1234
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(ajaxurl, data, function(response) {
            alert('Got this from the server: ' + response);
        });
    });


});
</script>
<?php
}
/*
add_action('wp_ajax_my_action', 'my_action_callback');

function my_action_callback() {
     global $wpdb; // this is how you get access to the database

     $whatever = $_POST['whatever'];

     $whatever += 10;

             echo $whatever;

     exit(); // this is required to return a proper result & exit is faster than die();
}*/

//make sure website is on verified list before submitting project
//add_filter( 'gform_validation_3', 'custom_validation' );

function custom_validation( $validation_result ) {
    $form           = $validation_result['form'];
    $acf_id         = 'user_' . get_current_user_id();
    $verified_sites = array();

    //get array of verified sites
    if ( have_rows( 'urls', $acf_id ) ):

        // loop through the rows of data
        while ( have_rows( 'urls', $acf_id ) ) : the_row();
            $site              = get_sub_field( 'url' );
            $parse_site        = parse_url( $site );
            $parse_site_domain = $parse_site['host'];

            //$verified_sites[] = $site;
            // display a sub field value
            $verified_sites[] = $parse_site_domain;


        endwhile;

    else :

        // no rows found

    endif;

    //check if url is in array
    $url_field              = rgpost( 'input_9' );
    $parse_url_field        = parse_url( $url_field );
    $parse_url_field_domain = $parse_url_field['host'];

    if ( ! in_array( $parse_url_field_domain, $verified_sites ) ) {
        $validation_result['is_valid'] = false;
        //finding Field with ID of 1 and marking it as failed validation
        foreach ( $form['fields'] as &$field ) {

            //NOTE: replace 1 with the field you would like to validate
            if ( $field->id == '9' ) {
                $field->failed_validation  = true;
                $field->validation_message = 'You have not verified ownership of this website. You must first verify that you are the real owner before you can post your project. Please <a href="' . get_home_url() . '/profile/" target="_blank">click here</a> to verify ownership before continuing.';
                //$field->validation_message =  print_r($verified_sites);
                break;
            }
        }
    }

    //Assign modified $form object back to the validation result
    $validation_result['form'] = $form;

    return $validation_result;

}

/*to debug cron, uncomment and go to http://wordpress-257790-935760.cloudwaysapps.com/?the_cron_test
	reference: https://wordpress.stackexchange.com/questions/13625/how-to-debug-wordpress-cron-wp-schedule-event */

add_action( 'init', function () {

    if ( ! isset( $_GET['the_cron_test'] ) ) {
        return;
    }

    error_reporting( 1 );

    //do_action( 'cm_inquiries' );
    cm_inquiries();

    die();

} );

//cron job to email inquiries to authors every day
if ( ! wp_next_scheduled( 'send_cm_inquiries' ) ) {
    wp_schedule_event( strtotime( '22:20:00' ), 'daily', 'send_cm_inquiries' );
}

add_action( 'send_cm_inquiries', 'cm_inquiries' );
function cm_inquiries() {

    //loop through all employers
    $cms = get_users( array( 'role' => 'employer' ) );
    foreach ( $cms as $cm ) {
        $cm_id         = $cm->ID;
        $cm_email      = $cm->user_email;
        $cm_first_name = $cm->first_name;
        $inq_table     = '';
        $send_it       = 0;

        //loop through all projects by this employer
        $args = array(
            'post_type'      => 'project',
            'author'         => $cm_id,
            'post_status'    => 'publish',
            'posts_per_page' => '-1',
        );

        $query = new WP_Query( $args );

        $inq_table = '<div>';
        $i         = 'odd';
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                $project_include = false;
                $send_proj       = 0;
                //echo get_the_title() . '<br/>';
                if ( have_rows( 'inquiries_made_for_this_project' ) ):
                    while ( have_rows( 'inquiries_made_for_this_project' ) ) : the_row();
                        $email_sent = get_sub_field( 'email_sent_to_cm' );
                        if ( $email_sent != 1 ) {
                            $send_proj ++;
                        }
                    endwhile;
                endif;

                if ( $send_proj > 0 ) {
                    $project_include = true;
                }


                if ( $project_include == true ) {
                    $inq_table .= "<div class='section' style='margin-bottom: 35px;'>";
                    $inq_table .= "<div class='row'><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></div>";


                    //check for projects where email has not been sent
                    // check if the repeater field has rows of data
                    if ( have_rows( 'inquiries_made_for_this_project' ) ):

                        // loop through the rows of data
                        while ( have_rows( 'inquiries_made_for_this_project' ) ) : the_row();

                            // display a sub field value
                            $email_sent = get_sub_field( 'email_sent_to_cm' );
                            if ( $email_sent != 1 ) {

                                $send_it ++;
                                //gather data for email
                                //domain, da, price, follow type, link
                                $domain = get_sub_field( 'url' );
                                /*	if(parse_url($domain['path']) !== '') {
                                        $domain = $domain['path'];
                                    } else {
                                        $domain = parse_url($domain);
                                        $domain = $domain['host'];
                                    }*/
                                $domain = str_replace( 'www.', '', $domain );
                                $domain = str_replace( 'http://', '', $domain );
                                $domain = str_replace( 'https://', '', $domain );

                                $da          = get_sub_field( 'da' );
                                $follow_type = get_sub_field( 'follow_type' );
                                $price       = get_sub_field( 'price' );
                                $style       = '';

                                if ( $i == 'even' ) {
                                    $style = 'background-color:#e5e5e5;clear:both;height: 1.6em;';
                                } else {
                                    $style = 'clear:both;';
                                }

                                $inq_table .= '';
                                //add data to content for email
                                $inq_table .= "<div style='" . $style . "' class='row " . $i . "'>";
                                $inq_table .= '<div style="float:left;"><strong>' . $domain . '</strong>';
                                $inq_table .= ' (DA of ' . $da . ') ';
                                $inq_table .= '- ' . $follow_type;
                                $inq_table .= ' - Approx. cost $' . number_format( $price ) . '</div>';

                                $inq_table .= '<div style="display:inline; float: right;"><a href="' . get_home_url() . '/response-sent?row_id=' . get_row_index() . '&project_id=' . get_the_ID() . '&author_id=' . get_sub_field( 'author_id' ) . '">Yes</a>  |  No</div>';


                                $inq_table .= '</div>';

                                if ( $i == 'odd' ) {
                                    $i = 'even';
                                } else {
                                    $i = 'odd';
                                }

                                //mark row as sent
                                update_sub_field( 'email_sent_to_cm', true );

                            }

                        endwhile; //repeater

                    else:
                        $send_it = false;

                    endif; //repeater

                    $inq_table .= '</div>'; //end section
                } else {

                }


            endwhile; //projects
        endif; //projects

        $inq_table .= "</div>";

        echo $inq_table;

        echo $send_it;

        //send email
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Link-able <noreply@link-able.com>'
        );

        $subject = 'Would you want these backlinks?';

        $body = "<html><body><p>Hi " . $cm_first_name . ",</p><p>We have a few inquiries about your project from authors!</p><p><strong>Would you like any of these backlinks?</strong></p>";
        //table data goes here
        $body .= $inq_table;

        $body .= '<p>Simply click "Yes" on the links you want to let authors know. The authors will then shortly submit their application so you can hire them to build you the link! If you\'re not interested in any, no further action is required.</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';
        if ( $send_it > 0 ) {
            wp_mail( $cm_email, 'Would you want these backlinks?', $body, $headers );
            //wp_mail('anne@anneschmidt.co', 'Would you want these backlinks?', $body, $headers);
        }


    }


    //find any repeater rows where cm email box isn't checked

    //add data to email
}

/**
 * Add new schedule into default schedules.
 *
 * @param array $schedules
 *
 * @return array
 */
function la_create_new_cron_schedule( $schedules ) {
    $schedules['weekly'] = array(
        'interval' => 604800,
        'display'  => __( 'Once Weekly' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'la_create_new_cron_schedule' );
//each day run a function to check new projects posted. Send a summary email to authors who have signed up to receive notifications for categories in which a new project was posted.

if ( ! wp_next_scheduled( 'send_category_emails' ) ) {
    wp_schedule_event( strtotime( '20:20:00' ), 'weekly', 'send_category_emails' );
}

add_action( 'send_category_emails', 'category_emails' );
function category_emails() {

    $subscribers                  = get_users( array( 'role' => 'freelancer' ) );
    $emails                       = array();
    $first_names                  = array();
    $project_category             = array();
    $user_notification_categories = array();
    $category_name                = array();
    $fresh_projects               = array();
    $project_email_data           = '';

    //1. get an array of all new projects posted within the last 24 hours
    $args = array(
        'post_type'      => 'project',
        'post_status'    => 'publish',
        'posts_per_page' => '-1',
        'date_query'     => array(
            array(
                'after' => '24 hours ago'
            )
        )
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $proj_id   = get_the_ID();
            $proj_name = get_the_title();
            $proj_cats = get_the_terms( $proj_id, 'project_category' );

            foreach ( $proj_cats as $cat ) {
                $project_category = $cat->term_id;
                //echo $cat->term_id;
                $category_name = $cat->name;
            }

            //array of needed project data
            //$project_array = array($proj_id,$proj_name,$project_category,$category_name);
            $project_array = array( $proj_id, $project_category );
            array_push( $fresh_projects, $project_array );


        endwhile;

    endif;

    //print_r($fresh_projects);

    foreach ( $subscribers as $subscriber ) {
        $project_email_data = '';
        //get array of notification categories that author wants
        $sub_notifies = get_field( 'notification_categories', 'user_' . $subscriber->ID );

        foreach ( $sub_notifies as $category ) {

            //echo $category->term_id;
            foreach ( $fresh_projects as $i ) {
                print_r( $i );
                if ( in_array( $category->term_id, $i ) ) {

                    $key = array_search( $category->term_id, $i );

                    //echo $key;
                    //echo $category->term_id;
                    $project_id = $i[0];
                    //echo $project_id;

                    $project_name = get_the_title( $project_id );
                    $permalink    = get_the_permalink( $project_id );
                    //echo $project_name;
                    //echo $permalink;

                    $digits     = 6;
                    $random_num = rand( pow( 10, $digits - 1 ), pow( 10, $digits ) - 1 );

                    // $email_link = get_home_url() . '/apply-to-project/?title_field=' . $project_name . '-' . $random_num . '&parent_id=' . $project_id;
                    $email_link = get_site_url() . '/projects';
                    //echo $email_link;


                    $project_email_data .= $category->name . ' - <a href="' . $email_link . '">' . $project_name . '</a><br/>';
                    //echo $project_email_data;

                } else {

                }
            }
        }


        if ( $project_email_data !== '' ) {
            echo $subscriber->ID;
            $email      = $subscriber->user_email;
            $first_name = $subscriber->first_name;

            //send email
            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: Link-able <noreply@link-able.com>'
            );

            $subject = 'New Earnings Opportunities on Link-able!';

            $body = "<html><body><p>Hi " . $first_name . ",</p><p>We have some new projects that were just posted on Link-able today!</p><p><strong>Your New Earning Opportunities:</strong></p><p>" . $project_email_data . "</p><p>These projects were all posted under categories you mentioned you specialize in and commonly write for, so we highly recommend you check them out and see if they’re a good fit for you!</p><p><strong>Don't want this notification?</strong></p><p>You are receiving this notification because you have Alert Notifications enabled. Please login to your Link-able account, visit Settings and uncheck the boxes of all categories you do not wish to receive alerts for.</p><p>Cheers!</p><p>The Link-able Team</p></body></html>";

            wp_mail( $email, 'New Earnings Opportunities on Link-able!', $body, $headers );

        }

    }

}

//each day run a function to see if there are any applications that have expired, but the content author has NOT completed or canceled. Sent notice to late@link-able.com

if ( ! wp_next_scheduled( 'late_app_action' ) ) {
    wp_schedule_event( strtotime( '14:20:00' ), 'daily', 'late_app_action' );
}

add_action( 'late_app_action', 'late_app' );


function late_app() {


    $expiration_query2 = new WP_Query(

        array(
            'post_type'      => 'bid',
            'post_status'    => 'accept',
            'posts_per_page' => - 1,
            'nopaging'       => true
        )
    );

    while ( $expiration_query2->have_posts() ) : $expiration_query2->the_post();


        $proj_id = get_the_ID();
        //echo get_the_ID();
        //echo get_post_status();
        //echo '<br>';
        $email_sent = get_field( 'late_project_admin_email_already_sent' );

        $publish_date  = get_the_date( 'm/d/Y', $proj_id );
        $time_frame    = get_field( 'how_long', $proj_id );
        $max_time_days = '';

        if ( $time_frame == '1 to 2 weeks' ) {
            $max_time_days = 14;
        }
        if ( $time_frame == 'Less than 2 weeks' ) {
            $max_time_days = 14;
        }
        if ( $time_frame == '2 to 3 weeks' ) {
            $max_time_days = 21;
        }
        if ( $time_frame == '4 to 6 weeks' ) {
            $max_time_days = 42;
        }
        if ( $time_frame == '7 to 8 weeks' ) {
            $max_time_days = 56;
        }

        //echo $max_time_days .'<br>';
        //echo $time_frame . '<br>';
        $date = date( 'm/d/Y', time() );
        //echo $publish_date;
        //echo '<br>';
        $diff = abs( strtotime( $date ) - strtotime( $publish_date ) );

        $days = round( $diff / ( 60 * 60 * 24 ) );

        //echo get_post_status();
        //echo ' publish date: ' . $publish_date;
        //echo ' time in days: ' . $max_time_days;
        //echo ' time left in days: ' . ($max_time_days - $days) . '<br>';

        $time_left = ( $max_time_days - $days );

        $parent_proj       = wp_get_post_parent_id( $proj_id );
        $author_id         = get_the_author_meta( 'ID' );
        $author_bid_email  = get_the_author_meta( 'user_email', $author_id );
        $parent_proj_id    = get_post_field( 'post_author', $parent_proj );
        $parent_proj_email = get_the_author_meta( 'user_email', $parent_proj_id );


        if ( $time_left < 0 && get_post_status() == 'accept' && $email_sent == 0 ) {
            echo get_the_ID() . '<br>';

            echo $parent_proj;
            echo $parent_proj_id;
            echo $parent_proj_email;

            //update email checkbox
            update_field( 'late_project_admin_email_already_sent', 1, $proj_id );

            //send admin email
            //---------- SEND ADMIN EMAIL ----------*/

            $bid_id       = $proj_id;
            $bid_link     = get_the_permalink( $bid_id );
            $author_email = 'late@link-able.com';
            //$author_email = 'anne@scoutdigitalllc.com';

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: Link-able <noreply@link-able.com>'
            );
            $body    = '<html><body><p>The following Application number is late: <a href="' . get_post_permalink() . '">' . $bid_id . '</a></p><p><ul><li>Project ID :' . $parent_proj . '</li><li style="">Content Author ID and Email:' . $author_id . ' ' . $author_bid_email . '</li><li>Content Marketer ID and Email:' . $parent_proj_id . ' ' . $parent_proj_email . '</li><li>URL: <a href="' . get_post_permalink() . '">' . get_post_permalink() . '</a></li></ul></p></body></html>';

            wp_mail( $author_email, 'Content Author late notification.', $body, $headers );

            /* ---------- END ADMIN EMAIL ---------- */

        }
    endwhile;

    wp_reset_postdata();


}


//each day run function to see if 30 day waiting period is over for completed project. If it is, send admin email to completed@link-able.com


/*to debug cron, uncomment and go to http://wordpress-257790-935760.cloudwaysapps.com/?the_cron_test
	reference: https://wordpress.stackexchange.com/questions/13625/how-to-debug-wordpress-cron-wp-schedule-event */
/*
add_action( 'init', function() {

    if ( ! isset( $_GET['the_cron_test'] ) ) {
        return;
    }

    error_reporting( 1 );

    do_action( 'check_waiting_period_action' );
    check_waiting_period();

    die();

} ); */

if ( ! wp_next_scheduled( 'check_waiting_period_action' ) ) {
    wp_schedule_event( strtotime( '15:20:00' ), 'daily', 'check_waiting_period_action' );
}

add_action( 'check_waiting_period_action', 'check_waiting_period' );


function check_waiting_period() {


    $expiration_query2 = new WP_Query(

        array(
            'post_type'      => 'bid',
            'post_status'    => 'pending-completion',
            'posts_per_page' => - 1,
            'nopaging'       => true
        )
    );

    while ( $expiration_query2->have_posts() ) : $expiration_query2->the_post();

        $email_sent2 = get_field( 'guar_date_sent' );


        $proj_id = get_the_ID();
        //echo get_the_ID();
        //echo get_post_status();
        //echo '<br>';
        $publish_date = get_the_date( 'm/d/Y', $proj_id );
        $publish_date = get_field( 'completed_date', $proj_id );

        $guar_date = date( 'm/j/Y', strtotime( $publish_date . ' + 30 days' ) );

        //$publish_date = date('m/d/Y',$publish_date);
        $publish_date = strtotime( $publish_date );
        $publish_date = date( 'm/d/Y', $publish_date );

        if ( get_post_status() == 'pending-completion' ) {
            //echo $publish_date;
        }

        //echo $guar_date;

        $date = date( 'm/d/Y', time() );
        $date = strtotime( $date );
        //echo $publish_date;
        //echo '<br>';


        $days = round( $diff / ( 60 * 60 * 24 ) );

        /*echo date('m/d/Y', $date);
                                    echo '<br>';
                                    echo date('m/d/Y', $guar_date);
                                    echo '<br>';*/

        $date = date( 'm/d/Y', $date );

        $diff = ( strtotime( $date ) - strtotime( $guar_date ) );
        //$guar_date = date('m/d/Y', $guar_date);

        if ( $diff > 0 && get_post_status() == 'pending-completion' ) {
            echo '<br>bid ID:' . $proj_id;
            echo '<br>Today: ' . $date;
            echo '<br>Guranatee date: ' . $guar_date;
            echo '<br>Diff: ' . ( strtotime( $date ) - strtotime( $guar_date ) );
            echo '<br>';
            echo wp_get_post_parent_id( $bid_id );
        }


        if ( $diff > 0 && ( get_post_status() == 'pending-completion' ) && $email_sent2 == 0 ) {

            //echo get_the_ID();
            //send admin email
            //---------- SEND ADMIN EMAIL ----------*/

            $bid_id = $proj_id;
            update_field( 'guar_date_sent', 1, $proj_id );
            $bid_link = get_the_permalink( $bid_id );

            $project_id     = wp_get_post_parent_id( $bid_id );
            $project_link   = get_permalink( $project_id );
            $date_completed = get_field( 'completed_date', $bid_id );

            $author_id = get_post_field( 'post_author', $bid_id );

            $author_data          = get_userdata( $author_id );
            $content_author_email = $author_data->user_email;

            $author_paypal = get_field( 'paypal_email', 'user_' . $author_id );

            $owner_id    = get_post_field( 'post_author', $project_id );
            $owner_data  = get_userdata( $owner_id );
            $owner_id    = $owner_data->ID;
            $owner_email = $owner_data->user_email;

            $author_email = 'guaranteedate@link-able.com';

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: Link-able <noreply@link-able.com>'
            );
            $body    = '<html><body><p>A completed application’s 30-day waiting period is up. Here are the details:</p><p>Application ID: <a href="' . get_post_permalink() . '">' . $bid_id . '</a><br/>Project ID: <a href="' . $project_link . '">' . $project_id . '</a><br/>This application was marked as complete on: ' . $date_completed . '</p><p>Content Author ID: ' . $author_id . '<br/>Content Author Email: <a href="mailto:' . $content_author_email . '">' . $content_author_email . '</a><br/>Content Author\'s PayPal Email: <a href="mailto:' . $author_paypal . '">' . $author_paypal . '</a><br/></p><p>Content Marketer ID: ' . $owner_id . '<br/>Content Marketer Email: <a href="mailto:' . $owner_email . '">' . $owner_email . '</a></p></body></html>';

            wp_mail( $author_email, '30-Day Waiting Period Notification.', $body, $headers );

            /* ---------- END ADMIN EMAIL ---------- */

        }
    endwhile;

    wp_reset_postdata();


}

//each day run function to see if project is more than 30 days old
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'check_old_projects_action' ) ) {
    wp_schedule_event( strtotime( '16:20:00' ), 'daily', 'check_old_projects_action' );
}

add_action( 'check_old_projects_action', 'check_old_projects' );


function check_old_projects() {


    $expiration_query = new WP_Query(

        array(
            'post_type'      => 'project',
            'posts_per_page' => - 1,
            'nopaging'       => true
        )
    );

    while ( $expiration_query->have_posts() ) : $expiration_query->the_post();


        $proj_id = get_the_ID();
        echo get_the_ID();
        echo '<br>';
        $publish_date = get_the_date( 'm/d/Y', $proj_id );
        $date         = date( 'm/d/Y', time() );
        echo $publish_date;
        echo '<br>';
        $diff = abs( strtotime( $date ) - strtotime( $publish_date ) );

        $days = round( $diff / ( 60 * 60 * 24 ) );


        if ( $days > get_field( 'project_expiration_time_in_days', 'option' ) ) {
            wp_update_post( array(
                'ID'          => $proj_id,
                'post_status' => 'cancelled'
            ) );
        }
    endwhile;

    wp_reset_postdata();


}

//author cancels project
add_action( 'gform_after_submission_11', 'author_cancel', 10, 2 );
function author_cancel( $entry, $form ) {
    $project_id        = rgar( $entry, 1 );
    $project_link      = get_post_permalink( $project_id );
    $project_title     = get_the_title( $project_id );
    $bid_id            = rgar( $entry, 2 );
    $cancel_reason     = rgar( $entry, 5 );
    $post              = get_post( $bid_id );
    $post->post_status = 'cancelled';
    wp_update_post( $post );

    $field_key = 'field_5be6495c6ac60';
    $value     = $cancel_reason;
    update_field( $field_key, $value, $post->ID );
    $today = current_time( 'Y-m-d H:i:s' );
    update_post_meta( $post->ID, 'bid_cancel_date', $today );

    //update invoice status
    $invoice_id = get_field( 'author_invoice_id', $bid_complete );
    update_field( 'payment_status', 'Application was cancelled', $invoice_id );
    update_field( 'payment_submitted_date', 'Cancelled', $invoice_id );

    //---------- SEND EMAIL TO OWNER ----------*/

    $project_author_id = get_post_field( 'post_author', $project_id );
    $author_data       = get_userdata( $project_author_id );
    $author_email      = $author_data->user_email;
    $author_first_name = $author_data->first_name;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Link-able <noreply@link-able.com>'
    );
    $body    = '<html><body><p>Hi ' . $author_first_name . ',</p><p>Unfortunately, your contract for <a href="' . $project_link . '">' . $project_title . '</a> was cancelled by the author.</p><p><strong>What happened?</strong></p><p>It appears the author was unable to build their proposed link and has cancelled the contract. We apologize for the inconvenience and will reach out to the author to see what happened. Please understand that building quality backlinks is difficult and sometimes authors are unable to build their proposed link.</p><p><strong>What you need to do:</strong></p><p>In the meanwhile, there is no action you need to take on your end. We will be issuing your refund for this cancelled contract shortly and once again apologize for this inconvenience.</p><p><strong>What\'s next?</strong></p><p>Don’t let this discourage you... We’d love to have you <a href="' . get_home_url() . '/login">log back into Link-able</a> and try again!</p><p>If you have any questions or need additional help, please let us know via our live chat!</p><p>Cheers!<br/>The Link-able Team</p></body></html>';

    wp_mail( $author_email, 'Your author contract on Link-able was cancelled.', $body, $headers );

    /* ---------- END EMAIL TO OWNER ---------- */


}


//content author referral
add_action( 'gform_after_submission_2', 'tapfiliate_author', 10, 2 );
function tapfiliate_author( $entry, $form ) {

    $new_user_email = rgar( $entry, 1 );

    //tapfiliate tracking code for Content Marketer signup
    echo '<!--tapfiliate tracking code-->
    <script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
    <script type="text/javascript">
      (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,"tap");
      tap("create", "8498-5cbe8a");
      tap("customer", "' . $new_user_email . '");
    </script>';
    // Removed from script
    // tap("conversion", "' . $new_user_email . '",0,{program_group: "content-author-affiliate-program"});
}

//Content Marketer referral
add_action( 'gform_after_submission_1', 'tapfiliate_owner', 10, 2 );
function tapfiliate_owner( $entry, $form ) {


    $new_user_email = rgar( $entry, 1 );
    $new_user       = get_user_by( 'email', $new_user_email );
    $new_user_id    = $new_user->ID;

    //tapfiliate tracking code for Content Marketer signup
    echo '<!--tapfiliate tracking code-->
    <script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
    <script type="text/javascript">
      (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,"tap");

      tap("create", "8498-5cbe8a");
      tap("customer", "' . $new_user_email . '");
    </script>';
    // Removed from script
    // tap("conversion", "' . $new_user_email . '",0);
}


//owner rejects bid
add_action( 'gform_after_submission_15', 'owner_hide', 10, 2 );
function owner_hide( $entry, $form ) {
    $bid_id         = rgar( $entry, 3 );
    $decline_reason = rgar( $entry, 5 );

    update_field( 'declination_reason', $decline_reason, $bid_id );

    wp_update_post( array(
        'ID'          => $bid_id,
        'post_status' => 'deleted'
    ) );

    $bid_author_id = get_post_field( 'post_author', $bid_id );
    $author_data   = get_userdata( $bid_author_id );
    //$author_email = $author_data->user_email;
    $author_email = 'issues@link-able.com';
    $first_name   = $author_data->first_name;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Link-able <noreply@link-able.com>'
    );
    $body    = '<html><body><p>Hi ' . $first_name . ',</p><p>Unfortunately, the client has declined your contract.</p><p><strong>What happened?</strong></p><p>There could be a number of reasons for this, but here\'s the main reason that the client provided:</p><p>' . $decline_reason . '</p><p>Don’t let this discourage you and we urge you to continue applying to more projects!</p><p><a href="' . get_home_url() . '/login">Login to Link-able</a> and search for better projects you can apply to!</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

    $args = array();
    $current_user = get_current_user_id();
    $args['project_id'] = wp_get_post_parent_id($bid_id);
    $args['author_id'] = $bid_author_id;
    $args['sender_id'] = $current_user;
    $args['message'] = '[@linkable_status@],contract_deleted,' . $bid_id . ',[/@linkable_status@]';
    $message = new LAPrivateMessaging();
    $message = $message->create_message($args, true);
    //wp_mail($author_email, 'A CM has declined an application', $body, $headers);

}

//owner deletes project
add_action( 'gform_after_submission_14', 'owner_cancel', 10, 2 );
function owner_cancel( $entry, $form ) {

    $bid_status = rgar( $entry, 5 );
    $post       = rgar( $entry, 3 );


    wp_update_post( array(
        'ID'          => $post,
        'post_status' => 'deleted'
    ) );


}

//password key fix from gravity forms
//add_action('gform_after_submisission_1', 'fix_pass_key', 10, 2);
/*function fix_pass_key($entry,$form) {
	require_once( gf_user_registration()->get_base_path() . '/includes/signups.php' );
	GFUserSignups::prep_signups_functionality();
	$activation_key = GFUserSignups::get_lead_activation_key( $entry_id );
	GFUserSignups::activate_signup( $activation_key );

GFCommon::log_debug( __METHOD__ . "Activation key function is running." );
GFCommon::log_debug( __METHOD__ . "Activation key is: ." . $activation_key );

}*/

//update notification settings
add_action( 'gform_after_submission_10', 'update_notify', 10, 2 );
function update_notify( $entry, $form ) {

    //print_r($entry);

    $user_id = $entry['created_by'];

    //get checked checkboxes
    $field_id    = 1;
    $field       = GFFormsModel::get_field( $form, $field_id );
    $field_value = is_object( $field ) ? $field->get_value_export( $entry ) : '';
    $myArray     = explode( ',', $field_value );
    $post_id     = "user_" . $user_id;

    //notification categories
    $field_key = "field_5b7b0621d7f66";
    $value     = $myArray;
    update_field( $field_key, $value, $post_id );

}

//map author category fields
add_action( 'gform_user_registered', 'add_custom_user_meta', 10, 4 );
function add_custom_user_meta( $user_id, $feed, $entry, $user_pass ) {
    //update_user_meta( $user_id, 'user_confirmation_number', rgar( $entry, '1' ) );
    //print_r($entry);
    $form = GFAPI::get_form( $entry['form_id'] );
    //print_r($form);

    //get checked checkboxes
    $field_id    = 7;
    $field       = GFFormsModel::get_field( $form, $field_id );
    $field_value = is_object( $field ) ? $field->get_value_export( $entry ) : '';
    $myArray     = explode( ',', $field_value );
    $post_id     = "user_" . $user_id;

    //topics
    $field_key = "field_5b686b76b51e6";
    $value     = $myArray;
    update_field( $field_key, $value, $post_id );

    //notification categories
    $field_key = "field_5b7b0621d7f66";
    $value     = $myArray;
    update_field( $field_key, $value, $post_id );
}

//don't show no preference follow type in facetwp search
add_filter( 'facetwp_index_row', function ( $params, $class ) {
    if ( 'follow_type' == $params['facet_name'] ) {
        $excluded_terms = array( 'no-preference' );
        if ( in_array( $params['facet_value'], $excluded_terms ) ) {
            return false;
        }
    }

    return $params;
}, 10, 2 );

//after post a project, change title to URL + date
add_action( 'gform_after_submission_3', 'project_post_title', 10, 2 );
function project_post_title( $entry, $form ) {
    GFCommon::log_debug( __METHOD__ . '(): The entry => ' . print_r( $entry, true ) );

    $post_id            = rgar( $entry, 'post_id' );
    $project_post_title = get_the_title( $post_id );
    $date               = rgar( $entry, 'date_created' );
    $url                = rgar( $entry, 9 );
    $da_range           = rgar( $entry, 18 );
    $check_field_id     = 18; // Update this number to your field id number
    $check_field        = RGFormsModel::get_field( $form, $check_field_id );
    $check_value        = is_object( $check_field ) ? $check_field->get_value_export( $entry ) : '';

    $show_url = $entry["12.1"];

    $follow_type = rgar( $entry, '6' );

    $desired_domains = rgar( $entry, 15 );

    //get follow type
    //if chose no preference, assign to both dofollow and nofollow
    if ( $follow_type == 191 ) {
        $cat_ids = array( 162, 163 );
        wp_set_object_terms( $post_id, $cat_ids, 'project-follow-type' );
    } else if ( $follow_type == 162 ) {
        wp_set_object_terms( $post_id, 162, 'project-follow-type' );
    } else {
        wp_set_object_terms( $post_id, 163, 'project-follow-type' );
    }

    // Update post autor
    wp_update_post(array(
        'ID'          => $post_id,
        'post_author' => get_current_user_id()
    ));

    /*if ($show_url === "Yes") {
        update_field('field_5c59b09347b77',0,$post_id);
    } else {*/
    update_field( 'field_5c59b09347b77', 1, $post_id );
    //}

    if ( $desired_domains ) {
        update_field( 'field_5c8082c1a5eda', $desired_domains, $post_id );
    }

    update_field( 'field_5d1cfb17b6d17', $check_value, $post_id );

    // Preferred pages
    $preferred_pages = rgar( $entry, 1000 );
    $p_1002          = [];
    foreach ( $preferred_pages as $preferred_page ) {
        $p_1002[] = $preferred_page[1002];
    }
    $p_1002_str = join( "\n", $p_1002 );
    update_field( 'field_5df82e6abb39b', $p_1002_str, $post_id );

    /*$new_title = $url . ' ' . $date;

    $post_array = array(
        'ID'	=> $post_id,
        'post_title'	=> $new_title
    );

    wp_update_post($post_array);	*/

    //also send notification emails to authors
    $subscribers                  = get_users( array( 'role' => 'freelancer' ) );
    $emails                       = array();
    $first_names                  = array();
    $project_category             = array();
    $user_notification_categories = array();
    $category_name                = array();

    //get project category
    $posted_project_cat = get_the_terms( $post_id, 'project_category' );

    //this returns the project category ID
    foreach ( $posted_project_cat as $cat ) {
        $project_category[] = $cat->term_id;
        //echo $cat->term_id;
        $category_name[] = $cat->name;
    }

    // echo "Project Category: ";
    // print_r($project_category);

    //get author notification categories
    //send if project category = author notification categories


    foreach ( $subscribers as $subscriber ) {
        //get array of notification categories that author wants
        $sub_notifies = get_field( 'notification_categories', 'user_' . $subscriber->ID );

        foreach ( $sub_notifies as $category ) {
            //echo $category->term_id;
            if ( $category->term_id == $project_category[0] ) {
                $emails[] = [ 'user_email' => $subscriber->user_email, 'first_name' => $subscriber->first_name ];
                //$first_names[] = $subscriber->first_name;
            } else {

            }
        }

    }

    $email_link = get_home_url() . '/apply-to-project/?title_field=' . $project_post_title . '&parent_id=' . $post_id;
    //$headers = array('Content-Type: text/html; charset=UTF-8');
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Link-able <noreply@link-able.com>'
    );

    //$body = 'A new INSERT CATEGORY HERE project has been posted on Linkable.<br/><a href="'.get_permalink( $post_id ).'">Click here</a> to see the project description.';


    foreach ( $emails as $email_address ) {

        $body = "<html><body><p>Hi " . $email_address['first_name'] . ",</p><p>A client has just posted a new project under the <strong><em>'" . $category_name[0] . "'</strong></em> category on Link-able!</p><p>Since this is a topic you mentioned you are interested in, we recommend that you check it out and see if it is something you can link to. <a href='" . $email_link . "'>Click here</a> to view the full project description and apply!</p><p><strong>Don't want this notification?</strong></p><p>You are receiving this notification because you have Alert Notifications enabled. Please login to your Link-able account, visit Settings and deselect any alert notifications you do not wish to receive.</p><p>Cheers!</p><p>The Link-able Team</p></body></html>";

        //wp_mail($email_address['user_email'], 'A new project has been posted on Link-able!', $body, $headers);
    }


}

/**
 * Gravity Wiz // Gravity Forms // Post Permalink Merge Tag
 * http://gravitywiz.com
 */
class GWPostPermalink {

    function __construct() {

        add_filter( 'gform_custom_merge_tags', array( $this, 'add_custom_merge_tag' ), 10, 4 );
        add_filter( 'gform_replace_merge_tags', array( $this, 'replace_merge_tag' ), 10, 3 );

    }

    function add_custom_merge_tag( $merge_tags, $form_id, $fields, $element_id ) {

        if ( ! GFCommon::has_post_field( $fields ) ) {
            return $merge_tags;
        }

        $merge_tags[] = array( 'label' => 'Post Permalink', 'tag' => '{post_permalink}' );

        return $merge_tags;
    }

    function replace_merge_tag( $text, $form, $entry ) {

        $custom_merge_tag = '{post_permalink}';
        if ( strpos( $text, $custom_merge_tag ) === false || ! rgar( $entry, 'post_id' ) ) {
            return $text;
        }

        $post_permalink = get_permalink( rgar( $entry, 'post_id' ) );
        $text           = str_replace( $custom_merge_tag, $post_permalink, $text );

        return $text;
    }

}

new GWPostPermalink();

add_filter( 'gform_field_value_complete-bid-id', 'my_custom_population_function103' );
function my_custom_population_function103( $value ) {
    return get_the_ID();
}

//Content Marketer ID
add_filter( 'gform_replace_merge_tags', 'replace_owner_ID', 10, 7 );
function replace_owner_ID( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {

    $custom_merge_tag        = '{owner_ID}';
    $owner_email_tag         = '{owner_email}';
    $project_URL_tag         = '{project_URL}';
    $purchased_apps_tag      = '{purchased_app_list}';
    $project_from_bid_id     = '{project_ID}';
    $parent_proj_id_tag      = '{parent_proj_ID}';
    $parent_proj_email_tag   = '{parent_proj_email}';
    $parent_proj_website_tag = '{parent_proj_website}';
    $invoice_merge_tag       = '{invoice_id}';

    $project_title_tag = '{proj_title}';

    $author_id_tag    = '{author_id}';
    $author_email_tag = '{author_email}';
    $bid_url_tag      = '{bid_url_tag}';


    /* if ( strpos( $text, $custom_merge_tag ) === false && strpos( $text, $owner_email_tag ) === false && strpos( $text, $project_URL_tag ) === false && strpos( $text, $purchased_apps_tag ) === false && strpos( $text, $project_from_bid_id ) === false){
        return $text;
    }*/


    $app_id     = rgar( $entry, 3 );
    $app_id_num = intval( $app_id );

    $author_id_data    = get_post_field( 'post_author', $app_id_num );
    $author_id_info    = get_userdata( $author_id_data );
    $author_email_data = $author_id_info->user_email;
    $bid_url_info      = get_the_permalink( $app_id_num );

    $parent_project = wp_get_post_parent_id( $app_id_num );

    $parent_project_title = get_the_title( $parent_project );

    $invoice_id = get_field( 'author_invoice_id', $app_id_num );

    $project_string = rgar( $entry, 1 );
    $project_number = intval( $project_string );

    $owner_ID            = get_post_field( 'post_author', $project_number );
    $parent_proj_id      = get_post_field( 'post_author', $parent_project );
    $parent_info         = get_userdata( $parent_proj_id );
    $parent_proj_email   = $parent_info->user_email;
    $parent_proj_website = get_field( 'url_of_page_you_want_to_build_a_link_to', $parent_project );

    $user_info   = get_userdata( $owner_ID );
    $owner_email = $user_info->user_email;
    $project_url = get_the_permalink( $project_number );

    $purchased_bid_info = '';


    //get purchased bid info
    $field_id = 5; // Update this number to your field id number
    $field    = RGFormsModel::get_field( $form, $field_id );
    $value    = is_object( $field ) ? $field->get_value_export( $entry ) : '';
    $bid_ids  = explode( ',', $value );

    $i = 1;

    foreach ( $bid_ids as $accepted_bid ) {

        $bid_author    = get_post_field( 'post_author', $accepted_bid );
        $bid_user_info = get_userdata( $bid_author );
        $author_email  = $bid_user_info->user_email;
        $workroom_url  = get_the_permalink( $accepted_bid );

        $purchased_bid_info .= 'Purchased application ' . $i . ': ';
        $purchased_bid_info .= 'Application ID: ' . $accepted_bid;
        $purchased_bid_info .= ', Author ID: ' . $bid_author;
        $purchased_bid_info .= ', Author Email: ' . $author_email;
        $purchased_bid_info .= ', Application Workroom: <a href="' . $workroom_url . '">' . $workroom_url . '</a>';
        $purchased_bid_info .= '<br>';

        $i ++;
    }

    $text = str_replace( $custom_merge_tag, $owner_ID, $text );
    $text = str_replace( $owner_email_tag, $owner_email, $text );
    $text = str_replace( $project_URL_tag, $project_url, $text );
    $text = str_replace( $purchased_apps_tag, $purchased_bid_info, $text );
    $text = str_replace( $project_from_bid_id, $parent_project, $text );

    $text = str_replace( $parent_proj_id_tag, $parent_proj_id, $text );
    $text = str_replace( $parent_proj_email_tag, $parent_proj_email, $text );
    $text = str_replace( $parent_proj_website_tag, $parent_proj_website, $text );

    $text = str_replace( $project_title_tag, $parent_project_title, $text );

    $text = str_replace( $invoice_merge_tag, $invoice_id, $text );

    $text = str_replace( $author_id_tag, $author_id_data, $text );
    $text = str_replace( $author_email_tag, $author_email_data, $text );
    $text = str_replace( $bid_url_tag, $bid_url_info, $text );


    return $text;
}

//after application, insert id of project as parent_post
add_action( 'gform_after_submission_4', 'after_application_submission', 10, 2 );
function after_application_submission( $entry, $form ) {

    //getting post ID
    $post          = $entry['post_id'];
    $parent_id     = rgar( $entry, 14 );
    $author_charge = rgar( $entry, 20 );

    global $wpdb;
    //$wpdb->query($wpdb->prepare("UPDATE 'wp_posts' SET 'post_parent'=32 WHERE 'ID'=727"));
    $wpdb->update(
        'wp_posts',
        array(
            'post_parent' => $parent_id,    // integer (number)
            'post_status' => 'publish'
        ),
        array( 'ID' => $post ),
        array(
            '%d'    // value2
        ),
        array( '%d' )
    );

    //remove random number from title
    $post_title  = get_the_title( $post );
    $last_digits = substr( $post_title, 0, - 7 );
	  $slug = substr( sanitize_title( $post_title ), 0, - 7 );

    echo $last_digits;
    echo $_POST;

    $post_to_update = array(
        'ID'          => $post,
        'post_parent' => $parent_id,
        'post_title'  => $last_digits,
        'post_name'   => $slug . '-' . $post,
        'post_status' => 'publish'
    );

    wp_update_post( $post_to_update );
    update_post_meta( $post, 'bid_budget', $author_charge );

    //now set up notification
    $project_number     = rgar( $entry, 14 );
    $notification_title = get_the_title( $project_number );

    $bid_author = get_post_field( 'post_author', $project_number );

    $dofollow_price = rgar( $entry, 20 );
    $nofollow_price = rgar( $entry, 21 );

    update_field( 'dofollow_price', $dofollow_price, $post );
    update_field( 'nofollow_price', $nofollow_price, $post );

    //add notification
    $notification_array = array(
        'post_title'   => 'New application for ' . $notification_title,
        'post_content' => 'type=new_bid&amp;project=' . $project_number . '&amp;bid=' . $post,
        'post_author'  => $bid_author,
        'post_excerpt' => 'type=new_bid&amp;project=' . $project_number . '&amp;bid=' . $post,
        'post_type'    => 'notify',
        'post_status'  => 'publish'
    );

    //turning this off temporarily
    //wp_insert_post($notification_array);

    //---------- SEND EMAIL TO OWNER ----------*/

    $project_author_id = $bid_author;
    $author_data       = get_userdata( $project_author_id );
    $author_email      = $author_data->user_email;
    $author_first_name = $author_data->first_name;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Link-able <noreply@link-able.com>'
    );
    $body    = '<html><body><p>Hi ' . $author_first_name . ',</p><p>This is an automatic notification just to let you know that an author has sent over a job contract on Link-able to build an awesome backlink for you!<p><strong>What you need to do:</strong></p><p>You’ll need to either accept or decline the author’s contract. You’ll find this under My Projects -> Pending Contracts -> Go to workroom OR by simply visiting:</p><p><a href="' . get_permalink( $parent_id ) . '">' . get_permalink( $parent_id ) . '</a></p><p><strong>Keep in mind:</strong></p><p>The author’s contract is typically time sensitive so please accept or decline it as promptly as you can.</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

    //turning this off temporarily
    //wp_mail($author_email, 'Your project received an application on Link-able!', $body, $headers);


    /* ---------- END EMAIL TO OWNER ---------- */
    $args = array();
    $current_user = get_current_user_id();
    $args['project_id'] = $project_number;
    $args['author_id'] = $current_user;
    $args['sender_id'] = $current_user;
    $args['message'] = '[@linkable_status@],contract_send,' . $post . ',[/@linkable_status@]';
    $message = new LAPrivateMessaging();
    $message = $message->create_message($args, true);

}

//after application is approved, add notification and email owner
function send_mails_on_publish( $new_status, $old_status, $post ) {
    // A function to perform when a pending post is published.
    //$postID = $post->ID;
    //$post_type = get_post_type($postID);
    if ( 'publish' == $new_status && ( 'draft' == $old_status ) && 'bid' == get_post_type( $post ) ) {
        //---------- SEND EMAIL TO OWNER ----------*/

        $project_author_id = get_post_field( 'post_author', $post );
        $author_data       = get_userdata( $project_author_id );
        $author_email      = $author_data->user_email;
        $author_first_name = $author_data->first_name;
        $parent_id         = wp_get_post_parent_id( $post );

        $parent_author_id         = get_post_field( 'post_author', $parent_id );
        $parent_author_data       = get_userdata( $parent_author_id );
        $parent_author_email      = $parent_author_data->user_email;
        $parent_author_first_name = $parent_author_data->first_name;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Link-able <noreply@link-able.com>'
        );
        $body    = '<html><body><p>Hi ' . $parent_author_first_name . ',</p><p>An author has just sent over a job contract for you to review on Link-able. <p><strong>What you need to do:</strong></p><p>You’ll need to either accept or decline the author’s contract. You’ll find this contract awaiting your review in your Project’s Workroom:</p><p><a href="' . get_permalink( $parent_id ) . '">' . get_permalink( $parent_id ) . '</a></p><p><strong>Keep in mind:</strong></p><p>The author’s work is typically time sensitive so please accept or decline it as promptly as you can.</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

        //wp_mail($author_email, 'Your project received an application on Link-able!', $body, $headers);
        wp_mail( $parent_author_email, 'You have a pending job contract awaiting on Link-able', $body, $headers );

        /* ---------- END EMAIL TO OWNER ---------- */


        $project_number     = $parent_id;
        $notification_title = get_the_title( $post );
        $bid_author         = get_post_field( 'post_author', $parent_id );
        //add notification
        $notification_array = array(
            'post_title'   => 'New application for ' . $notification_title,
            'post_content' => 'type=new_bid&amp;project=' . $project_number . '&amp;bid=' . $post->ID,
            'post_author'  => $bid_author,
            'post_excerpt' => 'type=new_bid&amp;project=' . $project_number . '&amp;bid=' . $post->ID,
            'post_type'    => 'notify',
            'post_status'  => 'publish'
        );

        wp_insert_post( $notification_array );

    }
}

//send email to author when app is published
add_action( 'transition_post_status', 'send_mails_on_publish', 10, 3 );


//after review, insert data into database
add_action( 'gform_after_submission_12', 'after_review_submission', 10, 2 );
function after_review_submission( $entry, $form ) {
    //print_r($entry);
    global $wpdb;

    $rating_score    = rgar( $entry, 1 );
    $author_identity = rgar( $entry, 2 );
    $project_id      = rgar( $entry, 3 );
    $feedback        = sanitize_textarea_field( rgar( $entry, 5 ) );

    $wpdb->insert(
        'wp_posts',
        array(
            'post_author' => $author_identity
        )
    );

    $lastid = $wpdb->insert_id;

    /*
    $wpdb->insert(
        'wp_postmeta',
        array(
            'post_id'    => $lastid,
            'meta_key'   => 'rating_score',
            'meta_value' => $rating_score
        )
    ); */
    // Update field with Wordpress function
    update_post_meta( $lastid, 'rating_score', $rating_score );
    update_post_meta( $lastid, 'rating_feedback', $feedback );
    update_post_meta( $lastid, 'rating_project_id', $project_id );

    //add rating to bid so author can only rate once
    update_field( 'field_5bb6ba07b034c', 1, $project_id );
}

add_action( 'gform_post_paging', 'alert_user', 10, 3 );
function alert_user( $form, $source_page_number, $current_page_number ) {
    if ( $current_page_number == 2 ) {
        // echo '<style>.price-calc {display:block;}</style>';
    }

}

function get_the_content_by_id( $post_id ) {
    $page_data = get_page( $post_id );
    if ( $page_data ) {
        return $page_data->post_content;
    } else {
        return false;
    }
}


//google doc form

add_action( 'gform_after_submission_16', 'google_doc_submission', 10, 2 );
function google_doc_submission( $entry, $form ) {
    $bid_id   = rgar( $entry, 3 );
    $doc_link = rgar( $entry, 4 );
    $post     = get_post( $bid_id );

    $invoice_id = get_field( 'author_invoice_id', $bid_id );

    update_field( 'google_doc_link', $doc_link, $bid_id );

    update_field( 'payment_status', 'Awaiting your completion', $invoice_id );

    update_field( 'revisions_needed', '', $bid_id );

    //$post->post_status = 'admin-review';

}

//after freelancer marks project as complete, change status of post

add_action( 'gform_after_submission_6', 'set_post_content', 10, 2 );
function set_post_content( $entry, $form ) {

    $bid_complete = rgar( $entry, 3 );
    //getting post
    $post          = get_post( $bid_complete );
    $date_complete = rgar( $entry, 'date_created' );

    wp_mail( 'm.yurchenko@link-able.comm', 'LOG DATA', print_r($date_complete) );

    $author_invoice_id = get_field('author_invoice_id', $bid_complete);
    $owner_invoice_id = get_field('owner_invoice_id', $bid_complete);

    //field_5b7c3db466533
    $converted_date = date( 'm/d/Y' );//, strtotime($date_complete) );
    update_field( 'field_5b7c3db466533', $converted_date , $author_invoice_id );
    update_field( 'field_5b7c3db466533', $converted_date , $owner_invoice_id );

    //add completion date
    $project_num = rgar( $entry, 6 );
    update_field( 'field_5b96ae48bf2ee', $date_complete, $bid_complete );

    //changing post content
    $post->post_status = 'pending-completion';

    //echo '<pre>' . print_r($entry) . '</pre>';
    $final_link = rgar( $entry, 4 );
    //echo $post->post_status;

    //$post->final_link = $final_link;
    $selector = 'final_link';
    $value    = $final_link;
    $post_id  = $post;

    update_field( $selector, $value, $post_id );

    $selector_2 = 'projet';
    $value_2    = $date_complete;

    update_field( $selector_2, $value_2, $post_id );

    //updating post
    wp_update_post( $post );

    //update invoice status
    $invoice_id = get_field( 'author_invoice_id', $bid_complete );
    update_field( 'payment_status', 'Awaiting 30 day guarantee date', $invoice_id );

    //now let's set up notification for Content Marketer

    $parent_project = wp_get_post_parent_id( $bid_complete );

    $project_author = get_post_field( 'post_author', $parent_project );

    $notification_title = get_the_title( $parent_project );

    //echo $parent_project;

    //add notification
    $notification_array = array(
        'post_title'   => 'A content author completed your project. You can view your link at ' . $final_link,
        'post_content' => 'type=complete_project&amp;project=' . $parent_project . '&amp;bid=' . $bid_complete,
        'post_author'  => $project_author,
        'post_excerpt' => 'type=complete_project&amp;project=' . $parent_project . '&amp;bid=' . $bid_complete,
        'post_type'    => 'notify',
        'post_status'  => 'publish'
    );

    wp_insert_post( $notification_array );

    //---------- SEND EMAIL TO AUTHOR ----------*/
    $bid_author_id = $entry['created_by'];
    $author_data   = get_userdata( $bid_author_id );
    $author_email  = $author_data->user_email;
    $first_name    = $author_data->first_name;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Link-able <noreply@link-able.com>'
    );
    $body    = '<html><body><p>Hi ' . $first_name . ',</p><p>It looks like you’ve marked your job contract on Link-able as complete… Awesome!</p><p><strong>What\'s next?</strong></p><p>We will verify your work and send a notification to the client that their link is now live. As <a href="'. get_site_url() .'/terms-of-service/">per our terms</a>, we require a waiting period to ensure that the link remains active before releasing your payment. After successful completion of the waiting period, we’ll send over your payment via PayPal to the PayPal email address you have on file (under Settings). If you have not added your PayPal email address yet, please do so. We cannot process your payment without a valid PayPal email address.</p><p><strong>Continue earning more!</strong></p><p>In the meantime, <a href="' . get_home_url() . '/login">log back into Link-able</a> and apply to more projects so you can continue earning more!</p><p><strong>Have a question?</strong></p><p>If you have a question or need help with anything, please let us know via our live chat!</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

    wp_mail( $author_email, 'You’ve marked your job contract as complete!', $body, $headers );

    /* ---------- END EMAIL TO AUTHOR ---------- */


    //---------- SEND EMAIL TO OWNER ----------*/

    //$bid_complete is bid id
    $project_author_id = $project_author;
    $author_data       = get_userdata( $project_author_id );
    $author_email      = $author_data->user_email;
    $author_first_name = $author_data->first_name;

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: noreply@link-able.com <noreply@link-able.com>'
    );
    $body = '<html><body><p>Hi ' . $author_first_name . ',</p>
    <p>Good news! The author has just finished building your link and has marked their job as complete. You can view your new backlink and full details here:</p>
    <p><a href="'. get_home_url() . '/author-contract-details-' . $bid_complete . '/">'. get_home_url() . '/author-contract-details-' . $bid_complete . '/</a></p>
    <p><strong>What&#39;s next?</strong></p>
    <p>We recommend that you take a look at your new link and review it as soon as you can. If you have any issues, please message the author first to see if they can help resolve them. In the unlikely event the author cannot, please contact us via our live chat to file a dispute. Remember, we offer a 30-day guarantee* - so be sure to contact us before then if you are not fully satisfied with the author&#39;s work. </p>
    <p><strong>Need help?</strong></p>
    <p>If you have a question or need help with anything, please let us know via our live chat!</p>
    <p>
    Cheers!<br>
    The Link-able Team
    </p>
    <p>*Please review the <a href="'.get_site_url().'/terms-of-service/">Link-able Terms of Service</a> for full details on our Link-able Guarantee.</p>
    </body></html>';

    wp_mail( $author_email, 'Your link has been built!', $body, $headers );

    /* ---------- END EMAIL TO OWNER ---------- */

}


function my_custom_post_status() {


    register_post_status( 'pending-acceptance', array(
        'label'                     => __( 'Pending Acceptance', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Pending Acceptance <span class="count">(%s)</span>', 'Pending Acceptance <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'active', array(
        'label'                     => __( 'Active', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'completed', array(
        'label'                     => __( 'Completed', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'declined', array(
        'label'                     => __( 'Declined', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'admin-review', array(
        'label'                     => __( 'Admin Approved', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Admin Approved <span class="count">(%s)</span>', 'Admin Approved <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'pending-completion', array(
        'label'                     => __( 'Completed', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'cancelled', array(
        'label'                     => __( 'Cancelled', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'withdrawn', array(
        'label'                     => __( 'Withdrawn', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Withdrawn <span class="count">(%s)</span>', 'Withdrawn <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'deleted', array(
        'label'                     => __( 'Declined', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>' ),
    ) );

    register_post_status( 'deleted-accepted-app', array(
        'label'                     => __( 'Deleted with Accepted App', ET_DOMAIN ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Deleted with Accepted App<span class="count">(%s)</span>', 'Deleted with Accepted App<span class="count">(%s)</span>' ),
    ) );

}

add_action( 'init', 'my_custom_post_status' );


/**
 * Add User Role Class to Body
 * Referenced code from http://www.studiok40.com/
 */
function print_user_classes() {
    if ( is_user_logged_in() ) {
        add_filter( 'body_class', 'class_to_body' );
        add_filter( 'admin_body_class', 'class_to_body_admin' );
    }
}

add_action( 'init', 'print_user_classes' );

/// Add user role class to front-end body tag
function class_to_body( $classes ) {
    global $current_user;
    $user_role = array_shift( $current_user->roles );
    $classes[] = $user_role . ' ';

    return $classes;
}

/// Add user role class and user id to front-end body tag

// add 'class-name' to the $classes array
function class_to_body_admin( $classes ) {
    global $current_user;
    $user_role = array_shift( $current_user->roles );
    /* Adds the user id to the admin body class array */
    $user_ID = $current_user->ID;
    $classes = $user_role . ' ' . 'user-id-' . $user_ID;

    return $classes;

    return 'user-id-' . $user_ID;
}


//change bid name in pdf
add_filter( 'gfpdf_field_label', function ( $label, $field, $entry ) {
    if ( $field->id === 5 ) {
        return 'Purchased Application ID(s)';
    }

    return $label;
}, 10, 3 );

add_action( 'gfpdf_pre_html_fields', function ( $entry, $config ) {
    echo 'Thank you! Your payment has been processed.';
    echo '</br>';
}, 10, 2 );

//add bid details to pdf
add_action( 'gfpdf_post_html_fields', function ( $entry, $config ) {
    $form     = 5;
    $field_id = 5; // Update this number to your field id number
    $field    = RGFormsModel::get_field( $form, $field_id );
    $value    = is_object( $field ) ? $field->get_value_export( $entry ) : '';
    $bid_ids  = explode( ',', $value );

    foreach ( $bid_ids as $bid ) {
        echo '<br>';
        echo '<strong>Purchased Links:</strong>';
        echo '<br>Link URL: ' . get_field( 'url_domain', $bid );
        echo '<br>Domain Authority: ' . get_field( 'domain_authority', $bid );
        echo '<br>Price: $' . get_field( 'bid_budget', $bid );
        echo '<br>';
        echo '<hr>';
    }

}, 10, 2 );

//exclude bid ids from invoice
add_filter( 'gform_field_css_class_5', 'custom_class2', 10, 3 );
function custom_class2( $classes, $field, $form ) {
    if ( $field->type == 'checkbox' ) {
        $classes .= ' exclude';
    }

    return $classes;
}

//dynamically populate bid checkout checkboxes

add_filter( 'gform_pre_render_5', 'populate_checkbox' );
add_filter( 'gform_pre_validation_5', 'populate_checkbox' );
add_filter( 'gform_pre_submission_filter_5', 'populate_checkbox' );
add_filter( 'gform_admin_pre_render_5', 'populate_checkbox' );
function populate_checkbox( $form ) {

    $parent_post = get_the_ID();

    foreach ( $form['fields'] as $field ) {

        // echo $parent_post;

        //NOTE: replace 3 with your checkbox field id
        $field_id = 5;
        if ( $field->id != $field_id ) {
            continue;
        }
        $user_ID = get_current_user_id();
        // you can add additional parameters here to alter the posts that are retreieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $projects = new WP_Query(
            array(
                'posts_per_page'   => - 1,
                'is_author'        => true,
                'post_type'        => PROJECT,
                'author'           => $user_ID,
                'suppress_filters' => true,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_status'      => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'complete', 'cancelled', 'deleted-accepted-app', 'no-app', 'active-app', 'accepted-app' ),
            )
        );
        $post_parent_in = array();
        if ($projects->posts) {

          foreach ($projects->posts as $project_post) {
            $post_parent_in[] = $project_post->ID;
          }
          $bids = new WP_Query( array(
                  'post_type'      => BID,
                  'post_parent__in' => $post_parent_in,
                  'posts_per_page' => -1,
                  'post_status'      => array( 'publish' ),
              )
          );
          //$posts = get_posts( 'numberposts=-1&post_status=publish&post_type=bid&posts_per_page=-1');

          $input_id = 1;
          foreach ( $bids->posts as $post ) {

              //skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
              /*if ( $input_id % 10 == 0 ) {
                  $input_id++;
              }*/

              $choices[] = array( 'text' => $post->ID, 'value' => $post->ID );
              $inputs[]  = array( 'label' => $post->ID, 'id' => "{$field_id}.{$input_id}" );

              $input_id ++;
          }

          $field->choices = $choices;
          $field->inputs  = $inputs;
        }

    }

    return $form;
}


add_action( 'gform_post_payment_completed', 'update_bid_status', 10, 8 );
function update_bid_status( $entry, $action ) {
  GFCommon::log_debug( 'DONE_FORM: $rule => ' . $action["type"] );
    if ( $action['type'] == 'complete_payment' ) {
        GFCommon::log_debug( __METHOD__ . '(): payment is complete.' );

        $field_id       = 5; // Update this number to your field id number
        $field          = RGFormsModel::get_field( 5, $field_id );
        $value          = is_object( $field ) ? $field->get_value_export( $entry ) : '';
        $bid_ids        = explode( ',', $value );
        $project_number = rgar( $entry, 6 );

        $amount      = $entry['payment_amount'];
        $post_author = get_post_field( 'post_author', $project_number );
        $author_data = get_userdata( $post_author );
        $ca_email    = $author_data->user_email;
        //tapfiliate code
        echo '<script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
            <script type="text/javascript">
              (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,"tap");
              tap("create", "8498-5cbe8a");
              tap("conversion", "' . $ca_email . '", ' . $amount . ', {customer_id: "' . $ca_email . '"});
            </script>';
        // Removed from Script
        // tap("conversion", "123456");

        foreach ( $bid_ids as $accepted_bid ) {

            $bid_author = get_post_field( 'post_author', $accepted_bid );

            $date_complete = rgar( $entry, 'date_created' );

            //add completion date
            update_field( 'field_5babb29cabef9', $date_complete, $accepted_bid );


            $post = array( 'ID' => $accepted_bid, 'post_status' => 'accept' );
            wp_update_post( $post );

            $notification_title = get_the_title( $project_number );

            //add notification
            $notification_array = array(
                'post_title'   => 'Bid for ' . $notification_title . ' has been accepted',
                'post_content' => 'type=bid_accept&amp;project=' . $project_number . '&bid_id_2=' . $accepted_bid,
                'post_author'  => $bid_author,
                'post_excerpt' => 'type=bid_accept&amp;project=' . $project_number . '&bid_id_2=' . $accepted_bid,
                'post_type'    => 'notify',
                'post_status'  => 'publish'
            );

            wp_insert_post( $notification_array );

            $args = array();
            $current_user = get_current_user_id();
            $args['project_id'] = wp_get_post_parent_id($accepted_bid);
            $args['author_id'] = $bid_author;
            $args['sender_id'] = $current_user;
            $args['message'] = '[@linkable_status@],bid_accepted,' . $accepted_bid . ',[/@linkable_status@]';
            $message = new LAPrivateMessaging();
            $message = $message->create_message($args, true);

            add_post_meta( $project_number, 'accepted', $accepted_bid );

            //---------- SEND EMAIL TO AUTHOR ----------*/
            $author_data  = get_userdata( $bid_author );
            $author_email = $author_data->user_email;
            $first_name   = $author_data->first_name;

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: Link-able <noreply@link-able.com>'
            );
            $body    = '<html><body><p>Hi ' . $first_name . ',</p><p>Congratulations! Your job contract was just accepted by the client!</p><p><strong>What you need to do:</strong></p><p>Now that your contract was accepted, you need to work on completing it within the timeframe you promised. Login to Link-able and visit your accepted contract’s workroom to view all the details. You’ll find it under My Contracts -> Active -> Go to workroom OR by simply visiting:</p><p><a href="' . get_permalink( $accepted_bid ) . '">' . get_permalink( $accepted_bid ) . '</a></p><p><strong>Remember:</strong></p><p>It’s important that you follow our link building rules and complete the contract exactly as you promised the client. We highly recommend that you reach out to us via our live chat if you need any help or have any questions about the contract. Your success is our success!</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

            wp_mail( $author_email, 'Your job contract on Link-able was accepted!', $body, $headers );

            /* ---------- END EMAIL TO AUTHOR ---------- */

            /* ------------------ add invoice post for author --------------*/
            // Initialize the page ID to -1. This indicates no action has been taken.
            $post_id = - 1;

            // Setup the author, slug, and title for the post
            $author_id = $bid_author;

            $i        = 1;
            $slug     = $author_id;
            $new_slug = $author_id . date();
            $title    = $new_slug;

            $current_use  = $author_id;
            $current_date = date( "m/d/Y" );
            $user_name    = get_user_meta( $author_id, 'display_name', true );
            $return_value = $user_name . ' ' . $current_date;

            $author_price = get_post_meta( $accepted_bid, 'bid_budget', true );

            // If the page doesnt already exist, then create it
            //if( null == get_page_by_title( $title ) ) {

            // Set the post ID so that we know the post was created successfully
            $post_id = wp_insert_post(
                array(
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_author'    => $author_id,
                    'post_name'      => $return_value,
                    'post_title'     => $return_value,
                    'post_status'    => 'publish',
                    'post_type'      => 'invoices'
                )
            );

            //bid number
            $project_num = rgar( $entry, 6 );
            update_field( 'field_5b7c3d9666531', $accepted_bid, $post_id );

            //amount
            $total_paid = rgar( $entry, 2 );

            $comm_rate = get_field( 'commission_rate_%', 'option' );
            $author_price = $author_price * (1-($comm_rate/100));

            update_field( 'field_5b7c3da966532', $author_price, $post_id );

            //project posted date
            // $project_date = get_the_date( 'm/d/Y', $project_num );
            // update_field( 'field_5b7c3db466533', $project_date, $post_id );
            // correct date complited generate after author complited (gform_6)

            //payment status
            update_field( 'field_5b7c3dc366535', 'Awaiting your completion', $post_id );

            //payment date
            update_field( 'field_5b7c3dbc66534', 'Pending', $post_id );


            //add invoice ID to bid
            update_field( 'author_invoice_id', $post_id, $accepted_bid );
            update_field( 'owner_invoice_id', $post_id, $accepted_bid );

            /* ------------------ end invoice post for author --------------*/

            /* ------------------ add invoice post for owner --------------*/
            // Initialize the page ID to -1. This indicates no action has been taken.
            $post_id = - 1;

            // Setup the author, slug, and title for the post
            $author_id = $entry['created_by'];

            $i        = 1;
            $slug     = $author_id;
            $new_slug = $author_id . date();
            $title    = $new_slug;

            $current_use  = $author_id;
            $current_date = date( "m/d/Y" );
            $user_name    = get_user_meta( $author_id, 'display_name', true );
            $return_value = $user_name . ' ' . $current_date;

            // If the page doesnt already exist, then create it
            //if( null == get_page_by_title( $title ) ) {

            // Set the post ID so that we know the post was created successfully
            $post_id = wp_insert_post(
                array(
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_author'    => $author_id,
                    'post_name'      => $return_value,
                    'post_title'     => $return_value,
                    'post_status'    => 'publish',
                    'post_type'      => 'invoices'
                )
            );

            //project number
            $project_num = rgar( $entry, 6 );
            update_field( 'field_5bfc6d5079e39', $project_num, $post_id );

            //bid id
            update_field( 'field_5b7c3d9666531', $accepted_bid, $post_id );

            //amount
            $total_paid = rgar( $entry, 2 );
            update_field( 'field_5b7c3da966532', $total_paid, $post_id );

            //project posted date
            // $project_date = get_the_date( 'm/d/Y', $project_num );
            // update_field( 'field_5b7c3db466533', $project_date, $post_id );

            //payment status
            update_field( 'field_5b7c3dc366535', 'paid', $post_id );

            //entry ID
            $entry_id = $entry['id'];
            update_field( 'field_5b7cc4dbf9dd1', $entry_id, $post_id );

            //payment date
            update_field( 'field_5b7c3dbc66534', $current_date, $post_id );

            //add invoice ID to bid
            update_field( 'owner_invoice_ids', $post_id . ' ', $project_num );
            update_field( 'field_5bfcb59e09695', $post_id, $accepted_bid );

        }


    }

    GFCommon::log_debug( __METHOD__ . '(): update bid status is running' );
}


//update status of bid after paypal is complete
//add_action( 'gform_paypal_fulfillment', 'process_linkable_order', 10, 4 );
//add_action( 'gform_after_submission_5', 'testing_bid_ids', 10, 2 );
function process_linkable_order( $entry, $form, $feed, $transaction_id, $amount ) {

//function testing_bid_ids($entry,$form) {
    $todays_date    = rgar( $entry, 'date_created' );
    $field_id       = 5; // Update this number to your field id number
    $field          = RGFormsModel::get_field( $form, $field_id );
    $value          = is_object( $field ) ? $field->get_value_export( $entry ) : '';
    $bid_ids        = explode( ',', $value );
    $project_number = rgar( $entry, 6 );
    $current_date   = date( "d/m/Y" );


    foreach ( $bid_ids as $accepted_bid ) {

        $bid_author = get_post_field( 'post_author', $accepted_bid );

        $post = array( 'ID' => $accepted_bid, 'post_status' => 'accept' );
        wp_update_post( $post );

        $notification_title = get_the_title( $project_number );

        //add notification
        $notification_array = array(
            'post_title'   => 'Bid for ' . $notification_title . ' has been accepted',
            'post_content' => 'type=bid_accept&amp;project=' . $project_number,
            'post_author'  => $bid_author,
            'post_excerpt' => 'type=bid_accept&amp;project=' . $project_number,
            'post_type'    => 'notify',
            'post_status'  => 'publish'
        );

        wp_insert_post( $notification_array );

        add_post_meta( $project_number, 'accepted', $accepted_bid );

        update_field( 'field_5babb29cabef9', $current_date, $accepted_bid );

        //add invoice post
        // Initialize the page ID to -1. This indicates no action has been taken.
        $post_id = - 1;

        // Setup the author, slug, and title for the post
        $author_id = $current_user->ID;

        $i        = 1;
        $slug     = $current_user->ID;
        $new_slug = $current_user->ID . date();
        $title    = $new_slug;

        $current_use  = wp_get_current_user();
        $current_date = date( "d/m/Y" );
        $return_value = $current_use->user_login . ' ' . $current_date;

        // If the page doesnt already exist, then create it
        //if( null == get_page_by_title( $title ) ) {

        // Set the post ID so that we know the post was created successfully
        $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'post_author'    => $author_id,
                'post_name'      => $return_value,
                'post_title'     => $return_value,
                'post_status'    => 'publish',
                'post_type'      => 'invoices'
            )
        );

        update_field( 'field_5b7c3dbc66534', 'testing testing', $post_id );

        //project number
        $project_num = rgar( $entry, 6 );
        update_field( 'field_5bfc6d5079e39', $project_num, $post_id );

        //bid id
        update_field( 'field_5b7c3d9666531', $accepted_bid, $post_id );

        //amount
        $total_paid = rgar( $entry, 2 );
        update_field( 'field_5b7c3da966532', $total_paid, $post_id );

        //project posted date
        // $project_date = get_the_date( 'm/d/Y', $project_num );
        // update_field( 'field_5b7c3db466533', $project_date, $post_id );

        //payment submitted date (today)
        $date_payment = $entry['date_created'];


        //payment status
        update_field( 'field_5b7c3dc366535', 'paid', $post_id );

        //entry ID
        $entry_id = $entry['id'];
        update_field( 'field_5b7cc4dbf9dd1', $entry_id, $post_id );

        // Otherwise, we'll stop
        //} else {

        // Arbitrarily use -2 to indicate that the page with the title already exists
        //$post_id = -2;

        //} // end if
    }


}

//verify website
function checkExternalFile2( $url ) {
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_NOBODY, true );
    curl_exec( $ch );
    $retCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close( $ch );

    return $retCode;
}

//$fileExists = checkExternalFile($_POST['website-url'] . '/randomfile-5678.txt');


//sample ajax
function example_ajax_request() {

    $message = $_REQUEST['message'];

    // The $_REQUEST contains all the data sent via ajax
    if ( isset( $_REQUEST ) ) {

        //print_r($_REQUEST);


        $fileExists  = checkExternalFile2( $_REQUEST['file_path'] );
        $fileExists2 = checkExternalFile2( $_REQUEST['file_path2'] );


        if ( $fileExists == 200 || $fileExists2 == 200 ) {
            echo 'Your website was successfully verified.';
            //get current user id
            $acf_id = 'user_' . get_current_user_id();
            //echo $acf_id;

            //add row to repeater field
            $row = array(
                'field_5b783d35b41a1' => $_REQUEST['website_url'],
                'field_5b783da962c9e' => 1
            );

            add_row( 'field_5b783d22b41a0', $row, $acf_id );

        } else {
            $message = 'There was a problem verifying your website. Please try again.';
            echo $message;

        }


    }

    // Always die in functions echoing ajax content
    die();
}

add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );

// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );

function freelancer_rating_score( $freelancer_id ) {
    global $wpdb;
    $bid     = BID;
    $sql     = "SELECT AVG(M.meta_value)  as rate_point, COUNT(p.ID) as count
                from $wpdb->posts as  p
                    join $wpdb->postmeta as M
                        on M.post_id = p.ID
                Where p.post_author = $freelancer_id
                        and M.meta_key = 'rating_score'";
    $results = $wpdb->get_results( $sql );
    if ( $results ) {
        // update user meta
        //update_user_meta( $freelancer_id, 'rating_score', $results[0]->rate_point );

        // return value
        return array( 'rating_score' => $results[0]->rate_point, 'review_count' => $results[0]->count );
    } else {
        // update user meta
        //update_user_meta( $freelancer_id, 'rating_score', 0 );

        return array( 'rating_score' => 0, 'review_count' => 0 );
    }
}

//show prices on bid in wp-admin
add_action( 'add_meta_boxes_bid', 'add_contact_form_meta_box' );
function add_contact_form_meta_box() {
    add_meta_box( 'bid-budget-meta-box', 'Content Author Price', 'contact_form_meta_box' );
    add_meta_box( 'owner-price-meta-box', 'Content Marketer Price', 'contact_form_meta_box2' );
    add_meta_box(
        'url_of_page_author_link',
        'Page URL where user will link to',
        'url_of_page_author_link_cb'
    );
}

function contact_form_meta_box( $post ) {
    // echo '$' . get_post_meta( $post->ID, 'owner_price', true );
    echo '$';
	$cm_do_price = get_field( 'dofollow_price', $post->ID );
	$comm_rate = get_field('commission_rate_%','option');
	$author_do_price = $cm_do_price * (1-($comm_rate/100));
	if( $author_do_price > 0) {
		echo $author_do_price;
	} else {
		echo get_post_field( 'owner_price', $post->ID );
	}
}

function contact_form_meta_box2( $post ) {
    echo '$' . get_post_meta( $post->ID, 'bid_budget', true );
}

function url_of_page_author_link_cb( $post ) {
    echo get_post_meta( $post->ID, 'url_of_page_you_want_to_build_a_link_to', true );
    // update_post_meta($post->ID, 'url_of_page_you_want_to_build_a_link_to', 'https://mywebsite.com/test-page');
}

function restrict_admin_with_redirect() {

    if ( ! current_user_can( 'manage_options' ) && ( ! wp_doing_ajax() ) ) {
        wp_safe_redirect( get_home_url() . '/dashboard' ); // Replace this with the URL to redirect to.
        exit;
    }
}

//move tooltips on gravity forms
add_filter( 'gform_pre_render', 'gravity_tooltips' );
function gravity_tooltips( $form ) {
    ?>
    <script>

        jQuery(document).bind('gform_page_loaded', function () {

            jQuery(".gfield_description").each(function () {
                jQuery(this).hide();
            });

            //insert gravity form descriptions as tooltips
            var tooltipParent = jQuery(this).parent().find('.list-item');
            jQuery(".gfield_description").each(function () {
                tooltipParent.prepend(jQuery(this));
            });

        });
    </script>
    <?php

    return $form;
}


//add_action( 'admin_init', 'restrict_admin_with_redirect', 1 );

function possibly_redirect() {
    /*$user = wp_get_current_user();
    $role = ( array ) $user->roles;
    $u_r = $role[0];*/


    global $pagenow;
    echo $pagenow;
    if ( 'wp-login.php' == $pagenow ) {

        echo 'LOGIN PAGE!';
        print_r( $_POST );
        print_r( $_GET );

        /*if ( isset( $_POST['wp-submit'] ) ||   // in case of LOGIN
      ( isset($_GET['action']) && $_GET['action']=='logout') ||   // in case of LOGOUT
      ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm') ||   // in case of LOST PASSWORD
      ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered') ) return;    // in case of REGISTER
    //else wp_safe_redirect( home_url('/login') ); // or wp_redirect(home_url('/login'));
    //exit();*/
    }
}

//add_action('init','possibly_redirect');

//add_action('init','set_login_cookie');
function set_login_cookie() {
    wp_set_current_user( $user_id );
    if ( wp_validate_auth_cookie() == false ) {
        wp_set_auth_cookie( $user_id, true, false );
    }
}


add_filter( 'gform_entry_field_value', function ( $value, $field, $entry, $form ) {
    $classes = array(
        'GF_Field_Checkbox',
        'GF_Field_MultiSelect',
        'GF_Field_Radio',
        'GF_Field_Select',
    );

    foreach ( $classes as $class ) {
        if ( $field instanceof $class ) {
            $value = $field->get_value_entry_detail( RGFormsModel::get_lead_field_value( $entry, $field ), $currency = '', $use_text = true, $format = 'html' );
            break;
        }
    }

    return $value;
}, 10, 4 );

function add_author_support_to_posts() {
    add_post_type_support( 'bid', 'author' );
}

add_action( 'init', 'add_author_support_to_posts' );

//deregister unused post types
function delete_post_type() {
    unregister_post_type( 'fre_profile' );
    unregister_post_type( 'portfolio' );
    unregister_post_type( 'pack' );
    unregister_post_type( 'bid_plan' );
}

add_action( 'init', 'delete_post_type', 100 );

add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    // if there's a valid referrer, and it's not the default log-in screen
    if ( ! empty( $referrer ) && ! strstr( $referrer, 'wp-login' ) && ! strstr( $referrer, 'wp-admin' ) ) {
        wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
        exit;
    }

}

//make sure there aren't duplicate entries for domain value overrides

add_filter( 'acf/validate_value/key=field_5c07f4b9f935d', 'acf_unique_repeater_sub_field', 10, 4 );
function acf_unique_repeater_sub_field( $valid, $value, $field, $input ) {
    // set up an array to hold all submitted values for rows
    $list = array();
    foreach ( $_POST['acf']['field_5c07f4b1f935c'] as $row ) {
        $domain_new = parse_url( $row['field_5c07f4b9f935d'] );
        $domain_new = $domain_new['host'];
        $domain_new = str_replace( 'www.', '', $domain_new );

        if ( in_array( $domain_new, $list ) ) {
            // this one already exists
            $valid = 'There are duplicate ' . $field['name'] . ' values';
            // found a duplicate so we don't need to continue looping
            break;
        }
        // add the value of this row to the list
        $list[] = $domain_new;
    }

    return $valid;
}

//remove unused wp-admin items
function custom_menu_page_removing() {
    remove_menu_page( 'edit.php' );                   //Posts
    remove_menu_page( 'edit-comments.php' );          //Comments
}

add_action( 'admin_menu', 'custom_menu_page_removing' );

function remove_engine_menu() {
    remove_menu_page( 'et-overview' );
}

add_action( 'admin_init', 'remove_engine_menu' );
/*
add_action( 'admin_init', 'wpse_136058_debug_admin_menu' );

function wpse_136058_debug_admin_menu() {

    echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
}

*/

/**
 * Gravity Wiz // Gravity Forms Post Content Merge Tags
 *
 * Adds support for using Gravity Form merge tags in your post content. This functionality requires that the entry ID is
 * is passed to the post via the "eid" parameter.
 *
 * Setup your confirmation page (requires GFv1.8) or confirmation URL "Redirect Query String" setting to
 * include this parameter: 'eid={entry_id}'. You can then use any entry-based merge tag in your post content.
 *
 * @version   1.2
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/...
 * @video     http://screencast.com/t/g6Y12zOf4
 * @copyright 2014 Gravity Wiz
 */
class GW_Post_Content_Merge_Tags {

    public static $_entry = null;

    private static $instance = null;

    public static function get_instance( $args = array() ) {

        if ( self::$instance == null ) {
            self::$instance = new self( $args );
        }

        return self::$instance;
    }

    function __construct( $args ) {

        if ( ! class_exists( 'GFForms' ) ) {
            return;
        }

        $this->_args = wp_parse_args( $args, array(
            'auto_append_eid' => true, // true, false or array of form IDs
            'encrypt_eid'     => false,
        ) );

        add_filter( 'the_content', array( $this, 'replace_merge_tags' ), 1 );
        add_filter( 'gform_replace_merge_tags', array( $this, 'replace_encrypt_entry_id_merge_tag' ), 10, 3 );

        if ( ! empty( $this->_args['auto_append_eid'] ) ) {
            add_filter( 'gform_confirmation', array( $this, 'append_eid_parameter' ), 20, 3 );
        }

    }

    function replace_merge_tags( $post_content ) {

        $entry = $this->get_entry();
        if ( ! $entry ) {
            return $post_content;
        }

        $form = GFFormsModel::get_form_meta( $entry['form_id'] );

        $post_content = $this->replace_field_label_merge_tags( $post_content, $form );
        $post_content = GFCommon::replace_variables( $post_content, $form, $entry, false, false, false );

        return $post_content;
    }

    function replace_field_label_merge_tags( $text, $form ) {

        preg_match_all( '/{([^:]+?)}/', $text, $matches, PREG_SET_ORDER );
        if ( empty( $matches ) ) {
            return $text;
        }

        foreach ( $matches as $match ) {

            list( $search, $field_label ) = $match;

            foreach ( $form['fields'] as $field ) {

                $full_input_id       = false;
                $matches_admin_label = rgar( $field, 'adminLabel' ) == $field_label;
                $matches_field_label = false;

                if ( is_array( $field['inputs'] ) ) {
                    foreach ( $field['inputs'] as $input ) {
                        if ( GFFormsModel::get_label( $field, $input['id'] ) == $field_label ) {
                            $matches_field_label = true;
                            $input_id            = $input['id'];
                            break;
                        }
                    }
                } else {
                    $matches_field_label = GFFormsModel::get_label( $field ) == $field_label;
                    $input_id            = $field['id'];
                }

                if ( ! $matches_admin_label && ! $matches_field_label ) {
                    continue;
                }

                $replace = sprintf( '{%s:%s}', $field_label, (string) $input_id );
                $text    = str_replace( $search, $replace, $text );

                break;
            }

        }

        return $text;
    }

    function replace_encrypt_entry_id_merge_tag( $text, $form, $entry ) {

        if ( strpos( $text, '{encrypted_entry_id}' ) === false ) {
            return $text;
        }

        // $entry is not always a "full" entry
        $entry_id = rgar( $entry, 'id' );
        if ( $entry_id ) {
            $entry_id = $this->prepare_eid( $entry['id'], true );
        }

        return str_replace( '{encrypted_entry_id}', $entry_id, $text );
    }

    function append_eid_parameter( $confirmation, $form, $entry ) {

        $is_ajax_redirect = is_string( $confirmation ) && strpos( $confirmation, 'gformRedirect' );
        $is_redirect      = is_array( $confirmation ) && isset( $confirmation['redirect'] );

        if ( ! $this->is_auto_eid_enabled( $form ) || ! ( $is_ajax_redirect || $is_redirect ) ) {
            return $confirmation;
        }

        $eid = $this->prepare_eid( $entry['id'] );

        if ( $is_ajax_redirect ) {
            preg_match_all( '/gformRedirect.+?(http.+?)(?=\'|")/', $confirmation, $matches, PREG_SET_ORDER );
            list( $full_match, $url ) = $matches[0];
            $redirect_url = add_query_arg( array( 'eid' => $eid ), $url );
            $confirmation = str_replace( $url, $redirect_url, $confirmation );
        } else {
            $redirect_url             = add_query_arg( array( 'eid' => $eid ), $confirmation['redirect'] );
            $confirmation['redirect'] = $redirect_url;
        }

        return $confirmation;
    }

    function prepare_eid( $entry_id, $force_encrypt = false ) {

        $eid        = $entry_id;
        $do_encrypt = $force_encrypt || $this->_args['encrypt_eid'];

        if ( $do_encrypt && is_callable( array( 'GFCommon', 'encrypt' ) ) ) {
            $eid = rawurlencode( GFCommon::encrypt( $eid ) );
        }

        return $eid;
    }

    function get_entry() {

        if ( ! self::$_entry ) {

            $entry_id = $this->get_entry_id();
            if ( ! $entry_id ) {
                return false;
            }

            $entry = GFFormsModel::get_lead( $entry_id );
            if ( empty( $entry ) ) {
                return false;
            }

            self::$_entry = $entry;

        }

        return self::$_entry;
    }

    function get_entry_id() {

        $entry_id = rgget( 'eid' );
        if ( $entry_id ) {
            return $this->maybe_decrypt_entry_id( $entry_id );
        }

        $post = get_post();
        if ( $post ) {
            $entry_id = get_post_meta( $post->ID, '_gform-entry-id', true );
        }

        return $entry_id ? $entry_id : false;
    }

    function maybe_decrypt_entry_id( $entry_id ) {

        // if encryption is enabled, 'eid' parameter MUST be encrypted
        $do_encrypt = $this->_args['encrypt_eid'];

        if ( ! $entry_id ) {
            return null;
        } else if ( ! $do_encrypt && is_numeric( $entry_id ) && intval( $entry_id ) > 0 ) {
            return $entry_id;
        } else {
            // gEYs6Cqzh1akKc7Y4RGkV8HtcJqQZRmNH+ONxuFEvXM
            // 0FSCGpzzmt+4Y05fFsJ4ipRZfqD/zdi2ecEeMMRKCjc=
            $entry_id = is_callable( array( 'GFCommon', 'decrypt' ) ) ? GFCommon::decrypt( $entry_id ) : $entry_id;

            return intval( $entry_id );
        }

    }

    function is_auto_eid_enabled( $form ) {

        $auto_append_eid = $this->_args['auto_append_eid'];

        if ( is_bool( $auto_append_eid ) && $auto_append_eid === true ) {
            return true;
        }

        if ( is_array( $auto_append_eid ) && in_array( $form['id'], $auto_append_eid ) && $form['id'] != 15 ) {
            return true;
        }

        return false;
    }

}

function gw_post_content_merge_tags( $args = array() ) {
    return GW_Post_Content_Merge_Tags::get_instance( $args );
}

gw_post_content_merge_tags();

add_filter( 'gform_ip_address', 'filter_gform_ip_address' );

function filter_gform_ip_address( $ip ) {
    // Return the IP address set by the proxy.
    // E.g. $_SERVER['HTTP_X_FORWARDED_FOR'] or $_SERVER['HTTP_CLIENT_IP']
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
}


//send email to author when google doc is approved
add_action( 'transition_post_status', 'send_mails_on_google_approval', 10, 3 );
function send_mails_on_google_approval( $new_status, $old_status, $post ) {
    if ( 'admin-review' == $new_status && ( 'accept' == $old_status ) && 'bid' == get_post_type( $post ) ) {


        //---------- SEND AUTHOR EMAIL ----------*/

        $project_id    = get_the_ID();
        $project_link  = get_post_permalink( $project_id );
        $project_title = get_the_title( $project_id );

        $project_author_id = get_post_field( 'post_author', $project_id );
        $author_data       = get_userdata( $project_author_id );
        $author_email      = $author_data->user_email;
        $author_first_name = $author_data->first_name;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Link-able <noreply@link-able.com>'
        );
        $body    = '<html><body><p>Hi ' . $author_first_name . ',</p><p>Good news! We just finished reviewing your article for <strong>' . $project_title . '</strong> and have marked it as approved! Good job!</p><p><strong>What\'s next?</strong></p><p>Login to Link-able and visit your contract’s workroom:</p><p><a href="' . $project_link . '">' . $project_link . '</a></p><p>From there, you can now move on to the next step - which involves publishing your article and then marking your contract as complete on Link-able.</p><p><strong>Need help?</strong></p><p>If you need help or have any questions, just let us know via our live chat!</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

        wp_mail( $author_email, 'Your article has been approved for publication!', $body, $headers );

        /* ---------- SEND AUTHOR EMAIL ---------- */

    }
}


//send email to author when google doc is disapproved
add_action( 'acf/save_post', 'send_mails_on_google_disapproval', 20, 1 );
function send_mails_on_google_disapproval( $post_id ) {
    // bail early if no ACF data
    if ( empty( $_POST['acf'] ) ) {

        return;

    }

    //die(print_r($_POST));

    $post_status    = get_post_status( $post_id );
    $need_revisions = $_POST['acf']['field_5c41f808c9ef7'][0];

    if ( $post_status == 'accept' && $need_revisions === 'yes' ) {


        //---------- SEND AUTHOR EMAIL ----------*/

        $project_id    = get_the_ID();
        $project_link  = get_post_permalink( $project_id );
        $project_title = get_the_title( $project_id );

        $google_link = get_field( 'google_doc_link', $project_id );

        $project_author_id = get_post_field( 'post_author', $project_id );
        $author_data       = get_userdata( $project_author_id );
        $author_email      = $author_data->user_email;
        $author_first_name = $author_data->first_name;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Link-able <noreply@link-able.com>'
        );
        $body    = '<html><body><p>Hi ' . $author_first_name . ',</p><p>We just finished reviewing your article for <strong><a href="' . $project_link . '">' . $project_title . '</a></strong> and unfortunately, we could not approve it for publication.</p><p><strong>Why was my article not approved?</strong></p><p>There could be a number of reasons for this, but quality is very important to us and the article somehow did not meet our quality standards. We have added comments as to why your article was not approved.</p><p><strong>What\'s next?</strong></p><p>Visit your article and review our comments:</p><p><a href="' . $google_link . '">' . $google_link . '</a></p><p>Please make any requested edits to your article and resubmit your work on Link-able in your contract\'s workroom after you\'ve made them. We will re-review your article and reevaluate our approval decision. If the revised article meet our quality standards, we will then approve it and you can continue on to the next step.</p><p><strong>IMPORTANT:</strong></p><p><em>Do NOT publish your article yet</em>! Our clients deserve incredible quality backlinks placed on incredible quality articles. Your article was not approved because we felt it has not met our quality standards. If you were to publish your article now, without our approval, you will not be paid for this contract!</p><p><strong>Need help?</strong></p><p>If you need help or have any questions with your contract, just let us know via our live chat!</p><p>Cheers!</p><p>The Link-able Team</p></body></html>';

        wp_mail( $author_email, 'Your article was NOT approved for publication.', $body, $headers );

        /* ---------- SEND AUTHOR EMAIL ---------- */

    }
}

//disalbe search auto refresh
function fwp_disable_auto_refresh() {
    ?>
    <script>
        (function ($) {
            $(function () {
                if ('undefined' !== typeof FWP) {
                    FWP.auto_refresh = false;
                }
            });
        })(jQuery);
    </script>
    <?php
}

add_action( 'wp_head', 'fwp_disable_auto_refresh', 100 );

//add_filter( 'gform_submit_button_1', 'add_ga_onclick', 10, 2 );
function add_ga_onclick( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( $button );
    $input     = $dom->getElementsByTagName( 'input' )->item( 0 );
    $onclick   = $input->getAttribute( 'onclick' );
    $permalink = get_permalink();
    $onclick   .= " gtag_report_conversion('" . $permalink . "');";
    $input->setAttribute( 'onclick', $onclick );

    return $dom->saveHtml( $input );
}

add_filter( 'gform_confirmation_1', 'custom_confirmation_message', 10, 4 );
function custom_confirmation_message( $confirmation, $form, $entry, $ajax ) {
    $confirmation .= "<!-- Event snippet for CM Signup conversion page --><script>gtag('event', 'conversion', {'send_to': 'AW-733115435/haMICIOA5qIBEKvoyd0C'});</script>";

    return $confirmation;
}

//map fields after submission of inquiry form
add_action( 'gform_after_submission_18', 'map_inquiry_fields', 10, 2 );
function map_inquiry_fields( $entry, $form ) {
    $project_id = rgar( $entry, 2 );
    // $entry_date         = rgar( $entry, 'date_created' );
    $inquiry_message = rgar( $entry, 4 );
    // $repeater_input = rgar($entry,1);
    // $repeater_input = unserialize($repeater_input);
    $author_id = $entry['created_by'];
    // Action for Private Messaging
    do_action( 'la_inquiry_message_submit', $project_id, $inquiry_message, $author_id );
    /*
    foreach($repeater_input as $line) {
        $url = $line['URL'];
        $follow_type = $line['Follow Type'];

        $domain_calc = $url;

        // ----------------------------------- START OF DA CALCULATION --------------------------------------

        // MOZ API CALL

        $domain_authority = 0;

            // Get your access id and secret key here: https://moz.com/products/api/keys
            $accessID = "mozscape-d19b96ee83";
            $secretKey = "c8d7a78da00e772bc8257143f9d38972";

            //old paid API credentials
            //$accessID = "mozscape-db140bc87e";
            //$secretKey = "c4bdc40952faf45b502960c6e42c4c63";


            // Set your expires times for several minutes into the future.
            // An expires time excessively far in the future will not be honored by the Mozscape API.
            $expires = time() + 300;

            // Put each parameter on a new line.
            $stringToSign = $accessID."\n".$expires;

            // Get the "raw" or binary output of the hmac hash.
            $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

            // Base64-encode it and then url-encode that.
            $urlSafeSignature = urlencode(base64_encode($binarySignature));

            // Specify the URL that you want link metrics for.
            $objectURL = $domain_calc;

            // Add up all the bit flags you want returned.
            // Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
            $cols = "68719476736";

            // Put it all together and you get your request URL.
            // This example uses the Mozscape URL Metrics API.
            $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

            // Use Curl to send off your request.
            $options = array(
                CURLOPT_RETURNTRANSFER => true
                );

            $ch = curl_init($requestUrl);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            curl_close($ch);

            //print_r($content);

            $b = json_decode($content,true);
            $domain_authority = $b['pda'];
            //echo $domain_authority;

            // END MOZ API CALL


          //$domain_authority = 85;
          $price_from_da = 0; //price based on pricing grid on options page
          $follow_multiplier = 1;
          $commission = get_field('commission_rate_%','option');

          //get multipliers
            if( have_rows('follow_type_calculation','option') ): ?>


            <?php while( have_rows('follow_type_calculation','option') ): the_row();

                // vars
                $no_follow_mult = get_sub_field('nofollow_multiplier');
                $do_follow_mult = get_sub_field('dofollow_multiplier');


                ?>

            <?php endwhile; ?>

        <?php endif;

          //get price from grid based on DA
          $override_exists = false;

          //first see if domain has an override
          if( have_rows('domain_overrides','option') ) {
              while( have_rows('domain_overrides','option') ): the_row();
                      $domain_name = get_sub_field('domain_override_field');
                      $domain_name = parse_url($domain_name);
                      $domain_name = $domain_name['host'];
                      $domain_name = str_replace('www.','',$domain_name);
                      $domain_name = strtolower($domain_name);

                      //echo $domain_name;

                      $entered_domain = $url;
                      $entered_domain = parse_url($entered_domain);
                      $entered_domain = $entered_domain['host'];
                      $entered_domain = str_replace('www.','',$entered_domain);
                      $entered_domain = strtolower($entered_domain);

                      //echo $entered_domain;

                      if( $domain_name == $entered_domain) {
                          $override_exists = true;
                          //here we need to get the price
                          $price_from_da = get_sub_field('price');

                          break;
                      }



              endwhile;
          }

         // echo $override_exists;

          if($override_exists) {


          }else {

          if( have_rows('domain_authority_pricing_schedule','option') ): ?>



            <?php while( have_rows('domain_authority_pricing_schedule','option') ): the_row();

                // vars
                $low = get_sub_field('range_low');
                $high = get_sub_field('range_high');
                $price = get_sub_field('dollar_value');

                if ( ($domain_authority >= $low) && ($domain_authority <= $high) ) {
                    $price_from_da = $price;
                }

                ?>

            <?php endwhile; ?>

        <?php endif;

            }

            //grab domain authority from moz api
            //calc based on table


            //get domain authority selection
            if ($follow_type) {
                $radioVal = $follow_type;

                if($radioVal == "NoFollow") {
                    $follow_multiplier = $no_follow_mult;
                    ?>

                    <?php
                } else {
                    $follow_multiplier = $do_follow_mult;
                    ?>

                    <?php
                }
            }

             $owner_price = $price_from_da * $follow_multiplier;
               $paid_price = (1-($commission/100)) * $owner_price;
               $paid_price = number_format((float)$paid_price, 2, '.', '');

            // echo 'da is: ' . $domain_authority;
            // echo '<br/>owner price is: ' . $owner_price;
             //echo '<br/>author price is: ' . $paid_price;


        // ----------------------------------- END OF DA CALCULATION --------------------------------------


        //echo $url;
        //echo $follow_type;

        //add to repeater field
        $row = array(
            'author_id' => $author_id,
            'url' => $url,
            'follow_type' => $follow_type,
            'da' => $domain_authority,
            'price' =>  $owner_price
        );

        add_row('inquiries_made_for_this_project', $row, $project_id);

    }
    */
}

/**
 * Including all files for Messaging Service
 * @author Ainal Haq
 * @since version 1.0.92
 */

require_once dirname( __FILE__ ) . '/messaging/_loader.php';
// Linkable app
require_once dirname( __FILE__ ) . '/inc/app.php';

//Turn off Relevanssi Facet WP updates as we are using custom functionaity in this plugin as per Facet WP dev guidelines
/**
 * Prevent update notification for plugin
 * http://www.thecreativedev.com/disable-updates-for-specific-plugin-in-wordpress/
 * Place in theme functions.php or at bottom of wp-config.php
 */
function disable_plugin_updates( $value ) {
    if ( isset( $value ) && is_object( $value ) ) {
        if ( isset( $value->response['facetwp-relevanssi/facetwp-relevanssi.php'] ) ) {
            unset( $value->response['facetwp-relevanssi/facetwp-relevanssi.php'] );
        }
    }

    return $value;
}

add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

/**
 * Add Icon to Gravity form Button
 *
 * @param $button
 * @param $form
 *
 * @return string
 */
function input_to_button( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input      = $dom->getElementsByTagName( 'input' )->item( 0 );
    $new_button = $dom->createElement( 'button' );
    $new_button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) . ' ' ) );
    $input->removeAttribute( 'value' );
    foreach ( $input->attributes as $attribute ) {
        $new_button->setAttribute( $attribute->name, $attribute->value );
    }
    $btn_classes = $new_button->getAttribute( 'class' );
    $new_button->setAttribute( 'class', $btn_classes . ' btn la_btn_default la_gform_submit_btn' );
    $icon = $dom->createDocumentFragment();
    $icon->appendXML( '<span class="fab fa-telegram-plane"></span>' );
    $new_button->appendChild( $icon );
    $input->parentNode->replaceChild( $new_button, $input );

    return $dom->saveHtml( $new_button );
}

add_filter( 'gform_submit_button_6', 'input_to_button', 10, 2 );
add_filter( 'gform_submit_button_16', 'input_to_button', 10, 2 );

//Intercom custom user type attribute
add_filter( 'intercom_settings', 'intercom_user_type' );
function intercom_user_type( $settings ) {
    if ( is_user_logged_in() ) {
        $role = ae_user_role( $user_ID );
    }
	    if ( $role == 'freelancer' ) {
	        $intercom_role = 'author';
	    } else if ( $role == 'employer' ) {
	        $intercom_role = 'client';
	    } else {
	        $intercom_role = $role;
	    }

    $settings['user_type'] = $intercom_role;

    return $settings;

}

add_action( 'gform_after_submission_1', 'intercom_attributes', 10, 2 );

function intercom_attributes($entry, $form) {

	global $intercom_user_email;
	$intercom_user_email = rgar( $entry, '1' );

	add_filter( 'intercom_settings', 'registration_intercom' );

}

function registration_intercom($settings) {

	$settings['email'] = $intercom_user_email;

	$settings['user_type'] = 'pending client';

    return $settings;

}

// Gravity form Repeater field for Post a new project
function add_repeater_field_3( $form ) {
    $url              = GF_Fields::create( array(
        'type'        => 'text',
        'id'          => 1002,
        'formId'      => $form['id'],
        'placeholder' => 'Ex. https://mywebsite.com/specific-page-i-want-a-link-to/',
        'pageNumber'  => 1
    ) );
    $page_url         = GF_Fields::create( array(
        'type'             => 'repeater',
        'description'      => 'In general, authors will review your site and offer to build links to the most relevant page of their choice. For example, this could be a fact or statistic that they find on one of your blog articles. However, if you have any specific pages that you prefer to build links to, let them know here.',
        'id'               => 1000,
        'formId'           => $form['id'],
        'label'            => '8. Are there any specific pages on your website that you would prefer authors to build links to? Leave blank if there are none.',
        'addButtonText'    => '+ add another page',
        'removeButtonText' => '- remove page',
        'pageNumber'       => 1,
        'fields'           => array( $url ),
        'cssClass'         => 'gformRepeater_3'
    ) );
    $form['fields'][] = $page_url;

    return $form;
}

add_filter( 'gform_form_post_get_meta_3', 'add_repeater_field_3' );

// Wants to build backlinks to
function la_build_backlinks_to_markup( $preferred_pages ) {
    ob_start();
    $isEmpty = empty( $preferred_pages );
    ?>
    <div class="project-description no-underline attribute">
        <div class="project-header">Wants to Build Backlinks To:</div>
        <p style="margin-bottom: 5px;"><?= ! $isEmpty ? 'Client is open to building links to any page of their site, but has preference if you can link to:' : 'Client has no preference and is open to building links to any page of their website.' ?></p>
        <div class="multiple-click-wrapper">
            <?php
            if ( ! $isEmpty ) {
                $p_1002_ar = explode( "\n", $preferred_pages );
                if ( is_array( $p_1002_ar ) ) {
                    foreach ( $p_1002_ar as $item ) {
                        echo '<p style="margin-bottom:0; display: block;" class="click-to-copy-wrapper green bold"><span class="click-to-copy">' . $item . '</span></p>';
                    }
                } else {
                    echo '<a target="_blank" href="' . esc_url( $p_1002_ar ) . '">' . $p_1002_ar . '</a>';
                }
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

//intercom
function intercom_script_footer(){
  if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
	$user_hash = hash_hmac(
		  'sha256', // hash function
		  $current_user->user_email, // user's id
		  'JpQZuNmGSpM63OKOospxTKiBwQsiAOAxC-R1Jp9K' // secret key (keep safe!)
		);
	//echo 'hash: ' . $user_hash;
	?>
<script>

	//console.log(<?php echo $user_hash; ?>);

   /* Replace 'APP_ID' with your app ID */
    window.intercomSettings = {
    app_id: 'n8kh4ch9',
    email: '<?php echo $current_user->user_email; ?>',
    user_id: '<?php echo $current_user->id; ?>',
    name: '<?php echo $current_user->display_name; ?>',
    created_at: <?php echo strtotime(get_userdata($current_user->ID)->user_registered); ?>,
    user_hash: '<?php echo $user_hash; ?>'
};

<?php } else { ?>

<script>
   /* Replace 'APP_ID' with your app ID */
    window.intercomSettings = {
    app_id: 'n8kh4ch9',
};

<?php } ?>

// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/n8kh4ch9'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/n8kh4ch9';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>

<?php }
// To add intercom to the front end of your wordpress site:
add_action('wp_footer', 'intercom_script_footer');
//To add intercom to the admin area of your wordpress site:
add_action( 'admin_enqueue_scripts', 'intercom_script_footer' );

/* Remove Default WordPress Welcome Email
********************************************************/
function vc_mailtrap($phpmailer){
  if( strpos($phpmailer->Subject, 'Login Details') ){
        //remove all the recipients
        $phpmailer->ClearAllRecipients();
    }
}
add_action('phpmailer_init', 'vc_mailtrap');

add_filter('wp_mail', 'delete_welcome_email', 1);

function delete_welcome_email($atts) {
  if( strpos($atts['subject'], 'Login Details') ){
      $atts['to'] = '';
  }
  return $atts;
}
if ( !function_exists( 'wp_new_user_notification' ) ) :
function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
    return;
}
endif;

function is_there_new_contracts() {
  global $wpdb, $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
  $employer_current_project_query = new WP_Query(
      array(
          'posts_per_page'   => - 1,
          'is_author'        => true,
          'post_type'        => PROJECT,
          'author'           => $user_ID,
          'suppress_filters' => true,
          'orderby'          => 'date',
          'order'            => 'DESC',
          'post_status'      => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'complete', 'cancelled', 'deleted-accepted-app', 'no-app', 'active-app', 'accepted-app' ),
          //'post_status'      => 'deleted',
          // 'paged'            => $paged
      )
  );
  $post_parent_in = array();
  if (count($employer_current_project_query->posts) == 0) {
    return false;
  }
  foreach ($employer_current_project_query->posts as $project_post) {
    $post_parent_in[] = $project_post->ID;
  }
  $bid_query = new WP_Query( array(
          'post_type'      => BID,
          //'post_parent'    => 5362,
          'post_parent__in' => $post_parent_in,
          'posts_per_page' => -1
      )
  );
  $return = false;
  foreach ($bid_query->posts as $bid_post) {
    if ($bid_post->post_status == 'publish') {
      $return = true;
    }
  }
  return $return;
}

add_action( 'init', 'add_author_contract_rule' );
function add_author_contract_rule() {
    add_rewrite_rule('^author-contract-details-([^/]*)?','index.php?page_id=12714&la_contract_id=$matches[1]','top');
}
add_filter('query_vars', 'add_query_vars_author_contract');
function add_query_vars_author_contract($aVars) {
    $aVars[] = "la_contract_id";
    return $aVars;
}

function la_clear_domain_name($input) {
  $input = trim($input, '/');
  if (!preg_match('#^http(s)?://#', $input)) {
      $input = 'http://' . $input;
  }
  $urlParts = parse_url($input);
  $domain = preg_replace('/^www\./', '', $urlParts['host']);
  return $domain;
}

$earnings_last_month = array();
add_shortcode('author_stats_new','author_stats_new');

function author_stats_new() {
    global $earnings_last_month;

    $user_id = get_current_user_id();

        //start new code
        $args_get_projects = array(
                'no_found_rows' => true,
                'posts_per_page' => -1,
                'post_type' => 'project',
                'post_status' => 'publish'
        );
        $get_projects = new WP_Query($args_get_projects);
        $count_projects = count($get_projects->posts);

        $total_accepted_post_count = custom_get_author_posts_count($user_id, array(
            'post_type' =>'bid',
            'author' => get_current_user_id(),
            'posts_per_page' => -1,
            'post_status' => array(
                'pending-completion',
                'publish',
                'accept',
                'complete',
                'admin-review'
            )
        ));
        $total_active_post_count = custom_get_author_posts_count($user_id, array(
            'post_type' =>'bid',
            'author' => get_current_user_id(),
            'posts_per_page' => -1,
            'post_status' => array(
                'accept',
                'admin-review'
            )
        ));
        global $wpdb;
        // $messages = $wpdb->get_results( "SELECT * FROM `wp_la_private_messages` WHERE `status` = 'unread' " );
        $messages = $wpdb->get_results( "SELECT * FROM `wp_la_private_messages` WHERE `status` = 'unread' AND `author_id` = {$user_id}" );

        $count_messages = 0;
        foreach ($messages as $msg) {
            if ($msg->status == 'unread'){
                 if( $msg->sender_id != $msg->author_id){
                    $count_messages++;
                 }
           }
        }


       $output = '<div class="col"><strong>Potential clients available:</strong><div class="num">' . $count_projects . '</div><a href="'.get_home_url().'/projects">View all</a></div>';
       $output .= '<div class="col"><strong>Jobs hired:</strong><div class="num">' . $total_accepted_post_count . '</div><a href="'.get_home_url().'/my-contracts/">View all</a></div>';
       $output .= '<div class="col"><strong>Unread messages:</strong><div class="num">' . $count_messages . '</div><a href="'.get_home_url().'/messages">View all</a></div>';
       $output .= '<div class="col"><strong>Jobs in progress:</strong><div class="num">' . $total_active_post_count . '</div><a href="'.get_home_url().'/my-applications/active">View all</a></div>';
       /*$output = 'Total app: ' . $total_post_count;
       $output .= '<br/>Num active: ' . $num_active;
       $output .= '<br/>Total rev: ' . $total_rev;
       $output .= '<br/>Num links built: ' . $num_links_built;*/
       return $output;
       wp_reset_query();
   }

   function owner_pending_apps_new() {

    global $links_last_month;

    $num_pending = 0;
    $num_total = 0;
    $num_cancelled = 0;
    $num_accepted = 0;
    $num_active = 0;
    $num_projects = 0;
    $employers_array = array();

     $employer_current_project_query = new WP_Query(
            array(
                'posts_per_page' => -1,
                'is_author'        => true,
                'post_type'        => PROJECT,
                'author'           => get_current_user_id(),
                'suppress_filters' => true,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'paged'            => $paged,
                // 'post_status'      => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'complete',  'no-app', 'active-app', 'accepted-app' ),
            )

        );

     foreach ($employer_current_project_query as $employer) {
        echo $employer->author;
     }

    //loop through all projects by owner
    //get total number of pending bids
    if ( $employer_current_project_query->have_posts() ) {


        while ( $employer_current_project_query->have_posts() ) : $employer_current_project_query->the_post();
            $num_projects++;

            $bid_query = new WP_Query( array(
                    'post_type'      => 'bid',
                    'post_parent'    => get_the_ID(),
                    'posts_per_page' => -1
                )
            );

            if ( $bid_query->have_posts() ) : while ( $bid_query->have_posts() ) : $bid_query->the_post();

                $num_total++;

                global $ae_post_factory, $post;
$post_object    = $ae_post_factory->get( BID );
$convert        = $post_object->convert( $post );
$author_data      = get_userdata($convert->post_author);

$employers_array[] = $author_data->user_login;

                    if ( get_post_status() == 'publish') {

                        $num_pending++;
                    }

                    if ( ( get_post_status() == 'completion' || get_post_status() == 'pending-completion') && get_post_status() !== 'cancelled') {

                        $num_accepted++;

                        $date_accepted = get_field('date_accepted',get_the_ID());
                        $date_accepted = date("n/j", strtotime($date_accepted));
                        array_push($links_last_month,$date_accepted);


                    }

                    if ( get_post_status() == 'cancelled') {

                        $num_cancelled++;
                    }
                    if ( get_post_status() == 'accept' || get_post_status() == 'admin-review') {

                        $num_active++;
                    }

                endwhile;
            endif;

        endwhile;

    }
    $result = array_unique($employers_array);
    $count_authors = count($result);

        global $wpdb;
        // $messages = $wpdb->get_results( "SELECT * FROM `wp_la_private_messages` WHERE `status` = 'unread' " );
        $messages = $wpdb->get_results( "SELECT * FROM `wp_la_private_messages` WHERE `status` = 'unread' AND `author_id` = {$user_id}" );

        $count_messages = 0;
        foreach ($messages as $msg) {
            if ($msg->status == 'unread'){
                 if( $msg->sender_id != $msg->author_id){
                    $count_messages++;
                 }
           }
        }

         $total_active_post_count = custom_get_author_posts_count($user_id, array(
            'post_type' =>'bid',
            'author' => get_current_user_id(),
            'posts_per_page' => -1,
            'post_status' => array(
                'accept',
                'admin-review'
            )
        ));

       $output = '<div class="col"><strong>Projects posted:</strong><div class="num">' . $num_projects . '</div><a href="'.get_home_url().'/my-projects/">View all</a></div>';
       $output .= '<div class="col"><strong>Authors hired:</strong><div class="num">' . $count_authors . '</div><a href="'.get_home_url().'/author-contracts/">View all</a></div>';
       $output .= '<div class="col"><strong>Unread messageы:</strong><div class="num">' . $count_messages . '</div><a href="'.get_home_url().'/messages">View all</a></div>';
       $output .= '<div class="col"><strong>Jobs in progress:</strong><div class="num">' . $num_active . '</div><a href="'.get_home_url().'/author-contracts/?ac_project=&ac_tab=2">View all</a></div>';

    /*$output .= 'Number of cancelled apps: ' . $num_cancelled . '<br>';
    $output .= 'Total links built: ' . $num_accepted . '<br>';
    $output .= ' Total number of apps: ' . $num_total;*/

    return $output;

    wp_reset_query();

 }

 add_shortcode('owner_pending_apps_new','owner_pending_apps_new');


 function la_get_user_icon_color_la($user_id) {
   //$html = '<svg> <circle id=”MyCircle” fill="#407bbf" cx=”150" cy=”150" r=”50"><text x="0" y="15" fill="red">JD</text></svg>';
  return true;
 }


add_filter( 'avatar_defaults', 'add_default_avatar_option' );
function add_default_avatar_option( $avatars ){
	$url = get_stylesheet_directory_uri() . '/img/replace_this_avatar.svg';
	$avatars[ $url ] = 'def_avatar';
	return $avatars;
}

add_shortcode( 'la_sidebar_message', 'la_sidebar_message_func' );

function la_sidebar_message_func( $atts ){
  $add_class = '';
  if ($atts['active'] == true) {
    $add_class = ' active';
  }
  if ($atts['unread'] == true) {
    $add_class = ' strong';
  }
  ?>
  <li>
      <a href="javascript:void(0)" class="laSidebarMessage<?= $add_class ?>" data-project="<?= $atts['project_id'] ?>" data-author="<?= $atts['author'] ?>">
        <?php
        if (strpos(get_avatar( $atts['avatar_user'] ), 'replace_this_avatar.svg') !== false) {
          $user_firstname = get_user_meta( $atts['avatar_user'], 'first_name', true );
          $user_lastname = get_user_meta( $atts['avatar_user'], 'last_name', true );
          $colorHash = new Shahonseven\ColorHash();
          $color = $colorHash->hex($user_firstname . ' ' . $user_lastname);

          $user_firstname = substr($user_firstname, 0, 1);
          $user_lastname = substr($user_lastname, 0, 1);

            ?>
            <div id="profile_img" style="min-width: 35px;    margin-right: 10px;">
              <div id="profile_img_wrapper">
                <div id="profile_img_circle" style="background: <?= $color ?>;">
                    <?= $user_firstname ?><?= $user_lastname ?>
                </div>
              </div>
            </div>
            <?php
        } else {
            echo get_avatar( $atts['avatar_user'], 35 );
        }
        ?>
        <?php if (ae_user_role() != 'employer'): ?>
          <?= wp_strip_all_tags( get_the_title($atts['project_id']) ); ?>
        <?php else: ?>
          <div class="la_msg_usertitle">
            <?= $atts['short_username'] ?>
            <div class="la_msg_user_last_msg">
              <?= employer_get_latest_message( $atts['project_id'], $atts['avatar_user']); ?>
            </div>
          </div>
        <?php endif; ?>
      </a>
  </li>
  <?php
}
