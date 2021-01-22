<?php //print_r(wp_count_posts('bid'));
//$total_post_count = count_user_posts($current_user->ID,'bid');

$user_id = $current_user->ID;

function custom_get_user_posts_count($user_id,$args ) {
    $args['author'] = $user_id;
    $args['posts_per_page'] = -1;
    $ps = get_posts($args);
    return count($ps);
}

$num_active = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'accept',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_pending = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'publish',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_complete = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'complete',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_pending_complete = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'pending-completion',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_cancelled = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'cancelled',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_deleted = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'deleted',
    'author' => $user_id,
    'posts_per_page' => -1
));

$num_admin_review = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'post_status'=> 'admin-review',
    'author' => $user_id,
    'posts_per_page' => -1
));

$total_post_count = custom_get_user_posts_count($user_id, array(
    'post_type' =>'bid',
    'author' => $user_id,
    'posts_per_page' => -1,
    'post_status' => array(
        'pending-completion',
        'publish',
        'accept',
        'complete',
        'cancelled',
        'deleted',
        'admin-review'
    )
));

//echo $pending_completion;
//echo $complete;
?>
<ul class="fre-tabs nav-tabs-my-work fre-tabs-js-filter">
    <li class="next">
        <a tag_filter="all" href="<?php echo get_home_url(); ?>/my-applications/"><span>All Contracts (<?php  echo $total_post_count;?>)</span></a>
    </li>
    <li class="next">
        <a tag_filter="accept" href="<?php echo get_home_url(); ?>/my-applications/active/"><span>Active (<?php  echo $num_active + $num_admin_review;?>)</span></a>
    </li>

    <li class="next">
        <a tag_filter="publish" href="<?php echo get_home_url(); ?>/my-applications/pending"><span>Pending Acceptance (<?php  echo $num_pending;?>)</span></a>
    </li>

    <li class="next">
        <a tag_filter="pending-completion" href="<?php echo get_home_url(); ?>/my-applications/complete/"><span>Completed (<?php  echo ( $num_complete + $num_pending_complete);?>)</span></a>
    </li>

    <li class="next">
        <a tag_filter="deleted" href="<?php echo get_home_url(); ?>/my-applications/declined/"><span>Declined (<?php echo (  $num_deleted);?>)</span></a>
    </li>

    <li class="next">
        <a tag_filter="cancelled" href="<?php echo get_home_url(); ?>/my-applications/cancelled/"><span>Cancelled (<?php echo (  $num_cancelled );?>)</span></a>
    </li>
</ul>

<script>
    //insert counts into side menu
    jQuery(".project-sub-nav li:first-child a").append(" (<?php echo $total_post_count;?>)");
    jQuery(".project-sub-nav li:nth-child(2) a").append(" (<?php echo $num_active; ?>)");
    jQuery(".project-sub-nav li:nth-child(3) a").append(" (<?php echo $num_pending; ?>)");
    jQuery(".project-sub-nav li:nth-child(4) a").append(" (<?php echo $num_complete + $num_pending_complete;?>)");
    jQuery(".project-sub-nav li:nth-child(5) a").append(" (<?php echo ( $num_deleted);?>)");
    jQuery(".project-sub-nav li:nth-child(6) a").append(" (<?php echo ( $num_cancelled );?>)");

    jQuery('.fre-tabs-js-filter li a').click(function(e){
      e.preventDefault();
      jQuery('.alert-info-no_contracts').hide();
      jQuery('.fre-table').show();
      jQuery('.fre-tabs-js-filter li.active').removeClass('active');
      jQuery(this).parent().addClass('active');
      var tag = jQuery(this).attr('tag_filter');
      jQuery('.fre-table-row-all.no_border').removeClass('no_border');
      var selector = '.fre-table-row-all';
      if (tag != 'all') {
        selector += '.' + tag;
      }
      jQuery('.fre-table-row-all').hide();
      jQuery(selector).show();
      jQuery(selector).last().addClass('no_border');
      if(jQuery(selector).length == 0) {
        jQuery('.fre-table').hide();
        jQuery('.alert-info-no_contracts[filter="' + tag + '"]').show();
      }
    });
    jQuery(document).ready(function(){
      if(jQuery('.fre-table-row-all').length == 0) {
        jQuery('.fre-table').hide();
        jQuery('.alert-info-no_contracts[filter="all"]').show();
      }
    });


</script>
