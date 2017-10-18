<?php
  header('Content-Type: application/json; charset=utf-8');
  header("X-Frame-Options: SAMEORIGIN");
	header("X-XSS-Protection: 0");
	header("X-Content-Type-Options: nosniff");
	header("strict-transport-security: max-age=31536000; includeSubdomains");
	header("X-Powered-By: Celery");
	header("X-Turbo-Charged-By: Celery");
	header("x-cf-powered-by: Celery");
	header("Server: Celery");
  
	require_once( dirname(__DIR__).'/autoload.php');
	require_once( dirname(__DIR__).'/core/pdodb.php');
	
	$mobileApp = new pdodb();

	$mobileApp->query('SELECT F_IMAGEID, F_TEXT, F_DATE, F_AUTHOR FROM o_appstats 
				    WHERE F_DATE > (Select F_DATE from 000_config where F_LEAGUE="APP" ) 
				    ORDER BY F_ID desc limit 6');
	$rows = $mobileApp->resultset();
	
	$string = "[";
			foreach ($rows as $row) {
			
				$f1 = stripslashes($row['F_TEXT']);
				$f2 = str_replace('@','',$row['F_AUTHOR']);
				$date = $row['F_DATE'];
				
				$string .= '{';
				$string .= '	"uid" : "'.sha1($f1.'-'.$date).'",';
				$string .= '	"updateDate" : "'.str_replace('+00:00', 'Z', gmdate('c', strtotime($date))).'",';
				$string .= '	"titleText" : "'.$f2.'",';
				$string .= '	"mainText" : "'.$f2.' says '.$f1.'",';
				$string .= '	"redirectionUrl" : "https://m.thechels.uk"';
				$string .= '}'.PHP_EOL;
				$string .= ',';			
			} 		
	    $string .= "]".PHP_EOL;
	    print str_replace(",]", "]", $string);
?>
