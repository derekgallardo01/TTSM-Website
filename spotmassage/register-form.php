<?php

ob_start();
$template->the_instance();
$instance = ob_get_clean();
$form_id = 'registerform'.$instance;
$btn_submit_id = 'wp-submit'.$instance;
?>
<div class="login theme_my_login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php //$template->the_action_template_message( 'register' ); ?>
	<?php $template->the_errors(); ?>
	<form class="p-columns" name="registerform" id="<?php echo $form_id; ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
        <div class="column_container">
            <div class="wrapper_columns">
                <div class="col2">
                    <label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username', 'spotmassage' ); ?></label>
                    <input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
                </div>
                <div class="col2">
                    <label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail', 'spotmassage' ); ?></label>
                    <input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
                </div>
            </div>
            <div class="wrapper_columns">
                <div class="colFull">
                    <p id="reg_passmail<?php $template->the_instance(); ?>" class="p-full"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.', 'spotmassage' ) ); ?></p>
                </div>
            </div>
            <div class="wrapper_columns">
                <div class="colFull">
                    <?php do_action( 'register_form' ); ?>
                </div>
            </div>
        </div>
        <p class="submit paragraph">
			<input type="submit" name="wp-submit" id="<?php echo $btn_submit_id; ?>" value="<?php _e( 'Register', 'spotmassage' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
        <?php $template->the_action_links( array( 'register' => false ) ); ?>
		
	</form>
	
</div>
<script type="text/javascript">
    var url_search_address;
    jQuery(document).on('ready', function(){
        var id_form_submit = '<?php echo $form_id; ?>';
        var id_btn_submit = '<?php echo $btn_submit_id; ?>';
        jQuery('#'+id_form_submit).on('submit', function(event){
            url_search_address = 'http://maps.googleapis.com/maps/api/geocode/json?address={ADDRESS}&sensor=true';
            
            var user_address = '';
            var cimy_uef_STATE = sm_get_value_fieldCimy('state', id_form_submit);
            if( cimy_uef_STATE ) {
                user_address = cimy_uef_STATE;
            }
            var cimy_uef_CITY = sm_get_value_fieldCimy('city', id_form_submit);
            if( cimy_uef_CITY ) {
                user_address = cimy_uef_CITY+','+user_address;
            }
            var cimy_uef_ADDRESS = sm_get_value_fieldCimy('address', id_form_submit);
            if( cimy_uef_ADDRESS ) {
                user_address = cimy_uef_ADDRESS+','+user_address;
            }
            
            if(user_address.length > 0) {
                user_address = sm_clean_for_search(user_address);
                
                jQuery.ajax({
                    type: 'get',
                    url: url_search_address.replace('{ADDRESS}', user_address),
                    success: function(result) {
                        
                        if(result.status == 'OK') {
                            document.getElementById(id_form_submit).submit();
                        } else {
                            jQuery('#msg-register-form').html('<?php _e('Unable to find a geological directions for current address, please provide your detail address again.','spotmassage'); ?>').addClass('error').fadeIn('fast');
                        }
                    }
                });
            }
            return false;
        });
        
    });
    function sm_clean_for_search(data_str) {
        return data_str.replace(/ /g,"+");
    }
    function sm_get_value_fieldCimy(field, form_id) {
        var n_field = field.toUpperCase();
        var object_html = jQuery('#'+form_id).find('[name="cimy_uef_'+n_field+'"]');
        if(object_html.length > 0) {
            return object_html.val();
        }
        return '';
    }
</script>