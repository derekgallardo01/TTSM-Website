<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login theme_my_login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'login' ); ?>
	<?php $template->the_errors(); ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
        <div class="column_container">
            <div class="wrapper_columns">
                <div class="col2">
                    <label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?></label>
                    <input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
                </div>
                <div class="col2">
                    <label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Password' ); ?></label>
                    <input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" />
                </div>
            </div>
            <?php do_action( 'login_form' ); ?>
            <div class="wrapper_columns">
                <div class="col2 forgetmenot">
                    <label><input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" /><?php esc_attr_e( 'Remember Me' ); ?></label>
                </div>
            </div>
        </div>
		<p class="submit paragraph">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Log In' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="login" />
		</p>
        <?php $template->the_action_links( array( 'login' => false ) ); ?>
	</form>
	
</div>
