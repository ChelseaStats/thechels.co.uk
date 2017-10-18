<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	define("POP_USER", "*****@*****");
	define("POP_PASS", "*****");
	$m_box = imap_open ("{localhost:995/pop3/ssl/novalidate-cert}INBOX", POP_USER, POP_PASS, OP_SILENT);
	if($m_box):
		$check = imap_mailboxmsginfo($m_box);
		if( $check->Nmsgs > 0 ) { 
		     	$message    = quoted_printable_decode(imap_body($m_box, 1));
		     	$start      = strpos($message,'Morning all!');
				$end        = strpos($message,'Best of luck!');
				$content    = substr($message,$start,$end-$start);
				$content    = str_replace('Morning all!','',$content);
				$content    = str_replace('Best of luck!','',$content);
				$text       = $content .'Good luck. #CountDownRocks';
				$melinda->goTweet( $text, 'COUNT');
				   goSlackForHesa( $text, 'CountDownBot', 'clock1230', 'bots');
				imap_delete($m_box, 1);
				imap_expunge($m_box);
		}
		imap_close($m_box);
	endif;
	
	
	function goSlackForHesa($message, $name, $icon, $room = "bots") {
		$room = ($room) ? $room : "bots";
		$icon = ($icon) ? $icon : "cfc";
		$data = json_encode(array(
			"username"      =>  $name,
			"channel"       =>  "#{$room}",
			"text"          =>  $message,
			"icon_emoji"    =>  ":{$icon}:"
		));
		$ch = curl_init( "https://hooks.slack.com/services/*****/*****/*****" );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
