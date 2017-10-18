<?php /* Template Name: # Z ** Gen Preview */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
<div id = "content">
<div id = "contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class = "special"> <?php the_title(); ?>  - HARMONIC STATS PREVIEW GENERATOR</h4>
<?php    
	
    $submit = $_POST['Submit'];

if (isset($submit) && $submit!= '' ) {

	 $pdo = new pdodb();
	//defaults
	$ra0=0;
	$ra1=0;
	$ra2=0;
	$ra3=0;
	$ra4=0;
	$bs0=0;
	$bs1=0;
	$bs2=0;
	$bs3=0;
	$bs4=0;
	$bs5=0;
	$bs6=0;
	$bs7=0;
	$bs8=0;
	$bs9=0;
	// actual data
    $opp        =  $go->inputUpClean($_POST['opp']);
    $comp       =  $go->inputUpClean($_POST['comp']);
    $loc        =  $go->inputUpClean($_POST['loc']);
    $ref        =  $go->inputUpClean($_POST['ref']);

	$pdo->query("SELECT F_SNAME from cfc_managers order by F_ORDER desc limit 1");
	$row = $pdo->row();
	$mgr = $row['F_SNAME'];
    
    $omgr       =  $go->inputUpClean($_POST['omgr']);
    $friendly   =  $go->inputUpClean($_POST['friendly']);
    // tidy up team name (use {$team} to echo, use $opp to query)
    //$team = $go->replaceTeamName($opp);
    // swap spaces, so the replacer works (hopefully)
    $team = $go->replaceTeamName(str_replace(' ', '', $opp));

	$team_replacer = str_replace(' ', '', $team);
	$team_replacer = trim(str_replace(" ", "", $team_replacer));

    // tidy up competition (use {$competition} to echo, use $comp to query)
    $competition = $go->comp($comp);
    // tidy up location (use $location to echo, use $loc to query)
    $location = $go->local($loc);
    // tidy up referee (use {$referee} to echo, use $ref to query)
    $referee = $go->ref($ref);
    // tidy up team name (use {$team} to echo, use $opp to query)
    $manager = $go->mgr($mgr);
    $omanager = $go->mgr($omgr);

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $q1 = "SELECT SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw,
    SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean,SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp)*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures where F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures where F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_OPP = :opp) /(SELECT count(*) FROM cfc_fixtures where F_OPP = :opp)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_OPP = :opp ";
    
    $pdo->query($q1);
    $pdo->bind(':opp',$opp);
    $a = $pdo->row();

    $tot01 = $a['f_total'];
    $tot02 = $a['f_win'];
    $tot03 = $a['f_winper'];
    $tot04 = $a['f_draw'];
    $tot05 = $a['f_drawper'];
    $tot06 = $a['f_loss'];
    $tot07 = $a['f_lossper'];
    $tot08 = $a['f_for'];
    $tot09 = $a['f_forper'];
    $tot10 = $a['f_against'];
    $tot11 = $a['f_againstper'];
    $tot12 = $a['f_clean'];
    $tot13 = $a['f_cleanper'];
    $tot14 = $a['f_failed'];
    $tot15 = $a['f_failedper'];
    // new total therefore
    $total = $tot01+1;

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $q6a = "SELECT count(*) FROM cfc_fixtures WHERE F_REF = :ref ORDER BY  F_DATE DESC LIMIT 5";
    $pdo->query($q6a);
    $pdo->bind(':ref',$ref);
    $ref_counter = $pdo->row();

    if($ref_counter > 0) :

        $q6b = "SELECT F_ID FROM cfc_fixtures WHERE F_REF = :ref ORDER BY  F_DATE DESC LIMIT 5";
        $pdo = new pdodb();
        $pdo->query($q6b);
        $pdo->bind(':ref',$ref);
        $rows = $pdo->rows();
        $ra = array();
        
            foreach ($rows as $row) :
                $ra[] = $row['F_ID'];

            endforeach;

        $ra0 = $ra['0'];
        $ra1 = $ra['1'];
        $ra2 = $ra['2'];
        $ra3 = $ra['3'];
        $ra4 = $ra['4'];

    endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $fixturesids = "SELECT count(*) FROM cfc_fixtures WHERE F_OPP = :opp ORDER BY F_DATE DESC LIMIT 10";
    $pdo = new pdodb();
    $pdo->query($fixturesids);
    $pdo->bind(':opp',$opp);
    $counter = $pdo->row();

    if ($counter > 0) :

        $fixturesids = "SELECT F_ID FROM cfc_fixtures WHERE F_OPP = :opp ORDER BY F_DATE DESC LIMIT 10";
        $pdo = new pdodb();
        $pdo->query($fixturesids);
        $pdo->bind(':opp',$opp);
        $rows = $pdo->rows();
        $bs = array();

            foreach($rows as $row) :
                $bs[] = $row['F_ID'];
            endforeach;

        $bs0 = $bs['0'];
        $bs1 = $bs['1'];
        $bs2 = $bs['2'];
        $bs3 = $bs['3'];
        $bs4 = $bs['4'];
        $bs5 = $bs['5'];
        $bs6 = $bs['6'];
        $bs7 = $bs['7'];
        $bs8 = $bs['8'];
        $bs9 = $bs['9'];

    endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $q1Limit10 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*)
    FROM cfc_fixtures where F_RESULT = 'W' AND F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))*100,2) AS f_winper,
    ROUND((SELECT count(*)
    FROM cfc_fixtures where F_RESULT = 'D' AND F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))*100,2) AS f_drawper,
    ROUND((SELECT count(*)
    FROM cfc_fixtures where F_RESULT = 'L' AND F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9)),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9)),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST)
    FROM cfc_fixtures where F_AGAINST = '0' AND F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR)
    FROM cfc_fixtures where F_FOR = '0' AND F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))
    /(SELECT count(*)
    FROM cfc_fixtures where F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9))*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9)
    ORDER BY F_DATE DESC limit 10";

    $pdo = new pdodb();
    $pdo->query($q1Limit10);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':bs0',$bs0);
    $pdo->bind(':bs1',$bs1);
    $pdo->bind(':bs2',$bs2);
    $pdo->bind(':bs3',$bs3);
    $pdo->bind(':bs4',$bs4);
    $pdo->bind(':bs5',$bs5);
    $pdo->bind(':bs6',$bs6);
    $pdo->bind(':bs7',$bs7);
    $pdo->bind(':bs8',$bs8);
    $pdo->bind(':bs9',$bs9);
    $a10  =  $pdo->row();
    $limit01 = $a10['f_total'];
    $limit02 = $a10['f_win'];
    $limit03 = $a10['f_winper'];
    $limit04 = $a10['f_draw'];
    $limit05 = $a10['f_drawper'];
    $limit06 = $a10['f_loss'];
    $limit07 = $a10['f_lossper'];
    $limit08 = $a10['f_for'];
    $limit09 = $a10['f_forper'];
    $limit10 = $a10['f_against'];
    $limit11 = $a10['f_againstper'];
    $limit12 = $a10['f_clean'];
    $limit13 = $a10['f_cleanper'];
    $limit14 = $a10['f_failed'];
    $limit15 = $a10['f_failedper'];
