<!--<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '256058491685947',
      xfbml      : true,
      version    : 'v3.1'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     //js.src = "https://connect.facebook.net/en_US/sdk.js";
	 js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
-->


<script type="text/javascript">
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "http://connect.facebook.net/en_US/all.js#version=v3.1&appId=256058491685947&status=true&cookie=true&xfbml=true";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script>
function facebook_login(){
	var fb_scope = 'public_profile,email'; 
	FB.login(function(response){
	  if(response.status == 'connected'){
			FB.api('/me', {fields: 'last_name,birthday,email,first_name,gender'}, function(response) {
				var dob = response.birthday ? response.birthday : '';
				var fb_data = {
					name: response.first_name + ' '+response.last_name,
					dob: dob,
					gender: response.gender == 'male' ? 'M' : 'F',
					email: response.email
				};
				$.ajax({
					url: '<?php echo base_url('api_login/facebook_check')?>',
					type: 'POST',
					data: fb_data,
					dataType: 'JSON',
					success: function(res){
						if(res.status == 1){
							location.href = '<?php echo base_url('dashboard/')?>';
						}
					}
				});
			});
	  }else{

	  }
	  //console.log(response);
	}, {scope: fb_scope, auth_type: 'rerequest', return_scopes: true});
}
</script>