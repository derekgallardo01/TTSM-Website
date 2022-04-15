<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); 
$content_class = 'full-width'; ?>
    <div id="wrapper-content">
        <div class="total-width">
            <div id="content" class="<?php echo $content_class.' '.apply_filters('sm_class_content', ''); ?>">
                <?php while(have_posts()): the_post(); ?>
                    <div class="post">
                        <h3 class="title-content"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-content"><?php the_content(); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>
<?php get_footer(); ?>