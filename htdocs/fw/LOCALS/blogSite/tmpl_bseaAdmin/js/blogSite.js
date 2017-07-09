/**
 * Created with JetBrains PhpStorm.
 * User: ioana
 * Date: 2/6/15
 * Time: 8:19 PM
 * To change this template use File | Settings | File Templates.
 */

ivyMods.blogSite = {
	init	: function(){
		$('.toggleHidden').bind('click',function(){
			var showId = $(this).data("show");
			//alert(showId);
			$("#"+showId).toggle();
		});
		if(fmw.preview != 'undefined' && fmw.preview){
			//alert('preview = true');
			$('form#previewPage').attr('action', '');
		}
	}
};

$(document).ready(function () {
	ivyMods.blogSite.init();
});
