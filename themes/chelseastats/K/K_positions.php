<?php /* Template Name: XXXX Ebook League Positions */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<head>
    <style>
      * { margin:2px; padding:0; font-family:Verdana, serif; font-size:1em; color:#232323;}
      header {display:none;}
      h1 { font-size:2em; line-height:3em;}
      h2 { font-size:1.5em; line-height:2em;}
      .left  {float:left;}
      .right {float:right;}
      .clear {clear:both;}
      .content-header { font-size:3em;  }
      .content-footer { text-align: center;}
      table {width:100%; border:1px solid brown; border-collapse: collapse;}
      .content-main {width:50%; padding:3px;}
      .match-events {width:33%; padding:3px;}
      .team0 {border-right:3px solid red; text-align:right;}
      .team1 {border-left:3px solid blue; text-align:left;}
      .img { height:350px; min-height:350px; margin:auto auto; padding:1em; float:none; display:block;}
	    .sponsor { display:none;}
    </style>
    <title>Chelsea League Positions, Records and Attendances</title>
    </head>
  <body>
        <div id="main">
        <br/>
        <h1>Chelsea FC</h1>
        <h2>League Positions, Records and Attendances</h2>
        <h3><?php echo $title;?></h3>
        <div style="clear:both;"><p>&nbsp;</p></div>
        <mbp:pagebreak/>
        <p class="centered"><img src="default.png" height="300px;"/></p>
        <div style="clear:both;"><p>&nbsp;</p></div>
        <h4>ChelseaStats : thechels.co.uk</h4>
        <div style="clear:both;"><p>&nbsp;</p></div>
        <mbp:pagebreak/>
        <p>Notes: founded 1905, no games 1915-1919 for WWI and 1939-1946 for WWII</p>
        <mbp:pagebreak/>
        <p>Years</p>
        <ul>
        <?php
        ######### start contents #############
        $pdo = new pdodb();
        $pdo->query("SELECT * FROM cfc_positions ORDER BY F_YEAR DESC");
        $rows = $pdo->rows();
        foreach($rows as $row) {
                print '<li><a href="#'.$row["F_YEAR"].'">'.$row["F_YEAR"].'</a></li>';
        }
        ######### end contents ##############
        ?>
        </ul>
        <mbp:pagebreak/>
        <?php
        ######### content ##############
        $pdo->query("SELECT * FROM cfc_positions ORDER BY F_YEAR DESC");
        $rows = $pdo->rows();
        foreach($rows as $row) {
                $f1 = $row["F_YEAR"];
                $f2 = $row["F_COMPETITION"];
                $f3 = $row["F_POSITION"];
                $f4 = $row["F_PLAYED"];
                $f5 = $row["F_WON"];
                        $f5b = ($f4 > 0) ? round(( $f5 / $f4 ) *100,3) : 0;
                $f6 = $row["F_DREW"];
                    $f6b = ($f4 > 0) ? round(( $f6 / $f4 ) *100,3) : 0;
                $f7 = $row["F_LOSS"];
                        $f7b = ($f4 > 0) ? round(( $f7 / $f4 ) *100,3) : 0;
                $f8 = $row["F_FOR"];
                $f9 = $row["F_AGAINST"];
                $f10= $row["F_POINTS"];
	                    $f10b = ($f4 > 0) ? round(( $f10 / $f4 ),3) : 0;
                $f11 = $row["F_ATT"];
                $f12 = $row["F_FACUP"];
                $f13 = $row["F_LCUP"];
                $f14 = $row["F_NOTES"];
                $f15 = $row["F_ID"];
                $f16 = ($f8-$f9);
                ?>
                <a name="<?php echo str_replace("/","-",$f1); ?>"></a>
                <h1><?php echo $f1; ?></h1>
                <br/>
                <ul>
                <li><b>Year:</b> <?php echo $f1;?></li>
                <li><b>Competition:</b> <?php echo $f2;?></li>
                <li><b>Position:</b> <?php echo $f3;?></li>
                <li><b>Played:</b> <?php echo $f4;?></li>
                <li><b>W:</b> <?php echo $f5;?> (<?php echo $f5b;?>%)</li>
                <li><b>D:</b> <?php echo $f6;?> (<?php echo $f6b;?>%)</li>
                <li><b>L:</b> <?php echo $f7;?> (<?php echo $f7b;?>%)</li>
                <li><b>For:</b> <?php echo $f8;  ?></li>
                <li><b>Against:</b> <?php echo $f9;  ?></li>
                <li><b>Goal Difference:</b> <?php echo $f16;  ?></li>
                <li><b>Points:</b> <?php echo $f10;?> ( <?php echo $f10b;?> ppg)</li>
                <li><b>Attendance (home average):</b> <?php echo $f11;?></li>
                <li><b>FA Cup:</b> <?php echo $f12; ?></li>
                <li><b>L Cup:</b> <?php echo $f13; ?></li>
                <li><b>Notes:</b> <?php echo $f14; ?></li>
                </ul>
                <br/>
                <h3 class="centered">* * *</h3>
                <mbp:pagebreak />
        <?php
        }
        ##### end content #####
        ?>
        <div style="clear:both;"><p>&nbsp;</p></div>
    </div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>