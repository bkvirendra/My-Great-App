<?php

session_start();
if (isset($_SESSION['id'])) {
    header("location: home.php");
}

require 'src/facebook.php';
require 'db/functions.php';

$facebook = new Facebook(array(
  'appId'  => ' ', // Add your APP ID here
  'secret' => ' ', // Add your App secret here
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

$params = array(
  'scope' => 'email',
  'redirect_uri' => ' ' // Add your Redirect URI Here
);

$loginUrl = $facebook->getLoginUrl($params);

?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>My Great App</title>
  <meta name="description" content="">

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	
	
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
  
  	<?php 
    if (!empty($user_profile )) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
        $username = $user_profile['name'];
		$uid = $user_profile['id'];
		$email = $user_profile['email'];
        $user = new User();
        $userdata = $user->checkUser($uid , $email, $username);
        if(!empty($userdata)){
            $_SESSION['id'] = $userdata['id'];
			$_SESSION['uid'] = $uid;
            $_SESSION['username'] = $userdata['username'];
			$_SESSION['email'] = $email;
            header("Location: home.php");
        } else {
			# For testing purposes, if there was an error, let's kill the script
			die("There was an error.");
		}
	} else {
		 # There's no active session, let's generate one
		echo "<script>setTimeout(function() { top.location.href = '$loginUrl' }, 5000);</script>";
   }

   ?>
  
  <script>
	setTimeout(function() { top.location.href = "<?php echo $loginUrl; ?>" }, 5000);
  </script>
</head>
<body style="background:url(https://lh6.googleusercontent.com/-obBgN3vk1qs/TlOaB41zkcI/AAAAAAAAFJs/a34UV_6PfLw/grids.gif)">

	<h1 align="center">Please Wait while we authenticate you...</h1>


  <div id="fb-root"></div>
    <script>
      // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?php echo $facebook->getAppID();?>', // App ID
          channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });

        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook
            FB.api('/me', function(me){
              if (me.name) {
              }
            })
          } else {
            // user has not auth'd your app, or is not logged into Facebook
			window.location.href = '<?php echo $loginUrl;?>';
          }
        });

        // respond to clicks on the login and logout links
        document.getElementById('auth-loginlink').addEventListener('click', function(){
          FB.login(function(response) {
			window.location.reload();
		}, {scope: 'email'});
        });
        document.getElementById('auth-logoutlink').addEventListener('click', function(){
          FB.logout();
        }); 
      }
    </script>

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</body>
</html>
