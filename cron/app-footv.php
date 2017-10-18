<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda    = new melinda();
	$your_user  =   '@ChelseaStatsBot';
	$your_team  =   'Chelsea';
	$url	    =   "http://www.live-footballontv.com/";
	$ch	        =   curl_init($url);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$raw	    =   curl_exec($ch);
					curl_close($ch);
	$s_date     =   date('d-m-Y');
	$s_today    =   date('l jS F Y');
	$s          =   strpos($raw, '<div class="span12 matchdate">'.$s_today.'</div>');
	$e_date     =   date('l jS F Y', strtotime($s_date . ' +1 day'));
	$e          =   strpos($raw, '<div class="span12 matchdate">'.$e_date.'</div>');
	$table      =   substr($raw,$s,$e-$s);
	$table      =   str_replace( $s_today , '', $table);

	$table      =   '<table style="width:100%; margin:auto auto; padding:2em;">
					 <thead><tr><th>Fix</th><th>Comp</th><th>KO</th><th>TV</th></tr></thead>
					 <tbody>' . $table . '</tbody></table>';

	$table      =   str_replace( '<div class="row-fluid">'           , '<tr>'      , $table);
	$table      =   str_replace( '<hr>'                              , '</tr>'     , $table);
	$table      =   str_replace( '<div class="span4 matchfixture">'  , '<td>'      , $table);
	$table      =   str_replace( '<div class="span4 competition">'   , '<td>'      , $table);
	$table      =   str_replace( '<div class="span1 kickofftime">'   , '<td>'      , $table);
	$table      =   str_replace( '<div class="span3 channels">'      , '<td>'      , $table);
	$table      =   str_replace( '</div>'                            , '</td>'     , $table);
	$table      =   str_replace( 'Red Button'               	 , 'RB'        , $table);
	$table      =   str_replace( 'BT Sport'                 	 , 'BT'        , $table);
	$table      =   str_replace( 'Sky Sports'               	 , 'SkySports' , $table);
	$table      =   str_replace( 'UEFA '                    	 , ''          , $table);
	$table      =   str_replace( 'LFCTV'                    	 , 'LFC'        , $table);
	$table      =   str_replace( 'Champions League '        	 , 'UCL'       , $table);
	$table      =   str_replace( 'Group Stage'              	 , 'G'         , $table);
	$table      =   str_replace( 'Last-16 1st Leg'          	 , 'L16 1'     , $table);
	$table      =   str_replace( 'Last-16 2nd Leg'          	 , 'L16 2'     , $table);
	$table      =   str_replace( 'Quarter-Final 1st Leg'    	 , 'QTR 1'     , $table);
	$table      =   str_replace( 'Quarter-Final 2nd Leg'    	 , 'QTR 2'     , $table);
	$table      =   str_replace( 'Semi-Final 1st Leg'       	 , 'SF 1'      , $table);
	$table      =   str_replace( 'Semi-Final 2nd Leg'       	 , 'SF 2'      , $table);
	$table      =   str_replace( 'Final'                    	 , 'Final'     , $table);
	$table      =   str_replace( 'International'            	 , 'Int'       , $table);
	$table      =   str_replace( 'United'                   	 , 'Utd'       , $table);
	$table      =   str_replace( "Women&#39;s Super League"     	 , 'WSL'       , $table);
	$table      =   str_replace( "&nbsp;"     			 , ' '         , $table);
	$table      =   str_replace( '&nbsp;'     			 , ' '         , $table);
	// important
	$table      =   str_replace( 'TBC'  , ''  , $table);
	preg_match_all( "|<tr(.*)</tr>|U", $table, $rows );
	
foreach ( $rows[0] as $row ) :

  if ( ( strpos( $row, '<th' ) === FALSE ) ) :
 	preg_match_all( "|<td(.*)</td>|U", $row, $cells );

 	$fix  = trim( strip_tags ( $cells[0][0] ) );
 	if ( strpos( $fix, " v " ) ) {
 		$teams  = explode( " v ", $fix );
 		$h_team = $teams['0'];
 		$a_team = $teams['1'];
 	}

 	$comp = trim ( strip_tags ( $cells[0][1] ) );
 	$KO   = trim ( strip_tags ( $cells[0][2] ) );
 	$tv   = trim ( strip_tags ( $cells[0][3] ) );
 	if ( strpos( $tv, "/" ) ) {
 			$tv = explode( "/", $tv );
 			$tv = trim($tv['1']);
	}
 $message = ''.PHP_EOL;
  if ( $fix !='' && $comp !='' && $KO !='' && $tv != '') :
	if( $tv != 'MUTV HD' && $tv != 'LFC HD' && $tv != 'S4C' && $tv != 'Premier Sports HD' && $tv != 'BBC ALBA' ) :
		$message .= "{$fix} in {$comp} is on {$tv} at {$KO} !".PHP_EOL;
	endif;
  endif;
 endif;
endforeach;

$melinda->goSlack( "{$fix} in {$comp} is on {$tv} at {$KO} !", 'TvBot','satellite' ,'bots');
