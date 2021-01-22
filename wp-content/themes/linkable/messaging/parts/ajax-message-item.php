<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );

$project_title = isset( $project ) ? $project->post_title : '';
$project_url = isset( $project ) ? get_permalink( $project->ID ) : '#';
$author = get_userdata( $author_id );
?>
    <div class="la_message_title">
        <div class="text-right">
            <p id="la_project_title" class="strong" style="display: none;"><?= $project_title ?>!</p>
            <p class="ie_la">
                <?php if( EMPLOYER == ae_user_role() ) { ?>
                    <!-- <a class="la_project_workroom" href="<?= esc_url( $project_url ); ?>" target="_blank"><?php esc_html_e('Project workroom') ?> <i class="fa fa-sign-out"></i></a> -->
                    <div class="project_title"><?= $project->post_title ?></div>
                    <div class="project_conversation">
                      Conversation with <?= get_short_username( $author ); ?>
                    </div>
                <?php } else {
                    $digits = 6;
                    $random_num = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    ?>
                    <span><?php esc_html_e( 'Finished discussing the pricing and details with the client?', 'link-able' ); ?></span>
                    <a class="la_msg_send_contact" href="<?= get_site_url(); ?>/apply-to-project/?title_field=<?php echo urlencode($project->post_title) . '-' . $random_num; ?>&parent_id=<?= $project->ID ?>" target="_blank"><?php esc_html_e( 'Send contract', 'link-able' ); ?> <i class="fas fa-location-arrow"></i></a>
                <?php } ?>
            </p>
        </div>
    </div>
    <div class="la_messages_container" id="la_project_<?= $project->ID; ?>_<?= $author_id; ?>">
        <?php
        $messages = isset( $messages ) ? $messages : [];
        foreach ( $messages as $message ) {
            include dirname( __FILE__ ) . '/ajax-single-message-item.php';
        }
        ?>
    </div>
<?php include_once dirname( __FILE__ ) . '/modals/author-profile.php'; ?>
<?php include_once dirname( __FILE__ ) . '/modals/project-details.php'; ?>
