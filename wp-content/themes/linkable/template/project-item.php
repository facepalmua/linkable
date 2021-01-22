<?php

global $wp_query, $ae_post_factory, $post;
$post_object = $ae_post_factory->get( PROJECT );
$current     = $post_object->current_post;
$tax_input   = $current->tax_input;
?>

<li class="project-item">
    <div class="project-list-wrap fre-table-row">
        <div class="project-details-head">
            <h3 class="my-proj-title">
                <?php echo get_the_title(); ?>
                <?php if ( get_field( 'publicly_display_url', $parent_project ) == 1 ) { ?>
                    <br>
                    <div class="green" style="display: inline-block; ">
                        <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $parent_project ); ?></span>
                    </div>
                <?php } ?>
            </h3>
            <div class="header-category text-right gray_858585">
                <span class="project-header gray_858585" style="display:block;">Category</span>
                <span class="project-cats">
                    <?php
                    $terms = get_the_terms( $post->ID, 'project_category' );
                    foreach ( $terms as $term ) {
                        echo $term->name;
                    }
                    ?>
                </span>
            </div>
        </div>


        <div class="project-description project-description-first">
            <div class="project-header">Project Description:</div>
            <?php
            $content = get_the_content();
            echo '<span>' . wp_strip_all_tags( $content ) . '</span>';
            ?>
        </div>

        <div class="project-description">
            <div class="project-header">DETAILS &amp; REQUIREMENTS:</div>
            <?php
            if ( get_field( 'linkable_ideas', $parent_project ) ) {
                echo wpautop(get_field( 'linkable_ideas', $parent_project ) );
            } else {
                echo 'The Content Marketer has no additional info about their page.';
            }
            ?>
        </div>

        <div class="project-description">
            <div class="project-header">Wants a backlink on:</div>
            <?php
            if ( get_field( 'desired_domains_for_backlinks', $parent_project ) ) {
                echo get_field( 'desired_domains_for_backlinks', $parent_project );
            } else {
                echo 'No preference.';
            }
            ?>
        </div>

        <div class="project-description">
            <div class="project-header">DESIRED LINK ATTRIBUTE:</div>
            <span class="italic">
                <?php
                $follow_type = [];
                $no_pref     = array( 'NoFollow', 'DoFollow' );
                $terms       = get_the_terms( $post->ID, 'project-follow-type' );
                foreach ( $terms as $term ) {
                    array_push( $follow_type, $term->name );
                }
                if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                    echo "NoFollow or DoFollow";
                } else {
                    echo $follow_type[0];
                }
                ?>
		     </span>
        </div>

        <?php
            $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
            echo la_build_backlinks_to_markup($preferred_pages);
        ?>

        <!--        <div class="project-top-bar">-->
        <!--            <div class="left-container">-->
        <!---->
        <!---->
        <!--				--><?php
        //				//posted x hours ago
        //				?>
        <!--                <div class="col-section">-->
        <!--					--><?php
        //					echo ' <span class="project-header">Posted</span><span class="bold">' . human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago';
        //
        //					echo '</span></div>';
        //
        //					echo '</div>';
        //
        //					$digits     = 6;
        //					$random_num = rand( pow( 10, $digits - 1 ), pow( 10, $digits ) - 1 );
        //
        //					?>
        <!--                </div>-->
        <!--                <a class="mobile button green-bg"-->
        <!--                   href="--><?php //echo get_home_url(); ?><!--/apply-to-project/?title_field=--><?php //echo urlencode( get_the_title( get_the_ID() ) ) . '-' . $random_num; ?><!--&parent_id=--><?php //echo get_the_ID(); ?><!--">Apply-->
        <!--                    Now</a>-->
        <!---->
        <!--                <div class="project-list-bookmark">-->
        <!--                    <a class="fre-bookmark" href="">Bookmark</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <?php
        $digits     = 6;
        $random_num = rand( pow( 10, $digits - 1 ), pow( 10, $digits ) - 1 );
        ?>
        <div class="project-footer-bar">
            <div class="button-container">
                <span><?php esc_html_e( 'Can you build any backlinks to this website?', 'linkable' ); ?></span>
                <?php
                if (is_messages_exists($current->ID)) {
                  ?>
                  <a class="desktop tablet button purple-bg inquire-button messaged">Client messaged <i class="fa fa-check-circle" aria-hidden="true"></i></a>
                  <?php
                } else {
                  ?>
                  <a class="desktop tablet button purple-bg inquire-button">Connect with client <i class="fas fa-paper-plane"></i></a>
                  <?php
                  echo do_shortcode( '[gravityform id=18 title=false description=false ajax=true tabindex=49 field_values="inquiry-proj-id=' . get_the_ID() . '"]' );
                }
                ?>
                <?php
                /*
				<a class="button green-bg"
                   href="<?php echo get_home_url(); ?>/apply-to-project/?title_field=<?php echo urlencode( get_the_title( get_the_ID() ) ) . '-' . $random_num; ?>&parent_id=<?php echo get_the_ID(); ?>">Apply
                    Now<i class="fas fa-sign-out-alt"></i></a>
				*/ ?>
            </div>
        </div>
</li>
