/*
 * @author Adrian Nitu <adrian.nitu at gmail.com>
 * @version 0.1 -
 */

var bule;

$("#header .button-home")
	.on("click", function(){
		$("#video").removeClass("hidden");
		$("#details").addClass("hidden");
		$(".button-home").addClass("hidden");
		d3.selectAll("#bubbles svg use#show-selected-node").remove();
		window.location.hash = "";
		return false;
	})
	.on("mouseover mouseout", function(e){
		var over = (e.type == "mouseover");
		d3.select(this).select("img.icon:not(.over)")
			.classed("hidden", over);
		d3.select(this).select("svg.icon.over")
			.classed("hidden", !over);
	});

$(document).ready(function(){
	console.log('ready');
	//filterSelect = new Array("HoReCa","Finance","Food manufacture","Media","Transport","Football","Farming","Telecom");
	filterSelect = new Array("Farming");
	filter1 =new Array("Heavy Industry","Mining","Energy");
	filter2 = new Array("HoReCa","Finance","Food manufacture","Media","Transport","Football","Farming","Telecom");
//	filterSelect = "Heavy Industry";
	$.ajax({ url: './companies.json',
		success: function( data ) {
			bule = new Bubble(data);

			$("a#btn-"+filterSelect).addClass("selected");

		}
	});

});

/*$(window).load(function(){
	jQuery('#filters .button img.icon.over, #header .button-home img.icon.over').each(function(){
		var $img = jQuery(this);
		var imgID = $img.attr('id');
		var imgURL = $img.attr('src');

		jQuery.get(imgURL, function(data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');

			// Add replaced image's ID to the new SVG
			if(typeof imgID !== 'undefined')
				$svg = $svg.attr('id', imgID);

			if($img.parent().attr("id") == "btn-"+filterSelect) {
				$("#btn-"+filterSelect+" img.icon:not(.over)").addClass("hidden");
				$("#btn-"+filterSelect+" img.icon.over").removeClass("hidden");
			}

			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');
			$svg.attr("class", $img.attr('class'))
				.attr("width", $img.width())
				.attr("height", $img.height());

			// Replace image with new SVG
			$("*[fill='#EC1C24'],*[fill='#ec1c24']", $svg).attr("fill", "white");

			$img.replaceWith($svg);

		}, 'xml');
	});
});*/

