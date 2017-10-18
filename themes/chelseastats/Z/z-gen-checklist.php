<?php /* Template Name:  # Z ** Gen Checklist */ ?>
<?php get_header(); ?>
<?php


	if (current_user_can('level_10')) : ?>
	<div id="content">
			<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?> </h4>
            <?php
	        $x              =   $_POST['F01']; //checker
	        $submit         =   $_POST['submit']; //checker
	        if (isset($x) && $submit == 'Create Issue') {

		        $checklist = new checklister();

		        switch ( $x ) {

			        case 'NEW_MGR':
				        $title = "New manager";
				        $body  = $checklist->checklist_new_manager();
				        break;
			        case 'OLD_MGR':
				        $title = "Old manager";
				        $body  = $checklist->checklist_old_manager();
				        break;
			        case 'NEW_PLYR':
				        $title = "New player";
				        $body  = $checklist->checklist_new_player();
				        break;
			        case 'OLD_PLYR':
				        $title = "Old player";
				        $body  = $checklist->checklist_old_player();
				        break;
			        case 'END':
				        $title = "End of season";
				        $body  = $checklist->checklist_end_of_season();
				        break;
			        case 'WSL':
				        $title = "WSL results";
				        $body  = $checklist->checklist_wsl_results();
				        break;
			        case 'FIN':
				        $title = "New financial year";
				        $body  = $checklist->checklist_finance();
				        break;
			        case 'CFCnonPL':
				        $title = "New fixture (non PL)";
				        $body  = $checklist->checklist_cfc_results_nonPL();
				        break;
			        case 'WSLnewLeague':
				        $title = "New Season setup (WSL)";
				        $body  = $checklist->checklist_new_wsl_season();
				        break;
			        case 'PLnewLeague':
				        $title = "New Season setup (PL)";
				        $body  = $checklist->checklist_new_pl_season();
				        break;
			        case 'CFC':
			        default:
				        $title = "New CFC result";
				        $body  = $checklist->checklist_cfc_results();
				        break;
		        }

		        print $checklist->generateIssue( $title, $body );

	        } else { ?>

		        <form method="post" action="<?php the_permalink();?>">
				      <div class="form-group">
					      <label for="F01">Select Checklist</label>
					      <select name="F01" id="F01">
						      <option value="CFC">Chelsea Results</option>
						      <option value="CFCnonPL">Chelsea Results (non-PL)</option>
						      <option value="WSL">Ladies Results</option>
						      <option value="NEW_MGR">New Manager</option>
						      <option value="OLD_MGR">Old Manager</option>
						      <option value="NEW_PLYR">New Player</option>
						      <option value="OLD_PLYR">Old PLayer</option>
						      <option value="FIN">Finance</option>
						      <option value="WSLnewLeague">New WSL Season</option>
						      <option value="PLnewLeague">New PL Season</option>
						      <option value="END">End of Season</option>
					      </select>
				      </div>
				        <div class="form-group">
				            <input name="submit" type="submit" id="submit" value="Create Issue" class="btn btn-primary"/>
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
