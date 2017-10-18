<?php /* Template Name: # m-plyrs */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
// Form handler
$tweet=$_GET['tw']; 
if (isset($tweet) && $tweet !='')  {
switch ($tweet) {
/********************************************************************************************************************/
case 'T01': //  CFC
$sql="SELECT F_NAME N, sum(F_GOALS) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players for goals: ";
break;
/********************************************************************************************************************/
case 'T02': // CFC
$sql="SELECT F_NAME N, sum(F_ASSISTS) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players for assists: ";
break;
/********************************************************************************************************************/
case 'T03': // CFC
$sql="SELECT F_NAME N, sum(F_GOALS+F_ASSISTS) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players for points (G+A): ";
break;
/********************************************************************************************************************/
case 'T04': // CFC
$sql="SELECT F_NAME N, sum(F_SHOTSON) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players for shots on target: ";
break;
/********************************************************************************************************************/
case 'T05': // CFC
$sql="SELECT F_NAME N, sum(F_SHOTS) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players for shots: ";
break;
/********************************************************************************************************************/
case 'T06': // CFC
$sql="SELECT F_NAME N, sum(F_FOULSSUF) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most fouled players: ";
break;
/********************************************************************************************************************/
case 'T07': // CFC
$sql="SELECT F_NAME N, sum(F_FOULSCOM) V FROM cfc_fixtures_players WHERE F_DATE >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') GROUP BY N ORDER BY V DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 enforcers (fouls committed): ";
break;
/********************************************************************************************************************/
case 'T10': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT='SUBON' AND F_TEAM='1'  AND F_DATE  >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') 
	  GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players subbed on: ";
break;
/********************************************************************************************************************/
case 'T11': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT='SUBOFF' AND F_TEAM='1'  AND F_DATE  >= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')  
	  GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 players subbed off: ";
break;
/********************************************************************************************************************/
case 'T19': // CFC
$sql="SELECT N, V FROM (SELECT F_NAME N, 
concat(sum(if(F_EVENT='PKGOAL'=1,1,0)), "/", sum(if(F_EVENT like '%PK%'=1,1,0)) ) as V, sum(if(F_EVENT like '%PK%'=1,1,0)) as A, round(sum(if(F_EVENT='PKGOAL'=1,1,0))/sum(if(F_EVENT like '%PK%'=1,1,0))*100,2) as B
FROM cfc_fixture_events WHERE F_EVENT LIKE '%PK%' AND F_TEAM='1'  AND F_DATE > '2010-07-01' GROUP BY F_NAME
ORDER BY A DESC, B DESC limit 0,3) aa";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 penalty takers (scored/attempted) since 2010 : ";
break;
/********************************************************************************************************************/

case 'T20': // CFC
$sql="SELECT N, V
FROM (SELECT F_NAME N, 
concat(sum(if(F_EVENT='PKGOAL'=1,1,0)), "/", sum(if(F_EVENT like '%PK%'=1,1,0)) ) as V, sum(if(F_EVENT like '%PK%'=1,1,0)) as A, round(sum(if(F_EVENT='PKGOAL'=1,1,0))/sum(if(F_EVENT like '%PK%'=1,1,0))*100,2) as B
FROM cfc_fixture_events WHERE F_EVENT LIKE '%PK%' AND F_TEAM='0'  AND F_DATE > '2010-07-01' GROUP BY F_NAME
ORDER BY A DESC, B DESC limit 0,3) aa";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 opposition penalties (scored/attempted) since 2010 : ";
break;

############################################# APPS ############################################################################

/********************************************************************************************************************/
case 'A01': // CFC
$sql="SELECT F_NAME N, sum(F_APPS) V FROM cfc_fixtures_players WHERE F_DATE > '2014-07-01'
		GROUP BY F_NAME ORDER BY sum(F_APPS) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 starters (this season): ";
break;
/********************************************************************************************************************/
case 'A02': // CFC
$sql="SELECT F_NAME N, sum(F_APPS) V FROM cfc_fixtures_players WHERE F_DATE > '2013-07-01'
			GROUP BY F_NAME ORDER BY sum(F_APPS) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 starters (since 2013): ";
break;
/********************************************************************************************************************/
case 'A03': // CFC
$sql="SELECT F_NAME N, sum(F_APPS) V FROM cfc_fixtures_players WHERE F_DATE > '2012-07-01'
		GROUP BY F_NAME ORDER BY sum(F_APPS) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 starters (since 2012): ";
break;
/********************************************************************************************************************/
case 'A04': // CFC
$sql="SELECT F_NAME N, sum(F_APPS) V FROM cfc_fixtures_players WHERE F_DATE > '2011-07-01'
		GROUP BY F_NAME ORDER BY sum(F_APPS) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 starters (since 2011): ";
break;
/********************************************************************************************************************/
case 'A05': // CFC
$sql="SELECT F_NAME N, sum(F_APPS) V FROM cfc_fixtures_players WHERE F_DATE > '2010-07-01'
		GROUP BY F_NAME ORDER BY sum(F_APPS) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 starters (since 2010): ";
break;
/********************************************************************************************************************/


############################################# GOALS ##########################################################################

/********************************************************************************************************************/
case 'G01': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='1'
		AND F_DATE > '2014-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scorers (this season): ";
break;
/********************************************************************************************************************/
case 'G02': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='1'
			AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scorers (since 2013): ";
break;
/********************************************************************************************************************/
case 'G03': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='1'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scorers (since 2012): ";
break;
/********************************************************************************************************************/
case 'G04': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='1'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scorers (since 2011): ";
break;	
/********************************************************************************************************************/
case 'G05': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='1'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scorers (since 2010): ";
break;	
/********************************************************************************************************************/
############################################### OPPO GOALS ###############################################################

/********************************************************************************************************************/
case 'P01': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='0'
		AND F_DATE > '2014-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scoring opponents (this season): ";
break;
/********************************************************************************************************************/
case 'P02': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='0'
			AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scoring opponents (since 2013): ";
break;
/********************************************************************************************************************/
case 'P03': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='0'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scoring opponents (since 2012): ";
break;
/********************************************************************************************************************/
case 'P04': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='0'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scoring opponents (since 2011): ";
break;	
/********************************************************************************************************************/
case 'P05': // CFC goals since x
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE '%GOAL%' AND F_TEAM='0'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 scoring opponents (since 2010): ";
break;	
/********************************************************************************************************************/
################################################### BOOKINGS #################################################################

/********************************************************************************************************************/
case 'B01': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='1'
		AND F_DATE > '2014-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most cautioned players (this season): ";
break;
/********************************************************************************************************************/
case 'B02': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='1'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most cautioned players (since 2013): ";
break;
/********************************************************************************************************************/
case 'B03': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='1'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most cautioned players (since 2012): ";
break;
/********************************************************************************************************************/
case 'B04': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='1'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most cautioned players (since 2011): ";
break;
/********************************************************************************************************************/
case 'B05': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='1'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most cautioned players (since 2010): ";
break;
/********************************************************************************************************************/

################################################# OPPO BOOKINGS ############################################################

/********************************************************************************************************************/
case 'C01': // CFC
	$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='0'
		AND F_DATE > '2014-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
	$url="http://thechels.uk/top3cfc";
	$message="#Stats #Chelsea's top 3 most cautioned opponents (this season): ";
	break;
	/********************************************************************************************************************/
case 'C02': // CFC
	$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='0'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
	$url="http://thechels.uk/top3cfc";
	$message="#Stats #Chelsea's top 3 most cautioned opponents (since 2013): ";
	break;
	/********************************************************************************************************************/
case 'C03': // CFC
	$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='0'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
	$url="http://thechels.uk/top3cfc";
	$message="#Stats #Chelsea's top 3 most cautioned opponents (since 2012): ";
	break;
	/********************************************************************************************************************/
case 'C04': // CFC
	$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='0'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
	$url="http://thechels.uk/top3cfc";
	$message="#Stats #Chelsea's top 3 most cautioned opponents (since 2011): ";
	break;
	/********************************************************************************************************************/
case 'C05': // CFC
	$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'YC' AND F_TEAM='0'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
	$url="http://thechels.uk/top3cfc";
	$message="#Stats #Chelsea's top 3 most cautioned opponents (since 2010): ";
	break;

########################################################## REDS #####################################################
	
/********************************************************************************************************************/
case 'R01': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='1'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off players (this season): ";
break;
/********************************************************************************************************************/
case 'R02': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='1'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off players (since 2013): ";
break;
/********************************************************************************************************************/
case 'R03': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='1'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off players (since 2012): ";
break;
/********************************************************************************************************************/
case 'R04': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='1'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off players (since 2011): ";
break;
/********************************************************************************************************************/
case 'R05': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='1'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off players (since 2010): ";
break;
/**	
############################################################# OPPO REDS #######################################
	
/********************************************************************************************************************/
case 'R06': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='0'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off opponents (this season): ";
break;
/********************************************************************************************************************/
case 'R07': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='0'
		AND F_DATE > '2013-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off opponents (since 2013): ";
break;
/********************************************************************************************************************/
case 'R08': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='0'
		AND F_DATE > '2012-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off opponents (since 2012): ";
break;
/********************************************************************************************************************/
case 'R09': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='0'
		AND F_DATE > '2011-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off opponents (since 2011): ";
break;
/********************************************************************************************************************/
case 'R10': // CFC
$sql="SELECT F_NAME N, count(*) V FROM cfc_fixture_events WHERE F_EVENT LIKE 'RC' AND F_TEAM='0'
		AND F_DATE > '2010-07-01' GROUP BY F_NAME ORDER BY count(*) DESC LIMIT 0,3";
$url="http://thechels.uk/top3cfc";
$message="#Stats #Chelsea's top 3 most sent off opponents (since 2010): ";
break;	
/********************************************************************************************************************/
default:
 	exit();
break;
/********************************************************************************************************************/
}

	$pdo = new pdodb();
	$pdo->query($sql);
	$rows = $pdo->rows();
	    
	foreach($rows as $row) {
	$ns[] = $row['N'];
	$vs[] = $row['V'];
	}
	
	$n0=$ns[0];
	$v0=$vs[0];
	$n1=$ns[1];
	$v1=$vs[1];
	$n2=$ns[2];
	$v2=$vs[2];
	
	$nv1= $go->_V($n0.' ('.$v0.'), '.$n1.' ('.$v1.') & '.$n2.' ('.$v2.')');
	$nv=ucwords(strtolower($nv1));
	$message = $message.' '.$nv.' - '.$url;
	$melinda->goTweet($message,'APP');
	print $melinda->goMessage($message,'success');
	print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

} else {
/********************************************************************************************************************/
?>
<form action="../" class="form">
    <div class="form-group">
<select name="mySelectbox" class="form-control">
<option value="" class="bolder">-- Choose a stat type --</option>
<option value="<?php the_permalink();?>?tw=T02">CFC Assists</option>
<option value="<?php the_permalink();?>?tw=T03">CFC Points</option>
<option value="<?php the_permalink();?>?tw=T04">CFC Shots on</option>
<option value="<?php the_permalink();?>?tw=T05">CFC Shots</option>
<option value="<?php the_permalink();?>?tw=T06">CFC Fouled</option>
<option value="<?php the_permalink();?>?tw=T07">CFC Enforcers</option>
<option value="<?php the_permalink();?>?tw=T10">CFC Subbed On</option>
<option value="<?php the_permalink();?>?tw=T11">CFC Subbed Off</option>

<option value="" class="bolder">-- Bookings --</option>
<option value="<?php the_permalink();?>?tw=B01">CFC bookings this season</option>
<option value="<?php the_permalink();?>?tw=B02">CFC bookings since 2013</option>
<option value="<?php the_permalink();?>?tw=B03">CFC bookings since 2012</option>
<option value="<?php the_permalink();?>?tw=B04">CFC bookings since 2011</option>
<option value="<?php the_permalink();?>?tw=B05">CFC bookings since 2010</option>

<option value="" class="bolder">-- Oppo Bookings --</option>
<option value="<?php the_permalink();?>?tw=C01">OPP bookings this season</option>
<option value="<?php the_permalink();?>?tw=C02">OPP bookings since 2013</option>
<option value="<?php the_permalink();?>?tw=C03">OPP bookings since 2012</option>
<option value="<?php the_permalink();?>?tw=C04">OPP bookings since 2011</option>
<option value="<?php the_permalink();?>?tw=C05">OPP bookings since 2010</option>

<option value="" class="bolder">-- reds --</option>
<option value="<?php the_permalink();?>?tw=R01">CFC reds this season</option>
<option value="<?php the_permalink();?>?tw=R02">CFC reds since 2013</option>
<option value="<?php the_permalink();?>?tw=R03">CFC reds since 2012</option>
<option value="<?php the_permalink();?>?tw=R04">CFC reds since 2011</option>
<option value="<?php the_permalink();?>?tw=R05">CFC reds since 2010</option>

<option value="" class="bolder">-- Oppo reds --</option>
<option value="<?php the_permalink();?>?tw=R06">OPP reds this season</option>
<option value="<?php the_permalink();?>?tw=R07">OPP reds since 2013</option>
<option value="<?php the_permalink();?>?tw=R08">OPP reds since 2012</option>
<option value="<?php the_permalink();?>?tw=R09">OPP reds since 2011</option>
<option value="<?php the_permalink();?>?tw=R10">OPP reds since 2010</option>

<option value="" class="bolder">-- starters --</option>
<option value="<?php the_permalink();?>?tw=A01">CFC starters this season</option>
<option value="<?php the_permalink();?>?tw=A02">CFC starters since 2013</option>
<option value="<?php the_permalink();?>?tw=A03">CFC starters since 2012</option>
<option value="<?php the_permalink();?>?tw=A04">CFC starters since 2011</option>
<option value="<?php the_permalink();?>?tw=A05">CFC starters since 2010</option>

<option value="" class="bolder">-- goals --</option>
<option value="<?php the_permalink();?>?tw=G01">CFC Goals this season</option>
<option value="<?php the_permalink();?>?tw=G02">CFC Goals since 2013</option>
<option value="<?php the_permalink();?>?tw=G03">CFC Goals since 2012</option>
<option value="<?php the_permalink();?>?tw=G04">CFC Goals since 2011</option>
<option value="<?php the_permalink();?>?tw=G05">CFC Goals since 2010</option>

<option value="" class="bolder">-- Oppo goals --</option>
<option value="<?php the_permalink();?>?tw=P01">OPP Goals this season</option>
<option value="<?php the_permalink();?>?tw=P02">OPP Goals since 2013</option>
<option value="<?php the_permalink();?>?tw=P03">OPP Goals since 2012</option>
<option value="<?php the_permalink();?>?tw=P04">OPP Goals since 2011</option>
<option value="<?php the_permalink();?>?tw=P05">OPP Goals since 2010</option>

<option value="" class="bolder">-- Coming Soon --</option>
<option value="<?php the_permalink();?>?tw=T99">CFC Minutes</option>
<option value="<?php the_permalink();?>?tw=T99">CFC Goals/min</option>
<option value="<?php the_permalink();?>?tw=T99">CFC Assists/min</option>
<option value="<?php the_permalink();?>?tw=T99">CFC Points/min</option>
</select>
    </div>
<?php print $go->getSubmit(); ?>
</form>
<div class="clearfix"><p>&nbsp;</p></div>
<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
    </div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
    <?php endif; ?>
    <?php get_footer(); ?>
