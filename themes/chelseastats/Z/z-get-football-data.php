<?php /* Template Name: # Z ** FootballData */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
	$hidden     = $_POST['hidden'];

	if(isset($hidden) && $hidden !='') {
		$melinda                = new melinda();
		$updater                = new updater();
		$go                     = new utility();
		$startingValue          = $go->getSeasonalDate( date('Y-m-d') );
		$yearMarker             = $go->getYearMarkerFromDate( $startingValue );
		$shortId                = $go->getShortDateID( $yearMarker );
		$thisYearNextYear       = $go->getThisYearNextYearFromDate();
		$baseFootballDataTable  = "o_tempFootballData{$yearMarker}";
		$plResultsTable         = "all_results";
		$SubsUsage_this         = "0V_SubsUsage_this";
		$footballData           = "http://www.football-data.co.uk/mmz4281/{$shortId}/E0.csv";
		$urlEPL1                = "http://www.futbol24.com/national/England/Premier-League/{$thisYearNextYear}/results/";


		$return = $updater->createFootballDataBase( $baseFootballDataTable, $footballData );
		if(isset($return) && $return > 0) {

			print $melinda->goMessage( "shots :" . $updater->updater_shots( $baseFootballDataTable), 'success');
			print $melinda->goMessage( "SOT   :" . $updater->updater_shotsOnTarget( $baseFootballDataTable), 'success');
			print $melinda->goMessage( "Fouls :" . $updater->updater_fouls( $baseFootballDataTable), 'success');
			print $melinda->goMessage( "Football-Data updated", 'success');
			
		  $sql = "SELECT F_DATE, F_HOME H_TEAM, F_AWAY A_TEAM, H_FOULS, A_FOULS, H_CARDS, A_CARDS, H_SHOTS, A_SHOTS, H_SOT, A_SOT 
							FROM {$baseFootballDataTable} ORDER BY F_ID DESC LIMIT 5";
				    outputDataTable( $sql, 'Output');
				    
				    
			$melinda->goSlack( "Football-Data updated", "UpdaterBot", "package", "bots" );
		}

	} else {
?>
	<form name="form" method="POST" action="<?php the_permalink();?>">
		<div class="form-group">
			<input type="hidden" value="hidden" name="hidden">
			<input type="submit" value="submit" class="btn btn-primary">
		</div>
	</form>

<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
