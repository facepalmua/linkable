<?php
if ( ! defined( 'ABSPATH' ) ) die( 'No kidding, please!' );
?>
<div class="fre-table-row <?php echo $bid_status; ?> fre-table-row-all">
    <div class="fre-table-row-inner">
        <div class="title-workroom">
            <div class="project-details-head">
                <h3 class="my-proj-title"><?php echo get_the_title(); ?>
                    <span class="green bold btn-block">
                        <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $bid_parent ); ?></span>
                    </span>
                </h3>
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
                $submitted_text .= 'on ' . date( 'M j, Y', strtotime( $date_posted ) );
                // } else {
                // 	$submitted_text .= floor( $datediff / ( 60 * 60 * 24 ) ) . ' days ago';
                // }

                if ('cancelled' == $bid_status ) {
                    $cancel_date = get_post_meta( get_the_ID(), 'bid_cancel_date', true);
                    $c_date = $date_posted;
                    $cancel_text = ! empty( $cancel_date ) ? 'Cancelled ' : 'Submitted ';
                    if( ! empty( $cancel_date ) ) {
                        $c_date = 'on ' . date( 'M j, Y', strtotime( $cancel_date ) );
                    }
                    echo "<div class='days-left'><i class='fa fa-calendar-alt'></i> ".$cancel_text . $c_date." </div>";
                }
                else if ( 'deleted' == $bid_status ) {
                    // if( $due_date < $today ){
                    echo "<div class='days-left'><i class='fa fa-calendar-alt'></i> Submitted on ".date( 'M j, Y', strtotime( $date_posted ) )." </div>";
                    // } else {
                    // 	echo "<span class='days-left'><i class='fa fa-calendar-alt'></i> Submitted " . floor( $datediff / ( 60 * 60 * 24 ) ) . " days ago</span>";
                    // }
                }
                else if ( $bid_status == 'active' || $bid_status == 'accept' || $bid_status == 'admin-review') {
                    echo "<div class='days-left'><i class='fa fa-calendar-alt'></i>" . floor( $datediff / ( 60 * 60 * 24 ) ) . " days left to complete</div>";
                }
                else {
                    echo "<div class='days-left'><i class='fa fa-calendar-alt'></i> ". $submitted_text ."</div>";
                }
                ?>
            </div>
        </div>
        <!--                                                        <div class="project-description">-->
        <!--                                                            <div class="project-header">Content Marketer's Description-->
        <!--                                                            </div>-->
        <!--                                                            <p>-->
        <?php //echo get_post_field( 'post_content', $bid_parent ); ?><!--</p>-->
        <!--                                                        </div>-->
        <!---->
        <!--                                                        <div class="project-description linkable-ideas">-->
        <!--                                                            <div class="project-header">Additional Info</div>-->
        <!--                                                            <p>-->
        <?php
        //																if ( get_field( 'linkable_ideas', $bid_parent ) ) {
        //																	echo get_field( 'linkable_ideas', $bid_parent );
        //																} else {
        //																	echo 'The Content Marketer has no additional info about their page.';
        //																}
        //
        //																?><!--</p>-->
        <!--                                                        </div>-->

        <div class="project-description">
            <div class="project-header">Your Contract Proposal</div>
            <p><?php echo get_field( 'proposal' ); ?></p>
        </div>

        <div class="project-top-bar">
            <div class="left-bar">
                <div class="time-posted col-section">
                    <span class="project-header">Your Proposed Link On</span> <span class="bold green"><?php echo get_field( 'url_domain' ); ?></span>
                </div>
                <div class="time-posted link-attribute col-section">
                    <div class="project-header">Your Promised Timeframe</div>
                    <?php echo get_field( 'how_long' ); ?>
                </div>
            </div>
        </div>
    </div>


    <div class="project-status col-section">
        <div class="project-status-bar">

            <?php
            //	echo $bid_status;
            if ( $bid_status == 'accept' || $bid_status == 'admin-review' ) {
                echo "<span><strong>Contract Status:</strong> <i>Active - Your contract was accepted and is active. Go to the workroom and follow the directions to complete this.</i></span>";
            } else if ( ($bid_status == 'cancelled' || $proj_status == 'cancelled') && $bid_status !== 'pending-completion' ) {
                echo "<span><strong>Contract Status:</strong> <i>Cancelled - This contract has been cancelled.</i></span>";
            } else if ( $bid_status == 'deleted' ) {
                echo "<span><strong>Contract Status:</strong> <i>Declined - Your contract was declined by the client.</i></span> <span class='decline-toggle'>See reason for decline</span><span class='decline-reason'>" . get_field( 'declination_reason' ) . "</span>";
            } else if ( $bid_status == 'pending-completion' ) {
                echo "<span><strong>Contract Status:</strong> <i>Completed - You marked this contract has complete and the work should be done.</i></span>";
            } else if ( $proj_status == 'publish' || $bid_status == 'publish' ) {
                echo "<span><strong>Contract Status:</strong> <i>Pending Acceptance - Your contract was submitted to the client and is pending their acceptance.</i></span>";
            } else if ( $bid_status == 'complete' || $bid_status == 'pending-completion' ) {
                echo "<span><strong>Contract Status:</strong> <i>Completed - This contract is completed.</i></span>";
            } else if ( $proj_status = "complete" || $proj_status == 'pending-completion' ) {
                echo "<span><strong>Contract Status:</strong> <i>Pending Acceptance - Your contract was submitted to the client and is pending their acceptance.</i></span>";
            } else {
                echo "<span><strong>Contract Status:</strong> <i>Completed - You marked this contract has complete and the work should be done.</i></span>";
            }


            ?>
            <div class="workspace-button tablet desktop">
                <?php
                if ( $bid_status != 'publish' && $bid_status != 'deleted' ) {
                    echo '<a href="' . get_permalink() . '"  >' . __( 'Go to workroom', ET_DOMAIN ) . '<i class="fas fa-sign-out-alt"></i></a>';
                }
                ?>

            </div>
        </div>
    </div>


    <div class="workspace-button mobile">
        <?php

        if ( $proj_status == 'complete' || $proj_status == 'accept' || $proj_status == 'pending-completion' ) {
            echo '<a href="' . get_permalink() . '"  >' . __( 'Go to workroom', ET_DOMAIN ) . '<i class="fas fa-sign-out-alt"></i></a>';
        }
        ?>
    </div>

</div>
