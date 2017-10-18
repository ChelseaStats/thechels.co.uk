<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$pdo     = new pdodb();
	$go 	 = new utility();
	$hash    = $go->getUrlOTD(date('Y-m-d'));
	$wins    ='3';
	$losses  ='1';
	$events  ='3';

	$sql = "SELECT SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN, SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW, SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS,
	      COUNT(*) AS F_TOTAL FROM cfc_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now()))";
	$pdo->query($sql);
	$row = $pdo->row();
            $W = $row['F_WIN'];
            $D = $row['F_DRAW'];
            $L = $row['F_LOSS'];
            $T = $row['F_TOTAL'];
		    if ($T > 0 ) {
			    $melinda->goTweet( "On This Day - #Chelsea's results, birthdays, significant days & days since our rivals won a trophy - $hash #OTD", 'OTD' );
			    $melinda->goTweet( "On This Day - #Chelsea played $T, winning $W, drawing $D and losing $L - $hash #Stats #CFC #OTD", 'OTD' );

			    $sql = "SELECT F_OPP, F_DATE, F_LOCATION, F_FOR, F_AGAINST, (F_FOR-F_AGAINST) as F_MAX FROM cfc_fixtures
						WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND F_RESULT='W' UNION ALL
	      				SELECT F_OPP, F_DATE, F_LOCATION, F_FOR, F_AGAINST, (F_FOR+F_AGAINST) as F_MAX FROM cfc_fixtures
	      				WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND F_RESULT='W' ORDER BY F_MAX DESC LIMIT " . $wins;
			    $pdo->query( $sql );
			    $rows = $pdo->rows();
			    foreach ( $rows as $row ) {
				    $team    = $go->_V( $row['F_OPP'] );
				    $H_score = $row['F_FOR'];
				    $A_score = $row['F_AGAINST'];
				    $date    = $go->_Y( $row['F_DATE'] );
				    $loc     = $row['F_LOCATION'];
				    if ( $loc == 'H' ) {
					    $loc = "at home";
				    } elseif ( $loc == 'A' ) {
					    $loc = "away";
				    } else {
					    $loc = "(neutral)";
				    }
				    $melinda->goTweet( "On This Day ($date) #Chelsea beat $team $loc $H_score-$A_score $hash #Stats #CFCOTD", 'OTD' );
			    }

			    $sql = "SELECT F_OPP, year(F_DATE) as F_DATE, F_LOCATION, F_FOR, F_AGAINST, (F_AGAINST-F_FOR) as F_MAX FROM cfc_fixtures
      					WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND F_RESULT='L' ORDER BY F_MAX DESC LIMIT $losses";
			    $pdo->query( $sql );
			    $rows = $pdo->rows();
			    foreach ( $rows as $row ) {
				    $team    = $go->_V( $row['F_OPP'] );
				    $H_score = $row['F_FOR'];
				    $A_score = $row['F_AGAINST'];
				    $date    = $row['F_DATE'];
				    $loc     = $row['F_LOCATION'];
				    if ( $loc == 'H' ) {
					    $loc = "at home";
				    } elseif ( $loc == 'A' ) {
					    $loc = "away";
				    } else {
					    $loc = "(neutral)";
				    }
				    $melinda->goTweet( "On This Day ($date) #Chelsea's heaviest loss was against $team $loc $H_score-$A_score $hash #Stats #CFCOTD", 'OTD' );
			    }

			    $sql = "SELECT F_NAME, F_NOTES, YEAR(F_DATE) as F_YEAR FROM cfc_dates
	      				WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) ORDER BY F_DATE DESC LIMIT $events";
			    $pdo->query( $sql );
			    $rows = $pdo->rows();
			    foreach ( $rows as $row ) {
				    $n = $go->_V( $row['F_NAME'] );
				    $d = $row['F_NOTES'];
				    $y = $row['F_YEAR'];
				    $melinda->goTweet( "#Chelsea On This Day ($y) - $n - $d - $hash #CFCOTD", 'OTD' );
			    }
		    }
