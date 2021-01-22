<?php
/**
 * Proxy & VPN Blocker
 *
 * @package           Proxy & VPN Blocker
 * @author            RickstermUK
 * @copyright         2017 - 2020 Proxy & VPN Blocker
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Proxy & VPN Blocker
 * Plugin URI: https://pvb.ricksterm.net
 * description: Proxy & VPN Blocker. This plugin will prevent Proxies and VPN's accessing your site's login page or making comments on pages & posts using the Proxycheck.io API
 * Version: 1.6.8
 * Author: RickstermUK
 * Author URI: https://profiles.wordpress.org/rickstermuk
 * License: GPLv2
 * Text Domain:       proxy-vpn-blocker
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

$version = '1.6.8';
$update_date = 'May 22nd 2020';

if ( version_compare( get_option( 'proxy_vpn_blocker_version' ), $version, '<' ) ) {
	update_option( 'proxy_vpn_blocker_version', $version );
	update_option( 'proxy_vpn_blocker_last_update', $update_date );
}

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Load plugin class files.
require_once 'includes/class-proxy-vpn-blocker.php';
require_once 'includes/plugin-options.php';
require_once 'includes/custom-form-handlers.php';
// Load plugin libraries.
require_once 'includes/lib/class-proxy-vpn-blocker-admin-api.php';

/**
 * Returns the main instance of proxy_vpn_blocker to prevent the need to use globals.
 *
 * @return object proxy_vpn_blocker
 */
function proxy_vpn_blocker() {
	global $version;
	$instance = proxy_vpn_blocker::instance( __FILE__, $version );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = proxy_vpn_blocker_Settings::instance( $instance );
	}

	return $instance;
}

proxy_vpn_blocker();

/**
 * Display message if disablepvb.txt file exists
 */
function disable_pvb_file_exists() {
	if ( is_file( ABSPATH . 'disablepvb.txt' ) ) {
		echo '<div class="notice notice-warning">';
		echo '<p>' . _e( 'Proxy & VPN Blocker is currently not protecting your site, disablepvb.txt exists in your WordPress root directory, please delete it!', 'proxy-vpn-blocker' ) . '</p>';
		echo '</div>';
	}
}
add_action( 'admin_notices', 'disable_pvb_file_exists' );

/**
 * Display message if cloudflare detected but not enabled in Proxy & VPN Blocker
 */
function pvb_cloudflare_not_enabled() {
	if ( get_option( 'pvb_proxycheckio_CLOUDFLARE_select_box' ) == '' && isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && get_option( 'pvb_proxycheckio_master_activation' ) == 'on' ) {
		echo '<div class="notice notice-warning pvb-cloudflare-notice is-dismissible">';
		echo '<p>' . _e( 'Proxy & VPN Blocker has detected that you are probably using Cloudflare but have not enabled the Cloudflare option in Proxy & VPN Blocker settings, please enable this or we <i>*may not</i> be able to check visitors real IP addresses!', 'proxy-vpn-blocker' ) . '</p>';
		echo '<p>' . _e( '*If your web server supports Cloudflare natively then Proxy & VPN Blocker will get the correct visitor IP anyway, but you should still enable the Cloudflare option.', 'proxy-vpn-blocker' ) . '</p>';
		echo '</div>';
	}
}
add_action( 'admin_notices', 'pvb_cloudflare_not_enabled' );

/**
 * Proxy & VPN Blocker General check for (pages, posts, login etc).
 */
