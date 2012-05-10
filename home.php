<?php

//Always place this code at the top of the Page
session_start();
if (!isset($_SESSION['id'])) {
    // Redirection to login page twitter or facebook
    header("location: index.php");
}

require 'db/functions.php';
require 'src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => ' ', // Add your FB App ID here
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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
  xmlns:fb="https://www.facebook.com/2008/fbml">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>My Great App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    
  </head>

  <body style="background:url(https://lh6.googleusercontent.com/-obBgN3vk1qs/TlOaB41zkcI/AAAAAAAAFJs/a34UV_6PfLw/grids.gif)">
  <a target="_blank" href="https://github.com/bkvirendra/My-Great-App"><img style="position:absolute; top: 0; right: 0; border: 0; z-index:99999" src="https://a248.e.akamai.net/camo.github.com/e6bef7a091f5f3138b8cd40bc3e114258dd68ddf/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub"></a>
  <div id='fb-root'></div>
    <script src='http://connect.facebook.net/en_US/all.js'></script>

	  <div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="#">My Great App</a>
	        </div>
	      </div>
	    </div>
	
  <div class="container">
	<div class="row-fluid">
		<div class="span12">

			<div class="hero-unit">
				<?php 
					echo '<h1>Welcome '. $_SESSION['username'] .'</h1><br />';
					echo '<div id="profile" style="padding-right:25px; float: right;"><img style="border:1px solid rgb(204, 204, 204); cursor: pointer;" src="http://graph.facebook.com/'. $_SESSION['uid'] .'/picture?type=normal"></div>';
					echo '<p>Your User ID : ' . $_SESSION['id'];
					echo '<br />Facebook UserID : ' . $_SESSION['uid'];
					echo '<br/>Email : ' . $_SESSION['email'];
					echo '</p><br />';
				?>
				
				<p>
					<a class="btn btn-success btn-large" onclick='postToFeed(); return false;'>Publish Feed</a>
				</p>

				<br />

				 <p>
				  <a class="btn btn-danger btn-large" href="logout.php">Logout</a>
				 </p>
			</div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
	 <div class="container">
        <p>&copy; A Virendra Rajput Production</p>
	</div>
      </footer>

    </div><!--/.fluid-container-->

	    <script> 
      FB.init({appId: "<?php echo $facebook->getAppID();?>", status: true, cookie: true});

      function postToFeed() {

        // calling the API ...
        var obj = {
          method: 'feed',
          link: 'http://teckzone.in/myfbapps/mygreatapp/',
          picture: 'http://www.allfacebook.com/wordpress/wp-content/uploads/2010/11/Facebook-Developers-Logo.png',
          name: 'My Great App',
          caption: 'My Great Logo',
          description: 'Using Dialogs to interact with users.'
        };

        function callback(response) {
          
        }

        FB.ui(obj, callback);
      }
    
    </script>


  </body>
</html>

