<?php
global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;

$post_object = $ae_post_factory->get( PROJECT );
$project     = $post_object->current_post;

//$number_bids = (int) get_number_bids( get_the_ID() ); // 1.8.5
add_filter( 'posts_orderby', 'fre_order_by_bid_status' );
$bid_query = new WP_Query( array(
        'post_type'      => BID,
        'post_parent'    => get_the_ID(),
        'posts_per_page' => - 1
    )
);
remove_filter( 'posts_orderby', 'fre_order_by_bid_status' );
$bid_data = array();

//get count of all projects by this owner. get link to each one and show in sidebar.
//create ability to purchase bids
//create ability to change status between pending and accepted


?>

<div id="project-detail-bidding" class="project-detail-box no-padding pending">

    <div class="freelancer-bidding">
        <div class="bid-nav">
            <a class="pending-bids active">Pending Contracts (<span class="pending-count">0</span>)</a>
            <a class="accepted-bids">Accepted Contracts (<span class="accepted-count">0</span>)</a>
            <a class="complete-bids">Completed Contracts (<span class="completed-count">0</span>)</a>
            <a class="cancelled-bids">Cancelled Contracts (<span class="cancelled-count">0</span>)</a>
        </div>

        <?php
        if ( $bid_query->have_posts() ) {
            global $wp_query, $ae_post_factory, $post;

            $post_object = $ae_post_factory->get( BID );
            while ( $bid_query->have_posts() ) {
                $bid_query->the_post();
                $convert = $post_object->convert( $post );
                $show_bid_info = can_see_bid_info( $convert, $project);

                //echo $convert->ID;

                get_template_part( 'template/bidding', 'item' );
            }
        } else {
            get_template_part( 'template/bid', 'not-item' );
        }
        ?>
    </div>



    <?php
    wp_reset_postdata();
    wp_reset_query();
    ?>
</div>