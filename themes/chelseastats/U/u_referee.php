<?php /* Template Name: # U Referees */ ?>
<?php get_header();?>
<?php
// declare table names

	$cc = $_GET['ref'];

	$page = get_permalink($post->ID);
	if (strpos($page,'ladies') !== false) {

		$title = 'Chelsea Ladies';

		$fixtures = 'wsl_fixtures';

		$refsql = "SELECT F_OPP as L_TEAM, CONCAT(F_ID,',',F_DATE) as LX_DATE, F_COMPETITION AS L_COMPETITION, F_LOCATION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF AS L_REF, F_NOTES
            from wsl_fixtures where F_REF='$cc' ORDER BY F_DATE DESC";

		$drop_down = "SELECT DISTINCT F_REF AS L_REF FROM wsl_fixtures WHERE F_REF IS NOT NULL ORDER BY F_REF ASC";

		$mainquery = "select F_REF as L_REF, SUM(IF(F_RESULT='W'=1,1,0)) as win, SUM(IF(F_RESULT='D'=1,1,0)) as draw, SUM(IF(F_RESULT='L'=1,1,0)) as loss,
                  ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
                  ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
                  ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
                  ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
                  ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
                  SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
                  SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
                  SUM(F_FOR) AS F_FOR,
                  SUM(F_AGAINST) AS F_AGAINST,
                  SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
                  ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG,
                  MIN(F_DATE) AS F_FIRST, MAX(F_DATE) AS F_LAST, COUNT(*) AS F_COUNT from wsl_fixtures WHERE F_REF!='UNKNOWN'
                  GROUP BY F_REF ORDER BY F_LAST DESC, F_COUNT";

		$querycc = "SELECT SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
                ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS winper,
                ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS drawper,
                ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS lossper,
                count(*) AS total FROM wsl_fixtures a WHERE F_REF=:cc ";

		$ref_rank = "select F_LOCATION as LOC, count(*) as F_PLD, SUM(IF(F_RESULT='W'=1,1,0)) as win, SUM(IF(F_RESULT='D'=1,1,0)) as draw, SUM(IF(F_RESULT='L'=1,1,0)) as loss,
                ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
                ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
                ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
                ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
                ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
                SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
                SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
				ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
                ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
                from wsl_fixtures WHERE F_REF='$cc'
                GROUP BY LOC ORDER BY LOC DESC";

		$query   = "SELECT SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
		ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
		ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
		ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
		ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
		ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
		ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
		ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
		ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
		ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
		ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS winper,
		ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS drawper,
		ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS lossper,
		count(*) AS total FROM wsl_fixtures";


	} else {

		$title = 'Chelsea';

		$fixtures = 'cfc_fixtures';

		$refsql = "SELECT F_OPP as M_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF AS M_REF, F_NOTES
               from cfc_fixtures where F_REF='$cc' ORDER BY F_DATE DESC";

		$drop_down = "SELECT DISTINCT F_REF AS F_REF FROM cfc_fixtures WHERE F_REF IS NOT NULL ORDER BY F_REF ASC";

		$mainquery = "select F_REF, SUM(IF(F_RESULT='W'=1,1,0)) as win, SUM(IF(F_RESULT='D'=1,1,0)) as draw, SUM(IF(F_RESULT='L'=1,1,0)) as loss,
                  ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
                  ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
                  ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
                  ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
                  ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
                  SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
                  SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
                  SUM(F_FOR) AS F_FOR,
                  SUM(F_AGAINST) AS F_AGAINST,
                  SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
                  ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG,
                  MIN(F_DATE) AS F_FIRST, MAX(F_DATE) AS F_LAST, COUNT(*) AS F_COUNT from cfc_fixtures WHERE F_REF!='UNKNOWN'
                  GROUP BY F_REF ORDER BY F_LAST DESC, F_COUNT";

		$querycc = "SELECT SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
                ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
                ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
                ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
                ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS winper,
                ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS drawper,
                ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS lossper,
                count(*) AS total FROM cfc_fixtures a WHERE F_REF=:cc ";

		$ref_rank = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS, F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED,
					F_FOR, F_AGAINST, F_GD, F_GFPG, F_GAPG, F_POINTS, A_POINTS, F_PPG FROM 0V_base_REFRANK
					WHERE Referee='$cc' ORDER BY F_ORDER ASC";

		$ref_mean = "
					SELECT 'Mean' as LOC,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures where F_REF !='$cc'
					and F_DATE >= (select min(F_DATE) from cfc_fixtures where F_REF= '$cc')
					and F_DATE <= (select max(F_DATE) from cfc_fixtures where F_REF= '$cc')
					GROUP BY LOC";




		$query = "SELECT SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
              ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
              ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
              ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
              ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
              ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
              ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
              ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
              ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
              ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
              ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS winper,
              ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS drawper,
              ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS lossper,
              count(*) AS total FROM cfc_fixtures";
	}
