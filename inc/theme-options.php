<?php
/**
 * That The Spot Massage Theme Options
 *
 * @package WordPress
 * @subpackage spotmassage
 * @since That The Spot Massage
 */
 
 
 class SM_ThemeOptions {
    
    
    static $all_posts = null;
    
    function __construct() {
        add_action( 'admin_print_styles-appearance_page_theme_options', array($this,'admin_enqueue_scripts') );
        add_action( 'admin_init', array($this,'theme_options_init') );
        add_action( 'admin_menu', array($this,'theme_options_add_page') );
        
        add_action( 'customize_register', array($this,'customize_register') );
        add_action( 'customize_preview_init', array($this,'customize_preview_js') );
        
        add_filter( 'option_page_capability_spotmassage_options', array($this,'option_page_capability') );
        
        add_filter( 'posts_where',array($this, 'search_filter'));
        
        add_action('wp_ajax_order_fields_location', array($this, 'change_order_labels_location'));


        $this->load_all_posts();
    }
    
    function search_filter($where) {
        if ( is_search() ) {
            $options = $this->get_theme_options();
            $pages_exclude = is_null($options['pages_exclude']) ? array() : $options['pages_exclude'];
            $posts_exclude = is_null($options['posts_exclude']) ? array() : $options['posts_exclude'];
            $all_exclude = array_merge_recursive($pages_exclude,$posts_exclude);
            if( count($all_exclude) > 0) {
                $where .= ' AND ID NOT IN ('.implode(',',$all_exclude).')';
            }
    	}
    	return $where;
    }
    function load_all_posts() {
        if(!self::$all_posts) {
            global $wpdb;
            $sql = "SELECT * FROM ".$wpdb->posts." WHERE post_status='publish' AND post_type IN (%s, %s)";
            $results = $wpdb->get_results( $wpdb->prepare($sql, 'post','page') );
            self::$all_posts = $results;
        }
    }
    
    /**
     * Properly enqueue styles and scripts for our theme options page.
     *
     * This function is attached to the admin_enqueue_scripts action hook.
     *
     * @since That The Spot Massage
     *
     */
    function admin_enqueue_scripts( $hook_suffix ) {
    	wp_enqueue_style( 'spotmassage-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
    	wp_enqueue_script( 'spotmassage-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
    	wp_enqueue_style( 'farbtastic' );

        wp_enqueue_script( 'jquery-ui-sortable' );
    }
    
    
    /**
     * Register the form setting for our spotmassage_options array.
     *
     * This function is attached to the admin_init action hook.
     *
     * This call to register_setting() registers a validation callback, spotmassage_theme_options_validate(),
     * which is used when the option is saved, to ensure that our option values are complete, properly
     * formatted, and safe.
     *
     * @since That The Spot Massage
     */
    function theme_options_init() {
        
    	register_setting(
    		'spotmassage_options',
    		'spotmassage_theme_options',
    		array($this,'theme_options_validate')
    	);
        
    	add_settings_section(
    		'general',
    		'',
    		'__return_false',
    		'theme_options'
    	);
        add_settings_field( 'footer_text', __( 'Footer Text', 'spotmassage' ), array($this,'settings_footer_text'), 'theme_options', 'general' );
        add_settings_field( 'pages_exclude', __( 'Pages Exclude Search', 'spotmassage' ), array($this,'settings_field_pages_exclude'), 'theme_options', 'general' );
        add_settings_field( 'posts_exclude', __( 'Posts Exclude Search', 'spotmassage' ), array($this,'settings_field_posts_exclude'), 'theme_options', 'general' );
        $this->labels_location = get_option('gf_front_labels_location', array());

        if( !empty($this->labels_location) )
            add_settings_field( 'order_location', __( 'Change Order Location', 'spotmassage' ), array($this,'render_order_labels_location'), 'theme_options', 'general' );
    }

    /**
     * Order Location
     ***/
    function render_order_labels_location() {
        
        ?>
        <div id="change-order-labels-location">
            <p><?php _e('Drag and drop to Label to change order', 'spotmassage'); ?></p>
            <div id="msg-order" style="display: none;"></div>
            <ul id="labels-location">
                <?php foreach($this->labels_location as $key=>$lbl) : ?>
                <li key="<?php echo $key; ?>"><?php echo $lbl; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <script type="text/javascript">
        jQuery(change_order_labels_location);
        function change_order_labels_location() {
            var stop_change_order = function( event, ui) {
                var fields = new Array();
                var each_lis = function(index, domE) {
                    var elemt = jQuery(domE);
                    var i = elemt.attr('key');
                    fields.push({
                        key: i,
                        label: elemt.text()
                    });
                };

                jQuery(this).children().each(each_lis);

                var params = {
                    action: 'order_fields_location',
                    fields_location: fields
                };
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: params,
                    success: function(response) {
                        jQuery('#msg-order').addClass('updated').html('<p><?php _e('Order updated','spotmassage'); ?></p>').slideDown('slow').delay(5000).slideUp('slow');
                    }
                });
            };
            jQuery( '#labels-location' ).sortable({
                stop: stop_change_order,
                revert: true,
            });
        }
        </script>
        <?php
    }
    function change_order_labels_location() {
        
        if( !empty($_POST['fields_location']) ) {
            $fields_orders = $_POST['fields_location'];
            $new_order = array();
            foreach($fields_orders as $field) {
                $new_order[$field['key']] = $field['label'];
            }
            update_option('gf_front_labels_location', $new_order);
        }

        die();
    }
    
    
    /**
     * Change the capability required to save the 'spotmassage_options' options group.
     *
     * @see spotmassage_theme_options_init() First parameter to register_setting() is the name of the options group.
     * @see spotmassage_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
     *
     * By default, the options groups for all registered settings require the manage_options capability.
     * This filter is required to change our theme options page to edit_theme_options instead.
     * By default, only administrators have either of these capabilities, but the desire here is
     * to allow for finer-grained control for roles and users.
     *
     * @param string $capability The capability used for the page, which is manage_options by default.
     * @return string The capability to actually use.
     */
    function option_page_capability( $capability ) {
    	return 'edit_theme_options';
    }
    
    
    /**
     * Add our theme options page to the admin menu, including some help documentation.
     *
     * This function is attached to the admin_menu action hook.
     *
     * @since That The Spot Massage
     */
    function theme_options_add_page() {
    	$theme_page = add_theme_page(
    		__( 'Theme Options', 'spotmassage' ),   // Name of page
    		__( 'Theme Options', 'spotmassage' ),   // Label in menu
    		'edit_theme_options',                    // Capability required
    		'theme_options',                         // Menu slug, used to uniquely identify the page
    		array($this, 'theme_options_render_page') // Function that renders the options page
    	);
    
    	if ( !$theme_page )
    		return;
    
    	add_action( "load-$theme_page", array($this,'theme_options_help') );
    }
    
    
    function theme_options_help() {
    
    	$help = '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, Twenty Eleven, provides the following Theme Options:', 'spotmassage' ) . '</p>' .
    			'<ol>' .
    				'<li>' . __( '<strong>Color Scheme</strong>: You can choose a color palette of "Light" (light background with dark text) or "Dark" (dark background with light text) for your site.', 'spotmassage' ) . '</li>' .
    				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'spotmassage' ) . '</li>' .
    				'<li>' . __( '<strong>Default Layout</strong>: You can choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'spotmassage' ) . '</li>' .
    			'</ol>' .
    			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'spotmassage' ) . '</p>';
    
    	$sidebar = '<p><strong>' . __( 'For more information:', 'spotmassage' ) . '</strong></p>' .
    		'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_Theme_Options_Screen" target="_blank">Documentation on Theme Options</a>', 'spotmassage' ) . '</p>' .
    		'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'spotmassage' ) . '</p>';
    
    	$screen = get_current_screen();
    
    	if ( method_exists( $screen, 'add_help_tab' ) ) {
    		// WordPress 3.3
    		$screen->add_help_tab( array(
    			'title' => __( 'Overview', 'spotmassage' ),
    			'id' => 'theme-options-help',
    			'content' => $help,
    			)
    		);
    
    		$screen->set_help_sidebar( $sidebar );
    	} else {
    		// WordPress 3.2
    		add_contextual_help( $screen, $help . $sidebar );
    	}
    }
    
    
    
    /**
     * Returns the default options for Twenty Eleven.
     *
     * @since That The Spot Massage
     */
    function get_default_theme_options() {
    	$default_theme_options = array(
            'footer_text' => __('Copyright 2013 Ahh That\'s the Spot     Privacy Notice.     Terms and Conditions.', 'spotmassage'),
            'pages_exclude' => array(),
            'posts_exclude' => array()
    	);
    
    	return apply_filters( 'spotmassage_default_theme_options', $default_theme_options );
    }
    
    
    /**
     * Returns the options array for Twenty Eleven.
     *
     * @since That The Spot Massage
     */
    function get_theme_options() {
    	return get_option( 'spotmassage_theme_options', $this->get_default_theme_options() );
    }
    
    
    
    /**
     * Returns the options array for Twenty Eleven.
     *
     * @since Twenty Eleven 1.2
     */
    function theme_options_render_page() {
    	?>
    	<div class="wrap">
    		<?php screen_icon(); ?>
    		<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
    		<h2><?php printf( __( '%s Theme Options', 'spotmassage' ), $theme_name ); ?></h2>
    		<?php settings_errors(); ?>
    
    		<form method="post" action="options.php">
    			<?php
    				settings_fields( 'spotmassage_options' );
    				do_settings_sections( 'theme_options' );
    				submit_button();
    			?>
    		</form>
    	</div>
    	<?php
    }
    
    /**
     * Sanitize and validate form input. Accepts an array, return a sanitized array.
     *
     * @see spotmassage_theme_options_init()
     * @todo set up Reset Options action
     *
     * @since That The Spot Massage
     */
    function theme_options_validate( $input ) {
    	$output = $defaults = $this->get_default_theme_options();
        
        if ( isset( $input['footer_text'] ) && $input['footer_text'] )
            $output['footer_text'] = $input['footer_text'];

        if ( isset( $input['pages_exclude'] ) && $input['pages_exclude'] )
    		$output['pages_exclude'] = array_values( array_filter( explode(',',$input['pages_exclude']) ) );
            
        if ( isset( $input['posts_exclude'] ) && $input['posts_exclude'] )
    		$output['posts_exclude'] = array_values( array_filter( explode(',',$input['posts_exclude']) ) );
            
    	return apply_filters( 'spotmassage_theme_options_validate', $output, $input, $defaults );
    }
    
    
    
    /**
     * Implements That The Spot Massage Theme options into Theme Customizer
     *
     * @param $wp_customize Theme Customizer object
     * @return void
     *
     * @since That The Spot Massage
     */
    function customize_register( $wp_customize ) {
    	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    
    	$options  = $this->get_theme_options();
    	$defaults = $this->get_default_theme_options();

        // Footer Text
        $wp_customize->add_setting( 'spotmassage_theme_options[footer_text]', array(
            'default'           => __('Copyright 2013 Ahh That\'s the Spot     Privacy Notice.     Terms and Conditions.', 'spotmassage'),
            'type'              => 'option',
            'capability'        => 'edit_theme_options'
        ) );
    
        $wp_customize->add_control( 'spotmassage_theme_options[footer_text]', array(
            'label' => __( 'Footer Text', 'spotmassage' ),
            'section' => 'general'
        ) );    
    	
        // Pages Exclude
    	$wp_customize->add_setting( 'spotmassage_theme_options[pages_exclude]', array(
    		'default'           => $options['pages_exclude'] ? $options['pages_exclude'] : array(),
    		'type'              => 'option',
    		'capability'        => 'edit_theme_options'
    	) );
    
        $wp_customize->add_control( 'spotmassage_theme_options[pages_exclude]', array(
    		'label' => __( 'Exclude Pages in the search', 'spotmassage' ),
    		'section' => 'general'
    	) );
        
        // Posts Exclude
    	$wp_customize->add_setting( 'spotmassage_theme_options[posts_exclude]', array(
    		'default'           => $options['posts_exclude'] ? $options['posts_exclude'] : array(),
    		'type'              => 'option',
    		'capability'        => 'edit_theme_options'
    	) );
        $wp_customize->add_control( 'spotmassage_theme_options[posts_exclude]', array(
    		'label' => __( 'Exclude Posts in the search', 'spotmassage' ),
    		'section' => 'general'
    	) );
    }
    
    
    /**
     * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
     * Used with blogname and blogdescription.
     *
     * @since That The Spot Massage
     */
    function customize_preview_js() {
    	wp_enqueue_script( 'spotmassage-customizer', get_template_directory_uri() . '/inc/theme-customizer.js', array( 'customize-preview' ), '20120523', true );
    }
    
    function settings_footer_text() {
        $options = $this->get_theme_options();
        $footer_text = !empty($options['footer_text']) ? $options['footer_text'] : '';
        ?>
        <div id="select-footer-text">
            <?php wp_editor($footer_text, 'footer_text', array('textarea_name' => 'spotmassage_theme_options[footer_text]')); ?>
        </div>
        <?php
    }

    function settings_field_pages_exclude() {
        $posts = self::$all_posts;
        $empty = true;
        $options = $this->get_theme_options();
        $pages_exclude = is_null($options['pages_exclude']) ? array() : $options['pages_exclude'];
        ?>
        <div id="select-page">
            <ul>
            <?php foreach($posts as $page): if($page->post_type != 'page') continue; $empty = false; ?>
                <li>
                    <label>
                        <input class="page_excludes" type="checkbox" value="<?php echo $page->ID; ?>" <?php if(in_array($page->ID, $pages_exclude)) { echo 'checked="checked"'; } ?> />&nbsp;<?php echo $page->post_title; ?>
                    </label>
                </li>
            <?php endforeach;
                
                if($empty) {
                    echo '<li>'.__('Not found pages','spotmassage').'</li>';
                }
            ?>
            </ul>
            <input id="input_page_exclude" type="hidden" name="spotmassage_theme_options[pages_exclude]" value="" />
        </div>
        <?php
    }
    
    function settings_field_posts_exclude() {
        $posts = self::$all_posts;
        $empty = true;
        $options = $this->get_theme_options();
        $posts_exclude = is_null($options['posts_exclude']) ? array() : $options['posts_exclude'];
        ?>
        <div id="select-post">
            <ul>
            <?php foreach($posts as $post): if($post->post_type != 'post') continue; $empty = false; ?>
                <li>
                    <label>
                        <input class="post_excludes" type="checkbox" value="<?php echo $post->ID; ?>" <?php if(in_array($post->ID, $posts_exclude)) { echo 'checked="checked"'; } ?> />&nbsp;<?php echo $post->post_title; ?>
                    </label>
                </li>
            <?php endforeach;
                
                if($empty) {
                    echo '<li>'.__('Not found posts','spotmassage').'</li>';
                }
            ?>
            </ul>
            <input id="input_post_exclude" type="hidden" name="spotmassage_theme_options[posts_exclude]" value="" />
        </div>
        <?php
    }

}
$GLOBALS['sm_theme_options'] = new SM_ThemeOptions();