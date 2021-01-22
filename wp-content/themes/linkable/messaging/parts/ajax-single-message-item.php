<?php
if( ! defined( 'ABSPATH' ) ) die( 'No kidding!' );

$extraClass = isset( $extraClass ) ? $extraClass : '';
if( $author->ID == $message->sender_id ){
	$sender = $author;
} else {
	$sender = get_userdata( $message->sender_id );
}
$rating = get_gf_user_ratings( $sender->ID );
$msg_item = $message->message;
if (strpos($msg_item, '[@linkable_status@]') !== false) {
	$msg_item = explode(',', $msg_item);
	//var_dump($msg_item);
	if (ae_user_role() == 'employer') {
		switch ($msg_item[1]) {
			case 'contract_send':
					?>
					<div class="la_message_item_status green">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							<?php echo get_short_username( $sender ); ?> has sent over a job contract for you to accept so that they can begin their work.  <a href="<?= get_home_url() ?>/author-contracts/" target="_blank">View contract</a>
						</div>
					</div>
					<?php
					break;
			case 'bid_accepted':
					?>
					<div class="la_message_item_status green">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							You have accepted <?php echo get_short_username( $sender ); ?>’s job contract and the author can now begin their work. <a href="<?= get_home_url() ?>/author-contract-details-<?= $msg_item[2] ?>/?ac_tab=2" target="_blank">View contract</a>
						</div>
					</div>
					<?php
					break;
			case 'contract_deleted':
					?>
					<div class="la_message_item_status red">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							You have declined <?php echo get_short_username( $sender ); ?>’s job contract.
						</div>
					</div>
					<?php
					break;
		}

	} else {
		switch ($msg_item[1]) {
			case 'contract_send':
					?>
					<div class="la_message_item_status green">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							You have sent a job contract over to the client to review and accept. Do not begin any work until this contract is accepted.
						</div>
					</div>
					<?php
					break;
			case 'bid_accepted':
					?>
					<div class="la_message_item_status green">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							The client has accepted your job contract and you are ready to begin your work! <a href="<?= get_permalink($msg_item[2]) ?>" target="_blank">View job details</a>
						</div>
					</div>
					<?php
					break;
			case 'contract_deleted':
					?>
					<div class="la_message_item_status red">
						<div class="date">
							<?php
							$time = mysql2date('U', $message->send_date, false);
							$send_time = date( 'h:ia @ M d', $time );
							$send_time = str_replace( '@', 'on', $send_time);
							echo $send_time;
							?>
						</div>
						<div class="content_for_status">
							The client has declined your job contract. <a href="<?= get_permalink($msg_item[2]) ?>" target="_blank">View details</a>
						</div>
					</div>
					<?php
					break;
		}
	}

} else { ?>
	<div class="la_message_item <?= $extraClass; ?>">
		<div class="la_msg_heading">
			<div class="la_person_img">
				<?php
				if (strpos(get_avatar( $sender->ID ), 'replace_this_avatar.svg') !== false) {
					$user_firstname = get_user_meta( $sender->ID, 'first_name', true );
					$user_lastname = get_user_meta( $sender->ID, 'last_name', true );
					$colorHash = new Shahonseven\ColorHash();
					$color = $colorHash->hex($user_firstname . ' ' . $user_lastname);

					$user_firstname = substr($user_firstname, 0, 1);
					$user_lastname = substr($user_lastname, 0, 1);

				    ?>
						<div id="profile_img" style="width: 50px;">
							<div id="profile_img_wrapper">
								<div id="profile_img_circle" style="background: <?= $color ?>;">
										<?= $user_firstname ?><?= $user_lastname ?>
								</div>
							</div>
						</div>
						<?php
				} else {
						echo get_avatar( $sender->ID, 50 );
				}
				?>
			</div>
			<div class="la_person_details">
				<p class="strong"><?php echo get_short_username( $sender ); ?></p>
				<?php if( FREELANCER == ae_user_role($sender->ID) ) { ?>
					<p class="la_tagline"><?php echo get_author_tag_name( $sender ); ?></p>
					<p><?php echo generate_ratings( $rating ); ?>
						<a href="#" class="small viewAuthorProfile" data-author="<?= $sender->ID; ?>" data-toggle="modal" data-target="#la_modal_container">View author</a></p>
				<?php }
				if( EMPLOYER == ae_user_role( $sender->ID ) ) {
				    // $emp_tag = get_cm_tag_name( $sender );
				    $emp_tag = get_field( 'url_of_page_you_want_to_build_a_link_to', $project->ID );
				    $emp_url = parse_url($emp_tag);
				    ?>
					<p class="la_tagline"><?php echo $emp_url['host']; ?></p>
					<a href="#" class="la_tagline_project"  data-toggle="modal" data-target="#la_modal_container_project">View project</a>
					<?php
				}
				?>
			</div>
		</div>
		<div class="la_message_text">
			<?php
			$time = mysql2date('U', $message->send_date, false);
			$send_time = date( 'h:ia @ M d', $time );
			$send_time = str_replace( '@', 'on', $send_time);
			?>
			<p class="small strong"><?php echo $send_time; ?></p>
			<?php echo wpautop( stripslashes( $message->message ) ); ?>
		</div>
	</div>
<?php } ?>
