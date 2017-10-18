     
##### Query team list     
     SELECT distinct Team FROM
     (
     SELECT distinct F_HOME as Team FROM `all_results_all`
     union all
     select distinct F_AWAY as Team FROM `all_results_all`
     ) a
     order by Team desc
     limit 0,200
     
##### Fix team names

    UPDATE `all_results_all` SET `F_HOME` = upper(F_HOME);
    UPDATE `all_results_all` SET `F_AWAY` = upper(F_AWAY);
    UPDATE `all_results_all` SET `F_HOME`='MAN UTD'  WHERE `F_HOME`='Manchester United';
    UPDATE `all_results_all` SET `F_AWAY`='MAN UTD'  WHERE `F_AWAY`='Manchester United';
    UPDATE `all_results_all` SET `F_HOME`='MAN CITY' WHERE `F_HOME`='Manchester City';
    UPDATE `all_results_all` SET `F_AWAY`='MAN CITY' WHERE `F_AWAY`='Manchester City';
    UPDATE `all_results_all` SET `F_HOME`='OXFORD' WHERE `F_HOME`='OXFORD UNITED';
    UPDATE `all_results_all` SET `F_AWAY`='OXFORD' WHERE `F_AWAY`='OXFORD UNITED';
    UPDATE `all_results_all` SET `F_HOME`='SWINDON' WHERE `F_HOME`='SWINDON TOWN';
    UPDATE `all_results_all` SET `F_AWAY`='SWINDON' WHERE `F_AWAY`='SWINDON TOWN';
    UPDATE `all_results_all` SET `F_HOME`='WIGAN' WHERE `F_HOME`='WIGAN ATHLETIC';
    UPDATE `all_results_all` SET `F_AWAY`='WIGAN' WHERE `F_AWAY`='WIGAN ATHLETIC';
    UPDATE `all_results_all` SET `F_HOME`='C PALACE' WHERE `F_HOME`='Crystal Palace';
    UPDATE `all_results_all` SET `F_AWAY`='C PALACE' WHERE `F_AWAY`='Crystal Palace';
    UPDATE `all_results_all` SET `F_HOME`='N FOREST' WHERE `F_HOME`='Nottingham Forest';
    UPDATE `all_results_all` SET `F_AWAY`='N FOREST' WHERE `F_AWAY`='Nottingham Forest';
    UPDATE `all_results_all` SET `F_HOME`='LUTON' WHERE `F_HOME`='LUTON TOWN';
    UPDATE `all_results_all` SET `F_AWAY`='LUTON' WHERE `F_AWAY`='LUTON TOWN';
    UPDATE `all_results_all` SET `F_HOME`='QPR' WHERE `F_HOME`='Queens Park Rangers';
    UPDATE `all_results_all` SET `F_AWAY`='QPR' WHERE `F_AWAY`='Queens Park Rangers';
    UPDATE `all_results_all` SET `F_HOME`='BRADFORD' WHERE `F_HOME`='BRADFORD CITY';
    UPDATE `all_results_all` SET `F_AWAY`='BRADFORD' WHERE `F_AWAY`='BRADFORD CITY';
    UPDATE `all_results_all` SET `F_HOME`='WEST HAM' WHERE `F_HOME`='WEST HAM UNITED';
    UPDATE `all_results_all` SET `F_AWAY`='WEST HAM' WHERE `F_AWAY`='WEST HAM UNITED';
    UPDATE `all_results_all` SET `F_HOME`='BRIGHTON' WHERE `F_HOME`='Brighton & Hove Albion';
    UPDATE `all_results_all` SET `F_AWAY`='BRIGHTON' WHERE `F_AWAY`='Brighton & Hove Albion';
    UPDATE `all_results_all` SET `F_HOME`='BOLTON' WHERE `F_HOME`='Bolton Wanderers';
    UPDATE `all_results_all` SET `F_AWAY`='BOLTON' WHERE `F_AWAY`='Bolton Wanderers';
    UPDATE `all_results_all` SET `F_HOME`='WOLVES' WHERE `F_HOME`='Wolverhampton Wanderers';
    UPDATE `all_results_all` SET `F_AWAY`='WOLVES' WHERE `F_AWAY`='Wolverhampton Wanderers';
    UPDATE `all_results_all` SET `F_HOME`='Birmingham' WHERE `F_HOME`='Birmingham City';
    UPDATE `all_results_all` SET `F_AWAY`='Birmingham' WHERE `F_AWAY`='Birmingham City';
    UPDATE `all_results_all` SET `F_HOME`='Blackburn' WHERE `F_HOME`='Blackburn Rovers';
    UPDATE `all_results_all` SET `F_AWAY`='Blackburn' WHERE `F_AWAY`='Blackburn Rovers';
    UPDATE `all_results_all` SET `F_HOME`='Bradford PA' WHERE `F_HOME`='Bradford Park Avenue';
    UPDATE `all_results_all` SET `F_AWAY`='Bradford PA' WHERE `F_AWAY`='Bradford Park Avenue';
    UPDATE `all_results_all` SET `F_HOME`='Oldham' WHERE `F_HOME`='Oldham Athletic';
    UPDATE `all_results_all` SET `F_AWAY`='Oldham' WHERE `F_AWAY`='Oldham Athletic';
    UPDATE `all_results_all` SET `F_HOME`='Norwich' WHERE `F_HOME`='Norwich City';
    UPDATE `all_results_all` SET `F_AWAY`='Norwich' WHERE `F_AWAY`='Norwich City';
    UPDATE `all_results_all` SET `F_HOME`='Sheff Wed' WHERE `F_HOME`='Sheffield Wednesday';
    UPDATE `all_results_all` SET `F_AWAY`='Sheff Wed' WHERE `F_AWAY`='Sheffield Wednesday';
    UPDATE `all_results_all` SET `F_HOME`='Sheff Utd' WHERE `F_HOME`='Sheffield United';
    UPDATE `all_results_all` SET `F_AWAY`='Sheff Utd' WHERE `F_AWAY`='Sheffield United';
    UPDATE `all_results_all` SET `F_HOME`='Preston' WHERE `F_HOME`='Preston North End';
    UPDATE `all_results_all` SET `F_AWAY`='Preston' WHERE `F_AWAY`='Preston North End';
    UPDATE `all_results_all` SET `F_HOME`='Spurs' WHERE `F_HOME`='Tottenham Hotspur';
    UPDATE `all_results_all` SET `F_AWAY`='Spurs' WHERE `F_AWAY`='Tottenham Hotspur';
    UPDATE `all_results_all` SET `F_HOME`='Stoke' WHERE `F_HOME`='Stoke City';
    UPDATE `all_results_all` SET `F_AWAY`='Stoke' WHERE `F_AWAY`='Stoke City';
    UPDATE `all_results_all` SET `F_HOME`='Swansea' WHERE `F_HOME`='Swansea City';
    UPDATE `all_results_all` SET `F_AWAY`='Swansea' WHERE `F_AWAY`='Swansea City';
    UPDATE `all_results_all` SET `F_HOME`='West Brom' WHERE `F_HOME`='West Bromwich Albion';
    UPDATE `all_results_all` SET `F_AWAY`='West Brom' WHERE `F_AWAY`='West Bromwich Albion';
    UPDATE `all_results_all` SET `F_HOME`='Newcastle' WHERE `F_HOME`='Newcastle United';
    UPDATE `all_results_all` SET `F_AWAY`='Newcastle' WHERE `F_AWAY`='Newcastle United';
    UPDATE `all_results_all` SET `F_HOME`='Northampton' WHERE `F_HOME`='Northampton Town';
    UPDATE `all_results_all` SET `F_AWAY`='Northampton' WHERE `F_AWAY`='Northampton Town';
    UPDATE `all_results_all` SET `F_HOME`='Leicester' WHERE `F_HOME`='Leicester City';
    UPDATE `all_results_all` SET `F_AWAY`='Leicester' WHERE `F_AWAY`='Leicester City';
    UPDATE `all_results_all` SET `F_HOME`='Leeds' WHERE `F_HOME`='Leeds United';
    UPDATE `all_results_all` SET `F_AWAY`='Leeds' WHERE `F_AWAY`='Leeds United';
    UPDATE `all_results_all` SET `F_HOME`='Ipswich' WHERE `F_HOME`='Ipswich Town';
    UPDATE `all_results_all` SET `F_AWAY`='Ipswich' WHERE `F_AWAY`='Ipswich Town';
    UPDATE `all_results_all` SET `F_HOME`='Huddersfield' WHERE `F_HOME`='Huddersfield Town';
    UPDATE `all_results_all` SET `F_AWAY`='Huddersfield' WHERE `F_AWAY`='Huddersfield Town';
    UPDATE `all_results_all` SET `F_HOME`='Grimsby' WHERE `F_HOME`='Grimsby Town';
    UPDATE `all_results_all` SET `F_AWAY`='Grimsby' WHERE `F_AWAY`='Grimsby Town';
    UPDATE `all_results_all` SET `F_HOME`='Ipswich' WHERE `F_HOME`='Ipswich Town';
    UPDATE `all_results_all` SET `F_AWAY`='Ipswich' WHERE `F_AWAY`='Ipswich Town';
    UPDATE `all_results_all` SET `F_HOME`='Glossop' WHERE `F_HOME`='Glossop North End';
    UPDATE `all_results_all` SET `F_AWAY`='Glossop' WHERE `F_AWAY`='Glossop North End';
    UPDATE `all_results_all` SET `F_HOME`='Derby' WHERE `F_HOME`='Derby County';
    UPDATE `all_results_all` SET `F_AWAY`='Derby' WHERE `F_AWAY`='Derby County';
    UPDATE `all_results_all` SET `F_HOME`='Charlton' WHERE `F_HOME`='Charlton Athletic';
    UPDATE `all_results_all` SET `F_AWAY`='Charlton' WHERE `F_AWAY`='Charlton Athletic';
    UPDATE `all_results_all` SET `F_HOME`='Coventry' WHERE `F_HOME`='Coventry City';
    UPDATE `all_results_all` SET `F_AWAY`='Coventry' WHERE `F_AWAY`='Coventry City';
    UPDATE `all_results_all` SET `F_HOME`='Carlisle' WHERE `F_HOME`='Carlisle United';
    UPDATE `all_results_all` SET `F_AWAY`='Carlisle' WHERE `F_AWAY`='Carlisle United';
    UPDATE `all_results_all` SET `F_HOME`='Accrington' WHERE `F_HOME`='Accrington F.C.';
    UPDATE `all_results_all` SET `F_AWAY`='Accrington' WHERE `F_AWAY`='Accrington F.C.';
    UPDATE `all_results_all` SET `F_HOME`='Cardiff' WHERE `F_HOME`='Cardiff City';
    UPDATE `all_results_all` SET `F_AWAY`='Cardiff' WHERE `F_AWAY`='Cardiff City';
