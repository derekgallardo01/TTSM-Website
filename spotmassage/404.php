<?php get_header(); 
$active_sidebar_right = is_active_sidebar('sidebar-right');
$content_class = $active_sidebar_right ? 'content-width' : 'full-width'; ?>
    <div id="wrapper-content">
        <div class="total-width">
            <div id="content" class="<?php echo apply_filters('sm_class_content', $content_class); ?>">
                <h3><?php _e('Page Not Found', 'spotmassage'); ?></h3>
                <?php get_search_form(); ?>
            </div>
            <?php get_sidebar(); ?>
            <div class="clr"></div>
        </div>
    </div>
<?php get_footer(); ?>