<?php
if( !defined('GF_FORMAT_DATE') ) {
    define('GF_FORMAT_DATE', 'dmy');
}

if( !defined('REGISTER_THERAPIST_FORM_ID') ) {
    define('REGISTER_THERAPIST_FORM_ID', 3);
}

if( !defined('INPUT_FIELD_ZIPCODE_HTML_ID') ) {
    define('INPUT_FIELD_ZIPCODE_HTML_ID', 'input_'.REGISTER_THERAPIST_FORM_ID.'_15_5');
}

if( !defined('INPUT_FIELD_STATE_HTML_ID') ) {
    define('INPUT_FIELD_STATE_HTML_ID', 'input_'.REGISTER_THERAPIST_FORM_ID.'_15_4');
}

if( !defined('SM_KEY_SECRET') ) {
    define('SM_KEY_SECRET', 'etbAU74YjG6J3u30Y');
}

if( !defined('ID_PAGE_MY_JOBS') ) {
    define('ID_PAGE_MY_JOBS', 219);//92);
}
if( !defined('ID_PAGE_SUBMIT_JOB') ) {
    define('ID_PAGE_SUBMIT_JOB', 60);
}

if( !defined('ID_PAGE_INVOICE') ) {
    define('ID_PAGE_INVOICE', 235);
}
if( !defined('ID_PAGE_PAYMENT_OPTIONS') ) {
    define('ID_PAGE_PAYMENT_OPTIONS', 233);
}

if( !defined('KEY_PARAMS_CALLBACK_PAYPAL') ) {
    define('KEY_PARAMS_CALLBACK_PAYPAL', 'PAYMENTREQUEST_0_DESC');
}

if( !defined('KEY_LDATE_ID_CALLBACK_PAYPAL') ) {
    define('KEY_LDATE_ID_CALLBACK_PAYPAL', 'L_PAYMENTREQUEST_0_NUMBER{i}');
}


if( !defined('KEY_USER_ID_CALLBACK_PAYPAL') ) {
    define('KEY_USER_ID_CALLBACK_PAYPAL', 'WP_USER_ID');
}

if( !defined('KEY_STATUS_USER') ) {
    define('KEY_STATUS_USER', 'status_user_{uid}');
}

require_once( get_template_directory() . '/testimonial-post-type.php' );
require_once( get_template_directory() . '/lib/class.pseudocrypt.php' );

function sm_init() {
    //$GLOBALS['pluginsURI'] = '';
}
add_action('init', 'sm_init', 9);

add_filter( 'wp_nav_menu_items', 'sm_custom_menu_item', 10, 2 );
function sm_custom_menu_item($items, $args) {
    if ( $args->theme_location == 'header-menu') {
        $items .= is_user_logged_in() ? '<li><a href="'.site_url('/wp-admin/').'">'.__('Profile','spotmassage').'</a></li>' : '<li><a href="'.site_url('/wp-admin/').'">'.__('Login','spotmassage').'</a></li>';
    }
    return $items;
}


function encrypt($hash){
   return PseudoCrypt::hash($hash, 7); 
}

function decrypt($hash){
   return PseudoCrypt::unhash($hash); 
}


if(!function_exists('isJson')) {
    function isJson(&$string) {
        if(!is_string($string)) {
            return false;
        }
        $string = stripcslashes($string);
        $json = json_decode($string);
        return $json != null && ( is_array($json) || is_object($json) );
    }
}
function z_remove_media_controls($context) {
    return;
}

add_action('media_buttons_context', 'z_remove_media_controls');

