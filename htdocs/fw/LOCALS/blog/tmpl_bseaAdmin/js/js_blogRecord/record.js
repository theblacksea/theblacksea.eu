/**
 * Created with JetBrains PhpStorm.
 * User: ioana
 * Date: 2/6/15
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */
ivyMods.blog = {
	init	: function(){
		$('textarea[name=scripts]')
			.bind(
				{ 'focus': function(){
						$(this).width('390').height('350');
						$(this).parent().width('1000');
						$(this).next('#scriptTips').toggle();
				   },
					'blur' : function(){
						$(this).attr('style', '');
						$(this).parent().attr('style', '');
						$(this).next('#scriptTips').toggle();

					}
				}
		);
	}
};

$(document).ready(function () {
	ivyMods.blog.init();
});