<?php
/**
 * Template Name: Apply to Project
 */


add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';

    return $classes;
}

global $user_ID;

if ( ae_user_role() == EMPLOYER ) {
    wp_redirect( get_home_url() . '/my-projects/' );
}

if ( ( ! is_user_logged_in() ) ) {

    $current_url = $_SERVER["SERVER_NAME"] . '/apply-to-project/?' . $_SERVER["QUERY_STRING"];
    wp_redirect( get_home_url() . '/login' . '?redirect_to="' . $current_url . '"' );
} else {
    if ( ! $_GET ) {
        wp_redirect( get_home_url() . '/dashboard' );
    }
}


get_header();


?>

    <style>
        .dashboard-sidebar ul li:first-child a {
            color: white;
        }

        .dashboard-sidebar ul li:first-child a i {
            color: #1aad4b;
        }

    </style>


    <div class="fre-page-wrapper entry-content dashboard-page">

<?php
get_template_part( 'dashboard-side-nav' ); ?>
    <div class="main-dashboard-content dashboard-landing inner-dashboard">
        <div class="fre-page-section">
            <div class="project-intro-wrap">
                <a class="button shortcode-button back-my-projects" href="<?php echo get_home_url(); ?>/messages/"><i
                            class="fa fa-arrow-left"></i> Cancel & Go Back</a>

                <h1>Submit Your Contract to the Client</h1>
                <p class="project-summary">Project Overview:</p>
            </div>
            <div class="project-detail-box project-info">
                <div class="project-details-head">
                    <h3 class="my-proj-title"><?php
                        $url   = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                        $parts = parse_url( $url );
                        parse_str( $parts['query'], $query );

                        $parent_id = $query['parent_id'];

                        echo get_the_title( $parent_id ); ?>
                        <?php if ( get_field( 'publicly_display_url', $parent_id ) == 1 ) { ?>
                            <span class="green bold">
                                <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $parent_id ); ?></span>
                            </span>
                        <?php } ?>
                    </h3>
                    <div class="left-bar">
                        <div class="col-section text-right gray_858585">
                            <div class="project-header gray_858585">Category:</div>
                            <?php
                            $terms = get_the_terms( $query['parent_id'], 'project_category' );
                            foreach ( $terms as $term ) {
                                echo $term->name;
                            } ?>
                        </div>
                    </div>
                </div>
                <!--                <div class="project-top-bar">-->
                <!--                    <div class="col-section">-->
                <!--                        <div class="project-header">Posted</div>-->
                <!--						--><?php ////echo $query['parent_id']; ?>
                <!--						--><?php //echo human_time_diff( get_the_time( 'U', $query['parent_id'] ), current_time( 'timestamp' ) ) . ' ago'; ?>
                <!---->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->

                <div class="single-project-description-section">
                    <div class="break-field">
                        <div class="project-header">PROJECT DESCRIPTION:</div>
                        <span><?php echo get_the_content_by_id( $parent_id ); ?></span></div>
                    <div>
                        <div class="project-header">DETAILS & REQUIREMENTS:</div><?php
                        if ( get_field( 'linkable_ideas', $parent_id ) ) {
                            echo wpautop( get_field( 'linkable_ideas', $parent_id ) );

                        } else {
                            echo 'The Content Marketer has no additional info about their page.';
                        }
                        ?></div>
                    <?php if ( get_field( 'desired_domains_for_backlinks', $parent_id ) ) { ?>
                        <div>
                            <div class="project-header">Wants a backlink on</div>
                            <?php echo get_field( 'desired_domains_for_backlinks', $parent_id ); ?>
                        </div>

                    <?php } ?>
                    <div>
                        <div class="project-header">Desired Link Attribute</div>
                        <?php $terms = get_the_terms( $parent_id, 'project-follow-type' );
                        $follow_type = [];
                        $no_pref     = array( 'NoFollow', 'DoFollow' );
                        foreach ( $terms as $term ) {
                            array_push( $follow_type, $term->name );
                        }

                        if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                            echo "NoFollow or DoFollow";
                        } else {
                            echo $follow_type[0];
                        } ?>
                    </div>

                    <?php
                        $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
                        echo la_build_backlinks_to_markup($preferred_pages);
                    ?>

                </div>
            </div>


            <div class="project-intro-wrap second">
                <p class="project-summary second" style="margin-bottom: 20px">Write & submit your contract below to the client:</p>
            </div>


            <div class="project-detail-box">
                <?php
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;

                //print_r($_POST);

                $length = $_POST["input_3"];
                //$proposal = preg_replace( "/\r|\n/", "", trim($_POST["input_4"]) );
                $proposal      = trim( $_POST["input_4"] );
                $project_title = $_POST["input_5"];
                $follow_val    = $_POST["input_2"];

                if ( isset( $_POST["input_1"] ) ) {
                    $domain_calc = $_POST["input_1"];
                    $domain_authority = get_da_from_moz_api( $domain_calc );

                }

                //$domain_authority = 85;
                $price_from_da     = 0; //price based on pricing grid on options page
                $follow_multiplier = 1;
                $commission        = get_field( 'commission_rate_%', 'option' );

                //get multipliers
                if ( have_rows( 'follow_type_calculation', 'option' ) ): ?>


                    <?php while ( have_rows( 'follow_type_calculation', 'option' ) ): the_row();

                        // vars
                        $no_follow_mult = get_sub_field( 'nofollow_multiplier' );
                        $do_follow_mult = get_sub_field( 'dofollow_multiplier' );


                        ?>

                    <?php endwhile; ?>

                <?php endif;

                //get price from grid based on DA
                $override_exists = false;

                //first see if domain has an override
                if ( have_rows( 'domain_overrides', 'option' ) ) {
                    while ( have_rows( 'domain_overrides', 'option' ) ): the_row();
                        $domain_name = get_sub_field( 'domain_override_field' );
                        $domain_name = parse_url( $domain_name );
                        $domain_name = $domain_name['host'];
                        $domain_name = str_replace( 'www.', '', $domain_name );
                        $domain_name = strtolower( $domain_name );

                        //echo $domain_name;

                        $entered_domain = $_POST["input_1"];
                        $entered_domain = parse_url( $entered_domain );
                        $entered_domain = $entered_domain['host'];
                        $entered_domain = str_replace( 'www.', '', $entered_domain );
                        $entered_domain = strtolower( $entered_domain );

                        //echo $entered_domain;

                        if ( $domain_name == $entered_domain ) {
                            $override_exists = true;
                            //here we need to get the price
                            $price_from_da = get_sub_field( 'price' );

                            break;
                        }


                    endwhile;
                }

                // echo $override_exists;

                if ( $override_exists ) {


                } else {

                    if ( have_rows( 'domain_authority_pricing_schedule', 'option' ) ): ?>


                        <?php while ( have_rows( 'domain_authority_pricing_schedule', 'option' ) ): the_row();

                            // vars
                            $low   = get_sub_field( 'range_low' );
                            $high  = get_sub_field( 'range_high' );
                            $price = get_sub_field( 'dollar_value' );

                            if ( ( $domain_authority >= $low ) && ( $domain_authority <= $high ) ) {
                                $price_from_da = $price;
                            }

                            ?>

                        <?php endwhile; ?>

                    <?php endif;

                }

                //grab domain authority from moz api
                //calc based on table


                //get domain authority selection
                if ( isset( $_POST['input_2'] ) ) {
                    $radioVal = $_POST["input_2"];

                    if ( $radioVal == "NoFollow" ) {
                        $follow_multiplier = $no_follow_mult;
                        ?>
                        <script>
                            jQuery("#choice_4_2_0").prop("checked", true);
                        </script>
                    <?php
                    } else {
                    $follow_multiplier = $do_follow_mult;
                    ?>
                        <script>
                            jQuery("#choice_4_2_1").prop("checked", true);
                        </script>
                        <?php
                    }
                }

                //echo 'calc value:' . $dollar_value;
                echo '<div class="price-calc">';
                echo 'We would recommend charging this price: <span class="price-value">$';

                $owner_price = $price_from_da * $follow_multiplier;
                $paid_price  = ( 1 - ( $commission / 100 ) ) * $owner_price;
                $paid_price  = number_format( (float) $paid_price, 2, '.', '' );


                echo $paid_price;

                echo '</span>';
                echo '<div class="how-calc"><a class="how-calc">How is this price calculated?</a></div>';
                echo '<div class="list-item-expanded">The price for each link is automatically calculated using our unique formula and is primarily dependent on the DA (Domain Authority) of the domain your link will be on. Other factors like the link attribute (dofollow or nofollow) and the experience of the Content Author can also affect the price. After building each link, our staff analyzes the Content Author’s work and may increase or decrease the price, so be sure to always build a quality backlink that adheres to our Link Building Rules and Terms of Service!</div>';
                echo '</div></div>';


                //add price to hidden field
                ?>
                <?php wp_nonce_field( '_la_csrf_token', '_csrf_token'); ?>
                <script>
                    <?php /*
                    //move calc price button
                    jQuery(document).bind('gform_post_render', function () {
                        jQuery("#gform_page_4_2 .gform_page_footer").addClass("apply-button");
                        jQuery("#gform_page_4_1 .gform_page_footer").addClass("calc-button");
                        jQuery("#gform_page_4_1 .gform_page_footer").insertBefore("#gform_page_4_2 .gform_page_footer");
                        jQuery("#gform_page_4_2").show();

                        jQuery(".apply-button").hide();
                        jQuery(".price-calc").hide();
                        jQuery(".price-calc").css("display", "none");

                        var postData = <?php echo $_POST; ?>;
                        if ((jQuery(".validation_error").text() == '') && (window.location.hash)) {

                            console.log('have a price');

                            jQuery("#gform_page_4_2").show();
                            jQuery(".apply-button").show();
                            jQuery(".price-calc").show();

                            jQuery("#gform_page_4_2 .gform_page_footer:nth-child(3)").css("visibility", "hidden");
                            jQuery("#gform_page_4_2 .gform_page_footer:nth-child(3)").css("height", "0px");
                            jQuery("#input_4_1").prop("readonly", true);
                            jQuery("#input_4_1").addClass("disabled");

                            jQuery("#input_4_2").addClass("disabled");
                            jQuery("#input_4_3").addClass("disabled");

                            jQuery("#input_4_4").prop("readonly", true);
                            jQuery("#input_4_4").addClass("disabled");

                            jQuery("#input_4_7 input").attr("readonly", "readonly");
                            jQuery("#input_4_7").addClass("disabled original");
                            jQuery("#field_4_7").clone().addClass("copy-disabled").appendTo("#gform_fields_4");
                            jQuery("#field_4_7.copy-disabled input").prop("disabled", true);

                            jQuery("#field_4_7:not(.copy-disabled)").hide();


                            jQuery('option:not(:selected)').prop('disabled', true);

                            jQuery("#gform_page_4_2 .gform_page_footer").append("<div class='reset-application'><a>Clear/Reset Application</a></div>");

                        }

                        //jQuery("#gform_next_button_4_13").attr("disabled","disabled");
                        //jQuery("#gform_next_button_4_13").addClass("disabled");

                    });

                    jQuery("#input_4_18").val('<?php echo $owner_price; ?>');
                    jQuery("#field_4_18").hide();

                    jQuery("#input_4_11").val('<?php echo $paid_price; ?>');
                    jQuery(".price-calc").insertAfter("#gform_page_4_2 .gform_page_fields");

                    jQuery("#input_4_15").val('<?php echo $domain_authority; ?>');

                    //auto populate other saved data
                    //jQuery("#input_4_5").val('<?php echo $project_title; ?>');
                    jQuery("#input_4_1").val('<?php echo $domain_calc; ?>');
                    if ($proposal) {
                        jQuery("#input_4_4").val('<?php echo json_encode( $proposal, JSON_HEX_APOS ); ?>');
                    } */ ?>

                    var earning_link_cont = jQuery('label[for="input_4_20"]');
                    if( earning_link_cont.length ) {
                        var el_html = earning_link_cont.html();
                        el_html = el_html.replace('calculator tool', '<a href="<?= get_site_url(); ?>/earnings-calculator" target="_blank">calculator tool</a>');
                        // earning_link_cont.html(el_html);
                    }

                    if (jQuery("#gform_confirmation_wrapper_4").length) {
                        jQuery(".entry-content p:first-child").hide();
                        jQuery(".project-summary").hide();
                        jQuery(".project-detail-box.project-info").hide();
                        jQuery(".project-summary.second").hide();
                        jQuery(".project-intro-wrap h1").text("Application Submitted!");
                    }

                    // Hide unnecessary things
                    jQuery('#field_4_20 .instruction').remove();
                    jQuery('#field_4_18').hide();

                    // Append Additional Things
                    jQuery('#field_4_20 .ginput_container').append('<div class="la_actual_earning">Your actual earnings: <br><span id="actual_pricing" class="green bold"></span></div>');
                    jQuery('#field_4_21 .ginput_container').append('<div class="la_actual_earning_nofollow">Your actual earnings: <br><span id="actual_pricing_nofollow" class="green bold"></span></div>');
                    jQuery("#gform_4 .gform_footer").append("<div class='reset-application'><a>Clear/reset contract</a></div>");

                    // Set price based user's input
                    jQuery('#input_4_20').on( 'keyup', function (e) {
                        var price = jQuery(this).val();
                        if( "" == price ){
                            jQuery('.la_actual_earning').removeClass('active');
                        } else {
                            jQuery('.la_actual_earning').addClass('active');
                        }
                        price = price.replace('$', '');
                        price = price.replace(',', '');
                        var commission = 30;
                        if( "undefined" !== globalObject.commission){
                            commission = globalObject.commission;
                        }
                        var calc_price = ( price - ( price * commission ) / 100 );
                        jQuery('#actual_pricing').text( '$' + calc_price.toFixed(2) );

                    } );

                    // Set price based user's input
                    jQuery('#input_4_21').on( 'keyup', function (e) {
                        var price = jQuery(this).val();
                        if( "" == price ){
                            jQuery('.la_actual_earning_nofollow').removeClass('active');
                        } else {
                            jQuery('.la_actual_earning_nofollow').addClass('active');
                        }
                        price = price.replace('$', '');
                        price = price.replace(',', '');
                        var commission = 30;
                        if( "undefined" !== globalObject.commission){
                            commission = globalObject.commission;
                        }
                        var calc_price = ( price - ( price * commission ) / 100 );
                        jQuery('#actual_pricing_nofollow').text( '$' + calc_price.toFixed(2) );

                    } );
                    // Set DA based on domain added
                    jQuery('#input_4_1, input[name="input_2"]').on('change', function (e) {
                        var dom = jQuery('#input_4_1').val();
                        //var follow = jQuery('input[name="input_2"]:checked').val();
                        var follow = 'dofollow';
                        if( dom && follow ){
                            get_da_from_moz( dom, follow );
                        }
                    });

                    // Get DA from Backend
                    function get_da_from_moz( domain, follow = 'dofollow' ) {

                        var dataObj = {domain: domain, follow: follow, action: 'la_get_da_from_moz', csrf_token: jQuery('#_csrf_token').val() };
                        jQuery.post(example_ajax_obj.ajaxurl, dataObj, function (res) {
                            if( res.status ){
                                jQuery('#input_4_15').val( res.msg );
                                jQuery('#input_4_18').val( res.price.owner_price );
                                jQuery("#input_4_11").val( res.price.paid_price );
                            }
                        });
                    }
                </script>
                <?php
                //echo 800 * .5;
                //echo '<div class="price-based-on-moz-api">Price</div>';


                ?>

            </div>
        </div>
    </div>
<?php
get_footer();