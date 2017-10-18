<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$logs = [
		"Cron"          => 'error_log',
		"www"           => 'public_html/error_log',
		"theme"         => 'public_html/media/themes/ChelseaStats/error_log',
		"Api"           => 'public_html/media/api/error_log',
		"M"             => 'public_html/media/m/error_log',
		"442"           => 'public_html/media/api/442/error_log',
		"bitly"         => 'public_html/media/u/error_log',
		"Admin"         => 'public_html/wp-admin/error_log',
		"Auto Admin"    => 'public_html/wp-admin/auto_scheduler_log',
		"Auto"          => 'auto_scheduler_log' ];
	foreach($logs as $k => $v) :
	  if(file_exists($v)) :
	    $content = file_get_contents($v);
	    if(isset($content) && $content !='') :
	      $melinda->goSlack($content, $k.' Logger Bot', 'robot_face', 'bots');
	      file_put_contents( $v, "");
	      sleep(60);
	    endif;
	  else :
		  $melinda->goSlack(  $k ." log doesn't exist", 'Logger Bot', 'robot_face', 'bots');
		  file_put_contents( $v, "{$k} Log created");
	  endif;
	endforeach;