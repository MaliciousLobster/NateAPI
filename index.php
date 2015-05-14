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

//function that connects to insta
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2,
		));
	$result= curl_exec($ch);
	curl_close($ch);
	return $result;
}

//function to get userID
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q=' . $userName . '&client_id=' . clientID;
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);

	return $results['data'][0]['id'];
}

//function to print out images onto the screen
function printImages($userID){
	$url = 'https://api.instagram.com/v1/users/' . $userID . '/media/recent?client_id=' . clientID . '&count=5';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//parse in info one by one
	foreach ($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url']; //goes through the results and returns an url and saves it to the PHP server
		echo '<img src=" ' . $image_url . ' "/><br/>';
		//calling a function to save the $image_url
		savePictures($image_url);
	}
}

function savePictures($image_url){
	echo $image_url . '<br/>';
	$filename = basename($image_url); //where the images are getting stored
	echo $filename . '<br/>';

	$destination = ImageDirectory . $filename; //making the sure the image doesn't already exist in the file
	file_put_contents($destination, file_get_contents($image_url)); //goes in and grabs the images and stores it in the file
}

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



$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName);

printImages($userID);

}
else{

?>
<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <meta charset="UTF-8">
	<title></title>
</head>
<body>
	<!--creating a login to go and give approval to access instagram profile
	after approval, now the information are usable.  -->
	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a>
</body>
</html>
<?php
}
?>