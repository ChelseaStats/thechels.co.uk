#### assets

    RewriteEngine on
    RewriteCond %{HTTP_HOST} ^www\.
    RewriteCond %{HTTPS}s ^on(s)|off
    RewriteCond http%1://%{HTTP_HOST} ^(https?://)(www\.)?(.+)$
    RewriteRule ^ %1%3%{REQUEST_URI} [R=301,L]
     
    # Also change the url in config
    # Also create friendly https://thechels.co.uk/mobile -> https://m.thechels.uk
    # Also create friendly https://thechels.co.uk/coral -> affiliate
    # Also create friendly https://thechels.co.uk/amazon -> affiliate
    # Also create friendly https://thechels.co.uk/twitter -> https://twitter.com/ChelseaStats
     
    # Instagram http://u.thechels.uk/InstaCFC
      
    RewriteRule ^subdirectory/(.*)$ /anotherdirectory/$1 [R=301,NC,L]
      
    www.site.tld/folder/* -> redirect www.site.tld/folder/folder/*
    but visibility stays  www.site.tld/folder/*

#### SQL

>Some handy SQL scripts and snippets:

##### windows terminal

    copy /b *.sql all_files.sql
    
##### Mac OS X

    cat *.sql >merged.sql

##### See the code behind the View

    SHOW CREATE VIEW xxxx
    
##### See the code behind the code

    select hex(F_FIELD) from T_TABLE where F_FIELD=F_VALUE 

#### fix league teams

    UPDATE `all_results_wdl_south` 
    SET
    `F_HOME`=REPLACE(`F_HOME`, ' ', '_'), 
    `F_AWAY`=REPLACE(`F_AWAY`, ' ', '_');

##### some minute man queries

    SELECT `F_APPS`,`F_SUBS`,`F_UNUSED`,`X_MINUTES`, count(*) total FROM `cfc_fixtures_players` 
    WHERE X_MINUTES not in ('0','1','90','120')
    GROUP BY `F_APPS`,`F_SUBS`,`F_UNUSED`,`X_MINUTES`


    SELECT `F_APPS`,`F_SUBS`,`F_UNUSED`,`X_MINUTES`, count(*) Total FROM `cfc_fixtures_players` 
    WHERE X_MINUTES in ('0','1','90','120')
    GROUP BY `F_APPS`,`F_SUBS`,`F_UNUSED`,`X_MINUTES`
    
##### Re-order table in PHPmyadmin

    ALTER TABLE `named` ORDER BY F_ID DESC;
    ALTER TABLE `cfc_fixtures` 			ORDER BY F_ID DESC;
    ALTER TABLE `cfc_cleansheets` 		ORDER BY F_ID  ASC;
    ALTER TABLE `cfc_fixture_events` 	ORDER BY F_ID DESC;
    ALTER TABLE `cfc_fixtures_players` 	ORDER BY F_ID DESC;
    ALTER TABLE `meta_squadno`          ORDER BY F_END ASC, F_START DESC, F_SQUADNO ASC 
    
##### Correct Age Calculation

    SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(F_DOB, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') 
    < DATE_FORMAT(F_DOB, '00-%m-%d')) AS age
    
##### Empty game players by date.

    SELECT F_DATE, COUNT(*) FROM `cfc_fixtures_players` WHERE `F_NO` IS NULL AND `F_NAME` IS NULL
    GROUP BY F_DATE
    ORDER BY F_DATE DESC;
    
##### Update players DB

        UPDATE `cfc_fixtures_players`b SET `F_NAME`= (
            SELECT a.F_NAME FROM meta_squadno a 
            WHERE ( b.F_NO=a.F_SQUADNO and a.F_START < b.F_DATE ) 
            AND ( b.F_DATE < a.F_END or a.F_END is null ) 
            ) WHERE F_ID IS NOT NULL;
    
##### Delete from players where null

    DELETE FROM `cfc_fixtures_players` WHERE `F_NO` IS NULL AND `F_NAME` IS NULL;
    
##### select Nos without names (update squadno db)

    SELECT F_NO, count(*) FROM `cfc_fixtures_players` WHERE ( F_NAME IS NULL OR F_NAME ='' )
    GROUP BY F_NO ORDER BY count(*) DESC, F_NO ASC;
    ##
    SELECT * FROM `cfc_fixtures_players` WHERE ( F_NAME IS NULL OR F_NAME ='' ) AND F_NO='7'
    ##
    SELECT `F_ID`, `F_DATE`, `F_NO`, `F_NAME`, `F_APPS`, `F_SUBS`, `F_GAMEID` 
    FROM `cfc_fixtures_players` WHERE F_NAME='' ORDER BY F_DATE DESC, F_NO DESC

##### The Selector (league table generic)

    SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, 
    SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
    FROM $table_name
    GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC;

##### Select Events against 

    SELECT `F_NAME`, F_EVENT, COUNT(*) FROM `cfc_fixture_events` 
    WHERE F_TEAM='0'
    AND F_EVENT IN ('GOAL','PKGOAL')
    GROUP BY F_NAME
    HAVING COUNT(*) > 1 
    ORDER BY COUNT(*)  DESC

###### update duplicate sub ons to sub off

    UPDATE cfc_fixture_events a, cfc_fixture_events b SET a.F_EVENT='SUBOFF' 
    WHERE a.F_ID > b.F_ID 
    AND a.F_NAME=b.F_NAME 
    AND a.F_EVENT=b.F_EVENT
    AND a.F_MINUTE=b.F_MINUTE
    AND a.F_DATE=b.F_DATE
    AND a.F_EVENT='SUBON'

##### New meta squadno table

    SELECT a.F_NAME 
    FROM meta_squadno a, cfc_fixtures_players b 
    WHERE ( b.F_NO=a.F_SQUADNO and a.F_START < b.F_DATE )
    AND ( b.F_DATE < a.F_END or a.F_END is null )
    AND b.F_DATE = '2014-04-05' and b.F_NO='19'
    
##### Fix WSL squad no player names

    UPDATE wsl_squadno SET `F_Y2011` = REPLACE(`F_Y2011`, ' ', '_') WHERE `F_Y2011` IS NOT NULL;
    UPDATE wsl_squadno SET `F_Y2012` = REPLACE(`F_Y2012`, ' ', '_') WHERE `F_Y2012` IS NOT NULL;
    UPDATE wsl_squadno SET `F_Y2013` = REPLACE(`F_Y2013`, ' ', '_') WHERE `F_Y2013` IS NOT NULL;
    UPDATE wsl_squadno SET `F_Y2014` = REPLACE(`F_Y2014`, ' ', '_') WHERE `F_Y2014` IS NOT NULL;
        
##### fix null players

    DELETE FROM `cfc_fixtures_players` 
    WHERE F_NO is null 
    AND F_NAME is null 
    AND F_DATE > '2003-06-01' 
    AND F_DATE < '2004-05-16';

##### Query duplicate names

     SELECT * FROM cfc_fixtures_players WHERE F_DATE 
     IN ( SELECT F_DATE FROM ( SELECT F_DATE, count(*) 
     FROM `cfc_fixtures_players` GROUP BY F_DATE HAVING count(*) > 18 ) a ) 
     ORDER BY F_DATE ASC, F_NAME ASC, F_ID ASC
    
##### Fix player names in Squad number

    UPDATE `cfc_squadno` 
    SET 
    `F_Y1994`=REPLACE(F_Y1994, ' ', '_'),
    `F_Y1995`=REPLACE(F_Y1995, ' ', '_'),
    `F_Y1996`=REPLACE(F_Y1996, ' ', '_'),
    `F_Y1997`=REPLACE(F_Y1997, ' ', '_'),
    `F_Y1998`=REPLACE(F_Y1998, ' ', '_'),
    `F_Y1999`=REPLACE(F_Y1999, ' ', '_'),
    `F_Y2000`=REPLACE(F_Y2000, ' ', '_'),
    `F_Y2001`=REPLACE(F_Y2001, ' ', '_'),
    `F_Y2002`=REPLACE(F_Y2002, ' ', '_'),
    `F_Y2003`=REPLACE(F_Y2003, ' ', '_'),
    `F_Y2004`=REPLACE(F_Y2004, ' ', '_'),
    `F_Y2005`=REPLACE(F_Y2005, ' ', '_'),
    `F_Y2006`=REPLACE(F_Y2006, ' ', '_'),
    `F_Y2007`=REPLACE(F_Y2007, ' ', '_'),
    `F_Y2008`=REPLACE(F_Y2008, ' ', '_'),
    `F_Y2009`=REPLACE(F_Y2009, ' ', '_'),
    `F_Y2010`=REPLACE(F_Y2010, ' ', '_'),
    `F_Y2011`=REPLACE(F_Y2011, ' ', '_'),
    `F_Y2012`=REPLACE(F_Y2012, ' ', '_'),
    `F_Y2013`=REPLACE(F_Y2013, ' ', '_')
    WHERE 1=1

##### Make a copy of a table

     drop table cfc_fixtures_players_bk;
     create table `cfc_fixtures_players_bk` like `cfc_fixtures_players`;
     insert into `cfc_fixtures_players_bk`select * from `cfc_fixtures_players`;

##### Show names and apps

    SELECT `F_NAME`, SUM(F_APPS) AS STARTS, SUM(F_SUBS) AS SUBS 
    FROM `cfc_fixtures_players` GROUP BY F_NAME ORDER BY F_NAME ASC

##### Using `CASE` for a count of total wins, draws losses

    SELECT 
    SUM(CASE WHEN F_RESULT='W' THEN 1 ELSE 0 END) as Wins,
    SUM(CASE WHEN F_RESULT='D' THEN 1 ELSE 0 END) as Draws,
    SUM(CASE WHEN F_RESULT='L' THEN 1 ELSE 0 END) as Losses 
    FROM fixtures;
    
##### Results by player

    SELECT a.F_DATE, a.F_APPS, a.F_SUBS, b.F_FOR, b.F_AGAINST, b.F_RESULT 
    FROM `cfc_fixtures_players` a, cfc_fixtures b 
    WHERE a.`F_NAME`= 'RODRIGO_DA_COSTA_ALEX' 
    AND a.F_GAMEID=b.F_ID
    AND b.F_COMPETITION='PREM'
    
##### Winning/Losing Streaks (with home / away clause)

        SELECT F_RESULT,
          MIN(F_DATE) as StartDate, 
          MAX(F_DATE) as EndDate, 
          COUNT(*) as Games
        FROM (SELECT F_DATE, F_RESULT, 
          (SELECT COUNT(*) 
           FROM wp_fixtures G 
           WHERE G.F_RESULT <> GR.F_RESULT
           AND G.F_DATE <= GR.F_DATE
           ORDER BY GR.F_DATE DESC) as RunGroup 
        FROM wp_fixtures GR
        WHERE F_DATE <>  '1900-01-00'
        AND  F_RESULT="W"
        --AND  F_RESULT="L"
        AND F_LOCATION="H"
        --AND F_LOCATION="A"
        ORDER BY F_DATE DESC) A
        GROUP BY F_RESULT, RunGroup
        HAVING COUNT(*) >5
        ORDER BY Min(F_DATE);
        
##### Update Script for team names

    UPDATE fixtures SET F_OPPOSITION="SWANSEA CITY" WHERE F_OPPOSITION="SWANSEA"

##### Update Script for notes and dates

    UPDATE fixtures SET F_NOTE="" WHERE F_OPPOSITION="BRIGHTON HOVE ALBION" AND F_DATE="1900-01-00"
    UPDATE fixtures SET F_DATE="" WHERE F_OPPOSITION="BRIGHTON HOVE ALBION" AND F_DATE="1900-01-00"
    
