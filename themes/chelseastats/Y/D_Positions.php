<?php /* Template Name: # D Positions Summary */ ?>
<?php get_header(); ?>
<div id="content">
<h4 class="special">Chelsea - Final league Positions, attendances, goal differential tables and charts</h4>

<h3>Chelsea - Final league Positions by Year, With Averages</h3>
<div class="graph-container">
<div id="placeholder1" style="width:960px;height:225px">
<script type="text/javascript"  id="source">
$(function () {
	//noinspection OctalIntegerJS
	var d1 = [  [1905,'NULL'], [1906,-03],  [1907,-02], [1908,-13], [1909,-11], [1910,-19], [1911,-03], [1912,-02], [1913,-18], [1914,-08], [1915,-19], [1916,'NULL'], [1919,'NULL'],
[1920,-03], [1921,-18], [1922,-09], [1923,-19], [1924,-21], [1925,-05], [1926,-03], [1927,-04], [1928,-03], [1929,-09], [1930,-02], [1931,-12], [1932,-12], [1933,-18], [1934,-19],
[1935,-12], [1936,-08], [1937,-13], [1938,-10], [1939,-20], [1940,'NULL'], [1946,'NULL'], [1947,-15], [1948,-18], [1949,-13], [1950,-13], [1951,-20], [1952,-19], [1953,-19], [1954,-08],
[1955,-01], [1956,-16], [1957,-12], [1958,-11], [1959,-14], [1960,-18], [1961,-12], [1962,-22], [1963,-02], [1964,-05], [1965,-03], [1966,-05], [1967,-09], [1968,-06], [1969,-05],
[1970,-03], [1971,-06], [1972,-07], [1973,-12], [1974,-17], [1975,-21], [1976,-11], [1977,-02], [1978,-16], [1979,-22], [1980,-04], [1981,-12], [1982,-12], [1983,-18], [1984,-01],
[1985,-06], [1986,-06], [1987,-14], [1988,-18], [1989,-01], [1990,-05], [1991,-11], [1992,-14], [1993,-11], [1994,-14], [1995,-11], [1996,-11], [1997,-06], [1998,-04], [1999,-03],
[2000,-05], [2001,-06], [2002,-06], [2003,-04], [2004,-02], [2005,-01], [2006,-01], [2007,-02], [2008,-02], [2009,-03], [2010,-01], [2011,-02], [2012,-06], [2013,-03], [2014,-03],
[2015,-01], [2016,-10], [2017,'NULL'] ];

var d2 = [  [1905,'NULL'], [1906,-9.8], [1915,-9.8] ];

var d3 = [  [1919,-11], [1939,-11] ];

var d4 = [  [1947,-10.9], [1991,-10.9] ];

var d5 = [  [1992,-5.1], [2016,-5.1], [2017,'NULL'] ];

 $.plot($("#placeholder1"), [
        {
            label: "Positions", data: d1,
            lines: { show: true}, points: { show: true }
        },
        {
             label: "1905-1915 AVG",data: d2,
            lines: { show: true}
        },
        {
             label: "1919-1939 AVG", data: d3,
            lines: { show: true}
        },
        {
             label: "1947-1991 AVG", data: d4,
            lines: { show: true}
        },
        {
             label: "1992-2016 AVG", data: d5,
            lines: { show: true}
            
        }

    ],

{
legend: { position: 'se', noColumns: 5 },
yaxis: { min: -28 , max:-1, ticks: [[0, "00"], [-2, "02"], [-4, "04"] , [-6, "06"] ,[-8, "08"] ,[-10, "10"]  ,[-12, "12"],[-14, "14"],[-16, "16"] , [-18, "18"] , [-20, "20"] , [-22, "22"] , [-24, "24"] , [-26, "26"], [-28, "28"] ] },
xaxis: { min:1905, max:2020, ticks: [1905, 1910, 1915, 1920, 1925, 1930, 1935, 1940, 1945, 1950, 1955, 1960, 1965, 1970, 1975, 1980, 1985, 1990, 1995, 2000, 2005, 2010, 2015, 2020 ]}
}
);
});
</script>
</div>
</div>
<h3>Chelsea - Goals For, Against and Difference by Year</h3>
<div class="graph-container">
<div id="placeholder2" style="width:960px;height:225px">
<script type="text/javascript"  id="source">
	 $(function () 
		{
 			// a null signifies separate line segments
			//first set of variables from array
var d1 = [ 
<?php 

$pdo = new pdodb();
$pdo->query("SELECT IFNULL(F_FOR,NULL) AS F_FOR, F_YR FROM cfc_positions ORDER BY F_YEAR ASC");
$rows = $pdo->rows();
foreach ( $rows as $row) {

$f1  = $row["F_FOR"];
$f2  = $row["F_YR"];
?>
[<?php echo $f2; ?>,<?php echo $f1; ?>], 

<?php  }   ?>
[2016, 'NULL' ] ];

var d2 = [ 
<?php 

$pdo = new pdodb();
$pdo->query("SELECT IFNULL(SUM(F_AGAINST-(F_AGAINST*2)),NULL) AS F_AGAINST, F_YR FROM cfc_positions GROUP BY F_YEAR ORDER BY F_YEAR ASC");
$rows = $pdo->rows();
foreach ( $rows as $row) {

$f21 = $row["F_AGAINST"];
$f22 = $row["F_YR"];
?>
[<?php echo $f22 ?>,<?php echo $f21; ?>], 
<?php } ?>
[2016, 'NULL' ] ];


var d3 = [ 
<?php 

$pdo = new pdodb();
$pdo->query("SELECT IFNULL(F_DIFF,NULL) AS F_DIFF, F_YR FROM cfc_positions ORDER BY F_YEAR ASC");
$rows = $pdo->rows();
foreach ( $rows as $row) {

$f31 = $row["F_DIFF"];
$f32 = $row["F_YR"];
?>
[<?php echo $f32; ?>,<?php echo $f31; ?>], 
<?php  }  ?>
[2016, 'NULL' ] ];

			// plot these values to the placeholder div & let jquery-flot do its thing

				$.plot($("#placeholder2"), 

						[
{ label: "Goals For", data: d1,  bars: { show: true, align:"center", barWidth:0.2, fill: true }	},
{ label: "Goals Against", data: d2,  bars: { show: true, align:"center", barWidth:0.2, fill: true } },
{ color:'#666666', label: "Goals Difference", data: d3,  lines: { show: true}, points: { show: true } }
						],
{
legend: { position: 'se', noColumns: 3 },
yaxis: { ticks: [-150, -125, -100, -75, -50, -25, 0, 25, 50, 75, 100, 125, 150 ] },
xaxis: { min:1905, max:2020, ticks: [1905, 1910, 1915, 1920, 1925, 1930, 1935, 1940, 1945, 1950, 1955, 1960, 1965, 1970, 1975, 1980, 1985, 1990, 1995, 2000, 2005, 2010, 2015, 2020 ]}
}
					);	
}
					);	
