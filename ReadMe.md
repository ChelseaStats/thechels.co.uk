###### https://thechels.co.uk

> Over Land & Sea, and build control.

This looks incredibly lightweight but uploads and generic plugins are ignored so they can be updated through the UI so what is left is the must-use plugins and the theme. Cron job scripts are also included, to allow for better control.

Check the wp-config and .htaccess for more information.

<p>
    <a href="http://achecker.ca/checker/index.php?uri=referer&gid=WCAG2-AA">
      <img src="http://achecker.ca/images/icon_W2_aa.jpg" alt="WCAG 2.0 (Level AA)" height="32" width="102" />
    </a>
 </p>

##### Setting up:

    1 Generic WordPress (latest) install 
    2 PHP On Server 5.5+
    3 Use this repo
    4 Upload back-up of uploads 
    5 Activate plugins
    6 Flush those permalinks to fix urls
    7 That should be it.
    8 Check pages work, queries work, rss works, graphics etc.

##### Rules

    1 Master is always deployable (and is auto built by default)
    2 Changes should be branched (fix-xxx, feat-xxx, dev-xxx, bug-xxx etc)

##### Versioning

    We should use semantic versioning that breaks down to MAJOR.MINOR.PATCH. 
    In general,  MAJOR is a whole version number — it is used for massive changes and/or milestones. 
    It is allowed to break backwards compatibility. 
    MINOR is used for new features. It should not break any backwards compatibility. 
    PATCH is for small changes and fixes, and should not break any backwards compatibility. 
    We should be in a pre-release (0.x.x) until launch.
    
##### Structure

      root
           /media
                /themes/
                /uploads/
                /core/ (must-use)
                /cron/
                /u/ (redirect manager for bitly)
                /plugins/
                /tests/

##### Keys

###### Askimet
  
     22d210e0b03a

###### Sponsor & affiliate URLS

    Amazon      -   http://u.thechels.uk/cfc-amazon
    Moo         -   https://www.moo.com/share/276h2k
    Webstash    -   https://webstash.uk/
    Dropbox     -   https://db.tt/ocJGgY5
    App         -   https://m.thechels.uk/
    RSS feeds   -   https://thechels.co.uk/rss-feeds/
    Open        -   https://thechels.co.uk/sponsorship/

##### snippets

      <div class="navigation well visible-phone">
      <div class="prev-link pull-left">&larr; <?php previous_posts_link('%link', 'Older articles'); ?></div>
      <div class="next-link pull-right"><?php next_posts_link('%link', 'Newer articles'); ?> &rarr; </div>
      </div>
      
##### Twitter Card  (width: 598px; height: 399px;)

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@ChelseaStats">
    <meta name="twitter:domain" content="https://www.thechels.co.uk">
    <meta name="twitter:creator" content="@ChelseaStats">
    <meta name="twitter:title" content="Chelsea Stats">
    <meta name="twitter:image:src" content="https://www.thechels.co.uk/media/uploads/twitter-card.png">
    <meta name="twitter:description" content="Chelsea Statistics, Facts and Trivia by @ChelseaStats">

##### configuration

command `/usr/local/bin/php -f /home/thechels/public_html/media/cron/[filename].php`

    Minute	Hour    Day Month Weekday Command
    0       19      *    *    5    cfc-ff.php    
    0       */4     *    *    *    cfc-tweet.php    
    5       3       *    *    *    cfc-otd.php    
    15      9       *    *    3    wsl-history.php    
    22      22      *    *    *    wsl-today.php    
    0       */4     *    *    *    wsl-tweet.php    
    45      9       *    *    5    wsl-tables.php    
    11      11      *    *    5    wsl-summary.php    
    34      19      19   5    *    app-ucl.php    
    0,5,10  10      *    *    *    app-countdown.php    
    40      10,14   *    *    *    app-anagram.php    
    40      12,16   *    *    *    app-mssngVwls.php    
    0       9       *    *    *    app-horo.php    
    30      7       *    *    *    app-weather.php    
    30      16      *    *    *    app-ref.php    
    25      8       *    *    *    app-footv.php    
    */5      *      *    *    *    app-errors.php    
    15      7       *    *    4    app-bins.php    
    30      16      *    *    3    app-bins.php    
    */3     *       *    *    *    app-response.php    
    5       22      *    *    4    app-coeff.php    
    */5     *       *    *    *    app-tocfcws.php    
    */5     *       *    *    *    app-slack-mail.php
    30      7       *    *    *    hesa-weather.php    
    30      16      *    *    5    app-super6.php    
    */5     *       *    *    *    app-football-data.php
    55      7,15,21 *    *    *    app-wsl-data.php 
    45      2       *    *    3    app-backup-files.php 
    15      2       *    *    */2  app-backup-db.php 