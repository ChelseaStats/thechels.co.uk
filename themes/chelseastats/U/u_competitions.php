<?php /* Template Name: # U Competition */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$cc=$_GET['comp']; 
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
$title = 'Chelsea Ladies';
$fixtures='wsl_fixtures';
$meta_seasons = 'meta_seasons';

$compccsql = "SELECT F_OPP as L_TEAM, CONCAT(F_ID,',',F_DATE) as LX_DATE, F_LOCATION, F_COMPETITION AS L_COMPETITION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF AS L_REF, F_NOTES FROM $fixtures where F_COMPETITION='$cc' order by F_DATE DESC";

$compsql = "SELECT  F_OPP as L_TEAM, CONCAT(F_ID,',',F_DATE) as LX_DATE, F_LOCATION, F_COMPETITION AS L_COMPETITION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF AS L_REF, F_NOTES FROM $fixtures order by F_DATE DESC LIMIT 50";	

$comp = "select Year(F_DATE) as SSN, F_COMPETITION as L_COMPETITION, SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
SUM(F_FOR) AS F_FOR,
SUM(F_AGAINST) AS F_AGAINST,
SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG,
ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,
SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
from $fixtures WHERE F_COMPETITION='$cc'
group by Year(F_DATE) order by Year(F_DATE) asc";

$comp_all = "select F_COMPETITION as L_COMPETITION, SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
SUM(F_FOR) AS F_FOR,
SUM(F_AGAINST) AS F_AGAINST,
SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG,
ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,
SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
from $fixtures GROUP BY F_COMPETITION";


?>
<h4 class="special"><?php echo $title; ?> - Results by competition for :<?php if (isset($cc)) { echo "$cc "; } else { echo "All Competitions "; } ?></h4>
<div class="row-fluid">
  <div class="span4 offset8">
      <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                    <option value="">Competition Filter</option>
                    <option value="<?php the_permalink() ?>?comp=WSL">Women's Super League</option>
                    <option value="<?php the_permalink() ?>?comp=PREM">Women's Premier League</option>
                    <option value="<?php the_permalink() ?>?comp=FAC">Women's FA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=LC" >Women's League Cup</option>
                    <option value="<?php the_permalink() ?>?comp=CC" >Women's Continental Cup</option>
                </select>
            </span>
        </div>
    </div>