// add one to the total

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $q2 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc)*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_OPP = :opp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_LOCATION = :loc)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_OPP = :opp AND F_LOCATION = :loc ";

    $pdo = new pdodb();
    $pdo->query($q2);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':loc',$loc);
    $b  =  $pdo->row();
    $loc01 = $b['f_total'];
    $loc02 = $b['f_win'];
    $loc03 = $b['f_winper'];
    $loc04 = $b['f_draw'];
    $loc05 = $b['f_drawper'];
    $loc06 = $b['f_loss'];
    $loc07 = $b['f_lossper'];
    $loc08 = $b['f_for'];
    $loc09 = $b['f_forper'];
    $loc10 = $b['f_against'];
    $loc11 = $b['f_againstper'];
    $loc12 = $b['f_clean'];
    $loc13 = $b['f_cleanper'];
    $loc14 = $b['f_failed'];
    $loc15 = $b['f_failedper'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////        
    
    $q3 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp)*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_OPP = :opp AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_OPP = :opp AND F_COMPETITION = :comp ";

    $pdo = new pdodb();
    $pdo->query($q3);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':comp',$comp);
    $c = $pdo->row();
    $comp01 = $c['f_total'];
    $comp02 = $c['f_win'];
    $comp03 = $c['f_winper'];
    $comp04 = $c['f_draw'];
    $comp05 = $c['f_drawper'];
    $comp06 = $c['f_loss'];
    $comp07 = $c['f_lossper'];
    $comp08 = $c['f_for'];
    $comp09 = $c['f_forper'];
    $comp10 = $c['f_against'];
    $comp11 = $c['f_againstper'];
    $comp12 = $c['f_clean'];
    $comp13 = $c['f_cleanper'];
    $comp14 = $c['f_failed'];
    $comp15 = $c['f_failedper'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////     
    
    $ql3 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc)*100,2) AS f_lossper, 
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc),2) AS f_forper,  
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc),2) AS f_againstper,  
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc) /(SELECT count(*) FROM cfc_fixtures WHERE  F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_OPP = :opp AND F_COMPETITION = :comp AND F_LOCATION = :loc ";

    $pdo = new pdodb();
    $pdo->query($ql3);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':comp',$comp);
    $pdo->bind(':loc',$loc);
    $cl = $pdo->row();
    $l_comp01 = $cl['f_total'];
    $l_comp02 = $cl['f_win'];
    $l_comp03 = $cl['f_winper'];
    $l_comp04 = $cl['f_draw'];
    $l_comp05 = $cl['f_drawper'];
    $l_comp06 = $cl['f_loss'];
    $l_comp07 = $cl['f_lossper'];
    $l_comp08 = $cl['f_for'];
    $l_comp09 = $cl['f_forper'];
    $l_comp10 = $cl['f_against'];
    $l_comp11 = $cl['f_againstper'];
    $l_comp12 = $cl['f_clean'];
    $l_comp13 = $cl['f_cleanper'];
    $l_comp14 = $cl['f_failed'];
    $l_comp15 = $cl['f_failedper'];
    
