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

<table class="sticky-list">

    <tr>
        <th class="sort header-company" data-sort="sort-0">Company</th>
        <th class="sort header-onsite-contact-name" data-sort="sort-1">Onsite Contact Name</th>
        <th class="sort header-phone-number" data-sort="sort-2">Phone Number</th>
        <th class="sort header-email" data-sort="sort-3">Email</th>
        <th class="sort header-event-date" data-sort="sort-4">Event Date</th>
        <th class="sort header-start-time" data-sort="sort-5">Start Time</th>
        <th class="sort header-end-time" data-sort="sort-6">End Time</th>
        <th class="sticky-action"></th>
    </tr>
<?php
$date = null;

if( !empty($_REQUEST['search']) && is_array($_REQUEST['search']) && !empty($_REQUEST['search']['year']) ) {

    $date = $_REQUEST['search']['year'].'{month}';

    $date = str_replace('{month}',(!empty($_REQUEST['search']['month']) ? '-'.$_REQUEST['search']['month'] : ''),$date);

}

$locations = Admin_Jobs::get_available_locations_user(get_current_user_id(),$date);

?>
    <tr>
        <td class="sort-0  sticky-nowrap stickylist-text">govind</td>
        <td class="sort-1  stickylist-text">govind</td>
        <td class="sort-2  sticky-nowrap stickylist-phone">(928) 491-2494</td>
        <td class="sort-3  sticky-nowrap stickylist-email">testet@sfsdf.com</td>
        <td class="sort-4  sticky-nowrap stickylist-date">04/08/2022</td>
        <td class="sort-5  sticky-nowrap stickylist-text">8:46 pm</td>
        <td class="sort-6  sticky-nowrap stickylist-text">4:46 am</td>
        <td class="sticky-action">
                                            
    </td>
    </tr>

</table>

    <?php 
    //echo do_shortcode('[stickylist id="11" user="' . $usrid . '"]'); ?>
    
</div> 
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