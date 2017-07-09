/*
 * @author Adrian Nitu <adrian.nitu at gmail.com>
 * @version 0.1 - mar.2013
 *			0.2 - mar.2014
 *
 */

/**
 * check if supplied object is a function (code from Underscore.js)
 * @param {type} object
 * @returns {Boolean}
 */
function isFunction(object) { return !!(object && object.constructor && object.call && object.apply); }

//function Icon() {}

var Icon = function(){}; //just a namespace, will act as a static class (no initializer)

Icon.lib = Icon.lib || [];
Icon.defer = Icon.defer || [];
Icon.path = Icon.path || "./icons/";

/**
 * loads async icon svg and inserts it on the specified dom object
 * TODO: poate ar fi mai normal sa incerc Icon.place() si trigger .load() in caz ca nu e in cache
 * @param {Number} id
 * @param {function} callback
 * @param {Object} dom - DOM Node or jQuery Object
 * @param {Number} size (the icon must have a square viewBox)
 * @param {Boolean} atEnd true
 * @returns {Boolean} success/fail
 */
Icon.load = function(id, callback, d, size, atEnd) {
	//param validation
	if (isNaN(id)) {
		return warn("Icon.load: Icon id " + id + " must be a Number! (eg. database id)");
	}
	if (!isFunction(callback)) {
		return warn("Icon.load: Invalid callback.");
	}
	/*if (!(dom instanceof jQuery)) {
		if (dom) {
			if (dom.nodeType !== 1)
				return warn("Icon.load: DOM parameter must be DOM or jQuery Object!");
			dom = jQuery(dom);
		} else
			return warn("Icon.load: DOM parameter must be DOM or jQuery Object!");
	}*/

	$(d.node).attr("icon", id); //save it for future access
	if (this.lib[id] == "loading") {
		this.defer.push({id:id, callback:callback, d:d, size:size, atEnd:atEnd});
	} else if (this.lib[id]) {
		// console.log("icon ", dom.icon, " already loaded");
		callback(this.lib[id], d, size, atEnd);
	} else {
		this.lib[id] = "loading";
		$.ajax({
//			url: this.path + id + ".svg",
			url: this.path + "flag_" + d.code + ".svg",
//			contentType: "image/svg+xml",
			context: this,
			success: function(data, textStatus, jqXHR) {
				this.lib[id] = jqXHR.responseText; //.replace(/#ffffff/gi, dom.css('color')); //color icon with custom color; not used anymore
				callback(this.lib[id], d, size, atEnd);
				for (i = 0; i < this.defer.length; i++) { //check for deferred calls
					if(this.defer[i].id==id){
						callback(this.lib[id], this.defer[i].d, this.defer[i].size, this.defer[i].atEnd);
						this.defer.splice(i--, 1);
					}
				}
			}
		});
	}
	return true;
};

Icon.place = function(data, d, size, atEnd) { //console.log("place", data, dom);
	size = size || 10;
	d.flag = $(data).filter("svg")
				.attr("x", -size / 2).attr("y", -size / 2)
				.attr("width", size).attr("height", size)
				[0];
	if (atEnd) $(d.node).append(d.flag);
	else $(d.node).prepend(d.flag);
};

//Icon.load(ui.draggable.context.getAttribute("icon"), Icon.place, $(this), r * .9, true);
//console.log(Icon.load('101', Icon.place, (".content"), 49, true));
