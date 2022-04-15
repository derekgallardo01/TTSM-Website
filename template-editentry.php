<?php
if(!is_user_logged_in()) {
    $url_login = empty($permalink_structure) ? $url.'&redirect_to='.curPageURL() : $url.'?redirect_to='.curPageURL();
    wp_redirect($url_login);
}
get_header(); 
$active_sidebar_left = is_active_sidebar('sidebar-left-user');
$content_class = $active_sidebar_left ? 'content-width' : 'full-width';
$wclass = $active_sidebar_left ? 'wrapper-sleft': '';
?>
    <div id="wrapper-content" class="<?php echo $wclass; ?>">
        <div class="total-width">
            <?php if($active_sidebar_left): ?>
                <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                    <?php dynamic_sidebar('sidebar-left-user'); ?>
                </div>
            <?php endif; ?>
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?> content-right">
                
                <div class="post">
                    <h3 class="title-content"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="post-content">
                        <?php 
                        $edit_post_id = isset( $_GET['gform_post_id'] ) ? (int) $_GET['gform_post_id'] : 0;
                         
                        if ( !empty( $edit_post_id ) ) {
                            gform_update_post::setup_form( $edit_post_id );
                            gravity_form( $gform_id );
                        }
                        ?>
                    </div>
                </div>
                
            </div>
            <div class="clr"></div>
        </div>
    </div>
<?php get_footer(); ?>
<!-- /* Template Name: Template User Front-end */ -->