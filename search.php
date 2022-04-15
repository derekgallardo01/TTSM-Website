<?php get_header(); 
$active_sidebar_right = is_active_sidebar('sidebar-right');
$content_class = $active_sidebar_right ? 'content-width' : 'full-width'; ?>
    <div id="wrapper-content">
        <div class="total-width">
            <?php 
            if( isset($_REQUEST['s']) && strlen($_REQUEST['s'])>1 ) {
                echo '<h2>'.sprintf("Search Results for '%s'", $_REQUEST['s']).'</h2>';
            } else {
                echo '<h2>'.__("Search Results").'</h2>';
            }
            ?>
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?>">
                <?php
                    if(have_posts()):
                        while(have_posts()): the_post(); ?>
                        <div class="post">
                            <h3 class="title-content"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="post-excerpt"><?php the_excerpt(); ?></div>
                        </div>
                <?php
                        endwhile;
                    else:
                ?>
                    <h3><?php _e('Not Found Results', 'spotmassage'); ?></h3>
                <?php endif; ?>
            </div>
            <?php get_sidebar(); ?>
            <div class="clr"></div>
        </div>
    </div>
<?php get_footer(); ?>