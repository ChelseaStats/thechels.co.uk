<?php  /* Template Name: # D ExG */ ?>
<?php get_header(); ?>
	<div id="content">
			<h4 class="special">Expected Goals Statistics</h4>

		<p>The statistics below are based on the Paul Riley ( <a href="http://twitter.com/FootballFactMan">@footballfactman</a>) Expected Goals model, an explanation of which can be seen
			<a href="https://differentgame.wordpress.com/2014/05/19/a-shooting-model-an-expglanation-and-application/">at his blog Differentgame</a>.</p>
		<p>The tables will be updated from time to time as the model gets upgraded and validated.</p>

		<p>Common key for tables:

		<?php print $go->getTooltip('ExpGF','Expected Goals For'); ?>,
		<?php print $go->getTooltip('ExpGA','Expected Goals Against');  ?>,
		<?php print $go->getTooltip('ExpGD','Expected Goal Difference');  ?>,
		<?php print $go->getTooltip('ExpGRatio','Expected Goal Ratio = ExpGF/(ExpGF+ExpGA)');  ?>,
		<?php print $go->getTooltip('Att Eff','Attacking Efficiency = Goals For/ExpGF');  ?>,
		<?php print $go->getTooltip('Def Eff','Defensive Efficiency = ExpGF/Goals Against');  ?>,
		<?php print $go->getTooltip('DZ SoTs F','Danger Zone Shots on Target For'); ?>,
		<?php print $go->getTooltip('DZ GF','Danger Zone Goals For'); ?>,
		<?php print $go->getTooltip('DZ sc%','Danger Zone Scoring % = (DZ GF/DZ SoTs F)*100'); ?>,
		<?php print $go->getTooltip('DZ SoTs A','Danger Zone Shots on Target Against'); ?>,
		<?php print $go->getTooltip('DZ GA','Danger Zone Goals Against'); ?>,
		<?php print $go->getTooltip('DZ sv%','Danger Zone Save % = 100-(DZ GA/DZ SoT F*100)'); ?>,
		<?php print $go->getTooltip('SoTs F','Shots on Target For'); ?>,
		<?php print $go->getTooltip('SoTs A','Shots on Target Against'); ?>,
		<?php print $go->getTooltip('SoTQual F','Shot Quality For = ExpGF/SoTs F'); ?>,
		<?php print $go->getTooltip('SoTQual A','Shot Quality Against = ExpGA/SoTs A'); ?>
		and
		<?php print $go->getTooltip('Danger Zone','The central area in front of goal up to 10 yards out between width confines of the 6 yard box'); ?>

		</p>
		<div style="clear:both; height:5px;"></div>
		<p>
			<img class="aligncenter size-full" src="/media/uploads/2014-15-exG.png" alt="Danger Zone Shots on Target - 2014-15"/>
		</p>
		<div style="clear:both; height:5px;"></div>

		<h3>Expected Goals - Premier League 2014-15</h3>
		<?php
			//================================================================================
			$sql = "SELECT Club, ExpGF, ExpGA, ExpGD, ExpGRatio, Att_Eff, Def_Eff, DZ_SoTs_F, DZ_GF, DZ_sc, DZ_SoTs_A, DZ_GA, DZ_sv, SoTs_F, SoTs_A, SoTQual_F, SoTQual_A
				FROM cfc_exG WHERE f_season ='2014-15' ORDER BY f_order ASC";
			outputDataTable( $sql, 'exG');
			//================================================================================
		?>

		<h3>Expected Goals - Premier League 2013-14</h3>
		<?php
			//================================================================================
			$sql = "SELECT Club, ExpGF, ExpGA, ExpGD, ExpGRatio, Att_Eff, Def_Eff, DZ_SoTs_F, DZ_GF, DZ_sc, DZ_SoTs_A, DZ_GA, DZ_sv, SoTs_F, SoTs_A, SoTQual_F, SoTQual_A
					FROM cfc_exG WHERE f_season ='2013-14' ORDER BY f_order ASC";
			outputDataTable( $sql, 'exG');
			//================================================================================
		?>

		<h3>Expected Goals - Premier League 2012-13</h3>
		<?php
			//================================================================================
			$sql = "SELECT Club, ExpGF, ExpGA, ExpGD, ExpGRatio, Att_Eff, Def_Eff, DZ_SoTs_F, DZ_GF, DZ_sc, DZ_SoTs_A, DZ_GA, DZ_sv, SoTs_F, SoTs_A, SoTQual_F, SoTQual_A
					FROM cfc_exG WHERE f_season ='2012-13' ORDER BY f_order ASC";
			outputDataTable( $sql, 'exG');
			//================================================================================
		?>

		<h3>Expected Goals - Premier League 2011-12</h3>
		<?php
			//================================================================================
			$sql = "SELECT Club, ExpGF, ExpGA, ExpGD, ExpGRatio, Att_Eff, Def_Eff, DZ_SoTs_F, DZ_GF, DZ_sc, DZ_SoTs_A, DZ_GA, DZ_sv, SoTs_F, SoTs_A, SoTQual_F, SoTQual_A
					FROM cfc_exG WHERE f_season ='2011-12' ORDER BY f_order ASC";
			outputDataTable( $sql, 'exG');
			//================================================================================
		?>

		<h3>Expected Goals - Premier League 2010-11</h3>
		<?php
			//================================================================================
			$sql = "SELECT Club, ExpGF, ExpGA, ExpGD, ExpGRatio, Att_Eff, Def_Eff, DZ_SoTs_F, DZ_GF, DZ_sc, DZ_SoTs_A, DZ_GA, DZ_sv, SoTs_F, SoTs_A, SoTQual_F, SoTQual_A
					FROM cfc_exG WHERE f_season ='2010-11' ORDER BY f_order ASC";
			outputDataTable( $sql, 'exG');
			//================================================================================
		?>
	</div>
	<!-- The main column ends  -->
<?php get_footer(); ?>