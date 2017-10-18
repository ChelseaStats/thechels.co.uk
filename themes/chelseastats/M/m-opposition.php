<?php /* Template Name: # m-opposition */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
// Form handler
$base='thechels_CFC.cfc_fixtures';
$opp=$go->inputUpClean($_GET['team']); 
if (isset($opp) && $opp !='') 
{
$team=$go->replaceTeamName($opp);

    
$pdo = new pdodb();
$pdo->query('SELECT SUM(IF(F_RESULT="W",1,0)) AS W, SUM(IF(F_RESULT="D",1,0)) AS D, SUM(IF(F_RESULT="L",1,0)) AS L,
ROUND((SUM(IF(F_RESULT="W"=1,1,0))/COUNT(*))*100,2) AS WP, ROUND((SUM(IF(F_RESULT="D"=1,1,0))/COUNT(*))*100,2) AS DP,
ROUND((SUM(IF(F_RESULT="L"=1,1,0))/COUNT(*))*100,2) AS LP, count(*) as GT 
FROM cfc_fixtures WHERE F_OPP = :opp');
$pdo->bind(':opp',$opp);  
$row = $pdo->row();    
$W  = $row['W'];
$D  = $row['D'];
$L  = $row['L'];
$WP = $row['WP'];
$DP = $row['DP'];
$LP = $row['LP'];
$GT = $row['GT'];
$short_url = $go->goBitly("https://thechels.co.uk/analysis/results/?team=$opp");
$message1 = "#stats #CFC Complete results archive: #Chelsea vs $team -  $short_url";
$message2 = '#Chelsea are W'.$W.' ('.$WP.'%), D'.$D.' ('.$DP.'%) & L'.$L.' ('.$LP.'%) of '.$GT.' games against '.$team.'.';

//////////////////////////////////////////////////
    
if($GT > 11) {
$pdo = new pdodb();
$pdo->query('SELECT SUM(IF(F_RESULT="W",1,0)) AS W, SUM(IF(F_RESULT="D",1,0)) AS D, SUM(IF(F_RESULT="L",1,0)) AS L,
ROUND((SUM(IF(F_RESULT="W"=1,1,0))/COUNT(*))*100,2) AS WP, ROUND((SUM(IF(F_RESULT="D"=1,1,0))/COUNT(*))*100,2) AS DP, 
ROUND((SUM(IF(F_RESULT="L"=1,1,0))/COUNT(*))*100,2) AS LP, count(*) as GT 
FROM (select * from cfc_fixtures WHERE F_OPP =:opp ORDER BY F_DATE DESC LIMIT 10) a');
$pdo->bind(':opp', $opp);
$row = $pdo->row();   
$W1   = $row['W'];
$D1   = $row['D'];
$L1   = $row['L'];
$WP1  = $row['WP'];
$DP1  = $row['DP'];
$LP1  = $row['LP'];
$GT1  = $row['GT'];
$message3 = '... and #CFC are W'.$W1.' ('.$WP1.'%), D'.$D1.' ('.$DP1.'%) & L'.$L1.' ('.$LP1.'%) in last 10 games against '.$team.'.';
}

//////////////////////////////////////////////////

$pdo = new pdodb(); 
$pdo->query('SELECT F_LOCATION, F_FOR, F_AGAINST, F_COMPETITION, F_RESULT FROM cfc_fixtures WHERE F_OPP =:opp ORDER BY F_DATE DESC LIMIT 1');
$pdo->bind(':opp', $opp);
$row = $pdo->row();
$L   = $go->local($row['F_LOCATION']);
$F   = $row['F_FOR'];
$A   = $row['F_AGAINST'];
$C   = $go->comp($row['F_COMPETITION']);
$R   = $go->res($row['F_RESULT']);
$message4="#CFC Chelsea's last result against ".$team." was a ".$R." ".$L." in the ".$C." where it finished ".$F."-".$A.".";
    
//////////////////////////////////////////////////

$shorty2 = $go->goBitly("https://thechels.co.uk/analysis/frequency/?team=$opp");
$message5 = "#stats #CFC Results Frequency (most common scorelines) archive: #Chelsea vs $team -  $shorty2";

// end form handler

    $melinda->goTweet($message1,'APP');
    print $melinda->goMessage($message1,'success');

    $melinda->goTweet($message2,'APP');
    print $melinda->goMessage($message2,'success');

if($message3!='') {
    $melinda->goTweet($message3,'APP');
    print $melinda->goMessage($message3,'success');
}

    $melinda->goTweet($message4,'APP');
    print $melinda->goMessage($message4,'success');

    $melinda->goTweet($message5,'APP');
    print $melinda->goMessage($message5,'success');

    print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

}
else
{
?>
    <form action="../" class="form form-control">
  <div class="form-group">
	  <label class="control-label" for="mySelectbox">Choose Club:</label>
		  <select id="mySelectbox" name = "mySelectbox" class = "form-control">
			        <option value = "" class = "bolder"> -- Choose a Club --</option>
			  <?php
					$pdo = new pdodb();
					$pdo->query('SELECT DISTINCT F_OPP FROM cfc_fixtures WHERE F_OPP IS NOT NULL ORDER BY F_OPP ASC');
			        $rows = $pdo->rows();

					foreach($rows as $row) {
					$f1 = $go->_V($row['F_OPP']);
					$f2 = $go->_Q($row['F_OPP']);
			  ?>
			        <option value = "<?php the_permalink();?>?team=<?php echo $f2; ?>"><?php echo $f1; ?></option>
			  <?php   }   ?>
		  </select>
  </div>
<?php print $go->getSubmit(); ?>
</form>
<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