///////////////////////////////////////////////////////////////////////////////////////////////////////// 
    
    $q4 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref)*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures where F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures where F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_REF = :ref) /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_REF = :ref ";

    $pdo = new pdodb();
    $pdo->query($q4);
    $pdo->bind(':ref',$ref);
    $d = $pdo->row();
    $ref01 = $d['f_total'];
    $ref02 = $d['f_win'];
    $ref03 = $d['f_winper'];
    $ref04 = $d['f_draw'];
    $ref05 = $d['f_drawper'];
    $ref06 = $d['f_loss'];
    $ref07 = $d['f_lossper'];
    $ref08 = $d['f_for'];
    $ref09 = $d['f_forper'];
    $ref10 = $d['f_against'];
    $ref11 = $d['f_againstper'];
    $ref12 = $d['f_clean'];
    $ref13 = $d['f_cleanper'];
    $ref14 = $d['f_failed'];
    $ref15 = $d['f_failedper'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    $q4limit5 = "SELECT
    SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W' AND F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4)),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4)),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))
    /(SELECT count(*) FROM cfc_fixtures where F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4))*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE F_REF = :ref AND F_ID IN (:ra0, :ra1, :ra2, :ra3, :ra4)
     ORDER BY F_DATE DESC LIMIT 5";

    $pdo->query($q4limit5);
    $pdo->bind(':ref',$ref);
    $pdo->bind(':ra0',$ra0);
    $pdo->bind(':ra1',$ra1);
    $pdo->bind(':ra2',$ra2);
    $pdo->bind(':ra3',$ra3);
    $pdo->bind(':ra4',$ra4);
    $dlimit5 = $pdo->row();
    $limitref01 = $dlimit5['f_total'];
    $limitref02 = $dlimit5['f_win'];
    $limitref03 = $dlimit5['f_winper'];
    $limitref04 = $dlimit5['f_draw'];
    $limitref05 = $dlimit5['f_drawper'];
    $limitref06 = $dlimit5['f_loss'];
    $limitref07 = $dlimit5['f_lossper'];
    $limitref08 = $dlimit5['f_for'];
    $limitref09 = $dlimit5['f_forper'];
    $limitref10 = $dlimit5['f_against'];
    $limitref11 = $dlimit5['f_againstper'];
    $limitref12 = $dlimit5['f_clean'];
    $limitref13 = $dlimit5['f_cleanper'];
    $limitref14 = $dlimit5['f_failed'];
    $limitref15 = $dlimit5['f_failedper'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////     
    
    $q5 = "SELECT SUM(IF(F_RESULT = 'W' = 1,1,0)) AS f_win, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS f_draw, SUM(IF(F_RESULT = 'L' = 1,1, 0)) AS f_loss,
    SUM(F_FOR) AS f_for, SUM(F_AGAINST) AS f_against, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS f_clean, SUM(IF(F_FOR = '0' = 1,1,0)) AS f_failed,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'W'  AND F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE  F_COMPETITION = :comp)*100,2) AS f_winper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'D' AND  F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp)*100,2) AS f_drawper,
    ROUND((SELECT count(*) FROM cfc_fixtures where F_RESULT = 'L' AND  F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp)*100,2) AS f_lossper,
    ROUND((SELECT sum(F_FOR) FROM cfc_fixtures WHERE   F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp),2) AS f_forper,
    ROUND((SELECT sum(f_AGAINST) FROM cfc_fixtures WHERE   F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp),2) AS f_againstper,
    ROUND((SELECT count(F_AGAINST) FROM cfc_fixtures where F_AGAINST = '0' AND  F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp)*100,2) AS f_cleanper,
    ROUND((SELECT count(F_FOR) FROM cfc_fixtures where F_FOR = '0' AND  F_COMPETITION = :comp) /(SELECT count(*) FROM cfc_fixtures WHERE F_COMPETITION = :comp)*100,2) AS f_failedper,
    count(*) AS f_total FROM cfc_fixtures WHERE  F_COMPETITION = :comp ";

    $pdo = new pdodb();
    $pdo->query($q5);
    $pdo->bind(':comp',$comp);
    $e = $pdo->row();
    $ecomp01 = $e['f_total'];
    $ecomp02 = $e['f_win'];
    $ecomp03 = $e['f_winper'];
    $ecomp04 = $e['f_draw'];
    $ecomp05 = $e['f_drawper'];
    $ecomp06 = $e['f_loss'];
    $ecomp07 = $e['f_lossper'];
    $ecomp08 = $e['f_for'];
    $ecomp09 = $e['f_forper'];
    $ecomp10 = $e['f_against'];
    $ecomp11 = $e['f_againstper'];
    $ecomp12 = $e['f_clean'];
    $ecomp13 = $e['f_cleanper'];
    $ecomp14 = $e['f_failed'];
    $ecomp15 = $e['f_failedper'];