?>
	<div id="content">
		<h4 class="special"><?php echo $title; ?> - Results by Official : <?php if (isset($cc))  { print $go->displayRef($cc); } else { echo "All Officials "; } ?></h4>
		<div class="row-fluid">
			<div class="span4 offset8">
				<div id="filter-2" class="widget widget_archive">
		            <span class="form-filter">
		                <label>
			                <select name = "filter-dropdown"
			                        onchange = "document.location.href=this.options[this.selectedIndex].value;">
				                <option value = "">Referee Filter</option>
				                <?php
				                $pdo = new pdodb();
				                $pdo->query($drop_down);
				                $rows = $pdo->rows();
				                foreach($rows as $row) {
				                $f1 = $row["F_REF"];
				                ?>
				                <option value = "<?php the_permalink() ?>?ref=<?php echo $f1; ?>"><?php echo $f1; ?></option>
				                <?php } ?>
			                </select>
		                </label>
		            </span>
				</div>
			</div>
		</div>
<?php
			if (isset($cc)) {
				$pdo = new pdodb();
				$pdo->query($querycc);
				$pdo->bind(':cc',$cc);
				$row = $pdo->row();
			} else  {
				$pdo = new pdodb();
				$pdo->query($query);
				$row = $pdo->row();
			}

			$f001 = $row['hwin'];
			$f002 = $row['hdraw'];
			$f003 = $row['hloss'];
			$f004 = $row['awin'];
			$f005 = $row['adraw'];
			$f006 = $row['aloss'];
			$f011 = $row['nwin'];
			$f012 = $row['ndraw'];
			$f013 = $row['nloss'];
			$f007 = $row['winper'];
			$f008 = $row['drawper'];
			$f009 = $row['lossper'];
			$f010 = $row['total'];

			if(isset($f001) && $f001<>'') { print $go->_comparebars3('Home'	 ,$f001,$f002,$f003);}
			if(isset($f004) && $f004<>'') { print $go->_comparebars3('Away'	 ,$f004,$f005,$f006);}
			if(isset($f011) && $f011<>'') { print $go->_comparebars3('Neutral'  ,$f011,$f012,$f013);}
			if(isset($f007) && $f007<>'') { print $go->_comparebars3('Total'	 ,$f007,$f008,$f009);}

			if(isset($cc)) {

				print '<h3>Location Summary</h3>';

				print $go->getTableKey();

				//================================================================================	
				outputDataTable( $ref_rank, 'Ref-loc-summary');
				//================================================================================

				if($title == 'Chelsea') {
					print "<p>mean equates to the overall record across all other referees between the start and end (latest) match of this official</p>";
					//================================================================================
					outputDataTable( $ref_mean, 'Ref-mean' );
					//================================================================================
				}


				print '<h3>Match Summary</h3>';
				
	//================================================================================
		outputDataTable( $refsql, 'Referee-match-summary');
	//================================================================================
	
} else {

				print '<h3>Summary</h3>';
				//================================================================================
				outputDataTable( $mainquery, 'Referee-overall');
				//================================================================================
			}
?>
		<div style="clear:both;"><p>&nbsp;</p></div>
	</div>
<?php get_footer(); ?>