function pvb_general_check() {
	if ( get_option( 'pvb_proxycheckio_CLOUDFLARE_select_box' ) == 'on' && isset( $_SERVER["HTTP_CF_CONNECTING_IP"] ) ) {
		$visitor_ip_address = $_SERVER["HTTP_CF_CONNECTING_IP"];
	} else {
		$visitor_ip_address = $_SERVER["REMOTE_ADDR"];
	}
	if ( ! empty( $visitor_ip_address ) ) {
		require_once 'proxycheckio-api-call.php';
		$proxycheck_denied = get_option( 'pvb_proxycheckio_denied_access_field' );
		$countries = get_option( 'pvb_proxycheckio_blocked_countries_field' );
		if ( ! empty( $countries ) && is_array( $countries ) ) {
			$perform_country_check = 1;
		} else {
			$perform_country_check = 0;
		}
		$proxycheck_answer = proxycheck_function( $visitor_ip_address, $perform_country_check );
		if ( 1 == $proxycheck_answer[0] ) {
			// Check if Risk Score Checking is on.
			if ( get_option( 'pvb_proxycheckio_risk_select_box' ) == 'on' ) {
				// Check if proxycheck answer array key 4 is set and is NOT VPN or EMPTY.
				if ( 'VPN' != $proxycheck_answer[4] ) {
					// Check if proxycheck answer array key 4 for risk score and compare it to the set proxy risk score.
					if ( $proxycheck_answer[3] != 'null' && $proxycheck_answer[3] >= get_option( 'pvb_proxycheckio_max_riskscore_proxy' ) ) {
						if ( ! empty( get_option( 'pvb_proxycheckio_custom_blocked_page' ) ) ) {
							$redirect_to = array_values( get_option( 'pvb_proxycheckio_custom_blocked_page' ) );
							wp_safe_redirect( $redirect_to[0] );
							exit();
						} else {
							define( 'DONOTCACHEPAGE', true ); // Do not cache this page.
							wp_die( '<p>'.  $proxycheck_denied . '</p>', $proxycheck_denied, array( 'back_link' => true ) );
						}
					}
				} else if ( 'VPN' == $proxycheck_answer[4] ) {
					// Check if proxycheck answer array key 4 for risk score and compare it to the set VPN risk score.
					if ( $proxycheck_answer[3] != 'null' && $proxycheck_answer[3] >= get_option( 'pvb_proxycheckio_max_riskscore_vpn' ) ) {
						if ( ! empty( get_option( 'pvb_proxycheckio_custom_blocked_page' ) ) ) {
							$redirect_to = array_values( get_option( 'pvb_proxycheckio_custom_blocked_page' ) );
							wp_safe_redirect( $redirect_to[0] );
							exit();
						} else {
							define( 'DONOTCACHEPAGE', true ); // Do not cache this page.
							wp_die( '<p>' . $proxycheck_denied . '</p>', $proxycheck_denied, array( 'back_link' => true ) );
						}
					}
				}
			} else {
				// Do this if risk score checking is off.
				if ( ! empty( get_option( 'pvb_proxycheckio_custom_blocked_page' ) ) ) {
					$redirect_to = array_values( get_option( 'pvb_proxycheckio_custom_blocked_page' ) );
					wp_safe_redirect( $redirect_to[0] );
					exit();
				} else {
					define( 'DONOTCACHEPAGE', true ); // Do not cache this page.
					wp_die( '<p>' . $proxycheck_denied . '</p>', $proxycheck_denied, array( 'back_link' => true ) );
				}
			}
		} else if ( 1 == $perform_country_check ) {
			if ( get_option( 'pvb_proxycheckio_whitelist_countries_select_box' ) == '' ) {
				// Block Countries in Country Block List. Allow all others.
				if ( in_array( $proxycheck_answer[1], $countries ) || in_array( $proxycheck_answer[2], $countries ) ) {
					if ( ! empty( get_option( 'pvb_proxycheckio_custom_blocked_page' ) ) ) {
						$redirect_to = array_values( get_option( 'pvb_proxycheckio_custom_blocked_page' ) );
						wp_safe_redirect( $redirect_to[0] );
						exit();
					} else {
						define( 'DONOTCACHEPAGE', true ); // Do not cache this page.
						wp_die( '<p>' . $proxycheck_denied . '</p>', $proxycheck_denied, array( 'back_link' => true ) );
					}
				}
			} else if ( get_option( 'pvb_proxycheckio_whitelist_countries_select_box' ) == 'on' ) {
				// Allow Countries through if listed if this is to be treated as a whitelist. Block all other countries.
				if ( in_array( $proxycheck_answer[1], $countries ) || in_array( $proxycheck_answer[2], $countries ) ) {
					set_transient( 'pvb_' . get_option( 'pvb_proxycheckio_current_key' ) . '_' . $visitor_ip_address, time() + 1800 . '-' . 0, 60 * get_option( 'pvb_proxycheckio_good_ip_cache_time' ) );
				} else {
					if ( ! empty( get_option( 'pvb_proxycheckio_custom_blocked_page' ) ) ) {
						$redirect_to = array_values( get_option( 'pvb_proxycheckio_custom_blocked_page' ) );
						wp_safe_redirect( $redirect_to[0] );
						exit();
					} else {
						define( 'DONOTCACHEPAGE', true ); // Do not cache this page.
						wp_die( '<p>' . $proxycheck_denied . '</p>', $proxycheck_denied, array( 'back_link' => true ) );
					}
				}
			}
		} else {
			// No proxy has been detected so set a transient to cache this result and then return false.
			set_transient( 'pvb_' . get_option( 'pvb_proxycheckio_current_key' ) . '_' . $visitor_ip_address, time() + 1800 . '-' . 0, 60 * get_option( 'pvb_proxycheckio_good_ip_cache_time' ) );
		}
	}
}

