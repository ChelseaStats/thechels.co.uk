<?php /*  Template Name: # U StatsReport */ ?>
<?php get_header(); ?>
<?php
          $opp 	= isset($_GET['team']) ? $_GET['team'] : 'CHELSEA'; 
          $team = $go->_Q($opp);
          $visual_team 	= $go->_V($opp);
?>
<div id="content">
<div id="contentleft">
<h4 class="special"> <?php the_title(); ?> - <?php print $visual_team; ?></h4>
    <div class="row-fluid">
        <div class="span6 offset6">
            <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <label>Pick a team :<br/>
	                <select name = "filter-dropdown"
	                        onchange = "document.location.href=this.options[this.selectedIndex].value;">
		                <option value = "">Team filter</option>
		                <?php
          $pdo = new pdodb();
          $pdo->query("SELECT DISTINCT Team FROM 0V_base_current_pl_teams ORDER BY Team ASC");
		                $rows = $pdo->rows();

		                foreach($rows as $row){
		                $vt_form = $go->_V($row["Team"]);
		                $qt_form = $go->_Q($row["Team"]);
		                ?>
		                <option
			                value = "<?php the_permalink() ?>?team=<?php echo $qt_form; ?>"><?php echo $vt_form; ?></option>
		                <?php
          }
                    ?>
	                </select>
                </label>
                </span>
            </div>
        </div>
    </div>
