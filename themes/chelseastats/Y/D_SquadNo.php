<?php /* Template Name: # D Squad No. */ ?>
<?php $field = $_GET['year']; ?>

<?php get_header(); ?>
<div id="content">
    <div id="horizontalcontainer">
        <h4 class="special">Players by Squad Number and start/end date of assignment.</h4>
        <p>Squad numbers prior to the years shown below were assigned to the player/position in the matchday squad rather than to a
        player over the course of a season so they have been excluded.</p>

		<h3>Historic List</h3>
		<?php
			//================================================================================
			$sql = "SELECT F_SQUADNO, F_NAME as N_LINK_NAME, F_START as S_DATE, F_END AS E_DATE
					FROM meta_squadno  ORDER BY F_SQUADNO ASC, S_DATE ASC, E_DATE ASC, N_LINK_NAME ASC";
			outputDataTable( $sql, 'small');
			//================================================================================

		?>
		<?php get_footer(); ?>