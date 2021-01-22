<?php


function stripe_register_user(){
  $user_id = get_current_user_id();
  $first_name = get_user_meta( $user_id, 'first_name', true );
  $last_name = get_user_meta( $user_id, 'last_name', true );
  $mode = get_field('stripe_connect_mode', 'option');
  $url = get_permalink( 11 ) . '?stripe=completed';
  $url_repeat = get_permalink( 11 ) . '?stripe=repeat';
  if ($mode == 'Test') {
    $live_key = get_field('stripe_test_key', 'option');
    $secret_key = get_field('stripe_test_key_secret', 'option');
  } else {
    $live_key = get_field('stripe_live_key', 'option');
    $secret_key = get_field('stripe_live_key_secret', 'option');
  }
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.stripe.com/v1/accounts",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "type=express&metadata[user_id]=$user_id&metadata[name]=$first_name $last_name",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $secret_key",
      "Content-Type: application/x-www-form-urlencoded",
    ),
  ));

  $response = json_decode(curl_exec($curl));
  $acc_id = $response->id;
  curl_close($curl);
  // print_r($response);
  // wp_die();
  update_user_meta( $user_id, 'user_stripe_id', $acc_id );
  // print_r($response);
  // wp_die();


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.stripe.com/v1/account_links",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "account=$acc_id&refresh_url=$url_repeat&return_url=$url&type=account_onboarding",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $secret_key",
      "Content-Type: application/x-www-form-urlencoded"
    ),
  ));

  //$response = curl_exec($curl);
  $response = json_decode(curl_exec($curl));
  curl_close($curl);
  if ($response->url) {
    // $response->url = '200' . $response->url;
    // print_r($response->url);
    $response_arr = array();
    $response_arr['code'] = 200;
    $response_arr['url'] = $response->url;
    echo(json_encode( $response_arr ));
  }
  //echo $_GET['user_id_data'];
  wp_die();
}

add_action( 'wp_ajax_stripe_register_user', 'stripe_register_user' );
add_action( 'wp_ajax_nopriv_stripe_register_user', 'stripe_register_user' );


add_shortcode( 'stripe_connect_button', 'stripe_connect_button_code' );
function stripe_connect_button_code( $atts ){
	$atts = shortcode_atts( array(
	), $atts );
  $cur_user_id = get_current_user_id();
  $mode = get_field('stripe_connect_mode', 'option');
  if ($mode == 'Test') {
    $live_key = get_field('stripe_test_key', 'option');
    $secret_key = get_field('stripe_test_key_secret', 'option');
  } else {
    $live_key = get_field('stripe_live_key', 'option');
    $secret_key = get_field('stripe_live_key_secret', 'option');
  }

  //var_dump($live_key);
  //var_dump($secret_key);
  var_dump (get_user_meta( $cur_user_id, 'user_stripe_id', true ));
	?>
  <form id="stripe_connect" class="stripe_connect_form" action="index.html" method="post">
    <input style="display:none;" type="text" name="user_id" value="<?= $cur_user_id ?>">
    <button type="submit" class="stripe-connect" name="button"><span>Connect with stripe</span></button>
  </form>
  <?php
}

function la_check_stripe($user_id) {
  $mode = get_field('stripe_connect_mode', 'option');
  if ($mode == 'Test') {
    $live_key = get_field('stripe_test_key', 'option');
    $secret_key = get_field('stripe_test_key_secret', 'option');
  } else {
    $live_key = get_field('stripe_live_key', 'option');
    $secret_key = get_field('stripe_live_key_secret', 'option');
  }
  $stripe_id = get_user_meta( $cur_user_id, 'user_stripe_id', true );
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.stripe.com/v1/accounts/$stripe_id",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer $secret_key"
    ),
  ));
  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;

}
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Payments',
		'menu_title'	=> 'Stripe Payments',
		'menu_slug' 	=> 'stripe-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

add_menu_page(
  'Stripe payments',
  'Stripe Freelancers settings',
  'administrator', __FILE__,
  'stripe_freelancers_page'
);


