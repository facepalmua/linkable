<?php
if ( ! defined( 'ABSPATH' ) ) die( 'No kidding, please!' );
?>

    <?php
        $time_left   = 0;
        $date_posted = get_the_date();
        $how_long    = get_field( 'how_long' );

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

        $due_date = strtotime( $due_date );

        $bid_status = get_post_status();
        $datediff = $due_date - $today;

        $submitted_text = ( $bid_status == 'completed' || $bid_status == 'pending-completion' ) ? 'Completed ' : 'Submitted ';
        // if( $due_date < $today ){

        $comp_timestamp      = get_field( 'completed_date' );
        $submitted_text .= 'on ' . date( 'M j, Y', strtotime( $comp_timestamp ) );

        //$submitted_text .= 'on ' . date( 'M j, Y', strtotime( $date_posted ) );


        // } else {
        // 	$submitted_text .= floor( $datediff / ( 60 * 60 * 24 ) ) . ' days ago';
        // }
    ?>

    <!-- <div class="workspace-button mobile">
        <?php

        // if ( $proj_status == 'complete' || $proj_status == 'accept' || $proj_status == 'pending-completion' ) {
        //     echo '<a href="' . get_permalink() . '"  >' . __( 'Go to workroom', ET_DOMAIN ) . '<i class="fas fa-sign-out-alt"></i></a>';
        // }
        ?>
    </div> -->


    <tr class="<?php echo $bid_status; ?> fre-table-row-all">
        <td>
            <span class="bold btn-block">
                <?php $ie_perge_client_url = get_field( 'url_of_page_you_want_to_build_a_link_to', $bid_parent ); ?>
                <span class="click-to-copy"><?php echo la_clear_domain_name($ie_perge_client_url); ?></span>
            </span>
        </td>

        <td>
            <?php $ie_perge_backlink = get_field( 'url_domain' ); ?>
            <strong class="proposed-url"><span class=""><?php echo la_clear_domain_name($ie_perge_backlink); ?></span></strong>
        </td>

        <td class="text-uppercase">
            <?php
            //  echo $bid_status;
            if ( $bid_status == 'accept' || $bid_status == 'admin-review' ) {
	            echo '<span class="status bold text-dark-green">Active</span>';
            } else if ( ( $bid_status == 'cancelled' || $proj_status == 'cancelled' ) && $bid_status !== 'pending-completion' ) {
	            echo '<span class="status bold text-red">Cancelled</span>';
            } else if ( $bid_status == 'deleted' ) {
	            echo '<span class="status bold text-dark-red">Declined</span>';
            } else if ( $bid_status == 'pending-completion' ) {
	            echo '<span class="status bold">Completed</span>';
            } else if ( $proj_status == 'publish' || $bid_status == 'publish' ) {
	            echo '<span class="status bold text-magenta">Pending Acceptance</span>';
            } else if ( $bid_status == 'complete' || $bid_status == 'pending-completion' ) {
	            echo '<span class="status bold text-dark">Completed</span>';
            } else if ( $proj_status = "complete" || $proj_status == 'pending-completion' ) {
	            echo '<span class="status bold">Pending Acceptance</span>';
            } else {
	            echo '<span class="status bold text-dark">Completed</span>';
            }
            ?>
        </td>

        <td>
            <?php
            if ('cancelled' == $bid_status ) {
                $cancel_date = get_post_meta( get_the_ID(), 'bid_cancel_date', true);
                $c_date = $date_posted;
                $cancel_text = ! empty( $cancel_date ) ? 'Cancelled ' : 'Submitted ';
                if( ! empty( $cancel_date ) ) {
                    $c_date = 'on ' . date( 'M j, Y', strtotime( $cancel_date ) );
                }
                echo "<div class='days-left'></i> ".$cancel_text . $c_date." </div>";
            }
            else if ( 'deleted' == $bid_status ) {
                // if( $due_date < $today ){
                echo "<div class='days-left'></i> Submitted on ".date( 'M j, Y', strtotime( $date_posted ) )." </div>";
                // } else {
                //  echo "<span class='days-left'></i> Submitted " . floor( $datediff / ( 60 * 60 * 24 ) ) . " days ago</span>";
                // }
            }
            else if ( $bid_status == 'active' || $bid_status == 'accept' || $bid_status == 'admin-review') {
                echo "<div class='days-left'></i>" . floor( $datediff / ( 60 * 60 * 24 ) ) . " days left</div>";
            }
            else if ( $bid_status == 'publish' || $bid_status == 'pending-acceptance' ) {
              echo "<div class='days-left'></i> Submitted on ".get_the_date( 'M j, Y', get_the_ID() )." </div>";
            }
            else {
                echo "<div class='days-left'></i> ". $submitted_text ."</div>";
            }
            ?>
        </td>

        <td>
            <div class="tablet desktop">
            <?= '<a href="' . get_permalink() . '"  >' . __( 'View job', ET_DOMAIN ) . '<i class="fas fa-sign-out-alt"></i></a>' ?>
            </div>
        </td>

    </tr>
