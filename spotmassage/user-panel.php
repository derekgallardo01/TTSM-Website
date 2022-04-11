<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login theme_my_login" id="theme-my-login<?php $template->the_instance(); ?>">
    <div class="column_container">
        <div class="wrapper_columns only">
        <?php if ( $template->options['show_gravatar'] ) : ?>
            <div class="colLeft"><div class="tml-user-avatar"><?php $template->the_user_avatar(100); ?></div></div>
        <?php endif; ?>
            <div class="colLeft"><?php $template->the_user_links(); ?></div>
        </div>
    </div>
	<?php do_action( 'tml_user_panel' ); ?>
</div>
