<?php
/**
 * Created by PhpStorm.
 * User: Vosydao
 * Date: 6/5/2017
 * Time: 10:41 AM
 * Template Name: My Credit
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}

global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role = ae_user_role($current_user->ID);

if(!is_user_logged_in()){
    $current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
}

if ($user_role=='freelancer'){
    add_filter( 'wp_title', 'my_tpl_wp_title', 100 );
}


function my_tpl_wp_title($title) {

    $title = 'Earnings - Link-able';

    return $title;
}

get_header();

?>

<style>
    .dashboard-sidebar > ul > li.la_nav_payments a {
        color: white;
        font-weight: bold;
    }
    .dashboard-sidebar > ul > li.la_nav_payments a i {
        color: #1aad4b;
    }
</style>

<div class="entry-content landing-entry-content">

    <?php get_template_part( 'dashboard-side-nav'); ?>
    <div class="main-dashboard-content dashboard-landing inner-dashboard">
        <h1 class="entry-title"><?php
            if ($user_role=='freelancer'){ echo 'Earnings'; }
            else { echo 'Payments';} ?></h1>
        <p class="optional-text">
            <?php
            if ($user_role=='freelancer'){ echo get_field('earnings_intro_text'); }
            else { echo get_field('payments_intro_text') ;} ?>
        </p>
        <!-- <h4 class="sub-head"><?php
            if ($user_role=='freelancer'){ echo 'Earnings'; }
            else { echo 'Payments';} ?> Summary</h4> -->
        <?php

            $employer_invoice_query = new WP_Query(
                array(

                    'is_author'        => true,
                    'post_type'        => 'invoices',
                    'author'           => $user_ID,
                    'suppress_filters' => true,
                    'orderby'          => 'date',
                    'order'            => 'DESC',
                    'paged' => false,
                    'posts_per_page'    => -1
                )
            );

           // The Loop
           if ( $employer_invoice_query->have_posts() ) { ?>
                <div class="white-bg payment-table">
                    <div class="payment-row">
                        <div class="col project-header"><?php
                            if ($user_role=='freelancer'){ echo 'Contract'; }
                            else { echo 'Contract';} ?></div>
                        <div class="col project-header">Amount</div>
                        <!--<div class="col project-header"><?php if ($user_role=='freelancer'){ ?>Project Completed On<?php } ?>
                     <?php if ($user_role=='employer'){ ?>Project Submitted<?php } ?>
                     </div>-->
                        <div class="col project-header"><?php
                            if ($user_role=='freelancer'){ echo 'Payment Date'; }
                            else { echo 'Purchase Date';} ?></div>
                        <div class="col project-header">Status</div>
                        <div class="col project-header"><?php
                            if ($user_role=='freelancer'){ echo 'Payment Method'; }
                            else { echo 'Invoice';} ?></div>
                    </div>
               <?php  while ( $employer_invoice_query->have_posts() ) {
                    $employer_invoice_query->the_post();

                    echo '<div class="payment-row 11">';
                    $current_proj_id = get_the_ID(); // id invoice
                    //print_r($employer_invoice_query);

                    //project
                    $proj_num = get_field('project_number',$current_proj_id);  //this is the APPLICATION ID , bid id
                    $proj_num2 = get_field('project_id_',$current_proj_id); //this is the actual project id


                    if ($user_role=='freelancer') {
                        $link = get_the_permalink($proj_num);
                    } else {
                        $owner_url = get_field('url_domain',$proj_num);
                        $owner_url = preg_replace('#^https?://#', '', rtrim($owner_url,'/'));
                        $link = get_the_permalink($proj_num2);
                    }
                    echo '<div class="col"><a href="'.$link.'">' . $proj_num . ' <span>-</span> '.$owner_url.'</a></div>';

                    //amount
                    $amount = get_field('amount',$current_proj_id);
                    $app_amount = get_field('owner_price',$proj_num); //price for author

                    $app_amount_owner = get_field('bid_budget',$proj_num);


                  /***** OLD CODE FOR CALCULATING AMOUNT BASED ON COMM RATE FROM PROJECT PRICE ******/
	                // $comm_rate = get_field('commission_rate_%','option');
	                // $author_do_price = $app_amount_owner * (1-($comm_rate/100));
	                // if( $author_do_price > 0) {
		              //   $amount = $author_do_price;
	                // }
                  /***** NEW CODE FOR AMOUNT ******/
                    //var_dump($proj_num);
                  $invoice_id = get_field('author_invoice_id', $proj_num);
                  $amount = get_field('amount', $invoice_id);
                  /***** END ******/


                    //$app_amount_freelancer = get_post_meta($proj_num,true);
                    echo '<div class="col 2">$';
                    //echo $proj_num . "<br>";
                    //if($app_amount) { echo $app_amount;} else { echo $amount;}
                    //echo $user_role;
                    //echo $amount;
                    //echo $amount;
                  if($user_role == 'employer') { echo $app_amount_owner;} else { echo $amount; /*echo get_the_ID();*/}
                    echo '</div>';

                    //project posted date
                    $proj_date = get_field('project',$current_proj_id);
                    //echo '<div class="col">' . $proj_date. '</div>';

                    //payment submitted date
                    //echo '<div class="col">' . get_field('payment_submitted_date',$current_proj_id) . '</div>';
                    echo '<div class="col 1">';

                    if($user_role == 'employer') {
                        echo get_the_date('m/d/Y');
                    } else {
                        echo get_field('payment_submitted_date',$current_proj_id);
                        //var_dump(get_field('payment_submitted_date',$current_proj_id)); // #mycomment
                    }

                    echo '</div>';

                    //payment status
                    echo '<div class="col">' . get_field('payment_status',$current_proj_id) . '</div>';

                    //invoice
                    if ($user_role == 'freelancer') {
                        echo '<div class="col gray"><i class="fab fa-paypal"></i> PayPal</div>';
                    } else if(get_field('manual_invoice_upload',$current_proj_id) == '') {
                        echo '<div class="col"><i class="fa fa-file-pdf"></i> ' . do_shortcode('[gravitypdf id="5b7caf6570b1d" entry="'.get_field('gravity_form_entry_id',$current_proj_id).'" text="Download"]') . '</div>';
                    } else {
                        echo '<div class="col"><a target="_blank" href="' . get_field('manual_invoice_upload',$current_proj_id) . '" ><i class="fa fa-file-pdf"></i>  Download</a></div>';
                    }
                    echo '</div>';
                }
                /* Restore original Post Data */
                wp_reset_postdata(); ?>
            </div>
           <?php } else { ?>
            <div class="blue-box author-earing-info payment-info">
            <?php    if ($user_role=='freelancer'){ echo get_field('earings_default_text') ; }
                else { echo get_field('payments_default_text') ; }  ?>
            </div>
            <?php }
            ?>

    </div>
</div>

<?php get_footer() ?>
