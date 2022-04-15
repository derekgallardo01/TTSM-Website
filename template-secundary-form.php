<?php
/*
Template Name: Secundary Form
*/
?>
<?php 
// functions.php:
do_action('sm_secundary_form_page');
get_header(); 
$content_class = 'full-width'; ?>
    <div id="wrapper-content" class="template-secundary-form">
        <div class="total-width">
            <div id="content" class="<?php echo $content_class.' '.apply_filters('sm_class_content', ''); ?>">
                <?php while(have_posts()): the_post(); ?>
                    <div class="post">
                        <h3 class="title-content"><?php the_title(); ?></h3>
                        <div class="post-content"><?php the_content(); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <?php if(is_active_sidebar('sidebar-form-secundary')): ?>
    <div class="sidebars-content">
        <div class="total-width">
            <div class="<?php echo $content_class.' '.apply_filters('sm_class_content', ''); ?>">
                    <div><?php dynamic_sidebar('sidebar-form-secundary') ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php get_footer(); ?>