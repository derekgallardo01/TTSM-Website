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
            <div class="wrapper-footer-one">
                <div id="footer-one" class="total-width"><div class="wrapper"><?php dynamic_sidebar('sidebar-footer-one'); ?></div></div>
            </div>
            <?php endif;
            
                if($active_column1 || $active_column2 || $active_column3): ?>
            <div class="wrapper-main-footer">
                <div id="main-footer" class="total-width">
                    <div class="wrapper">
                        <?php if($active_column1): ?>
                        <div class="column col1_<?php echo $case; ?>"><?php dynamic_sidebar('sidebar-footer-column-one'); ?></div>
                        <?php endif; ?>
                        <?php if($active_column2): ?>
                        <div class="column col2_<?php echo $case; ?>"><?php dynamic_sidebar('sidebar-footer-column-two'); ?></div>
                        <?php endif; ?>
                        <?php if($active_column3): ?>
                        <div class="column col3_<?php echo $case; ?>"><?php dynamic_sidebar('sidebar-footer-column-three'); ?></div>
                        <?php endif; ?>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="wrapper-copyright">
                <div id="footer-copyright" class="total-width"><p class="wrapper"><?php $theme_options = $sm_theme_options->get_theme_options(); echo $theme_options['footer_text']; ?></p></div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>