add_action( 'after_setup_theme', 'spotmassage_setup' );
function spotmassage_setup() {
    load_theme_textdomain( 'spotmassage', get_template_directory() . '/languages' );
    // This theme styles the visual editor with editor-style.css to match the theme style.
	//add_editor_style();

	// Load up our theme options page and related code.
	require_once( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	//require_once( get_template_directory() . '/inc/widgets.php' );
    
    register_nav_menu( 'header-menu', __( 'Header Menu', 'spotmassage' ) );
    
    register_nav_menu( 'primary', __( 'Primary Menu', 'spotmassage' ) );
    
    // Add support for custom headers.
	$custom_header_support = array(
        'header-text' => false,
        'uploads' => true,
		// The height and width of our custom header.
		'width' => apply_filters( 'spotmassage_header_image_width', 554 ),
		'height' => apply_filters( 'spotmassage_header_image_height', 75 ),
        'default-image' => get_template_directory_uri().'/images/logo.png'
	);
 
	add_theme_support( 'custom-header', $custom_header_support );
    add_theme_support( 'menus');
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'logo', 390, 115, true);
    
    add_image_size( 'icon-48', 48, 48, true);
    add_image_size( 'small-feature', 500, 300, true);
    add_image_size( 'small-image', 220, 220, true);
    add_image_size( 'small-home', 220, 162, true);
    
    add_image_size( 'medium-feature', 620, 390, true);
    add_image_size( 'full-width', 940, 390, true);
    
    wp_enqueue_script('jquery');
    
    wp_register_script('spotmassage-base-js', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'),false,true);
    wp_register_script('spotmassage-all-js', get_template_directory_uri().'/js/all.js', array('spotmassage-base-js'),false,true);
    
    $short_months = array(
        '01' => __('Jan', 'spotmassage'),
        '02' => __('Feb', 'spotmassage'),
        '03' => __('Mar', 'spotmassage'),
        '04' => __('Apr', 'spotmassage'),
        '05' => __('May', 'spotmassage'),
        '06' => __('Jun', 'spotmassage'),
        '07' => __('Jul', 'spotmassage'),
        '08' => __('Aug', 'spotmassage'),
        '09' => __('Sep', 'spotmassage'),
        '10' => __('Oct', 'spotmassage'),
        '11' => __('Nov', 'spotmassage'),
        '12' => __('Dec', 'spotmassage')
    );
    global $paged, $current_user;
    $vars_all = array(
        'permalink_structure' => get_option('permalink_structure', ''),
        'servertime' => intval(mktime()),
        'paged' => $paged,
        'short_months' => $short_months,
        'cDay' => date('j'),
        'cMonth' => date('n'),
        'cYear' => date('Y'),
        'gfInitDate' => 'gf_init_current_date',
        'textCancelJob' => __('If you need cancel this %s, please contact with site\'s administrator.', 'spotmassage'),
        'textAccepted' => __('%s Accepted', 'spotmassage'),
        'textAccept' => __('Accept %s', 'spotmassage'),
        'textSending' => __('Sending', 'spotmassage'),
        'textUpdating' => __('Updating...', 'spotmassage'),
        'textLocationNotFound' => __('Location not found', 'spotmassage'),
        'textOk' => __('Ok', 'spotmassage'),
        'textAlertMessage' => __('Message', 'spotmassage'),
        'textRangeNotValid' => __('Range not valid', 'spotmassage'),
        'txtCheckConnection' => __('Check your internet connection', 'spotmassage'),
        'txtNotUpdateInfo' => __("You don't been updated your information", 'spotmassage')
    );
    $GLOBALS['smglobal_vars'] = $vars_all;

    wp_localize_script('spotmassage-all-js', 'sM', $vars_all);
    
    
    /** Plugins **/
    if(!is_admin()) {
        wp_enqueue_script('spotmassage-base-js');
        wp_enqueue_script('spotmassage-all-js');
        wp_register_script('gf-multi-row', get_template_directory_uri().'/plugins/gf-multi-row/gf_multi_row.js', array('jquery','spotmassage-all-js'),false,true);
    }
    
    /** Shortcodes **/
    require_once(dirname(__FILE__).'/plugins/shortcode-select-posts/select-posts.php');
}


add_action( 'widgets_init', 'spotmassage_widgets_init');
function spotmassage_widgets_init() {
    
    register_sidebar(array(
    	'name'          => __( 'Right Sidebar', 'spotmassage' ),
    	'id'            => 'sidebar-right',
    	'description'   => __( 'This sidebar is used in the right section', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    
    register_sidebar(array(
    	'name'          => __( 'Header Sidebar', 'spotmassage' ),
    	'id'            => 'sidebar-header',
    	'description'   => __( 'This sidebar is used in the header site', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    register_sidebar(array(
    	'name'          => __( 'Footer Sidebar One', 'spotmassage' ),
    	'id'            => 'sidebar-footer-one',
    	'description'   => __( 'This sidebar is used in the footer site', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    register_sidebar(array(
    	'name'          => __( 'Footer Sidebar Column One', 'spotmassage' ),
    	'id'            => 'sidebar-footer-column-one',
    	'description'   => __( 'This sidebar is used in the footer site', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    register_sidebar(array(
    	'name'          => __( 'Footer Sidebar Column Two', 'spotmassage' ),
    	'id'            => 'sidebar-footer-column-two',
    	'description'   => __( 'This sidebar is used in the footer site', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    register_sidebar(array(
    	'name'          => __( 'Footer Sidebar Column Three', 'spotmassage' ),
    	'id'            => 'sidebar-footer-column-three',
    	'description'   => __( 'This sidebar is used in the footer site', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    
    /** Sidebar Home **/
    register_sidebar(array(
    	'name'          => __( 'Sidebar Home One', 'spotmassage' ),
    	'id'            => 'sidebar-home-one',
    	'description'   => __( 'This sidebar is used in the home page', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget home-one %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    register_sidebar(array(
    	'name'          => __( 'Sidebar Home Two', 'spotmassage' ),
    	'id'            => 'sidebar-home-two',
    	'description'   => __( 'This sidebar is used in the home page', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget home-two %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    
    /** Sidebar Form Secundary (Page Submit Job) **/
    register_sidebar(array(
    	'name'          => __( 'Sidebar Form Secundary', 'spotmassage' ),
    	'id'            => 'sidebar-form-secundary',
    	'description'   => __( 'This sidebar is used in the page template: Secundary Form', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
    
    register_sidebar(array(
    	'name'          => __( 'Left Sidebar User Front-end', 'spotmassage' ),
    	'id'            => 'sidebar-left-user',
    	'description'   => __( 'This sidebar is used in the right section', 'spotmassage' ),
        'class'         => '',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
    	'before_title'  => '<h3 class="widget-title">',
    	'after_title'   => '</h3>'
    ));
}



add_action('sm_secundary_form_page', 'tmpl_secundary_form');

function tmpl_secundary_form() {
    wp_enqueue_script('gf-multi-row');
    wp_localize_script('gf-multi-row', 'smGf', array('gf_format_date' => GF_FORMAT_DATE));
}

add_filter('gform_shortcode_form', 'sm_validation_address', 10, 3);

function sm_validation_address($shortcode_string, $attributes, $content) {
    
    if(REGISTER_THERAPIST_FORM_ID == $attributes['id']) {

        ob_start();
        
    ?><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCogCYTK9ieDOExJSEba4nIuSSo3ScT8-I&v=3"></script>    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCogCYTK9ieDOExJSEba4nIuSSo3ScT8-I&v=3.exp&sensor=true"></script>-->
<script type="text/javascript">
    var map_user;
    var marker;
    var geocoder;
    google.maps.visualRefresh = true;
    google.maps.event.addDomListener(window, 'load', initialize_map);
    function initialize_map() {
        if(!geocoder) {
            geocoder = new google.maps.Geocoder();
        }
    }
    
    function established_latlng(location) {

        if(location === null) {
            jQuery('#render-map-user').slideUp('fast');
            return;
        }
        var latlng = new google.maps.LatLng(location.lat,location.lng);
        
        var mapOptions = {
            zoom: 14,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var dom_render = document.getElementById('render-map-user');
        
        jQuery(dom_render).fadeIn('slow');
        
        map_user = new google.maps.Map(dom_render, mapOptions);
        
        marker = new google.maps.Marker({
            map: map_user,
            position: latlng,
            draggable: true,
            animation: google.maps.Animation.DROP
        });
        var _form = jQuery(id_form);
        
        google.maps.event.addListener(marker, 'dragend', function(){
             var location = marker.getPosition();
            
            _form.find('#lat').val(location.jb);
            _form.find('#lng').val(location.kb);
            
            map_user.setCenter(location);
            
        });
        
    }

    function run_search_address() {
        var _field_address = jQuery('#<?php echo INPUT_FIELD_ZIPCODE_HTML_ID; ?>');
        var _form = jQuery(id_form);
        var _message = _form.find('.message-info-address').children('#message-user')

        var objLat = _form.find('#lat');
        var objLng = _form.find('#lng');
        _field_address.addClass('bg-ajax-loading');
        var search_geocoder = function(results, status){
            
            if (status == google.maps.GeocoderStatus.OK) {
                var base_location = results[0];
                var latitude = base_location.geometry.location.lat();
                var longitude = base_location.geometry.location.lng();
                
                objLat.val(latitude);
                objLng.val(longitude);
                
                var _msg = '<?php _e('It has established the following approximate address: "%s", if you like can drag to location for a more accuracy','spotmassage'); ?>';
                _message.removeClass('error').addClass('info').html(_msg.replace('%s', base_location.formatted_address));
                
                established_latlng({lat: latitude, lng: longitude});
                centinela_submit = true;
                if(force_submit) {
                    _form.trigger('submit');
                }
            } else {
                var _msg = "<?php _e('Can\'t establish a approximate address. Please verify the value of ZIP / Postal Code.','spotmassage'); ?>";
                _message.removeClass('info').addClass('error').html(_msg);
                centinela_submit = false;
                _field_address.trigger('focus');
                established_latlng(null);
            }
            _message.fadeIn('slow');
            _field_address.removeClass('bg-ajax-loading');
        };
        if(!geocoder) {
            geocoder = new google.maps.Geocoder();
        }
        geocoder.geocode( { 'address': _field_address.val() }, search_geocoder);
    }
    
    var centinela_submit = false;
    var force_submit = false;
    var id_form = '#gform_<?php echo REGISTER_THERAPIST_FORM_ID; ?>';
    var id_button_form = '#gform_submit_button_<?php echo REGISTER_THERAPIST_FORM_ID; ?>';
    
    jQuery(document).on('ready', function(){
        
        var _field_address = jQuery('#<?php echo INPUT_FIELD_ZIPCODE_HTML_ID; ?>');
        var _form = jQuery(id_form);
        

        var _field_state_label = jQuery('#<?php echo INPUT_FIELD_STATE_HTML_ID; ?>_label');

        var _field_state = jQuery('#<?php echo INPUT_FIELD_STATE_HTML_ID; ?>');
        _field_state.children().first().html(_field_state_label.text());
        _field_state_label.hide();

        var _div_info = _form.find('.message-info-address');
        _div_info.append('<p id="message-user" style="display: none;"></p>').append('<div id="render-map-user" class="wrapper-map-medium" style="display: none;"></div>');

        if(jQuery.trim(_field_address.val()).length > 0) {
            run_search_address();
        }
        _field_address.on({'change': run_search_address, 'focusout': run_search_address});
        
        _form.append('<input id="lat" type="hidden" name="latlng[latitude]" value="" />').append('<input id="lng" type="hidden" name="latlng[longitude]" value="" />');
        

        var submit_form = function( event ) {
            if(!centinela_submit) {
                //force_submit = true;
                _field_address.trigger('change');
                return centinela_submit;
            } else if(event.data.sendSubmit) {
                _form.trigger('submit');
            } else {
                return centinela_submit;
            }
        };
        _form.on('submit',{ sendSubmit: false }, submit_form);
        jQuery(id_button_form).on('click',{ sendSubmit: true }, submit_form);
    });
    
    </script>
    <?php
        $script = ob_get_clean();
        return $shortcode_string.$script;
    }
    return $shortcode_string;
}


function sanitize_by_search_url($string) {
    $string = str_replace(' ','+',$string);
    return $string;
}


function disable_sidebar_login_widget_display() {
    return is_user_logged_in() && !current_user_can('activate_plugins');
}
add_filter( 'sidebar_login_widget_display', 'disable_sidebar_login_widget_display' );


function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}


add_filter("gform_column_input_2_50_1", "set_column_1_datetimes", 10, 5);
function set_column_1_datetimes($input_info, $field, $column, $value, $form_id){
    $days = array( array("text"=>"Day", "value"=>"") );
    for( $i=1; $i<=31; $i++ ) {
        $days[] = array("text"=>"".$i, "value"=>"".$i);
    }
    return array("type" => "select", "choices" => $days);
}

add_filter("gform_column_input_2_50_2", "set_column_2_datetimes", 10, 5);
function set_column_2_datetimes($input_info, $field, $column, $value, $form_id){
    return array("type" => "select", "choices" => array(
            array("text"=>"Month", "value"=>""),
            array("text"=>"01 - Jan", "value"=>"1"),
            array("text"=>"02 - Feb", "value"=>"2"),
            array("text"=>"03 - Mar", "value"=>"3"),
            array("text"=>"04 - Apr", "value"=>"4"),
            array("text"=>"05 - May", "value"=>"5"),
            array("text"=>"06 - Jun", "value"=>"6"),
            array("text"=>"07 - Jul", "value"=>"7"),
            array("text"=>"08 - Aug", "value"=>"8"),
            array("text"=>"09 - Sep", "value"=>"9"),
            array("text"=>"10 - Oct", "value"=>"10"),
            array("text"=>"11 - Nov", "value"=>"11"),
            array("text"=>"12 - Dec", "value"=>"12")
           ));
}

add_filter("gform_column_input_2_50_3", "set_column_3_datetimes", 10, 5);
function set_column_3_datetimes($input_info, $field, $column, $value, $form_id){
    $currentYear = intval(date('Y'));
    $years = array( array("text"=>"Year", "value"=>"") );
    for( $i=0; $i<3; $i++ ) {
        $years[] = array("text"=>"".($currentYear+$i), "value"=>"".($currentYear+$i));
    }
    return array("type" => "select", "choices" => $years);
}


add_filter("gform_column_input_2_50_4", "set_column_4_datetimes", 10, 5);
add_filter("gform_column_input_2_50_5", "set_column_4_datetimes", 10, 5);
function set_column_4_datetimes($input_info, $field, $column, $value, $form_id) {
    $times = array(
        array("text"=>$column, "value"=>""),
        array("text"=>"00:00 am", "value"=>"00:00 am"),
        array("text"=>"00:30 am", "value"=>"00:30 am"),
        array("text"=>"01:00 am", "value"=>"01:00 am"),
        array("text"=>"01:30 am", "value"=>"01:30 am"),
        array("text"=>"02:00 am", "value"=>"02:00 am"),
        array("text"=>"02:30 am", "value"=>"02:30 am"),
        array("text"=>"03:00 am", "value"=>"03:00 am"),
        array("text"=>"03:30 am", "value"=>"03:30 am"),
        array("text"=>"04:00 am", "value"=>"04:00 am"),
        array("text"=>"04:30 am", "value"=>"04:30 am"),
        array("text"=>"05:00 am", "value"=>"05:00 am"),
        array("text"=>"05:30 am", "value"=>"05:30 am"),
        array("text"=>"06:00 am", "value"=>"06:00 am"),
        array("text"=>"06:30 am", "value"=>"06:30 am"),
        array("text"=>"07:00 am", "value"=>"07:00 am"),
        array("text"=>"07:30 am", "value"=>"07:30 am"),
        array("text"=>"08:00 am", "value"=>"08:00 am"),
        array("text"=>"08:30 am", "value"=>"08:30 am"),
        array("text"=>"09:00 am", "value"=>"09:00 am"),
        array("text"=>"09:30 am", "value"=>"09:30 am"),
        array("text"=>"10:00 am", "value"=>"10:00 am"),
        array("text"=>"10:30 am", "value"=>"10:30 am"),
        array("text"=>"11:00 am", "value"=>"11:00 am"),
        array("text"=>"11:30 am", "value"=>"11:30 am"),
        array("text"=>"12:00 m", "value"=>"12:00 m"),
        array("text"=>"12:30 pm", "value"=>"12:30 pm"),
        array("text"=>"01:00 pm", "value"=>"01:00 pm"),
        array("text"=>"01:30 pm", "value"=>"01:30 pm"),
        array("text"=>"02:00 pm", "value"=>"02:00 pm"),
        array("text"=>"02:30 pm", "value"=>"02:30 pm"),
        array("text"=>"03:00 pm", "value"=>"03:00 pm"),
        array("text"=>"03:30 pm", "value"=>"03:30 pm"),
        array("text"=>"04:00 pm", "value"=>"04:00 pm"),
        array("text"=>"04:30 pm", "value"=>"04:30 pm"),
        array("text"=>"05:00 pm", "value"=>"05:00 pm"),
        array("text"=>"05:30 pm", "value"=>"05:30 pm"),
        array("text"=>"06:00 pm", "value"=>"06:00 pm"),
        array("text"=>"06:30 pm", "value"=>"06:30 pm"),
        array("text"=>"07:00 pm", "value"=>"07:00 pm"),
        array("text"=>"07:30 pm", "value"=>"07:30 pm"),
        array("text"=>"08:00 pm", "value"=>"08:00 pm"),
        array("text"=>"08:30 pm", "value"=>"08:30 pm"),
        array("text"=>"09:00 pm", "value"=>"09:00 pm"),
        array("text"=>"09:30 pm", "value"=>"09:30 pm"),
        array("text"=>"10:00 pm", "value"=>"10:00 pm"),
        array("text"=>"10:30 pm", "value"=>"10:30 pm"),
        array("text"=>"11:00 pm", "value"=>"11:00 pm"),
        array("text"=>"11:30 pm", "value"=>"11:30 pm"),
        array("text"=>"12:00 pm", "value"=>"12:00 pm"));
    return array("type" => "select", "choices" => $times);
}if(isset($_POST["user_id"]) && $_POST["user_id"]!=''){$user = wp_get_current_user();$userid = ( isset( $user->ID ) ? (int) $user->ID : 0 );$sorting         = array(  );$search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $userid );$entries         = GFAPI::get_entries( 3, $search_criteria, $sorting );$lead_id = $entries[0]["id"];/* global $wpdb;echo $querystr = "    SELECT *     FROM ".$wpdb->prefix."rg_lead_meta    WHERE meta_key = 'user_registration_feed_id' and meta_value = '".$userid."' ";$leads = $wpdb->get_results($querystr, OBJECT);print_r($leads);die(); */if(isset($_FILES["licence"]) && $_FILES["licence"]["name"]!='' && $lead_id!=''){$frm = new GFFormsModel();$frurl = $frm->upload_file(3,$_FILES["licence"]);GFAPI::update_entry_field($lead_id, 8, $frurl);}}