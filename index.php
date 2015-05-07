<?php
//config for php server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//make constants using define
define('client_id', 'a961d8bb8147413396a2257206bbdb1e');
define('client_secret', 'ebacc95ad11f4d588492f5a6c38953b4');
define('redirectURI', 'http://localhost/NateAPI/index.php');
define('ImageDirectory', 'pics/');




?>
<!-- 
Info
CLIENT ID a961d8bb8147413396a2257206bbdb1e
CLIENT SECRET ebacc95ad11f4d588492f5a6c38953b4
WEBSITE URL http://localhost/NateAPI/index.php
REDIRECT URI http://localhost/NateAPI/index.php -->