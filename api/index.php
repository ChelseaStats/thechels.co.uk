<?php
	header("X-Frame-Options: SAMEORIGIN");
	header("X-XSS-Protection: 0");
	header("X-Content-Type-Options: nosniff");
	header("strict-transport-security: max-age=31536000; includeSubdomains");
	header("X-Powered-By: Celery");
	header("X-Turbo-Charged-By: Celery");
	header("x-cf-powered-by: Celery");
	header("Server: Celery");

	//require_once( '../autoload.php');

	require_once( dirname(__DIR__).'/autoload.php');
	require_once( dirname(__DIR__).'/core/pdodb.php');
	require_once( dirname(__DIR__).'/core/utility.php');
	require_once( dirname(__DIR__).'/core/melinda.php');

	$value  = '';
	$type   = '';
	$limit  = '';
	$pdo    = new pdodb();
	$go     = new utility();
	$m      = new melinda();

	// Get request
	$request = $_SERVER['REQUEST_URI'];
	// clean it
	$request = $go->clean($request);

	// get request can be 1, 2 or 3 parts
	$requests = explode("/",$request);

    /*****************/
    // make it a string
    $type = is_string($requests['1']) ? (string) ($requests['1']) : (string) ($requests['1']);

    // handle type if set use it, else default 
    if(strlen($type) > 0) { $type =  $requests['1']; } else { $type =  '/'; }

    /*****************/

    // make it a string
    $value = is_string($requests['2']) ? (string) ($requests['2']) : (string) ($requests['2']);

    // handle value if set use it, else default to listing of values available (s)
    if(strlen($value) > 0) { $value = strtoupper($requests['2']); } else { $type = $type.'s'; }
	if($type == 'ALLS') { $type = 'Last10';}

    /*****************/

    // make it an integer
    $limit = is_int($requests['3']) ? (int) ($requests['3']) : (int) ($requests['3']);

    // handle limit if set use it, else default it
    if($limit > 0) { $limit = (int) $requests['3']; } else { $limit = (int) '9999'; }

    /*****************/