///////////////////////////////////////////////////////////////////////////////////////////////////////// 
    
    $q6 = "SELECT 
    SUM(IF(F_EVENT = 'YC' AND F_TEAM = '1' = 1,1,0)) AS F_HYC, SUM(IF(F_EVENT = 'RC' AND F_TEAM = '1' = 1,1,0)) AS F_HRC,
    SUM(IF(F_EVENT IN ('PKGOAL','PKMISS') AND F_TEAM = '1' = 1,1,0)) AS F_HPK,
    SUM(IF(F_EVENT = 'YC' AND F_TEAM = '0' = 1,1,0)) AS F_AYC, SUM(IF(F_EVENT = 'RC' AND F_TEAM = '0' = 1,1,0)) AS F_ARC,
    SUM(IF(F_EVENT IN ('PKGOAL','PKMISS') AND F_TEAM = '0' = 1,1,0)) AS F_APK
    FROM ( select a.f_event, a.f_team from cfc_fixture_events a, cfc_fixtures b 
    WHERE b.F_REF = :ref AND a.F_GAMEID = b.F_ID AND a.F_GAMEID in (:ra0, :ra1, :ra2, :ra3, :ra4)) b";
    
    $pdo = new pdodb();
    $pdo->query($q6);
    $pdo->bind(':ref',$ref);
    $pdo->bind(':ra0',$ra0);
    $pdo->bind(':ra1',$ra1);
    $pdo->bind(':ra2',$ra2);
    $pdo->bind(':ra3',$ra3);
    $pdo->bind(':ra4',$ra4);
    $f = $pdo->row();
    $eve01 = ($f['F_HYC']);
    $eve02 = ($f['F_HRC']);
    $eve03 = $go->pluralPens($f['F_HPK']);
    $eve04 = ($f['F_AYC']);
    $eve05 = ($f['F_ARC']);
    $eve06 = $go->pluralPens($f['F_APK']);
    

/////////////////////////////////////////////////////////////////////////////////////////////////////////

	if($omgr != '0') {
		$qomgr = "SELECT F_NAME, F_NAME2, PLD, W, D, L, PPG, First, Last FROM 0V_base_oppoMgr WHERE Fullname = :omgr ";
		$pdo = new pdodb();
		$pdo->query($qomgr);
		$pdo->bind(':omgr',$omgr);
		$oma = $pdo->row();
		$omPLD      = $oma['PLD'];
		$omF1       = $oma['F_NAME'];
		$omF2       = $oma['F_NAME2'];
		$omW        = $oma['W'];
		$omD        = $oma['D'];
		$omL        = $oma['L'];
		$omPPG      = $oma['PPG'];
		$omFirst    = str_split($oma['First'],4);
		$omFirst    = $omFirst[0];
		$omLast     = $oma['Last'];
	} 
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    // calculating most common scorelines to save some typing work?

    $sql_x0 = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/10)*100,3) as F_PER FROM cfc_fixtures WHERE F_OPP = :opp  GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC limit 1";
    $pdo->query($sql_x0);
    $pdo->bind(':opp',$opp);
    $row = $pdo->row();
    $common_scoreA0 = $row['F_FOR'];
    $common_scoreB0 = $row['F_AGAINST'];
    $common_scoreC0 = $row['F_COUNT'];

    // calculating most common scorelines to save some typing work?

    $sql_x1 = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/10)*100,3) as F_PER FROM cfc_fixtures WHERE F_OPP = :opp  GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC limit 1,2";
    $pdo->query($sql_x1);
    $pdo->bind(':opp',$opp);
    $row = $pdo->row();
    $common_scoreA1 = $row['F_FOR'];
    $common_scoreB1 = $row['F_AGAINST'];
    $common_scoreC1 = $row['F_COUNT'];

    // calculating most common scorelines to save some typing work?

    $sql_x0 = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/10)*100,3) as F_PER
             FROM cfc_fixtures WHERE F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9)
             GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC limit 1";
    $pdo->query($sql_x0);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':bs0',$bs0);
    $pdo->bind(':bs1',$bs1);
    $pdo->bind(':bs2',$bs2);
    $pdo->bind(':bs3',$bs3);
    $pdo->bind(':bs4',$bs4);
    $pdo->bind(':bs5',$bs5);
    $pdo->bind(':bs6',$bs6);
    $pdo->bind(':bs7',$bs7);
    $pdo->bind(':bs8',$bs8);
    $pdo->bind(':bs9',$bs9);
    $row = $pdo->row();
    $common_scoreA2 = $row['F_FOR'];
    $common_scoreB2 = $row['F_AGAINST'];
    $common_scoreC2 = $row['F_COUNT'];

    // calculating most common scorelines to save some typing work?

    $sql_x1 = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/10)*100,3) as F_PER
             FROM cfc_fixtures WHERE F_OPP = :opp AND F_ID IN (:bs0, :bs1, :bs2, :bs3, :bs4, :bs5, :bs6, :bs7, :bs8, :bs9)
             GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC limit 1,2";
    $pdo->query($sql_x1);
    $pdo->bind(':opp',$opp);
    $pdo->bind(':bs0',$bs0);
    $pdo->bind(':bs1',$bs1);
    $pdo->bind(':bs2',$bs2);
    $pdo->bind(':bs3',$bs3);
    $pdo->bind(':bs4',$bs4);
    $pdo->bind(':bs5',$bs5);
    $pdo->bind(':bs6',$bs6);
    $pdo->bind(':bs7',$bs7);
    $pdo->bind(':bs8',$bs8);
    $pdo->bind(':bs9',$bs9);
    $row = $pdo->row();
    $common_scoreA3 = $row['F_FOR'];
    $common_scoreB3 = $row['F_AGAINST'];
    $common_scoreC3 = $row['F_COUNT'];



