<?php
/**
 * @package JET_Onyen_Login
 * @version 1.7.2
 */
/*
Plugin Name: JET Onyen Login
Plugin URI: https://github.com/jetweedy/
Description: A super simple plugin to facilitate Onyen logins on CloudApps using Shibboleth.
Author: Jonathan Tweedy
Version: 1.0.0
Author URI: https://jonathantweedy.com/
*/

// ==================================================================================

// -----------------------------------------------------
// CONFIG OPTIONS:
// -----------------------------------------------------
$__JET_ONYEN_LOGIN_ADMIN_USERNAME = "admin";
$__JET_ONYEN_LOGIN_DIRECTORY = "/wp-content/plugins/jet-onyen-login";
// -----------------------------------------------------

// ==================================================================================

// -----------------------------------------------------
// Options for future considerations
// -----------------------------------------------------
/*
 ___ Enable variables for the configurations above
 ___ 
*/
// -----------------------------------------------------


// ==================================================================================

if (session_id() == '') { session_start(); $_SESSION['UNC_ONYEN']==NULL; } 

function jet_onyen_login() {
	global $__JET_ONYEN_LOGIN_DIRECTORY;
	global $__JET_ONYEN_LOGIN_ADMIN_USERNAME;
	$html = "";
	$html .= "<div class='jet-onyen-login'>";
	if ( true || !isset($_SESSION['UNC_ONYEN']) || $_SESSION['UNC_ONYEN']==NULL || !$_SESSION['UNC_ONYEN'] ) {
		require_once("jetAuth.php");
		require_once("onyenAuth.php");
		$oa = new onyenAuth(array());
		$oa->generateHandshake();
		if (jetAuth::isLocal()) {
			$html = "<a href='{$__JET_ONYEN_LOGIN_DIRECTORY}/secured/?uid=".$__JET_ONYEN_LOGIN_ADMIN_USERNAME."' target='_blank');'>ONYEN login</a>";
		} else {
			$html = "<a href='{$__JET_ONYEN_LOGIN_DIRECTORY}/secured' target='_blank');'>ONYEN login</a>";
		}
	} else {
		$html = "";
//		$html .= "<a>{$_SESSION['UNC_ONYEN']}</a> | ";
//		$html .= "<a href='/wp-admin' target='_blank'>Wordpress Admin</a> | ";
		$html .= "<a href='/wp-content/plugins/jet-onyen-login/logout.php' target='_blank'>ONYEN logout</a>";
	}
	$html .= "</div>";
	return $html;
}
add_shortcode( 'jet-onyen-login', 'jet_onyen_login' );

