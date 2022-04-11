<?php
/*
Template Name: Contact Us
*/
?>
<?php get_header('4'); 
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
<?php get_footer('3'); ?>