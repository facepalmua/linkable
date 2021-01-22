<?php
/**
 * Template Name: Author App - Cancelled
 */
add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';
    $classes[] = 'page-template-page-my-project';

    return $classes;
}

$user_role = ae_user_role( $user_ID );

if ( ( ! is_user_logged_in() ) || ( $user_role == 'employer' ) ) {
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

?>

<style>
    .dashboard-sidebar > ul > li.la_nav_app_project a {
        color: white;
        font-weight: bold;
    }
    .dashboard-sidebar > ul > li.la_nav_app_project a i {
        color: #1aad4b;
    }
</style>

<?php
//project query
$args = array(
	'post_type'      => 'bid',
	'author'         => $current_user->ID,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'cancelled',
	'post_count'     => - 1,
	'posts_per_page' => - 1,
	'max_num_pages'  => 50000000
);
if ( isset( $_GET['orderby'] ) && 'deadline' == $_GET['orderby'] ) {
	$args['order'] = 'ASC';
}
$author_app_query = new WP_Query( $args );
?>

<div class="entry-content landing-entry-content">

	<?php get_template_part( 'dashboard-side-nav-projects' ); ?>

    <div class="main-dashboard-content dashboard-landing inner-dashboard">
        <h1 class="entry-title"><?php if ( ae_user_role() == FREELANCER ) { ?>My Contracts<?php } else { ?>My Projects<?php } ?></h1>
	    <?php
	    if ( $user_role == 'freelancer' ) {
		    echo '<p class="optional-text my-projects">';
		        echo get_field( 'intro_text_copy', 1813 );
		    echo '</p>';
	    }
	    ?>
        <div class="fre-page-section">
            <div class="container">
                <div class="my-work-employer-wrap freelancer-csm-contracts-table">

					<?php include( locate_template( 'author-app-nav.php', false, false ) ); ?>

                    <div class="fre-tab-content">

                        <div id="current-project-tab" class="freelancer-current-project-tab fre-panel-tab active">

                            <div class="fre-work-project-box">

                                <div class="current-freelance-project">
									<?php
									if ( $author_app_query->have_posts() ) { ?>
                                        <div class="fre-table">
                                            <div class="fre-current-table-rows" style="display: table-row-group;">

                                                <div class="fre-all-contracts-table">
                                                    <style>
                                                        .fre-all-contracts-table {
                                                            background: #fff;
                                                            padding: 20px;
                                                            border-bottom: 2px solid #e6e6e6;
                                                        }

                                                        .fre-all-contracts-table th {
                                                            color: #848485;
                                                            font-size: 14px;
                                                            text-transform: uppercase;
                                                        }

                                                        .fre-all-contracts-table th,
                                                        .fre-all-contracts-table td {
                                                            border-bottom: 1px solid #e6e6e6;
                                                            text-align: left;
                                                            padding: 10px 0;
                                                        }

                                                        .fre-all-contracts-table tr:last-child td {
                                                            border: 0;
                                                            padding-bottom: 0;
                                                        }

                                                        .fre-all-contracts-table .accept .status {
                                                            color: #1aad4b;
                                                        }

                                                        .fre-all-contracts-table .cancelled .status {
                                                            color: #c05f3e;
                                                        }
                                                        .fre-all-contracts-table td .status, .fre-all-contracts-table td .days-left {
                                                            font-size: 14px !important;
                                                        }
                                                        .fre-all-contracts-table td .days-left {
                                                            color: #333333;
                                                        }
                                                    </style>
                                                    <table style="width: 100%;">
                                                        <tr>
															<?php if ( $user_role == FREELANCER ) {
																echo '<th>Client</th>';
															} ?>

															<?php if ( $user_role == FREELANCER ) {
																echo '<th>Backlink on</th>';
															}
															$deadlineOrderLink = get_site_url() . '/my-applications/cancelled';
															$deadlineOrderLink .= isset( $_GET['orderby'] ) && 'deadline' == $_GET['orderby'] ? '' : '?orderby=deadline';
															if ( isset( $_GET['project_id'] ) && ! empty( $_GET['project_id'] ) ) {
																$deadlineOrderLink = add_query_arg(
																	'project_id',
																	$_GET['project_id'],
																	$deadlineOrderLink
																);
															}
															?>
                                                            <th>Status</th>
                                                            <th>
                                                                <a href="<?= $deadlineOrderLink; ?>"
                                                                   style="color: inherit; ">Deadline <i
                                                                            class="fa fa-sort"></i></a>
                                                            </th>

															<?php if ( $user_role == FREELANCER ) {
																echo '<th>Details & Requirements</th>';
															} ?>
                                                        </tr>

														<?php
														while ( $author_app_query->have_posts() ) {
															$author_app_query->the_post();

															$bid_status = get_post_status();
															$bid_parent = wp_get_post_parent_id( get_the_ID() );
															$proj_status = get_post_status( $bid_parent );

															// Loop the item
															include dirname( __FILE__ ) . '/template/loop-application-item-table.php';
														}
														//}
														?>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
									<?php } else { ?>
                                        <div class="text-center alert alert-info">You have no jobs yet!</div>
									<?php } ?>
                                </div>
                            </div>

                            <nav>
								<?php
								$big = 999999999; // need an unlikely integer
								echo paginate_links( array(
									'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format'    => '?paged=%#%',
									'current'   => max( 1, get_query_var( 'paged' ) ),
									'total'     => $author_app_query->max_num_pages,
									'prev_text' => '<',
									'next_text' => '>'
								) );
								?>
                            </nav>
							<?php
							wp_reset_postdata();
							wp_reset_query();
							?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div> <!--- end inner dashboard -->
</div> <!-- end entry content -->

<?php get_footer(); ?>

<script>
    //add active class to dashboard sidebar
    jQuery(".project-sub-nav li:nth-child(6)").addClass("active");
    jQuery(".nav-tabs-my-work li:nth-child(6)").addClass("active");
</script>