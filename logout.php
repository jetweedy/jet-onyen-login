<?php
require_once("jetAuth.php");
require_once("onyenAuth.php");
$oa = new onyenAuth();
$oa->doWordpressLogout();
$_SESSION['UNC_ONYEN'] = NULL;
?>
	<script type='text/javascript'>
	window.opener.location.reload();
	setTimeout(function() {
		window.close();
	}, 300);
	</script>