<p><br/></p>
<?php if (isset($opp) && $opp !='') { ?>
<h3>Latest 10 Results for <?php print $visual_team; ?></h3>
<?php
          //================================================================================
          $sql="SELECT F_DATE as N_DATE, F_HOME AS H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY AS A_TEAM
	      FROM all_results where ( F_HOME='$team' OR F_AWAY='$team') order by F_DATE DESC LIMIT 10";
          outputDataTable( $sql, 'RESULTS');
          //================================================================================
?>
<h3>Team Records vs League groupings and Status Types</h3>
<?php
          //================================================================================
          $sql="SELECT 'PL' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_PL_this WHERE Team = '$team' GROUP BY LOC
	UNION ALL
	      	SELECT 'Last38' as Type, 'All' as LOC, Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_last38 WHERE Team ='$team' 
	UNION ALL
		SELECT  'Big7' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_BIG_this
	      WHERE Team = '$team'
	      GROUP BY LOC
	UNION ALL
		SELECT  'T13' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_T13_this
	      WHERE Team = '$team'
	      GROUP BY LOC
	UNION ALL
		  SELECT  'ever6' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_EVER_this
	      WHERE Team = '$team'
	      GROUP BY LOC
	UNION ALL
		  SELECT 'B7vT13' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_PRJ_this
	      WHERE Team = '$team'
	      GROUP BY LOC
	UNION ALL
		  SELECT 'LDN' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_LDN_this
	      WHERE Team = '$team' 
	      GROUP BY LOC
	UNION ALL
		  SELECT 'Close' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
	      FROM 0V_base_close_this
	      WHERE Team = '$team' 
	      GROUP BY LOC
	UNION ALL
        SELECT 'W @ HT' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	     SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	     FROM 0V_base_PL_this_W_HT
	     WHERE Team = '$team'
	     GROUP BY LOC
	UNION ALL
        SELECT 'L @ HT' as Type, LOC, Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	    SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	    FROM 0V_base_PL_this_L_HT
	    WHERE Team = '$team'
	    GROUP BY LOC";
        
          outputDataTable( $sql, 'OVERALL');
          //================================================================================
          // Team, PLD, W, D, L, FS, CS, BTTS, F,  A, GD, round(sum(PTS)/sum(PLD),3) PPG, PTS 


          print '<h3>Milestones</h3>';
          //================================================================================
          $sql = "SELECT C as N_COMP, L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles WHERE N in ('$team') ORDER BY V DESC";
          outputDataTable( $sql, 'Miles');
          //================================================================================
          // Team, PLD, W, D, L, FS, CS, BTTS, F,  A, GD, round(sum(PTS)/sum(PLD),3) PPG, PTS

	      // includes headers
		  print $go->get_HeadlineStats($team);


?>
<?php if ($team != 'CHELSEA') { ?>
	<h3>Latest 10 Results vs Chelsea</h3>
	<?php
          //================================================================================
          $sql="SELECT F_HOME AS H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY AS A_TEAM
		      FROM all_results where ( (F_HOME='$team' and F_AWAY ='CHELSEA') OR
		      (F_AWAY='$team' and F_HOME ='CHELSEA') ) order by F_DATE DESC LIMIT 10";
          outputDataTable( $sql, 'resvcfc');
          //================================================================================
    ?>
	<h3>Chelsea's home goals record vs <?php print $visual_team; ?></h3>
	<?php
          //================================================================================
          $sql8 = "SELECT F_HGOALS as F, F_AGOALS as A, count(*) AS F_COUNT FROM all_results WHERE F_AWAY='$team' and F_HOME='CHELSEA' GROUP BY F_HGOALS, F_AGOALS ORDER BY F_COUNT DESC";
          outputDataTable( $sql8, 'homerec');
          //================================================================================
    ?>
	<h3>Chelsea's away goals record vs <?php print $visual_team; ?> </h3>
	<?php
          //================================================================================
          $sql8 = "SELECT F_AGOALS as F, F_HGOALS as A, count(*) AS F_COUNT FROM all_results WHERE F_HOME='$team' and F_AWAY='CHELSEA' GROUP BY F_AGOALS, F_HGOALS ORDER BY F_COUNT DESC";
          outputDataTable( $sql8, 'awayrec');
          //================================================================================
      } // end if

	?>
		<h3>Seasonal record of <?php print $visual_team; ?> </h3>
	<?php
		 //================================================================================
		 $sql="SELECT year as F_YEAR, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
 			   FROM 0V_base_PL_year WHERE team = '$team' group by year, team";
		 outputDataTable( $sql, 'RESULTS');
		 //================================================================================
	?>
	<h3>Seasonal record of <?php print $visual_team; ?> by home/away split</h3>
	<?php
		 //================================================================================
		 $sql="SELECT year as F_YEAR, LOC, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_PL_year WHERE team = '$team' ";
		 outputDataTable( $sql, 'RESULTS');
		 //================================================================================
	?>
	<h3>Oppo rank vs <?php print $visual_team; ?> </h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM (
			select A.F_HOME AS Team,count(A.F_HOME) AS PLD,sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS,sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,sum(A.F_HGOALS) AS F,sum(A.F_AGOALS) AS A,sum((A.F_HGOALS - A.F_AGOALS)) AS GD,round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
			from all_results A where A.F_AWAY in ('$team') group by A.F_HOME
			union all
			select B.F_AWAY AS Team,count(B.F_AWAY) AS PLD,sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS,sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,sum(B.F_AGOALS) AS F,sum(B.F_HGOALS) AS A,sum((B.F_AGOALS - B.F_HGOALS)) AS GD,round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
			from all_results B where B.F_HOME in  ('$team') group by B.F_AWAY
		) b
		GROUP BY Team
		ORDER BY PTS DESC, GD DESC, F DESC, PPG DESC, Team DESC";
	outputDataTable( $sql, 'RESULTS');
	//================================================================================
	?>
	<h3>Oppo rank at <?php print $visual_team; ?> </h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM ( select B.F_AWAY AS Team,count(B.F_AWAY) AS PLD, sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D, 
		sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L, sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,sum(B.F_AGOALS) AS F,
		sum(B.F_HGOALS) AS A,sum((B.F_AGOALS - B.F_HGOALS)) AS GD,round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
		sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
			from all_results B where B.F_HOME in  ('$team') group by B.F_AWAY
		) b
		GROUP BY Team
		ORDER BY PTS DESC, GD DESC, F DESC, PPG DESC, Team DESC";
	outputDataTable( $sql, 'RESULTS');
	//================================================================================
      } // end if
    ?>
<?php print $go->getTableKey();?>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
<?php get_footer(); ?>