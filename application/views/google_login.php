<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>

<script>

// Called when Google Javascript API Javascript is loaded
function HandleGoogleApiLibrary() {
	// Load "client" & "auth2" libraries
	gapi.load('client:auth2', {
		callback: function() {
			// Initialize client library
			// clientId & scope is provided => automatically initializes auth2 library
			gapi.client.init({
		    	apiKey: 'AIzaSyDuIxpJQIrmvMXu_LFoiFccw1lpDF8_v0E',
		    	clientId: '277431235340-712vdird95p6sangoglc8buon6h35m4k.apps.googleusercontent.com',
		    	scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
			}).then(
				// On success
				function(success) {
			  		// After library is successfully loaded then enable the login button
			  		$("#login-button").removeAttr('disabled');
					$("#login-button").show();
				}, 
				// On error
				function(error) {
					/* alert('Error : Failed to Load Library'); */
			  	}
			);
		},
		onerror: function() {
			// Failed to load libraries
		}
	});
}

// Click on login button
$("#login-button").on('click', function() {
	$("#login-button").attr('disabled', 'disabled');
			
	// API call for Google login
	gapi.auth2.getAuthInstance().signIn().then(
		// On success
		function(success) {
			// API call to get user information
			gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
				// On success
				function(success) {
					console.log(success);
					var user_info = JSON.parse(success.body);
					console.log(user_info);

					/* $("#user-information div").eq(0).find("span").text(user_info.displayName);
					$("#user-information div").eq(1).find("span").text(user_info.id);
					$("#user-information div").eq(2).find("span").text(user_info.gender);
					$("#user-information div").eq(3).find("span").html('<img src="' + user_info.image.url + '" />');
					$("#user-information div").eq(4).find("span").text(user_info.emails[0].value);

					$("#user-information").show(); */
					
					var google_data = {
						id: user_info.id,
						last_name: user_info.name.familyName,
						first_name: user_info.name.givenName,
						email: user_info.emails[0].value,
					};
					$.ajax({
						url : '<?php echo base_url('api_login/google_login')?>',
						data: google_data,
						type: 'POST',
						dataType: 'json',
						success: function(res){
							if(res.status == 1){
								if(res.next){
									location.href = res.next;
								}else{
									location.reload();
								}
							}
							
						}
					});
					
					$("#login-button").hide();
				},
				// On error
				function(error) {
					$("#login-button").removeAttr('disabled');
					alert('Error : Failed to get user user information');
				}
			);
		},
		// On error
		function(error) {
			$("#login-button").removeAttr('disabled');
			alert('Error : Login Failed');
		}
	);
});

</script>