/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////           BEGIN OUTPUT          
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

$title =  "Statistical Preview: Chelsea vs {$team}";

// first Data
$data  =  '<img class="aligncenter size-full wp-image-6527" src="https://thechels.co.uk/media/uploads/sp_master.gif" alt="Statistical Preview - ChelseaStats">';

// append
$data .=   "<p style='text-align:justify;'><strong>Chelsea face ^_{$team_replacer} for the ". $go->numsuffix($total) ." time in all competitions, The Blues have won {$tot02} ({$tot03}%), drawn {$tot04} ({$tot05}%) and lost {$tot06} ({$tot07}%) of the previous {$tot01} matches.</strong></p>
            <p style='text-align:justify;'>Chelsea have scored {$tot08} goals against ^_{$team_replacer}, averaging {$tot09} goals per game (gpg) and have conceded {$tot10} times ({$tot11} gpg). The Blues have kept {$tot12} ({$tot13}%) clean sheets and have failed to score {$tot14} ({$tot15}%) times.</p>
            <p style='text-align:justify;'>The Pensioners have won {$loc02} ({$loc03}%), drawn {$loc04} ({$loc05}%) and lost {$loc06} ({$loc07}%) of the {$loc01} games played {$location}. Chelsea have scored {$loc08} goals against {$team} {$location}, averaging {$loc09} goals per game, The Blues have conceded {$loc10} times, averaging {$loc11} goals per game. Chelsea have kept {$loc12} ({$loc13}%) clean sheets and have failed to score on {$loc14} ({$loc15}%) occasions.</p> 
            <p style='text-align:justify;'>In the {$competition} Chelsea have won {$comp02} ({$comp03}%), drawn {$comp04} ({$comp05}%) and lost {$comp06} ({$comp07}%) of the {$comp01} games played against {$team}. Chelsea have scored {$comp08} goals in the competition ({$comp09} gpg) and have conceded {$comp10} times ({$comp11} gpg). The Blues have kept {$comp12} ({$comp13}%) clean sheets and have failed to score on {$comp14} ({$comp15}%) occasions.</p>
            ";

$data .=  "[cs]Chels Stat[/cs]";

$data .=   "<p style='text-align:justify;'>{$location}, in the {$competition} Chelsea have won {$l_comp02} ({$l_comp03}%), drawn {$l_comp04} ({$l_comp05}%) and lost {$l_comp06} ({$l_comp07}%) of the {$l_comp01} games played against {$team}. Chelsea have scored {$l_comp08} goals ({$l_comp09} gpg) and have conceded {$l_comp10} times ({$l_comp11} gpg). The Blues have kept {$l_comp12} ({$l_comp13}%) clean sheets and have failed to score on {$l_comp14} ({$l_comp15}%) occasions.</p>
            <p style='text-align:justify;'>Compared to in the {$competition} as a whole where Chelsea have won {$ecomp02} ({$ecomp03}%), drawn {$ecomp04} ({$ecomp05}%) and lost {$ecomp06} ({$ecomp07}%). Chelsea have scored {$ecomp08} goals in the competition ({$ecomp09} gpg), The Blues have conceded {$ecomp10} times ({$ecomp11} gpg). The Blues have kept {$ecomp12} ({$ecomp13}%) clean sheets and have failed to score in {$ecomp14} ({$ecomp15}%) attempts.</p> 
            <p style='text-align:justify;'>The Blues have won {$limit02} ({$limit03}%), drawn {$limit04} ({$limit05}%) and lost {$limit06} ({$limit07}%) of the previous {$limit01} matches. Chelsea have scored {$limit08} goals against {$team} ({$limit09} gpg), The Blues have conceded {$limit10} times ({$limit11} gpg).  The Blues have kept {$limit12} ({$limit13}%) clean sheets and have failed to score {$limit14} ({$limit15}%) times.</p>
            <p style='text-align:justify;'>The most common scoreline between the sides is {$common_scoreA0}-{$common_scoreB0} with {$common_scoreC0} occurrences, the next most common is {$common_scoreA1}-{$common_scoreB1} with {$common_scoreC1}.</p>";

            // ==================================== 
            $sql = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/(SELECT COUNT(*) FROM cfc_fixtures WHERE F_OPP = '$opp'))*100,3) as F_PER
                    FROM cfc_fixtures WHERE F_OPP = '$opp' GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC";
 $data .= returnDataTable( $sql, 'small');
            // ==================================== 

