<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
    $melinda->goSlack( "Remember to do your Super 6 predictions. Good Luck!", 'Super 6 Bot','moneybag', 'bots');
