<?php /* Template Name: # U MatchEvents */ ?>
<?php
$game=$_GET['game']; 
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
if(isset($game) && is_numeric($game)) { $cc=$_GET['game'];  } 
else {  header('Location: https://thechels.co.uk/analysis-ladies/results-ladies/'); }

    $title 	= 'Chelsea Ladies';

    $urlcomp	= 'https://thechels.co.uk/analysis-ladies/competition-analysis/';

    $urlref	= 'https://thechels.co.uk/analysis-ladies/ladies-referees/';
    
    $data = "SELECT F_DATE, F_FOR as FFOR, F_AGAINST as AGG, F_OPP as OPP, F_ATT as ATT, F_REF as FREF, F_LOCATION as LOC, F_NOTES as FNOTES, F_COMPETITION as COMP FROM wsl_fixtures WHERE F_ID=:cc ";

    $apps = "SELECT F_NO, F_NAME as N_NAME, F_GOALS, F_ASSISTS, F_YC, F_RC, x_minutes as F_MINS FROM wsl_fixtures_players WHERE F_GAMEID ='$cc' AND F_APPS='1' ORDER BY F_NO ASC";

    $subs = "SELECT F_NO, F_NAME as N_NAME, F_GOALS, F_ASSISTS, F_YC, F_RC, x_minutes as F_MINS FROM wsl_fixtures_players WHERE F_GAMEID ='$cc' AND F_APPS='0' ORDER BY F_NO ASC";

    $eventsql = "SELECT F_MINUTE, F_EVENT, F_NAME as N_NAME FROM wsl_fixture_events WHERE F_GAMEID ='$cc' ORDER BY  F_MINUTE ASC, F_EVENT DESC";

    $counterapps = "select count(*) as CNT FROM wsl_fixtures_players WHERE F_APPS='1' AND F_GAMEID=:cc";

    $countersubs = "select count(*) as CNT FROM wsl_fixtures_players WHERE F_APPS='0' AND F_GAMEID=:cc";

    $counterevents = "SELECT count(*) as CNT FROM wsl_fixture_events WHERE F_GAMEID=:cc";
    
} else {

// redirect to the results page - if no game id provided  
if(isset($game) && is_numeric($game)) { $cc=$_GET['game'];  }  
else {  header('Location: https://thechels.co.uk/analysis/results/'); }

    $title 	= 'Chelsea';

    $urlcomp	= 'https://thechels.co.uk/analysis/competitions/';

    $urlref	= 'https://thechels.co.uk/analysis/referees/';

    $data = "SELECT F_DATE, F_FOR as FFOR, F_AGAINST as AGG, F_OPP as OPP, F_ATT as ATT, F_REF as FREF, F_LOCATION as LOC, F_NOTES as FNOTES, F_COMPETITION as COMP, SUM(F_POSSESSION*100) AS H_POS, SUM(1-F_POSSESSION)*100 AS A_POS,
		ROUND(F_H_ATTEMPTSOFF/SUM(F_H_ATTEMPTSOFF+F_A_ATTEMPTSOFF)*100,2) AS H_OFF, ROUND(F_A_ATTEMPTSOFF/SUM(F_H_ATTEMPTSOFF+F_A_ATTEMPTSOFF)*100,2) AS A_OFF,
		ROUND(F_H_ATTEMPTSON/SUM(F_H_ATTEMPTSON+F_A_ATTEMPTSON)*100,2) AS H_ON, ROUND(F_A_ATTEMPTSON/SUM(F_H_ATTEMPTSON+F_A_ATTEMPTSON)*100,2) AS A_ON,
		ROUND(F_H_CORNERS/SUM(F_H_CORNERS+F_A_CORNERS)*100,2) AS H_CORN, ROUND(F_A_CORNERS/SUM(F_H_CORNERS+F_A_CORNERS)*100,2) AS A_CORN,
		ROUND(F_H_FOULS/SUM(F_H_FOULS+F_A_FOULS)*100,2) AS H_FOUL, ROUND(F_A_FOULS/SUM(F_H_FOULS+F_A_FOULS)*100,2) AS A_FOUL
		FROM cfc_fixtures WHERE F_ID=:cc ";

    $apps = "SELECT F_NO, F_NAME as N_NAME, F_SHOTS, F_SHOTSON, F_GOALS, F_ASSISTS, F_OFFSIDES, F_FOULSSUF, F_FOULSCOM, F_SAVES, F_YC, F_RC, x_minutes as F_MINS FROM cfc_fixtures_players WHERE F_GAMEID='$cc' AND F_APPS='1' ORDER BY F_NO ASC";

    $subs = "SELECT F_NO, F_NAME as N_NAME, F_SHOTS, F_SHOTSON, F_GOALS, F_ASSISTS, F_OFFSIDES, F_FOULSSUF, F_FOULSCOM, F_SAVES, F_YC, F_RC, x_minutes as F_MINS FROM cfc_fixtures_players WHERE F_GAMEID='$cc' AND F_APPS='0' ORDER BY F_NO ASC";

    $eventsql = "SELECT F_MINUTE, F_EVENT, F_NAME as N_NAME FROM cfc_fixture_events WHERE F_GAMEID ='$cc' ORDER BY F_HALF ASC, F_MINUTE ASC, F_EVENT DESC";

    $counterapps = "select count(*) as CNT FROM cfc_fixtures_players WHERE F_APPS='1' AND F_GAMEID=:cc";

    $countersubs = "select count(*) as CNT FROM cfc_fixtures_players WHERE F_APPS='0' AND F_GAMEID=:cc";

    $counterevents = "SELECT count(*) as CNT FROM cfc_fixture_events WHERE F_GAMEID=:cc";
}