$data .=  "<p style='text-align:justify;'>In the last 10 games Chelsea have won {$common_scoreC2} games by {$common_scoreA2}-{$common_scoreB2} scoreline, the next most common is {$common_scoreA3}-{$common_scoreB3} with {$common_scoreC3}.</p>";

            // ====================================
            $sql_x0 = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/10)*100,3) as F_PER
                       FROM cfc_fixtures WHERE F_OPP = '$opp' AND F_ID IN ('$bs0','$bs1','$bs2','$bs3','$bs4','$bs5','$bs6', '$bs7','$bs8','$bs9')
                       GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC, F_FOR DESC, F_AGAINST DESC";
 $data .= returnDataTable( $sql_x0, 'small');
            // ==================================== 

$data .=   "<p style='text-align:justify;'>The Referee assigned to the game is {$referee}. Chelsea have won {$ref02} ({$ref03}%), drawn {$ref04} ({$ref05}%) and lost {$ref06} ({$ref07}%) of the {$ref01} games played with {$referee} as the official. Chelsea have scored {$ref08} goals ({$ref09} gpg) and have conceded {$ref10} times ({$ref11} gpg). The Blues have kept {$ref12} ({$ref13}%) clean sheets and have failed to score in {$ref14} ({$ref15}%) attempts with this official in charge.</p>
            <p style='text-align:justify;'>Chelsea have won {$limitref02} ({$limitref03}%), drawn {$limitref04} ({$limitref05}%) and lost {$limitref06} ({$limitref07}%) of the last {$limitref01} games played with {$referee} at the whistle. Chelsea have scored {$limitref08} goals, averaging {$limitref09} goals per game and have conceded {$limitref10} times ({$limitref11} gpg). The Blues have kept {$limitref12} ({$limitref13}%) clean sheets and have failed to score in {$limitref14} ({$limitref15}%) attempts in games with this official.</p>
            <p style='text-align:justify;'>{$referee} has given Chelsea {$eve01} cautions and sent off {$eve02} whilst awarding {$eve06} against us. He has yellow carded {$eve04} and sent off {$eve05} of the opposition and awarded us {$eve03} in the last 5 games he has officiated.</p>";

$data .= "[rs]Ref stat[/rs]";

	$m_special = "SELECT SUM(IF(F_RESULT='W' ,1,0)) AS W, SUM(IF(F_RESULT='D' ,1,0)) AS D, SUM(IF(F_RESULT='L' ,1,0)) AS L, count(*) AS T
				  FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like '{$manager}%' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";
	$pdo->query($m_special);
	$m_special = $pdo->row();
	$mW   = $m_special['W'];
	$mD   = $m_special['D'];
	$mL   = $m_special['L'];
	$mT   = $m_special['T'];

$data .=  "<p style='text-align:justify;'> {$manager} has won {$mW}, drawn {$mD} and lost {$mL} of his {$mT} games in charge at the club</p>";

$mgr = str_replace("_"," ",$mgr);

$data .=  "<h3>Managerial record</h3>";

            // ==================================== 
            $sql_z = "SELECT SUM(IF(F_RESULT = 'W' = 1,1,0)) AS F_WON, SUM(IF(F_RESULT = 'D' = 1,1,0)) AS F_DRAW, SUM(IF(F_RESULT = 'L' = 1,1,0)) AS F_LOSS,
                     SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(IF(F_AGAINST = '0' = 1,1,0)) AS F_CLEAN, SUM(IF(F_FOR = '0' = 1,1,0)) AS F_FAILED,
                     count(*) as F_TOTAL FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like '{$manager}%' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE ";
 $data .= returnDataTable( $sql_z, 'mgrALL');
            // ==================================== 
            
$mgro = explode(',',$omgr);
$mgro = ucwords(strtolower($mgro[1].' '.$mgro[0]));

if($omgr == '0') {
	$data .=  "<p style='text-align:justify;'>Chelsea face {$mgro} as an opposition manager for the first time.</p>";
	
} else {
	$data .=  "<p style='text-align:justify;'>Chelsea have faced {$mgro} managed sides on {$omPLD} occasions having won {$omW} and drawn {$omD} of games in all competitions against his sides since our first meeting in {$omFirst}.</p>";
}
            // ==================================== 
            $qmgrz = "SELECT PLD, W, D, L, PPG, First, Last FROM 0V_base_oppoMgr WHERE FullName = '$omgr'";
$data .= returnDataTable( $qmgrz, 'mgrALL');
            // ==================================== 
$data .=  "<p>some {$team} stats</p>";
$data .=  "<ul>
           <li>Chelsea </li>
           <li>^_{$team_replacer} </li>
           </ul>";