</div> 
<?php
} else {
$title = 'Chelsea';
$fixtures='cfc_fixtures';
$meta_seasons = 'meta_seasons';

$compccsql = "SELECT F_OPP as F_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_LOCATION, F_COMPETITION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF, F_NOTES 
FROM $fixtures where F_COMPETITION='$cc' order by F_DATE DESC";
	
$compsql = "SELECT  F_OPP as F_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_LOCATION, F_COMPETITION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF, F_NOTES 
FROM $fixtures order by F_DATE DESC LIMIT 50";	

$comp = "select F_LABEL as SSN, F_COMPETITION, SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
SUM(F_FOR) AS F_FOR,
SUM(F_AGAINST) AS F_AGAINST,
SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG,
ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,
SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
from $fixtures a, $meta_seasons b WHERE F_COMPETITION='$cc'
and a.F_DATE > b.F_SDATE and a.F_DATE < b.F_EDATE
group by F_LABEL order by F_LABEL asc";

$comp_all = "select F_COMPETITION, SUM(IF(F_RESULT='W',1,0)) AS win, SUM(IF(F_RESULT='D',1,0)) AS draw, SUM(IF(F_RESULT='L',1,0)) AS loss,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+
ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN,
SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
SUM(F_FOR) AS F_FOR,
SUM(F_AGAINST) AS F_AGAINST,
SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG,
ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,
SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
from $fixtures GROUP BY F_COMPETITION";

?>
<h4 class="special"><?php echo $title; ?> - Results by competition for :<?php if (isset($cc)) { echo "$cc "; } else { echo "All Competitions "; } ?></h4>
<div class="row-fluid">
  <div class="span4 offset8">
      <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                    <option value="">Competition Filter</option>
                    <option value="<?php the_permalink() ?>?comp=PREM">Premier League</option>
                    <option value="<?php the_permalink() ?>?comp=DIV1OLD">Division 1 (old)</option>
                    <option value="<?php the_permalink() ?>?comp=DIV2OLD">Division 2 (old)</option>
                    <option value="" class="bolder"> ----- Europe -----</option>
                    <option value="<?php the_permalink() ?>?comp=UCL">UEFA Champions League</option>
                    <option value="<?php the_permalink() ?>?comp=UEL">UEFA Europa League</option>
                    <option value="<?php the_permalink() ?>?comp=UEFAC">UEFA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=ECWC">European Cup Winners Cup</option>
                    <option value="<?php the_permalink() ?>?comp=ESC">European Super Cup</option>
                    <option value="" class="bolder"> ----- Cups -----</option>
                    <option value="<?php the_permalink() ?>?comp=FAC">FA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=LC">League Cup</option>
                    <option value="<?php the_permalink() ?>?comp=CS">Charity/Community Shield</option>
                    <option value="<?php the_permalink() ?>?comp=FAIRS">Fairs Cup</option>
                    <option value="<?php the_permalink() ?>?comp=FMC">Full Members cup</option>
                </select>
            </span>
        </div>
    </div>
</div>
<?php } 
#############################################################################################################
?>
<h3>Summary</h3>
<?php
if (isset($cc)) 
{
//================================================================================
 outputDataTable( $comp, 'Competition');
//================================================================================
}
else
{
//================================================================================
 outputDataTable( $comp_all, 'Competition');
//================================================================================
}

if (isset($cc)) 
{
// Results processing
$query="SELECT
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2) AS win,
ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2) AS draw,
ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2) AS loss,
count(*) AS total
FROM $fixtures WHERE F_COMPETITION='$cc' ";
}
else
{
// Results processing
$query="SELECT 
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hwin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hdraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0))/SUM(IF(F_LOCATION='H',1,0)))*100,2) AS hloss,
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS awin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS adraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0))/SUM(IF(F_LOCATION='A',1,0)))*100,2) AS aloss,
ROUND((SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nwin,
ROUND((SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS ndraw,
ROUND((SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0))/SUM(IF(F_LOCATION='N',1,0)))*100,2) AS nloss,
ROUND((SUM(IF(F_RESULT='W',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS win, 
ROUND((SUM(IF(F_RESULT='D',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS draw, 
ROUND((SUM(IF(F_RESULT='L',1,0))/SUM(IF(F_LOCATION<>'0',1,0)))*100,2)  AS loss, 
count(*) AS total 
FROM $fixtures";
}

// Perform Query
$pdo = new pdodb();
$pdo->query($query);
$row = $pdo->row();

$f001 = $row['hwin'];
$f002 = $row['hdraw'];
$f003 = $row['hloss'];
$f004 = $row['awin'];
$f005 = $row['adraw'];
$f006 = $row['aloss'];
$f011 = $row['nwin'];
$f012 = $row['ndraw'];
$f013 = $row['nloss'];
$f007 = $row['win'];
$f008 = $row['draw'];
$f009 = $row['loss'];
$f010 = $row['total'];

if(isset($f001) && $f001<>'') { print $go->_comparebars3('Home'	 ,$f001,$f002,$f003);}
if(isset($f004) && $f004<>'') { print $go->_comparebars3('Away'	 ,$f004,$f005,$f006);}
if(isset($f011) && $f011<>'') { print $go->_comparebars3('Neutral'  ,$f011,$f012,$f013);}
if(isset($f007) && $f007<>'') { print $go->_comparebars3('Total'	 ,$f007,$f008,$f009);}
?>
<h3>Competition Analysis: All Results by Competition</h3>
<?php
if (isset($cc)) 
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
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
<?php get_footer(); ?>
