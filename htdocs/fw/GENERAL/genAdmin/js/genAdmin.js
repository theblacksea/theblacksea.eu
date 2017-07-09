/**
 * Created with JetBrains PhpStorm.
 * User: ioana
 * Date: 2/6/15
 * Time: 8:19 PM
 * To change this template use File | Settings | File Templates.
 */

ivyMods.genAdmin = {
	textInput: function(jqInput, inputValue){
		jqInput.attr('value', inputValue);
	},
	checkboxInput:function (jqInput, inputValue){
		if(inputValue){
			jqInput.attr('checked', 'checked');
		}
	},
	bindUpdateItem: function(){
		var obj = this;
		$('.updateItem').bind('click',function(){

			var id      = $(this).data("id");
			var name    = $(this).data("name");
			var type    = $(this).data("type");
			var parents = $(this).data("parents");
			var menus   = $(this).data("menus");
			var formShow= $(this).data('show');
			var options = $(this).data('options');


			$('#'+formShow).show();

			if(typeof options == 'object'){
				for(var option in options){
					var jqInput = $("#options_"+option);
					var typeInput = jqInput.attr('type');

					var functionName = typeInput+"Input";
					var valueInput = options[option];

					/*console.log("typeInput = " + typeInput
								+ " functionName = " + functionName
								+ " valueInput =" +valueInput);*/

					if(typeof obj[functionName] == 'function'){
						obj[functionName](jqInput, valueInput);
					} else {
						console.log(functionName + " is not a function");
					}
				}
			} else {
				console.log((typeof options == 'object' ? "" : "no Object")
						+(options.length > 0 ? "" : "no items"));
			}

			//atentie la un moment dat vreau sa fac pentru mai multi parents
			// a se vedea queryurile din genAdmin
			var jqUpdateItem = $('#form-updateItem');
			$('#form-updateItem #id').attr('value',id);
			$('#form-updateItem #name').attr('value',name);
			$('#form-updateItem #type option[value='+type+']').attr('selected','selected');
			$('#form-updateItem #parents  option[value='+parents+']').attr('selected','selected');
			if(menus){
				$('#form-updateItem #menus').attr('checked','checked');
			}


			//alert(showId);
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		});

	},
	bindDeleteItem: function(){
		$('.deleteItem').bind('click', function(){
			var confirmMessage = $(this).data('message');
			var confirmation = confirm(confirmMessage);
			if(confirmation) {
				$(this).parents('form').submit();
			}
		});
	},
	sortedData: function(data){
		//alert(data);
	},
	sortableItems:function(){
		if(typeof $.sortable == 'function') alert("swe have sortable");
		$('#sortableItems').sortable({
		  delay: 150,
		  stop: function( event, ui ) {
			  //get the list whit the sorted elements
			  var sorted = $( "#sortableItems" ).sortable( "toArray" );

			  //get the node id
			  if(fmw.urlGet != 'undefined' && fmw.urlGet["idC"]){
				  var node = fmw.urlGet["idC"];
			  } else {
				  var node = 0;
			  }
			  //alert(node);
			  //configure the asincron object
			  var asyncsConf = new fmw.asyncConf({
				   dataSend:{
					   modName: "genAdmin",
					   methName: "jsSortItems"
				   },
				   restoreCore: true,
				   callBack :  {fn: ivyMods.genAdmin.sortedData,context: ivyMods.genAdmin, args: []}
			   });

			  //call the script
			  asyncsConf.fnpost({
				  "sorted": sorted,
				  "idC" : node
			  });

		  }
		});
	},
	init	: function(){
		this.bindUpdateItem();
		this.bindDeleteItem();
		this.sortableItems();
	}
};

$(document).ready(function () {
	ivyMods.genAdmin.init();
});
