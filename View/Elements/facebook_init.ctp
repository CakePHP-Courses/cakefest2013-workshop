<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	// init the FB JS SDK
	FB.init({
		appId : <?= Configure::read('Facebook.appId'); ?>,
		status : true,
		xfbml: true
	});
	FB.Event.subscribe('auth.login', function(response) {
		if (response.status === 'connected') {
			$.post('/users/login', {fb_token: response.authResponse.accessToken});
		}
	});
  };
  // Load the SDK asynchronously
  (function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

