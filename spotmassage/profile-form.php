<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);	
	?>
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post" enctype="multipart/form-data">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>

		<?php if ( has_action( 'personal_options' ) ) : ?>

		<h3><?php _e( 'Personal Options', 'spotmassage' ); ?></h3>

		<table class="form-table">
		<?php do_action( 'personal_options', $profileuser ); ?>
		</table>

		<?php endif; ?>

		<?php do_action( 'profile_personal_options', $profileuser ); ?>

		<h3><?php _e( 'Personal Data', 'spotmassage' ); ?></h3>
		<span>You will be logged out and must sign in using your new username if you choose a new username
		<table class="form-table" style="width:100%">
			<tr>
				<?php if( user_can( $current_user->ID, 'client_employee' ) && !user_can( $current_user->ID, 'activate_plugins' ) ) {?>
					<th><label for="user_login"><?php _e( 'Email', 'spotmassage' ); ?></label></th>
					<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Your email cannot be changed.', 'spotmassage' ); ?></span></td>
				<?php } else { ?>
					<th><label for="user_login"><?php _e( 'Username', 'spotmassage' ); ?></label></th>
					<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" class="regular-text" /> <span class="description"><?php _e( 'Your username cannot be changed.', 'spotmassage' ); ?></span></td>
				<?php } ?>
			</tr>

			<tr>
				<th><label for="first_name"><?php _e( 'First Name', 'spotmassage' ); ?></label></th>
				<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
			</tr>

			<tr>
				<th><label for="last_name"><?php _e( 'Last Name', 'spotmassage' ); ?></label></th>
				<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
			</tr>
			<?php if($user_role==='therapist') : ?>
				<tr>
					<th><label for="last_name"><?php _e( 'Main Number', 'spotmassage' ); ?></label></th>
					<td><input type="text" name="main_number" id="main_number" value="<?php echo esc_attr( $profileuser->get('alternate_number') );  ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th><label for="last_name"><?php _e( 'Mobile Phone Number', 'spotmassage' ); ?></label></th>
					<td><input type="text" name="mobile_phone_number" id="mobile_phone_number" value="<?php echo esc_attr( $profileuser->get('mobile_phone_number') );  ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th><label for="last_name"><?php _e( 'Mailing Address', 'spotmassage' ); ?></label></th>
					<td class="gfield">
						<input type="text" name="mailing_address" id="mailing_address" value="<?php echo esc_attr( $profileuser->get('mailing_address') );  ?>" class="regular-text" />
						<?php
						/*$full_address = $profileuser->get('mailing_address');
						$add_fields = explode(",", $full_address);
						$address = $add_fields[0];
						$city = $add_fields[1];
						$others = explode(" ", $add_fields[2]);
						$state = $others[0];
						$zip = $others[1];*/
						?>
						<!--<div class="ginput_complex ginput_container" id="input_3_15">
							<span class="ginput_left" id="input_3_15_1_container">
								<input type="text" name="address_street" id="address_street" value="<?php echo $address; ?>" 
									placeholder="Street Address">
								<label for="address_street" id="input_3_15_1_label" style="display: none;">Street Address</label>
							</span>
							<span class="ginput_right" id="input_3_15_3_container">
								<input type="text" name="address_city" id="address_city" value="<?php echo $city; ?>" 
									placeholder="City">
								<label for="address_city" id="input_3_15.3_label" style="display: none;">City</label>
							</span>
							<span class="ginput_left" id="input_3_15_4_container">
								<select name="address_state" id="address_state">
									<option value="" selected="selected">State</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District of Columbia">District of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option><option value="Armed Forces Americas">Armed Forces Americas</option><option value="Armed Forces Europe">Armed Forces Europe</option><option value="Armed Forces Pacific">Armed Forces Pacific</option>
								</select>
								<label for="address_state" id="input_3_15_4_label" style="display: none;">State</label>
							</span>
							<span class="ginput_right" id="input_3_15_5_container">
								<input type="text" name="address_zip" id="address_zip" value="<?php echo $zip; ?>" 
									placeholder="ZIP Code">
								<label for="address_zip" id="input_3_15_5_label" style="display: none;">ZIP Code</label>
							</span>
							<input type="hidden" class="gform_hidden" name="address_country" id="address_country" value="United States">
							<div class="gf_clear gf_clear_complex"></div>
						</div> -->
					</td>
				</tr>
			<?php endif; ?>
		</table>

		<h3><?php _e( 'Company Info', 'spotmassage' ); ?></h3>

		<table class="form-table">
			<tr>
				<th><label for="user_address"><?php _e( 'Complete Address', 'spotmassage' ); ?></label></th>
				<td><input type="text" name="user_address" id="user_address" value="<?php echo esc_attr( get_user_meta($current_user->ID,'user_address',true) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="user_department"><?php _e( 'Department', 'spotmassage' ); ?></label></th>
				<td><input type="text" name="user_department" id="user_department" value="<?php echo esc_attr( get_user_meta($current_user->ID,'user_department',true) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="user_position"><?php _e( 'Position', 'spotmassage' ); ?></label></th>
				<td><input type="text" name="user_position" id="user_position" value="<?php echo esc_attr( get_user_meta($current_user->ID,'user_position',true) ); ?>" class="regular-text" /></td>
			</tr>
			
			<tr class="tml-user-url-wrap">
				<th><label for="url"><?php _e( 'Renewal Massage License', 'theme-my-login' ); ?></label></th>
				<td><input type="file" name="licence" id="licence" class="regular-text code" /></td>
			</tr>
		
		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		</table>

		<h3><?php _e( 'Account Management', 'theme-my-login' ); ?></h3>
		<table class="tml-form-table">
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
					</button>
					<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
						<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
					</button>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
			<td>
			<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
			<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
				</label>
			</td>
		</tr>
		<?php endif; ?>

		</table>

		<?php //do_action( 'show_user_profile', $profileuser ); ?>

		<p class="submit">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname )!=''?esc_attr( $profileuser->nickname ):'test'; ?>" />
			<input type="hidden" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( __('Update Profile', 'spotmassage') ); ?>" name="submit" />
		</p>
	</form>
</div>
