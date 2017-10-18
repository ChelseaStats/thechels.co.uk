<?php /* Template Name: XXXX Ebook Explayers Archive */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content"  style="width:90%; margin:0 auto;">
    <br/>
    <h1> Complete
        <br/>Former Players
        <br/>Archive
    </h1>
    <p class="centered">
        <img src="logo.png" height="300px;"/>
    </p>
    <div style="clear:both;"><p>&nbsp;</p></div>
    <h4>ChelseaStats : thechels.co.uk</h4>
    <div style="clear:both;"><br/></div>
    <?php
    //================================================================================
    $pdo = new pdodb();
    $pdo->query("SELECT F_SNAME, F_FNAME, F_EDATE, F_SDATE, F_APPS, F_SUBS, F_GOALS, F_GPG FROM cfc_explayers order by F_SNAME ASC, F_FNAME ASC");
    $rows = $pdo->rows();
    foreach($rows as $row){
    ?>
        <p style="page-break-before:always"><mbp:pagebreak /></p>
        <div class="player">
            <h2><?php echo $row["F_FNAME"]; ?> <?php echo $row["F_SNAME"]; ?></h2>
            <br/><br/>
            <h5>Chelsea Career: <?php echo $row["F_SDATE"];  ?> <?php echo $row["F_EDATE"]; ?></h5>
            <div class="stats">
                <ul>
                    <li>Apps:           <?php echo $row["F_APPS"];  ?></li>
                    <li>Subs:           <?php echo $row["F_SUBS"];  ?></li>
                    <li>Goals: 	        <?php echo $row["F_GOALS"]; ?></li>
                    <li>Goals Per Game: <?php echo $row["F_GPG"];   ?></li>
                </ul>
            </div>
        </div>
    <?php  } ?>
    <div style="clear:both;"><br/></div>
    </div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>