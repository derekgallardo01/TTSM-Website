<?php 


if(current_user_can('van_user')) {
    get_header('2');
} else {
    get_header();
}

$active_sidebar_left = is_active_sidebar('sidebar-left-user');
$active_sidebar_van = is_active_sidebar('sidebar-left-van-user');
$active_van_user = current_user_can('van_user');
$content_class = $active_sidebar_left ? 'content-width' : 'full-width';
$wclass = $active_sidebar_left ? 'wrapper-sleft': '';
$content_id= $active_van_user ? "wrapper-content-2" : 'wrapper-content';

?>

<?php
/*
Template Name: Event listing
*/$url = Theme_My_Login::get_page_link('login');$permalink_structure = get_option('permalink_structure', '');if(!is_user_logged_in()) {    $url_login = empty($permalink_structure) ? $url.'&redirect_to='.curPageURL() : $url.'?redirect_to='.curPageURL();    wp_redirect($url_login);} $active_sidebar_left = is_active_sidebar('sidebar-left-user');$content_class = $active_sidebar_left ? 'content-width' : 'full-width';$wclass = $active_sidebar_left ? 'wrapper-sleft': ''; ?>    
<div id="wrapper-content-2" class="<?php echo $wclass; ?>"> <div class="second-wrapper">        <div class="total-width">                        <?php if($active_sidebar_left && !$active_van_user): ?>
                <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                    <?php dynamic_sidebar('sidebar-left-user'); ?>
                </div>
            <?php endif; ?>
                    <?php if($active_sidebar_left && $active_van_user): ?>
                <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                    <?php dynamic_sidebar('sidebar-left-van-user'); ?>
                </div>
                 <?php endif; ?><h3 class="title-content" style="padding-top:30px;"><?php the_title(); ?></h3>            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?> content-right">			<?php			$user = wp_get_current_user();			$usrid = ( isset( $user->ID ) ? (int) $user->ID : 0 );			$content_class = 'full-width'; 

?>            

<?php
// Get all the user roles as an array.

$user_roles = $user->roles;

// Check if the role you're interested in, is present in the array.
if ( in_array( 'van_user', $user_roles, true ) || $usrid == 136343 ||  $usrid == 136344 ||  $usrid == 65263 ||  $usrid == 64380)  {
    // Do something.
?>
<div class="post-content">


    <?php echo do_shortcode('[stickylist id="11" user="' . $usrid . '"]'); ?></div> 
<?php
}else{
?>
<div class="post-content">

    <?php echo do_shortcode('[stickylist id="2" user="' . $usrid . '"]'); ?></div> 
<?php
}
?> 

</div>            <div class="clr"></div>        </div>    </div> </div>



<?php get_footer(); ?>