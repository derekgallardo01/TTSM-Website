<div class="searchform">
    <form action="/" method="get">
        <input class="input-search" type="text" name="s" 
        	value="<?php echo (isset($_REQUEST['s']))? $_REQUEST['s'] : '' ?>" 
        	placeholder="<?php _e('Enter a search term', 'spotmassage'); ?>" />
        <input class="btn-search" type="submit" value="" />
        <div class="clr"></div>
    </form>
    <div class="clr"></div>
</div>