$data .=  "[os]oppo stat[/os]";
$data .=  "<p>some {$team} stats</p>";

   $q_opp = $go->_Q($friendly);

   if($comp == 'PREM') {

	                $data .= '<h3>Goals for and against by 15 minutes</h3>';
	                $data .= '<p>Premier league goals grouped into 15 minute blocks this season, blocks 30-45 and 75-90 include stoppage time</p>';
	                $sql  = "SELECT '0-14' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
				    AND a.F_MINUTE >='0' AND a.F_MINUTE <= '14' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					UNION ALL
					SELECT '15-29' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
					AND a.F_MINUTE >='15' AND a.F_MINUTE <= '29' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					UNION ALL
					SELECT '30-45' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
					AND  a.F_MINUTE >='30' AND a.F_MINUTE <= '45' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					UNION ALL
					SELECT '46-59' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
					AND  a.F_MINUTE >='46' AND a.F_MINUTE <= '59' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					UNION ALL
					SELECT '60-74' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
					AND  a.F_MINUTE >='60' AND a.F_MINUTE <='74' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					UNION ALL
					SELECT '75-90' AS F_MIN15, SUM(IF((F_TEAM = 1)=1,1,0)) AS F, SUM(IF((F_TEAM = 0)=1,1,0)) AS A FROM cfc_fixture_events a, cfc_fixtures b WHERE b.F_ID = a.F_GAMEID
					AND  a.F_MINUTE >='75' AND a.F_MINUTE <= '90' AND a.F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL')
					AND b.F_COMPETITION = 'PREM'
					AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') GROUP BY F_MIN15
					ORDER BY F_MIN15 ASC";
	                $data .= returnDataTable( $sql, 'small');
	                //================================================================================

	   $data .=  "<p>some {$team} stats</p>
           <ul>
               <li>Chelsea </li>
               <li>^_{$team_replacer} </li>
           </ul>";

	   $data .=  $go->get_HeadlineStats($friendly);

                    $data .=  '<h3>Records When Scoring First</h3>';
				    $sql = "SELECT SUM(W) AS W, SUM(D) AS D, SUM(L) AS L FROM 0V_base_PL_this_1S";
				    $return_data = $go->getLast100($sql);
	                $first_100_win  = $return_data['W'];
	                $first_100_draw = $return_data['D'];
	                $first_100_loss = $return_data['L'];
					$total = $first_100_win + $first_100_draw + $first_100_loss;
                    $data .= "<p>Over the last {$total} Premier League matches in which a team has scored the game's first goal, that team that has gone on to win {$first_100_win}, draw {$first_100_draw} and lose {$first_100_loss} times.</p>";
                    //================================================================================
                    $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
					SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
					FROM 0V_base_PL_this_1S
					WHERE Team in ('Chelsea','$q_opp')
					GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
                    $data .= returnDataTable( $sql, 'Scoring 1st');
                    //================================================================================

                    $data .= '<h3>Records When Conceding First</h3>';
                    //================================================================================
                    $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
					SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
					FROM 0V_base_PL_this_1C
					WHERE Team in ('Chelsea','$q_opp')
					GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
                    $data .= returnDataTable( $sql, 'Conceding 1st');
                    //================================================================================


                    $data .=  '<h3>Records When Winning at HT</h3>';

	                $sql = "SELECT SUM(W) AS W, SUM(D) AS D, SUM(L) AS L FROM 0V_base_PL_this_W_HT";
	                $return_data = $go->getLast100($sql);
	                $half_100_win   = $return_data['W'];
					$half_100_draw  = $return_data['D'];
					$half_100_loss	= $return_data['L'];
	                $total = $half_100_win + $half_100_draw + $half_100_loss;

                    $data .= "<p>Over the last {$total} Premier League games, in which a team has been winning at the interval, that team has gone on to win {$half_100_win}, draw {$half_100_draw} and lose {$half_100_loss} times.</p>";
                    //================================================================================
                    $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
                           SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
                           FROM 0V_base_PL_this_W_HT
                           WHERE Team in ('Chelsea','$q_opp')
                           GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
                    $data .= returnDataTable( $sql, 'Winning @ HT');
                    //================================================================================

                    $data .=  '<h3>Records When Losing at HT</h3>';
                    //================================================================================
                    $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
                           SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
                           FROM 0V_base_PL_this_L_HT
                           WHERE Team in ('Chelsea','$q_opp')
                           GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
                    $data .= returnDataTable( $sql, 'Losing @ HT');
                    //================================================================================

                    $data .=  '<h3>Potential Milestones</h3>';
                    $data .= "<p>Premier League milestones achievable in this game are listed below, they relate to results by certain scorelines or counts of clean sheets etc by team or as a league total.</p>";
                    
                    if($team == $friendly) {
                        
                        //================================================================================
                        $sql = "SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='$team' and L != '$loc'
								UNION ALL
				                SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='LEAGUE WIDE'
				                UNION ALL
				                SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='CHELSEA' and L = '$loc'
			            		ORDER BY F_TOTAL DESC";
                        $data .= returnDataTable($sql, 'Miles');
                        //================================================================================
                        // Team, PLD, W, D, L, FS, CS, BTTS, F,  A, GD, round(sum(PTS)/sum(PLD),3) PPG, PTS                  
                        
                    } else {
                        
                        //================================================================================
                        $sql = "SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='$team' and L != '$loc'
								UNION ALL
				              	SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='$friendly' and L != '$loc'
				                UNION ALL
				                SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='LEAGUE WIDE'
				                UNION ALL
				                SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N ='CHELSEA' and L = '$loc'
			            		ORDER BY F_TOTAL DESC";
                        $data .= returnDataTable($sql, 'Miles');
                        //================================================================================
                        // Team, PLD, W, D, L, FS, CS, BTTS, F,  A, GD, round(sum(PTS)/sum(PLD),3) PPG, PTS
                    }
                }


