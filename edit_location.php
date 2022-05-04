<?php 
/*
Template Name: Template for edit location
*/

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

global $wpdb;

if(isset($_POST["resave_location"]) && $_POST["resave_location"]!=''){
//Array ( [input_52] => Test Company [input_33] => Derek [input_49] => Gallardo [input_34] => (786) 707-5642 [input_44] => derekgallardo01@gmail.com [input_7] => 1 [input_28] => Eastern Time Zone [input_30] => 1 [input_8] => 3256 Sw 23 St [input_9] => Miami [input_10] => Alabama [input_51] => 33145 [resave_location] => update [location_id] => 680 )

$location_id = isset($_POST["location_id"])?$_POST["location_id"]:'';

$location_data =  $wpdb->get_row('SELECT d.*,l.lead_id,l.data,l.created_by,l.users_invited,l.accept_job,l.primary_location FROM '.$wpdb->prefix.AJ_Location::$tblLocation.' l LEFT JOIN '.$wpdb->prefix.AJ_Location::$tblDateLocation.' d ON l.ID=d.location_id WHERE l.ID='.$location_id.';');

        //print_r($location_data);
        //$location_id = $location_data->location_id;

        $loc_data = unserialize($location_data->data);

        $loc_data[52]   = $_POST["input_52"];
        $loc_data[33]   = $_POST["input_33"];
        $loc_data[49]   = $_POST["input_49"];
        $loc_data[34]   = $_POST["input_34"];
        $loc_data[44]   = $_POST["input_44"];
        $loc_data[7]    = $_POST["input_7"];
        $loc_data[28]   = $_POST["input_28"];
        $loc_data[30]   = $_POST["input_30"];
        $loc_data[8]    = $_POST["input_8"];
        $loc_data[9]    = $_POST["input_9"];
        $loc_data[10]   = $_POST["input_10"];
        $loc_data[51]   = $_POST["input_51"];
        
        //echo 'update '.$wpdb->prefix.AJ_Location::$tblLocation.' set data = "'.serialize($loc_data).'" where ID='.$location_id.';'; die();

        $wpdb->query("update ".$wpdb->prefix.AJ_Location::$tblLocation." set data = '".serialize($loc_data)."' where ID=".$location_id.";");



}

?>
<style>
#gform_fields_11{
    list-style: none;
}
</style>
<?php

/*
Template Name: Event listing
*/$url = Theme_My_Login::get_page_link('login');$permalink_structure = get_option('permalink_structure', '');if(!is_user_logged_in()) {    $url_login = empty($permalink_structure) ? $url.'&redirect_to='.curPageURL() : $url.'?redirect_to='.curPageURL();    wp_redirect($url_login);} $active_sidebar_left = is_active_sidebar('sidebar-left-user');$content_class = $active_sidebar_left ? 'content-width' : 'full-width';$wclass = $active_sidebar_left ? 'wrapper-sleft': ''; ?>    
<div id="wrapper-content-2" class="<?php echo $wclass; ?>"> 

