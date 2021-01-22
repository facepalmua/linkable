<?php
/**
 * Generate API Key Statistics Page.
 *
 * @package Proxy & VPN Blocker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$get_api_key = get_option( 'pvb_proxycheckio_API_Key_field' );
if ( ! empty( $get_api_key ) ) {
	// Build page HTML.
	$request_args      = array(
		'timeout'     => '10',
		'blocking'    => true,
		'httpversion' => '1.1',
	);
	$request_usage = wp_remote_get( 'https://proxycheck.io/dashboard/export/usage/?key=' . get_option( 'pvb_proxycheckio_API_Key_field' ), $request_args );
	$api_key_usage = json_decode( wp_remote_retrieve_body( $request_usage ) );
	if ( isset( $api_key_usage->status ) && 'denied' === $api_key_usage->status ) {
		$html  = '<div class="wrap" id="' . $this->parent->_token . '_statistics">' . "\n";
		$html .= '<h1>' . __( 'Proxy &amp; VPN Blocker proxycheck.io Statistics', 'proxy-vpn-blocker' ) . '</h1>' . "\n";
		$html .= '<div class="pvberror">' . "\n";
		$html .= '<div class="pvberrortitle">' . __( 'Oops!', 'proxy-vpn-blocker' ) . '</div>' . "\n";
		$html .= '<div class="pvberrorinside">' . "\n";
		$html .= '<h2>' . __( 'You must enable Dashboard API Access within your <a href="https://proxycheck.io" target="_blank">proxycheck.io</a> Dashboard to access this part of Proxy & VPN Blocker', 'proxy-vpn-blocker' ) . '</h2>' . "\n";
		$html .= '</div>' . "\n";
		$html .= '</div>' . "\n";
		$html .= '</div>';
		echo $html;
	} else {
		// Format and Display usage stats.
		$queries_today = $api_key_usage->{'Queries Today'};
		$daily_limit   = $api_key_usage->{'Daily Limit'};
		$queries_total = $api_key_usage->{'Queries Total'};
		$plan_tier     = $api_key_usage->{'Plan Tier'};
		$html          = '<div class="wrap" id="' . $this->parent->_token . '_statistics">' . "\n";
		$html         .= '<h1>' . __( 'Your proxycheck.io API Key Statistics', 'proxy-vpn-blocker' ) . '</h1>' . "\n";
		$html         .= '<div class="pvboptionswrap">' . "\n";
		$html         .= '<div class="pvbapidaily">';
		$html         .= '<div class="pvbapikey">' . __( 'API Key: ', 'proxy-vpn-blocker' ) . get_option( 'pvb_proxycheckio_API_Key_field' ) . '</div>' . "\n";
		$html         .= '<div class="pvbapitier">' . __( 'Plan: ', 'proxy-vpn-blocker' ) . $plan_tier . __( ' / ', 'proxy-vpn-blocker' ) . number_format( $daily_limit ) . __( ' Daily Queries', 'proxy-vpn-blocker' ) . '</div>' . "\n";
		$html         .= '</div>';
		$html         .= '<div class="pvbapiusageday">';
		$usage_percent = ( $queries_today * 100 ) / $daily_limit;
		$html         .= 'API Key Usage Today: ' . number_format( $queries_today ) . '/' . number_format( $daily_limit ) . ' Queries - ' . round( $usage_percent, 2 ) . '% of Total.';
		$html         .= '<div class="pvbpercentbar">';
		$html         .= '<div class="pvbpercentbarinner" style="width:' . $usage_percent . '%">';
		$html         .= '</div> </div>';
		$html         .= '</div>';
		$html         .= '<h3>' . __( 'API Key Queries: Past Month', 'proxy-vpn-blocker' ) . '</h3>' . "\n";
		echo $html;
	}
	// Get API Key statistics and display them on the page.
	$request1      = wp_remote_get( 'https://proxycheck.io/dashboard/export/queries/?json=1&key=' . get_option( 'pvb_proxycheckio_API_Key_field' ), $request_args );
	$api_key_stats = json_decode( wp_remote_retrieve_body( $request1 ) );
	if ( isset( $api_key_stats->status ) && 'denied' === $api_key_stats->status ) {
		// Do nothing.
	} else {
		// Format and display month stats.
		$proxy_total      = null;
		$vpn_total        = null;
		$undetected_total = null;
		$refused_total    = null;
		$query_total      = null;
		foreach ( $api_key_stats as $day ) {
			$proxy_total      = $day->proxies + $proxy_total;
			$vpn_total        = $day->vpns + $vpn_total;
			$undetected_total = $day->undetected + $undetected_total;
			$refused_total    = $day->{'refused queries'} + $refused_total;
			$query_total      = $proxy_total + $vpn_total + $undetected_total + $refused_total;
		}

		$response_api_month = array();
		$count_day           = 0;
		foreach ( $api_key_stats as $key => $value ) {
				$data                    = array();
				$data['days']            = $count_day++;
				$data['proxies']         = $value->proxies;
				$data['vpns']            = $value->vpns;
				$data['undetected']      = $value->undetected;
				$data['refused queries'] = $value->{'refused queries'};
				array_push( $response_api_month, $data );
		}
		$reverse_order = array_reverse( $response_api_month );
		$result        = wp_json_encode( $reverse_order );

		// Month stats graph.
		$html = '<script type="text/javascript">
                        var chart = AmCharts.makeChart("amchartAPImonth", {
                            "type": "serial",
                            "theme": "light",
                            "legend": {
                                "align": "center",
                                "equalWidths": false,
                                "periodValueText": "[[value.sum]]",
                                "valueAlign": "left",
                                "valueText": "[[value]]",
                                "valueWidth": 100
                            },
                            "dataProvider": ' . $result . ',
                            "plotAreaBorderAlpha": 0,
                            "marginLeft": 0,
                            "marginBottom": 0,
                            "chartCursor": {
                                "cursorAlpha": 0
                            },
                            "valueAxes": [{
                                "stackType": "regular",
                                "gridAlpha": 0.07,
                                "position": "left",
                                "title": "Day Total"
                            }],
                            "graphs": [{
                                "balloonText": "<span style=\'font-size:14px; color:#000000;\'><b>Undetected: [[value]]</b></span>",
                                "fillAlphas": 0.6,
                                "type": "smoothedLine",
                                "title": "Undetected",
                                "valueField": "undetected",
                                "stackable": false
                            }, {
                                "balloonText": "<span style=\'font-size:14px; color:#000000;\'><b>Proxies: [[value]]</b></span>",
                                "fillAlphas": 0.6,
                                "type": "smoothedLine",
                                "title": "Proxies",
                                "valueField": "proxies",
                                "stackable": false
                            }, {
                                "balloonText": "<span style=\'font-size:14px; color:#000000;\'><b>VPN\'s: [[value]]</b></span>",
                                "fillAlphas": 0.6,
                                "type": "smoothedLine",
                                "title": "VPN\'s",
                                "valueField": "vpns",
                                "stackable": false
                            }, {
                                "balloonText": "<span style=\'font-size:14px; color:#000000;\'><b>Refused Queries: [[value]]</b></span>",
                                "fillAlphas": 0.6,
                                "type": "smoothedLine",
                                "title": "Refused Queries",
                                "valueField": "refused queries",
                                "stackable": false
                            }],
                            "plotAreaBorderAlpha": 0,
                            "marginTop": 10,
                            "marginLeft": 0,
                            "marginBottom": 0,
                            "categoryField": "days",
                            "categoryAxis": {
                                "startOnAxis": true,
                                "axisColor": "#DADADA",
                                "gridAlpha": 0.07,
                                "title": "Days"
                            },
                             "guides": [{
                                category: "0",
                                lineColor: "#CC0000",
                                lineAlpha: 0,
                                dashLength: 2,
                                inside: true,
                                labelRotation: 90,
                                label: "Today",
                                position: "bottom"
                                }, {
                                category: "1",
                                lineAlpha: 0,
                                lineColor: "#CC0000",
                                dashLength: 2,
                                inside: true,
                                labelRotation: 90,
                                label: "Yesterday",
                                position: "bottom"
                                }, {
                                category: "28",
                                lineColor: "#CC0000",
                                lineAlpha: 0,
                                dashLength: 2,
                                inside: true,
                                labelRotation: 90,
                                label: "A Month Ago",
                                position: "bottom",
                                expand: "true"
                                }]
                            });
                    </script>
                ';
		$html .= '<div id="amchartAPImonth" style="width: 100%; height: 400px;"></div>' . "\n";
		$html .= '<p>' . __( '*Statistics delayed by several minutes.', 'proxy-vpn-blocker' ) . '</p>' . "\n";
		$html .= '</div>' . "\n";
		// Get recent detection stats.
		$html .= '<div class="pvboptionswrap">' . "\n";
		$html .= '<h3>' . __( 'API Key Recent Positive Detections', 'proxy-vpn-blocker' ) . '</h3>' . "\n";
		$html .= '<div id="log_content"></div>' . "\n";
		$html .= '<form id="log_query_form" action="https://proxycheck.io/dashboard/export/detections/pvb.pagination.php" method="post" target="hiddenFrame">' . "\n";
		$html .= '<input type="hidden" id="api_key" name="api_key" value="' . $get_api_key . '">' . "\n";
		$html .= '<input type="hidden" id="page_number" name="page_number" value="0">' . "\n";
		$html .= '<button class="pvbdefault" style="float: right; margin-top: 10px" onclick="decrementValue()" type="submit">View Newer Entries >></button>' . "\n";
		$html .= '<button class="pvbdefault" style="margin-top: 10px" onclick="incrementValue()" type="submit"><< View Older Entries</button>' . "\n";
		$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";
		echo $html;
	}
} else {
	$html  = '<div class="wrap" id="' . $this->parent->_token . '_statistics">' . "\n";
	$html .= '<h1>' . __( 'Proxy &amp; VPN Blocker proxycheck.io Statistics', 'proxy-vpn-blocker' ) . '</h1>' . "\n";
	$html .= '<div class="pvberror">' . "\n";
	$html .= '<div class="pvberrortitle">' . __( 'Oops!', 'proxy-vpn-blocker' ) . '</div>' . "\n";
	$html .= '<div class="pvberrorinside">' . "\n";
	$html .= '<h2>' . __( 'Please set a <a href="https://proxycheck.io" target="_blank">proxycheck.io</a> API Key to see this page!', 'proxy-vpn-blocker' ) . '</h2>' . "\n";
	$html .= '<h3>' . __( 'This page will display stats about your API Key queries and recent detections.', 'proxy-vpn-blocker' ) . '</h3>' . "\n";
	$html .= '<h3>' . __( 'If you need an API Key they are free for up to 1000 daily queries, paid plans are available with more.', 'proxy-vpn-blocker' ) . '</h3>' . "\n";
	$html .= '</div>' . "\n";
	$html .= '</div>' . "\n";
	$html .= '</div>';
	echo $html;
}

/**
 * Function for stats table.
 */
