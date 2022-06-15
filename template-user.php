<?php
/*
Template Name: Template User Front-end
*/

$url = site_url('/login');
$permalink_structure = get_option('permalink_structure', '');
if(!is_user_logged_in()) {
    $url_login = empty($permalink_structure) ? $url.'&redirect_to='.curPageURL() : $url.'?redirect_to='.curPageURL();
    wp_redirect($url_login);

}

if(current_user_can('van_user') || current_user_can('client')) {
    get_header('2');
} else {
    get_header();
}

$active_sidebar_left = is_active_sidebar('sidebar-left-user');
$active_sidebar_van = is_active_sidebar('sidebar-left-van-user');
$active_van_user = current_user_can('van_user');
$active_client = current_user_can('client');
$content_class = $active_sidebar_left ? 'content-width' : 'full-width';
$wclass = $active_sidebar_left ? 'wrapper-sleft': '';
$content_id= ( $active_van_user ) ? "wrapper-content-2" : (( $active_client ) ? "wrapper-content-2" : "wrapper-content" );

 ?>

    <div id="<?php echo $content_id;?>" class="<?php echo $wclass;?>">
        <div class="total-width">
            <?php if($active_sidebar_left && !$active_van_user && !$active_client): ?>
                <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                    <?php dynamic_sidebar('sidebar-left-user'); ?>
                </div>
            <?php endif; ?>
                    <?php if($active_sidebar_left && $active_van_user || $active_client): ?>
                <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                    <?php dynamic_sidebar('sidebar-left-van-user'); ?>
                </div>
                 <?php endif; ?>
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?> content-right">
                <?php while(have_posts()): the_post(); ?>
                    <div class="post">
                        <h3 class="title-content"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-content"><?php the_content(); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>
   
<?php get_footer(); ?>