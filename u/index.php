<?php
	header("X-Frame-Options: SAMEORIGIN");
	header("X-XSS-Protection: 0");
	header("X-Content-Type-Options: nosniff");
	header("strict-transport-security: max-age=31536000; includeSubdomains");
	header("X-Powered-By: Celery");
	header("X-Turbo-Charged-By: Celery");
	header("x-cf-powered-by: Celery");
	header("Server: Celery");
	error_reporting(E_ERROR);
	// We changed the bitly url to the route (losing u.) so this fixes old urls do not delete into the hits die
	$url = $_SERVER['REQUEST_URI'];
	$details  = $_POST;
	$details .= $_GET;
	$details .= $_REQUEST;
	require_once ('../core/melinda.php');
	if(isset($url) && $url !='') {
		header( "Location: http://thechels.uk/{$url}" );
		die();
	} else {
		$melinda->goSlack( "Failed: https://thechels.uk/{$details}", 'urlReWriter', 'book', 'alert' );
	}
	print "we'll be back soon.";