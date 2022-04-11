<?php


class SM_Select_Posts {
    
    function __construct() {
        
        add_shortcode('smposts', array($this, 'render'));
    }
     
    function render($attrs) {

        $defaults = array(
        	'link_title' => true,
            'show_thumbnail' => true,
        	'link_image' => true,
            'show_read_more' => true,
        	'read_more' => __('Learn More', 'spotmassage'),
        	'number_letters' => 200,
            'number_posts' => 4,
            'posts' => '',
            'order' => 'DESC',
            'orderby' => 'post_date',
            'count_row' => 4,
            'size_thumb' => 'small-home',
            'post_type' => 'page'
        );
        $args = shortcode_atts( $defaults, $attrs );
        ob_start();
        if(trim($args['posts'])) {
                        
            $posts = get_posts(array(
                'posts_per_page' => $args['number_posts'],
                'numberposts' => $args['number_posts'],
                'include' => $args['posts'],
                'order' => $args['order'],
                'orderby' => $args['orderby'],
                'post_type' => $args['post_type']
            ));
            echo '<ul class="sm-select-posts">';
            foreach($posts as $idx=>$the_post) {
                if($idx >= $args['number_posts']) {
                    continue;
                }
                
                $new_row = ($idx+1)%($args['count_row']+1) == 0;
                $isFirst = $new_row || $idx == 0;
                $isLast = ($idx+2)%($args['count_row']+1) == 0;
                
                if( $new_row ) {
                    echo '</ul><ul class="sm-select-posts">';
                }
                echo '<li class="'.($isFirst ? 'first item' : ($isLast ? 'last item' : 'item' ) ).'">';
                
                echo '<h3 class="title">'.$the_post->post_title.'</h3>';
                
                if( has_post_thumbnail($the_post->ID) && $args['show_thumbnail'] ) {
                    echo '<div class="thumb">';
                    if($args['link_image']) {
                        echo '<a href="'.get_permalink($the_post->ID).'">'.get_the_post_thumbnail($the_post->ID, $args['size_thumb']).'</a>';
                    } else {
                        echo get_the_post_thumbnail($the_post->ID, $args['size_thumb']);
                    }
                    echo '</div>';
                }

                
                $text = $the_post->post_excerpt ? strip_tags($the_post->post_excerpt) : strip_tags($the_post->post_content);

                if($text) {
                    //Remove the tags to the shortcode
                    $description = preg_replace('/.*\[.*\].*/', '', $text);

                    $description = substr($description, 0, $args['number_letters']);
                    echo '<div class="description">'.$description.'</div>';
                } else {
                    echo '<div class="description">&nbsp;<!-- Not found content --></div>';
                }
                
                
                if($args['show_read_more']) {
                    echo '<a class="read-more btn btn-crimson" href="'.get_permalink($the_post->ID).'">'.$args['read_more'].'</a>';
                }
                echo '</li>';
            }
            echo '</ul>';
            
        } else {
            _e('Not found posts', 'spotmassage');
        }
        return ob_get_clean();
    }
    
}

$sm_select_posts = new SM_Select_Posts();

?>