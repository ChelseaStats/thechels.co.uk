<?php
	/*
	Plugin Name: CFC WordPress Replace Provider
	Description: Content replacer - no options
	Version: 11.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	if(!class_exists('replacer')) {

		class replacer {

			/**
			 * replacer constructor.
			 */
			function __construct() {

				add_filter('the_content'       , array($this, 'replace_content') );
				add_filter('content_save_pre'  , array($this, 'cfc_replace_content_pre'), 10, 1 );
			}

			/** Process content after retrieval before display
			 *
			 * @param mixed $content
			 * @return mixed $content
			 */
			function replace_content($content) {
				/** Responsive wrapper for tables - important **/
				$content = str_replace('<table class="tablesorter">', '<div class="table-container"><table class="tablesorter">', $content);
				$content = str_replace('<table class="tablesorter small">', '<div class="table-container-small"><table class="tablesorter">', $content);
				$content = str_replace('</table>', '</table></div>', $content);

				return $content;
			}

			/** Pre-saving changes to post content
			 *
			 * @param mixed $content
			 * @return mixed $content
			 */
			function cfc_replace_content_pre($content) {
				// Process content here
				/** competitions */
				$content = str_replace('FAWSL','<a href="https://thechels.co.uk/analysis-ladies/competition-analysis/?comp=WSL">FAWSL</a>',$content);
				$content = str_replace('FA_Cup','<a href="https://thechels.co.uk/analysis/competitions/?comp=FAC">FA Cup</a>',$content);
				$content = str_replace('Women\'s FA Cup','<a href="https://thechels.co.uk/analysis-ladies/competition-analysis/?comp=FAC">Women\'s FA Cup</a>',$content);
				$content = str_replace('Champions League','<a href="https://thechels.co.uk/analysis/competitions/?comp=UCL">Champions League</a>',$content);
				$content = str_replace('the Premier League','<a href="https://thechels.co.uk/analysis/competitions/?comp=PREM">the Premier League</a>',$content);
				$content = str_replace('Premiership','<a href="https://thechels.co.uk/analysis/competitions/?comp=PREM">the Premier League</a>',$content);
				/** referees **/
				$content = str_replace('^_PhilDowd','<a href="https://thechels.co.uk/analysis/referees/?ref=DOWD,PHIL">Phil Dowd</a>',$content);
				$content = str_replace('^_MikeDean','<a href="https://thechels.co.uk/analysis/referees/?ref=DEAN,MIKE">Mike Dean</a>',$content);
				$content = str_replace('^_AndreMarriner','<a href="https://thechels.co.uk/analysis/referees/?ref=MARRINER,ANDRE">Andre Marriner</a>',$content);
				$content = str_replace('^_HowardWebb','<a href="https://thechels.co.uk/analysis/referees/?ref=WEBB,HOWARD">Howard Webb</a>',$content);
				$content = str_replace('^_LeeMason','<a href="https://thechels.co.uk/analysis/referees/?ref=MASON,LEE">Lee Mason</a>',$content);
				$content = str_replace('^_MartinAtkinson','<a href="https://thechels.co.uk/analysis/referees/?ref=ATKINSON,MARTIN">Martin Atkinson</a>',$content);
				$content = str_replace('^_MikeJones','<a href="https://thechels.co.uk/analysis/referees/?ref=JONES,MIKE">Mike Jones</a>',$content);
				$content = str_replace('^_KevinFriend','<a href="https://thechels.co.uk/analysis/referees/?ref=FRIEND,KEVIN">Kevin Friend</a>',$content);
				$content = str_replace('^_MarkClattenburg','<a href="https://thechels.co.uk/analysis/referees/?ref=CLATTENBURG,MARK">Mark Clattenburg</a>',$content);
				/** managers **/
				$content = str_replace('^_RobertoDiMatteo','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=DI_MATTEO">Roberto Di Matteo</a>',$content);
				$content = str_replace('^_DiMatteo','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=DI_MATTEO">Di Matteo</a>',$content);
				$content = str_replace('^_RDM','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=DI_MATTEO">RDM</a>',$content);
				$content = str_replace('^_AndreVillaBoas','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=VILLAS%20BOAS">Andre Villa Boas</a>',$content);
				$content = str_replace('^_CarloAncelotti','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=ANCELOTTI">Carlo Ancelotti</a>',$content);
				$content = str_replace('^_Mourinho','<a href="https://thechels.co.uk/mourinho/">Jose Mourinho</a>',$content);
				$content = str_replace('^_AVB','<a href="https://thechels.co.uk/analysis/managers/profiles/?profile=VILLAS%20BOAS">AVB</a>',$content);
				/** teams and nicknames **/
				$content = str_replace('^_Bournemouth','<a href="https://thechels.co.uk/analysis/results/?team=BOURNEMOUTH">Bournemouth</a>',$content);
				$content = str_replace('^_Watford','<a href="https://thechels.co.uk/analysis/results/?team=WATFORD">Watford</a>',$content);
				$content = str_replace('^_Ipswich','<a href="https://thechels.co.uk/analysis/results/?team=IPSWICH_TOWN">Ipswich Town</a>',$content);
				$content = str_replace('^_Birmingham_City','<a href="https://thechels.co.uk/analysis/results/?team=BIRMINGHAM_CITY">Birmingham City</a>',$content);
				$content = str_replace('^_AstonVilla','<a href="https://thechels.co.uk/analysis/results/?team=ASTON_VILLA">Aston Villa</a>',$content);
				$content = str_replace('^_Sunderland','<a href="https://thechels.co.uk/analysis/results/?team=SUNDERLAND">Sunderland</a>',$content);
				$content = str_replace('^_CrystalPalace','<a href="https://thechels.co.uk/analysis/results/?team=CRYSTAL_PALACE">Crystal Palace</a>',$content);
				$content = str_replace('^_Manchester_United','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_UNITED">Manchester United</a>',$content);
				$content = str_replace('^_Manchester_Utd','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_UNITED">Manchester Utd</a>',$content);
				$content = str_replace('^_Man_United','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_UNITED">Man United</a>',$content);
				$content = str_replace('^_ManUtd','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_UNITED">Man Utd</a>',$content);
				$content = str_replace('^_SwanseaCity','<a href="https://thechels.co.uk/analysis/results/?team=SWANSEA_CITY">Swansea City</a>',$content);
				$content = str_replace('^_BlackburnRovers','<a href="https://thechels.co.uk/analysis/results/?team=BLACKBURN_ROVERS">Blackburn Rovers</a>',$content);
				$content = str_replace('^_Blackburn','<a href="https://thechels.co.uk/analysis/results/?team=BLACKBURN_ROVERS">Blackburn</a>',$content);
				$content = str_replace('^_Burnley','<a href="https://thechels.co.uk/analysis/results/?team=BURNLEY">Burnley</a>',$content);
				$content = str_replace('^_ManchesterCity','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_CITY">Manchester City</a>',$content);
				$content = str_replace('^_ManCity','<a href="https://thechels.co.uk/analysis/results/?team=MANCHESTER_CITY">Man City</a>',$content);
				$content = str_replace('^_Wolves','<a href="https://thechels.co.uk/analysis/results/?team=WOLVERHAMPTON_WANDERERS">Wolves</a>',$content);
				$content = str_replace('^_WestBrom','<a href="https://thechels.co.uk/analysis/results/?team=WEST_BROMWICH_ALBION">West Brom</a>',$content);
				$content = str_replace('^_WestHam','<a href="https://thechels.co.uk/analysis/results/?team=WEST_HAM_UNITED">West Ham</a>',$content);
				$content = str_replace('^_HullCity','<a href="https://thechels.co.uk/analysis/results/?team=HULL_CITY">Hull City</a>',$content);
				$content = str_replace('^_LeicesterCity','<a href="https://thechels.co.uk/analysis/results/?team=LEICESTER_CITY">Leicester City</a>',$content);
				$content = str_replace('^_WolverhamptonWanderers','<a href="https://thechels.co.uk/analysis/results/?team=WOLVERHAMPTON_WANDERERS">Wolverhampton Wanderers</a>',$content);
				$content = str_replace('^_Newcastle','<a href="https://thechels.co.uk/analysis/results/?team=NEWCASTLE_UNITED">Newcastle</a>',$content);
				$content = str_replace('^_Newcastle_United','<a href="https://thechels.co.uk/analysis/results/?team=NEWCASTLE_UNITED">Newcastle United</a>',$content);
				$content = str_replace('^_Tottenham_Hotspur','<a href="https://thechels.co.uk/analysis/results/?team=TOTTENHAM_HOTSPUR">Tottenham Hotspur</a>',$content);
				$content = str_replace('^_Spurs','<a href="https://thechels.co.uk/analysis/results/?team=TOTTENHAM_HOTSPUR">Spurs</a>',$content);
				$content = str_replace('^_Tottenham','<a href="https://thechels.co.uk/analysis/results/?team=TOTTENHAM_HOTSPUR">Tottenham</a>',$content);
				$content = str_replace('^_Portsmouth','<a href="https://thechels.co.uk/analysis/results/?team=PORTSMOUTH">Portsmouth</a>',$content);
				$content = str_replace('^_FrattonPark','<a href="https://thechels.co.uk/analysis/results/?team=PORTSMOUTH">Fratton Park</a>',$content);
				$content = str_replace('^_BoltonWanderers','<a href="https://thechels.co.uk/analysis/results/?team=BOLTON_WANDERERS">Bolton Wanderers</a>',$content);
				$content = str_replace('^_QPR','<a href="https://thechels.co.uk/analysis/results/?team=QUEENS_PARK_RANGERS">QPR</a>',$content);
				$content = str_replace('^_FULHAM','<a href="https://thechels.co.uk/analysis/results/?team=FULHAM">FULHAM</a>',$content);
				$content = str_replace('^_Fulham','<a href="https://thechels.co.uk/analysis/results/?team=FULHAM">Fulham</a>',$content);
				$content = str_replace('^_WiganAthletic','<a href="https://thechels.co.uk/analysis/results/?team=WIGAN_ATHLETIC">Wigan Athletic</a>',$content);
				$content = str_replace('^_Wigan','<a href="https://thechels.co.uk/analysis/results/?team=WIGAN_ATHLETIC">Wigan</a>',$content);
				$content = str_replace('^_Latics','<a href="https://thechels.co.uk/analysis/results/?team=WIGAN_ATHLETIC">Latics</a>',$content);
				$content = str_replace('^_Arsenal','<a href="https://thechels.co.uk/analysis/results/?team=ARSENAL">Arsenal</a>',$content);
				$content = str_replace('^_Gunners','<a href="https://thechels.co.uk/analysis/results/?team=ARSENAL">Gunners</a>',$content);
				$content = str_replace('^_Everton','<a href="https://thechels.co.uk/analysis/results/?team=EVERTON">Everton</a>',$content);
				$content = str_replace('^_Toffees','<a href="https://thechels.co.uk/analysis/results/?team=EVERTON">Toffees</a>',$content);
				$content = str_replace('^_Liverpool ','<a href="https://thechels.co.uk/analysis/results/?team=LIVERPOOL">Liverpool</a> ',$content);
				$content = str_replace('^_Nordjaelland','<a href="https://thechels.co.uk/analysis/results/?team=NORDSJAELLAND">Nordsjaelland</a>',$content);
				$content = str_replace('^_Nordsjaelland','<a href="https://thechels.co.uk/analysis/results/?team=NORDSJAELLAND">Nordsjaelland</a>',$content);
				$content = str_replace('^_NorwichCity','<a href="https://thechels.co.uk/analysis/results/?team=NORWICH_CITY">Norwich City</a>',$content);
				$content = str_replace('^_SpartakMoscow','<a href="https://thechels.co.uk/analysis/results/?team=Spartak_Moscow">Spartak Moscow</a>',$content);
				$content = str_replace('^_Southampton','<a href="https://thechels.co.uk/analysis/results/?team=SOUTHAMPTON">Southampton</a>',$content);
				$content = str_replace('^_Saints','<a href="https://thechels.co.uk/analysis/results/?team=SOUTHAMPTON">Saints</a>',$content);
				$content = str_replace('^_StokeCity','<a href="https://thechels.co.uk/analysis/results/?team=STOKE_CITY">Stoke City</a>',$content);
				/** ladies **/
				$content = str_replace('^_Birmingham_City_LFC','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=BIRMINGHAM_CITY_LFC">Birmingham City Ladies</a>',$content);
				$content = str_replace('^_Birmingham_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=BIRMINGHAM_CITY_LFC">Birmingham City Ladies</a>',$content);
				$content = str_replace('^_Birmingham_City_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=BIRMINGHAM_CITY_LFC">Birmingham City Ladies</a>',$content);
				$content = str_replace('^_Doncaster_Rovers_Belles','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=DONCASTER_ROVERS_BELLES_LFC">Doncaster Rovers Belles</a>',$content);
				$content = str_replace('^_Arsenal_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=ARSENAL_LFC">Arsenal Ladies</a>',$content);
				$content = str_replace('^_Everton_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=EVERTON_LFC">Everton Ladies</a>',$content);
				$content = str_replace('^_Bristol_Academy_Women','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=BRISTOL_ACADEMY_WFC">Bristol Academy</a>',$content);
				$content = str_replace('^_Bristol_Academy','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=BRISTOL_ACADEMY_WFC">Bristol Academy</a>',$content);
				$content = str_replace('^_Lincoln_City_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=LINCOLN_LADIES">Lincoln Ladies</a>',$content);
				$content = str_replace('^_Lincoln_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=LINCOLN_LADIES">Lincoln Ladies</a>',$content);
				$content = str_replace('^_Liverpool_Ladies','<a href="https://thechels.co.uk/analysis-ladies/results-ladies/?team=LIVERPOOL_LFC">Liverpool Ladies</a>',$content);
				$content = str_replace('^_Chelsea_Ladies','<strong>Chelsea Ladies</strong>',$content);
                $content = str_replace('[Src','[src',$content);
				return $content;
			}

		}

		new replacer();
	}
