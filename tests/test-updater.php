<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/updater.php";
	
	class UpdaterTests extends PHPUnit_Framework_TestCase {

		public function testSwapOutTeamNames(){

			$updater = new updater();

			$this->assertTrue ( 'C_PALACE'       === $updater->swapOutTeamNames( 'Crystal Palace'));
			$this->assertTrue ( 'SPURS'          === $updater->swapOutTeamNames( 'Tottenham'));
			$this->assertTrue ( 'WEST_HAM'       === $updater->swapOutTeamNames( 'West Ham'));
			$this->assertTrue ( 'CHELSEA'        === $updater->swapOutTeamNames( 'Chelsea'));
			$this->assertTrue ( 'WEST_BROM'      === $updater->swapOutTeamNames( 'West Brom'));
			$this->assertTrue ( 'LEICESTER'      === $updater->swapOutTeamNames( 'LEICESTER CITY'));
			$this->assertTrue ( 'LEICESTER'      === $updater->swapOutTeamNames( 'Leicester City'));
			$this->assertTrue ( 'MAN_CITY'       === $updater->swapOutTeamNames( 'MAN CITY'));
			$this->assertTrue ( 'MAN_CITY'       === $updater->swapOutTeamNames( 'MANCHESTER CITY'));
			$this->assertTrue ( 'MAN_UTD'        === $updater->swapOutTeamNames( 'Manchester United'));
			$this->assertTrue ( 'MAN_UTD'        === $updater->swapOutTeamNames( 'MAN UNITED'));
			$this->assertTrue ( 'MAN_UTD'        === $updater->swapOutTeamNames( 'MANCHESTER UNITED'));
			$this->assertTrue ( 'BORO'           === $updater->swapOutTeamNames( 'MIDDLESBROUGH'));
			$this->assertTrue ( 'NEWCASTLE'      === $updater->swapOutTeamNames( 'NEWCASTLE UTD'));
			$this->assertTrue ( 'NORWICH'        === $updater->swapOutTeamNames( 'NORWICH CITY'));
			$this->assertTrue ( 'STOKE'          === $updater->swapOutTeamNames( 'STOKE CITY'));
			$this->assertTrue ( 'ASTON_VILLA'    === $updater->swapOutTeamNames( 'ASTON VILLA' ));
			$this->assertTrue (	'C_PALACE'       === $updater->swapOutTeamNames( 'CRYSTAL PALACE'));
			$this->assertTrue (	'DERBY'          === $updater->swapOutTeamNames( 'DERBY COUNTY'));
			$this->assertTrue (	'LEICESTER'      === $updater->swapOutTeamNames( 'LEICESTER CITY'));
			$this->assertTrue (	'MAN_CITY'       === $updater->swapOutTeamNames( 'MAN CITY'    ));
			$this->assertTrue (	'MAN_CITY'       === $updater->swapOutTeamNames( 'MANCHESTER CITY' ));
			$this->assertTrue (	'MAN_UTD'        === $updater->swapOutTeamNames( 'MAN UNITED'  ));
			$this->assertTrue (	'MAN_UTD'        === $updater->swapOutTeamNames( 'MANCHESTER UNITED'));
			$this->assertTrue (	'BORO'           === $updater->swapOutTeamNames( 'MIDDLESBROUGH'));
			$this->assertTrue (	'NEWCASTLE'      === $updater->swapOutTeamNames( 'NEWCASTLE UTD'));
			$this->assertTrue (	'NORWICH'        === $updater->swapOutTeamNames( 'NORWICH CITY'));
			$this->assertTrue (	'STOKE'          === $updater->swapOutTeamNames( 'STOKE CITY'  ));
			$this->assertTrue (	'SWANSEA'        === $updater->swapOutTeamNames( 'SWANSEA CITY'));
			$this->assertTrue (	'SPURS'          === $updater->swapOutTeamNames( 'TOTTENHAM'   ));
			$this->assertTrue (	'WEST_BROM'      === $updater->swapOutTeamNames( 'WEST BROM'   ));
			$this->assertTrue (	'WEST_BROM'      === $updater->swapOutTeamNames( 'WEST BROMWICH'));
			$this->assertTrue (	'WEST_HAM'       === $updater->swapOutTeamNames( 'WEST HAM'    ));
			$this->assertTrue (	'BIRMINGHAM'     === $updater->swapOutTeamNames( 'BIRMINGHAM CITY' ));
			$this->assertTrue (	'DONCASTER'      === $updater->swapOutTeamNames( 'DONCASTER ROVERS BELLES' ));
			$this->assertTrue (	'DONCASTER'      === $updater->swapOutTeamNames( 'DONCASTER'   ));
			$this->assertTrue (	'BRISTOL'        === $updater->swapOutTeamNames( 'BRISTOL ACADEMY'));
			$this->assertTrue (	'BRISTOL'        === $updater->swapOutTeamNames( 'BRISTOL CITY'));
			$this->assertTrue (	'SHEFFIELD'      === $updater->swapOutTeamNames( 'SHEFFIELD'   ));
			$this->assertTrue (	'LIVERPOOL'      === $updater->swapOutTeamNames( 'LIVERPOOL'   ));
			$this->assertTrue (	'EVERTON'        === $updater->swapOutTeamNames( 'EVERTON'     ));
			$this->assertTrue (	'MILLWALL'       === $updater->swapOutTeamNames( 'MILLWALL LIONESSES' ));
			$this->assertTrue (	'SUNDERLAND'     === $updater->swapOutTeamNames( 'SUNDERLAND'  ));
			$this->assertTrue (	'DURHAM'         === $updater->swapOutTeamNames( 'DURHAM'      ));
			$this->assertTrue (	'WATFORD'        === $updater->swapOutTeamNames( 'WATFORD'     ));
			$this->assertTrue (	'LONDON_BEES'    === $updater->swapOutTeamNames( 'LONDON BEES' ));
			$this->assertTrue (	'ARSENAL'        === $updater->swapOutTeamNames( 'ARSENAL'     ));
			$this->assertTrue (	'CHELSEA'        === $updater->swapOutTeamNames( 'CHELSEA'     ));
			$this->assertTrue (	'YEOVIL'         === $updater->swapOutTeamNames( 'YEOVIL TOWN' ));
			$this->assertTrue (	'READING'        === $updater->swapOutTeamNames( 'READING'     ));
			$this->assertTrue (	'NOTTS_COUNTY'   === $updater->swapOutTeamNames( 'NOTTS COUNTY'));
			$this->assertTrue (	'OXFORD'         === $updater->swapOutTeamNames( 'OXFORD UNITED'));
			
			
		}

		public function testRandomUa() {

			$up = new updater();
			$string   = $up->generateRandomUA();
			$prefix   = 'Mozilla/5.0';

			$this->assertStringStartsWith( $prefix, $string );
		}

		public function testRemoveLines() {

			$up = new updater();
			$data = "<p><br/>\n\tbob</p>";
			$output = $up->removeLines($data);
			$this->assertTrue( $output === "   bob ");
		}

		public function testUpperTrimStrippedCell() {

			$up = new updater();
			$test =$up->upperTrimStrippedCell('<td>bob</td>');
			$expected = 'BOB';
			$this->assertTrue($test === $expected);
		}

		public function testSubstringByPosition() {

			$up = new updater();
			$output = $up->subStringingByPosition( "<p>", "</p>", "<p>bob<br/>bob</p>" );
			$expected = "<p>bob<br/>bob";
			$this->assertTrue($output == $expected);

		}

		public function testMakeIsoDateFromString() {

			$up = new updater();
			$output = $up->makeIsoDateFromString('08/01/16 14:00');
			$expected = '2016-01-08';
			$this->assertTrue($output == $expected);
			
			$output = $up->makeIsoDateFromString('08.05.16 14:00');
			$expected = '2016-05-08';
			$this->assertTrue($output == $expected);

		}

		public function testReplaceDashesSpacesForComma() {

			$up = new updater();
			$output = $up->replaceDashesSpacesForComma('string has - dashes and     spaces');
			$expected = "string has , dashes and,  spaces";
			$this->assertTrue($output == $expected);
		}
	}
