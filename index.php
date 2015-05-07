<?php
//config for php server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//make constants using define
define('clientID', 'a961d8bb8147413396a2257206bbdb1e');
define('clientSecret', 'ebacc95ad11f4d588492f5a6c38953b4');
define('redirectURI', 'http://localhost/NateAPI/index.php');
define('ImageDirectory', 'pics/');




?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<!--creating a login to go and give approval to access instagram profile
	after approval, now the information are usable.  -->
	<a href="https:api.instagram.com/oauth.authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code/">LOGIN</a>
</body>
</html>