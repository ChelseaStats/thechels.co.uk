<?php /* Template Name: # i CleanSheets */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
    <?php
          $v01 = $_POST['F01']; //player
          $v02 = $_POST['F02']; //number
          $v03 = $_POST['F03']; //number      
          $submit=$_POST['submit']; //checker
          if (isset($v01) && $submit=='CleanSheet Updater') {


			    try {
		              $pdo = new pdodb();
		              $pdo->query("UPDATE cfc_cleansheets a SET F_CLEAN = :v2 , F_SUBS = :v3 WHERE F_NAME = :v1");
		              $pdo->bind(':v3', $v03);
		              $pdo->bind(':v2', $v02);
		              $pdo->bind(':v1', $v01);
		              $pdo->execute();

				    $message1  = sprintf("Updated rows (CleanSheets): %d\n <br/>", $pdo->lastInsertId());

				        print $melinda->goMessage($message1,'success');

			    } catch (PDOException $e) {

				    print $melinda->goMessage( "DB Error: The record could not be Updated.<br>".$e->getMessage(), 'error' );
				    print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

			    } catch (Exception $e) {

				    print $melinda->goMessage( "General Error: The record could not be Updated.<br>".$e->getMessage() , 'error');
				    print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

			    }



          } else {
?>
    <?php
    //================================================================================
    $sql = "SELECT F_NAME, F_CLEAN, F_SUBS FROM cfc_cleansheets 
            WHERE F_EYEAR IS NULL ORDER BY F_CLEAN DESC";
     outputDataTable( $sql, 'small');
    //================================================================================
    ?>
      
    <form method="post" action="<?php the_permalink();?>" autocapitalize="characters">
           <div class="form-group">
                <label for="F01">Name:</label>
                <input type="text" name="F01" /><br/>
           </div>
           <div class="form-group">
                <label for="F02">CleanSheets:</label>
                <input type="number" name="F02" /><br/>
           </div>
           <div class="form-group">
                <label for="F03">Subs:</label>
                <input type="number" name="F03" /><br/>
           </div>

        <input name="submit" type="submit" id="submit" value="CleanSheet Updater" class="btn btn-primary"/>
    </form>
<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>

    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
