<?php
/**
 * Flexible Posts Widget: Default widget template
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;

if ( !empty($title) )
	echo $before_title . $title . $after_title;

if( $flexible_posts->have_posts() ):
?>
	<ul class="dpe-flexible-posts not-list-style not-padding not-margin">
	<?php while( $flexible_posts->have_posts() ) : 
        $flexible_posts->the_post(); global $post;
        $postid = get_the_ID();
        $author_name = get_post_meta($postid,'testimonial_name', true);
        $testimonial_url = get_post_meta($postid, 'testimonial_url', true);
    ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!--<a href="<?php echo the_permalink(); ?>">-->
				<?php
					if( $thumbnail == true ) { 
						// If the post has a feature image, show it
						if( has_post_thumbnail() ) {
							the_post_thumbnail( $thumbsize );
						// Else if the post has a mime type that starts with "image/" then show the image directly.
						} elseif( 'image/' == substr( $post->post_mime_type, 0, 6 ) ) {
							echo wp_get_attachment_image( $post->ID, $thumbsize );
						}
					}
				?>
				<!--<h4 class="title"><?php the_title(); ?></h4>-->
                <blockquote>
                    <div class="block">
                        <div><?php the_content(); ?></div>
                        <?php if( !empty($author_name) ) {
                            echo empty($testimonial_url) ? '<i class="author">'.$author_name.'</i>' : '<i class="author"><a target="_blank" href="'.$testimonial_url.'">'.$author_name.'</a></i>';
                        }?>
                    </div>
                </blockquote>
			<!--</a>-->
		</li>
	<?php endwhile; ?>
	</ul><!-- .dpe-flexible-posts -->
<?php else: // We have no posts ?>
	<div class="dpe-flexible-posts no-posts">
		<p><?php _e( 'No post found', 'flexible-posts-widget' ); ?></p>
	</div>
<?php	
endif; // End have_posts()
	
echo $after_widget;