$pdo = new pdodb();
$pdo->query($data);
$pdo->bind(':cc',$cc);
$row = $pdo->row();
?>
<?php get_header(); ?>
<div id="content">
<h4 class="special">Match Result, Statistics and Game Events:  <?php echo $title ?> <?php echo $row["FFOR"];?> - <?php echo $row["AGG"];?> <?php echo $go->_V($row["OPP"]);?></h4>
<div style="clear:both; height:10px;"></div>
<p>
<span class="rwd-line"><i class="fa fa-fw fa-shield"></i> Competition: <a href="<?php echo $urlcomp; ?>?comp=<?php echo $row["COMP"];?>"><?php echo $row["COMP"];?></a></span><span class="desktop"> - </span>
<span class="rwd-line"><i class="fa fa-fw fa-map-marker"></i> Location: <?php echo $go->getLoc($row["LOC"]);?></span><span class="desktop"> - </span>
<span class="rwd-line"><i class="fa fa-fw fa-eye"></i> Attendance: <?php echo $row["ATT"];?></span><span class="desktop"> - </span>
<span class="rwd-line"><i class="fa fa-fw fa-calendar"></i> Date: <?php echo $row["F_DATE"];?></span><span class="desktop"> - </span>
<span class="rwd-line"><i class="fa fa-fw fa-user"></i> Referee: <a href="<?php echo $urlref; ?>?ref=<?php echo $row["FREF"];?>" title="View record with this official"><?php echo $row["FREF"];?></a></span><span class="desktop"> - </span>
<span class="rwd-line"><i class="fa fa-fw fa-file-code-o"></i> Notes: <?php echo $row["FNOTES"];?></span>
</p>
<p id="meta game-<?php echo $cc; ?>" class="date"></p>
<?php if ($row["H_POS"]  > 0 ) { print $go->_comparebars('Possession',$row["H_POS"],$row["A_POS"]); }?>
<?php if ($row["H_CORN"] > 0 ) { print $go->_comparebars('Corners',$row["H_CORN"],$row["A_CORN"]); } ?>
<?php if ($row["H_FOUL"] > 0 ) { print $go->_comparebars('Fouls',$row["H_FOUL"],$row["A_FOUL"]); } ?>
<?php if ($row["H_ON"]   > 0 ) { print $go->_comparebars('Attempts On Target',$row["H_ON"],$row["A_ON"]); } ?>
<?php if ($row["H_OFF"]  > 0 ) { print $go->_comparebars('Attempts Off Target',$row["H_OFF"],$row["A_OFF"]); } ?>

<?php 
###################################################################################

print '<h3>Player Stats</h3>';
            $pdo = new pdodb();
            $pdo->query($counterapps);
            $pdo->bind(':cc',$cc);
            $row = $pdo->row();
            $num1 = $row["CNT"];
if ($num1 > 0) {
//================================================================================
 outputDataTable( $apps, 'Apps');
//================================================================================
}
else { print '<div class="alert alert-error">no player statistics available</div>'; }
            $pdo = new pdodb();
            $pdo->query($countersubs);
            $pdo->bind(':cc',$cc);
            $row = $pdo->row();
            $num2 = $row["CNT"];
if ($num2 > 0) {
print '<strong>Substitutes</strong>';
//================================================================================
 outputDataTable( $subs, 'Subs');
//================================================================================
}
else { print '<div class="alert alert-error">no substitute  statistics available</div>'; }

print '<h3>Match Events</h3>';
            $pdo = new pdodb();
            $pdo->query($counterevents);
            $pdo->bind(':cc',$cc);
            $row = $pdo->row();
            $num3 = $row["CNT"];
if ($num3 > 0) {
//================================================================================
 outputDataTable( $eventsql, 'Events');
//================================================================================
}
else { print '<div class="alert alert-error">no match details available</div>'; }

###################################################################################
?>
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
<?php get_footer(); ?>
