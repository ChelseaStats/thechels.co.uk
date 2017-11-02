<?php
	/*
	Plugin Name: CFC GUI Plugin
	Description: All of the table GUI here - Creates  the fields and tables for data output. it is nice.
	             Must Use plugin but needs to be editable (now mysqli)
	Version: 11.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();
	
	// THIS FUNCTION IS KEY TO THE WORKING OF THE WEBSITE DO NOT DEACTIVATE OR DELETE.
	/**
	 * @param $sql
	 * @return bool|\mysqli_result
	 * @throws \Exception
	 */
	function query_parse( $sql ) {
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if( !$statement = $mysqli->query($sql) ) {
			$err = mysqli_error( $mysqli );
			mysqli_free_result( $statement );
			throw new Exception( print_r( $err, TRUE ) );
		}
		return $statement;
	}
	// THIS FUNCTION IS KEY TO THE WORKING OF THE WEBSITE DO NOT DEACTIVATE OR DELETE.

	/**
	 * @param $mysqli
	 */
	function db_close($mysqli) {
		mysqli_close($mysqli);
		unset( $sql);
	}

	define( 'ffHEADING', 0 );
	define( 'ffWIDTH', 1 );
	define( 'ffALIGN', 2 );
	define( 'ffFUNCTION', 3 );
	$fieldformatting = array(
		// generic list of fields not yet processed fully. might need fixing.
		'PLD'				=>array('PLD',25,'right','_format'),
		'W'				    =>array('W',25,'right','_format'),
		'D'				    =>array('D',25,'right','_format'),
		'L'				    =>array('L',25,'right','_format'),
		'FS'				=>array('FS',25,'right','_format'),
		'CS'				=>array('CS',25,'right','_format'),
		'BTTS'				=>array('BTTS',25,'right','_format'),
		'F'				    =>array('F',25,'right','_format'),
		'A'				    =>array('A',25,'right','_format'),
		'GD'				=>array('GD',25,'right','_format'),
		'PTS'				=>array('PTS',25,'right','_format'),
		'PPG'				=>array('PPG',25,'right','_format'),
		'HG'				=>array('Score',25,'right','_format'),
		'AG'				=>array('Score',25,'right','_format'),
		'A1_PK'             =>array('a Pens',25,'right','_format'),
		'A1_PK_PG'          =>array('a Pens /g',25,'right','_format'),
		'A1_RC'             =>array('a RC',25,'right','_format'),
		'A1_RC_PG'          =>array('a RC /g',25,'right','_format'),
		'A1_YC'             =>array('a YC',25,'right','_format'),
		'A1_YC_PG'          =>array('a YC /g',25,'right','_format'),
		'A_TEAM'            =>array('Away Team',60,'left','_formatNAME'),
		'adraw'             =>array('AD',25,'right','_format'),
		'ALLP90'            =>array('ALLP90',25,'right','_format'),
		'aloss'             =>array('AL',25,'right','_format'),
		'AP90'              =>array('AP90',25,'right','_format'),
		'AvgMins'           =>array('Avg Mins per App',50,'right','_format'),
		'awin'              =>array('AW',25,'right','_format'),
		'draw'              =>array('D',25,'right','_format'),
		'E_DATE'            =>array('End',40, 'right','_formatDate'),
		'F00'               =>array('0' ,15,'right','_format'),
		'F05'               =>array('5' ,15,'right','_format'),
		'F10'               =>array('10',15,'right','_format'),
		'F15'               =>array('15',15,'right','_format'),
		'F1_PK'             =>array('h Pens',25,'right','_format'),
		'F1_PK_PG'          =>array('h Pens /g',25,'right','_format'),
		'F1_RC'             =>array('h RC',25,'right','_format'),
		'F1_RC_PG'          =>array('h RC /g',25,'right','_format'),
		'F1_YC'             =>array('h YC',25,'right','_format'),
		'F1_YC_PG'          =>array('h YC /g',25,'right','_format'),
		'F20'               =>array('20',15,'right','_format'),
		'F25'               =>array('25',15,'right','_format'),
		'F30'               =>array('30',15,'right','_format'),
		'F35'               =>array('35',15,'right','_format'),
		'F40'               =>array('40',15,'right','_format'),
		'F45'               =>array('45',15,'right','_format'),
		'F50'               =>array('50',15,'right','_format'),
		'F55'               =>array('55',15,'right','_format'),
		'F60'               =>array('60',15,'right','_format'),
		'F65'               =>array('65',15,'right','_format'),
		'F70'               =>array('70',15,'right','_format'),
		'F75'               =>array('75',15,'right','_format'),
		'F80'               =>array('80',15,'right','_format'),
		'F85'               =>array('85',15,'right','_format'),
		'F90'               =>array('90',15,'right','_format'),
		'F90_A'             =>array('Assists',25,'right','_format'),
		'F90_G'             =>array('Goals',25,'right','_format'),
		'F90_M'             =>array('Mins',25,'right','_format'),
		'F90_P'             =>array('Pens',25,'right','_format'),
		'F_A_ATTEMPTSOFF'   =>array('A Attempts Off',25,'right','_format'),
		'F_A_ATTEMPTSON'    =>array('A Attempts On',25,'right','_format'),
		'F_A_CORNERS'       =>array('A Corners',25,'right','_format'),
		'F_A_FOULS'         =>array('A Fouls',25,'right','_format'),
		'F_ACCURACY'        =>array('Accuracy',25,'right','_format'),
		'F_AGAINST'         =>array('A',25,'right','_format'),
		'F_AGE'             =>array('Age',25,'right','_format'),
		'F_APPEAL'          =>array('Appeals',25,'right','_format'),
		'F_APPS'            =>array('Apps',25,'right','_format'),
		'F_ASSISTS'         =>array('Assists',25,'right','_format'),
		'F_ATT'             =>array('Attendance',25,'right','_formatATT'),
		'F_AVGSAL'          =>array('Avg Salary',25,'right','_formatMoney'),
		'F_CLEAN'           =>array('CS', 25, 'right','_format'),
		'F_CLUB'            =>array('Club',25,'right','_format'),
		'F_COEFF'           =>array('Coefficient',25,'right','_format'),
		'F_COMPANY'         =>array('Company',25,'right','_format'),
		'F_COMPETITION'     =>array('Competition',45,'left','_M_formatCOMP'),
		'F_CONCEDED'        =>array('Con',25,'right','_format'),
		'F_COUNT'           =>array('Total',35,'right','_format'),
		'F_DATE'            =>array('Date',50,'right','_formatDate'),
		'F_DAY'             =>array('Day',25,'right','_format'),
		'F_DAYS'            =>array('Days', 50, 'right','_format'),
		'F_DESCRIPTION'     =>array('Description',25,'right','_format'),
		'F_DIFF'            =>array('GD',25,'right','_format'),
		'F_DOB'             =>array('DOB',25,'right','_formatDate'),
		'F_DRAW'            =>array('D',25,'right','_format'),
		'F_DRAWPER'         =>array('D %',25,'right','_format'),
		'F_DRAWS'           =>array('D',25,'right','_format'),
		'F_DREW'            =>array('D',25,'right','_format'),
		'F_EDATE'           =>array('End Date',25,'right','_formatDate'),
		'F_ESPN'            =>array('ESPN',25,'right','_format'),
		'F_EVENT'           =>array('Type',25,'right','_formatEVENT'),
		'F_EYEAR'           =>array('End Year',25,'right','_format'),
		'F_FACUP'           =>array('FAC',25,'left','_format'),
		'F_FAILED'          =>array('FS',25,'right','_format'),
		'F_FIRST'           =>array('First',50, 'right','_formatDate'),
		'F_FOR'             =>array('F',25,'right','_format'),
		'F_FOULSCOM'        =>array('Fcom',25,'right','_format'),
		'F_FOULSSUF'        =>array('Fsuf',25,'right','_format'),
		'F_GAMEID'          =>array('GameID',25,'right','_format'),
		'F_GAMES'           =>array('PLD',25,'right','_format'),
		'F_GAPG'            =>array('GA/PG',25,'right','_format'),
		'F_GD'              =>array('GD',25,'right','_format'),
		'F_GFPG'            =>array('GF/PG',25,'right','_format'),
		'F_GOAL_CONVERSION' =>array('Conversion',25,'right','_format'),
		'F_GOALCON'         =>array('Conversion %',25,'right','_format'),
		'F_GOALS'           =>array('Goals',25,'right','_format'),
		'F_GPA'             =>array('GPA',25,'right','_format'),
		'F_GPG'             =>array('GPG',25,'right','_format'),
		'F_H_ATTEMPTSOFF'   =>array('H Attempts off',25,'right','_format'),
		'F_H_ATTEMPTSON'    =>array('H Attempts On',25,'right','_format'),
		'F_H_CORNERS'       =>array('H Corners',25,'right','_format'),
		'F_H_FOULS'         =>array('H Fouls',25,'right','_format'),
		'F_ID'              =>array('ID',25,'right','_format'),
		'F_LAST'            =>array('Last',50, 'right','_formatDate'),
		'F_LCUP'            =>array('LCup',25,'left','_format'),
		'F_LENGTH'          =>array('Length',25,'right','_format'),
		'F_LOCATION'        =>array('Location',25,'right','_format'),
		'F_LOSS'            =>array('L',25,'right','_format'),
		'F_LOSSES'          =>array('L',25,'right','_format'),
		'F_LOSSPER'         =>array('L %',25,'right','_format'),
		'F_MINS'            =>array('Mins',25,'right','_format'),
		'F_MINUTE'          =>array('Minute',25,'right','_format'),
		'F_MIN15'           =>array('Minute Group',40,'right','_format'),
		'F_MONTH'           =>array('Month',25,'right','_format'),
		'F_MONTHNAME'       =>array('Month',25,'right','_format'),
		'F_NATION'          =>array('Nation',25,'left','_format'),
		'F_NO'              =>array('No',25,'right','_format'),
		'F_NONPSTAFF'       =>array('Non Playing Staff',25,'right','_format'),
		'F_NOTES'           =>array('Notes',125,'left','_formatNotes'),
		'F_NUMBER'          =>array('Number',25,'right','_format'),
		'F_OFFSIDES'        =>array('Offsides',25,'right','_format'),
		'F_ORDER'           =>array('Order',25,'right','_format'),
		'F_PASSCOMP'        =>array('Pass Completion',25,'right','_format'),
		'F_PER'             =>array('Percentage',25,'right','_format'),
		'F_PL'              =>array('Pld',25,'right','_format'),
		'F_PLAYED'          =>array('Pld',25,'right','_format'),
		'F_PLAYSTAFF'       =>array('Playing Staff',25,'right','_format'),
		'F_PLD'             =>array('Pld',25,'right','_format'),
		'F_POINTS'          =>array('Pts',25,'right','_format'),
		'F_POS'             =>array('Pos',25,'right','_format'),
		'F_POSITION'        =>array('Pos',25,'right','_format'),
		'F_POSSESSION'      =>array('Possession',25,'right','_format'),
		'F_PPG'             =>array('PPG',25,'right','_format'),
		'F_RATIO'           =>array('ratio',25,'right','_formatMoney'),
		'F_MONTHLY'         =>array('Monthly',25,'right','_formatMoney'),
		'F_HOURLY'          =>array('Hourly',25,'right','_formatMoney'),
		'F_RC'              =>array('RC',25,'right','_format'),
		'F_RESCIND'         =>array('Rescinded',25,'right','_format'),
		'F_RATING'          =>array('Rating',25,'right','_format'),
		'F_SAVEPER'         =>array('Save%',25,'right','_format'),
		'F_SAVES'           =>array('Saves',25,'right','_format'),
		'F_SDATE'           =>array('Start Date',25,'right','_format'),
		'F_SHOTACC'         =>array('Accuracy %',25,'right','_format'),
		'F_SHOTS'           =>array('Shots',25,'right','_format'),
		'F_SHOTSON'         =>array('Shots On',25,'right','_format'),
		'F_SNAME'           =>array('Sname',60,'left','_formatNAME'),
		'F_SQUADNO'         =>array('No',25,'right','_format'),
		'F_STRGL'           =>array('STRGL',25,'right','_format'),
		'F_SUBS'            =>array('Subs',25,'right','_format'),
		'F_SUBSO'           =>array('Subbed on',25,'right','_format'),
		'F_SUBSU'           =>array('Unused',25,'right','_format'),
		'F_SURNAME'         =>array('Sname',60,'left','_M_formatMGR'),
		'F_SYEAR'           =>array('Start Year',25,'right','_format'),
		'F_TEAM'            =>array('Team',75,'left','_M_formatOPP'),
		'F_TGTPER'          =>array('Target%',25,'right','_format'),
		'F_TIME'            =>array('Time',25,'right','_format'),
		'F_TOTAL'           =>array('Total',35,'right','_format'),
		'F_TOTSTAFF'        =>array('Total Staff',25,'right','_formatMoney'),
		'F_TRANSFER'        =>array('Transfer',25,'right','_formatMoney'),
		'F_TROPHIES'        =>array('Trophies',25,'right','_format'),
		'F_TURNOVER'        =>array('Turnover',25,'right','_formatMoney'),
		'F_UNDER'           =>array('U%',25,'right','_format'),
		'F_UNUSED'          =>array('Unused',25,'right','_format'),
		'F_WAGE'            =>array('Wage',25,'right','_format'),
		'F_WIN'             =>array('W',25,'right','_format'),
		'F_WINPER'          =>array('W %',25,'right','_format'),
		'F_WINS'            =>array('W',25,'right','_format'),
		'F_WON'             =>array('W',25,'right','_format'),
		'F_Y1994'           =>array('1994',25,'right','_format'),
		'F_Y1995'           =>array('1995',25,'right','_format'),
		'F_Y1996'           =>array('1996',25,'right','_format'),
		'F_Y1997'           =>array('1997',25,'right','_format'),
		'F_Y1998'           =>array('1998',25,'right','_format'),
		'F_Y1999'           =>array('1999',25,'right','_format'),
		'F_Y2000'           =>array('2000',25,'right','_format'),
		'F_Y2001'           =>array('2001',25,'right','_format'),
		'F_Y2002'           =>array('2002',25,'right','_format'),
		'F_Y2003'           =>array('2003',25,'right','_format'),
		'F_Y2004'           =>array('2004',25,'right','_format'),
		'F_Y2005'           =>array('2005',25,'right','_format'),
		'F_Y2006'           =>array('2006',25,'right','_format'),
		'F_Y2007'           =>array('2007',25,'right','_format'),
		'F_Y2008'           =>array('2008',25,'right','_format'),
		'F_Y2009'           =>array('2009',25,'right','_format'),
		'F_Y2010'           =>array('2010',25,'right','_format'),
		'F_Y2011'           =>array('2011',25,'right','_format'),
		'F_Y2012'           =>array('2012',25,'right','_format'),
		'F_Y2013'           =>array('2013',25,'right','_format'),
		'F_Y2014'           =>array('2014',25,'right','_format'),
		'F_Y2015'           =>array('2015',25,'right','_format'),
		'F_Y2016'           =>array('2016',25,'right','_format'),
		'F_YC'              =>array('YC',25,'right','_format'),
		'F_YEAR'            =>array('Year',25,'right','_format'),
		'F_YR'              =>array('Year',25,'right','_format'),
		'FFT'               =>array('FT',15,'right','_format'),
		'First'             =>array('First',50, 'right','_formatDate'),
		'GP90'              =>array('GP90',25,'right','_format'),
		'H_TEAM'            =>array('Home Team',60,'left','_formatNAME'),
		'hdraw'             =>array('HD',25,'right','_format'),
		'hloss'             =>array('HL',25,'right','_format'),
		'hwin'              =>array('HW',25,'right','_format'),
		'KEY'               =>array('Key',15,'left','_format'),
		'L_COMPETITION'     =>array('Competition',45,'left','_W_formatCOMP'),
		'Last'              =>array('Last',50, 'right','_formatDate'),
		'LOC'               =>array('Loc',15,'left','_format'),
		'Loc'               =>array('Loc',15,'left','_format'),
		'loss'              =>array('L',25,'right','_format'),
		'LX_D_DATE'         =>array('Last Draw',25,'right','_L_formatXdate'),
		'LX_DATE'           =>array('Date',50,'right','_L_formatXdate'),
		'LX_L_DATE'         =>array('Last Loss',25,'right','_L_formatXdate'),
		'LX_T_DATE'         =>array('Last Match',25,'right','_L_formatXdate'),
		'LX_W_DATE'         =>array('Last Win',25,'right','_L_formatXdate'),
		'MGR'               =>array('MGR',100,'left','_format'),
		'MIN_TEAM'          =>array('Team' ,15,'right','_formatNAME'),
		'MX_D_DATE'         =>array('Last Draw',25,'right','_M_formatXdate'),
		'MX_DATE'           =>array('Date',50,'right','_M_formatXdate'),
		'MX_L_DATE'         =>array('Last Loss',25,'right','_M_formatXdate'),
		'MX_T_DATE'         =>array('Last Match',25,'right','_M_formatXdate'),
		'MX_W_DATE'         =>array('Last Win',25,'right','_M_formatXdate'),
		'N_ASSISTS'         =>array('Assists',25,'right','_format'),
		'N_COMP'            =>array('Competition',45,'left','_format'),
		'N_DATE'            =>array('Date',50, 'right','_formatDate'),
		'N_EVENT'           =>array('Type',25,'right','_format'),
		'N_GAMES'           =>array('Games',25,'right','_format'),
		'N_KEY'             =>array('Key',20,'left','_format'),

		'fm8'               =>array('-8',10,'left','_format'),
		'fm7'               =>array('-7',10,'left','_format'),
		'fm6'               =>array('-6',10,'left','_format'),
		'fm5'               =>array('-5',10,'left','_format'),
		'fm4'               =>array('-4',10,'left','_format'),
		'fm3'               =>array('-3',10,'left','_format'),
		'fm2'               =>array('-2',10,'left','_format'),
		'fm1'               =>array('-1',10,'left','_format'),
		'f0'                =>array(' 0',10,'left','_format'),
		'f1'                =>array(' 1',10,'left','_format'),
		'f2'                =>array(' 2',10,'left','_format'),
		'f3'                =>array(' 3',10,'left','_format'),
		'f4'                =>array(' 4',10,'left','_format'),
		'f5'                =>array(' 5',10,'left','_format'),
		'f6'                =>array(' 6',10,'left','_format'),
		'f7'                =>array(' 7',10,'left','_format'),
		'f8'                =>array(' 8',10,'left','_format'),

		'L_OPP'             =>array('Team',100,'left','_W_formatOPP'),
		'L_OPPOSITION'      =>array('Team',100,'left','_W_formatOPP'),
		'L_REF'             =>array('Ref',100,'left','_W_formatREF'),
		'L_SURNAME'         =>array('Sname',60,'left','_W_formatMGR'),
		'L_TEAM'            =>array('Team',100,'left','_W_formatOPP'),
		'M_REF'             =>array('Ref',100,'left','_M_formatREF'),
		'M_TEAM'            =>array('Team',75,'left','_M_formatOPP'),
		'F_REF'             =>array('Ref',100,'left','_M_formatREF'),
		'F_FNAME'           =>array('Fname',60,'left','_formatNAME'),
		'F_HANDLE_TW'       =>array('Handle',25,'right','_formatTW'),

		'F_NAMES_TW'        =>array('Names',25,'right'      ,'_format'),
		'P_TEAM'            =>array('Team',25,'right'       ,'_format'),
		'N_COUNTRY'         =>array('Opposition',100,'left' ,'_formatNAME'),
		'F_NAME'            =>array('First name',100,'left' ,'_formatNAME'),
		'F_NAME2'           =>array('Surname',100,'left'    ,'_formatNAME'),
		'N_MGR'             =>array('MGR',75,'left'         ,'_formatNAME'),
		'N_NAME'            =>array('Name',100,'left'       ,'_formatNAME'),
		'N_SURNAME'         =>array('Sname',60,'left'       ,'_formatNAME'),

		'N_KEEP_NAME'       =>array('Name',100,'left'       ,'_formatKeepNAME'),
		'N_LINK_NAME'       =>array('Name',100,'left'       ,'_formatLinkNAME'),

		'ndraw'             =>array('ND',25,'right','_format'),
		'nloss'             =>array('NL',25,'right','_format'),
		'NPG90'             =>array('NPG90',25,'right','_format'),
		'NPPP90'            =>array('NPPP90',25,'right','_format'),
		'nwin'              =>array('NW',25,'right','_format'),

		'S_DATE'            =>array('Start',40, 'right','_formatDate'),
		'SSN'               =>array('Season',20,'left','_format'),
		'tdraw'             =>array('GT D',25,'right','_format'),
		'TEAM'              =>array('Team',75,'left','_formatNAME'),
		'Team'              =>array('Team',75,'left','_formatNAME'),
		'tloss'             =>array('GT L',25,'right','_format'),
		'twin'              =>array('GT W',25,'right','_format'),
		'Type'              =>array('Type',15,'left','_format'),
		'win'               =>array('W',25,'right','_format'),
		'x_comps'           =>array('Competition',25,'left','_format'),

		'F_TITLE'           =>array('Title',25,'left','_format'),
		'F_IMDB'            =>array('IMDB',25,'left','_format'),
		'F_RESULT'          =>array('Result',25,'right','_format'),
		'company_type'      =>array('Type',10,'left','_format'),
		'F_LABEL'           =>array('Label',30,'left','_format'),
		'F_VALUE'           =>array('£ value',10,'right','_format'),
		'F_INCOME'          =>array('£ income',10,'right','_format'),
		'F_EXPENDITURE'     =>array('£ expenditure',10,'right','_format'),
		'F_BALANCE'         =>array('£ balance',10,'right','_format'),

		'PDO'               =>array('PDO',15,'right','_format'),
		'TSR'               =>array('TSR',15,'right','_format'),
		'SOTR'              =>array('SOTR',15,'right','_format'),

		'Club'              =>array('Club',30,'right','_format'),
		'ExpGF'             =>array('Exp GF',30,'right','_format'),
		'ExpGA'             =>array('Exp GA',30,'right','_format'),
		'ExpGD'             =>array('Exp GD',30,'right','_format'),
		'ExpGRatio'         =>array('ExpG Ratio',30,'right','_format'),
		'Att_Eff'           =>array('Att Eff',30,'right','_format'),
		'Def_Eff'           =>array('Def Eff',30,'right','_format'),
		'DZ_SoTs_F'         =>array('DZ SoTs F',30,'right','_format'),
		'DZ_GF'             =>array('DZ GF',30,'right','_format'),
		'DZ_sc'             =>array('DZ sc%',30,'right','_format'),
		'DZ_SoTs_A'         =>array('DZ SoTs A',30,'right','_format'),
		'DZ_GA'             =>array('DZ GA',30,'right','_format'),
		'DZ_sv'             =>array('DZ sv%',30,'right','_format'),
		'SoTs_F'            =>array('SoTs F',30,'right','_format'),
		'SoTs_A'            =>array('SoTs A',30,'right','_format'),
		'SoTQual_F'         =>array('SoT Qual F',30,'right','_format'),
		'SoTQual_A'         =>array('SoT Qual A',30,'right','_format'),

		'Comm'              =>array('Committed',25,'right','_format'),
		'Suff'              =>array('Suffered',25,'right','_format'),
		'Booked'            =>array('Cards',25,'right','_format'),
		'OppoBooked'        =>array('Oppo Cards',25,'right','_format'),
		'FPCfor'            =>array('FPCfor',25,'right','_format'),
		'FPCagainst'        =>array('FPCagainst',25,'right','_format'),
		'CommPG'            =>array('Committed PG',25,'right','_format'),
		'suffPG'            =>array('suffered PG',25,'right','_format'),
		'CardsPerFor'       =>array('Cards/Fouls%',25,'right','_format'),
		'CardsPerAgg'       =>array('Oppo Cards/fouls%',25,'right','_format'),
		'FoulDiff'          =>array('Foul Diff',25,'right','_format'),

		'F_HOME'            =>array('H'   ,10,'left','_format'),
		'F_AWAY'            =>array('A'   ,10,'left','_format'),
		'HT_HGOALS'         =>array('HT H'   ,10,'left','_format'),
		'HT_AGOALS'         =>array('HT A'   ,10,'left','_format'),
		'H_FOULS'           =>array('HF'  ,10,'right','_format'),
		'A_FOULS'           =>array('AF'  ,10,'right','_format'),
		'H_CARDS'           =>array('HC'  ,10,'right','_format'),
		'A_CARDS'           =>array('AC'  ,10,'right','_format'),
		'H_SHOTS'           =>array('HS'  ,10,'right','_format'),
		'A_SHOTS'           =>array('AS'  ,10,'right','_format'),
		'H_SOT'             =>array('HSOT',10,'right','_format'),
		'A_SOT'             =>array('ASOT',10,'right','_format'),

		'F_SUBNAME'         =>array('Subbed Off',10,'left','_formatNAME'),

		'Total'             =>array('GT',25,'right','_format')
	);

	/**
	 * @param $fieldname
	 * @param $value
	 * @return string
	 */
	function _formatTableCell( $fieldname, $value ) {
		global $fieldformatting;
		$dollar = '';

		if( $fieldformat = $fieldformatting[$fieldname] ) {
			//save html size by ignoring left aligns since they are default
			if( $fieldformat[ffALIGN] == 'left' ) {
				$dollar =  "<td>" . $fieldformat[ffFUNCTION]( $value ) . "</td>";
			} else {
				$dollar =  "<td style='text-align:${fieldformat[ffALIGN]}'>" . $fieldformat[ffFUNCTION]( $value ) . "</td>";
			}
		}

		return $dollar;
	}

	/**
	 * @param $fieldname
	 * @return string
	 */
	function _formatTableHeading( $fieldname ) {
		global $fieldformatting;
		$dollar = '';
		if( $fieldformat = $fieldformatting[$fieldname] ) {
			$dollar =  "<th style='width:${fieldformat[ffWIDTH]}px'> ${fieldformat[ffHEADING]} </th>";
		}

		return $dollar;
	}

	/**
	 * @param $sql
	 * @param $size
	 * @throws \Exception
	 */
	function outputDataTable( $sql, $size ) {
		$statement = query_parse( $sql );
		$rowcount = 0;
		$tabledata = '';
		while ( $row = mysqli_fetch_array( $statement) ) {
			$rowcount++;
			$tabledata .= "<tr>";
			foreach( $row as $fieldname => $value ) {
				$tabledata .= _formatTableCell( $fieldname, $value );
			}
			$tabledata .= "</tr>";
		}

		if ($size == 'small') {

			echo "<div class='table-container table-container-small'>
			<table class='tablesorter'>
				<thead><tr>";

		} else {

			echo "<div class='table-container'>
			<table class='tablesorter'>
				<thead><tr>";
		}
		$n_cols = mysqli_num_fields( $statement );

		for ($i = 1; $i <= $n_cols; $i++) {
			$column_name  = mysqli_fetch_field ($statement);
			echo _formatTableHeading( $column_name->name );
		}

		// back to finishing the row in the header
		echo "</tr></thead><tbody>\n";
		echo $tabledata;
		echo "\n</tbody></table></div><br />";
		mysqli_free_result( $statement );
	}

	/**
	 * @param $sql
	 * @param $size
	 * @return string
	 * @throws \Exception
	 */
	function returnDataTable( $sql ,$size) {
		$statement = query_parse( $sql );
		$rowcount = 0;
		$tabledata = '';
		while ( $row = mysqli_fetch_array( $statement) ) {
			$rowcount++;
			$tabledata .= "<tr>";
			foreach( $row as $fieldname => $value ) {
				$tabledata .= _formatTableCell( $fieldname, $value );
			}
			$tabledata .= "</tr>\n";
		}

		if ( strtoupper($size) == 'SMALL') {
			$markup = "<table class='tablesorter small'><thead><tr>";
		}
		else {
			$markup = "<table class='tablesorter'><thead><tr>";
		}
		$n_cols = mysqli_num_fields( $statement );

		for ($i = 1; $i <= $n_cols; $i++) {
			$column_name  = mysqli_fetch_field ($statement);
			$markup .= _formatTableHeading( $column_name->name );

		}

		// back to finishing the row in the header
		$markup .= "</tr></thead><tbody>\n";
		$markup .= $tabledata;
		$markup .= "\n</tbody></table><br />";

		mysqli_free_result( $statement );

		return $markup;
	}

	/**
	 * @param $value
	 * @return mixed|string
	 */
	function _format( $value ) {
		// this is the standard output displays the value
		$value=htmlentities($value);
		// made safe and now replace underscores with space for pleasantness
		$value2=str_replace('_'," ",$value);
		if($value2=='0000-00-00') { $value2='';}
		if($value2=='9999-12-31') { $value2='';}
		return $value2;
	}

	/**
	 * @param $value
	 * @return mixed|string
	 */
	function _formatNotes( $value ) {
		// this is the standard output displays the value
		$value = stripslashes(htmlentities($value));
		// made safe and now replace underscores with space for pleasantness
		$value  = str_replace('_'," ",$value);
		$value  = ucfirst($value);

		return $value;
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatDate( $value ) {
		// this is the standard output displays the value
		$value=htmlentities($value);
		// made safe and now replace underscores with space for pleasantness
		$value2=str_replace('_'," ",$value);
		if($value2=='0000-00-00') { $value2='';}
		if($value2=='9999-12-31') { $value2='';}
		return "<span class='nowrap'><nobr>$value2</nobr></span>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatMoney( $value ) {
		// this is the standard output displays the value
		$value=htmlentities($value);
		// made safe and now replace underscores with space for pleasantness
		return "<span class='nowrap'><nobr>$value</nobr></span>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatEVENT( $value ) {
		// this is for displaying match event images
		$value=htmlentities($value);
		$value2=str_replace('_'," ",$value);
		return "<img class='eventimg' src='//thechels.co.uk/media/themes/ChelseaStats/img/$value2.png' alt='$value2' title='$value2' />";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatTW( $value ) {
		// this is for displaying match event images
		$value2=htmlentities($value);
		return "<a href='http://www.twitter.com/#!/$value2'>$value2</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatNAME( $value ) {
		// this is for displaying match event images
		$value = implode('-', array_map('ucfirst', explode('-', ucwords(strtolower(str_replace('_',' ',$value))))));
		if ($value == 'Qpr') { $value = 'QPR'; }
		return $value;
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatLinkNAME( $value ) {
		// this is for displaying links to player names
		$value2 = titleCase(str_replace('_'," ",$value));
		return '<a href="https://thechels.co.uk/analysis/players/data/?plyr='.$value.'">'.$value2.'</a>';
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _formatKeepNAME( $value ) {
		// this is for displaying links to player names
		$value2 = titleCase(str_replace('_'," ",$value));
		return '<a href="https://thechels.co.uk/analysis/players/data/?kpr='.$value.'">'.$value2.'</a>';
	}

	/**
	 * @param $value
	 * @return int|string
	 */
	function _formatATT( $value ) {
		// this is for displaying attendance (always INT)
		$value = (int)$value;
		$value = number_format($value);
		return $value;
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _M_formatOPP( $value ) {
		if ($value=='CHELSEA') {

			$value=ucwords(strtolower($value));
			return "<strong>$value</strong>";

		} else {

			$output = implode('-', array_map('ucfirst', explode('-', ucwords(strtolower(str_replace('_',' ',$value))))));
			return "<a href='//thechels.co.uk/analysis/results/?team=$value' title='view all the results against this opposition'>$output</a>";
		}
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _W_formatOPP( $value ) {
		if ($value=='CHELSEA LADIES') {
			$value=ucwords(strtolower($value));

			return "<strong>$value</strong>";
		} else {

			$output = implode('-', array_map('ucfirst', explode('-', ucwords(strtolower(str_replace('_',' ',$value))))));
			return "<a href='//thechels.co.uk/analysis-ladies/results-ladies/?team=$value' title='view all the results against this opposition'>$output</a>";
		}
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _M_formatREF( $value ) {
		$go         = new utility();
		$value      = htmlentities($value);
		$display    = $go->displayRef($value);
		return "<a href='//thechels.co.uk/analysis/referees/?ref=$value' title='view all results with this referee'>$display</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _W_formatREF( $value ) {
		$go         = new utility();
		$value      = htmlentities($value);
		$display    = $go->displayRef($value);
		return "<a href='//thechels.co.uk/analysis-ladies/ladies-referees/?ref=$value' title='view all results with this referee'>$display</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _M_formatxDATE( $value ) {
		$value=htmlentities($value);
		$array = preg_split("/[\s]*[,][\s]*/", $value);
		$id=$array[0];
		$date=$array[1];
		return "<a class='nowrap' href='//thechels.co.uk/analysis/results/events/?game=$id' title='view the match details of this game'><span class='nowrap'><nobr>$date</nobr></span></a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _L_formatxDATE( $value ) {
		$value=htmlentities($value);
		$array = preg_split("/[\s]*[,][\s]*/", $value);
		$id=$array[0];
		$date=$array[1];
		return "<a class='nowrap' href='//thechels.co.uk/analysis-ladies/results-ladies/match-events-ladies/?game=$id' title='view the match details of this game'><span class='nowrap'><nobr>$date</nobr></span></a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _M_formatCOMP( $value ) {
		$value=htmlentities($value);
		$value2=str_replace('_'," ",$value);
		return "<a href='//thechels.co.uk/analysis/competitions/?comp=$value' title='view all results in this competition'>$value2</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _W_formatCOMP( $value ) {
		$value=htmlentities($value);
		$value2=str_replace('_'," ",$value);
		return "<a href='//thechels.co.uk/analysis-ladies/competition-analysis/?comp=$value' title='view all results in this competition'>$value2</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _M_formatMGR( $value ) {
		$value=htmlentities($value);
		$value2=titleCase(str_replace('_'," ",$value));
		if($value2=='MOURINHO2') { $value2 ='MOURINHO'; }
		return "<a href='//thechels.co.uk/analysis/managers/profiles/?profile=$value' title='view all the results for this manager'>$value2</a>";
	}

	/**
	 * @param $value
	 * @return string
	 */
	function _W_formatMGR( $value ) {
		$value  = htmlentities($value);
		$value2 = titleCase(str_replace('_'," ",$value));
		return "<a href='//thechels.co.uk/analysis-ladies/managerial-analysis-ladies/manager-profiles-ladies/?profile=$value' title='view all the results for this manager'>$value2</a>";
	}

	/**
	 * 'LFC','FC','WFC','AFC','FK','AC','CFR','XI','QPR','CSKA','MSK','DWS','PA','SK','ST','VFB'
	 * @param $string
	 * @return string
	 */
	function titleCase($string) {
	$word_splitters = array(',',' ', '-', "O'", "L'", "D'", 'St.', 'Mc','Mac');
	$lowercase_exceptions = array('the', 'van', 'den', 'von', 'und', 'der', 'de', 'di', 'da', 'of', 'and', "l'", "d'");
	$uppercase_exceptions = array('III', 'IV', 'VI', 'VII', 'VIII', 'IX');

	$string = strtolower($string);
	foreach ($word_splitters as $delimiter)
	{
		$words = explode($delimiter, $string);
		$newwords = array();
		foreach ($words as $word)
		{
			if (in_array(strtoupper($word), $uppercase_exceptions))
				$word = strtoupper($word);
			else
				if (!in_array($word, $lowercase_exceptions))
					$word = ucfirst($word);

			$newwords[] = $word;
		}

		if (in_array(strtolower($delimiter), $lowercase_exceptions))
			$delimiter = strtolower($delimiter);

		$string = join($delimiter, $newwords);
	}
	return $string;
}