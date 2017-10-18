<?php /* Template Name: # Z Private Miles */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
<div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<p>Some future milestones for all premier league and Women's super league teams in various scenarios.</p>
<h3>A look at some 25, 50 and 100 level milestones for Premier League</h3>
         <?php
                //================================================================================
                $sql = "SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_miles ORDER BY V DESC";
                outputDataTable( $sql, 'Miles');
                //================================================================================
         ?>
<h3>A look at some 5, 10, 25 level milestones for WSL teams</h3>
         <?php
                //================================================================================
                $sql = "SELECT L as F_LOCATION, N as TEAM, D as N_KEY, V as F_TOTAL FROM 0t_wsl_miles ORDER BY V DESC";
                outputDataTable( $sql, 'Miles');
                //================================================================================
         ?>
<h3>Player and former player birthdays this month</h3>
         <?php
                //================================================================================
                $sql = "SELECT F_NAME AS F_NAME , F_DOB as N_DATE FROM cfc_dobs  WHERE MONTH(F_DOB) = (SELECT (MONTH( NOW( ) ) )) ORDER BY DAY(F_DOB) ASC";
                outputDataTable( $sql, 'Miles');
                //================================================================================
        ?>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
