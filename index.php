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

if (isset($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
									'client_secret' => clientSecret,
									'grant_type' => 'authorization_code',
									'redirect_uri' =>redirectURI,
									'code' => $code
									);

//cURL is a library that calls to other APIs for interaction 
$curl = curl_init($url); //setting a curl session and inputing $url to access data from instagram
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings); //setting the postfields to the array settup
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //settig equal to 1 because strings are being returned
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //verify the curl is actually there. in live-work production it would be set to true
}

$result = curl_exec($curl);
curl_close();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<!--creating a login to go and give approval to access instagram profile
	after approval, now the information are usable.  -->
	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>