<?php
include "inc/app-top.php";

ob_start();

// added in v4.0.0
require_once "facebook/src/Facebook/autoload.php";
// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId         = '575772272841719'; //Facebook App ID
$appSecret     = '887e4b74cb387cd2612546c4dc73a3be'; //Facebook App Secret
$fbPermissions = array('email');  //Optional permissions
$redirectURL   = 'https://x-cow.com/sportevent/fbconfig.php'; //Callback URL

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.11',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
		$accessToken = $helper->getAccessToken($redirectURL);
    }
} catch(FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error 1: ' . $e->getMessage();
	exit;
}

if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Getting user facebook profile info
    try {
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } catch(FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error 2: ' . $e->getMessage();
        exit;
    }
    
	
	$sql = "SELECT * FROM users WHERE user_fb_id ='".$fbUserProfile['id']."'";
	$result = $mysqli->query($sql);
	if ($result->num_rows == 1) {
        while($row_user = $result->fetch_assoc()) {    
            $user_id = $row_user["user_id"];
        }
//		$sql1 = "UPDATE users SET user_email = '".$fbUserProfile['email']."', user_fb_id = '".$fbUserProfile['id']."'";
//		$result1 = $mysqli->query($sql1);
        $_SESSION["id"] = $user_id;
        $_SESSION["fbid"] = $fbUserProfile['id'];
        if(isset($_SESSION["fbid"])){
		  header("Location: index.php?msg=1");
        }
	} else {
//		$sql1 = "INSERT INTO users (user_full_name, user_email, user_fb_id, user_created_at) VALUES ('".$fbUserProfile['first_name']." ".$fbUserProfile['last_name']."', '".$fbUserProfile['email']."','".$fbUserProfile['id']."','".date("Y-m-d H:i:s")."')";
//		$result1 = $mysqli->query($sql1);
        
        $_SESSION['fbid'] = $fbUserProfile['id'];
        $_SESSION['email'] = $fbUserProfile['email'];
        $_SESSION['fname'] = $fbUserProfile['first_name'];
        $_SESSION['lname'] = $fbUserProfile['last_name'];
        $_SESSION['picture'] = $fbUserProfile['picture']['url'];
        
		header("Location: login.php");
	}
}else{
    // Get login url
    $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
	header("Location: ".$loginURL);
}
?>