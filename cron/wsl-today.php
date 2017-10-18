<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$pdo = new pdodb();
	$go = new utility();
	$pdo->query("SELECT F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_DATE 
				 FROM all_results_wsl_one WHERE MONTH(F_DATE) =(SELECT MONTH(now())) 
				 AND DAY(F_DATE)=(SELECT DAY(now())) AND YEAR(F_DATE)=(SELECT YEAR(now()))");
    $rows_outer = $pdo->rows();

	foreach($rows_outer as $row_outer) {
		$H  = $go->_V($row_outer['F_HOME']);
		$A  = $go->_V($row_outer['F_AWAY']);
		$HG = $row_outer['F_HGOALS'];
		$AG = $row_outer['F_AGOALS'];
		$D  = $row_outer['F_DATE'];
		if ( $HG > $AG ) {
			$R = 'won';
		};
		if ( $HG < $AG ) {
			$R = 'lost';
		};
		if ( $HG == $AG ) {
			$R = 'drew';
		};

		$go->processMessage( "Today ($D) $H $R at home to $A  $HG-$AG in the #FAWSL" );

		/**********************************************************************************************/

		$pdo->query( "SELECT F_HGOALS, F_AGOALS, COUNT(*) as CNT FROM all_results_wsl_one 
					  WHERE F_HGOALS= :HG AND F_AGOALS= :AG GROUP BY F_HGOALS, F_AGOALS" );
		$pdo->bind( ':HG', $HG );
		$pdo->bind( ':AG', $AG );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$CNT = $row['CNT'];
			$HG  = $row['F_HGOALS'];
			$AG  = $row['F_AGOALS'];
			if ( $HG > $AG ) {
				$R = 'won';
			};
			if ( $HG < $AG ) {
				$R = 'lost';
			};
			if ( $HG == $AG ) {
				$R = 'drawn';
			};
			$i = $go->numsuffix( $CNT );

			$go->processMessage( "It is the {$i} time a team have {$R} at home {$HG}-{$AG} in #FAWSL history." );
		}

		/**********************************************************************************************/


		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1_this WHERE Team= :H
                 		GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':H', $H );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Ho  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Ho} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in the #FAWSL this season" );
		}

		/**********************************************************************************************/


		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1 WHERE Team= :H
                 		GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':H', $H );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Ho  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Ho} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in #FAWSL history." );
		}

		/**********************************************************************************************/


		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1_this WHERE Team= :A
                        GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':A', $A );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Aw   = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Aw} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in the #FAWSL this season" );
		}
		/**********************************************************************************************/


		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1 WHERE Team= :A
                        GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':A', $A );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Aw  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Aw} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in #FAWSL history." );
		}

	}

	sleep(60);

	$pdo->query("SELECT F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_DATE FROM all_results_wsl_two 
				 WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND YEAR(F_DATE)=(SELECT YEAR(now()))");

	$rows_outer = $pdo->rows();
	
	foreach($rows_outer as $row_outer) {
		$H  = $go->_V($row_outer['F_HOME']);
		$A  = $go->_V($row_outer['F_AWAY']);
		$HG = $row_outer['F_HGOALS'];
		$AG = $row_outer['F_AGOALS'];
		$D  = $row_outer['F_DATE'];
		if ( $HG > $AG ) {
			$R = 'won';
		};
		if ( $HG < $AG ) {
			$R = 'lost';
		};
		if ( $HG == $AG ) {
			$R = 'drew';
		};

		$go->processMessage( "Today ({$D}) {$H} {$R} at home to {$A}  {$HG}-{$AG} in the #FAWSL2" );


		/**********************************************************************************************/

		$pdo->query( "SELECT F_HGOALS, F_AGOALS, COUNT(*) as CNT FROM all_results_wsl_two 
					  WHERE F_HGOALS= :HG AND F_AGOALS= :AG GROUP BY F_HGOALS, F_AGOALS" );
		$pdo->bind( ':HG', $HG );
		$pdo->bind( ':AG', $AG );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$CNT = $row['CNT'];
			$HG  = $row['F_HGOALS'];
			$AG  = $row['F_AGOALS'];
			if ( $HG > $AG ) {
				$R = 'won';
			};
			if ( $HG < $AG ) {
				$R = 'lost';
			};
			if ( $HG == $AG ) {
				$R = 'drawn';
			};
			$i = $go->numsuffix( $CNT );

			$go->processMessage( "It is the {$i} time a team have {$R} at home {$HG}-{$AG} in #FAWSL2 history." );

		}

		/**********************************************************************************************/

		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL2_this WHERE Team= :H
                 		GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':H', $H );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Ho  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Ho} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in the #FAWSL2 this season" );
		}

		/**********************************************************************************************/

		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL2 WHERE Team= :H
                 		GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':H', $H );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Ho  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Ho} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in #FAWSL2 history." );
		}

		/**********************************************************************************************/

		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL2_this WHERE Team= :A
                        GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':A', $A );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Aw  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Aw} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in the #FAWSL2 this season" );

		}

		/**********************************************************************************************/

		$pdo->query( "SELECT Team as N_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
                 		round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL2 WHERE Team= :A
                        GROUP BY N_OPP ORDER BY PTS DESC, GD DESC, PPG DESC, N_OPP DESC" );
		$pdo->bind( ':A', $A );
		$rows = $pdo->rows();

		foreach ( $rows as $row ) {

			$Aw  = $go->_V($row['N_OPP']);
			$W   = $row['W'];
			$D   = $row['D'];
			$L   = $row['L'];
			$PPG = $row['PPG'];

			$go->processMessage( "{$Aw} are W{$W} D{$D} L{$L} (with {$PPG} PPG) in #FAWSL2 history." );

		}

	}