/**
 * Proxy & VPN Blocker Standard Script
 */
function pvb_standard_script() {
	if ( ! is_file( ABSPATH . 'disablepvb.txt' ) ) {
		$request_uri = $_SERVER['REQUEST_URI'];
		if ( stripos( $request_uri, 'wp-cron.php' ) === false && stripos( $request_uri, 'admin-ajax.php' ) === false && current_user_can( 'administrator' ) === false ) {
			pvb_general_check();
		}
	}
}

/**
 * PVB on select pages integration
 */
function pvb_select_pages_integrate() {
	if ( ! is_file( ABSPATH . 'disablepvb.txt' ) ) {
		$request_uri = $_SERVER['REQUEST_URI'];
		$blocked_pages = get_option( 'pvb_blocked_pages_array' );
		if ( stripos( $request_uri, 'wp-cron.php' ) === false && stripos( $request_uri, 'admin-ajax.php' ) === false && current_user_can( 'administrator' ) === false ) {
			if ( is_array( $blocked_pages ) ) {
				foreach ( $blocked_pages as $blocked_page ) {
					if ( stripos( $request_uri, $blocked_page ) !== false ) {
						pvb_general_check();
					}
				}
			}
		}
	}
}

/**
 * PVB on ALL pages integration.
 */
function pvb_all_pages_integration() {
	if ( ! is_file( ABSPATH . 'disablepvb.txt' ) ) {
		$request_uri = $_SERVER['REQUEST_URI'];
		$full_url = esc_url_raw( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		if ( stripos( $request_uri, 'wp-cron.php' ) === false && stripos( $request_uri, 'admin-ajax.php' ) === false && current_user_can( 'administrator' ) === false ) {
			$custom_block_page = get_option( 'pvb_proxycheckio_custom_blocked_page' );
			if ( ! empty( $custom_block_page ) ) {
				if ( stripos( $full_url, $custom_block_page[0] ) === false ) {
					pvb_general_check();
				}
			} else {
				pvb_general_check();
			}
		}
	}
}

/**
 * PVB on select posts integration
 */
function pvb_select_posts_integrate() {
	if ( ! is_file( ABSPATH . 'disablepvb.txt' ) ) {
		$request_uri = $_SERVER['REQUEST_URI'];
		$blocked_posts = get_option( 'pvb_blocked_posts_array' );
		if ( stripos( $request_uri, 'wp-cron.php' ) === false && stripos( $request_uri, 'admin-ajax.php' ) === false && current_user_can( 'administrator' ) === false ) {
			if ( is_array( $blocked_posts ) ) {
				foreach ( $blocked_posts as $blocked_post ) {
					if ( stripos( $request_uri, $blocked_post ) !== false ) {
						pvb_general_check();
					}
				}
			}
		}
	}
}

/**
 * Processes page/post ID's to permalinks for use later.
 * Cannot otherwise get permalinks from page/post ID's early enough to use when we need them.
 */
function process_permalinks() {
	if ( get_transient( 'pvb_' . get_option( 'pvb_proxycheckio_current_key' ) . '_permalinks_' ) === false ) {
		if ( ! empty( get_option( 'pvb_proxycheckio_blocked_select_pages_field' ) ) ) {
			foreach ( get_option( 'pvb_proxycheckio_blocked_select_pages_field' ) as $blocked_page ) {
				$formatted_page_permalink = str_replace( get_site_url(), '', get_permalink( $blocked_page ) );
				$permalink_pages_array[] = $formatted_page_permalink;
			}
			update_option( 'pvb_blocked_pages_array', $permalink_pages_array );
		}
		if ( ! empty( get_option( 'pvb_proxycheckio_blocked_select_posts_field' ) ) ) {
			foreach ( get_option( 'pvb_proxycheckio_blocked_select_posts_field' ) as $blocked_post ) {
				$formatted_post_permalink = str_replace( get_site_url(), '', get_permalink( $blocked_post ) );
				$permalink_posts_array[] = $formatted_post_permalink;
			}
			update_option( 'pvb_blocked_posts_array', $permalink_posts_array );
		}
		set_transient( 'pvb_' . get_option( 'pvb_proxycheckio_current_key' ) . '_permalinks_', time() + 1800 . '-' . 0, 1 * HOUR_IN_SECONDS );
	}
}

/**
 * Activation switch to enable or disable querying.
 */
if ( get_option( 'pvb_proxycheckio_master_activation' ) == 'on' ) {
	/**
	 * WordPress Auth protection and comments protection.
	 */
	add_filter( 'authenticate', 'pvb_standard_script', 1 );
	add_filter( 'login_head', 'pvb_standard_script', 1 );
	add_action( 'pre_comment_on_post', 'pvb_standard_script', 1 );
	add_action( 'wp_loaded', 'process_permalinks', 1 );

	/**
	 * Enable block on specified PAGES option
	 */
	if ( ! empty( get_option( 'pvb_proxycheckio_blocked_select_pages_field' ) ) ) {
		add_action( 'plugins_loaded', 'pvb_select_pages_integrate', 1 );
		if ( get_option( 'pvb_proxycheckio_all_pages_activation' ) == 'on' ) {
			update_option( 'pvb_proxycheckio_all_pages_activation', '' );
		}
	}

	/**
	 * Enable block on specified POSTS option
	 */
	if ( ! empty( get_option( 'pvb_proxycheckio_blocked_select_posts_field' ) ) ) {
		add_action( 'plugins_loaded', 'pvb_select_posts_integrate', 1 );
		if ( get_option( 'pvb_proxycheckio_all_pages_activation' ) == 'on' ) {
			update_option( 'pvb_proxycheckio_all_pages_activation', '' );
		}
	}

	/**
	 * Enable for all pages option
	 */
	if ( get_option( 'pvb_proxycheckio_all_pages_activation' ) == 'on' ) {
		add_action( 'plugins_loaded', 'pvb_all_pages_integration', 1 );
	}
}

/**
 * Function to upgrade database.
 */
function upgrade_pvb_db() {
	$database_version = get_option( 'pvb_db_version' );
	$current_version = '2.0.1';
	if ( $current_version != $database_version ) {
		require_once 'pvb-db-upgrade.php';
	}
}
add_action( 'init', 'upgrade_pvb_db' );
