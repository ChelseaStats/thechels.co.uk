<?php
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
	require_once( dirname(__DIR__).'/core/melinda.php');
	
	$m      = new melinda();
	
$key = $_GET['key'];

if($key !='*****') {
        die('sorry.');
} else {

			$secret = $_POST['secret'];
				if($secret != '*****') {
						die('sorry..');
					} else {
				  	$v01 = mt_rand('1','24');
						$v02 = $_POST['data'];
						$v03 = $_POST['account'];
						$v04 = date("Y-m-d");
													try {
																$pdo = new pdodb();
																$pdo->query('INSERT INTO o_appstats (F_IMAGEID, F_TEXT, F_AUTHOR, F_DATE ) VALUES (:v1,:v2,:v3,:v4)');
																$pdo->bind(':v1' ,$v01);
																$pdo->bind(':v2' ,$v02);
																$pdo->bind(':v3' ,$v03);
																$pdo->bind(':v4' ,$v04);
																$result = $pdo->execute();
										    						print $result;
																		$m->goSlack($v03 .' says '.$v02, 'AlexaBot','cfc', 'bots');
																} catch (PDOException $e) {
																		$message = "DB Error: " . $e->getMessage() ;
																		$m->goSlack($message , 'AlexaBot','cfc', 'bots');
																} catch (Exception $e) {
																		$message = "Error: it failed";
																		$m->goSlack($message , 'AlexaBot','cfc', 'bots');
																}
				}
}	