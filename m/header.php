<?php
	header("X-Frame-Options: SAMEORIGIN");
	header("X-XSS-Protection: 0");
	header("X-Content-Type-Options: nosniff");
	header("strict-transport-security: max-age=31536000; includeSubdomains");
	header("X-Powered-By: Celery");
	header("X-Turbo-Charged-By: Celery");
	header("x-cf-powered-by: Celery");
	header("Server: Celery");
?>
<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<title>ChelseaStats Mobile Web App</title>
<link rel="dns-prefetch" href="//thechels.co.uk">
<link rel="dns-prefetch" href="//maxcdn.bootstrapcdn.com">
<style>html,body,*{padding:0;margin:0;font-weight:300;font-family:-apple-system-font, 'San Francisco', 'Helvetica Neue', helvetica, calibri, sans-serif}h2{font-size:24px}h2,h3{padding:18% 10%}h3{font-size:18px} .thanks ul li h3{padding:10%}a:hover{color:#000}.clear{float:none;clear:both}p{font-size:14px;font-weight:300;color:#326ea1;margin-left:12%}ul{list-style:none}ul li{display:block;float:left;padding:0;height:auto}.header{position:fixed;left:0;top:0;min-width:100%;max-width:100%;background-color:#326ea1;color:#fff;font-weight:500;text-align:center;font-family:Helvetica,Arial,sans-serif;margin:0 auto;height:52px;font-size:17px;line-height:21px;z-index:1000}.banner{margin-top:52px}.banner,.thanks{position:relative;width:100%;overflow:hidden}.thanks{margin-top:36px}.banner ul{width:300%}.banner ul li{width:33%}.thanks ul,.thanks ul li{width:100%}.menu{position:relative;padding-top:52px;vertical-align:bottom}.fl{position:absolute;left:5px;bottom:5px;z-index:20}.fc{left:50%;bottom:10px;margin-left:-50%;width:100%;z-index:10}.fc,.fr{position:absolute}.fr{right:5px;bottom:5px;z-index:20}a{color:#fff;display:block;padding:5px} .sharers a, .sharers a:hover {color:#326ea1; } .rwd-line { display:inline-block;}</style>
<meta name="viewport" content="initial-scale=1.0, width=device-width, minimum-scale=1.0, maximum-scale=1.0, minimal-ui">
<meta name="google-site-verification" content="znVpBVN29ejrxrUEfv9bPBv6Lh5WhcWLBA4lVjfUCSM" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="application-name" content="ChelseaStats">
<meta name="application-url" content="https://m.thechels.uk">
<meta name="author" content="ChelseaStats">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="ChelseaStats">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="address=no">
<meta name="HandheldFriendly" content="True">
<meta name="keywords" content="Chelsea FC Stats curated in a mobile web application by @ChelseaStats CFC">
<meta name="description" content="Chelsea FC Stats curated in a mobile web application by @ChelseaStats CFC">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/img/favicon-msapplication-tileimage.png">
<meta name="msapplication-tooltip" content="ChelseaStats" />
<meta name="pinterest" content="nopin"/>
<!-- Open Graph Meta Data -->
<meta property="og:site_name" 		content="ChelseaStats">
<meta property="og:title" 		content="ChelseaStats">
<meta property="og:type" 		content="website">
<meta property="og:url" 		content="https://m.thechels.uk">
<meta property="og:description" 	content="Simple, lightweight mobile web app of curated Chelsea FC statistics by @ChelseaStats">
<meta property="og:image" 		content="https://m.thechels.uk/img/twitter-card.gif">
<!-- Twitter Card Meta Data -->
<meta name="twitter:card" 		content="summary_large_image">
<meta name="twitter:site" 		content="https://m.thechels.uk">
<meta name="twitter:creator" 		content="@ChelseaStats">
<meta name="twitter:title" 		content="ChelseaStats">
<meta name="twitter:description" 	content="Simple, lightweight mobile web app of curated Chelsea FC statistics by @ChelseaStats">
<meta name="twitter:image" 		content="https://m.thechels.uk/img/twitter-card.gif">
<!-- iPad, retina, portrait -->
<link href="/img/apple-touch-startup-image-1536x2008.png"
      media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image">
<!-- iPad, retina, landscape -->
<link href="/img/apple-touch-startup-image-1496x2048.png"
      media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image">
<!-- iPad, portrait -->
<link href="/img/apple-touch-startup-image-768x1004.png"
      media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)"
      rel="apple-touch-startup-image">
<!-- iPad, landscape -->
<link href="/img/apple-touch-startup-image-748x1024.png"
      media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)"
      rel="apple-touch-startup-image">
<!-- iPhone 5 -->
<link href="/img/apple-touch-startup-image-640x1096.png"
      media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image">
<!-- iPhone, retina -->
<link href="/img/apple-touch-startup-image-640x920.png"
      media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"
      rel="apple-touch-startup-image">
<!-- iPhone -->
<link href="/img/apple-touch-startup-image-320x460.png"
      media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)"
      rel="apple-touch-startup-image">
<link rel="apple-touch-icon-precomposed" sizes="57x57"      href="/img/apple-touch-icon-iphone.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"      href="/img/apple-touch-icon-ipad.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"    href="/img/apple-touch-icon-iphone4.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144"    href="/img/apple-touch-icon-ipad3.png">
<link rel="Shortcut Icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script defer async src="js/app.min.js"></script>
</head><body>
