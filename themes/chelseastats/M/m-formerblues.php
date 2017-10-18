<?php /* Template Name: # m-formerblues m*/ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
	<?php
	$id=$go->inputUpClean($_GET['id']);
	if (isset($id) && $id !='')  {
		
$pdo = new pdodb();
$pdo->query('SELECT F_SNAME as S, F_FNAME as F, F_EDATE as ED, F_SDATE as SD, F_APPS as A, F_SUBS as U, F_GOALS as G 
             FROM cfc_explayers WHERE F_ID = :id');
$pdo->bind(':id',$id);
$row = $pdo->row();
        
$S	= ucwords(strtolower($row['S']));
$F	= ucwords(strtolower($row['F']));
$ED	= $row['ED'];
$SD	= $row['SD'];
$A	= $row['A'];
$U	= $row['U'];
$G	= $row['G'];

			switch ($G) {
				case 1:
					$G = 'once';
					break;
				case 2:
					$G = 'twice';
					break;
				default:
					$G = $G.' times';
					break;
			}
			$shorty=$go->goBitly("https://thechels.co.uk/explayers/");
			$message1='#stats #formerblue '.$F.' '.$S.' made '.$A.'(+'.$U.') appearance whilst scoring '.$G.' at the club '.$shorty.' #cfc #chelsea';

            $melinda->goTweet($message1,'APP');
            print $melinda->goMessage($message1,'success');
            print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");
} else  {
			?>
            <form action="<?php the_permalink();?>" class="form">
                <div class="form-group">
                    <select name="mySelectbox" class="form-control">
                        <option value="" class="bolder"> -- Choose a Player --</option>
                        <?php

                        $pdo = new pdodb();
                        $pdo->query('SELECT F_ID as ID, F_FNAME as S, F_SNAME as F, F_EDATE AS E
                                    FROM cfc_explayers ORDER BY F_SNAME ASC, F_FNAME ASC');
                        $rows = $pdo->rows();

                        foreach($rows as $row) {
                        $f0 = $row['ID'];
                        $f1 = ucwords(strtolower($row['F']));
                        $f2 = ucwords(strtolower($row['S']));
                        $f3 = ucwords(strtolower($row['E']));
                        ?>
                        <option value="<?php the_permalink();?>?id=<?php echo $f0; ?>"><?php echo $f1; ?>, <?php echo $f2; ?> (<?php echo $f3; ?>)</option>
                        <?php  }   ?>
                    </select>
                </div>
			<?php print $go->getSubmit(); ?>
			</form>
<?php } ?>
    </div>
        <?php get_template_part('sidebar');?>
    </div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
