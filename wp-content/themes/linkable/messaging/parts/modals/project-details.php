<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( "You can't access this file directly" );
}
$job_title = get_author_tag_name( $author );
$a_rating  = Fre_Review::freelancer_rating_score( $author->ID );
?>
<div class="modal fade text-left la_modal_container_project_container" id="la_modal_container_project" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel">
    <div class="modal-dialog" role="document">

			<div class="project-detail-box ie_project_workroom">
			    <div class="project-detail-info">
			        <div class="fre-table-row project-info-single-template">
			            <div class="project-details-head">
			                <div>
			                    <h3 class="my-proj-title"><?php echo $project->post_title; ?></h3>
			                    <span class="green bold click-to-copy-wrapper">
			                        <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $project->ID ) ?></span>
			                    </span>

			                </div>
			                <div>
			                    <div class="time-posted col-section">
			                        <?php echo '<span class="project-header">Posted: </span> ' . human_time_diff( get_the_time( 'U', $project->ID ), current_time( 'timestamp' ) ) . ' ago'; ?>
			                    </div>
			                    <div class="project-category col-section">
			                        <span class="project-header">Category: </span>
			                        <?php
			                        //display category
			                        //			print_r($convert);
			                        $terms = get_the_terms( $project->ID, 'project_category' );
			                        foreach ( $terms as $term ) {
			                            echo $term->name;
			                        }
			                        ?>
			                    </div>
			                </div>

			            </div>

			            <div class="project-description line-break" style="border: none">
			                <div class="project-header">PROJECT DESCRIPTION:</div>
			                <p><span><?php echo get_post_field( 'post_content', $project->ID ); ?></span></p>
			            </div>

			            <div class="project-description no-underline line-break">
			                <div class="project-header">DETAILS & REQUIREMENTS:</div>
			                <p><?php
			                    if ( get_post_field( 'linkable_ideas', $project->ID ) ) {
			                        echo '<span>' . get_post_field( 'linkable_ideas', $project->ID ) . '</span>';
			                    } else {
			                        echo 'None';

			                    }
			                    ?></p>
			            </div>

			            <div class="project-description no-underline line-break">
			                <div class="project-header">WANTS A BACKLINK ON:</div>
			                <p><?php
			                    if ( get_post_field( 'desired_domains_for_backlinks', $project->ID ) ) {
			                        echo '<span>' . get_post_field( 'desired_domains_for_backlinks', $project->ID ) . '</span>';
			                    } else {
			                        echo 'None';

			                    }
			                    ?></p>
			            </div>

			            <div class="project-description no-underline attribute">
			                <div class="project-header">DESIRED LINK ATTRIBUTE:</div>
			                <p class="italic"><?php

			                    $terms       = get_the_terms( $project->ID, 'project-follow-type' );
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
			                $preferred_pages = get_field('preferred_pages_to_link', $project->ID);
			                echo la_build_backlinks_to_markup($preferred_pages);
			            ?>
			        </div>
			    </div>
			</div>
    </div>
</div>
