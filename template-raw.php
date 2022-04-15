<?php
/*
Template Name: Raw Template
*/
$content_class = 'full-width'; 

$filter = (isset($_REQUEST['raw'])) ? 'raw' : '';
if($filter != 'raw') {
    get_header();
}
?>
<div class="tmpl-raw">
    <div id="wrapper-content">
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
</div>
<?php if($filter != 'raw') {
    get_footer();
} ?>