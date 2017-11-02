<?php
	/*
	Plugin Name: CFC Admin Dashboard Widgets
	Description: Shows admin dashboard widgets
	License: GPL
	Version: 8.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.uk
	Author URI: https://thechels.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	if(!class_exists('widgeter')) {

		class widgeter {

			/**
			 * widgeter constructor.
			 */
			function __construct() {

				add_action( 'wp_dashboard_setup', array($this, 'cfc_wp_add_dashboard_widgets' ) );
				add_action( 'add_meta_boxes', array($this, 'cfc_wp_register_meta_boxes' ) );
				add_action( 'save_post', array($this, 'cfc_wp_save_meta_box' ) );

			}

			/**
			 * Adds the Dashboard Widgets.
			 */
			function cfc_wp_add_dashboard_widgets() {
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_a', 'Secure SSL/TLS Email Settings'   , array($this, 'cfc_wp_email_dash_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_b', 'PHP Settings'                    , array($this, 'cfc_wp_php_version_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_g', 'SSH Settings'                    , array($this, 'cfc_wp_ssh_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_c', 'Drafts'                          , array($this, 'cfc_wp_draft_post_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_d', 'Pending Activity'                , array($this, 'cfc_wp_pending_post_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_e', 'Bookmarks'                       , array($this, 'cfc_wp_bookmark_widget_function') );
				wp_add_dashboard_widget( 'cfc_wp_dashboard_widget_f', 'Stats Bookmarks'                 , array($this, 'cfc_wp_stats_bookmark_widget_function') );
			}

			/**
			 * Adds Stats based bookmarks to Dashboard Widget.
			 */
			function cfc_wp_stats_bookmark_widget_function() {

				echo '<div id="cfc_wp_stats_admin_bookmarks" class="activity-block seven">
						<ul style ="list-style-type: disc; margin-left:10px;">
							<li><a href="http://www.chelseafc.com//">tocfcws</a></li>
							<li><a href="http://www.espnfc.co.uk/club/chelsea/363/fixtures">Espn</a></li>
							<li><a href="http://www.fourfourtwo.com/statszone">StatsZone</a></li>
							<li><a href="http://www.premierleague.com/en-gb/referees/appointments.html?">Ref App</a></li>
							<li><a href="http://kassiesa.home.xs4all.nl/bert/uefa/data/method4/trank2016.html">Coeffs</a></li>
							<li><a href="http://www.soccerstats.com/">SoccerStats</a></li>
							<li><a href="http://www.statto.com/">Statto</a></li>
							<li><a href="http://footstats.co.uk/index.cfm?task=games">FootStats</a></li>
							<li><a href="http://www.uefa.com/">Uefa</a></li>
							<li><a href="http://www.fawsl.com/">FaWSL</a></li>
							<li><a href="https://beta.companieshouse.gov.uk/company/02536231/">02536231 CFC PLC</a></li>
							<li><a href="https://beta.companieshouse.gov.uk/company/01965149">01965149 CFC LTD</a></li>
							<li><a href="https://beta.companieshouse.gov.uk/company/07377729">07377729 CFC Ladies</a></li>
						</ul>
						<ul>
							<li><a href="http://chelseasupporterstrust.com.cp-uk-1.webhostbox.net/wp-admin/index.php">Chelsea Supporters Trust</a></li>
							<li><a href="http://5.100.152.24:2082/cpsess5489375224/frontend/x3/index.html">Chelsea Supporters Trust Cpanel</a></li>
							<li><a href="https://akismet.com/account/">Askimet</a></li>
							<li><a href="https://beta.companieshouse.gov.uk/company/07269584">07269584 ChelseaStats Ltd</a></li>
				        </ul>
				    </div>';
			}

			/**
			 * Adds Bookmark links to Dashboard Widget
			 */
			function cfc_wp_bookmark_widget_function() {

				echo '<div id="cfc_wp_admin_bookmarks" class="activity-block six">
						<ul style ="list-style-type: disc; margin-left:10px;">
							<li><a href="https://thechels.co.uk/">Home page</a></li>
							<li><a href="https://thechels.co.uk/a/private/">Front Admin</a></li>
							<li><a href="https://cpanel.thechels.co.uk">Cpanel Admin</a></li>
							<li><a href="https://m.thechels.uk">Mobile App</a></li>
							<li><a href="https://api.thechels.uk">Api</a></li>
							<li><a href="https://www.thechels.uk">Github</a></li>
				        </ul>
				    </div>';
			}

			/**
			 * Adds PHP version to Dashboard Widget
			 */
			function cfc_wp_php_version_widget_function() {

				echo '<div id="cfc_wp_php_version" class="activity-block five">Current PHP version: ' . phpversion();
				echo '</div>';

			}

			/**
			 * Adds SSH info to Dashboard Widget.
			 */
			function cfc_wp_ssh_widget_function() {

				echo '<div id="cfc_wp_ssh" class="activity-block five">
					<pre>ssh thechels@ssh.thechels.co.uk -p2223</pre>
					<pre>git pull --hard reset</pre></div>';

			}

			/**
			 * Adds draft posts to Dashboard Widget.
			 */
			function cfc_wp_draft_post_widget_function() {
				global $wpdb;
				$result = $wpdb->get_results( "select * from " . $wpdb->prefix . "posts where post_status in ('Draft') AND post_type !='' ORDER BY post_date ASC " );
				echo '<div class="activity-block one">';
				foreach ( $result as $sc_post ) {
					echo '<ul>
					        <li>
								<a href="' . get_edit_post_link( $sc_post->ID ) . '">' . $sc_post->post_title . '</a>
							</li>
					  </ul>';
				}
				echo "</div>";
			}

			/**
			 * Adds pending post to Dashboard Widget.
			 */
			function cfc_wp_pending_post_widget_function() {
				global $wpdb;
				$result = $wpdb->get_results( "select * from " . $wpdb->prefix . "posts where post_status in ('Pending') AND post_type !='' ORDER BY post_date ASC " );
				echo '<div class="activity-block two">';
				foreach ( $result as $sc_post ) {
					echo '<ul>
					        <li>
								<a href="' . get_edit_post_link( $sc_post->ID ) . '">' . $sc_post->post_title . '</a>
							</li>
					  </ul>';
				}
				echo "</div>";
			}

			/**
			 * Adds email details info to Dashboard Widget.
			 */
			function cfc_wp_email_dash_widget_function() {

				echo '<div class="activity-block four">
	                <ul>
	                    <li>Username:	[enter email]@TheChels.uk</li>
	                    <li>Password:	Use the email account password.</li>
	                    <li><b>Incoming Server:</b> mail.TheChels.uk</li>
	                    <li>IMAP Port: 993 / POP3 Port: 995</li>
	                    <li><b>Outgoing Server:</b> mail.TheChels.uk</li>
	                    <li>SMTP Port: 465</li>
	                    <li>Authentication is required for IMAP, POP3, and SMTP.</li>
	                </ul>
	                <p><b>Note:</b></p>
	                <p>The choice between IMAP and POP3 is important. IMAP synchronises back to the server so if you delete an email from your device,
	                it will be deleted from the server. POP3 will only delete your local copy and keeping files on the server intact</p>
	                </div>';
			}

			/**
			 * Register meta box(es).
			 */
			function cfc_wp_register_meta_boxes() {
				add_meta_box( 'cfc_wp_pending_meta', __( 'Add to Pending Queue', 'textdomain' ), array($this, 'cfc_wp_display_callback'), 'post' );
				add_meta_box( 'cfc_wp_pending_meta', __( 'Add to Pending Queue', 'textdomain' ), array($this, 'cfc_wp_display_callback'), 'feeders' );

			}

			/**
			 * Meta box display callback.
			 */
			function cfc_wp_display_callback() {

				wp_nonce_field( 'cfc_wp_pending_meta_box_nonce', 'meta_box_nonce' );
				// Display code/markup goes here. Don't forget to include nonces!
				?>
				<form method = "post">
					<div id = "minor-publishing-actions">
						<div id = "save-action">
							<input name = "original_publish" type = "hidden" id = "original_publish" value = 'pending'"
							/>
							<?php submit_button( __( 'Save as Pending' ), 'secondary button-large', 'cfc_wp_save_meta_box', FALSE ); ?>
						</div>
					</div>
				</form>
				<?php
			}

			/**
			 * Save meta box content.
			 * @param int $post_id Post ID
			 */
			function cfc_wp_save_meta_box( $post_id ) {

				// make post id is set otherwise we'd be in trouble
				if ( ! isset( $post_id ) ) {
					return;
				}

				$cfc_post = array ( 'ID' => $post_id, 'post_status' => 'pending' );

				// Bail if we're doing an auto save
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return;
				}

				// if our nonce isn't there, or we can't verify it, bail
				if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'cfc_wp_pending_meta_box_nonce') ) {
					return;
				}

				// if our current user can't edit this post, bail
				if ( ! current_user_can( 'edit_post' ) ) {
					return;
				}

				// check it's a post and the update the post setting it to pending
				if ( isset( $_POST['cfc_wp_save_meta_box'] ) ) {
					remove_action( 'save_post', array($this,'cfc_wp_save_meta_box') ); //if you don't unhook the function you'll have an infinite loop
					wp_update_post( $cfc_post );
					add_action( 'save_post', array($this,'cfc_wp_save_meta_box') ); //rehook the function
				}

			}

		}
		new widgeter();
	}



