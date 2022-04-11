
var all_post_selected = {
    post: new Array(),
    page: new Array()
};

(function($){

	$(document).ready( function() {
        
        
        
        var exclude_posts = function(post_type) {
            return function() {
                inpt = $(this);
                var pos = all_post_selected[post_type].indexOf(inpt.val());
                if( inpt.is(':checked') ) {
                    all_post_selected[post_type].push(inpt.val());
                } else if(pos >= 0) {
                    delete all_post_selected[post_type][pos];
                }
                $('#select-'+post_type+' #input_'+post_type+'_exclude').val(all_post_selected[post_type].join(','));
            };
        };
        
        
        var load_values = function(index, domElemt) {
            _element = $(domElemt);
            if(_element.is(':checked')) {
                _element.trigger('change');
            }
        };
        
        var pages_excludes_click = exclude_posts('page');
        
        var posts_excludes_click = exclude_posts('post');
        
        $('#select-page .page_excludes').on('change', pages_excludes_click).each(load_values);
        $('#select-post .post_excludes').on('change', posts_excludes_click).each(load_values);
        
	});
})(jQuery);