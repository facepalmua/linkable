<?php
/**
 * Template Name: Author App - All
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

    .la_category_list_holder {
        position: absolute;
        width: 100%;
        background-color: #ffffff;
        z-index: 99;
        text-align: left;
        padding: 20px;
        max-width: 380px;
        box-shadow: 1px 1px 6px -4px;
        right: 15px;
        opacity: 0;
        visibility: hidden;
        top: 80px;
        -webkit-transition: all 0.4s ease-in-out;
        -moz-transition: all 0.4s ease-in-out;
        -o-transition: all 0.4s ease-in-out;
        transition: all 0.4s ease-in-out;
    }

    .la_category_list_holder.active {
        top: 30px;
        opacity: 1;
        visibility: visible;
    }

    .la_category_list_holder label {
        display: block;
    }

    .la_category_list_holder.active::before {
        content: "";
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 15px;
        border-color: transparent transparent #fff transparent;
        top: -25px;
        right: 40px;
    }
		.alert-info-no_contracts {
			display: none;
		}
</style>

<?php
//project query
$args = array(
	'post_type'      => 'bid',
	'author'         => $current_user->ID,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_count'     => - 1,
	'posts_per_page' => - 1,
	'max_num_pages'  => 50000000
);

$contract_status = isset( $_GET['contact_status'] ) ? $_GET['contact_status'] : [];
if ( isset( $_GET['contact_status'] ) && is_array( $_GET['contact_status'] ) ) {
	// admin-review
	if ( in_array( 'accept', $contract_status ) ) {
		array_push( $contract_status, 'admin-review' );
	}
	$args['post_status'] = $contract_status;
}
if ( isset( $_GET['orderby'] ) && 'deadline' == $_GET['orderby'] ) {
	$args['order'] = 'ASC';
}
if ( isset( $_GET['project_id'] ) && ! empty( $_GET['project_id'] ) ) {
	$args['post_parent'] = $_GET['project_id'];
}

$author_app_query = new WP_Query( $args );
?>


<div class="entry-content landing-entry-content">

	<?php get_template_part( 'dashboard-side-nav-projects' ); ?>

    <div class="main-dashboard-content dashboard-landing inner-dashboard">
			<?php
			if (isset($_GET['withdrawn'])):
				global $current_user;
		    if (is_user_logged_in() && $current_user->ID == get_post_field('post_author', $_GET['withdrawn']))  {
		      $bid_status = get_post_status( $_GET['withdrawn'] );
					if ($bid_status == 'pending-acceptance' || $bid_status == 'publish') {
						wp_update_post(array(
			        'ID'    =>  $_GET['withdrawn'],
			        'post_status'   =>  'withdrawn'
		        ));
						echo '<div class="withdrawn_msg">Your contract #' . $_GET['withdrawn'] . ' marked as withdrawn!</div>';
					}
		    }
			endif; ?>
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
                                                            padding: 0px 10px;
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

                                                        .fre-all-contracts-table tr.no_border td {
                                                            border-bottom: none;
                                                        }

                                                        .fre-all-contracts-table tr:last-child td {
                                                            border: 0;
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
															$deadlineOrderLink = get_site_url() . '/my-applications';
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
															if ($bid_status != 'withdrawn') {
																include dirname( __FILE__ ) . '/template/loop-application-item-table.php';
															}
														}
														//}
														?>


                                                    </table>
                                                </div>

                                            </div>
                                        </div>
									<?php } ?>
																<div filter="all" class="text-center alert alert-info alert-info-no_contracts">You currently have no contracts to show.</div>
																<div filter="accept" class="text-center alert alert-info alert-info-no_contracts">You currently have no active contracts to show.</div>
																<div filter="publish" class="text-center alert alert-info alert-info-no_contracts">You currently have no pending contracts to show.</div>
																<div filter="pending-completion" class="text-center alert alert-info alert-info-no_contracts">You currently have no completed contracts to show.</div>
																<div filter="deleted" class="text-center alert alert-info alert-info-no_contracts">You currently have no declined contracts to show.</div>
																<div filter="cancelled" class="text-center alert alert-info alert-info-no_contracts">You currently have no cancelled contracts to show.</div>
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
    jQuery(".project-sub-nav li:nth-child(1)").addClass("active");
    jQuery(".nav-tabs-my-work li:nth-child(1)").addClass("active");
</script>
