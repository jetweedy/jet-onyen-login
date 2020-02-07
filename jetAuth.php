<?php

ini_set('display_errors', 1);

class jetAuth {
	
	var $Handshake = "";
	var $Options = array();

	function __construct($options=NULL) {
		$this->Options = $options;
		// Create a handshake session if none
		if ( !isset($_SESSION['jetAuth_Handshake']) ) {
			$this->clearHandshake();
		} else {
			$this->Handshake = $_SESSION['jetAuth_Handshake'];
		}
	}

	static function isLocal() {
		return (substr($_SERVER['HTTP_HOST'],0,9)=="localhost");
	}
	
	static function grabVar($v) {
		$r = "";
		if (isset($_GET[$v])) { $r = $_GET[$v]; }
		if (isset($_POST[$v])) { $r = $_POST[$v]; }
		$ts = "".$r;
		return $r;
	}

	static function getCurl($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$r = curl_exec($curl);
		curl_close($curl);
		return $r;
	}	

	static function postCurl($url,$fields) {
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, $url);
		curl_setopt($curl,CURLOPT_POST, count($fields));
		curl_setopt($curl,CURLOPT_POSTFIELDS, $fields);		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$r = curl_exec($curl);
		curl_close($curl);
		return $r;
	}	

	
	function generateHandshake() {
		$this->Handshake = substr(md5(rand()), 0, 10);
		$_SESSION['jetAuth_Handshake'] = $this->Handshake;
	}
	
	function clearHandshake() {
		$this->Handshake = "";
		$_SESSION['jetAuth_Handshake'] = "";
	}
	
	
	function checkHandshake($handshakeField) {
		print "[".$_SESSION['jetAuth_Handshake'] . "] | [".jetAuth::grabVar($handshakeField) . "]<hr />";
		if ($_SESSION['jetAuth_Handshake']==jetAuth::grabVar($handshakeField) 
				&& $_SESSION['jetAuth_Handshake']!="") {
//			$this->clearHandshake();
			return true;		
		}
		return false;
	}
	
	
}

?>