////////////////////////// create preview //////////////////////////
		print  '<div class="alert alert-info">Now try pre-process!!!</div>';

		$replacer = new replacer();
		$data = $replacer->cfc_replace_content_pre($data);

        print  '<div class="alert alert-info">Now try to insert the data!!!</div>';

		$date       = date( 'Y-m-d' );
		$post_array = array (
			'post_title'    => $title,
			'post_name'     => $title .'-'. $date,
			'post_content'  => $data,
			'post_author'   => 1,
			'post_category' => array ( '565' )
		);
		// Insert the post into the database
		$post_id = wp_insert_post( $post_array );
	
        if ( -1 == $post_id || -2 == $post_id ) {
				// The post wasn't created or the page already exists
				print '<div class="alert alert-warning">Error creating post: ' . $title . ' (reason: ' . $post_id . ')</div>';
		} else {	
                //success
				print  '<div class="alert alert-success">'. $post_id . ' :- ' . $title . '</div>';
		}

        print  '<div class="alert alert-info">It finished!!!</div>';
        
////////////////////////// end preview //////////////////////////

} else {

//////////////////////////////////////////////////////////////////////////
/////////////////////
/////////////////////        BEGIN FORM                
/////////////////////
//////////////////////////////////////////////////////////////////////////
?>

	<label for="form1">Harmonic Generator</label>
	<form name = "form1" id="form1" method = "POST" action = "<?php the_permalink()?>">

		<label for="opposition-selector">Opposition</label>
		<select name = "opp" id = "opposition-selector" class = "form-control">
			<option value = "" class = "bolder"> -- Choose a Club --</option>
			<?php
				$pdo = new pdodb();
				$pdo->query("SELECT DISTINCT F_OPP FROM cfc_fixtures WHERE F_OPP IS NOT NULL ORDER BY F_OPP ASC");
				$rows = $pdo->rows();
				foreach ($rows as $row) {
					$f1  =  $go->_V($row["F_OPP"]);
					$f2  =  $go->_Q($row["F_OPP"]);
					print "<option value = '{$f2}'>{$f1}</option>";
				}
			?>
		</select>

		<br/>
		<label for="location-selector">Location</label>
		<select name = "loc" id = "location-selector" class = "form-control">
			<option value = "" class = "bolder"> -- Choose Location --</option>
			<option value = "H">Home</option>
			<option value = "A">Away</option>
			<option value = "N">Neutral</option>
		</select>
		<br/>
		<label for="comp-selector">Competition</label>
		<select name = "comp" id="comp-selector" class = "form-control">
			<option value = "" class = "bolder"> -- Choose Competition --</option>
			<?php
				$pdo->query("SELECT DISTINCT F_COMPETITION FROM cfc_fixtures WHERE F_COMPETITION IS NOT NULL ORDER BY F_COMPETITION ASC");
				$rows = $pdo->rows();
				foreach ($rows as $row) {
					$f1  =  $row["F_COMPETITION"];
					print "<option value = '{$f1}'>{$f1}</option>";
				}
			?>
		</select>
		<br/>
		<label for="referee-selector">Referee</label>
		<select name = "ref" id = "referee-selector" class = "form-control">
			<option id = "refsel" value = "" class = "bolder"> -- Choose Referee --</option>
			<?php
				$pdo->query("SELECT DISTINCT F_REF FROM cfc_fixtures WHERE F_REF IS NOT NULL ORDER BY F_REF ASC");
				$rows = $pdo->rows();
				foreach ($rows as $row) {
					$f1  =  $row["F_REF"];
					print "<option value = '{$f1}'>{$f1}</option>";
				}
			?>
		</select>
		<br/>
		<label for="omanager-selector">Opposition Manager</label>
		<select name = "omgr" id = "omanager-selector" class = "form-control">
			<option id = "omgrself" value = "0" class = "bolder"> -- Choose Manager --</option>
			<?php
				$pdo->query("SELECT DISTINCT FullName FROM 0V_base_oppoMgr WHERE FullName IS NOT NULL ORDER BY FullName ASC");
				$rows = $pdo->rows();
				foreach ($rows as $row) {
					$f1  =  $row["FullName"];
					print "<option value = '{$f1}'>{$f1}</option>";
				}
			?>
		</select>
		<br/>
		<div class="form-group">
			<label for="friendly">friendly:</label>
			<input name="friendly"   type="text" id="friendly">
		</div>
		<br/>
		<input type = "submit" name = "Submit" value = "Submit" class = "btn btn-primary">
	</form>
<?php } ?>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class = "clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
