<?php
/*---------------------------------------------------------------------------------*/
/* Testimonials Custom Post Type */
/*---------------------------------------------------------------------------------*/
add_action('init', 'testimonial_register');
 
function testimonial_register() {
 
    $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonial', 'post type singular name'),
        'add_new' => _x('Add New', 'testimonial item'),
        'add_new_item' => __('Add New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'new_item' => __('New Testimonial'),
        'view_item' => __('View Testimonial'),
        'search_items' => __('Search Testimonial'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
 
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor')
      ); 
 
    register_post_type( 'testimonial' , $args );
}

add_action("admin_init", "admin_init_testimonial");
 
function admin_init_testimonial(){
  add_meta_box("credits_meta_testimonial", "Theme Team Custom Testimonial Options", "credits_meta_testimonial", "testimonial", "normal", "low");
}
 
function credits_meta_testimonial() {
  global $post;
  $custom = get_post_custom($post->ID);
  $testimonial_name = $custom["testimonial_name"][0];
  $testimonial_url = $custom["testimonial_url"][0];
  $testimonial_header = $custom["testimonial_header"][0];
  $testimonial_excerpt = $custom["testimonial_excerpt"][0];
  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'themeteam_testimonial' );
  
  ?>
  <style type="text/css">
    .input_text { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:80%; font-size:11px; padding: 5px;}
    .input_select { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:60%; font-size:11px; padding: 5px;}
    .input_checkbox { margin:0 10px 0 0; }
    .spacer { display: block; height:5px}
    .metabox_desc { font-size:10px; color:#aaa; display:block}
    .metaboxes{ border-collapse:collapse; width:100%}
    .metaboxes tr:hover th,
    .metaboxes tr:hover td { background:#f8f8f8}
    .metaboxes th,
    .metaboxes td{ border-bottom:1px solid #ddd; padding:10px 10px;text-align: left; vertical-align:top}
    .metabox_th { width:20%}
    .input_textarea { width:80%; height:120px;margin:0 0 10px 0; background:#f0f0f0; color:#444;font-size:11px;padding: 5px;}
  </style>
  <table class="metaboxes">
    <tr>
        <th class="metabox_th"><label for="testimonial_header">Testimonial Header Text:</label></th>
        <td><input class="input_text" type="text" name="testimonial_header" id="testimonial_header" value="<?php echo $testimonial_header; ?>"/>
        <span class="metabox_desc">Enter the text for the custom header</span></td>
        <td></td>
    </tr>
    <tr>
        <th class="metabox_th"><label for="testimonial_name">Testimonial Name:</label></th>
        <td><input class="input_text" type="text" name="testimonial_name" id="testimonial_name" value="<?php echo $testimonial_name; ?>"/>
        <span class="metabox_desc">Enter the Name of the person giving the testimonial</span></td>
        <td></td>
    </tr>
    <tr>
        <th class="metabox_th"><label for="testimonial_url">Testimonial URL:</label></th>
        <td><input class="input_text" type="text" name="testimonial_url" id="testimonial_url" value="<?php echo $testimonial_url; ?>"/>
        <span class="metabox_desc">Enter the URL of the person giving the testimonial</span></td>
        <td></td>
    </tr>
    <tr>
        <th class="metabox_th"><label for="testimonial_excerpt">Testimonial excerpt Text:</label></th>
        <td><textarea class="input_textarea" name="testimonial_excerpt" id="testimonial_excerpt"><?php echo $testimonial_excerpt;?></textarea>
        <span class="metabox_desc">Enter the text for the exceprt</span></td>
        <td></td>
    </tr>
  </table>
  <?php
}

add_action('save_post', 'save_details_testimonial');

function save_details_testimonial(){
  global $post;
  
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['themeteam_testimonial'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;
  
  update_post_meta($post->ID, "testimonial_name", $_POST["testimonial_name"]);
  update_post_meta($post->ID, "testimonial_url", $_POST["testimonial_url"]);
  update_post_meta($post->ID, "testimonial_header", $_POST["testimonial_header"]);
  update_post_meta($post->ID, "testimonial_excerpt", $_POST["testimonial_excerpt"]);
}

add_action("manage_testimonial_custom_column",  "testimonial_custom_columns");
add_filter("manage_edit-testimonial_columns", "testimonial_edit_columns");
 
function testimonial_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Testimonial Title",
    "description" => "Description",
    "name" => "Name",
  );
 
  return $columns;
}
function testimonial_custom_columns($column){
  global $post;
  switch ($column) {
    case "description":
      the_excerpt();
      break;
    case "name":
      $custom = get_post_custom();
      echo $custom["testimonial_name"][0];
      break;
   }
}
/* END Testimonials Custom Post Type */
