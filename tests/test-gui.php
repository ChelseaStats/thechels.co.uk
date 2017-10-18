<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/gui.php";
	
	class GuiTests extends PHPUnit_Framework_TestCase {
		
		public function testFormat() {
			
			$this->assertTrue('' == _format('9999-12-31'));
			$this->assertTrue('' == _format('0000-00-00'));
			$this->assertTrue('9999 12 31' == _format('9999_12_31'));

		}

		public function testFormatNotes() {

			$this->assertTrue('Test.'  === _formatNotes('test.'));
			$this->assertTrue('T est' === _formatNotes('t_est'));
			$this->assertTrue('T&gt;est' === _formatNotes('t>est'));
			$this->assertTrue("T'&gt;est" === _formatNotes("t\'>est"));
		}

		public function testFormatDate() {

			$this->assertTrue("<span class='nowrap'><nobr>2012-05-19</nobr></span>" === _formatDate('2012-05-19'));
			$this->assertTrue("<span class='nowrap'><nobr></nobr></span>" === _formatDate('0000-00-00'));
			$this->assertTrue("<span class='nowrap'><nobr></nobr></span>" === _formatDate('9999-12-31'));
			$this->assertTrue("<span class='nowrap'><nobr>9999 12 31</nobr></span>" === _formatDate('9999_12_31'));
		}

		public function testFormatMoney() {

			$this->assertTrue("<span class='nowrap'><nobr>&pound;200</nobr></span>" == _formatMoney('£200'));
		}

		public function testFormatEvent() {

			$this->assertTrue("<img class='eventimg' src='//thechels.co.uk/media/themes/ChelseaStats/img/value.png' alt='value' title='value' />" === _formatEVENT('value'));
			$this->assertTrue("<img class='eventimg' src='//thechels.co.uk/media/themes/ChelseaStats/img/value test.png' alt='value test' title='value test' />" === _formatEVENT('value test'));

		}

		public function testFormatTW() {

			$this->assertTrue("<a href='http://www.twitter.com/#!/twitter'>twitter</a>" == _formatTW('twitter'));
		}

		public function testFormatName() {

			$this->assertTrue('QPR' === _formatNAME('Qpr'));
			$this->assertTrue('Chelsea' === _formatNAME('chelsea'));
			$this->assertTrue('Ruben Loftus-Cheek' === _formatNAME('RUBEN_LOFTUS-CHEEK'));

		}

		public function testFormatLinkName() {

			$this->assertTrue('<a href="https://thechels.co.uk/analysis/players/data/?plyr=bob">Bob</a>' === _formatLinkNAME('bob'));
			$this->assertTrue('<a href="https://thechels.co.uk/analysis/players/data/?plyr=bob_bob">Bob Bob</a>' === _formatLinkNAME('bob_bob'));

		}

		public function testFormatKeepName() {

			$this->assertTrue('<a href="https://thechels.co.uk/analysis/players/data/?kpr=bob">Bob</a>' === _formatKeepNAME('bob'));
			$this->assertTrue('<a href="https://thechels.co.uk/analysis/players/data/?kpr=bob_bob">Bob Bob</a>' === _formatKeepNAME('bob_bob'));

		}
		
		public function testFormatAtt() {

			$this->assertTrue('200,000'         == _formatATT('200000'));
			$this->assertTrue('200,000,000'     == _formatATT('200000000'));
			$this->assertTrue('200,000,000,000' == _formatATT('200000000000'));
			$this->assertTrue('200,000'         == _formatATT('200000.50'));


		}
		
		public function testFormatMenOpp() {

			$this->assertTrue('<strong>Chelsea</strong>' === _M_formatOPP('CHELSEA'));
			$this->assertTrue("<a href='//thechels.co.uk/analysis/results/?team=ARSENAL' title='view all the results against this opposition'>Arsenal</a>" === _M_formatOPP('ARSENAL'));
			$this->assertTrue("<a href='//thechels.co.uk/analysis/results/?team=SHEFF_WED' title='view all the results against this opposition'>Sheff Wed</a>" === _M_formatOPP('SHEFF_WED'));

		}

		public function testFormatWomenOpp() {

			$this->assertTrue('<strong>Chelsea Ladies</strong>' === _W_formatOPP('CHELSEA LADIES'));
			$this->assertTrue("<a href='//thechels.co.uk/analysis-ladies/results-ladies/?team=ARSENAL' title='view all the results against this opposition'>Arsenal</a>" === _W_formatOPP('ARSENAL'));
			$this->assertTrue("<a href='//thechels.co.uk/analysis-ladies/results-ladies/?team=SHEFF_WED' title='view all the results against this opposition'>Sheff Wed</a>" === _W_formatOPP('SHEFF_WED'));

		}

		public function testFormatMenReferee() {

			$a = 'CLATTENBURG,MARK';
			$b = "<a href='//thechels.co.uk/analysis/referees/?ref=CLATTENBURG,MARK' title='view all results with this referee'>Mark Clattenburg</a>";
			$this->assertTrue( $b == _M_formatREF($a));

			$a = 'LAHOZ,ANTONIO_MATEU';
			$b = "<a href='//thechels.co.uk/analysis/referees/?ref=LAHOZ,ANTONIO_MATEU' title='view all results with this referee'>Antonio Mateu Lahoz</a>";
			$this->assertTrue( $b == _M_formatREF($a));
		}

		public function testFormatWomenReferee() {

			$a = _W_formatREF('BRYNE,HELEN');
			$b = "<a href='//thechels.co.uk/analysis-ladies/ladies-referees/?ref=BRYNE,HELEN' title='view all results with this referee'>Helen Bryne</a>";
			$this->assertTrue( $b == $a);

			$a = _W_formatREF('LAHOZ,ANTONIO_MATEU');
			$b = "<a href='//thechels.co.uk/analysis-ladies/ladies-referees/?ref=LAHOZ,ANTONIO_MATEU' title='view all results with this referee'>Antonio Mateu Lahoz</a>";
			$this->assertTrue( $b == $a);

		}

		public function testFormatXMenDate() {

			$string = "<a class='nowrap' href='//thechels.co.uk/analysis/results/events/?game=id' title='view the match details of this game'><span class='nowrap'><nobr>date</nobr></span></a>";
			$this->assertTrue( $string === _M_formatxDATE('id,date'));

		}

		public function testFormatXWomenDate() {

			$string = "<a class='nowrap' href='//thechels.co.uk/analysis-ladies/results-ladies/match-events-ladies/?game=id' title='view the match details of this game'><span class='nowrap'><nobr>date</nobr></span></a>";
			$this->assertTrue( $string === _L_formatxDATE('id,date'));

		}

		public function testFormatMenComp() {

			$string = "<a href='//thechels.co.uk/analysis/competitions/?comp=PREM' title='view all results in this competition'>PREM</a>";
			$this->assertTrue($string == _M_formatCOMP('PREM'));
		}

		public function testFormatWomenComp() {

			$string = "<a href='//thechels.co.uk/analysis-ladies/competition-analysis/?comp=PREM' title='view all results in this competition'>PREM</a>";
			$this->assertTrue($string == _W_formatCOMP('PREM'));
		}

		public function testFormatMenManager() {

			$string = "<a href='//thechels.co.uk/analysis/managers/profiles/?profile=MOURINHO2' title='view all the results for this manager'>Mourinho2</a>";
			$this->assertTrue($string === _M_formatMGR('MOURINHO2'));

			$string = "<a href='//thechels.co.uk/analysis/managers/profiles/?profile=DI_MATTEO' title='view all the results for this manager'>Di Matteo</a>";
			$this->assertTrue($string === _M_formatMGR('DI_MATTEO'));
		}

		public function testFormatWomenManager() {

			$string = "<a href='//thechels.co.uk/analysis-ladies/managerial-analysis-ladies/manager-profiles-ladies/?profile=MOURINHO2' title='view all the results for this manager'>Mourinho2</a>";
			$this->assertTrue($string === _W_formatMGR('MOURINHO2'));

			$string = "<a href='//thechels.co.uk/analysis-ladies/managerial-analysis-ladies/manager-profiles-ladies/?profile=DI_MATTEO' title='view all the results for this manager'>Di Matteo</a>";
			$this->assertTrue($string === _W_formatMGR('DI_MATTEO'));
		}

		public function testTitleCase() {

			$this->assertTrue('String' === titleCase('string'));
			$this->assertTrue('String String' === titleCase('string string'));
			$this->assertTrue('String-String' == titleCase('string-string'));

		}
	}