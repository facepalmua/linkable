<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access!' );
}

// Search by post title
add_filter( 'posts_where', 'la_posts_where_title', 10, 2 );
function la_posts_where_title( $where, $wp_query ) {
	global $wpdb;
	if ( $link_post_title = $wp_query->get( 'link_post_title' ) ) {
		$title_ww = 'w.' . $link_post_title;
		$title_sl = '/' . $link_post_title;
		$where    .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $title_ww ) ) . '%\'
		OR ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $title_sl ) ) . '%\' )';
	}

	return $where;
}

// Post type & taxonomy for Author Build Links
function la_build_links_post_type() {
	$links_labels = array(
		'name'               => __( 'Build Links', 'linkable' ),
		'singular_name'      => __( 'Build Link', 'linkable' ),
		'add_new'            => _x( 'Add New', 'linkable', 'linkable' ),
		'add_new_item'       => __( 'Add New', 'linkable' ),
		'edit_item'          => __( 'Edit Link', 'linkable' ),
		'new_item'           => __( 'New Link', 'linkable' ),
		'view_item'          => __( 'View link', 'linkable' ),
		'search_items'       => __( 'Search Links', 'linkable' ),
		'not_found'          => __( 'No Links found', 'linkable' ),
		'not_found_in_trash' => __( 'No Links found in Trash', 'linkable' ),
		'parent_item_colon'  => __( 'Parent link:', 'linkable' ),
		'menu_name'          => __( 'Build Links', 'linkable' ),
	);

	$bid_args = array(
		'labels'              => $links_labels,
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => false,
		'menu_position'       => 10,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		// 'taxonomies'          => array( 'project_category' ),
		'query_var'           => false,
		'can_export'          => true,
		'menu_icon'           => 'dashicons-admin-links',
		'supports'            => array(
			'title',
			'custom-fields',
			'author'
		)
	);
	register_post_type( 'build-links', $bid_args );

	// Register taxonomy for build links
	$labels = array(
		'name'                => _x( 'Recommended Links', 'Links Industries', 'linkable' ),
		'singular_name'       => _x( 'Links Category', 'Links Category', 'linkable' ),
		'search_items'        => __( 'Search Links Industries', 'linkable' ),
		'popular_items'       => __( 'Popular Links Industries', 'linkable' ),
		'all_items'           => __( 'All Links Industries', 'linkable' ),
		'parent_item'         => __( 'Parent Links Category', 'linkable' ),
		'parent_item_colon'   => __( 'Parent Links Category', 'linkable' ),
		'edit_item'           => __( 'Edit Links Category', 'linkable' ),
		'update_item'         => __( 'Update Links Category', 'linkable' ),
		'add_new_item'        => __( 'Add New Links Category', 'linkable' ),
		'new_item_name'       => __( 'New Links Category Name', 'linkable' ),
		'add_or_remove_items' => __( 'Add or remove Links Industries', 'linkable' ),
		'menu_name'           => __( 'Links Category', 'linkable' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_admin_column'   => true,
		'hierarchical'        => true,
		'show_tagcloud'       => true,
		'show_ui'             => true,
		'query_var'           => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => array( 'slug' => 'industry' ),
		'capabilities'        => array(
			'manage_terms',
			'edit_terms',
			'delete_terms',
			'assign_terms'
		)
	);

	register_taxonomy( 'industry', array( 'build-links', 'project' ), $args );
}

add_action( 'init', 'la_build_links_post_type' );

// Add the custom columns to the build links post type:
function la_set_custom_edit_links_columns( $columns ) {
	$rearrange = array(
		'cb'          => $columns['cb'],
		'title'       => $columns['title'],
		'link_author' => __( 'Freelancer', 'linkable' ),
	);
	unset( $columns['author'] );
	$new_cols = array_merge( $rearrange, $columns );

	return $new_cols;
}

add_filter( 'manage_build-links_posts_columns', 'la_set_custom_edit_links_columns' );

// Update Author Column
function la_update_links_author_column( $column, $post_id ) {
	switch ( $column ) {
		case 'link_author' :
			$post        = get_post( $post_id );
			$author_data = get_userdata( $post->post_author );
			$author_url  = get_admin_url() . '/edit.php?post_type=build-links&author=' . $author_data->ID;
			echo "<a href='{$author_url}'>{$author_data->first_name} {$author_data->last_name} - {$author_data->user_email}</a>";
			break;
	}
}

add_action( 'manage_build-links_posts_custom_column', 'la_update_links_author_column', 10, 2 );

// Delete links if user deleted
function la_delete_author_links_when_user_deleted( $id ) {
	global $wpdb;
	$links = $wpdb->get_results(
		$wpdb->prepare( "SELECT ID from {$wpdb->posts}
		WHERE post_type = 'build-links'
		AND post_author = %d
		", $id )
	);
	if ( count( $links ) > 0 ) {
		foreach ( $links as $link ) {
			wp_delete_post( $link->ID, true );
		}
	}
}

add_action( 'deleted_user', 'la_delete_author_links_when_user_deleted' );

/**
 * Check if the link already exists.
 *
 * @param $link string  Link to check.
 * @param $term int     Term ID to check.
 * @param $user int     User ID to check (Optional).
 *
 * @return bool
 */
function la_is_link_exists( $link, $term, $user = 0 ) {
	if ( 0 === $user ) {
		$user = get_current_user_id();
	}
	$link_host = wp_parse_url( $link, PHP_URL_HOST );
	$links     = get_posts( array(
		'post_type'       => 'build-links',
		'posts_per_page'  => - 1,
		'post_status'     => 'publish',
		'author'          => $user,
		'link_post_title' => $link_host,
		'tax_query'       => array(
			array(
				'taxonomy' => 'industry',
				'terms'    => $term
			)
		)
	) );
	if ( count( $links ) > 0 ) {
		return true;
	}

	return false;
}

// Ajax controller for author build links
function la_author_build_link_handler() {
	header( 'Content-Type: application/json' );
	$data = $_POST;

	// Security
	if ( ! wp_verify_nonce( $data['token'], '_build_links_token' ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Invalid Token!' ] );
		wp_die();
	}
	// Check site name
	if ( ! isset( $data['site_name'] ) || empty( $data['site_name'] ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Site name is required!' ] );
		wp_die();
	}
	// Check industry
	if ( ! isset( $data['site_category'] ) || empty( $data['site_category'] ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Industry is required!' ] );
		wp_die();
	}

	$current_user = get_current_user_id();
	$domain       = esc_url( $data['site_name'] );

	// Check if this link already exists
	if ( la_is_link_exists( $domain, $data['site_category'], $current_user ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Link already exists!' ] );
		wp_die();
	}

	// Let's save the information.
	$post_data = array(
		'post_title'   => sanitize_text_field( $domain ),
		'post_content' => sanitize_text_field( $domain ),
		'post_type'    => 'build-links',
		'post_author'  => $current_user,
		'post_status'  => 'publish'
	);
	if ( isset( $data['previous_site'] ) && ! empty( $data['previous_site'] ) ) {
		$post_data['ID'] = sanitize_text_field( $data['previous_site'] );
	}
	$new_link = wp_insert_post( $post_data );
	if ( ! is_wp_error( $new_link ) ) {
		wp_set_post_terms( $new_link, array( $data['site_category'] ), 'industry' );
		// DA from Moz
		$domain_authority = get_da_from_moz_api( $domain );
		update_post_meta( $new_link, 'la_domain_authority', $domain_authority );
		// Price
		$price = get_pricing_from_da( $domain_authority, $domain, 'DoFollow' );
		update_post_meta( $new_link, 'la_price_range', $price['owner_price'] );
	}
	echo wp_json_encode( [ 'status' => true, 'message' => 'Perfectly worked!' ] );
	wp_die();
}

add_action( 'wp_ajax_la_author_link_build', 'la_author_build_link_handler' );
add_action( 'wp_ajax_nopriv_la_author_link_build', 'la_author_build_link_handler' );

// Get Author Links builds
function la_get_author_build_links_cb() {
	header( 'Content-Type: text/html' );
	$data = $_POST;
	// Security
	if ( ! wp_verify_nonce( $data['token'], '_build_links_token' ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Invalid Token!' ] );
		wp_die();
	}
	locate_template( 'template/author-links.php', true );
	wp_die();
}

add_action( 'wp_ajax_la_get_users_links', 'la_get_author_build_links_cb' );
add_action( 'wp_ajax_nopriv_la_get_users_links', 'la_get_author_build_links_cb' );

// Delete Author Link
function la_del_users_links_cb() {
	header( 'Content-Type: application/json' );
	$data = $_POST;
	// Security
	if ( ! wp_verify_nonce( $data['token'], '_build_links_token' ) ) {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Invalid Token!' ] );
		wp_die();
	}
	if ( ! isset( $data['link_id'] ) || empty( $data['link_id'] ) ) {
		echo wp_json_encode( [ 'status' => true, 'message' => 'Invalid Request!' ] );
		wp_die();
	}
	$status = wp_delete_post( $data['link_id'], true );
	if ( $status ) {
		echo wp_json_encode( [ 'status' => true, 'message' => 'Successfully deleted!' ] );
	} else {
		echo wp_json_encode( [ 'status' => false, 'message' => 'Something going wrong!' ] );
	}
	wp_die();
}

add_action( 'wp_ajax_la_del_users_links', 'la_del_users_links_cb' );
add_action( 'wp_ajax_nopriv_la_del_users_links', 'la_del_users_links_cb' );

// Get recommended links
function la_get_client_recommended_links( $project_id, $sort_by = '', $order = 'ASC', $terms = [] ) {
	// Get the industries first
	$industries = wp_get_post_terms( $project_id, 'industry' );

	if ( count( $industries ) > 0 ) {
		if ( count( $terms ) > 0 ) {
			$ind = $terms;
		} else {
			$ind = wp_list_pluck( $industries, 'term_id' );
		}

		if ( 'industry' == $sort_by ) {
			$order_by = 't.name';
		} elseif ( 'da' == $sort_by ) {
			// $order_by = 'pm.meta_value';
			$order_by = 'CAST(pm.meta_value AS UNSIGNED)';
		} else {
			$order_by = '';
		}

		$ind_joins = join( ", ", (array) $ind );

		global $wpdb;

		$links_query = "
				SELECT p.ID, p.post_title as post_title, pm.meta_value AS da, t.name FROM {$wpdb->posts} p
				LEFT JOIN {$wpdb->term_relationships} tr
				ON p.ID = tr.object_id
				LEFT JOIN {$wpdb->terms} t
				ON tr.term_taxonomy_id = t.term_id
				LEFT JOIN {$wpdb->postmeta} pm
				ON p.ID = pm.post_id
				WHERE t.term_id IN ({$ind_joins})
				AND p.post_type = 'build-links'
				AND p.post_status = 'publish'
				AND pm.meta_key = 'la_domain_authority'
				GROUP BY post_title
			";

		if ( ! empty( $order_by ) ) {
			$links_query .= " ORDER BY {$order_by} {$order}";
		} else {
			$links_query .= " ORDER BY ID DESC";
		}
		$links = $wpdb->get_results( $links_query );

		return $links;
	}

	return [];
}

// Get sorted projects
function la_get_sorted_projects_cb() {
	header( 'Content-Type: text/html' );
	$data = $_POST;
	// Security
	if ( ! wp_verify_nonce( $data['token'], '_client_projects' ) ) {
		echo "Invalid Request!";
		wp_die();
	}
	$project_id = isset( $data['project_id'] ) ? sanitize_text_field( $data['project_id'] ) : '';
	if ( empty( $project_id ) ) {
		echo "Project ID is required!";
		wp_die();
	}
	$sort_by = isset( $data['sort_by'] ) && 'industry' == $data['sort_by'] ? 'industry' : 'da';
	$order   = isset( $data['desc'] ) && 'no' == $data['desc'] ? 'ASC' : 'DESC';
	$terms   = isset( $data['terms'] ) && $data['terms'] != '' ? $data['terms'] : [];
	if ( 'DESC' == $order ) {
		if ( 'da' == $sort_by ) {
			$order_da = 'asc';
		} else {
			$order_ind = 'asc';
		}
	} else {
		if ( 'da' == $sort_by ) {
			$order_da = 'desc';
		} else {
			$order_ind = 'desc';
		}
	}
	// $current_user = get_current_user_id();
	$links = la_get_client_recommended_links( $project_id, $sort_by, $order, $terms );
	include( locate_template( 'template/recommended-links.php' ) );
	wp_die();
}

add_action( 'wp_ajax_la_get_sorted_projects', 'la_get_sorted_projects_cb' );
add_action( 'wp_ajax_nopriv_la_get_sorted_projects', 'la_get_sorted_projects_cb' );

// Send email to new posted project's author about the related links
function la_related_links_email() {

	/*
	 * 1. Get published projects
	 * 2. Loop through the projects and check if there any Industries added
	 */
	 return;
	$args     = array(
		'post_type'      => 'project',
		'post_status'    => 'publish',
		'posts_per_page' => '-1',
		'tax_query'      => array(
			array(
				'taxonomy' => 'industry',
				'operator' => 'EXISTS'
			),
		)
	);
	$projects = get_posts( $args );
	// Check if there any new projects
	if ( count( $projects ) > 0 ) {

		foreach ( $projects as $project ) {
			$links = la_get_client_recommended_links( $project->ID, '' );
			// Check if there any industry added
			if ( count( $links ) > 0 ) {
				$client_id = $project->post_author;
				$client    = get_userdata( $client_id );
				// Check if there are any links
				if ( count( $links ) ) {
					$da_90_up = 0;
					$da_80_89 = 0;
					$da_70_79 = 0;
					$da_60_69 = 0;
					$da_50_59 = 0;
					$da_40_49 = 0;
					$da_30_39 = 0;
					$da_20_29 = 0;
					$da_10_19 = 0;
					$da_0_9   = 0;
					foreach ( $links as $link ) {
						$seen_list = get_post_meta( $link->ID, 'la_link_seen_by', true );
						if ( in_array( $client_id, (array) $seen_list ) ) {
							continue;
						} else {
							// $da = get_post_meta( $link->ID, 'la_domain_authority', true );
							$da = intval( $link->da );
							if ( $da >= 90 ) {
								$da_90_up ++;
							} elseif ( $da >= 80 && $da <= 89 ) {
								$da_80_89 ++;
							} elseif ( $da >= 70 && $da <= 79 ) {
								$da_70_79 ++;
							} elseif ( $da >= 60 && $da <= 69 ) {
								$da_60_69 ++;
							} elseif ( $da >= 50 && $da <= 59 ) {
								$da_50_59 ++;
							} elseif ( $da >= 40 && $da <= 49 ) {
								$da_40_49 ++;
							} elseif ( $da >= 30 && $da <= 39 ) {
								$da_30_39 ++;
							} elseif ( $da >= 20 && $da <= 29 ) {
								$da_20_29 ++;
							} elseif ( $da >= 10 && $da <= 19 ) {
								$da_10_19 ++;
							} elseif ( $da <= 9 ) {
								$da_0_9 ++;
							}
						}
					}

					// Check if there any new links found
					$hasSites = $da_90_up > 0 || $da_80_89 > 0 || $da_70_79 > 0 || $da_60_69 > 0 || $da_50_59 > 0 || $da_40_49 > 0 || $da_30_39 > 0 || $da_20_29 > 0 || $da_10_19 > 0 || $da_0_9 > 0;
					// Check if the client has any email
					if ( isset( $client->user_email ) && $hasSites ) {
						$recommended_url = get_site_url() . "/recommended-links";
						$client_email    = $client->user_email;
						$first_name      = $client->first_name;
						$email_subject   = 'We have some new backlink opportunities for you!';

						$email_body = "<html><body>Hi " . ucfirst( $first_name ) . ",<br><br>";
						$email_body .= "We have some new backlink opportunities for you!<br><br>";
						$email_body .= "Based off of your project requirements, we’ve posted some new sites that we’d recommend you should get a backlink on.<br><br>";
						$email_body .= "<strong>New backlinks recommended for you:</strong><br>";

						if ( $da_90_up > 0 ) {
							$email_body .= "DA 90 - 99 | <a href='{$recommended_url}'>{$da_90_up} new sites</a><br>";
						}
						if ( $da_80_89 > 0 ) {
							$email_body .= "DA 80 - 89 | <a href='{$recommended_url}'>{$da_80_89} new sites</a><br>";
						}
						if ( $da_70_79 > 0 ) {
							$email_body .= "DA 70 - 79 | <a href='{$recommended_url}'>{$da_70_79} new sites</a><br>";
						}
						if ( $da_60_69 > 0 ) {
							$email_body .= "DA 60 - 69 | <a href='{$recommended_url}'>{$da_60_69} new sites</a><br>";
						}
						if ( $da_50_59 > 0 ) {
							$email_body .= "DA 50 - 59 | <a href='{$recommended_url}'>{$da_50_59} new sites</a><br>";
						}
						if ( $da_40_49 > 0 ) {
							$email_body .= "DA 40 - 49 | <a href='{$recommended_url}'>{$da_40_49} new sites</a><br>";
						}
						if ( $da_30_39 > 0 ) {
							$email_body .= "DA 30 - 39 | <a href='{$recommended_url}'>{$da_30_39} new sites</a><br>";
						}
						if ( $da_20_29 > 0 ) {
							$email_body .= "DA 20 - 29 | <a href='{$recommended_url}'>{$da_20_29} new sites</a><br>";
						}
						if ( $da_10_19 > 0 ) {
							$email_body .= "DA 10 - 19 | <a href='{$recommended_url}'>{$da_10_19} new sites</a><br>";
						}
						if ( $da_0_9 > 0 ) {
							$email_body .= "DA 0 - 9 | <a href='{$recommended_url}'>{$da_0_9} new sites</a><br>";
						}

						$email_body .= "<br><strong>What should I do?</strong><br>";
						$email_body .= "Simply log back into Link-able and take a look at the sites. Then let authors know which backlinks you want!<br><br>";
						$email_body .= "Keep in mind, these opportunities may be time sensitive, so let authors know asap!<br><br>";
						$email_body .= "Cheers!<br>The Link-able Team";
						$email_body .= "</body></html>";

						$headers = array(
							'Content-Type: text/html; charset=UTF-8',
							'From: Link-able <noreply@link-able.com>'
						);
						// Now send email
						wp_mail( $client_email, $email_subject, $email_body, $headers );
					}
				}
			} // if there any industry added
		} // End loop
	}
}

add_action( 'send_category_emails', 'la_related_links_email' );

// ============= Temporary code
if ( isset( $_GET['linkable_jay_init_cron_job_271287'] ) ) {
	add_action( 'init', 'la_related_links_email' );
}
// ============ Temporary code ended

// Send email to Author from the client
function la_send_inquiry_to_author( $entry, $form ) {
	$project_id      = rgar( $entry, 2 );
	$inquiry_message = rgar( $entry, 4 );
	$domain          = rgar( $entry, 5 );

	$industries = wp_get_post_terms( $project_id, 'industry' );
	if ( count( $industries ) > 0 ) {
		$ind = wp_list_pluck( $industries, 'term_id' );

		$links_query = array(
			'post_type'       => 'build-links',
			'post_status'     => 'publish',
			'link_post_title' => $domain,
			'posts_per_page'  => - 1,
			'tax_query'       => array(
				array(
					'taxonomy' => 'industry',
					'terms'    => $ind,
				),
			)
		);

		$authors = [];
		$links   = get_posts( $links_query );
		$subject = 'You got a new inquiry message for ' . $domain;
		foreach ( $links as $link ) {
			$author = $link->post_author;
			if ( ! in_array( $author, $authors ) ) {

				$project = get_post( $project_id );

				$client       = $project->post_author;
				$client_data  = get_userdata( $client );
				$author_data  = get_userdata( $author );
				$author_email = $author_data->user_email;

				$url = $link->post_title;
				$da  = get_post_meta( $link->ID, 'la_domain_authority', true );

				// $price = get_post_meta( $link->ID, 'la_price_range', true );
				$price = get_pricing_from_da( $da, $url, 'DoFollow' );
				$range = '--';
				if ( ! empty( $price['owner_price'] ) ) {
					$differ     = ( $price['owner_price'] * 10 ) / 100;
					$high_price = number_format( $price['owner_price'] + $differ, 0 );
					$low_price  = number_format( $price['owner_price'] - $differ, 0 );
					$range      = '$' . $low_price . ' - $' . $high_price;
				}

				if ( ! empty( $author_email ) ) {

					$cm_name = $client_data->first_name;
					if ( empty( $cm_name ) ) {
						$cm_name = $client_data->display_name;
					}

					$time         = current_time( 'mysql' );
					$time         = mysql2date( 'U', $time, false );
					$send_time    = date( 'h:ia @ M d', $time );
					$current_time = str_replace( '@', 'on', $send_time );

					$message_link  = get_site_url() . '/messages';
					$author_f_name = $author_data->first_name;
					// Author message
					$author_message = '<div style="padding: 10px; background-color: #eef1ff; width: 100%; margin: 20px 0;">';
					$author_message .= '<p style="margin:0;"><strong>' . $cm_name . ' - ' . $current_time . '</strong></p>';
					$author_message .= '<p style="margin:5px 0 0; color: #1aad4b;"><i>Client is interested in ' . $domain . ' (Average cost is ' . $range . ')</i></p>';
					$author_message .= '<p style="margin: 3px 0 0;">' . $inquiry_message . '</p>';
					$author_message .= '</div>';

					// Create email
					$email_content = "
					Hi {$author_f_name},
					<br><br>
					A client is interested in one of the sites you mentioned you could build a backlink on and has sent you a message on Link-able!
					<br>
					{$author_message}
					<br>
					<a href='{$message_link}'>Reply Now</a>
					<br><br>
					Don't keep the client waiting! Simply login to your account and go to <a href='{$message_link}'>Messages</a> to reply back.
					<br><br>
					Cheers!
					<br>
					The Link-able Team
					";

					$subject = 'You have a new message from the client!';
					// Okay, everything done! Now send it.
					la_send_email( $author_email, $subject, $email_content );

					// Create message notification
					$message = "<p class='green italic'>Client is interested in {$domain} (Average cost is {$range})</p>";
					$message .= sanitize_textarea_field( $inquiry_message );

					$args = array(
						'project_id' => $project_id,
						'author_id'  => $author,
						'sender_id'  => $client,
						'message'    => $message,
					);

					$pm     = new LAPrivateMessaging();
					$status = $pm->create_message( $args, true );

					// Create a new notification
					$args = array(
						'author'    => $author,
						'project'   => $project_id,
						'notify_to' => $author
					);
					send_message_notification( $args );

				} // If author has an email
			}
			$authors[] = $author;
		}
	}
}

add_action( 'gform_after_submission_23', 'la_send_inquiry_to_author', 10, 2 );


function la_get_categories_recommended_links($links_cat){

	 foreach ($links_cat as $link) {
            $link_categories[] = $link->name;
        }

        $link_categories = array_unique($link_categories);
        $i = 0;
        $category_arr = array();
        foreach ($link_categories as $link) {
            // $category_arr[$i]['name'] = $link;
            // $term = get_term_by( 'name', $link, 'industry' );
            // $category_arr[$i]['term_id'] = $term->term_id;
            // $i++;
            $category_arr[] = $link;
        }

	return $category_arr;
}
