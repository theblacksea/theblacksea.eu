
ivyMods.profile = {
	init: function(){		},

	changePic: function (param) {
		param.jqObj_img.attr('src', param.newUrl);
		param.jqObj_img.parent().next('input[type=hidden]').val(param.newUrl);
	},

	loadPic: function (id) {

		//alert($('img#'+id).attr('src'));
		//var jqImg = $('img#'+id);
		fmw.KCFinder_popUp({
			jqObj_img: $('img#' + id),                  //img-ul al carui url va fi schimbat cu noua imagine aleasa
			callBackFn: ivyMods.profile.changePic   //functie apelata dupa ce a fost selectata o imagine
		})
	}
}

$(document).ready(function () {
	//ivyMods.profile.init();

});