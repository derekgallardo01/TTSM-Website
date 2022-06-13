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
    <?php endif; ?><h3 class="title-content" style="padding-top:30px;"><?php the_title(); ?></h3>            
    <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?> content-right">			
    <?php			
    $user = wp_get_current_user();			
    $usrid = ( isset( $user->ID ) ? (int) $user->ID : 0 );			
    $content_class = 'full-width'; 


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
        <th class="sticky-action">Actions</th>
    </tr>
<?php

if(isset($_GET["gg"]) || 1){
    
   /* error_reporting(E_ALL);
    ini_set('display_errors',1);*/

    $date = null;

    if( !empty($_REQUEST['search']) && is_array($_REQUEST['search']) && !empty($_REQUEST['search']['year']) ) {

        $date = $_REQUEST['search']['year'].'{month}';

        $date = str_replace('{month}',(!empty($_REQUEST['search']['month']) ? '-'.$_REQUEST['search']['month'] : ''),$date);

    }
    $adm_jobs = new Admin_Jobs();
    //get_available_locations_user
    
    $locations = $adm_jobs->get_available_locations_created(get_current_user_id(),$date);
    
    foreach($locations as $location_data){
        //echo '<pre>';
        //print_r($location_data);  die();
        $loc_data = unserialize($location_data->data);
        
        //print_r($location_data);

    ?>
        <tr>
            <td class="sort-0  sticky-nowrap stickylist-text"><?php echo $loc_data[52]?></td>
            <td class="sort-1  stickylist-text"><?php echo $loc_data[33]?> <?php echo $loc_data[49]?></td>
            <td class="sort-2  sticky-nowrap stickylist-phone"><?php echo $loc_data[49]?></td>
            <td class="sort-3  sticky-nowrap stickylist-email"><?php echo $loc_data[44]?></td>
            <td class="sort-4  sticky-nowrap stickylist-date"><?php echo $location_data->month?>/<?php echo $location_data->day?>/<?php echo $location_data->year?> </td>
            <td class="sort-5  sticky-nowrap stickylist-text"><?php echo $location_data->stime; ?> </td>
            <td class="sort-6  sticky-nowrap stickylist-text"><?php echo $location_data->etime; ?></td>
            <td class="sticky-action"><a href="/edit-location?location_id=<?php echo $location_data->location_id; ?>" > View</a> </td>
        </tr>
        <tr>
            <td colspan="8">
            <!--<table border="0">
                <tr>
                <td><span class="nameheading"><b>Therapist Names</b></span></td>
                <td><span class="nameheading"><b>Email Id</b></span></td>
                <td><span class="nameheading"><b>Phone</b></span></td>
                <td><span class="nameheading"><b>Invitation Status</b></span></td>
                </tr>-->

                <?php
                $users_inviteds = maybe_unserialize($location_data->users_invited);
                $status_accept = maybe_unserialize($location_data->accept_job);
                //print_r($location_data);
                if(!empty($users_inviteds)){
                    foreach($users_inviteds as $id=>$therapist) {
                        
                        $user_info = get_userdata($id);
                        //$user_info = $user_info_ob->data;
                       // print_r($user_info);
                        $user_email = isset($user_info->user_email)?$user_info->user_email:'';
                        
                        $first_name = get_user_meta($id, 'first_name', true);
                        $last_name = get_user_meta($id, 'last_name', true);
                        $phone  = get_user_meta($id,'phone',true);

                        //echo $therapist;
                        //echo '<tr><td><span class="simpletext">'.str_replace('View address','',$therapist).'</span></td><td><span class="simpletext">' . $user_email . '</span></td><td><span class="simpletext">' . $phone . '</span></td><td>';
                        
                        if( isset($status_accept[$id]) ) {

                            echo 'Accepted Therapist : '.$first_name.' '. $last_name.' '.$phone.'<br /> ';
                            //echo '<span class="selectedstat">Accepted</span>';
                        } else {
                            //echo '<span class="simplestat">Pending</span>';
                            
                        }
                        
                        //echo '</td></tr>';
                    }
                }
                                
                ?>

                <!--</table>-->	

                </td>
        </tr>

    <?php  } ?>
    </table>

    <?php 

}else{
    echo do_shortcode('[stickylist id="11" user="' . $usrid . '"]');
}


?>
    
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