function pagination_javascript() {
	$get_api_key = get_option( 'pvb_proxycheckio_API_Key_field' );
	?>
	<script type="text/javascript">
						jQuery(document).ready(function($) {
							$('#log_content').load("https://proxycheck.io/dashboard/export/detections/pvb.pagination.php?api_key=<?php echo $get_api_key; ?>");
						});
						jQuery('#log_query_form').submit(function(e) { // catch the form's submit event
							e.preventDefault();
							jQuery.ajax({ // create an AJAX call...
								data: jQuery(this).serialize(), // get the form data
								type: jQuery(this).attr('method'), // GET or POST
								url: jQuery(this).attr('action'), // the file to call
								success: function(response) { // on success..
									jQuery('#log_content').html(response); // update the DIV
								}
							}
						);
						return false; // cancel original event to prevent form submitting
						});
						function incrementValue() {
							var value = parseInt(document.getElementById('page_number').value, 10);
							value = isNaN(value) ? 0 : value;
							value++;
							document.getElementById('page_number').value = value;
						}
						function decrementValue() {
							var value = parseInt(document.getElementById('page_number').value, 10);
							value = isNaN(value) ? 0 : value;
							value--;
							if (value < 0) {
								value = 0;
							}
							document.getElementById('page_number').value = value;
						}
					</script> 
					<?php
}
add_action( 'admin_footer', 'pagination_javascript' );
