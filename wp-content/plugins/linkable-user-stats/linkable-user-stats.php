<?php
/**
 * Plugin Name: Link-able User Stats
 * Description: Display dashboard stats for link-able users
 * Version: 1.01
 * Author: Anne Schmidt
 * Author URI: https://anneschmidt.co
 */
 
 //enqueue canvasjs for graph
function enqueue_canvas() {   
    wp_enqueue_script( 'canvasjs', plugin_dir_url( __FILE__ ) . 'node_modules/chart.js/dist/Chart.js' );
    wp_enqueue_script( 'dashboard-stat-scrips', plugin_dir_url( __FILE__ ) . 'linkable-user-stats.js' );
}
add_action('wp_enqueue_scripts', 'enqueue_canvas');

//styles
function dashboard_stat_styles() 
{
    wp_enqueue_style( 'dashboard_css', plugin_dir_url( __FILE__ ) . 'style.css', '1.1' );

}

add_action('wp_enqueue_scripts', 'dashboard_stat_styles');
 
 /* ############################################ OWNER STATS  ############################################ */
 
 add_shortcode('user_first_name','user_first_name');
 function user_first_name() {
	 $current_user = get_currentuserinfo();
	 
	 return $current_user->user_firstname;
 }

 $links_last_month = array();
 
 /* ------------- # of projects posted ----------------- */
 
 function owner_projects() {
 	$projects_posted = count_user_posts( get_current_user_id() , "project"  );
 	return 'Number of projects posted: ' . $projects_posted . '<br>';

 	}
 add_shortcode('owner_projects','owner_projects');
 
 
 
 function owner_links_built() {
	 //number of accepted bids, excluding any cancelled bids
	 
	 //loop through all projects by owner
	 //get number of accepted bids
	 //subtract any cancelled bids
 }
 
 add_shortcode('owner_links_built','owner_links_built');
 
 
 
 
function owner_pending_apps() {
	
	global $links_last_month;
	
	$num_pending = 0;
	$num_total = 0;
	$num_cancelled = 0;
	$num_accepted = 0;
	$num_projects = 0;
	
	 $employer_current_project_query = new WP_Query(
			array(
				'posts_per_page' => -1,
				'is_author'        => true,
				'post_type'        => PROJECT,
				'author'           => get_current_user_id(),
				'suppress_filters' => true,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'paged'			   => $paged
			)
				
		);
	
	//loop through all projects by owner
 	//get total number of pending bids
 	if ( $employer_current_project_query->have_posts() ) {
	 	
	 	
	 	while ( $employer_current_project_query->have_posts() ) : $employer_current_project_query->the_post(); 
	 	
	 		$num_projects++;
	 	
	 		$bid_query = new WP_Query( array(
					'post_type'      => 'bid',
					'post_parent'    => get_the_ID(),
					'posts_per_page' => -1
				)
			);
			
			if ( $bid_query->have_posts() ) : while ( $bid_query->have_posts() ) : $bid_query->the_post();
			
				$num_total++;
	
	 				if ( get_post_status() == 'publish') {
		 			
		 				$num_pending++;
	 				}
	 				
	 				if ( ( get_post_status() == 'completion' || get_post_status() == 'pending-completion') && get_post_status() !== 'cancelled') {
		 			
		 				$num_accepted++;
		 				
		 				$date_accepted = get_field('date_accepted',get_the_ID());
		 				$date_accepted = date("n/j", strtotime($date_accepted));
		 				array_push($links_last_month,$date_accepted);
		 				
		 				
	 				}
	 				
	 				if ( get_post_status() == 'cancelled') {
		 			
		 				$num_cancelled++;
	 				}
	 				
	 			endwhile;
	 		endif;
	 	
	 	endwhile;
	 	
	}
	
	$output = '<div class="col"><strong>Total # of links built:</strong><div class="num">' . $num_accepted . '</div><a href="'.get_home_url().'/my-projects/completed/">See all</a></div>';
	$output .= '<div class="col"><strong>Projects posted:</strong><div class="num">' . $num_projects . '</div><a href="'.get_home_url().'/my-projects/">View all</a></div>';
	$output .= '<div class="col"><strong>Contracts received:</strong><div class="num">' . $num_total . '</div><a href="'.get_home_url().'/my-projects/">View all</a></div>';
	$output .= '<div class="col"><strong>Pending Contracts:</strong><div class="num">' . $num_pending . '</div><a href="'.get_home_url().'/my-projects/pending-application/">View all</a></div>';
	
	/*$output .= 'Number of cancelled apps: ' . $num_cancelled . '<br>';
	$output .= 'Total links built: ' . $num_accepted . '<br>';
	$output .= ' Total number of apps: ' . $num_total;*/
	
	return $output;
	
	wp_reset_query();
	 	
 }
 
 add_shortcode('owner_pending_apps','owner_pending_apps');
 
  /* ############################################ AUTHOR STATS  ############################################ */
  	$user_id = get_current_user_id();
