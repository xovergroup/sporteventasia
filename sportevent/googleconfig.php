<?php
require_once 'lib/Google_Client.php';
require_once 'lib/Google_Oauth2Service.php';

/*
------------------------------------------------------
  www.idiotminds.com
--------------------------------------------------------
*/


// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
define('CLIENT_ID','166814898574-d3akodmq2ogh3ua45p71qes5a7pa4nst.apps.googleusercontent.com');
define('CLIENT_SECRET','Cp3fj_fyJmxN1HvboNf4GqQf');
define('REDIRECT_URI','https://x-cow.com/sportevent/googleconfig.php');
define('APPROVAL_PROMPT','auto');
define('ACCESS_TYPE','offline');


$client = new Google_Client();
$client->setApplicationName("sportevent");

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setApprovalPrompt(APPROVAL_PROMPT);
$client->setAccessType(ACCESS_TYPE);

$oauth2 = new Google_Oauth2Service($client);

if(isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();
	echo '<script type="text/javascript">window.close();</script>';
	exit;
}

if(isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}

if(isset($_REQUEST['error'])) {
	echo '<script type="text/javascript">window.close();</script>';
	exit;
}

if($client->getAccessToken()) {
	$user = $oauth2->userinfo->get();

	// These fields are currently filtered through the PHP sanitize filters.
	// See http://www.php.net/manual/en/filter.filters.sanitize.php
	$email = filter_var($user['email']);
	$id = filter_var($user['id']);
	$username = filter_var($user['given_name']);

	// The access token may have been updated lazily.
	$_SESSION['token'] = $client->getAccessToken();
	$_SESSION["email"] = $email;

	//unset($_SESSION['token']);
	$client->revokeToken();

	//$client = new Google_Client();
	$sql = "SELECT * FROM users WHERE user_email ='$email'";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		echo "<script>window.top.location='index.php'</script>";
	} else {
		$sql1 = "INSERT INTO users (user_full_name, user_email, user_google_id) VALUES ('$username','$email','$id')";
		if($mysqli->query($sql1)) {
			echo "<script>window.top.location='index.php'</script>";
		}
	}
} else {
	$authUrl = $client->createAuthUrl();
}

?>