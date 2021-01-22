<?php
/**
 * Template Name: Author Contracts
 */
add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';
    $classes[] = 'ie-my-project';

    return $classes;
}

$user_role = ae_user_role( $user_ID );

if ( ( ! is_user_logged_in() ) || ( $user_role == 'freelancer' ) ) {
    $current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}

get_header();
global $wpdb, $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role     = ae_user_role( $user_ID );
$freelance_msg = '';
if ( $user_role == FREELANCER ) {
    $freelance_msg = 'Visit the <a href="' . get_home_url() . '/projects/">Project Marketplace</a> and search for content you can link to. Then submit your contract!</span>';
}
define( 'NO_RESULT', __( '<span class="project-no-results">You have no contracts to display here yet. ' . $freelance_msg, ET_DOMAIN ) );
$currency = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );

?>

<div class="entry-content landing-entry-content single-project">
  <?php
  get_template_part( 'dashboard-side-nav' );
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
      )
  );
  //var_dump($employer_current_project_query->posts);
  ?>

  <div class="fre-project-detail-wrap" style="width: calc(100% + 30px); margin: 0px;background: #f6f6f6;">
    <div class="cart-banner">
        <div class="left-column">
            <div class="num-selected">
              <span class="num">0</span>
              <span class="app-numberdd"></span>author
              contracts selected
            </div>
            <ul class="selected-project-names">
            </ul>
        </div>
        <div class="right-column">
            <div class="total-header">Total:</div>
            <div class="total-price green">$<span></span></div>
            <?php echo do_shortcode( '[gravityform id="5" title="false" description="false"]' ); ?>
        </div>
    </div>

    <div class="fre-page-section ie-my-project-wrap author-contracts-wrapper">
      <div class="container">
        <div class="my-work-employer-wrap">
          <div class="fre-tab-content">
            <h1 class="entry-title">Author contracts</h1>
              <p class="optional-text my-projects">
                Here is where you can view and manage all the job contracts you've received from authors
                <?php
                $post_parent_in = array();
                $post_per_page = -1;

                if (!$employer_current_project_query->posts) {
                  $post_per_page = 0;
                  //var_dump($post_per_page);
                }

                foreach ($employer_current_project_query->posts as $project_post) {
                  $post_parent_in[] = $project_post->ID;
                }

                global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
                $post_object = $ae_post_factory->get( PROJECT );
                $project     = $post_object->current_post;
                if ($post_per_page == 0) {
                  add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                  $bid_query = new WP_Query( array(
                          'post_type'      => NOT_REAL_POST_TYPE,
                          'post_parent__in' => $post_parent_in,
                          'posts_per_page' => $post_per_page,
                      )
                  );
                  remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                } else {
                  add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                  $bid_query = new WP_Query( array(
                          'post_type'      => BID,
                          'post_parent__in' => $post_parent_in,
                          'posts_per_page' => $post_per_page,
                      )
                  );
                  remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                }
                $bid_data = array();
                ?>
                <div id="project-detail-bidding" class="project-detail-box no-padding pending">
                  <div class="freelancer-bidding author_contracts">
                    <div class="bid-nav">
                      <div class="bid_nav_items">
                        <a data-value="1" data-tab="pending-bids_ac" class="pending-bids_ac active">Pending (<span class="pending-count">0</span>)</a>
                        <a data-value="2" data-tab="accepted-bids_ac" class="accepted-bids_ac">Active (<span class="accepted-count">0</span>)</a>
                        <a data-value="3" data-tab="complete-bids_ac" class="complete-bids_ac">Completed (<span class="completed-count">0</span>)</a>
                        <a data-value="4" data-tab="cancelled-bids_ac" class="cancelled-bids_ac">Cancelled (<span class="cancelled-count">0</span>)</a>
                      </div>
                      <select class="project_filter" name="">
                        <option value=""> -- Showing contracts for all projects -- </option>
                        <?php
                        foreach ($employer_current_project_query->posts as $project) {
                          ?><option value="<?= $project->ID ?>"><?= $project->post_title ?></option><?php
                        } ?>
                      </select>
                    </div>
                    <div class="no_contracts_msg no_contracts_active">
                      You currently have no actice contracts to show.
                    </div>
                    <div class="no_contracts_msg no_contracts_completed">
                      You currently have no completed contracts to show.
                    </div>
                    <div class="no_contracts_msg no_contracts_cancelled">
                      You currently have no cancelled contracts to show.
                    </div>
                    <?php
                    if ( $bid_query->have_posts() ) {
                        global $wp_query, $ae_post_factory, $post;
                        $post_object = $ae_post_factory->get( BID );
                        while ( $bid_query->have_posts() ) {
                            $bid_query->the_post();
                            $convert = $post_object->convert( $post );
                            $show_bid_info = can_see_bid_info( $convert, $project);
                            get_template_part( 'template/bidding', 'item' );
                        }
                    } else {
                        get_template_part( 'template/bid', 'not-item' );
                    }
                    wp_reset_postdata();
                    if ($post_per_page != 0) {
                      add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                      $bid_query = new WP_Query( array(
                              'post_type'      => BID,
                              //'post_parent'    => 5362,
                              'post_parent__in' => $post_parent_in,
                              'posts_per_page' => $post_per_page,
                              'post_status' => array('accept', 'admin-review', 'cancelled', 'pending-completion'),
                          )
                      );
                      remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                      if ( $bid_query->have_posts() ) {
                        $post_object = $ae_post_factory->get( BID ); ?>
                        <div class="author_contracts_table_wrapper">
                          <div id="authors_contracts" onscroll="author_contracts_scroll" class="white-bg payment-table">
                            <div class="payment-row">
                            	<div class="col project-header text-uppercase">Contract ID</div>
                            	<div class="col project-header text-uppercase">Backlink On</div>
                            	<div class="col project-header text-uppercase">Status</div>
                            	<div class="sort_eta_button col project-header text-uppercase">Eta <i class="fa fa-sort"></i></div>
                            	<div class="col project-header text-uppercase">Details</div>
                            </div>
                            <div class="author_contracts_table_result">
                              <?php
                              while ( $bid_query->have_posts() ) {
                                $bid_query->the_post();
                                $convert = $post_object->convert( $post );
                                $bid_status = get_post_status();
                                if ($bid_status == 'admin-review') {
                                  $bid_status = 'accept';
                                }
                                $url_domain = get_field( 'url_domain', $convert->ID );
                                $date_posted = get_field( 'date_accepted', $convert->ID );
                                $how_long    = get_field( 'how_long', $convert->ID );
                                if ( $how_long == 'Less than 2 weeks' || $how_long == '1 to 2 weeks' ) {
                                    $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 14 days' ) );
                                } else if ( $how_long == '2 to 3 weeks' ) {
                                    $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 21 days' ) );
                                } else if ( $how_long == '4 to 6 weeks' ) {
                                    $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 42 days' ) );
                                } else if ( $how_long == '7 to 8 weeks' ) {
                                    $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 56 days' ) );
                                }
                                $today = time();
                                $due_date   = strtotime( $due_date );
                                $datediff   = $due_date - $today;
                                $days_left  = floor( $datediff / ( 60 * 60 * 24 ) );
                                $days_label = 'days';
                                if ( $days_left == 1 ) {
                                    $days_label = 'day';
                                }
                                  ?>
                                <div data-eta="<?= $due_date ?>"  class="payment-row payment-project-row la_status_<?= $bid_status ?>" data-id="<?= wp_get_post_parent_id(get_the_id()); ?>">

                                  <div class="col"><?= get_the_ID(); ?></div>

                            			<div class="col link_col">
                            				<?= str_ireplace('www.', '', parse_url($url_domain, PHP_URL_HOST)); ?>
                            			</div>
                            			<div class="col">
                                    <?php if ( $bid_status == 'accept' || $bid_status == 'admin-review' ) {
                        	            echo '<span class="status bold status_active">Active</span>';
                                    } else if ( ( $bid_status == 'cancelled' || $proj_status == 'cancelled' ) && $bid_status !== 'pending-completion' ) {
                        	            echo '<span class="status bold text-red">Cancelled</span>';
                                    } else if ( $bid_status == 'deleted' ) {
                        	            echo '<span class="status bold text-dark-red">Declined</span>';
                                    } else if ( $bid_status == 'pending-completion' ) {
                        	            echo '<span class="status bold status_completed">Completed</span>';
                                    } else if ( $proj_status == 'publish' || $bid_status == 'publish' ) {
                        	            echo '<span class="status bold text-magenta">Pending Acceptance</span>';
                                    } else if ( $bid_status == 'complete' || $bid_status == 'pending-completion' ) {
                        	            echo '<span class="status bold text-dark">Completed</span>';
                                    } else if ( $proj_status = "complete" || $proj_status == 'pending-completion' ) {
                        	            echo '<span class="status bold">Pending Acceptance</span>';
                                    } else {
                        	            echo '<span class="status bold text-dark">Completed</span>';
                                    } ?>
                                  </div>
                                  <?php
                                  if ( $bid_status == 'accept' || $bid_status == 'admin-review' ) {
                                    $time = $days_left . ' ' . $days_label;
                                  } else if ( $bid_status == 'complete' || $bid_status == 'pending-completion' ) {
                                    $time = 'COMPLETED ON ' . la_local_date_i18n( 'm/d/Y', $due_date );
                                  } elseif ( $bid_status == 'cancelled' ){
                                    $cancel_date = get_post_meta( get_the_ID(), 'bid_cancel_date', true);
                                    $time = 'CANCELLED ON ' . date( 'm/d/Y', strtotime( $cancel_date ) );
                                  }
                                  ?>

                            			<div class="col text-uppercase sort_field"><?= $time ?></div>
                            			<a href="<?= get_home_url() ?>/author-contract-details-<?= get_the_id(); ?>" class="col col_view_details">View details <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                            		</div>
                                <?php
                              } ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        }
                        wp_reset_postdata();
                        wp_reset_query();
                    }?>

                        </div>
                      </div>
                    </p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="data/json" id="project_data">{"post_parent":0,"post_title":"This is a Test Project by the Link-able team 222","post_name":"this-is-a-test-project-by-the-link-able-team-222","post_content":"<p>This is a test project posted by the dev team. Please ignore.<\/p>\n","post_excerpt":"This is a test project posted by the dev team. Please ignore.","post_author":"450","post_status":"publish","ID":12652,"post_type":"project","comment_count":"","guid":"https:\/\/wordpress-257790-935760.cloudwaysapps.com\/?post_type=project&#038;p=12652","status_text":"ACTIVE","post_date":"September 28, 2020","project_category":[146],"tax_input":{"project_category":[{"term_id":146,"name":"Accounting &amp; Tax Services","slug":"accounting-and-tax","term_group":0,"term_taxonomy_id":146,"taxonomy":"project_category","description":"","parent":0,"count":2,"filter":"raw"}]},"address":"","avatar":"","post_count":"","et_featured":"0","et_expired_date":"","et_budget":"","deadline":"","total_bids":0,"bid_average":0,"accepted":"5377","project_deadline":"","et_payment_package":"","post_views":"9","id":12652,"permalink":"https:\/\/wordpress-257790-935760.cloudwaysapps.com\/project\/12652\/","unfiltered_content":"This is a test project posted by the dev team. Please ignore.","the_post_thumnail":"","featured_image":"","the_post_thumbnail":"","bid_won_date":"in 0 week","et_avatar":"<img alt='' src='https:\/\/secure.gravatar.com\/avatar\/79426f95832a63973426b5b0b748c7e7?s=35&amp;d=mm&amp;r=G' class='avatar avatar-35 photo avatar-default' height='35' width='35' \/>","author_url":"https:\/\/wordpress-257790-935760.cloudwaysapps.com\/author\/testownerlink-able-com\/","author_name":"testowner@link-able.com","budget":"$0.00","bid_budget_text":"$500.00","rating_score":0,"project_comment":"","project_comment_trim":"","post_content_trim":"This is a test project posted by the dev team. Please ignore.","count_word":0,"project_status_view":"Active","text_status_js":"Job is active","et_carousels":[],"current_user_bid":false,"posted_by":"Posted by testowner@link-able.com","list_skills":"","text_total_bid":"0 Bids","text_country":""}</script>