function custom_get_author_posts_count($user_id,$args ) {
	
		    $args['author'] = get_current_user_id();
		    $args['posts_per_page'] = -1;
		    $ps = get_posts($args);
		    return count($ps);
		}
		
$earnings_last_month = array();	
add_shortcode('author_stats','author_stats');

function author_stats() {
	global $earnings_last_month;
	
	$user_id = get_current_user_id();
	   $total_post_count = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'author' => get_current_user_id(),
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
		
		$num_active = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'post_status'=> 'accept',
		    'author' => $user_id,
		    'posts_per_page' => -1
		));
		
		$num_complete = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'post_status'=> 'complete',
		    'author' => $user_id,
		    'posts_per_page' => -1
		));
		
	$num_pending_complete = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'post_status'=> 'pending-completion',
		    'author' => $user_id,
		    'posts_per_page' => -1
		));
		
	$num_cancelled = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'post_status'=> 'cancelled',
		    'author' => $user_id,
		    'posts_per_page' => -1
		));
		
		$num_admin_review = custom_get_author_posts_count($user_id, array(
		    'post_type' =>'bid',
		    'post_status'=> 'admin-review',
		    'author' => $user_id,
		    'posts_per_page' => -1
		));
		
		$author_invoice_query = new WP_Query(
			array(
				'posts_per_page' => -1,
				'is_author'        => true,
				'post_type'        => 'invoices',
				'author'           => get_current_user_id(),
				'suppress_filters' => true,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'paged'			   => $paged
			)
				
		);
		
		$total_rev = 0;
		
		if ( $author_invoice_query->have_posts() ) : while ( $author_invoice_query->have_posts() ) : $author_invoice_query->the_post();
			
			$total_rev = $total_rev + floatval(get_field('amount'));
			
			$date_earn_array = array(
				"date" => get_the_date(),
				"amt" => get_field('amount')
			);
			
			array_push($earnings_last_month,$date_earn_array);
			
			endwhile;
		
		endif;
		
		$num_links_built = ($num_complete + $num_pending_complete);
		//$num_links_built = $num_admin_review;
		
		$num_active = $num_active + $num_admin_review;
		
	   $output = '<div class="col"><strong>Total revenue earned:</strong><div class="num">$' . number_format($total_rev) . '</div><a href="'.get_home_url().'/my-payments">View earnings</a></div>';
	   $output .= '<div class="col"><strong>Total links built:</strong><div class="num">' . $num_links_built . '</div><a href="'.get_home_url().'/my-applications/complete">View all</a></div>';
	   $output .= '<div class="col"><strong># of projects applied to:</strong><div class="num">' . $total_post_count . '</div><a href="'.get_home_url().'/my-applications">View all</a></div>';
	   $output .= '<div class="col"><strong>Active applications:</strong><div class="num">' . $num_active . '</div><a href="'.get_home_url().'/my-applications/active">View all</a></div>';
	   /*$output = 'Total app: ' . $total_post_count;
	   $output .= '<br/>Num active: ' . $num_active;
	   $output .= '<br/>Total rev: ' . $total_rev;
	   $output .= '<br/>Num links built: ' . $num_links_built;*/
	   return $output;
	   wp_reset_query();
   }
 
 
 //graph
 function show_graph() {
	 
	 global $links_last_month;
	 //print_r($links_last_month);
	 
	 $links_graph_data = array();
	 
	 $d = array();
	 for($i = 0; $i < 30; $i++)  {
	 	$d[] = date("n/j", strtotime('-'. $i .' days'));
	 	}
	 
	foreach ($d as $day_date) {
		$counter = 0;
		$counts = array_count_values($links_last_month);
		
		if(in_array($day_date,$links_last_month)) {
			//echo $day_date;
			//echo 'match';
			$counter = $counts[$day_date];
			
			
		}
		
		array_push($links_graph_data,$counter);

	}
	
	//print_r($links_graph_data);
	 
	 echo '<div style="height:400px;"><canvas id="myChart" width="400" height="200"></canvas></div>';
 	echo "<script>
 	var days = [];

 	var ctx = document.getElementById('myChart'); var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: " . json_encode($d) . ",
    datasets: [{ 
        data: " . json_encode($links_graph_data) . ",
        borderColor: '#1aad4b',
        fill: false
      }]},
    options:{
    title: {
      display: true,
      text: 'Number of backlinks acquired over the last 30 days',
      fontSize: 16,
      fontColor: '#4d4d4e',
      fontFamily: 'Roboto, sans-serif'
    },
    maintainAspectRatio: false,
    legend: {
        display: false
    },
    tooltips: {
	    displayColors: false,
            callbacks: {
                label: function(tooltipItems, data) {
                    return tooltipItems.yLabel.toString() + ' backlinks acquired';
                }
               }
              
              },

   scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
           suggestedMax: 10,
          callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }]
    }
  }
});

