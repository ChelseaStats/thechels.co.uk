<?php /* Template Name: # U MGR Profiles */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$cc=strtoupper($_GET['profile']);
$cc1=str_replace("_"," ",$cc);
if($cc1=='MOURINHO2') {$cc1 = 'MOURINHO mkII';}

$page = get_permalink($post->ID);
if (strpos($page,"ladies") !== false) {
$title  ="Chelsea Ladies";

$compccsql = "SELECT a.F_COMPETITION as L_COMPETITION, SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw,
SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss, SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin, 
SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss, count(*) AS Total
FROM wsl_fixtures a, wsl_managers b WHERE b.F_SNAME='$cc' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY L_COMPETITION";
    
$compsql = "SELECT a.F_COMPETITION as L_COMPETITION, SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw,
SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss, SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss, count(*) AS Total
FROM wsl_fixtures a, wsl_managers b  WHERE b.F_ORDER=(SELECT MAX(F_ORDER) FROM wsl_managers) AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY L_COMPETITION";
    
$resccsql = "SELECT CONCAT(a.F_ID,',',a.F_DATE) as LX_DATE, a.F_COMPETITION as L_COMPETITION, a.F_OPP as L_TEAM, a.F_LOCATION, a.F_RESULT, a.F_FOR, a.F_AGAINST, 
a.F_REF as L_REF, a.F_ATT, a.F_NOTES FROM wsl_fixtures a, wsl_managers b  WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE AND b.F_SNAME='$cc'
ORDER BY LX_DATE DESC";    
    
$ressql = "SELECT CONCAT(a.F_ID,',',a.F_DATE) as LX_DATE, a.F_COMPETITION as L_COMPETITION, a.F_OPP as L_TEAM, a.F_LOCATION, a.F_RESULT, a.F_FOR, a.F_AGAINST, 
a.F_REF as L_REF, a.F_ATT, a.F_NOTES FROM wsl_fixtures a, wsl_managers b  WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE AND
b.F_ORDER=(SELECT MAX(F_ORDER) FROM wsl_managers) ORDER BY LX_DATE DESC";

$dropquery="SELECT DISTINCT F_SNAME FROM wsl_managers ORDER BY F_ORDER DESC";

$querycc="SELECT
        SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
        count(*) AS total FROM wsl_fixtures a, wsl_managers b
        WHERE b.F_SNAME=:cc AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";

$query="SELECT
        SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
        count(*) AS total FROM wsl_fixtures a, wsl_managers b
        WHERE b.F_ORDER=(select max(F_ORDER) FROM wsl_managers)
        AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";

} else {
$title  ="Chelsea";

$compccsql = "SELECT a.F_COMPETITION, SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw,
SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss, SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin, 
SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss, count(*) AS Total
FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME='$cc' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY a.F_COMPETITION";
    
$compsql = "SELECT a.F_COMPETITION, SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw,
SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss, SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin,
SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss, count(*) AS Total
FROM cfc_fixtures a, cfc_managers b  WHERE b.F_ORDER=(SELECT MAX(F_ORDER) FROM cfc_managers) AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY a.F_COMPETITION";
    
$resccsql = "SELECT CONCAT(a.F_ID,',',a.F_DATE) as MX_DATE, a.F_COMPETITION, a.F_OPP as M_TEAM, a.F_LOCATION, a.F_RESULT, a.F_FOR, a.F_AGAINST, 
a.F_REF, a.F_ATT, a.F_NOTES FROM cfc_fixtures a, cfc_managers b  WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE AND b.F_SNAME='$cc'
ORDER BY MX_DATE DESC";    
    
$ressql = "SELECT CONCAT(a.F_ID,',',a.F_DATE) as MX_DATE, a.F_COMPETITION, a.F_OPP as M_TEAM, a.F_LOCATION, a.F_RESULT, a.F_FOR, a.F_AGAINST, 
a.F_REF, a.F_ATT, a.F_NOTES FROM cfc_fixtures a, cfc_managers b  WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE AND
b.F_ORDER=(SELECT MAX(F_ORDER) FROM cfc_managers) ORDER BY MX_DATE DESC";

$dropquery="SELECT DISTINCT F_SNAME FROM cfc_managers ORDER BY F_ORDER DESC";

$querycc="SELECT
        SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
        count(*) AS total FROM cfc_fixtures a, cfc_managers b
        WHERE b.F_SNAME=:cc AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";

$query="SELECT
        SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
        ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
        ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
        ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
        count(*) AS total FROM cfc_fixtures a, cfc_managers b
        WHERE b.F_ORDER=(select max(F_ORDER) FROM cfc_managers)
        AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";


}
?>
<h4 class="special"><?php echo $title; ?> - Manager Profile for : <?php if (isset($cc) && $cc!='')  { echo $cc1 ; } else { echo "Current Manager"; } ?></h4>
<div class="row-fluid">
  <div class="span4 offset8">
      <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                    	<option value="">Manager Filter</option>
                        <?php
                            $pdo = new pdodb();
                            $pdo->query($dropquery);
                            $rows = $pdo->rows();
                            foreach ($rows as $row) {
                                $f1 = $go->_V($row["F_SNAME"]);
                                $f2 = $go->_Q($row["F_SNAME"]);
                         ?>
                                <option value="<?php the_permalink() ?>?profile=<?php echo $f2; ?>"><?php echo $f1; ?></option>
                        <?php
                        }
                        ?>
                </select>
            </span>
        </div>
    </div>
