<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/schema.php";

	class SchemaTests extends PHPUnit_Framework_TestCase {

		/**
		 * Test views are create or replace
		 * Test tables are create
		 * Test statements are Select
		 */
		public function testCreateOrReplaceForViews() {

			$schema = new schema();

			$this->assertStringStartsWith( "CREATE TABLE", $schema->_0V_base_YRBIG() );

			$this->assertStringStartsWith( "SELECT", $schema->_selection_year( "table" ) );
			$this->assertStringStartsWith( "SELECT", $schema->_selection( "table" ) );

			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PDO_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_RES() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_goaldiffpl() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_progress_cfc() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_oppoMgr() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_mgr() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_country() );

			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0v_analysis_subs_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_BIG() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_BIG_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_BIG_TSO() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_CFC() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_CFC2( "date" ) );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_close() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_close_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_COMBINE() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_current_pl_teams() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_EVER() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_EVER_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_GRANK() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_REFRANK() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_ISG() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_ISG_table() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_ISG_totals() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_LDN() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_LDN_non() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_LDN_non_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_LDN_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_LDN_TSO() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_last38() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_last38_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_Per90s() );

			/* premier league */
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_mgr() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_GDIFF() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_post() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_pre() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_shots() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_shotsOn() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_1C() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_1S() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_D_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_L_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_post() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_pre() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_W_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_this_WD_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PL_year() );
			/* end premier league */

			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PRE() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PRJ() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_PRJ_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_pythag_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_SWLDN() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_SWLDN_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_T13() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_T13_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_TSO() );

			/* women */
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WDL_north() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WDL_north_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WDL_south() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WDL_south_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WRANK() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL1() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL1_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL2() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL2_this() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_ISG() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_ISG_table( '2015', '2014' ) );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_ISG_totals() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_Per90s() );

			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_1C() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_1S() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_D_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_WD_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_W_HT() );
			$this->assertStringStartsWith( "CREATE OR REPLACE VIEW", $schema->_0V_base_WSL_this_L_HT() );




			/* end women */


		}

		/**
		 *  Test strings of team subsets are set correctly
		 */
		public function testStringsAreSetCorrectly() {

			$schema = new schema();

			$this->assertTrue( $schema->big7  === "('MAN_UTD', 'CHELSEA', 'ARSENAL', 'SPURS', 'EVERTON', 'LIVERPOOL', 'MAN_CITY')");
			$this->assertTrue( $schema->ldn   === "('WEST_HAM', 'QPR', 'FULHAM', 'BRENTFORD', 'CHARLTON', 'C_PALACE', 'MILLWALL', 'ARSENAL', 'SPURS', 'CHELSEA', 'WIMBLEDON')");
			$this->assertTrue( $schema->swldn === "('QPR',  'FULHAM',  'BRENTFORD',  'CHELSEA')");
			$this->assertTrue( $schema->ever6 === "('MAN_UTD', 'CHELSEA', 'ARSENAL', 'SPURS', 'EVERTON', 'LIVERPOOL')");

		}
	}
	