</script>";
	
	
	}
	
 add_shortcode('show_graph','show_graph');
 
 //author graph
  function show_author_graph() {
	 
	 global $earnings_last_month;

	 
	 $links_graph_data = array();
	 
	 $d = array();
	 for($i = 0; $i < 30; $i++)  {
	 	$d[] = date("n/j", strtotime('-'. $i .' days'));
	 	}
	 	
	 	$d = array_reverse($d);
	 
	foreach ($d as $day_date) {
		$counter = 0;
		//$counts = array_count_values($earnings_last_month);
		
		foreach($earnings_last_month as $e) {
			//echo $day_date;
			//echo $e['date'];
			
			$loop_date =  date("n/j", strtotime($e['date']));
			
			//echo $loop_date . '<br>';
			
			if($loop_date == $day_date) {
				
				$amt = intval($e['amt']);
				
				//echo $day_date;
				//echo 'match';
				$counter = $counter + $amt;
				
				
			}
		
			
		}
		
		array_push($links_graph_data,$counter);

	}
	
	//print_r($links_graph_data);
	 
	 echo '<div style="height:400px;"><canvas id="myChart" width="400" height="200"></canvas></div>';
 	echo "<script>
 	var days = [];

 	var ctx = document.getElementById('myChart'); var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: " . json_encode($d) . ",
    datasets: [{ 
        data: " . json_encode($links_graph_data) . ",
        borderColor: '#1aad4b',
        fill: false
      }]},
    options:{
    title: {
      display: true,
      text: 'Earnings over the last 30 days',
      fontSize: 16,
      fontColor: '#4d4d4e',
      fontFamily: 'Roboto, sans-serif'
    },
    maintainAspectRatio: false,
    legend: {
        display: false
    },
    tooltips: {
	    displayColors: false,
            callbacks: {
                label: function(tooltipItems, data) {
                    return '$' + tooltipItems.yLabel.toString() + ' earned';
                }
               }
              
              },
   scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          suggestedMax: 1400,
          callback: function(value) {if (value % 1 === 0) {return '$' + value;}}
        }
      }]
    }
  }
});
</script>";
	
	
	}
	
 add_shortcode('show_author_graph','show_author_graph');