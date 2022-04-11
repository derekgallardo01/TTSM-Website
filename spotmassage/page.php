<?php get_header(); 
$content_class = 'full-width';

$shome1 = is_active_sidebar('sidebar-home-one');
$shome2 = is_active_sidebar('sidebar-home-two');
//$post_content = '';
?>
<?php get_header(); 
$active_sidebar_right = is_active_sidebar('sidebar-right');
$content_class = $active_sidebar_right ? 'content-width' : 'full-width'; ?>
    <div id="wrapper-content">
        <div class="total-width">
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?>">
                <?php while(have_posts()): the_post(); ?>
                    <div class="post">
                        <h3 class="title-content"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-content"><?php the_content(); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php get_sidebar(); ?>
            <div class="clr"></div>
        </div>
    </div>
    <div class="sidebars-content">
        <div class="total-width">
                <?php if($shome1 || $shome2): ?>
                <div class="sidebars-home">
                    <div class="column col1"><?php dynamic_sidebar('sidebar-home-one'); ?></div>
                    <div class="column col2"><?php dynamic_sidebar('sidebar-home-two'); ?></div>
                    <div class="clr"></div>
                </div>
                <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>