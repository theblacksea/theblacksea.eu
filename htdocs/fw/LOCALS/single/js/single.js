/**
 * Created with JetBrains PhpStorm.
 * User: ioana
 * Date: 11/29/13
 * Time: 4:43 PM
 * To change this template use File | Settings | File Templates.
 */

ivyMods.set_iEdit.single = function(){

	var pageDescSettings = {
		modName: 'single',
		saveBt: {
			attrValue: "save",
			methName: "savePage"
		}
	};

	iEdit.add_bttsConf( {
		sectionmission:  pageDescSettings,
		sectionabout: pageDescSettings,
		section: pageDescSettings
	});
}
$(document).ready(function () {
});