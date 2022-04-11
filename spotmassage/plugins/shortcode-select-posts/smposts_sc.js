jQuery(document).on('ready', init_smposts_sc);
function init_smposts_sc() {
	var max_height = 0;
	var each_lis = function(index, domElement){
		var height = jQuery(domElement).children('.description').height();
		if(height < max_height) {
			max_height = height;
		}
	};
	var each_uls = function(idx, domE) {
		var childs = jQuery(domE).children();
		if(childs.length > 0) {
			max_height = jQuery(childs[0]).height();
			childs.each(each_lis);
			if(max_height > 0) {
				childs.children('.description').height(max_height).css('overflow-y', 'hidden');
			}
		}
	};
	jQuery('.sm-select-posts').each(each_uls);
}