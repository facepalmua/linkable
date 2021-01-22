<?php
/**
 * Template Name: My Project
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
<div class="inquire_overlay"></div>
    <style>
        .dashboard-sidebar > ul > li.la_nav_app_project a {
            color: white;
            font-weight: bold;
        }
        .dashboard-sidebar > ul > li.la_nav_app_project a i {
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
        .projects_msg {
          display: block;
          font-size: 15px;
          color: #31708f;
          background-color: #d9edf7;
          border-color: #bce8f1;
          padding: 15px;
          margin-bottom: 20px;
          border: 1px solid transparent;
          border-radius: 4px;
          text-align: center;
        }
        div#gform_wrapper_14 {
          top: -30px;
          left: 50%;
          width: 438px;
          height: auto;
          transform: translate(-50%, -100%);
          box-shadow: 0px 3px 11px 0px #00000087;
        }
        div#gform_wrapper_14:after {
          content: '';
          width: 30px;
          height: 30px;
          position: absolute;
          bottom: -14px;
          z-index: -1;
          left: calc(50% - 15px);
          background: white;
          transform: rotate(45deg);
          /* box-shadow: 0px 16px 11px 0px #00000087; */
        }
        p.click-to-copy-wrapper.green.bold {
          width: fit-content;
          margin-left: 0px;
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
        .delete-explanation {
          font-weight: 400;
        }
    </style>

    <div class="entry-content landing-entry-content">
        <?php get_template_part( 'dashboard-side-nav-projects' ); ?>
        <div class="main-dashboard-content dashboard-landing inner-dashboard">
            <h1 class="entry-title">My Projects</h1>
            <p class="optional-text my-projects">
              <?php
              echo get_field( 'intro_text_copy' );
              echo '</p>';
              ?>
            </p>
            <div class="fre-page-section ie-my-project-wrap">
                <div class="container">
                    <div class="my-work-employer-wrap">
                        <div class="fre-tab-content">
                            <div id="current-project-tab" class="employer-current-project-tab fre-panel-tab active">
                                <div class="fre-work-project-box">
                                    <div class="current-employer-project">
                                        <div class="fre-table">
                                            <h2>My Projects</h2>
                                            <p class="optional-text my-projects">
                                                <?php if ( $user_role == 'employer' ) {
                                                    echo get_field( 'intro_text_projects_owner', 12 );
                                                } else if ( $user_role == 'freelancer' ) {
                                                    echo get_field( 'intro_text_copy' );
                                                }
                                                ?>
                                            </p>
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
                                            //var_dump();
                                            $employer_current_project_query_deleted = new WP_Query(
                                                array(
                                                    'posts_per_page'   => - 1,
                                                    'is_author'        => true,
                                                    'post_type'        => PROJECT,
                                                    'author'           => $user_ID,
                                                    'suppress_filters' => true,
                                                    'orderby'          => 'date',
                                                    'order'            => 'DESC',
                                                    'post_status'      => 'deleted',
                                                    // 'paged'            => $paged
                                                )
                                            );
                                            ?>
                                            <div class="employer-project-nav new_my_projects_page">
  		                                        <ul class="fre-tabs">
  		                                        	<li class="active_nav"><a href="#active">Published/Active (<?= count($employer_current_project_query->posts) ?>)</a></li>
  		                                        	<li><a href="#inactive">Unpublished/Inactive (<?= count($employer_current_project_query_deleted->posts) ?>)</a></li>
  		                                        </ul>
  	                                        </div>
                                            <?php

                                            //var_dump($employer_current_project_query->posts);
                                            $post_object       = $ae_post_factory->get( PROJECT );
                                            if (count($employer_current_project_query->posts) == 0) {
                                              ?>
                                              <div id="project_active" class="projects_msg">
                                                You do not have any published/active projects yet. <a href="/post-a-project/">Get started by posting a new project <i class="fa fa-chevron-circle-right"></i></a>
                                              </div>
                                              <?php
                                            }
                                            if (count($employer_current_project_query_deleted->posts) == 0) {
                                              ?>
                                              <div id="project_deleted" class="projects_msg">
                                                You do not have any unpublished/inactive projects.
                                              </div>
                                              <?php
                                            }
                                            while ( $employer_current_project_query->have_posts() ) {
                                              $employer_current_project_query->the_post();
                                              $convert        = $post_object->convert( $post, 'thumbnail' );
                                              $postdata[]     = $convert;
                                              $project_status = $convert->post_status;
                                              $count ++;
                                              $total_posts = $num;
                                              $bid_query = new WP_Query( array(
                                                      'post_type'      => 'bid',
                                                      'post_parent'    => get_the_ID(),
                                                      'posts_per_page' => - 1
                                                  )
                                              );
                                              $bid_posts     = $bid_query->posts;
                                              $parent_status = get_post_status( get_the_ID() );
                                              if ( ( $parent_status !== 'complete' ) ) {
                                                  if ( empty( $bid_posts ) ) {
                                                      $no_app ++;
                                                      $status_class = 'no-app';
                                                  } else {
                                                      $with_app ++;
                                                      $status_class = 'active-app';
                                                      foreach ( $bid_posts as $bid ) {
                                                          if ( ( $bid->post_status ) == 'accept' ) {
                                                              $status_class = 'accepted-app';
                                                              $with_accepted_app ++;
                                                              break;
                                                          } else {
                                                              $status_class = 'active-app';
                                                              $with_pending_app ++;
                                                          }
                                                      }
                                                  }
                                              }
                                              ?>

                                            <div id="project_active" class="fre-table-row <?php echo $status_class; ?>">
                                                <div class="fre-table-row-inner">
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
                                                                $terms = get_the_terms( $convert->post_parent, 'project_category' );
                                                                foreach ( $terms as $term ) {
                                                                    echo $term->name;
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="project-description line-break"
                                                         style="border-bottom: none">
                                                        <div class="project-header">PROJECT
                                                            DESCRIPTION:
                                                        </div>
                                                        <p><?php echo get_post_field( 'post_content', $convert->post_parent ); ?></p>
                                                    </div>
                                                    <div class="project-description no-underline line-break">
                                                        <div class="project-header">DETAILS &
                                                            REQUIREMENTS:
                                                        </div>
                                                        <p><?php
                                                            if ( get_post_field( 'linkable_ideas', $convert->post_parent ) ) {
                                                                echo get_post_field( 'linkable_ideas', $convert->post_parent );
                                                            } else {
                                                                echo 'None';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <div class="project-description no-underline attribute">
                                                        <div class="project-header">Link Attribute</div>
                                                        <p><?php $terms = get_the_terms( $convert->ID, 'project-follow-type' );
                                                            $follow_type = [];
                                                            $no_pref     = array(
                                                                'NoFollow',
                                                                'DoFollow'
                                                            );
                                                            foreach ( $terms as $term ) {
                                                                array_push( $follow_type, $term->name );
                                                            }
                                                            if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                                                                echo "NoFollow or DoFollow";
                                                            } else {
                                                                echo $follow_type[0];
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                        $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
                                                        echo la_build_backlinks_to_markup($preferred_pages);
                                                    ?>
                                                </div>
                                                <div class="project-footer-bar <?= $parent_status; ?>">
                                                  <div class="project-status-bar">
                                                    <?php
                                                    if ( $parent_status == 'complete' ) {
                                                        echo '<strong>Project Status:</strong> <i>This project was unpublished</i>';
                                                    } else if ( $parent_status == 'deleted' ) {
                                                        echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                    } else if ( $parent_status == 'cancelled' ) {
                                                        echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                    } else if ( $parent_status == 'deleted-accepted-app' ) {
                                                        echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                    } else if ( $status_class == 'no-app' ) {
                                                        echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                    } else if ( $status_class == 'active-app' ) {
                                                        echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                    } else if ( $status_class == 'accepted-app' ) {
                                                        echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                    }
                                                    if ( get_post_status() !== 'deleted' && get_post_status() !== 'cancelled' ) { ?>
                                                        <i style="position:relative;" class="fa fa-times owner-deletion">
                                                            Unpublish
                                                            <?php echo do_shortcode( '[gravityform id=14 title=false description=false]' ); ?>
                                                        </i>
                                                    <?php } ?>
                                                    <span class="hidden-id"><?php echo $convert->ID; ?></span>
                                                    <div class="delete-dropdown edit-ellipses-popup">
                                                        <a class="owner-delete-project">Delete Project</a>
                                                    </div>
                                                    <?php //echo do_shortcode( '[gravityform id=14 title=false description=false]' ); ?>
                                                  </div>

                                                  <!-- <a class="workspace-button"
                                                     href="<?php echo get_permalink( $convert->ID ) ?>">
                                                      Go to workroom <i class="fas fa-sign-out-alt"></i>
                                                  </a> -->
                                              </div>
                                            </div>

                                        <?php
                                        }
                                        while ( $employer_current_project_query_deleted->have_posts() ) {
                                          $employer_current_project_query_deleted->the_post();
                                          $convert        = $post_object->convert( $post, 'thumbnail' );
                                          $postdata[]     = $convert;
                                          $project_status = $convert->post_status;
                                          $count ++;
                                          $total_posts = $num;
                                          $bid_query = new WP_Query( array(
                                                  'post_type'      => 'bid',
                                                  'post_parent'    => get_the_ID(),
                                                  'posts_per_page' => - 1
                                              )
                                          );
                                          $bid_posts     = $bid_query->posts;
                                          $parent_status = get_post_status( get_the_ID() );
                                          if ( ( $parent_status !== 'complete' ) ) {
                                              if ( empty( $bid_posts ) ) {
                                                  $no_app ++;
                                                  $status_class = 'no-app';
                                              } else {
                                                  $with_app ++;
                                                  $status_class = 'active-app';
                                                  foreach ( $bid_posts as $bid ) {
                                                      if ( ( $bid->post_status ) == 'accept' ) {
                                                          $status_class = 'accepted-app';
                                                          $with_accepted_app ++;
                                                          break;
                                                      } else {
                                                          $status_class = 'active-app';
                                                          $with_pending_app ++;
                                                      }
                                                  }
                                              }
                                          }
                                          ?>

                                        <div id="project_deleted" class="fre-table-row <?php echo $status_class; ?>">
                                            <div class="fre-table-row-inner">
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
                                                            $terms = get_the_terms( $convert->post_parent, 'project_category' );
                                                            foreach ( $terms as $term ) {
                                                                echo $term->name;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="project-description line-break"
                                                     style="border-bottom: none">
                                                    <div class="project-header">PROJECT
                                                        DESCRIPTION:
                                                    </div>
                                                    <p><?php echo get_post_field( 'post_content', $convert->post_parent ); ?></p>
                                                </div>
                                                <div class="project-description no-underline line-break">
                                                    <div class="project-header">DETAILS &
                                                        REQUIREMENTS:
                                                    </div>
                                                    <p><?php
                                                        if ( get_post_field( 'linkable_ideas', $convert->post_parent ) ) {
                                                            echo get_post_field( 'linkable_ideas', $convert->post_parent );
                                                        } else {
                                                            echo 'None';
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <div class="project-description no-underline attribute">
                                                    <div class="project-header">Link Attribute</div>
                                                    <p><?php $terms = get_the_terms( $convert->ID, 'project-follow-type' );
                                                        $follow_type = [];
                                                        $no_pref     = array(
                                                            'NoFollow',
                                                            'DoFollow'
                                                        );
                                                        foreach ( $terms as $term ) {
                                                            array_push( $follow_type, $term->name );
                                                        }
                                                        if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                                                            echo "NoFollow or DoFollow";
                                                        } else {
                                                            echo $follow_type[0];
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                                <?php
                                                    $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
                                                    echo la_build_backlinks_to_markup($preferred_pages);
                                                ?>
                                            </div>
                                            <div class="project-footer-bar <?= $parent_status; ?>">
                                              <div class="project-status-bar">
                                                <?php
                                                if ( $parent_status == 'complete' ) {
                                                    echo '<strong>Project Status:</strong> <i>This project was unpublished</i>';
                                                } else if ( $parent_status == 'deleted' ) {
                                                    echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                } else if ( $parent_status == 'cancelled' ) {
                                                    echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                } else if ( $parent_status == 'deleted-accepted-app' ) {
                                                    echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                } else if ( $status_class == 'no-app' ) {
                                                    echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                } else if ( $status_class == 'active-app' ) {
                                                    echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                } else if ( $status_class == 'accepted-app' ) {
                                                    echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                }
                                                if ( get_post_status() !== 'deleted' && get_post_status() !== 'cancelled' ) { ?>
                                                    <i class="fa fa-times owner-deletion">
                                                        Unpublish
                                                    </i>
                                                <?php } ?>
                                                <span class="hidden-id"><?php echo $convert->ID; ?></span>
                                                <div class="delete-dropdown edit-ellipses-popup">
                                                    <a class="owner-delete-project">Delete Project</a>
                                                </div>
                                                <?php

                                                echo do_shortcode( '[gravityform id=14 title=false description=false]' ); ?>
                                              </div>

                                              <!-- <a class="workspace-button"
                                                 href="<?php echo get_permalink( $convert->ID ) ?>">
                                                  Go to workroom <i class="fas fa-sign-out-alt"></i>
                                              </a> -->
                                          </div>
                                        </div>

                                    <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
