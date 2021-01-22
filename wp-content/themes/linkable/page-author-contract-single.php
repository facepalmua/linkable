<?php
/**
 * Template Name: Author Contracts single
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
    //wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
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
        }
        .author-contracts-wrapper {
          background: #f6f6f6;
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
          align-items: center;
        }
        select.project_filter {
          background: #FFF;
          border: 1px solid #dbdbdb;
          min-height: 24px;
          color: #415161;
          padding: 4px 15px;
          display: none;
        }
        .bid_nav_items {
          width: -webkit-fit-content;width: -moz-fit-content;width: fit-content;
        }
        
        @media screen and (max-width: 600px) {
          #authors_contracts > div {
              width: 600px;
          }

          div#authors_contracts {
              overflow-x: scroll;
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
        .project-detail-box.bid-box {
          display: block !important;
        }
        .single-contract-page .info-for-purchase {
          display: none;
        }
        #project-detail-bidding .application-status {
          display: flex !important;
        }
        .single-project-bidding-item-copy div.click-to-copy-wrapper {
          display: flex;
          width: auto;
          max-width: -webkit-fit-content;
          max-width: -moz-fit-content;
          max-width: fit-content;
        }
        div.complete-status {
          width: -webkit-fill-available;width: -moz-available;width: fill-available;
        }
        .my-proj-title .green:hover .copy-tooltip, .click-to-copy-wrapper:hover .copy-tooltip {
          z-index: 99;
        }
        .author-app-popup.author-popup-opac {
          z-index: 100;
        }
        .single-contract-page .gform_wrapper .gfield_label {
            font-weight: 500;
            color: #4d4d4e;
        }
        a.go_back_btn {
          background: #1aad4b;
          color: white;
          display: block;
          width: -webkit-fit-content;width: -moz-fit-content;width: fit-content;
          /* display: flex; */
          /* justify-content: center; */
          /* align-items: center; */
          padding: 3px 7px;
          border-radius: 5px;
          font-weight: 600;
          font-size: 14px;
          margin-bottom: 25px;
        }
    </style>
    <?php
    if (isset($wp_query->query_vars['la_contract_id'])) {
      $la_contract_id = urldecode($wp_query->query_vars['la_contract_id']);
      //echo $la_contract_id;
    } ?>
    <div class="entry-content landing-entry-content single-project single-contract-page">


        <?php get_template_part( 'dashboard-side-nav' ); ?>
        <!-- <div class="main-dashboard-content dashboard-landing inner-dashboard">
            <h1 class="entry-title">Author contracts</h1>
            <p class="optional-text my-projects">-->
              <?php
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
              ?>
            <!-- </p> -->

            <div class="fre-project-detail-wrap" style="width: calc(100% + 30px);background: #f6f6f6;">

              <div class="cart-banner">
                  <div class="left-column">
                      <div class="num-selected"><span class="num">0</span> <span class="app-numberdd"></span>author
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
                            <?php
                            $params = http_build_query($_GET);
                            if ($params) {
                              $params = '?' . $params;
                            }
                            ?>
                              <a class="go_back_btn" href="<?= get_home_url() ?>/author-contracts/?<?= $params ?>"><i class="fas fa-arrow-left"></i> Go Back</a>
                              <h1 style="color:#1aad4b" class="entry-title">#<?= $la_contract_id ?> Author Contract Details:</h1>
                              <p class="optional-text my-projects">
                                  <?php
                                  //var_dump($employer_current_project_query->posts);
                                  $post_parent_in = array();
                                  foreach ($employer_current_project_query->posts as $project_post) {
                                    $post_parent_in[] = $project_post->ID;
                                  }
                                  //var_dump($post_parent_in);
                                  ?>

                                  <?php
                                  global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;

                                  $post_object = $ae_post_factory->get( PROJECT );
                                  $project     = $post_object->current_post;
                                  add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                                  $bid_query = new WP_Query( array(
                                          'post_type'      => BID,
                                          'p'        => $la_contract_id,
                                          //'post_parent'    => 5362,
                                          //'post_parent__in' => $post_parent_in,
                                          'posts_per_page' => -1,
                                          //'post_status' => 'publish',
                                      )
                                  );
                                  remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
                                  $bid_data = array();
                                  ?>
                                  <div id="project-detail-bidding" class="project-detail-box no-padding pending">
                                      <div class="freelancer-bidding author_contracts">
                                          <!-- <div class="bid-nav">
                                            <div class="bid_nav_items">
                                              <a class="pending-bids active">Pending (<span class="pending-count">0</span>)</a>
                                              <a class="accepted-bids">Active (<span class="accepted-count">0</span>)</a>
                                              <a class="complete-bids">Completed (<span class="completed-count">0</span>)</a>
                                              <a class="cancelled-bids">Cancelled (<span class="cancelled-count">0</span>)</a>
                                            </div>
                                          </div> -->

                                          <?php
                                          // loop for pending contacts
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
                                          wp_reset_query();
                                      ?>
                                    </div>
                                  </div>
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
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
<?php get_footer(); ?>
