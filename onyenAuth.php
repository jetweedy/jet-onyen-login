<?php
//// https://onyen.unc.edu/cgi-bin/unc_id/authenticator.pl

require_once(realpath(dirname(__FILE__)) . '/../../../wp-blog-header.php');

class onyenAuth extends jetAuth {

	function confirm($onyen) {
		$vURL = "https://onyen.unc.edu/cgi-bin/unc_id/authenticator.pl/" . jetAuth::grabVar('vfykey');
		$vResponse = jetAuth::getCurl($vURL);
//print "<pre>"; print_r($vResponse); print "</pre>";
		$vPattern = "/(.*?): pass.*?uid: [0-9]*.*?pid: [0-9]*/s";
		if (preg_match($vPattern,$vResponse,$match)) {
//print "<pre>"; print_r($match); print "</pre>";
			return ($match[1]==$onyen);
		}
		return false;
	}

	function checkWordpressUsername( $username ) {
//		print "checkWordpressUsername: " . $username . "<br />";
		return (!!username_exists($username));
	}


	function doWordpressLogout() {
		wp_logout();
	}

	function doWordpressLogin( $username ) {
//		ob_start();
	    // log in automatically
	    if ( !is_user_logged_in() ) {
	        $user = get_userdatabylogin( $username );
	        $user_id = $user->ID;
	        wp_set_current_user( $user_id, $user_login );
	        wp_set_auth_cookie( $user_id );
	        do_action( 'wp_login', $user_login );
	    }
//	    ob_end_clean();
//	    print "<pre>"; print_r($user); print "</pre>";
//		die;
	}	
	
}


?>