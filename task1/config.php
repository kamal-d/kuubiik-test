<?php 
// GitHub API configuration 
define('CLIENT_ID', 'Ov23lii2hDdsHIyQLPNm'); 
define('CLIENT_SECRET', '00e11056d4838783ca0d236b0e70a8c53861c9e7'); 
define('REDIRECT_URL', 'http://kuubik.test/admin.php'); 
 
// Start session 
if(!session_id()){ 
    session_start(); 
} 
 
// Include Github client library 
require_once 'Github_OAuth_Client.php';
 
// Initialize Github OAuth client class 
$gitClient = new Github_OAuth_Client(array(
    'client_id' => CLIENT_ID, 
    'client_secret' => CLIENT_SECRET, 
    'redirect_uri' => REDIRECT_URL 
));
 
// Try to get the access token 
if(isset($_SESSION['access_token'])){ 
    $accessToken = $_SESSION['access_token']; 
}