</script>
</div>
</div>
<h3>Chelsea - Average Attendances by Year</h3>
<div class="graph-container">
<div id="placeholder3" style="width:960px;height:225px">
<script type="text/javascript"  id="source">
	 $(function () 
		{
 			// a null signifies separate line segments
			//first set of variables from array

var d1 = [  [1905, 32691],  [2016, 32691 ] ];

var d2 = [ 
<?php 

$pdo = new pdodb();
$pdo->query("SELECT IFNULL(F_ATT,NULL) AS F_ATT, F_YR FROM cfc_positions ORDER BY F_YR ASC");
$rows = $pdo->rows();
foreach ( $rows as $row) {

$f91 = $row["F_ATT"];
$f92 = $row["F_YR"];
?>
[<?php echo $f92 ?>,<?php echo $f91; ?>], 
<?php }  ?>
[2016, 'NULL' ] ];

			// plot these values to the placeholder div & let jquery-flot do its thing

				$.plot($("#placeholder3"), 

[ 
{ color: '#888888', label: "Average Attendance", data: d1,  lines: { show: true}, points: { show: false } },
{ label: "Average Annual Attendance", data: d2,  lines: { show: true}, points: { show: true } }

],
{
legend: { position: 'se', noColumns:2},
yaxis: { min:0, max: 50000, ticks: [ [0,"0"],[5000,"5,000"],[10000,"10,000"],[15000,"15,000"],[20000,"20,000"],[25000,"25,000"],[30000,"30,000"],[35000,"35,000"],[40000,"40,000"],[45000,"45,000"],[50000,"50,000"] ] },
xaxis: { min:1905, max:2020, ticks: [1905, 1910, 1915, 1920, 1925, 1930, 1935, 1940, 1945, 1950, 1955, 1960, 1965, 1970, 1975, 1980, 1985, 1990, 1995, 2000, 2005, 2010, 2015, 2020 ]}
}
					);	
}
					);	
</script>
</div>
</div>
<br/>
<h3>Full list of league positions and performance Summary</h3>
	<?php
	 //===================================================================================
	$sql = "SELECT F_YEAR, F_COMPETITION as N_COMP, F_PLAYED, F_WON, F_DREW, F_LOSS, F_FOR, F_AGAINST, F_DIFF, F_POINTS, F_POSITION, F_ATT, F_FACUP, F_LCUP, F_NOTES FROM cfc_positions order by F_YR DESC";
	outputDataTable( $sql, 'Competition');
	//================================================================================
	?>
<p>Notes: founded 1905, no games 1915-1919 for WWI and 1939-1946 for WWII</p>
<h3>Chelsea Ladies - List of league positions and performance record</h3>
<?php
	 //===================================================================================
	$sql = "SELECT F_YEAR, F_COMPETITION as N_COMP, F_PLAYED, F_WON, F_DREW, F_LOSS, F_FOR, F_AGAINST, F_DIFF, F_POINTS, F_POSITION, F_ATT, F_FACUP, F_LCUP, F_NOTES FROM wsl_positions order by F_YR DESC";
	 outputDataTable( $sql, 'Competition');
	//================================================================================
?>
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
</div>
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript" ></script> 
<?php get_footer(); ?>