if(isset($type) && $type <>'') {

        switch ($type) {

                        case 'teams':
                                    /*****************/
                                    $pdo->query('SELECT distinct F_OPP as Teams from cfc_fixtures order by F_OPP asc limit :limit');
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type, $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'team':
                                    /*****************/
                                    $pdo->query('SELECT F_DATE as Date, F_LOCATION as Location, F_OPP AS Team, F_RESULT AS Result, F_FOR AS F, F_AGAINST AS A 
                                                from cfc_fixtures WHERE F_OPP=:team order by F_DATE desc limit :limit');
                                    $pdo->bind(':team', $value);
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type, $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'results':
                                    /*****************/
                                    $pdo->query('SELECT distinct F_RESULT as Result from cfc_fixtures order by F_RESULT desc limit :limit');
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;           
                        case 'result':
                                    /*****************/
                                    $pdo->query('SELECT F_DATE as Date, F_LOCATION as Location, F_OPP AS Team, F_RESULT AS Result, F_FOR AS F, F_AGAINST AS A 
                                                from cfc_fixtures WHERE F_RESULT=:result order by F_DATE desc limit :limit');
                                    $pdo->bind(':result', $value);
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'locations':
                                    /*****************/
                                    $pdo->query('SELECT distinct F_LOCATION as Location from cfc_fixtures order by F_LOCATION desc limit :limit');
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;               
                        case 'location':
                                    /*****************/
                                    $pdo->query('SELECT F_DATE as Date, F_LOCATION as Location, F_OPP AS Team, F_RESULT AS Result, F_FOR AS F, F_AGAINST AS A 
                                                from cfc_fixtures WHERE F_LOCATION=:location order by F_DATE desc limit :limit');
                                    $pdo->bind(':location', $value);
                                    $pdo->bind(':limit', $limit);
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                            break;
                                    /*****************/
                        case 'hazard':
                                    /*****************/
                                    $pdo->query("SELECT 'Total Prem this season' as TYPE_SET,  sum(a.F_FOULSSUF) as FOULS
                                                    FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
                                                    WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
                                                    AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
                                                    AND a.F_GAMEID = d.F_ID
                                                    AND d.F_COMPETITION='PREM'
                                                    AND a.F_NAME='EDEN_HAZARD'
                                                    GROUP BY TYPE_SET
                                                    union all
                                                    SELECT 'Total all comps this season' as TYPE_SET,  sum(a.F_FOULSSUF) as FOULS
                                                    FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
                                                    WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
                                                    AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
                                                    AND a.F_GAMEID = d.F_ID
                                                    AND a.F_NAME='EDEN_HAZARD'
                                                    GROUP BY TYPE_SET
                                                    union all
                                                    SELECT 'Total CFC career' as TYPE_SET, sum(a.F_FOULSSUF) as FOULS
                                                    FROM cfc_fixtures_players a, cfc_players b, cfc_fixtures d
                                                    WHERE a.F_NAME=b.F_NAME
                                                          AND a.F_GAMEID = d.F_ID
                                                              AND a.F_NAME='EDEN_HAZARD'
                                                    GROUP BY TYPE_SET");
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'films':
                                    /*****************/
                                    $pdo->query("SELECT F_TITLE as Title, F_RATING as Rating, F_IMDB as IMDB, F_YEAR as Year FROM o_lists_films order by F_ID desc");
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'seen':
                                    /*****************/
                                    $pdo->query("SELECT F_NAME as Name FROM o_lists_teams");
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'mac':
                                    /*****************/
                                    $pdo->query("SELECT F_NAME as Name FROM o_lists_mac");
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;
                        case 'ios':
                                    /*****************/
                                    $pdo->query("SELECT F_NAME as Name FROM o_lists_ios");
                                    $rows  = $pdo->resultset();
                                    if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
                                    /*****************/
                                break;     
                        case 'gw':
                                    /*****************/
                                    $pdo->query("SELECT SUM(PLD) as PLD FROM 0V_base_PL_this 
                                                 WHERE Team ='CHELSEA' GROUP BY Team");
                                    $rows  = $pdo->resultset();
                                    foreach($rows as $row) {
                                    $gw = intval($row['PLD']);
                                    }
                                    if($gw < 10) { $gw = '0'.$gw; }
                                    print trim($gw); 
                                    
                                    /*****************/
                                break;
			case 'app':
				$pdo->query("select concat( F_TEXT, concat(' says ', F_AUTHOR)) as stat from o_appstats order by f_date desc limit 5");
				$rows = $pdo->resultset();
				if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
				break;
                        case 'all':
			                        /*****************/
			                        $pdo->query('SELECT Date, Home, Away, F, A FROM  (
				                                  SELECT F_DATE as Date, F_HOME AS Home, F_AWAY as Away, F_HGOALS AS F, F_AGOALS AS A
				                                  FROM all_results WHERE F_HOME=:team1
				                                  UNION ALL
				                                  SELECT F_DATE as Date, F_HOME AS Home, F_AWAY as Away, F_AGOALS AS F, F_HGOALS AS A
				                                  FROM all_results WHERE F_AWAY=:team2
				                                  UNION ALL
				                                  SELECT F_DATE as Date, F_HOME AS Home, F_AWAY as Away, F_HGOALS AS F, F_AGOALS AS A
				                                  FROM all_results_pre WHERE F_HOME=:team1
				                                  UNION ALL
				                                  SELECT F_DATE as Date, F_HOME AS Home, F_AWAY as Away, F_AGOALS AS F, F_HGOALS AS A
				                                  from all_results_pre WHERE F_AWAY=:team2
				                                  ) a
				                        		  order by Date desc limit :limit');
			                        $pdo->bind(':team1', $value);
			                        $pdo->bind(':team2', $value);
			                        $pdo->bind(':limit', $limit);
			                        $rows  = $pdo->resultset();
			                        if(!empty($rows)) {  print $go->response('200','OK', $type,  $rows); } else { print $go->response('500','Server Error', $type, $rows); }
			                        /*****************/
                            break;
				        case 'last10':
					        /*****************/
					        $pdo->query('SELECT Date, Home, Away, F goals, A goals FROM  (
							                                  SELECT F_DATE as Date, F_HOME AS Home, F_AWAY as Away, F_HGOALS AS F, F_AGOALS AS A
							                                  FROM all_results
							                                  order by Date desc limit 10');

					        $rows  = $pdo->resultset();
					        if(!empty($rows)) {  print $go->response('200','OK', $type, $rows); } else { print $go->response('500','Server Error', $type, $rows); }
					        /*****************/
					        break;
	                    case 'lunch':
				                    $locations = [
					                    "Sandwich Box",
					                    "Thatchers",
					                    "Wolfies",
					                    "Blue Dog",
					                    "Munchies",
					                    "Bar and Wok",
					                    "KFC",
					                    "Yo Sushi",
					                    "Greggs",
					                    "Charlies",
					                    "Prezzo",
					                    "Pizza Express",
					                    "Swallow Bakery",
					                    "The Bayshill",
					                    "Gridiron",
					                    "Sainsbury's",
					                    "Boston Tea Party",
					                    "Paparito's",
					                    "Boots",
					                    "Jamie's Italian",
					                    "Gianni's",
					                    "Co-op",
					                    "Costa",
					                    "Starbucks",
					                    "Subway",
					                    "McDonalds",
					                    "Waitrose",
					                    "Papa John's",
					                    "Zizzi's",
					                    "Ask",
					                    "Patisserie Valerie",
					                    "Huffkins",
					                    "Care Rouge",
					                    "Bella Italia",
					                    "Carluccio's",
					                    "Red Pepper",
					                    "La Scala",
					                    "Anderson's",
					                    "The Pasty Shop next to blue dog",
					                    "Thai Emerald",
					                    "Wetherspoon's (Bank House)",
					                    "Wetherspoon's (Moon Under the Water)",
					                    "Chicken Inn",
					                    "Turkish Delight",
					                    "Turkish Grill",
					                    "Daphne's",
					                    "Franky and Benny's",
					                    "Harvester",
					                    "Nando's",
					                    "Chiquitos",
					                    "Kaspa's",
					                    "Brasserie Blanc",
					                    "Turtle Bay",
					                    "Thai Emerald",
					                    "The Railway Inn",
					                    "Yates'",
					                    "Vodka Revolution",
					                   
				                    ];
				                    $key       = array_rand( $locations, 1 );
				                    $string    = $locations[ $key ];
		                            $return_phrase = "Maybe you should go to {$string}";
		                            
		                            print $return_phrase;
	                    	break;
                        case 'help':
                        case 'docs':
                        case '/':
                        default:
                                /*****************/
                                    include('info.html');
                                /*****************/
                        break;
        } // endswitch
} //end type if
else {     
        print $go->response('404','Not found', 'NULL','NULL');
}