<?php
function la_local_date_i18n($format, $timestamp) {
    $timezone_str = get_option('timezone_string') ?: 'UTC';
    $timezone = new \DateTimeZone($timezone_str);

    // The date in the local timezone.
    $date = new \DateTime(null, $timezone);
    $date->setTimestamp($timestamp);
    $date_str = $date->format('Y-m-d H:i:s');

    // Pretend the local date is UTC to get the timestamp
    // to pass to date_i18n().
    $utc_timezone = new \DateTimeZone('UTC');
    $utc_date = new \DateTime($date_str, $utc_timezone);
    $timestamp = $utc_date->getTimestamp();

    return date_i18n($format, $timestamp, true);
}
?>



    <style>
        .dashboard-sidebar > ul > li.la_author_contracts a {
            color: white;
            font-weight: bold;
        }
        .dashboard-sidebar > ul > li.la_author_contracts a i {
            color: #1aad4b;
        }

        .employer-project-nav ul li a {
            transition: .3s all;
        }
        .employer-project-nav ul li.active_nav a {
            color: #1aad4b;
            border-bottom: 1px solid #1faa49;
        }

        .project-sub-nav li:nth-child(1) a {
            color: white;
            font-weight: bold;
        }
        #project_deleted, #project_active {
          display: block;
        }
        #project_deleted {
          display: none;
        }
        .fre-project-detail-wrap > div {
            padding: 20px;
        }

        .single-project .fre-project-detail-wrap .bid-nav {
            margin-bottom: 25px;
        }

        .url-for-author {
            margin-top: 0;
            padding-bottom: 18px;
            margin-bottom: 20px;
            padding-right: 20px;
            padding-top: 15px;
        }
        .cart-banner {
          margin-left: 0px;
          margin-top: 0px;
          box-shadow: 2px 0px 5px 2px #a6a5a5;
        }
        .cart-banner.show_cart {
          animation-name: showtoggle;
          animation-duration: 0.3s;
          display: flex;
        }
        #gform_wrapper_15 {
          position: absolute;
          bottom: 60px;
          right: 10px;
          box-shadow: 0px 2px 12px 1px #00000085;
        }
        #gform_wrapper_15:after {
          content: '';
          width: 30px;
          height: 30px;
          position: absolute;
          bottom: -14px;
          z-index: -1;
          left: calc(50% - 15px);
          background: white;
          transform: rotate(45deg);
          left: auto;
          right: 50px;
        }
        @keyframes showtoggle {
          from {transform: translateY(-100%); opacity: 0.3;}
          to {transform: translateY(0%); opacity: 1;}
        }
        .author-contracts-wrapper {
          background: #f6f6f6;
        }
        .payment-table .payment-row:first-child {
          padding: 10px 0px;
        }
        #authors_contracts .payment-row .col:first-child {
          flex: 170px;
        }
        #authors_contracts .payment-row .col:nth-child(5) {
          flex: 220px;
        }
        #authors_contracts .status {
          text-transform: uppercase;
        }
        #authors_contracts .status.status_completed{
          color: #1f5485;
        }
        #authors_contracts .status_active {
          color: #1aad4b;
          font-size: 14px;
          text-transform: uppercase;
        }
        .single-project .add-to-cart {
          margin-left: auto;
        }
        .author_contracts_table_wrapper {
          display: none;
        }
        .author_contracts_table_result .payment-row.payment-project-row {
          padding: 10px 0px;
          align-items: flex-start;
        }
        .sort_eta_button {
          cursor: pointer;
        }
        .single-project .fre-project-detail-wrap .bid-nav {
          margin-bottom: 25px;
          display: flex;
          justify-content: space-between;
          padding-left: 0px;
        }
        select.project_filter {
          background: #FFF;
          border: 1px solid #dbdbdb;
          min-height: 24px;
          height: 33px;
          color: #415161;
          padding: 4px 15px;

          /* display: none; */
        }
        .bid_nav_items {
          width: -webkit-fit-content;width: -moz-fit-content;width: fit-content;
          display: flex;
          justify-content: flex-start;
          align-items: center;
          flex-wrap: wrap;
        }
        .bid-nav a {
          width: fit-content;
        }
        #authors_contracts .click-to-copy-wrapper {
          margin-bottom: 0px;
          font-size: 14px;
          line-height: 19px;
        }
        .no_contracts_msg {
          display: none;
          font-size: 15px;
          line-height: 22px;
          color: #31708f;
          background-color: #d9edf7;
          border-color: #bce8f1;
          padding: 15px;
          margin-bottom: 20px;
          border: 1px solid transparent;
          border-radius: 4px;
          text-align: center;
        }

        p.empty-bid.empty-pending.project-detail-box.bid-box.publish {
          display: flex;
          justify-content: center;
          font-size: 15px;
          color: #31708f;
          background-color: #d9edf7;
          border-color: #bce8f1;
          padding: 15px !important;
          margin-bottom: 20px;
          border: 1px solid transparent;
          border-radius: 4px;
          text-align: center;
        }
        .author_contracts_table_wrapper .col.link_col {
          font-size: 16px;
        }
        .author_contracts_table_wrapper .no_border {
          border-bottom: 0px;
        }
        .author-contracts-wrapper a.pending-acceptance {
          color: #ADD5BF;
          font-size: 16px;
          font-family: 'Roboto';
          font-style: italic;
          font-weight: 200;
        }
        .author-contracts-wrapper a.pending-acceptance .fas {
          font-size: 8px;
          border: 2px solid #94c6ab;
          padding: 2px 3px;
          border-radius: 5px;
          margin-right: 5px;
          font-weight: 600;
        }
        .author-contracts-wrapper a.pending-acceptance strong {
          font-weight: 200;
        }
        .project-detail-box.bid-box.ie-bid-box.withdrawn {
          display: none;
        }
        @media screen and (max-width: 1100px) {
          #authors_contracts.payment-table .payment-row .col {

          }
          .author_contracts_table_result .payment-row.payment-project-row {
            padding: 0px;
          }
          #authors_contracts.payment-table .payment-row .col {
            height: 40px;
          }
          .payment-table .payment-row:first-child {
            padding-bottom: 0px;
          }
        }
        @media screen and (max-width: 1380px) {
          #authors_contracts .payment-row .col:first-child {
            flex: 15%;
          }
          .fre-project-detail-wrap {
            overflow: scroll;
          }
        }

        @media screen and (max-width: 1380px) {
          .payment-row .col {
              flex: 15%;
          }
        }
        @media screen and (max-width: 600px) {
          #authors_contracts > div {
              width: 600px;
          }

          div#authors_contracts {
              overflow-x: scroll;
              position: relative;
          }
          .author_contracts_table_wrapper {
            position: relative;
          }
          .author_contracts_table_wrapper:after {
            content: '';
            width: 25px;
            height: 100%;
            top: 0px;
            right: -1px;
            position: absolute;
            background: #f6f6f6;
            background: linear-gradient(90deg, rgba(0,82,132,0) 0%, rgba(246,246,246,1) 66%);
            transition: width .3s;
          }
          .author_contracts_table_wrapper.scrolled_max:after {
            width: 0px;
          }

          #authors_contracts .payment-row .col:first-child {
              /* flex: 10%; */
              max-width: 72px;
              text-align: center !important;
              margin-right: 3px;
          }

          .employer .payment-row .col:nth-child(2) {
              text-align: left !important;
              margin: 0 8px;
              min-width: 170px;
          }
          #authors_contracts .click-to-copy {
              font-size: 12px;
              /* margin-top: -5px; */
              display: block;
          }

          #authors_contracts .click-to-copy-wrapper {
              margin-top: -5px;
          }

          #authors_contracts .payment-row .col:nth-child(3) {
              text-align: left !important;
              /* max-width: 17px; */
              max-width: 100px;
          }
        }
        @media screen and (max-width: 980px) {
          .single-project .fre-project-detail-wrap .author_contracts .bid-nav a {
            width: fit-content;
            font-size: 14px;
            font-weight: bold;
            padding-bottom: 6px;
            margin-right: 30px;
            color: #4d4d4e;
            cursor: pointer;
          }
        }
    </style>
<?php get_footer(); ?>
<script>
jQuery(document).ready(function(){
  get_param_url();
});
</script>
