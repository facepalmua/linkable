<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

$user_role = ae_user_role( $user_ID );

if ( ( ! is_user_logged_in() ) || ( $user_role == 'employer' ) ) {
	$current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}


add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';

	return $classes;
}

global $wp_query, $ae_post_factory, $post, $user_ID;
$paged      = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$query_args = array(
	'post_type'     => PROJECT,
	'post_status'   => 'publish',
	'paged'         => $paged,
	'max_num_pages' => 9999999
);
$loop       = new WP_Query( $query_args );
get_header();

?>

    <style>
        .dashboard-sidebar > ul > li:nth-child(1) a {
            color: white;
            font-weight: bold;
        }

        .dashboard-sidebar > ul > li:nth-child(1) a i {
            color: #1aad4b;
        }

        .facetwp-template > p:first-child {
            display: none;
        }
				.inquire_overlay {
					position: fixed;
					width: 100vw;
					height: 100vh;
					left: 0px;
					top: 0px;
					right: 0px;
					background: black;
					opacity: .4;
					z-index: 1038;
					display: none;
				}
				div#gform_wrapper_18 {
					z-index: 1039;
				}
				.project-filters {
			    position: relative;
				}
				.project-filters .facetwp-input-wrap {
					width: 100%;
				}
				.page-project-list-wrap .facetwp-dropdown {
			    min-width: 150px;
				}
				.hwt-container .ginput_counter {
					display: none !important;
				}
				@media only screen and (min-width: 999px) {
					a.clear-search {
				    position: absolute;
				    bottom: -20px;
				    right: 0px;
				    height: auto;
				    top: auto;
					}
				}
				.project-footer-bar a.desktop.tablet.button.purple-bg.inquire-button.messaged {
				    background: #505050;
				    cursor: default;
						color: #BDBDBD;
				}
    </style>

    <script>

        (function ($) {
            $(document).on('facetwp-loaded', function () {
                var url = window.location.href;
                var field = 'fwp_search_by_keyword';
                var field2 = 'fwp_search_for_a_domain';
                var field3 = 'fwp_follow_type';
                var field4 = 'fwp_categories';
                var searchPerformed = false;
                if ((url.indexOf('?' + field + '=') != -1) || (url.indexOf('?' + field2 + '=') != -1) || (url.indexOf('?' + field3 + '=') != -1) || (url.indexOf('?' + field4 + '=') != -1)) {
                    var searchPerformed = true;
                }

                if (searchPerformed == true) {
                    if ($('.facetwp-template .project-item').length == 0) {

                        $(".filter-text").text('Sorry, there were no projects found. Try changing your keyword or searching by category.');
                    } else {

                        $(".filter-text").text('Showing results from your search...');
                    }
                } else {
                    $(".filter-text").text('Showing our most recently posted projects from clients...');
                }
            });
        })(jQuery);


    </script>
		<div class="inquire_overlay"></div>
    <div class="entry-content landing-entry-content">

		<?php get_template_part( 'dashboard-side-nav' ); ?>
        <div class="main-dashboard-content dashboard-landing inner-dashboard">
            <div class="fre-page-wrapper">
                <div class="fre-page-section section-archive-project">
                    <div class="container">
                        <div class="page-project-list-wrap">
                            <div class="fre-project-list-wrap">
                                <div class="marketplace-header">
                                    <h2><?php _e( 'Project Marketplace', ET_DOMAIN ); ?></h2>
                                    <p><?php the_field( 'project_marketplace_text', 'option' ); ?></p>

                                    <div class="search-contain">
                                        <h3>Search for something you can link to...</h3>

										<?php //get_template_part( 'template/filter', 'projects' ); ?>
                                        <div class="project-filters">
											<?php //add_filter( 'relevanssi_index_content', '__return_false' );
											//https://facetwp.com/documentation/developers/querying/facetwp_facet_filter_posts/

											/*add_filter( 'facetwp_query_args', function( $query_args, $class ) {
												if ( 'search_for_a_domain' == $params['facet']['name'] ) {
												   $query_args['meta_query'] = array(
															array(
																'key' => 'desired_domains_for_backlinks'
															)
														);
												}
												return $query_args;
											}, 10, 2 );*/
											?>
											<?php //echo do_shortcode('[searchandfilter post_types="project" types=",select,select" taxonomies="search,project_category,project-follow-type"]'); ?>
											<?php // do_shortcode( '[searchandfilter fields="project_category,project-follow-type" type="select,select"]' ); ?>
											<?php echo do_shortcode( '[facetwp facet="search_by_keyword"]' ); ?>
                                            <div class="search-tooltips mobile keyword">
                                                <div class="keyword"><?php echo get_field( 'search_by_keyword_tooltip', 'option' ); ?></div>
                                            </div>
											<?php echo do_shortcode( '[facetwp facet="search_for_a_domain"]' ); ?>
                                            <div class="search-tooltips mobile domain">
                                                <div class="domain "><?php echo get_field( 'search_for_a_domain_tooltip', 'option' ); ?></div>
                                            </div>
											<?php echo do_shortcode( '[facetwp facet="follow_type"]' ); ?>
                                            <div class="search-tooltips mobile follow">
                                                <div class="follow "><?php echo get_field( 'search_', 'option' ); ?></div>
                                            </div>
											<?php echo do_shortcode( '[facetwp facet="categories"]' ); ?>
                                            <div class="search-tooltips mobile categories">
                                                <div class="category"><?php echo get_field( 'search_by_', 'option' ); ?></div>
                                            </div>
                                            <div class="button-contain">
                                                <button onclick="FWP.refresh()"><i class="fas fa-search"></i></button>
                                            </div>
                                            <a href class="clear-search" onclick="FWP.reset()">Clear search</a>

                                        </div>


                                        <div class="search-tooltips desktop">
                                            <div class="keyword"><?php echo get_field( 'search_by_keyword_tooltip', 'option' ); ?></div>
                                            <div class="domain "><?php echo get_field( 'search_for_a_domain_tooltip', 'option' ); ?></div>
                                            <div class="follow "><?php echo get_field( 'search_', 'option' ); ?></div>
                                            <div class="category"><?php echo get_field( 'search_by_', 'option' ); ?></div>
                                        </div>

                                        <p class="pro-tip"><i class="far fa-lightbulb"></i> PRO TIP: You can also
                                            explore by category to discover new ideas you can link to.</p>

                                    </div>
                                </div>

                                <p class="italic filter-text">Showing our most recently posted projects from clients...</p>
                                <div class="fre-project-list-box">
									<?php /*
								$expiration_query = new WP_Query(
									array(
										'post_status'      => array(
											'publish'
										),
										'post_type'        => 'project'
									)
								);

								while ( $expiration_query->have_posts() ) : $expiration_query->the_post();

									$proj_id = get_the_ID();
									$publish_date = get_the_date('m/d/Y',$proj_id);
								    $date = date('m/d/Y', time());
								    //echo $date;
								    $diff = abs(strtotime($date) - strtotime($publish_date));
								    $days = round($diff / (60 * 60 * 24));


								    if($days > 30) {
									    wp_update_post(array(
											'ID' => $proj_id,
											'post_status' => 'cancelled'
										));
										echo $proj_id;
										echo $days;
								    }
								endwhile;

								wp_reset_query(); */

									?>
                                    <div class="fre-project-list-wrap">
                                        <div class="fre-project-result-sort">
                                            <div class="row">
												<?php
												$query_post  = $loop->found_posts;
												$found_posts = '<span class="found_post">' . $query_post . '</span>';
												$plural      = sprintf( __( '%s projects found', ET_DOMAIN ), $found_posts );
												$singular    = sprintf( __( '%s project found', ET_DOMAIN ), $found_posts );
												$not_found   = sprintf( __( 'There are no projects posted on this site!', ET_DOMAIN ), $found_posts );
												?>
                                            </div>
                                        </div>
										<?php get_template_part( 'list', 'projects' ); ?>
                                    </div>
                                </div>
								<?php
								$loop->query = array_merge( $loop->query, array( 'is_archive_project' => is_post_type_archive( PROJECT ) ) );
								//echo '<div class="fre-paginations paginations-wrapper">';
								//ae_pagination( $loop, get_query_var( 'paged' ) );
								//echo '</div>';  ?>
                                <nav class="nav-pagination">

									<?php
									//global $loop;

									$big = 999999999; // need an unlikely integer

									//print_r($loop);
									/*
									echo paginate_links( array(
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max( 1, get_query_var('paged') ),
										'total' => $wp_query->max_num_pages
									) );*/

									?>
                                </nav>
								<?php echo do_shortcode( '[facetwp pager="true"]' ); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