function stripe_freelancers_page() {
?>
<div class="wrap">
<h1>Payments</h1>

<!-- <form method="post" action="options.php">
    <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">New Option Name</th>
        <td><input type="text" name="new_option_name" value="<?php echo esc_attr( get_option('new_option_name') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Some Other Option</th>
        <td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('some_other_option') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Options, Etc.</th>
        <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form> -->

<?php if (!$_GET['project_id']): ?>
  <?php if (!$_GET['freelancer_id']) { ?>
    <table class="wp-list-table widefat fixed striped table-view-list pages">
      <thead>
      <tr>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
          <a href=""><span>Freelancer name</span><span class="sorting-indicator"></span></a>
        </th>
        <th scope="col" id="author" class="manage-column column-author">Stripe connected?</th>
      </tr>
      </thead>

      <tbody id="the-list">
        <?php
        $users = get_users( [
          'role'         => 'freelancer',
          'number'       => 9999999,
        ] );
        foreach ($users as $user) {
          $stripe_id = get_user_meta( $user->ID, 'user_stripe_id', true );
          $first_name = get_user_meta( $user->ID, 'first_name', true );
          $last_name = get_user_meta( $user->ID, 'last_name', true );
          ?>
          <tr id="post-1956" class="iedit author-other level-0 post-1956 type-page status-publish hentry">
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
              <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                <strong>
                  <?php
                  $url = $_SERVER['REQUEST_URI'];
                  $url = add_query_arg( array(
                              'freelancer_id' => $user->ID,
                          ), $url ); ?>
                  <a class="row-title" href="<?= $url ?>" aria-label="“About Us” (Edit)"><?php echo ($first_name . ' ' . $last_name); ?></a>
                </strong>
              </div>
            </td>
            <td class="author column-author" data-colname="Author">
              <?php if ($stripe_id): ?>
                <a style="color:green" href="edit.php?post_type=page&amp;author=1">Yes</a>
              <?php else: ?>
                <a style="color:red" href="edit.php?post_type=page&amp;author=1">No</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  <?php } ?>

  <?php if ($_GET['freelancer_id']) { ?>
    <table class="wp-list-table widefat fixed striped table-view-list pages">
      <thead>
      <tr>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
          <a href=""><span>Project</span><span class="sorting-indicator"></span></a>
        </th>
        <th scope="col" id="author" class="manage-column column-author">Status</th>
        <th scope="col" id="author" class="manage-column column-author">Pay with stripe</th>
      </tr>
      </thead>

      <tbody id="the-list">
        <?php
        $args = array(
          'post_type'      => 'bid',
          'author'         => $_GET['freelancer_id'],
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
        while ( $author_app_query->have_posts() ) {
          $author_app_query->the_post();

          $bid_status = get_post_status();
          $bid_parent = wp_get_post_parent_id( get_the_ID() );

          $proj_status = get_post_status( $bid_parent );
          ?>
          <?php $ie_perge_backlink = get_field( 'url_domain' ); ?>
          <tr id="post-1956" class="iedit author-other level-0 post-1956 type-page status-publish hentry">
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
              <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                <strong>
                  <?php $ie_perge_client_url = get_field( 'url_of_page_you_want_to_build_a_link_to', $bid_parent ); ?>
                  <a class="row-title" target="_blank" href="<?php echo $ie_perge_backlink ?>" aria-label="“About Us” (Edit)"><?php echo $ie_perge_backlink = preg_replace("(^https?://)", "", $ie_perge_backlink ); ?></a>
                </strong>
              </div>
            </td>
            <td class="author column-author" data-colname="Author">
              <?php
              if ( $bid_status == 'accept' || $bid_status == 'admin-review' ) {
                echo '<span class="status bold text-dark-green">Active</span>';
              } else if ( ( $bid_status == 'cancelled' || $proj_status == 'cancelled' ) && $bid_status !== 'pending-completion' ) {
                echo '<span class="status bold text-red">Cancelled</span>';
              } else if ( $bid_status == 'deleted' ) {
                echo '<span class="status bold text-dark-red">Declined</span>';
              } else if ( $bid_status == 'pending-completion' ) {
                echo '<span class="status bold">Completed</span>';
              } else if ( $proj_status == 'publish' || $bid_status == 'publish' ) {
                echo '<span class="status bold text-magenta">Pending Acceptance</span>';
              } else if ( $bid_status == 'complete' || $bid_status == 'pending-completion' ) {
                echo '<span class="status bold text-dark">Completed</span>';
              } else if ( $proj_status = "complete" || $proj_status == 'pending-completion' ) {
                echo '<span class="status bold">Pending Acceptance</span>';
              } else {
                echo '<span class="status bold text-dark">Completed</span>';
              }
              ?>
            </td>
            <?php
            $stripe_id = get_user_meta( $_GET['freelancer_id'], 'user_stripe_id', true );
            if ($stripe_id) {
              $url = $_SERVER['REQUEST_URI'];
              $url = add_query_arg( array(
                          'project_id' => get_the_ID(),
                      ), $url );
              ?>
              <td class="author column-author" data-colname="Author">
                <a href="<?= $url ?>" class="pay_with_stripe">Pay with stripe</a>
              </td>
              <?php
            } else {
              ?>
              <td class="author column-author" data-colname="Author">
                Stripe not connected
              </td>
              <?php
            }
            ?>

          </tr>
          <?php
        } ?>
      </tbody>
    </table>
  <?php } ?>
<?php else: ?>
  <form method="post" action="options.php">
      <table class="form-table">
          <tr valign="top">
          <th scope="row">Stripe password (last 4 chars from (stripe pass) api key)</th>
          <td><input type="text" name="stripe_pass" value="" /></td>
          </tr>

          <tr valign="top">
          <th scope="row">Payment amount</th>
          <td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('some_other_option') ); ?>" /></td>
          </tr>

          <tr valign="top">
          <th scope="row">Options, Etc.</th>
          <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
          </tr>
      </table>

      <?php submit_button(); ?>

  </form>
<?php endif; ?>


<?php

//var_dump($users);
$args = array(
	'post_type'      => 'bid',
	// 'author'         => $current_user->ID,
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

$author_app_query = new WP_Query( $args ); ?>
<?php //var_dump($author_app_query->posts); ?>
</div>
<?php }
?>
