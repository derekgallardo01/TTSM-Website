<?php get_header(); 
$content_class = 'full-width';

$shome1 = is_active_sidebar('sidebar-home-one');
$shome2 = is_active_sidebar('sidebar-home-two');
//$post_content = '';
?>
    <!--<div id="wrapper-content">
        <div class="total-width">
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?>">
                <?php while(have_posts()): the_post(); ob_start(); the_content(); $post_content = ob_get_clean(); ?>
                    <?php 
                        if(has_post_thumbnail()) {
                            the_post_thumbnail('full-width');
                        }
                    ?>
                <?php endwhile; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>-->
    <div class="sidebars-content">
        <div class="total-width">
            <div class="<?php echo apply_filters('sm_class_content', $content_class); ?>">
                <div class="post-content">
                    <?php while(have_posts()): the_post(); ?>
                    <?php the_content(); ?>
                    <?php endwhile; ?>
                </div>
                <?php if($shome1 || $shome2): ?>
                <div class="sidebars-home">
                    <div class="column col1"><?php dynamic_sidebar('sidebar-home-one'); ?></div>
                    <div class="column col2"><?php dynamic_sidebar('sidebar-home-two'); ?></div>
                    <div class="clr"></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>