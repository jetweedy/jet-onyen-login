<?php
//require_once("../../includes/config.php");
//require_once("../../includes/fun.php");
require_once("../jetAuth.php");
require_once("../onyenAuth.php");
$oa = new onyenAuth();

//// This grabs the 'uid' variable from the headers (provided by shibboleth)
$headers = getallheaders();

//print "<pre>";	print_r($headers);	die;

$uid = "";
if (isset($headers['uid'])) {
	$uid = $headers['uid'];
	$uid = trim($uid);
}
//// On my local box, this takes ?uid=xxx and sets the uid to xxx (so I can log in on my local dev box without a shibboleth installation)
if ($uid=="" && jetAuth::isLocal() && isset($_GET['uid'])) {
	$uid = $_GET['uid'];
}
//// Trims the uid (in case it's got whitespace around it)
$uid = trim($uid);

print "[" . $uid . "]";

//// If it's not blank, 
if ($uid!="") {
	//// Set the session (accessible outside of this shibboleth-protected folder) UID
	$_SESSION['UNC_ONYEN'] = $uid;
	//// This uses my onyenAuth library (in outside folder) to check the now-known onyen against
	//// the usernames that are in the WordPress database
	//// If it is found, then that user is logged in in Wordpress using the same library
	if ($oa->checkWordpressUsername($_SESSION['UNC_ONYEN'])) {
		//$oa->doWordpressLogout();
		$oa->doWordpressLogin($_SESSION['UNC_ONYEN']);
	}
	
	//// Closes the pop-up window and refreshes the parent that loaded it
	//// (to get a refreshed logged-in view)
	echo "
		<script type='text/javascript'>
		window.opener.location.reload();
		setTimeout(function() {
			window.close();
		}, 2000);
		</script>
	";
} else {
	//// Otherwise the login failed, so it just closes the window
	//// but no reason to refresh the parent page
	echo "
		<script type='text/javascript'>
		alert('Login unsuccessful.');
		window.opener.location.reload();
		setTimeout(function() {
			window.close();
		}, 2000);
		</script>
	";
}

	

?>