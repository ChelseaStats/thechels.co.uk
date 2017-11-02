<?php
	/*
	Plugin Name: CFC Format Media Titles
	Description: Automatically formats the title for new media uploads. No need to manually edit the title anymore every time you upload an image!
	Version: 2.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	info : http://www.wpgothemes.com/plugins/format-media-titles/
	*/

	// @todo
	//
	// 1. Be able to add a prefix or suffix to the title or filename etc.
	// 2. See the Plugin support posts for more ideas.
	// 3. Enable batch renaming of multiple images, all at once?
	// 4. Maybe add options to specify a different replacement character, such as a hyphen?

	/* Set-up Hooks. */
	register_activation_hook( __FILE__, 'cfc_wp_add_defaults' );
	register_uninstall_hook( __FILE__, 'cfc_wp_delete_plugin_options' );
	add_action('admin_menu', 'cfc_wp_add_options_page' );
	add_action('admin_init', 'cfc_wp_init' );
	add_action('add_attachment', 'cfc_wp_update_media_title' );

	/**
	 * Delete options table entries ONLY when plugin deactivated AND deleted.
	 *
	 */
	function cfc_wp_delete_plugin_options() {

		delete_option( 'cfc_wp_options' );
	}

	/**
	 *  Define default option settings.
	 *
	 */
	function cfc_wp_add_defaults() {

		$tmp = get_option( 'cfc_wp_options' );
		if ( ( $tmp['chk_default_options_db'] == '1' ) || ( ! is_array( $tmp ) ) ) {
			delete_option( 'cfc_wp_options' );
			$arr = array( 	"chk_hyphen"             => "1",
				    "chk_underscore"         => "1",
					"rdo_cap_options"        => "cap_all"
			);
			update_option( 'cfc_wp_options', $arr );
		}
	}

	/**
	 * Init plugin options to white list our options.
	 *
	 */
	function cfc_wp_init(){

        register_setting( 'cfc_wp_plugin_options', 'cfc_wp_options' );
	}

	/**
	 * Add menu page.
	 *
	 */
	function cfc_wp_add_options_page() {

		add_options_page( 'Format Media Titles Options Page', 'Format Media Titles', 'manage_options', __FILE__, 'cfc_wp_render_form' );
	}

	/**
	 * Render Plugin options form.
	 *
	 */
	function cfc_wp_render_form() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Format Media Titles', 'format-media-titles' ); ?></h2>

			<p><?php _e( 'Select the characters you want to be removed from the media title (and replaced with spaces) for newly uploaded media. Then, choose how you want the title to be capitalized.', 'format-media-titles' ); ?></p>

			<form method="post" action="options.php">
				<?php settings_fields( 'cfc_wp_plugin_options' ); ?>
				<?php $options = get_option( 'cfc_wp_options' ); ?>

				<table class="form-table">

					<tr valign="top">
						<th scope="row"><?php _e( 'Remove Characters', 'format-media-titles' ); ?></th>
						<td>
							<label><input name="cfc_wp_options[chk_hyphen]" type="checkbox" value="1" <?php if ( isset( $options['chk_hyphen'] ) ) {
									checked( '1', $options['chk_hyphen'] );
								} ?> /> <?php _e( 'Hyphen', 'format-media-titles' ); ?> (-)</label><br />

							<label><input name="cfc_wp_options[chk_underscore]" type="checkbox" value="1" <?php if ( isset( $options['chk_underscore'] ) ) {
									checked( '1', $options['chk_underscore'] );
								} ?> /> <?php _e( 'Underscore', 'format-media-titles' ); ?> (_)</label><br />

							<label><input name="cfc_wp_options[chk_period]" type="checkbox" value="1" <?php if ( isset( $options['chk_period'] ) ) {
									checked( '1', $options['chk_period'] );
								} ?> /> <?php _e( 'Period', 'format-media-titles' ); ?> (.)</label><br />

							<label><input name="cfc_wp_options[chk_tilde]" type="checkbox" value="1" <?php if ( isset( $options['chk_tilde'] ) ) {
									checked( '1', $options['chk_tilde'] );
								} ?> /> <?php _e( 'Tilde', 'format-media-titles' ); ?> (~)</label><br />

							<label><input name="cfc_wp_options[chk_plus]" type="checkbox" value="1" <?php if ( isset( $options['chk_plus'] ) ) {
									checked( '1', $options['chk_plus'] );
								} ?> /> <?php _e( 'Plus', 'format-media-titles' ); ?> (+)</label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e( 'Capitalization Method', 'format-media-titles' ); ?></th>
						<td>
							<label><input name="cfc_wp_options[rdo_cap_options]" type="radio" value="cap_all" <?php checked( 'cap_all', $options['rdo_cap_options'] ); ?> /> <?php _e( 'Capitalize All Words', 'format-media-titles' ); ?></label><br />

							<label><input name="cfc_wp_options[rdo_cap_options]" type="radio" value="cap_first" <?php checked( 'cap_first', $options['rdo_cap_options'] ); ?> /> <?php _e( 'Capitalize First Word Only', 'format-media-titles' ); ?></label><br />

							<label><input name="cfc_wp_options[rdo_cap_options]" type="radio" value="all_lower" <?php checked( 'all_lower', $options['rdo_cap_options'] ); ?> /> <?php _e( 'All Words Lower Case', 'format-media-titles' ); ?></label><br />

							<label><input name="cfc_wp_options[rdo_cap_options]" type="radio" value="all_upper" <?php checked( 'all_upper', $options['rdo_cap_options'] ); ?> /> <?php _e( 'All Words Upper Case', 'format-media-titles' ); ?></label><br />

							<label><input name="cfc_wp_options[rdo_cap_options]" type="radio" value="dont_alter" <?php checked( 'dont_alter', $options['rdo_cap_options'] ); ?> /> <?php _e( 'Don\'t Alter (title text isn\'t modified in any way)', 'format-media-titles' ); ?></label>

							<p class="description"><?php _e( 'Capitalization works on individual words separated by spaces. If the title contains NO spaces after formatting then only the first letter will be capitalized.', 'format-media-titles' ); ?></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e( 'Misc. Options', 'format-media-titles' ); ?></th>
						<td>
							<label><input name="cfc_wp_options[chk_alt]" type="checkbox" value="1" <?php if ( isset( $options['chk_alt'] ) ) {
									checked( '1', $options['chk_alt'] );
								} ?> /> <?php _e( 'Add Title to \'Alternative Text\' Field?', 'format-media-titles' ); ?></label><br>

							<label><input name="cfc_wp_options[chk_caption]" type="checkbox" value="1" <?php if ( isset( $options['chk_caption'] ) ) {
									checked( '1', $options['chk_caption'] );
								} ?> /> <?php _e( 'Add Title to \'Caption\' Field?', 'format-media-titles' ); ?></label><br>

							<label><input name="cfc_wp_options[chk_description]" type="checkbox" value="1" <?php if ( isset( $options['chk_description'] ) ) {
									checked( '1', $options['chk_description'] );
								} ?> /> <?php _e( 'Add Title to \'Description\' Field?', 'format-media-titles' ); ?></label><br>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<div></div>
						</td>
					</tr>
					<tr valign="top" style="border-top:#dddddd 1px solid;">
						<th scope="row"><?php _e( 'Database Options', 'format-media-titles' ); ?></th>
						<td>
							<label><input name="cfc_wp_options[chk_default_options_db]" type="checkbox" value="1" <?php if ( isset( $options['chk_default_options_db'] ) ) {
									checked( '1', $options['chk_default_options_db'] );
								} ?> /> <?php _e( 'Restore defaults upon plugin deactivation/reactivation', 'format-media-titles' ); ?></label>
							<p class="description"><?php _e( 'Only check this if you want to reset plugin settings upon Plugin reactivation', 'format-media-titles' ); ?></p>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'format-media-titles' ); ?>" />
				</p>
			</form>

		</div>
		<?php
	}

	/**
	 * @param $id
	 */
	function cfc_wp_update_media_title( $id ) {

		$options     = get_option( 'cfc_wp_options' );
		$cap_options = $options['rdo_cap_options'];

		$uploaded_post_id = get_post( $id );
		$title            = $uploaded_post_id->post_title;

		/* Update post. */
		$char_array = array();
		if ( isset( $options['chk_hyphen'] ) && $options['chk_hyphen'] ) {
			$char_array[] = '-';
		}
		if ( isset( $options['chk_underscore'] ) && $options['chk_underscore'] ) {
			$char_array[] = '_';
		}
		if ( isset( $options['chk_period'] ) && $options['chk_period'] ) {
			$char_array[] = '.';
		}
		if ( isset( $options['chk_tilde'] ) && $options['chk_tilde'] ) {
			$char_array[] = '~';
		}
		if ( isset( $options['chk_plus'] ) && $options['chk_plus'] ) {
			$char_array[] = '+';
		}

		/* Replace chars with spaces, if any selected. */
		if ( ! empty( $char_array ) ) {
			$title = str_replace( $char_array, ' ', $title );
		}

		/* Trim multiple spaces between words. */
		$title = preg_replace( "/\s+/", " ", $title );

		/* Capitalize Title. */
		switch ( $cap_options ) {
			case 'cap_all':
				$title = ucwords( $title );
				break;
			case 'cap_first':
				$title = ucfirst( strtolower( $title ) );
				break;
			case 'all_lower':
				$title = strtolower( $title );
				break;
			case 'all_upper':
				$title = strtoupper( $title );
				break;
			case 'dont_alter':
				/* Leave title as it is. */
				break;
		}

		// add formatted title to the alt meta field
		if ( isset( $options['chk_alt'] ) && $options['chk_alt'] ) {
			update_post_meta( $id, '_wp_attachment_image_alt', $title );
		}

		// update the post
		$uploaded_post               = array();
		$uploaded_post['ID']         = $id;
		$uploaded_post['post_title'] = $title;

		// add formatted title to the description meta field
		if ( isset( $options['chk_description'] ) && $options['chk_description'] ) {
			$uploaded_post['post_content'] = $title;
		}

		// add formatted title to the caption meta field
		if ( isset( $options['chk_caption'] ) && $options['chk_caption'] ) {
			$uploaded_post['post_excerpt'] = $title;
		}

		wp_update_post( $uploaded_post );
	}