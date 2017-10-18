<?php /* Template Name: # D OTD */ ?>
<?php get_header();?>
<div id="content">
	<h4 class="special">
		On This Day in history
		<?php echo date("Y-m-d") ?>
	</h4>

	<p>A an archive and summary of results, notable moments from our
		history that happened on this day.</p>
	<h3>Timeline : Chelsea Match History</h3>
<?php
	$pdo = new pdodb();	
	$pdo->query("SELECT COUNT(*) AS CNT FROM cfc_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now()))");
	$row = $pdo->row();
	$num = $row["CNT"];
if ($num > 0 ) {  
	//================================================================================
	$sql = "SELECT F_OPP as M_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF
	        FROM cfc_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) ORDER BY F_DATE DESC";
	outputDataTable( $sql, 'Days Since');
	//================================================================================
} else {
	print '<p><em>No matches played</em></p>';
}
?>

	<h3>Timeline : Chelsea Ladies Match History</h3>

<?php
	$pdo->query("SELECT COUNT(*) AS CNT FROM wsl_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now()))");
	$row = $pdo->row();
	$num = $row["CNT"];
	
if ($num > 0 ) {  
	//================================================================================
	$sql = "SELECT F_OPP as L_TEAM, CONCAT(F_ID,',',F_DATE) as LX_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_FOR, F_AGAINST, F_REF
	        FROM wsl_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) ORDER BY F_DATE DESC";
	 outputDataTable( $sql, 'Days Since');
	//================================================================================
} else {
	print '<p><em>No matches played</em></p>';
}
?>

	<h3>Timeline : Manager and Player Birthdays</h3>

<?php

	$pdo->query("SELECT COUNT(*) AS CNT FROM cfc_dobs WHERE MONTH(F_DOB)=(SELECT MONTH(now())) AND DAY(F_DOB)=(SELECT DAY(now()))");
	$row = $pdo->row();
	$num = $row["CNT"];
	
if ($num > 0 ) {  
	//================================================================================
	$sql = "SELECT F_NAME as N_NAME, F_DOB, DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(F_DOB, '%Y') - (DATE_FORMAT(NOW(), '-%m-%d') < DATE_FORMAT(F_DOB, '-%m-%d')) AS F_AGE
		    FROM cfc_dobs WHERE MONTH(F_DOB)=(SELECT MONTH(now())) AND DAY(F_DOB)=(SELECT DAY(now()))";
	 outputDataTable( $sql, 'Birthdays');
	//================================================================================
 } else { 
	print "<p><em>No birthdays on this day.</em></p>"; 
 } ?>
 
	<h3>Timeline : Significant Managerial and Player Dates</h3>
	
<?php 

	$pdo->query("SELECT COUNT(*) AS CNT FROM cfc_dates WHERE MONTH(F_DATE)=(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now()))");
	$row = $pdo->row();
	$num = $row["CNT"];
	
if ($num > 0 ) { 
	//================================================================================
	$significant = "SELECT F_NAME as N_NAME, F_DATE as N_DATE, F_NOTES FROM cfc_dates WHERE MONTH(F_DATE)=(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now()))";
	 outputDataTable( $significant, 'Significant ');
	//================================================================================
 } else { 
	print "<p><em>Nothing of any significance on this day.</em></p>"; 
} ?>

	<h3>Timeline: Days Since...</h3>
	
	
<?php
	//================================================================================
	 $sql = "SELECT DATEDIFF(NOW(),F_DATE) AS F_DAYS, F_DATE as N_DATE, F_TEAM AS Team, F_COMPETITION as N_COMP, F_NOTES 
	         FROM cfc_since ORDER BY F_DATE ASC";
	 outputDataTable( $sql, 'Days Since');
	//================================================================================
 ?>
	<div class="well well-small">
		<p>Major Trophies only (League, FA Cup, League Cup,
			Community/Charity Shield, Champions League, Europa League, Club World
			Cup, and European Super Cup).</p>
	</div>
	<div style="clear: both;"></div>
	</div>
	<!-- The main column ends  -->
	<?php get_footer(); ?>
