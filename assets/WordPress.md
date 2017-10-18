#### WORDPRESS

##### Make post content assets secure (SSL)

    update dbw_posts set post_content = replace(post_content,'src=\"http://www.thechels.co.uk/','src=\"https://www.thechels.co.uk/');
    update dbw_posts set post_content = replace(post_content,'a href=\"http://www.thechels.co.uk/','a href=\"https://www.thechels.co.uk/');
    
##### fix delete spam

    DELETE FROM wp_comments WHERE comment_approved = 'spam';
 
##### fix admin on local hosted versions

    UPDATE wp_users SET user_login = 'root' WHERE user_login = 'Admin';
    UPDATE wp_users SET user_pass = MD5( 'root' ) WHERE user_login = 'root';
 
##### fix urls on all wordpress settings and content when moving domains

    UPDATE wp_options SET option_value = replace(option_value, 'http://www.oldsiteurl.com', '/') 
    WHERE option_name = 'home' OR option_name = 'siteurl';
    
    UPDATE wp_posts SET guid = REPLACE (guid, 'http://www.oldsiteurl.com', '/');
    UPDATE wp_posts SET post_content = REPLACE (post_content, 'http://www.oldsiteurl.com', '/');
    UPDATE wp_posts SET post_content = REPLACE (post_content, 'src=”http://www.oldsiteurl.com', 'src=”/');
    
##### Fix Urls for localhost-ing in WP

    UPDATE `the_schema`.`wp_options` SET `option_value`='http://dev.io/url/' WHERE `option_id`='1';
    UPDATE `the_schema`.`wp_options` SET `option_value`='http://dev.io/url/' WHERE `option_id`='39';    

#####  The Chels 

    UPDATE `thecella_dhr`.`wp_options` 	    SET `option_value`='http://test.thechels.co.uk' WHERE `option_id`='1';
    UPDATE `thecella_thechels`.`dbw_options`    SET `option_value`='http://test.thechels.co.uk' WHERE `option_id`='2';
    UPDATE `thecella_thechels`.`dbw_options`    SET `option_value`='http://test.thechels.co.uk' WHERE `option_id`='38';
    UPDATE `thecella_thechels`.`dbw_options`    SET `option_value`='/' WHERE `option_id`='39';

#### Fix/tidy PostMeta

    SELECT meta_key, COUNT(meta_key) FROM cfc_wp_postmeta GROUP BY meta_key;


    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_jd_post_meta_fixed';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_jd_tweet_this';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_jd_twitter';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_jd_wp_twitter';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_bitly';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_clig';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_target';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_url';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_wp';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_wp_jd_yourls';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = 'jd_wp_twitter';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_edit_lock';
    DELETE FROM cfc_wp_postmeta WHERE meta_key = '_edit_last';
