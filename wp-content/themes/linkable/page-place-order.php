<?php
/**
 * Template Name:Place an order
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
        input[type=range] {
          height: 30px;
          -webkit-appearance: none;
          margin: 10px 0;
          width: 100%;
        }
        input[type=range]:focus {
          outline: none;
        }
        input[type=range]::-webkit-slider-runnable-track {
          width: 100%;
          height: 6px;
          cursor: pointer;
          animate: 0.2s;
          box-shadow: 0px 0px 0px #000000;
          background: #F0F5F0;
          border-radius: 6px;
          border: 0px solid #000000;
        }
        input[type=range]::-webkit-slider-thumb {
          box-shadow: 0px 0px 0px #000000;
          border: 0px solid #000000;
          height: 24px;
          width: 24px;
          border-radius: 12px;
          background: #56C23A;
          cursor: pointer;
          -webkit-appearance: none;
          margin-top: -9px;
        }
        input[type=range]:focus::-webkit-slider-runnable-track {
          background: #F0F5F0;
        }
        input[type=range]::-moz-range-track {
          width: 100%;
          height: 6px;
          cursor: pointer;
          animate: 0.2s;
          box-shadow: 0px 0px 0px #000000;
          background: #F0F5F0;
          border-radius: 6px;
          border: 0px solid #000000;
        }
        input[type=range]::-moz-range-thumb {
          box-shadow: 0px 0px 0px #000000;
          border: 0px solid #000000;
          height: 24px;
          width: 24px;
          border-radius: 12px;
          background: #56C23A;
          cursor: pointer;
        }
        input[type=range]::-ms-track {
          width: 100%;
          height: 6px;
          cursor: pointer;
          animate: 0.2s;
          background: transparent;
          border-color: transparent;
          color: transparent;
        }
        input[type=range]::-ms-fill-lower {
          background: #F0F5F0;
          border: 0px solid #000000;
          border-radius: 12px;
          box-shadow: 0px 0px 0px #000000;
        }
        input[type=range]::-ms-fill-upper {
          background: #F0F5F0;
          border: 0px solid #000000;
          border-radius: 12px;
          box-shadow: 0px 0px 0px #000000;
        }
        input[type=range]::-ms-thumb {
          margin-top: 1px;
          box-shadow: 0px 0px 0px #000000;
          border: 0px solid #000000;
          height: 24px;
          width: 24px;
          border-radius: 12px;
          background: #56C23A;
          cursor: pointer;
        }
        input[type=range]:focus::-ms-fill-lower {
          background: #F0F5F0;
        }
        input[type=range]:focus::-ms-fill-upper {
          background: #F0F5F0;
        }
        h1.entry-title {
          color: #1FAA49;
          margin-bottom: 10px;
        }
        .place_order_table {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
        }
        .place_order_table .place_order_settings {
          background: white;
          padding-bottom: 40px;
          box-shadow: 0px 0px 11px 3px #0000002e;
          width: 100%;
          padding: 0px 25px;
        }
        .place_order_table .place_order_settings .place_order_setting_item {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-top: 35px;
          padding-bottom: 25px;
          border-bottom: 1px solid #d2d2d2;
        }
        .place_order_setting_item .item_description.full {
          width: -webkit-fill-available;width: -moz-available;width: fill-available;
        }
        .place_order_setting_item .item_description .select_wrapper {
          position: relative;
          margin-left: 24px;
          margin-right: 24px;
        }
        .place_order_setting_item .item_description .select_wrapper svg {
          position: absolute;
          right: 6px;
          top: 50%;
          transform: translateY(-50%);
          width: 10px;
          height: 10px;
        }
        .place_order_setting_item .item_description select {
          width: -webkit-fill-available;width: -moz-available;width: fill-available;
          -webkit-appearance: none;-moz-appearance: none;appearance: none;
          font-size: 16px;
          line-height: 19px;
          padding: 7px 10px;
          border: 1px solid #CCCCCC;
          border-radius: 5px;
          color: #4D4D4E;
        }
        .place_order_table .place_order_settings .slider_item label {
          float: right;
          margin-bottom: 10px;
          font-weight: 400;
        }
        .place_order_table .place_order_settings .slider_item {
          min-width: calc( 300 / 900 * 100% );
        }
        .place_order_table .place_order_settings .place_order_setting_item h3 {
          margin: 0px 0px 12px;
          font-size: 20px;
        }
        .place_order_table .place_order_settings .place_order_setting_item .subtitle {
          margin-left: 24px;
          margin-right: 24px;
        }
        .place_order_table .place_order_total {
          min-width: 300px;
          margin-left: 40px;
          background: white;
          border-top: 4px solid #1aad4b;
          box-shadow: 0px 0px 11px 3px #0000002e;
          padding: 20px;
        }
        .place_order_table .place_order_total h3 {
          margin: 0px auto 20px;
          text-align: center;
        }
        .place_order_table .place_order_total .li_item {
          margin-bottom: 8px;
          font-size: 14px;
        }
        .place_order_table .place_order_total .li_item i {
          margin-right: 10px;
        }
        .place_order_total .order_total_inner{
          padding: 25px 15px 34px;
          margin-top: 25px;
          border-top: 1px solid #e7e7e7;
        }
        .place_order_total .order_total_inner .total_cost_title {
          font-size: 20px;
          margin: 0 auto 8px;
          font-weight: bold;
          text-align: center;
        }
        .place_order_total .order_total_inner .price {
          font-size: 48px;
          margin: 0 auto 8px;
          font-weight: bold;
          text-align: center;
          line-height: 1em;
          width: -webkit-fit-content;width: -moz-fit-content;width: fit-content;
          position: relative;
        }
        .price .price_absolute {
          position: absolute;
          font-size: 16px;
          font-weight: 400;
          left: 100%;
          top: 0px;
          margin-left: 5px;
          color: #1aad4b;
          width: -webkit-fit-content;width: -moz-fit-content;width: fit-content;
          line-height: 18px;
        }
        .place_order_total .order_total_inner .price_type {
          font-size: 18px;
          margin: 0 auto 8px;
          font-style: italic;
          text-align: center;
          line-height: 1em;
        }
        .place_order_total a {
          width: 190px;
          height: 45px;
          color: white;
          display: flex;
          justify-content: center;
          align-items: center;
          background: #1aad4b;
          border-radius: 5px;
          margin: 0 auto 12px;
        }

    </style>

    <div class="entry-content landing-entry-content single-project">
        <?php get_template_part( 'dashboard-side-nav' ); ?>
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
                              <h1 class="entry-title">Place an order</h1>
                              <p class="optional-text my-projects">
                                Simply let us know your backlink requirements below and place your order. All orders placed come with our Link-able Express Guarantee and you’ll be able to approve all domain(s) first before any link is built. This part should be standard page template text.
                                <?= wpautop(get_the_content()); ?>
                              </p>
                              <div class="place_order_table">
                                <div class="place_order_settings">
                                  <div class="place_order_setting_item">
                                    <div class="item_description">
                                      <h3>1. Choose the DA strength:</h3>
                                      <p class="subtitle">The higher number, the more authorative the site is.</p>
                                    </div>
                                    <div class="slider_item">
                                      <label for="range_da"><b><span>10</span>+</b> DA</label>
                                      <input type="range" id="range_da" name="points" value="10" min="10" max="50" step="10">
                                    </div>
                                  </div>
                                  <div class="place_order_setting_item">
                                    <div class="item_description">
                                      <h3>2. Choose the quantity:</h3>
                                      <p class="subtitle">The more links you order, the bigger the discount you’ll get!</p>
                                    </div>
                                    <div class="slider_item">
                                      <label for="range_quantity"><b><span>1</span></b> link</label>
                                      <input type="range" id="range_quantity" name="points" value="1" min="1" max="5" step="1">
                                    </div>
                                  </div>
                                  <div class="place_order_setting_item">
                                    <div class="item_description">
                                      <h3>3. Do you have specific anchor text & target URL(s)?</h3>
                                      <p class="subtitle">If yes, we’ll ask you for these after your order has been placed.</p>
                                    </div>
                                    <div class="slider_item">
                                      <label for="points"><b><span>Yes</span></b></label>
                                      <input type="range" class="yes_no_range" id="anchor_text_range" name="points" value="0" min="0" max="1" step="1">
                                    </div>
                                  </div>
                                  <div class="place_order_setting_item">
                                    <div class="item_description">
                                      <h3>4. Would you like to approve the domain?</h3>
                                      <p class="subtitle">If yes, you’ll get to approve the domain for each link we
                                        build. This typically requires more communication and time
                                        and thus increases the cost.
                                      </p>
                                    </div>
                                    <div class="slider_item">
                                      <label for="points"><b><span>Yes</span></b></label>
                                      <input type="range" class="yes_no_range" id="target_url_range" name="points" value="0" min="0" max="1" step="1">
                                    </div>
                                  </div>
                                  <div class="place_order_setting_item">
                                    <div class="item_description full">
                                      <h3>5. What project should this order be assigned to? </h3>
                                      <?php
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
                                              'post_status'      => array( 'publish', 'pending'),
                                          )
                                      );
                                      //var_dump($employer_current_project_query->posts);
                                      ?>
                                      <p class="subtitle">
                                        <div class="select_wrapper">
                                          <select class="project_select" name="project_select">
                                            <option value=""> -- Select your project for this order -- </option>
                                            <?php foreach ($employer_current_project_query->posts as $post): ?>
                                              <option value="<?= $post->ID ?>"><?= $post->post_title ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="7.778" height="4.587" viewBox="0 0 7.778 4.587">
                                            <g id="arrow_select" data-name="arrow select" transform="translate(-1177.111 -1025.646)">
                                              <path id="Path_1" data-name="Path 1" d="M0,0H5.487" transform="translate(1180.655 1029.88) rotate(-45)" fill="none" stroke="#555" stroke-width="1"/>
                                              <line id="Line_2" data-name="Line 2" y1="5" transform="translate(1177.464 1026) rotate(-45)" fill="none" stroke="#555" stroke-width="1"/>
                                            </g>
                                          </svg>

                                        </div>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                <div class="place_order_total">
                                  <h3>ORDER SUMMARY:</h3>
                                  <div class="custom_li">
                                    <div class="li_item">
                                      <i class="fa fa-check-circle" aria-hidden="true"></i> MOZ DA <span class="da_value">10</span>+ sites
                                    </div>
                                    <div class="li_item">
                                      <i class="fa fa-users" aria-hidden="true"></i> REAL sites relevant to your niche
                                    </div>
                                    <div class="li_item">
                                      <i class="fa fa-thumbs-up" aria-hidden="true"></i> You approve domain
                                    </div>
                                    <div class="li_item">
                                      <i class="fa fa-pencil" aria-hidden="true"></i> 1000+ word quality article
                                    </div>
                                    <div id="anchor_text_choice" class="li_item">
                                      <i class="fa fa-link" aria-hidden="true"></i> Anchor text choice (optional)
                                    </div>
                                    <div id="target_url_choice" class="li_item">
                                      <i class="fa fa-link" aria-hidden="true"></i> Target URL choice (optional)
                                    </div>
                                  </div>
                                  <div class="order_total_inner">
                                    <div class="total_cost_title">
                                      Total cost:
                                    </div>
                                    <div class="price" price_per_link="111">
                                      $<span>111</span>
                                      <div class="price_absolute">
                                        0% OFF!
                                      </div>
                                    </div>
                                    <div class="price_type">
                                      per link
                                    </div>
                                  </div>
                                  <a href="#">Order now</a>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <?= do_shortcode( '[gravityform id="24" title="false" description="false"]' ); ?>
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
