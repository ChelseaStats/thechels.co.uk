<?php
	/*
	Plugin Name: CFC Live Data Amendments
	Description: Class for managing live data amendments
	Version: 2.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class lda {

		/**
		 * Reason    : Diego Costa was awarded goal in League final, assist for Fabregas.
		 * source    : http://www.chelseafc.com/news/latest-news/2015/03/ask-statman.html
		 * @return string
		 */
		function gameid5042() {

			$sql = "UPDATE cfc_fixtures_players  SET F_GOALS 	= 1 WHERE F_NAME='DIEGO_COSTA' 	 AND F_GAMEID = '5042'";
			$sql .= "UPDATE cfc_fixtures_players  SET F_ASSISTS = 1 WHERE F_NAME='CESC_FABREGAS' AND F_GAMEID = '5042'";

			return $sql;

		}
	}

/*
###### Live Data Amendments

##### Re-order table in PHPmyadmin

	ALTER TABLE `named`                 ORDER BY F_ID DESC;
	ALTER TABLE `cfc_fixtures` 			ORDER BY F_ID DESC;
	ALTER TABLE `cfc_cleansheets` 		ORDER BY F_ID  ASC;
	ALTER TABLE `cfc_fixture_events` 	ORDER BY F_ID DESC;
	ALTER TABLE `cfc_fixtures_players` 	ORDER BY F_ID DESC;
	ALTER TABLE `meta_squadno`          ORDER BY F_END ASC, F_START DESC, F_SQUADNO ASC


##### Incorrect dates for rearranged games

	update cfc_fixture_events SET F_DATE = '2010-12-04' WHERE F_DATE = '2010-12-05';
	update cfc_fixture_events SET F_DATE = '2009-09-26' WHERE F_DATE = '2009-09-25';
	update cfc_fixture_events SET F_DATE = '2008-03-19' WHERE F_DATE = '2008-03-18';
	update cfc_fixture_events SET F_DATE = '2006-08-20' WHERE F_DATE = '2006-08-19';

##### Goals per game

	update cfc_explayers set F_GPG=F_GOALS/(F_APPS+F_SUBS);

##### Fix player data

	UPDATE cfc_fixtures_players SET F_ACCURACY = ROUND(F_SHOTSON/F_SHOTS,3) WHERE F_SHOTSON>0;
	UPDATE cfc_fixtures_players SET F_GOAL_CONVERSION = ROUND(F_GOALS/F_SHOTS,3) WHERE F_GOALS>0;
	UPDATE wsl_fixtures_players SET F_ACCURACY = ROUND(F_SHOTSON/F_SHOTS,3) WHERE F_SHOTSON>0;
	UPDATE wsl_fixtures_players SET F_GOAL_CONVERSION = ROUND(F_GOALS/F_SHOTS,3) WHERE F_GOALS>0;

##### Fix GameIDs

	UPDATE cfc_fixtures_players a   SET F_GAMEID = (select F_ID from cfc_fixtures b WHERE a.f_DATE=b.F_DATE);
	UPDATE cfc_fixture_events a     SET F_GAMEID = (select F_ID from cfc_fixtures b WHERE a.f_DATE=b.F_DATE);

##### set some defaults

	update cfc_fixtures_players_wip  a inner join cfc_fixtures b on a.F_GAMEID = b.F_ID
	set a.x_minutes = b.f_minutes where a.f_apps= '1';
	update `cfc_fixtures_players` a set a.x_minutes = '-1' where a.f_subs	= '1';
	update `cfc_fixtures_players` a set a.x_minutes = '0'  where a.f_unused = '1';

##### START to SUBOFF

	update `cfc_fixtures_players` a inner join `cfc_fixture_events` b on a.f_name=b.f_name
	set a.x_minutes = coalesce( b.f_minute, 1) where a.f_gameid=b.f_gameid and b.f_event = 'SUBOFF'
	and a.f_apps='1';

##### START to RC

	update `cfc_fixtures_players` a inner join `cfc_fixture_events` b on a.f_name=b.f_name
	set a.x_minutes = coalesce( b.f_minute, 1) where a.f_gameid=b.f_gameid and b.f_event = 'RC'
	and a.f_apps='1';

##### SUBON to END

	update `cfc_fixtures_players` a inner join `cfc_fixture_events` b on a.f_name=b.f_name
	set a.x_minutes = coalesce( (90 - b.f_minute), 1) where a.f_gameid=b.f_gameid and b.f_event = 'SUBON'
	and a.f_subs='1';

##### SUBON to END when Subs not set correctly

	update `cfc_fixtures_players` a inner join `cfc_fixture_events` b on a.f_name=b.f_name
	set a.x_minutes = coalesce( (90 - b.f_minute), 1), a.f_subs='1', a.f_apps='0', a.f_unused='0'
	where a.f_gameid=b.f_gameid and b.f_event = 'SUBON' and a.f_date > '2002-08-01'

##### SUBON to RC or SUBOFF

	update `cfc_fixtures_players` a set x_minutes = (select f_minute_diff FROM (
	select b.f_name, b.f_gameid, SUM(c.f_minute-b.f_minute) as f_minute_diff
	from `cfc_fixture_events` c inner join `cfc_fixture_events` b on c.f_name=b.f_name
	where c.f_name=b.f_name and c.f_gameid = b.f_gameid and c.f_event  in ('RC','SUBON') and b.f_event = 'SUBON'
	and c.f_minute >= b.f_minute group by f_name, f_gameid ) z
	where f_name= a.f_name and f_gameid = a.f_gameid and a.f_date > '2002-08-01' and a.f_subs='1');

##### Fix player names

	UPDATE cfc_fixtures_players SET F_NAME = REPLACE(F_NAME, ' ', '_') WHERE F_NAME IS NOT NULL;
	UPDATE cfc_fixtures_players SET F_NAME = REPLACE(F_NAME, '__', '') WHERE F_NAME IS NOT NULL;
	UPDATE `cfc_fixtures_players` SET `F_NAME`='BOUDEWIJN_ZENDEN' WHERE `F_NAME`='BOLO_ZENDEN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='CARLTON_COLE' WHERE `F_NAME`='COLE,C';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOE_COLE' WHERE `F_NAME`='COLE,J';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ASHLEY_COLE' WHERE `F_NAME`='COLE,A';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GLEN_JOHNSON' WHERE `F_NAME`='GLENN JOHNSON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='RUUD_GULLIT' WHERE `F_NAME`='GULLIT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOEL_KITAMIRIKE' WHERE `F_NAME`='KITAMIRIKE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MIKAEL_FORSSELL' WHERE `F_NAME`='MIKEL_FORSSELL';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='PATRICK_VAN_AANHOLT' WHERE `F_NAME`='PATRICK_VAN_AANHHOLT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MARIO_STANIC' WHERE `F_NAME`='STANIC';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='CRAIG_BURLEY' WHERE `F_NAME`='BURLEY';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DAN_PETRESCU' WHERE `F_NAME`='PETRESCU';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='TONY_CASCARINO' WHERE `F_NAME`='CASCARINO';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='FRANK_SINCLAIR' WHERE `F_NAME`='SINCLAIR';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MARK_STEIN' WHERE `F_NAME`='STEIN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='PAUL_FURLONG' WHERE `F_NAME`='FURLONG';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOHN_ SPENCER' WHERE `F_NAME`='SPENCER';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ANDY_TOWNSEND' WHERE `F_NAME`='TOWNSEND';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GAVIN_PEACOCK' WHERE `F_NAME`='PEACOCK';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MICK_HARFORD' WHERE `F_NAME`='HARFORD';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GRAHAME_STUART' WHERE `F_NAME`='STUART';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='EDDIE_NEWTON' WHERE `F_NAME`='NEWTON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='PAUL_ELLIOT' WHERE `F_NAME`='ELLIOT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GARETH_HALL' WHERE `F_NAME`='HALL';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='KEVIN_WILSON' WHERE `F_NAME`='WILSON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MICHAEL_DUBERRY' WHERE `F_NAME`='DUBERRY';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='EMMANUEL_PETIT' WHERE `F_NAME`='PETIT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DARREN_BARNARD' WHERE `F_NAME`='BARNARD';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='STEVE_CLARKE' WHERE `F_NAME`='CLARKE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ANDY_MYERS' WHERE `F_NAME`='MYERS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JAKOB_KJELDBJERG' WHERE `F_NAME`='KJELDBJERG';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ENRIQUE_DE_LUCAS' WHERE `F_NAME`='DE_LUCAS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NEIL_SHIPPERLEY' WHERE `F_NAME`='SHIPPERLEY';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='RATI_ALEKSIDZE' WHERE `F_NAME`='ALEKSIDZE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DAVE_BEASANT' WHERE `F_NAME`='BEASANT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='WAYNE_BRIDGE' WHERE `F_NAME`='BRIDGE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NEIL_CLEMENT' WHERE `F_NAME`='CLEMENT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NICK_COLGAN' WHERE `F_NAME`='COLGAN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='HERNAN_CRESPO' WHERE `F_NAME`='CRESPO';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NICK_CRITTENDEN' WHERE `F_NAME`='CRITTENDEN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='RHYS_EVANS' WHERE `F_NAME`='EVANS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='CRAIG_FORREST' WHERE `F_NAME`='FORREST';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GLEN_JOHNSON' WHERE `F_NAME`='GLENN_JOHNSON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DANNY_GRANVILE' WHERE `F_NAME`='GRANVILLE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MIKAEL_FORSSELL' WHERE `F_NAME`='MIKEL_FORSSELL';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='SCOTT_MINTO' WHERE `F_NAME`='MINTO';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ADRIAN_MUTU' WHERE `F_NAME`='MUTU';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='PATRICK_VAN_AANHOLT' WHERE `F_NAME`='PATRICK_VAN_AANHHOLT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='SCOTT_PARKER' WHERE `F_NAME`='PARKER';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='IAN_PEARCE' WHERE `F_NAME`='PEARCE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='CHRISTIAN_PANUCCI' WHERE `F_NAME`='PANUCCI';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='LUCA_PERCASSI' WHERE `F_NAME`='PERCASSI';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='TERRY_PHELAN' WHERE `F_NAME`='PHELAN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='LENNY_PIDGELEY' WHERE `F_NAME`='PIDGELEY';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MARIO_STANIC' WHERE `F_NAME`='SLANIC';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NEIL_SULLIVAN' WHERE `F_NAME`='SULLIVAN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DANNY_SLATTER' WHERE `F_NAME`='SLATTER';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='EMERSON_THOME' WHERE `F_NAME`='THOME';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JUAN_SEBASTIAN_VERON' WHERE `F_NAME`='VERON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GIANLUCA_VIALLI' WHERE `F_NAME`='VIALLI';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='NIGEL_SPACKMAN' WHERE `F_NAME`='SPACKMAN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='SAMUELE_DALLA_BONA' WHERE `F_NAME`='DALLA_BONA';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='KEN_MONKOU' WHERE `F_NAME`='MONKOU';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DAMIAN_MATTHEW' WHERE `F_NAME`='MATTHEW';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MARK_NICHOLLS' WHERE `F_NAME`='NICHOLLS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GRAHAM_RIX' WHERE `F_NAME`='RIX';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='YVES_MAKABU_MA-KALAMBAY' WHERE `F_NAME`='MAKALAMBAY';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOE_SHEERIN' WHERE `F_NAME`='SHEERIN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='DAVID_ROCASTLE' WHERE `F_NAME`='ROCASTLE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='FILIPE_OLIVEIRA' WHERE `F_NAME`='OLIVEIRA';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ALEXEI_NICHOLAS' WHERE `F_NAME`='NICHOLAS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='CLIVE_ALLEN' WHERE `F_NAME`='ALLEN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='GABREILE_AMBROSETTI' WHERE `F_NAME`='AMBROSETTI';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='MARCO_AMBROSIO' WHERE `F_NAME`='AMBROSIO';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOE_ALLON' WHERE `F_NAME`='ALLON';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ANTHONY_BARNESS' WHERE `F_NAME`='BARNESS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='TOM_BOYD' WHERE `F_NAME`='BOYD';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='BERNARD_LAMBOURDE' WHERE `F_NAME`='LAMBOURDE';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='BRIAN_LAUDRUP' WHERE `F_NAME`='LAUDRUP';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='LEON_KNIGHT' WHERE `F_NAME`='KNIGHT';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='JOE_KEENAN' WHERE `F_NAME`='KEENAN';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='FRODE_GRODAS' WHERE `F_NAME`='GRODAS';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='ANDY_DOW' WHERE `F_NAME`='DOW';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='PIERLUIGI_CASIRAGHI' WHERE `F_NAME`='CASIRAGHI';
	UPDATE `cfc_fixtures_players` SET `F_NAME`='LAURENT_CHARVET' WHERE `F_NAME`='CHARVET';

#### fix names

	update wsl_fixtures SET F_OPP=REPLACE(F_OPPOSITION,' ','_');

*/
