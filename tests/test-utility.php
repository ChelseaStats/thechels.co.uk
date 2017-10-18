<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/utility.php";

	class UtilityTests extends PHPUnit_Framework_TestCase {

		public function testWriteLinks() {
			$go = new utility();
			$first = $go->writeLinks('new #tweet');
			$test = 'new  <a href="http://twitter.com/search/tweet">#tweet</a> ';
			$this->assertTrue($test == $first);
		}

		public function testEscapeHtml() {

			$go = new utility();
			$this->assertTrue('//test/html&lt;&gt;' == $go->esc_html('//test/html<>'));
		}

		public function testGetAnother() {
			$go = new utility();
			$this->assertTrue('<span class="another"><a href="#"  class="btn btn-primary">bob</a></span>' == $go->getAnother('#','bob'));
			$this->assertTrue('<span class="another"><a href="#"  class="btn btn-primary">frank</a></span>' == $go->getAnother('#','frank'));
			$this->assertTrue('<span class="another"><a href="#"  class="btn btn-primary">7</a></span>' == $go->getAnother('#','7'));
		}

		public function testGetSubmit() {

			$go = new utility();
			$this->assertStringStartsWith('<div class="row-fluid"><div class="span12">', $go->getSubmit());
		}

		public function testGetInitials() {

			$go = new utility();

			$this->assertTrue( 'GZ'    === $go->getInitials('Gianfranco Zola'));
			$this->assertTrue( 'GLS'   === $go->getInitials('Graeme Le Saux'));
			$this->assertTrue( 'DC'    === $go->getInitials('Diego Costa'));
			$this->assertTrue( 'RLC'   === $go->getInitials('Ruben Loftus-Cheek'));
			$this->assertTrue( 'FL'    === $go->getInitials('Frank Lampard'));
			$this->assertTrue( 'FL'    === $go->getInitials('FRANK LAMPARD'));
			$this->assertTrue( 'RLC'   === $go->getInitials('Ruben Loftus-Cheek'));

		}

		public function testGetTooltip() {
			$go = new utility();
			$this->assertTrue('<abbr data-toggle="tooltip" data-placement="top" title="title">label</abbr>'         == $go->getTooltip('label','title'));
			$this->assertTrue('<abbr data-toggle="tooltip" data-placement="top" title="Goals Per Game">GPG</abbr>'  == $go->getTooltip('GPG','Goals Per Game'));

		}

		public function testGetPercentage() {

			$go = new utility();

			$this->assertTrue ( '33.33' === $go->getPercentage(1,3,2));
			$this->assertTrue ( '50.00' === $go->getPercentage(1,2,2));
			$this->assertTrue ( '50'    === $go->getPercentage(2,4,0));
			$this->assertTrue ( '75'    === $go->getPercentage(75,100,0));

		}
		
		public function testGetOptionMenu() {
			
			$go = new utility();
			
			$this->assertStringStartsWith('<div class="row-fluid"><div class="span12">', $go->getSubmit());
		}

		public function testGetMinute() {

			$go = new utility();

			$this->assertTrue(10 === $go->get_minute(10));
			$this->assertTrue(20 === $go->get_minute(20));
			$this->assertTrue(30 === $go->get_minute(30));
			$this->assertTrue(40 === $go->get_minute(40));
			$this->assertTrue(45 === $go->get_minute(45));
			$this->assertTrue(45 == $go->get_minute('45+1'));
			$this->assertTrue(45 == $go->get_minute('45+8'));
			$this->assertTrue(50 === $go->get_minute(50));
			$this->assertTrue(60 === $go->get_minute(60));
			$this->assertTrue(70 === $go->get_minute(70));
			$this->assertTrue(80 === $go->get_minute(80));
			$this->assertTrue(90 === $go->get_minute(90));
			$this->assertTrue(90 == $go->get_minute('90+5'));
			$this->assertTrue(95 === $go->get_minute(95));
			$this->assertTrue(104 === $go->get_minute(104));
			$this->assertTrue(105 === $go->get_minute(105));
			$this->assertTrue(110 === $go->get_minute(110));
			$this->assertTrue(120 === $go->get_minute(120));
			$this->assertTrue(120 === $go->get_minute(120));
			$this->assertTrue(120 == $go->get_minute('120+10'));
			$this->assertTrue(120 == $go->get_minute('120+30'));
		}

		public function testGetHalf() {

			$go = new utility();

			$this->assertTrue(1 === $go->get_half(1));
			$this->assertTrue(1 === $go->get_half(10));
			$this->assertTrue(1 === $go->get_half(20));
			$this->assertTrue(1 === $go->get_half(30));
			$this->assertTrue(1 === $go->get_half(40));
			$this->assertTrue(1 === $go->get_half(45));
			$this->assertTrue(2 === $go->get_half(46));
			$this->assertTrue(2 === $go->get_half(50));
			$this->assertTrue(2 === $go->get_half(60));
			$this->assertTrue(2 === $go->get_half(70));
			$this->assertTrue(2 === $go->get_half(80));
			$this->assertTrue(2 === $go->get_half(90));
			$this->assertTrue(3 === $go->get_half(95));
			$this->assertTrue(3 === $go->get_half(100));
			$this->assertTrue(4 === $go->get_half(115));
			$this->assertTrue(4 === $go->get_half(120));
			$this->assertTrue(4 === $go->get_half(130));

		}

		public function testGetContains() {

			$go = new utility();
			$array = ['string','bob','chelsea'];
			$this->assertTrue(True == $go->get_contains('string',$array));
		}

		public function testInputUpClean() {

			$u = new utility();
			$output = $u->inputUpClean("string`ingTogether's<br/>");
			$expected = "STRING`INGTOGETHER\'S";
			$this->assertTrue($output == $expected);
		}

		public function testGetPrepareText() {

			$go = new utility();
			$this->assertTrue('' == $go->get_prepare_text(''));
			$this->assertTrue('A' == $go->get_prepare_text('Æ'));
			$this->assertTrue('O' == $go->get_prepare_text('Ö'));
			$this->assertTrue('S' == $go->get_prepare_text('ş'));
			$this->assertTrue('B' == $go->get_prepare_text('b'));

		}

		public function testVisualTeamName() {

			$go = new utility();

			$this->assertTrue('Man Utd'            === $go->_V("MAN_UTD") );
			$this->assertTrue('Chelsea'            === $go->_V("CHELSEA"));
			$this->assertTrue('Tottenham Hotspur'  === $go->_V("TOTTENHAM_HOTSPUR"));
			$this->assertFalse('Spurs'             === $go->_V("TOTTENHAM_HOTSPUR"));
			$this->assertTrue('Manchester City'    === $go->_V("MANCHESTER_CITY"));
			$this->assertTrue('Ruben Loftus-Cheek' === $go->_V('RUBEN_LOFTUS-CHEEK'));
			$this->assertTrue('Graeme Le Saux'     === $go->_V('GRAEME_LE_SAUX'));
			$this->assertTrue('Gianfranco Zola'    === $go->_V('GIANFRANCO ZOLA'));
			$this->assertTrue("Samuel Eto'o"       === $go->_V("SAMUEL_ETO'O"));
			$this->assertTrue("Paris Saint-Germain" === $go->_V("PARIS_SAINT-GERMAIN"));

		}

		public function testQueryTeamName() {

			$go = new utility();

			$this->assertTrue('MAN_UTD'             === $go->_Q("MAN_UTD"));
			$this->assertTrue('CHELSEA'             === $go->_Q("CHELSEA"));
			$this->assertTrue('TOTTENHAM_HOTSPUR'   === $go->_Q("TOTTENHAM_HOTSPUR"));
			$this->assertTrue('MANCHESTER_CITY'     === $go->_Q("MANCHESTER_CITY"));
			$this->assertFalse('Spurs'              === $go->_Q("TOTTENHAM_HOTSPUR"));
		}

		public function testYear() {
			$go = new utility();
			$this->assertTrue( '2015' == $go->_Y( '2015-01-01' ) );
			$this->assertTrue( '2016' == $go->_Y( '2016-01-01' ) );
			$this->assertTrue( '2017' == $go->_Y( '2017-01-01' ) );
			$this->assertTrue( '1968' == $go->_Y( '1968-01-01' ) );
			$this->assertTrue( '1972' == $go->_Y( '1972-01-01' ) );
			$this->assertTrue( '2015' == $go->_Y( '2015-08-01' ) );
			$this->assertTrue( '2016' == $go->_Y( '2016-08-01' ) );
			$this->assertTrue( '2017' == $go->_Y( '2017-12-31' ) );
			$this->assertTrue( '1970' == $go->_Y( '1970-01-01' ) );
			$this->assertTrue( '1652' == $go->_Y( '1652-01-01' ) );
		}

		public function testEscaping() {

			$go = new utility();
			$test = $go->escaping('//test/html<>');
			$this->assertTrue('//test/html<>' == $test);
		}

		public function testCompetitionText() {

			$go = new utility();

			$this->assertTrue('Premier League'     === $go->comp('PREM'));
			$this->assertTrue('FA Cup'             === $go->comp('FAC'));
			$this->assertTrue('FA Cup'            === $go->comp('fac'));
			$this->assertTrue('Champions League'  === $go->comp('UCL'));
		}

		public function testRefereeNameFormat() {

			$go = new utility();

			$this->assertTrue('Firstname Surname'   === $go->ref('SURNAME,FIRSTNAME'));
			$this->assertFalse('First Name Surname' === $go->ref('SURNAME,FIRST,NAME'));
			$this->assertFalse('Surname Firstname'  === $go->ref('SURNAME FIRSTNAME'));
		}

		public function testLocationStringFormat() {

			$go = new utility();

			$this->assertTrue('At Stamford Bridge' === $go->local('H'));
			$this->assertTrue('Away from home'     === $go->local('A'));
			$this->assertTrue('On neutral soil'    === $go->local('N'));
			$this->assertFalse('On neutral soil'   === $go->local('other'));
			$this->assertTrue('unknown'            === $go->local(''));

		}

		public function testLocationGetter() {

			$go = new utility();

			$this->assertTrue( 'Home' === $go->getLoc( 'H' ) );
			$this->assertTrue( 'Away' === $go->getLoc( 'A' ) );
			$this->assertTrue( 'Neutral' === $go->getLoc( 'N' ) );
			$this->assertTrue( 'unknown' === $go->getLoc( 'other' ) );
			$this->assertTrue( 'unknown' === $go->getLoc( '' ) );
		}

		public function testPluralPenalties() {

			$go = new utility();

			$this->assertTrue('0 penalties' === $go->pluralPens('0'));
			$this->assertTrue('1 penalty'   === $go->pluralPens('1'));
			$this->assertTrue('2 pens'      === $go->pluralPens('2'));
			$this->assertTrue('3 pens'      === $go->pluralPens('3'));
			$this->assertTrue('4 pens'      === $go->pluralPens('4'));

		}

		public function testPluralCards() {

			$go = new utility();

			$this->assertTrue('0 cards' === $go->pluralCards('0'));
			$this->assertTrue('1 card'  === $go->pluralCards('1'));
			$this->assertTrue('2 cards' === $go->pluralCards('2'));
			$this->assertTrue('3 cards' === $go->pluralCards('3'));
			$this->assertTrue('4 cards' === $go->pluralCards('4'));

		}

		public function testPlayerName() {
			$go = new utility();
			$this->assertTrue('Roberto di Matteo'   == $go->titleCase("ROBERTO DI MATTEO"));
			$this->assertTrue('Graeme Le Saux'      == $go->titleCase("Graeme Le Saux"));
			$this->assertTrue('Jurgen MacHo'        == $go->titleCase("JURGEN MACHO")); //wrong
		}

		public function testOrdinal() {
			$go = new utility();
			$this->assertTrue('1st'     == $go->numsuffix(1));
			$this->assertTrue('2nd'     == $go->numsuffix(2));
			$this->assertTrue('3rd'     == $go->numsuffix(3));
			$this->assertTrue('4th'     == $go->numsuffix(4));
			$this->assertTrue('11th'    == $go->numsuffix(11));
			$this->assertTrue('22nd'    == $go->numsuffix(22));
			$this->assertTrue('44th'    == $go->numsuffix(44));
			$this->assertTrue('21st'    == $go->numsuffix(21));
			$this->assertTrue('31st'    == $go->numsuffix(31));
			$this->assertTrue('101st'   == $go->numsuffix(101));
			$this->assertTrue('2nd'     == $go->numsuffix(2));
			$this->assertTrue('32nd'    == $go->numsuffix(32));
			$this->assertTrue('33rd'    == $go->numsuffix(33));
			$this->assertTrue('66th'    == $go->numsuffix(66));
		}

		public function testgetValueFromKey(){
			$go = new utility();
			$array = [ "key" => "value" ];
			$this->assertTrue("value" == $go->getValueFromKey($array));
		}

		public function testgetValuesFromArray(){
			$go = new utility();
			$array = [ "key" => "value" ];
			$this->assertTrue("value" == $go->getValuesFromArray($array, 1));
		}

		public function testTitleCase(){
			$go = new utility();
			$this->assertTrue('Bob Smith' === $go->titleCase('BOB SMIth'));
			$this->assertTrue('Bob van de Dutch' === $go->titleCase('BOB VAN DE DUTCH'));
			$this->assertTrue('Bob van der Dutch' === $go->titleCase('BOB VAN DER DUTCH'));
			$this->assertTrue('Ruben Loftus-Cheek' === $go->titleCase('RUBEN LOFTUS-CHEEK'));
			$this->assertTrue('Kevin McAllister' === $go->titleCase('KEVIN MCALLISTER'));
			$this->assertTrue('Kevin McAllister' === $go->titleCase('kevin MCallISTER'));
			$this->assertTrue('Kevin MacAllister'=== $go->titleCase('KEVIN macallister'));
			$this->assertTrue('Kevin MacAllister'=== $go->titleCase('KEVIN MACALLISTER'));
			$this->assertTrue('Kevin McAllister the VII' === $go->titleCase('KEVIN MCALLISTER the vii'));
			$this->assertTrue('Roberto di Matteo' === $go->titleCase('ROBERTO DI MATTEO'));
			$this->assertTrue("Micahel d'Angelo" === $go->titleCase("MICAHEL D'ANGELO"));
			$this->assertTrue('Gianfranco Zola' === $go->titleCase('GIANFRANCO ZOLA'));
			$this->assertTrue('Marco van Ginkel' === $go->titleCase('MARCO VAN GINKEL'));
			$this->assertTrue('Jurgen MacHo' === $go->titleCase('jurgen macho'));
		}

		public function testCleanTweet(){
			$go = new utility();
			$this->assertTrue('clean tweet' === $go->cleanTweet('clean tweet @chelseastats'));
			$this->assertTrue('clean tweet' === $go->cleanTweet('@chelseastats clean tweet @chelseastats'));
			$this->assertTrue('clean tweet' === $go->cleanTweet('@chelseastats clean tweet'));
		}

		public function testSplitTweets() {

			$go = new utility();
			$array = ["a","b"];
			$this->assertTrue( $array === $go->splitTweets('a//b'));

			$array_three = ["a","b","c"];
			$this->assertTrue( $array_three === $go->splitTweets('a//b//c'));

		}

		public function testCountHashTags() {
			$go = new utility();
			$this->assertTrue( 5 == $go->countHashTags('#1 #2 #3 #4 #5'));
			$this->assertTrue( 0 == $go->countHashTags('no hashes here'));
			$this->assertTrue( 1 == $go->countHashTags('just the one #hash'));
		}

		public function testDecodeHashtags() {
			$go = new utility();
			$this->assertTrue( 'ARSENAL'       == $go->decodeHashtags('#ARS'));
			$this->assertTrue( 'ASTON_VILLA'   == $go->decodeHashtags('#AVFC'));
			$this->assertTrue( 'ASTON_VILLA'   == $go->decodeHashtags('#villa'));
			$this->assertTrue( 'LEICESTER'     == $go->decodeHashtags('#LCFC'));
			$this->assertTrue( 'LEICESTER'     == $go->decodeHashtags('#lei'));
		}

		public function testGetInteger() {
			$go = new utility();
			$this->assertTrue( 1 == $go->getInteger('1'));
			$this->assertTrue( 6 == $go->getInteger('6'));
			$this->assertTrue( 15 == $go->getInteger('15'));
			$this->assertTrue( 6 == $go->getInteger('0'));
			$this->assertTrue( 6 == $go->getInteger('nothing'));
		}

		public function testType() {

			$go = new utility();
			$this->expectOutputString('string');
			$go->type('string');
		}

		public function testConsole() {

			$go = new utility();

			$this->assertTrue( is_string($go->console('string'))=== TRUE );

		}

		public function testDisplayRef() {

			$go = new utility();
			$this->assertTrue('Antonio Mateu Lahoz' == $go->displayRef('LAHOZ,ANTONIO_MATEU'));
			$this->assertTrue('Mike Dean' == $go->displayRef('DEAN,MIKE'));
		}
		
		public function testSafeToTweet() {

			$u        = new utility();
			$string   = "Here is a tweet that tests the full length of the allowable amount of characters needed to fill said tweet from start to finish without extra";
			$output   = $u->safeToTweet( $string );
			$expected = "Here is a tweet that tests the full length of the allowable amount of characters needed to fill said tweet from start to finish without e...";
			$this->assertTrue( $output == $expected );
		}

		public function testTocfcwsTweet() {
			$u        = new utility();
			$string   = "Here is a tweet that tests the full length of the allowable amount of characters needed to fill said ";
			$output   = $u->tocfcwsTweet( $string );
			$expected = "Here is a tweet that tests the full length of the allowable amount of characters needed to fill s...";
			$this->assertTrue( $output == $expected );
		}

		public function testClean() {

			$u = new utility();
			$output = $u->clean("<p>Don't expect this to work</p>");
			$expected = "Don\'t expect this to work";
			$this->assertTrue($output == $expected);
		}
	}