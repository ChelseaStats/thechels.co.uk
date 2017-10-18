<?php /* Template Name: XXXX Ebook Results Archive Master */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<?php 

$i = strtoupper($_GET['title']);

switch ($i) {
    case 'EUROPE':
        $title='Europe';

        $sql="SELECT DISTINCT(F_LABEL) as F_LABEL FROM meta_seasons b, cfc_fixtures a
              WHERE F_EDATE <= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EBOOK')
	          AND a.F_DATE > b.F_SDATE AND a.F_DATE < b.F_EDATE AND x_comps='0' ORDER BY F_EDATE DESC";

        $content="SELECT * FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE and b.F_LABEL=:label AND x_comps='0' order by F_DATE DESC";

        break;
    case 'LC':
        $title='League Cup';

        $sql="SELECT DISTINCT(F_LABEL) as F_LABEL FROM meta_seasons b, cfc_fixtures a
              WHERE F_EDATE <= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EBOOK')
	          AND a.F_DATE > b.F_SDATE AND a.F_DATE < b.F_EDATE AND F_COMPETITION='LC' ORDER BY F_EDATE DESC";

        $content="SELECT * FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE and b.F_LABEL=:label AND F_COMPETITION='LC' order by F_DATE DESC";

        break;
    case 'FA':
	case 'FAC':
        $title='FA Cup';

        $sql="SELECT DISTINCT(F_LABEL) as F_LABEL FROM meta_seasons b, cfc_fixtures a
              WHERE F_EDATE <= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EBOOK')
	          AND a.F_DATE > b.F_SDATE AND a.F_DATE < b.F_EDATE AND F_COMPETITION='FAC' ORDER BY F_EDATE DESC";

        $content="SELECT * FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE and b.F_LABEL=:label AND F_COMPETITION='FAC' order by F_DATE DESC";

        break;
    case 'PREM':
        $title='Premier League';

        $sql="SELECT DISTINCT(F_LABEL) as F_LABEL FROM meta_seasons b, cfc_fixtures a
              WHERE F_EDATE <= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EBOOK')
	          AND a.F_DATE > b.F_SDATE AND a.F_DATE < b.F_EDATE AND F_COMPETITION='PREM' ORDER BY F_EDATE DESC";

        $content="SELECT * FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE and b.F_LABEL=:label AND F_COMPETITION='PREM' order by F_DATE DESC";

        break;
    default:
        $title='All Competitions';

        $sql="SELECT DISTINCT F_LABEL  as F_LABEL FROM meta_seasons b, cfc_fixtures a
              WHERE F_EDATE <= (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EBOOK')
	          AND a.F_DATE > b.F_SDATE AND a.F_DATE < b.F_EDATE ORDER BY F_EDATE DESC";

        $content="SELECT * FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE and b.F_LABEL=:label order by F_DATE DESC";

        break;
}

?>

    <style>
      * { font-family:Verdana, serif; font-size:1.0em; color:#232323;}
      table {width:100%; border:1px solid brown; border-collapse: collapse;}  
      header {display:none;}
      #main { width:90%; margin:auto auto;}
	.content-header { font-size:3em;  }
	.content-main { width:90%; margin:auto auto;}
	.content-footer { text-align: center;}
      h1 { font-size:2.5em; line-height:2.75em; }
      h2 { font-size:1.9em; line-height:2.00em; }
      h3 { font-size:1.5em; line-height:2.00em; }
      .left  {float:left;}
      .right {float:right;}
      .clear, img {clear:both;}
      .match-events {width:33%; padding:3px;}
      .team0 {border-right:3px solid red; text-align:right;}
      .team1 {border-left:3px solid blue; text-align:left;}
      .sponsor { display:none;}
      .centered { text-align:center;}
    </style>
    <title>Chelsea Complete Results Archive. <?php echo $title;?></title>
  </head>
  <body>
<div id="main">
<br/>
<h1>Chelsea FC</h1>
<h2>Complete Results Archive:</h2>
<h3><?php echo $title;?></h3>
<div style="clear:both;"><p>&nbsp;</p></div>
<mbp:pagebreak/>

<p class="centered"><img src="default.png" height="300px;"/></p>
<div style="clear:both;"><p>&nbsp;</p></div>
<h4>ChelseaStats : thechels.co.uk</h4>
<div style="clear:both;"><p>&nbsp;</p></div>
<mbp:pagebreak/>
<h4>Seasonal Contents List</h4>

<?php 
##### contents #####

    print '<ul>';
        $pdo = new pdodb();
        $pdo->query($sql);
        $rows = $pdo->rows();
        foreach ($rows as $row) {
                $label = $row["F_LABEL"];
                print '<li><a href="#'.$label.'">'.$label.'</a></li>';
        }
    print '</ul>';
##### contents #####
?>
    <mbp:pagebreak/>
 <?php 
##### headers #####
        // reuse the original query. better. yes.
		$pdo->query($sql);
		$rows = $pdo->rows();
        foreach ($rows as $row) {
	            $label = $row["F_LABEL"];
				print '<a name="'.$label.'"></a><br/><h2>'.$label.'</h2><mbp:pagebreak/>';

##### CONTENTS #####
 

        $pdo->query($content);
        $pdo->bind(':label',$label);
        $subRows = $pdo->rows();
        foreach ($subRows as $subRow) {

					    $opp	 =    $go->_V($subRow["F_OPP"]);
					    $time	 =    $subRow["F_TIME"];
					    $dater	 =    $subRow["F_DATE"];
					    $loc	 =    $subRow["F_LOCATION"];
					    $comp	 =    $subRow["F_COMPETITION"];
					    $res	 =    $subRow["F_RESULT"];
					    $for	 =    $subRow["F_FOR"];
					    $against =    $subRow["F_AGAINST"];
					    $att	 =    $subRow["F_ATT"];
					    $referee =    $subRow["F_REF"];
					    $info	 =    $subRow["F_NOTES"];
					    $id		 =    $subRow["F_ID"];
					    // variable formatting
					    $referee  = preg_split("/[\s,]+/",$referee);
					    $referee  = ucwords(strtolower($referee[1]." ".$referee[0]));
					    $datefull = $date ." at ".$time;
					    ?>
					    <div class="content-main">
					         <h1 class="team-header"> <?php echo $opp; ?></h1>
					         <h3 class="result"> <?php echo $for; ?> - <?php echo $against; ?></h3>
					 	 <div class="clearfix"><br/></div>
					      <ul>
						    <li><b>Date:</b> <?php echo $dater; ?></li>
					        <li><b>Location:</b> <?php echo $loc; ?></li>
					        <li><b>Result:</b> <?php echo $res; ?></li>
					        <li><b>Additional Info:</b> <?php echo $info; ?></li>
					        <li><b>Referee:</b> <?php echo $referee; ?></li>
					        <li><b>Attendance:</b> <?php echo $att; ?></li> 
					      </ul>
					    </div>
					    <div class="content-footer">
 							<p class="centered">***
								<mbp:pagebreak/></p>
					   </div>
		<?php  }    ?>
<?php  }    ?>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>