<div class="second-wrapper">   <!-- lavel 4 -->      
    <div class="total-width"> <!-- lavel 3 -->                      
        <?php if($active_sidebar_left && !$active_van_user): ?>
            <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                <?php dynamic_sidebar('sidebar-left-user'); ?>
            </div>
        <?php endif; ?>
        <?php if($active_sidebar_left && $active_van_user): ?>
            <div id="sidebar-left-therapist" class="sidebar sidebar-left">
                <?php dynamic_sidebar('sidebar-left-van-user'); ?>
            </div>
        <?php endif; ?>
        <h3 class="title-content" style="padding-top:30px;"><?php the_title(); ?></h3>       

    <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?> content-right">	<!-- lavel 2 -->

    <form method="post" name="location_update" id="location_update" >	
        <?php			
        $user = wp_get_current_user();			
        $usrid = ( isset( $user->ID ) ? (int) $user->ID : 0 );			
        $content_class = 'full-width'; 
        
        $location_id = isset($_GET["location_id"])?$_GET["location_id"]:'';
        
        $location_data =  $wpdb->get_row('SELECT d.*,l.lead_id,l.data,l.created_by,l.users_invited,l.accept_job,l.primary_location FROM '.$wpdb->prefix.AJ_Location::$tblLocation.' l LEFT JOIN '.$wpdb->prefix.AJ_Location::$tblDateLocation.' d ON l.ID=d.location_id WHERE l.ID='.$location_id.';');
        
        //print_r($location_data);
        //$location_id = $location_data->location_id;

        $loc_data = unserialize($location_data->data);
        //print_r($loc_data);
        //print_r($location_data);
        
            // Get all the user roles as an array.
            $user_roles = $user->roles;
            ?>
            <div class="post-content"> <!-- lavel 1 -->

            <ul id="gform_fields_11" class="gform_fields top_label form_sublabel_below description_below">
                <li id="field_11_4" class="gfield gsection start-job-info sm_tooltip field_sublabel_below field_description_below gfield_visibility_visible added-tooltip"><h2 class="gsection_title">Event Site/s Information</h2></li>
                
                <li id="field_11_52" class="gfield start_gf_multi_row gf_left_half field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_52">Company Name</label><div class="ginput_container ginput_container_text"><input name="input_52" id="input_11_52" type="text" value="<?php echo $loc_data[52]; ?>" class="medium" aria-invalid="false"></div></li>
                
                <li id="field_11_33" class="gfield start_gf_multi_row gf_left_half field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_33">On Site Contact Persons First Name</label><div class="ginput_container ginput_container_text"><input name="input_33" id="input_11_33" type="text" value="<?php echo $loc_data[33]; ?>" class="medium" aria-invalid="false"></div></li>
                
                <li id="field_11_49" class="gfield gf_right_half field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_49">On Site Contact Persons Last Name</label><div class="ginput_container ginput_container_text"><input name="input_49" id="input_11_49" type="text" value="<?php echo $loc_data[49]; ?>" class="medium" aria-invalid="false"></div></li>
                
                <li id="field_11_34" class="gfield gf_left_half field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_34">On Site Contact Persons Phone Number</label><div class="ginput_container ginput_container_phone"><input name="input_34" id="input_11_34" type="text" value="<?php echo $loc_data[34]; ?>" class="medium" aria-invalid="false"></div></li>
                
                <li id="field_11_44" class="gfield gf_right_half field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_44">On Site Contact Persons Email</label><div class="ginput_container ginput_container_email">
                <input name="input_44" id="input_11_44" type="text" value="<?php echo $loc_data[44]; ?>" class="medium" aria-invalid="false">
                    </div>
                </li>
                    
                <li id="field_11_7" class="gfield gf_left_half gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_7">How many therapists do you need?<span class="gfield_required">*</span></label><div class="ginput_container ginput_container_select"><select name="input_7" id="input_11_7" class="medium gfield_select" aria-required="true" aria-invalid="false">
                <option value="" selected="selected">Total # of Therapist for this location</option>
                
                <?php
                for($t=1;$t<11;$t++){
                    $selected = '';
                    if($loc_data[7]==$t){
                        $selected = 'selected="selected"';
                    }
                ?>
                    <option value="<?php echo $t;?>" <?php echo $selected;?> ><?php echo $t;?></option>
                <?php
                }
                ?>
                
                </select></div></li>
                
                <li id="field_11_28" class="gfield gf_right_half gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible">
                    <label class="gfield_label" for="input_11_28">Time Zone<span class="gfield_required">*</span></label>
                    <div class="ginput_container ginput_container_select">
                        <select name="input_28" id="input_11_28" class="medium gfield_select" aria-required="true" aria-invalid="false">
                            <option value=""  >Time Zone</option>
                            <option value="Central Time Zone" <?php if($loc_data[28]=='Central Time Zone'){echo 'selected="selected"';}?>>Central Time Zone</option>
                            <option value="Eastern Time Zone" <?php if($loc_data[28]=='Eastern Time Zone'){echo 'selected="selected"';}?>>Eastern Time Zone</option>
                            <option value="Mountain Time Zone" <?php if($loc_data[28]=='Mountain Time Zone'){echo 'selected="selected"';}?>>Mountain Time Zone</option>
                            <option value="Alaska Time Zone" <?php if($loc_data[28]=='Alaska Time Zone'){echo 'selected="selected"';}?>>Alaska Time Zone</option>
                            <option value="Pacific Time Zone" <?php if($loc_data[28]=='Pacific Time Zone'){echo 'selected="selected"';}?>>Pacific Time Zone</option>
                            <option value="Samoa Time Zone" <?php if($loc_data[28]=='Samoa Time Zone'){echo 'selected="selected"';}?>>Samoa Time Zone</option>
                        </select>
                    </div>
                </li>
                
                <li id="field_11_30" class="gfield gf_right_half hours_field_hide field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_30">Total numbers of massage hours at this location</label><div class="ginput_container ginput_container_select">
                    
                    <select name="input_30" id="input_11_30" class="medium gfield_select" aria-invalid="false">
                    <option value="" selected="selected">Total # of massage hours for this location</option>
                    <?php
                    for($t=1;$t<11;$t++){
                        $selected = '';
                        if($loc_data[30]==$t){
                            $selected = 'selected="selected"';
                        }
                    ?>
                        <option value="<?php echo $t;?>" <?php echo $selected;?> ><?php echo $t;?></option>
                    <?php
                    }
                    ?>

                </select></div></li>

            <li id="field_11_8" class="gfield gf_left_half gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_8">Complete Address for Event Location<span class="gfield_required">*</span></label><div class="ginput_container ginput_container_text"><input name="input_8" id="input_11_8" type="text" value="<?php echo $loc_data[8]; ?>" class="medium" aria-required="true" aria-invalid="false"></div>
            </li>
            <li id="field_11_9" class="gfield gf_right2_half gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_9">City<span class="gfield_required">*</span></label><div class="ginput_container ginput_container_text"><input name="input_9" id="input_11_9" type="text" value="<?php echo $loc_data[9]; ?>" class="medium" aria-required="true" aria-invalid="false"></div></li>
            
            <li id="field_11_10" class="gfield gf_right2_half gf_clearnone gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible">
                <label class="gfield_label" for="input_11_10">State<span class="gfield_required">*</span></label><div class="ginput_container ginput_container_select">
                <select name="input_10" id="input_11_10" class="medium gfield_select" aria-required="true" aria-invalid="false">
                    <?php
                    $state_array = array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming', 'Armed Forces Americas', 'Armed Forces Europe', 'Armed Forces Pacific' );

                    foreach($state_array as $state){
                        $selected = '';
                        if($loc_data[10]==$t){
                            $selected = 'selected="selected"';
                        }
                    ?>
                        <option value="<?php echo $state; ?>" <?php echo $selected;?> ><?php  echo $state; ?></option>
                    <?php
                    }
                    ?>
                </select>
                
                </div></li><li id="field_11_51" class="gfield gfield_contains_required field_sublabel_below field_description_below gfield_visibility_visible"><label class="gfield_label" for="input_11_51">Zip Code<span class="gfield_required">*</span></label><div class="ginput_container ginput_container_text"><input name="input_51" id="input_11_51" type="text" value="<?php echo $loc_data[51]; ?>" class="medium" aria-required="true" aria-invalid="false"></div></li>
        

            <li class="gchoice_11_29_1">
            <input type="submit" name="resave_location" id="submit" value="update" />     
            <input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id;?>" /> </li>

            </ul>

                    
            </div> <!-- end lavel 1 -->
            </form>
        </div>       <!-- end lavel 2 -->     

        <div class="clr"></div>       

    </div> <!-- end lavel 3 -->

  </div> <!-- end lavel 4 -->

</div>



<?php get_footer(); ?>