</div>
<h3>Summary</h3>
<br/>
<?php
    $pdo = new pdodb();
    if (isset($cc) && $cc!='')  {
        $pdo->query($querycc);
        $pdo->bind(':cc',$cc);
    } else  {
        $pdo->query($query);
    }
        $row  = $pdo->row();
        $f001 = $row['hwin'];
        $f002 = $row['hdraw'];
        $f003 = $row['hloss'];
        $f004 = $row['awin'];
        $f005 = $row['adraw'];
        $f006 = $row['aloss'];
        $f007 = $row['win'];
        $f011 = $row['nwin'];
        $f012 = $row['ndraw'];
        $f013 = $row['nloss'];
        $f008 = $row['draw'];
        $f009 = $row['loss'];
        $f010 = $row['total'];
?>
<div class="graph-container">
<div id="bars" style="width:960px;height:250px;">
<script id="source"  type="text/javascript">
$(function () {

var d1 =	[ 
		[1.0,<?php echo $f001;?> ],
		[1.7,<?php echo $f004;?> ],
		[2.3,<?php echo $f011;?> ]
		];


var d2 =	[ 
		[1.2,<?php echo $f002;?> ],
		[1.9,<?php echo $f005;?> ],
		[2.5,<?php echo $f012;?> ]
		];


var d3 =	[ 
		[1.4,<?php echo $f003;?> ],
		[2.1,<?php echo $f006;?> ],
		[2.7,<?php echo $f013;?> ]
		];

var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.15} }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'ne', noColumns: 1}
,yaxis: { min: 0, max:100, ticks: [ [0, "0%"], [10, "10%"], [20, "20%"], [30, "30%"], [40, "40%"], [50, "50%"], [60, "60%"], [70, "70%"], [80, "80%"], [90, "90%"], [100, "100%"] ] }
,xaxis: { min: 1, max:3.2, ticks: [ [1,"Home"], [1.7,"Away"], [2.3,"Neutral"] ] }
   };

$.plot($("#bars"), [ {label: "Wins (<?php echo $f007;?>)", data: d1}, {label: "Draws (<?php echo $f008;?>)", data: d2}, {label: "Losses (<?php echo $f009;?>)", data: d3} ],  options );  }
     );
</script>
</div>
</div>
<div style="clear:both;">&nbsp;</div>
<h3>Managerial Analysis: Managerial Profile by Competition and Location</h3>
<?php
if (isset($cc) && $cc!='') 
{
//================================================================================
outputDataTable( $compccsql, 'Competition');
//================================================================================
}
else
{
//================================================================================
outputDataTable( $compsql, 'Competition');
//================================================================================
}
?>
<h3>Results Archive</h3>
<?php
if (isset($cc) && $cc!='') 
{
//================================================================================
outputDataTable( $resccsql, 'results archive');
//================================================================================
}
else
{
//================================================================================
outputDataTable( $ressql, 'results archive');
//================================================================================
}
?>
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php get_footer(); ?>
