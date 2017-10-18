<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	define("POP_USER", "*****");
	define("POP_PASS", "*****");
	$m_box  = imap_open ("{localhost:995/pop3/ssl/novalidate-cert}INBOX", POP_USER, POP_PASS, OP_SILENT);
	if($m_box):
		$check = imap_mailboxmsginfo($m_box);
		if( $check->Nmsgs > 0 ) { 
		     	// $message = quoted_printable_decode(imap_body($m_box, 1));
		     	$message =  quoted_printable_decode(imap_fetchbody($m_box, 1, 1));
		     	$explode = explode('----',$message);
		     	$message = $explode['0'];
		     	$message = preg_replace('/--[\r\n]+.*/s', '', $message);
		     	$message = preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($message))) );
			$melinda->goSlack( trim(strip_tags($message)), 'Mail Bot','e-mail','bots');
			imap_delete($m_box, 1);
			imap_expunge($m_box);
		}
		imap_close($m_box);
	endif;