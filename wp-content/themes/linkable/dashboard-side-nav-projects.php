<?php
$add_html = '';
$add_author_contracts_class = '';
if (is_there_new_contracts()) {
	$add_html = '<span class="new_nav">NEW!</span>';
	$add_author_contracts_class = 'new_msg';
}
$add_messages_class = '';
if (is_there_new_messages($return_bool = true)) {
	$add_messages_class = 'new_msg';
}
?>

<style>
.new_nav {
	padding: 4px 6px;
	width: 36px;
	height: 20px;
	display: inline-block;
	margin: 0px 12px;
	font-size: 10px;
	font-weight: bold;
	border-radius: 4px;
	background: #ff0000;
	color: white;
}
</style>


<div class="dashboard-sidebar static">

    <ul>
        <?php if(ae_user_role() == FREELANCER) {
            echo '<li class="la_nav_projects"><a href="' . get_home_url() . '/projects/"><i class="fa fa-search"></i><span>Find Work</span></a></li>';
	        echo '<li class="la_author_link_build"><a href="' . get_home_url() . '/links-you-can-build/"><i class="fa fa-chain"></i><span>Links You Can Build</span></a></li>';
        } else { ?>
            <?php
            if ( ! is_user_logged_in() ) {
                $current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
            }
            ?>

            <li class="la_nav_post_project"><a href="<?php echo get_home_url(); ?>/post-a-project/"><i class="fa fa-bullhorn"></i><span>Post a Project</span></a></li>

        <?php } ?>
        <?php if(ae_user_role() == FREELANCER) { ?>
          <li class="la_nav_app_project">
                <a href="<?php echo get_home_url(); ?><?php if(ae_user_role() == FREELANCER) {?>/my-contracts/" <?php } else { ?>/my-projects/" <?php } ?>">
                    <i class="fa <?php if(ae_user_role() == FREELANCER) {echo 'fa-suitcase'; } else {echo 'fa-folder-open'; }?>"></i>
                    <span><?php if(ae_user_role() == FREELANCER) {echo 'My Jobs/Contracts'; } else {echo 'My Projects'; }?></span>
                </a>
            </li>
          <!-- <ul class="project-sub-nav">
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/"><span><?php if(ae_user_role() == FREELANCER) {echo 'All Contracts'; } else {echo 'All Projects'; }?></span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/active/"><span>Active</span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/pending/"><span>Pending Acceptance</span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/complete/" aria-expanded="false"><span>Completed</span></a></li>
              <?php if (ae_user_role() == FREELANCER) : ?>
                  <li><a href="<?php echo get_home_url(); ?>/my-contracts/declined/" aria-expanded="false"><span>Declined</span></a></li>
                  <li><a href="<?php echo get_home_url(); ?>/my-contracts/cancelled/" aria-expanded="false"><span>Cancelled</span></a></li>
              <?php else : ?>
                  <li><a href="<?php echo get_home_url(); ?>/my-contracts/declined/" aria-expanded="false"><span>Declined/Cancelled</span></a></li>
              <?php endif; ?>
          </ul> -->
        <?php } else { ?>
            <li class="la_nav_app_project">
                <a href="<?php echo get_home_url(); ?>/my-projects/">
                    <i class="fa fa-folder-open"></i>
                    <span>My Projects</span>
                </a>
            </li>
        <?php } ?>
	    <?php if( ae_user_role() == EMPLOYER ) { ?>
            <li class="la_author_contracts <?= $add_author_contracts_class ?>"><a href="<?= get_home_url() ?>/author-contracts/"><i class="fas fa-suitcase"></i><span>Author Contracts</span><?= $add_html ?></a></li>
            <li class="la_client_rec_links"><a href="<?= get_home_url() ?>/recommended-links/"><i class="fa fa-chain"></i><span>Recommended Links</span></a></li>
	    <?php } ?>
        <li class="la_nav_messages <?= $add_messages_class ?>"><a href="<?= get_site_url(); ?>/messages"><i class="fa fa-commenting"></i><span>Messages<?= is_there_new_messages() ?></span></a></li>
        <li class="la_nav_payments"><a href="<?php echo get_home_url(); ?>/my-payments"><i class="fa <?php if(ae_user_role() == FREELANCER) {echo 'fa-dollar-sign'; } else {echo 'fa-file-text'; }?>"></i><span><?php if(ae_user_role() == FREELANCER) { echo 'Earnings';} else {echo 'Payments & Invoices';}?></span></a></li>
        <li class="la_nav_profiles"><a href="<?php echo get_home_url(); ?>/profile/"><i class="fa fa-cog"></i><span><?php if(ae_user_role() == FREELANCER) {echo 'Profile & Settings'; } else {echo 'Settings'; }?></span></a></li>
        <li class="la_nav_help_support"><a href="<?php echo get_home_url(); ?>/help-and-support/"><i class="fa fa-info-circle"></i><span>Help & Support</span></a></li>
    </ul>

</div>

<div class="dashboard-sidebar slide-in">
    <ul>
        <?php if(ae_user_role() == FREELANCER) { ?>
            <li><a href="<?php echo get_home_url(); ?>/projects/">Project Marketplace</a></li>
            <li><a href="<?= get_home_url() ?>/links-you-can-build/">Links you can build</a></li>
        <?php } else { ?>

            <li><a href="<?php echo get_home_url(); ?>/post-a-project/">Post a New Project</a></li>

        <?php } ?>
        <?php if(ae_user_role() == FREELANCER) { ?>
          <li><a href="<?php echo get_home_url(); ?><?php if(ae_user_role() == FREELANCER) {?>/my-contracts/" <?php } else { ?>/my-projects/" <?php } ?>"><?php if(ae_user_role() == FREELANCER) {echo 'My Contracts'; } else {echo 'My Projects'; }?></a></li>
          <ul class="project-sub-nav">
              <li class="active"><a href="<?php echo get_home_url(); ?>/my-contracts/"><span><?php if(ae_user_role() == FREELANCER) {echo 'All Contracts'; } else {echo 'All Projects'; }?></span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/active/"><span>Active Projects</span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/pending/"><span>Pending Projects</span></a></li>
              <li><a href="<?php echo get_home_url(); ?>/my-contracts/complete/" aria-expanded="false"><span>Past Completed Projects</span></a></li>
          </ul>
        <?php } else { ?>
          <li><a href="<?php echo get_home_url(); ?>/my-projects/">My Projects</a></li>
        <?php } ?>
	    <?php if( ae_user_role() == EMPLOYER ) { ?>
        <li class="la_author_contracts <?= $add_author_contracts_class ?>"><a href="<?= get_home_url() ?>/author-contracts/"><i class="fas fa-suitcase"></i><span>Author contracts</span></a></li>
        <li><a href="<?= get_home_url() ?>/recommended-links/">Recommended links</a></li>
	    <?php } ?>
        <li><a href="<?= get_site_url(); ?>/messages" class="<?= $add_messages_class ?>"><i class="fa fa-commenting"></i><span>Messages<?= is_there_new_messages() ?></span></a></li>
        <li><a href="<?php echo get_home_url(); ?>/my-payments"><?php if(ae_user_role() == FREELANCER) { echo 'Earnings';} else {echo 'Payments';}?></a></li>
        <li><a href="<?php echo get_home_url(); ?>/profile/">Settings</a></li>
        <li><a href="<?php echo get_home_url(); ?>/help-and-support/">Help and Support</a></li>
    </ul>

</div>
