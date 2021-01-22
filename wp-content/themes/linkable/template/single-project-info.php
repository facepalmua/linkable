<?php
global $wp_query, $ae_post_factory, $post, $user_ID;
$post_object    = $ae_post_factory->get( PROJECT );
$convert        = $project = $post_object->convert( $post );
$project_status = $project->post_status;

$user_role = ae_user_role( $user_ID );

$et_expired_date = $convert->et_expired_date;
$bid_accepted    = $convert->accepted;
$project_status  = $convert->post_status;

$profile_id   = get_user_meta( $post->post_author, 'user_profile_id', true );
$project_link = get_permalink( $post->ID );
$currency     = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );
$avg          = 0;


if ( is_user_logged_in() && ( ( fre_share_role() || $user_role == FREELANCER ) ) ) {
    $bidding_id  = 0;
    $child_posts = get_children(
        array(
            'post_parent' => $project->ID,
            'post_type'   => BID,
            'post_status' => 'publish',
            'author'      => $user_ID
        )
    );
    if ( ! empty( $child_posts ) ) {
        foreach ( $child_posts as $key => $value ) {
            $bidding_id = $value->ID;
        }
    }
}

?>
<div class="project-detail-box ie_project_workroom">
    <div class="project-detail-info">
        <div class="fre-table-row project-info-single-template">
            <div class="project-details-head">
                <div>
                    <h3 class="my-proj-title"><?php echo get_the_title(); ?></h3>
                    <span class="green bold click-to-copy-wrapper">
                        <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $convert->ID ) ?></span>
                    </span>

                </div>
                <div>
                    <div class="time-posted col-section">
                        <?php echo '<span class="project-header">Posted: </span> ' . human_time_diff( get_the_time( 'U', $convert->post_parent ), current_time( 'timestamp' ) ) . ' ago'; ?>
                    </div>
                    <div class="project-category col-section">
                        <span class="project-header">Category: </span>
                        <?php
                        //display category
                        //			print_r($convert);
                        $terms = get_the_terms( $convert->post_parent, 'project_category' );
                        foreach ( $terms as $term ) {
                            echo $term->name;
                        }
                        ?>
                    </div>
                </div>

            </div>

            <div class="project-description line-break" style="border: none">
                <div class="project-header">PROJECT DESCRIPTION:</div>
                <p><span><?php echo get_post_field( 'post_content', $convert->post_parent ); ?></span></p>
            </div>

            <div class="project-description no-underline line-break">
                <div class="project-header">DETAILS & REQUIREMENTS:</div>
                <p><?php
                    if ( get_post_field( 'linkable_ideas', $convert->post_parent ) ) {
                        echo '<span>' . get_post_field( 'linkable_ideas', $convert->post_parent ) . '</span>';
                    } else {
                        echo 'None';

                    }
                    ?></p>
            </div>

            <div class="project-description no-underline line-break">
                <div class="project-header">WANTS A BACKLINK ON:</div>
                <p><?php
                    if ( get_post_field( 'desired_domains_for_backlinks', $convert->post_parent ) ) {
                        echo '<span>' . get_post_field( 'desired_domains_for_backlinks', $convert->post_parent ) . '</span>';
                    } else {
                        echo 'None';

                    }
                    ?></p>
            </div>

            <div class="project-description no-underline attribute">
                <div class="project-header">DESIRED LINK ATTRIBUTE:</div>
                <p class="italic"><?php

                    $terms       = get_the_terms( $convert->ID, 'project-follow-type' );
                    $follow_type = [];
                    $no_pref     = array( 'NoFollow', 'DoFollow' );
                    foreach ( $terms as $term ) {
                        array_push( $follow_type, $term->name );
                    }

                    if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                        echo "NoFollow or DoFollow";
                    } else {
                        echo $follow_type[0];
                    }
                    ?></p>
            </div>
            <?php
                $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
                echo la_build_backlinks_to_markup($preferred_pages);
            ?>
        </div>
    </div>
</div>