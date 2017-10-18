<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda   = new melinda();
	$go        = new utility();
	$up        = new updater();
	$url	   = "https://status.fitbit.com/";
	$today     = date('M D, Y');
	$raw       = $up->getCurlResponse( $url );
	$raw       = $up->removeLines($raw);
	$table     = $up->subStringingByPosition('<h3>Current Status</h3>','<h4>Recent Incidents</h4>', $raw);
	$data      = trim(str_replace("<h3>Current Status</h3>","",$table));
	$data      = trim(strip_tags($data));

	if ($data != "All systems operational") {
		$melinda->goSlack( $data, "FitBit Status Bot", "construction", "bots" );
	}
	
//	$url	            = "https://status.fitbit.com/incidents/";
//	$today              = date('M D, Y');
//	$raw                = $up->getCurlResponse( $url );
//	$raw                = $up->removeLines($raw);
//	$table              = $up->subStringingByPosition('<h3>Archived Incident Reports</h3>','<footer>', $raw);
//
//	preg_match_all( "|<tr(.*)</tr>|U", $table, $rows );
//
//	foreach ( $rows[0] as $row ) {
//
//		if ( ( strpos( $row, '<th' ) === FALSE ) ) {
//			preg_match_all( "|<td(.*)</td>|U", $row, $cells );
//
//			$date   = trim( strip_tags( $cells[0][0] ) );
//			$label  = trim( strip_tags( $cells[0][1] ) );
//
//			if($date == $today) {
//				$melinda->goSlack("Fitbit Status Update: {$label}","FitBit Status Bot","robot","bots");
//			}
//		}
//	}