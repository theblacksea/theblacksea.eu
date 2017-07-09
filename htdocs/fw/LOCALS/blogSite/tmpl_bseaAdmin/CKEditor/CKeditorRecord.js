
CKEditor_addOns = {
	vars : {copy:''},
	createDomImages : function(files) {
		/**
	   * <img alt="A view from the top, seen by a broken window glass, of the Pitsunda beach at the Black Sea."
	   * class="pull-right" data-cke-saved-src="http://theblacksea.eu/RES/uploads/images/petrut/abkhazia/01.jpg"
	   * src="http://theblacksea.eu/RES/uploads/images/petrut/abkhazia/01.jpg" style="width: 1013px;">
	   */
		var HTMLpics = "";
	   for (var i = 0; i < files.length; i++) {
	      HTMLpics += "<img alt='' class='pull-right' " +
					            "data-cke-saved-src= '"+files[i]+"' " +
					            "src='"+files[i]+"' "+
		               ">";
	   }
		return HTMLpics;
	},
	getContainerImages: function(jQtextarea) {
		//var containterPics = jQtextarea.find('p');
		var containerPics = jQtextarea.find('p').first();
		if(containerPics.length == 0) {
			return jQtextarea.append("<p></p>");
		} else {
			return containerPics;
		}

	},
	openKCFinder: function(jQtextarea) {
		window.KCFinder = {
			callBackMultiple: function(files) {
			   window.KCFinder = null;
				var HTMLpics = CKEditor_addOns.createDomImages(files);
				//alert(HTMLpics);

			   var containerPics = CKEditor_addOns.getContainerImages(jQtextarea);
				containerPics.append(HTMLpics);

			}
		};
		window.open('/assets/ivy-kcfinder/browse.php?type=images&dir=RES/uploads/images',
		'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
		'directories=0, resizable=1, scrollbars=0, width=800, height=600'
		);
	},
	bindGalleryControls: function(jQGallery){
			// adding photos
			jQGallery.find('.addPhotos').bind('click', function(){
				CKEditor_addOns.openKCFinder(jQGallery);
			});

			//removing gallery
			jQGallery.find('.removeGallery').bind('click', function(){
				jQGallery.remove();
			});

			// coping gallery
			jQGallery.find('.copyGallery').bind('click', function(){
				CKEditor_addOns.vars.copy = jQGallery.find('img').parent().html();
				alert(CKEditor_addOns.vars.copy);
			});

			//pasting gallery
			jQGallery.find('.pasteGallery').bind('click',function(){
				//var containterPics = jQGallery.find('p');
				var containerPics = CKEditor_addOns.getContainerImages(jQGallery);
				containerPics.append(CKEditor_addOns.vars.copy);
				CKEditor_addOns.vars.copy = '';
				jQGallery.find('.pasteGallery').addClass('hidden');
				jQGallery.find('.copyGallery').removeClass('hidden');
			});
	},
	getGalleryDomControls: function(jQgallery){
		var images = jQgallery.find('img').length == 0 ? false : true ;
		//if there is an image in the gallery then we can copy the gallery
		var copyGallery =  images;
		// if there is no gallery copy && is an empty gallery => then we can paste
		var pastegallery = CKEditor_addOns.vars.copy != '' && !images ? true : false;
		var controls = "<div class='controls'>" +
							"<input type='button' value='add Photos' class='addPhotos'/> " +
							"<input type='button' value='remove' class='removeGallery'/> " +
							"<input type='button' value='paste' class='pasteGallery "+(pastegallery ? "" : "hidden")+"' />" +
							"<input type='button' value='copy' class='copyGallery "+(copyGallery ? "" : "hidden")+"'/> "+
							"</div>";

		return controls;
	},
	enableGallery: function(jQgallery){
		// teoretic aceste butoane ar trebui sa existe deja ,puse o singura data si
		// scoase in momentul in care CKEditor livreaza continutul , un fel de cleaning up data
		// si stiu ca exista asa ceva deja
		jQgallery.on(
		{
			'mouseenter':function(){
				if($(this).find('.controls').length == 0) {
					var controls = CKEditor_addOns.getGalleryDomControls($(this));
					$(this).prepend(controls );
					CKEditor_addOns.bindGalleryControls($(this));
				}
			},
			'mouseleave' :function(){
				//alert('mouseout');
				$(this).find('.controls').remove();
			}
		});
	},
	initGallery: function(){
		CKEDITOR.on( 'instanceReady', function( ev ) {

			var ckcontents =  $( ev.editor.window.getFrame().$ ).contents();
			var galleryCont = ckcontents.find( '.gallery' );
			CKEditor_addOns.enableGallery(galleryCont);
			/**
			 * Check to see if a editor has been added.
			 */
		   ev.editor.on('change', function(ev){
				var galleryCont = ckcontents.find( '.gallery' );
				if(galleryCont.length > 0) {
					CKEditor_addOns.enableGallery(galleryCont);
				}
			});

		});
	}
};

$(document).ready(function(){
	CKEditor_addOns.initGallery();
});