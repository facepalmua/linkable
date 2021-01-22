jQuery(document).ready(function($) {
	
		var x = document.cookie;

		var match = document.cookie.match(new RegExp('(^| )' + 'dashboardVideo' + '=([^;]+)'));
			
		if (match) {
			if (match[2] !== 'closed') {
				$(".intro-video-wrap").show();
				$(".intro-video-wrap").removeClass('closed');
				
				
				} else {
					
				$(".show-hide-dash-intro").html("Show welcome message<i class='fa fa-angle-down'></i>");
				} 
		} else {
			$(".intro-video-wrap").show();
			$(".intro-video-wrap").removeClass('closed');
		}
	
	
	
	$(".show-hide-dash-intro").click(function(){
		$(".show-hide-wrap").slideToggle();
		$(".intro-video-wrap").toggleClass("closed");
		
		if($(".intro-video-wrap").hasClass('closed') ) {
			$(".show-hide-dash-intro").html("Show welcome message<i class='fa fa-angle-down'></i>");
			document.cookie = "dashboardVideo=closed";
		} else {
			$(".show-hide-dash-intro").html("Hide welcome message<i class='fa fa-angle-up'></i>");
			document.cookie = "dashboardVideo=open";
		}
		
	})
	
	//add to user dropdown
	$(".fre-account.dropdown ul.dropdown-menu").prepend('<li><a href="'+document.location.origin+'/dashboard/">DASHBOARD</a></li>');
});

