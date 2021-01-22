    jQuery(document).ready(function(){
 
        jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
	        
	        console.log('confirmation loaded');
	        
            if(formId == 1) {
	            console.log('we are on form 1');
                // client registration
                window.intercomSettings = {
				  email: "bob@example.com",
				  user_id: "123",
				  app_id: "abc1234",
				  created_at: 1234567890,
				  "subdomain": "intercom", // Put quotes around text strings
				  "teammates": 4, // Send numbers without quotes
				  "active_accounts": 12,
				  "last_order_at" : 1350466020, // Send dates in unix timestamp format and end key names with "_at"
				  "custom_domain": null // Send null when no value exists for a user
				}
                
            } else if(formId == 2) {
                // author registration
            }
        });
 
    })


