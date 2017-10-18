<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$pdo = new pdodb();
	$melinda = new melinda();
	$go = new utility();
	$up = new updater();
	$your_team = 'Chelsea';
	$url = "http://www.premierleague.com/content/premierleague-ajax/referee-info.ajax/-/-/-/-/2015-2016";
	$fileStore = 'public_html/media/cron/refStore.txt';
	$raw = $up->getJsonFromCurl($url);
	$stored_statement = $up->getStoredValue($fileStore);

foreach( $raw->refereeAppointments->dateList as $key => $value) {
	foreach ( $value->refAppointments->appointments as $k => $v ) {
		$matchState = $v->match->matchState;
		$ko         = $v->match->koTime;
		$home       = $v->match->homeTeam->name;
		$away       = $v->match->awayTeam->name;
		$date       = $v->match->date;
		// get future team games first
		if ( $matchState != 'POST_MATCH' && ( $home == $your_team || $away == $your_team ) ) {
			// Check if referee has been assigned
			// this node would be empty until referee assigned
			if ( isset( $v->mainReferee->name ) && $v->mainReferee->name != '' ) {
				$ref = $v->mainReferee->name;
				if ( isset( $ref ) && ( $ref != '' ) ) {

					$phrasing = "The FA have assigned {$ref} to {$home} v {$away} on {$date} at {$ko}!";
					if ( $stored_statement != $phrasing ) {

						$up->writeToFileStore($fileStore , $phrasing );

						if ( isset( $ref ) && $ref != '' ) {

							$i       = explode( ' ', $ref );
							$f_name  = $i['0'];
							$s_name  = $i['1'];
							$referee = strtoupper( $s_name . ',' . $f_name );

							$bit = $go->goBitly( "https://thechels.co.uk/analysis/referees/?ref=$referee" );

							$pdo->query( "SELECT SUM(IF(F_RESULT='W',1,0)) AS W, SUM(IF(F_RESULT='D',1,0)) AS D, SUM(IF(F_RESULT='L',1,0)) AS L,
							ROUND((SUM(IF(F_RESULT='W'=1,1,0))/COUNT(*))*100,2) AS WP, ROUND((SUM(IF(F_RESULT='D'=1,1,0))/COUNT(*))*100,2) AS DP,
							ROUND((SUM(IF(F_RESULT='L'=1,1,0))/COUNT(*))*100,2) AS LP, MAX(F_DATE) as MXD, count(*) as GT FROM cfc_fixtures WHERE F_REF=:ref" );
							$pdo->bind( ':ref', $referee );
							$row      = $pdo->row();
							$W        = $row['W'];
							$D        = $row['D'];
							$L        = $row['L'];
							$WP       = $row['WP'];
							$DP       = $row['DP'];
							$LP       = $row['LP'];
							$GT       = $row['GT'];
							$date     = $row['MXD'];
							$message1 = "Chelsea are W{$W} ({$WP}%), D{$D} ({$DP}%) & L{$L} ({$LP}%) of {$GT} games with {$ref} as the official.";


							$pdo->query( "SELECT F_OPP, F_FOR, F_AGAINST, F_DATE FROM cfc_fixtures WHERE F_DATE = :game_date" );
							$pdo->bind( ':game_date', $date );
							$row      = $pdo->row();
							$OPP      = $go->_V( $row['F_OPP'] );
							$FX       = $row['F_FOR'];
							$AX       = $row['F_AGAINST'];
							$DX       = $row['F_DATE'];
							$message2 = "Our last meeting with {$ref} was on the {$DX} against {$OPP} when it finished {$FX}-{$AX}.";

							$message3 = "Full results analysis of #Chelsea games with Referee: $ref -  $bit";

							$melinda->goSlack( "New: {$phrasing}", 'RefereeBot', 'skull_and_crossbones','bots');
							$melinda->goTweet( $phrasing, 'REF' );

							if ( $GT > 0 ) :
								$melinda->goTweet( $message1, 'REF' );
								$melinda->goTweet( $message2, 'REF' );
								$melinda->goTweet( $message3, 'REF' );
							endif;


						}

						$ref = ''; // reset the referee. barf.
					}
				}
				$ref = '';
			}
		}
	}
}

/** other PL feeds
 * http://www.premierleague.com/ajax/live-match/{gameid}/live-match-details.json
 * http://www.premierleague.com/ajax/live-match/{gameid}/squad-details.json
 * http://www.premierleague.com/ajax/site-header/ajax-all-matches.json
 */
