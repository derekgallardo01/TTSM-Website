        <?php
        global $sm_theme_options;
        
        $active_column1 = is_active_sidebar('sidebar-footer-column-one');
        $active_column2 = is_active_sidebar('sidebar-footer-column-two');
        $active_column3 = is_active_sidebar('sidebar-footer-column-three');
        $case = '3';
        if($active_column1 && !$active_column2 && !$active_column3) {
            $case = 'cols1';
        } elseif(!$active_column1 && $active_column2 && !$active_column3) {
            $case = 'cols2';
        } elseif(!$active_column1 && !$active_column2 && $active_column3) {
            $case = 'cols3';
        } elseif($active_column1 && $active_column2 && !$active_column3) {
            $case = 'cols12';
        } elseif(!$active_column1 && $active_column2 && $active_column3) {
            $case = 'cols23';
        } elseif($active_column1 && !$active_column2 && $active_column3) {
            $case = 'cols13';
        }
        ?>
        <div id="footer">
            <?php if(is_active_sidebar('sidebar-footer-one')): ?>

            <?php endif;
            
                if($active_column1 || $active_column2 || $active_column3): ?>
            <div class="wrapper-main-footer">

            </div>
            <?php endif; ?>
            <div class="wrapper-copyright">
                <div id="footer-copyright" class="total-width"><p class="wrapper"><?php $theme_options = $sm_theme_options->get_theme_options(); echo $theme_options['footer_text']; ?></p></div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>