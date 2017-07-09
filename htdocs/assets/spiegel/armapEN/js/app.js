var vizState={
	point:-1,
	ini:true,
	hoverEl: 0,
	swipeImg: -1,
	takeItEasy:false
};
var animTime=300;
var map, paneOpts, markers, iconSizeAttempt, iconAnchorAttempt;

$(document).ready(function () {
	
	// Feeding navigation
	var htmlNavElems='';
	var singleElem='';
	for( var i=0; i< pointsData.length; i++ ){
		htmlNavElems+='<li class="elem'+i+'"><span class="circle trans"></span>';
		htmlNavElems+='<div class="elem_inside trans"><span class="title">'+pointsData[i].city+'</span>';
		htmlNavElems+='<span class="country">('+pointsData[i].country+')</span></div></li>';
	}
	$('#navigation #main_elems').html( htmlNavElems );
	
	// EVENTS
	// Nav events 
	$('#navigation ul li').click(function(){
		var iPoint= parseInt($(this).attr('class').replace('elem',''));
		if ( $('#see_nav').is(':visible') ) $('#see_nav img').click();
		goToPoint( iPoint );
	});

	$('#see_nav img').click(function(){
		if( !$('#navigation #main_elems').is(':visible') ){ 
			$('#navigation #main_elems').addClass('watching');
		}else{
			$('#navigation #main_elems').removeClass('watching');
		}
	});

	$('#navigation .arr_nav').click(function(){
		var moveTo= ( $(this).attr('id')=='arr_prev' ) ? vizState.point-1 : vizState.point+1 ;
		if( moveTo==-1 ) moveTo=pointsData.length-1;
		if( moveTo== pointsData.length ) moveTo=0;
		goToPoint(moveTo);
	});
	
	// Info weapon events
	$('#gimme_info_weapon').click(function(){
		$('body').addClass('watching_weapon');
	});
	
	$('#close_weapon').click(function(){
		$('body').removeClass('watching_weapon');
	});
	
	$('#full_weapon .swipe_nav').click(function(){
		if( window.mySwipe ){
			var idNav = $(this).attr('id').replace('swipe_nav_','');
			var idWeapon;
			if(idNav=='next'){
				vizState.swipeImg = vizState.swipeImg + 1;
				window.mySwipe.next();
			}else{
				vizState.swipeImg = vizState.swipeImg - 1;
				window.mySwipe.prev();
			}
			
			if( vizState.swipeImg == 0 ){
				$('#full_weapon #swipe_nav_prev').hide();
				idWeapon='weapon';
			}else if(vizState.swipeImg==2){
				$('#full_weapon #swipe_nav_next').hide();
				idWeapon='weapon3';
			}else{
				$('#full_weapon .swipe_nav').show();
				idWeapon='weapon2';
			}
			
			// TODO: Aquí actualizamos info del arma
			$('#info_model .info_value').html( pointsData[ vizState.point ][ idWeapon ].model );
			$('#info_snumber .info_value').html( pointsData[ vizState.point ][ idWeapon ].snumber );
			$('#info_capacity .info_value').html( pointsData[ vizState.point ][ idWeapon ].capacity );
			$('#info_large .info_value').html( pointsData[ vizState.point ][ idWeapon ].large );
		}
	});
	
	
	// Init viz
	$('#navigation #arr_prev').addClass('no_sense');
	
	$('#info_model .info_prop').html( weaponInfoTxts.model );
	$('#info_snumber .info_prop').html( weaponInfoTxts.snumber );
	$('#info_capacity .info_prop').html( weaponInfoTxts.capacity);
	$('#info_large .info_prop').html( weaponInfoTxts.large);
	
	$('#info_point #gimme_info_weapon').text( contextElems.fullWeaponTxt );
	
	$('.leaflet-control-zoom a').attr('title','');
	
	$('#info_point h2').html( contextElems.iniTitle );
	if ( $('.container').width() < 400 ){
		$('#info_point #txt_point p').html( contextElems.iniTextSmart );
	}else{
		$('#info_point #txt_point p').html( contextElems.iniText );
	}
	
	$('#smart_ht h2').html( '<span class="tpoint">'+ contextElems.iniTitle1 + '</span><span class="cpoint">'+ contextElems.iniTitle2 +'</span>' );
	$('#info_point h2').html( '<span class="tpoint">'+ contextElems.iniTitle1 + '</span>: <span class="cpoint">'+ contextElems.iniTitle2 +'</span>' );

	
});

// MAP INIT
	map = L.map('map',{
		center: [48.876980, 18.005026],
		zoom: 10,
		zoomControl:false
	});

	paneOpts={
		animate: true,
		duration: 1,
		easeLinearity: 0.4
	};

	markers = [];

	L.control.zoom({position:'bottomright'}).addTo(map);

	L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
		subdomains:'abcd',
		maxZoom: 12,
		minZoom:5
	}).addTo(map);


	/* Starting minimap */
	var osm2 = new L.TileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
		subdomains:'abcd',
		maxZoom: 12,
		minZoom:2
	});

	var pubs2 = [];
	for( var i=0; i< pointsData.length; i++){
		pubs2[i]= new L.CircleMarker(pointsData[i].coords, {
			radius: 2, 
			color: '#5b5b5f', 
			opacity: 1,
			className: 'icon'+i} 
		);
	}

	var ps = L.layerGroup(pubs2);
	var layers=new L.LayerGroup([osm2, ps]);


	var miniMap = new L.Control.MiniMap(layers,{
			position:'topright',
			width: 100,
			height: 100,
			zoomAnimation:true
		}).addTo(map);

	/* end minimap js */
		
	iconSizeAttempt=[50,50];
	iconAnchorAttempt=[23,38];

	for(var i=0; i<pointsData.length; i++){
		
		var marker=L.marker(
				[pointsData[i].coords[0], pointsData[i].coords[1]],
				{idPoint: i }
			).addTo(map).on('click',clickMarker);
		
		var customIcon='img/' + (  pointsData[i].attempt ? 'attempt' : 'icon'   ) + '.png' ;
		if( pointsData[i].attempt ){
			marker.setIcon( L.icon({ 
				iconUrl: customIcon, 
				iconSize: iconSizeAttempt,
				iconAnchor: iconAnchorAttempt,
				className: 'icon'+i 
			}));
		}else{
			marker.setIcon( L.icon({ iconUrl: customIcon, className: 'icon'+i }) );
		}
		
		$('#map .leaflet-marker-pane .icon'+i).css('z-index','200');
		
		markers[i]=marker;
	}

function clickMarker(e){
	var ind=$(this)[0].options.idPoint;
	goToPoint( ind );
}

function goToPoint(ind){
	if( vizState.ini ){
		$('body').removeClass('ini');
		vizState.ini=false;
	}
	
	// Assign selected class to nav element
	$('#navigation li.selected').removeClass('selected');
	$('#navigation li.elem'+ind).addClass('selected');
	
	if(ind==0){
		$('#navigation #arr_prev').addClass('no_sense');
	}else if(ind==pointsData.length-1){
		$('#navigation #arr_next').addClass('no_sense');
	}else{
		if( $('#navigation #arr_prev').hasClass('no_sense') ) 
			$('#navigation #arr_prev').removeClass('no_sense');
		
		if( $('#navigation #arr_next').hasClass('no_sense') )
			$('#navigation #arr_next').removeClass('no_sense');
	}
	
	
	// Moving map
	map.panTo(  pointsData[ind].coords, paneOpts  );
	
	// Set info in header div
	$('#info_point_container').fadeOut(animTime,function(){
		$('h2.title_point').html( '<span class="tpoint">'+pointsData[ind].title + '</span> <span class="cpoint">(' + pointsData[ind].city + ', ' + pointsData[ind].country +')</span>' );
		$('#txt_point p').html( pointsData[ind].text );
		
		if( pointsData[ind].weapon ){
			var oWeapon= pointsData[ind].weapon;
			if( !$('#info_point').hasClass('with_weapon') )
				$('#info_point').addClass('with_weapon')
			
			if( pointsData[ind].weapon2 ){
				$('#full_weapon').addClass('severalWeapons');
				$('#full_weapon #full_img_container').addClass('swipe');
				
				var htmlSwipe='<div class="swipe-wrap">';
				htmlSwipe+='<div><img src="img/'+ pointsData[ind].weapon.img_id +'.png" /></div>';
				htmlSwipe+='<div><img src="img/'+ pointsData[ind].weapon2.img_id +'.png" /></div>';
				htmlSwipe+='<div><img src="img/'+ pointsData[ind].weapon3.img_id +'.png" /></div></div>';
				$('#full_weapon #full_img_container').html( htmlSwipe );
				
				var elemSw = document.getElementById('full_img_container');
				window.mySwipe = Swipe(elemSw, {});
				
				vizState.swipeImg=0;
				$('#full_weapon #swipe_nav_next').show();
				
			}else{
				window.mySwipe=null;
				vizState.swipeImg=-1;
				$('#full_weapon').removeClass('severalWeapons');
				$('#full_weapon #full_img_container').removeClass('swipe');
				$('#full_weapon #full_img_container').html('<img src="img/'+ oWeapon.img_id + '.png" />' );
				$('#full_weapon .swipe_nav').hide();
			}
			
			$('#info_model .info_value').html( oWeapon.model );
			$('#info_snumber .info_value').html( oWeapon.snumber );
			$('#info_capacity .info_value').html( oWeapon.capacity );
			$('#info_large .info_value').html( oWeapon.large );
			
		}else{
			if( $('#info_point').hasClass('with_weapon') )
				$('#info_point').removeClass('with_weapon')
		}
		
		$('#info_point_container').fadeIn(animTime);
	});
	
	// Remove selected the previous current point
	if( vizState.point!=-1 ){
		var prevCustomIcon='img/' + (  pointsData[vizState.point].attempt ? 'attempt' : 'icon'   ) + '.png' ;
		if( pointsData[vizState.point].attempt ){
			markers[vizState.point].setIcon( L.icon({ 
				iconUrl: prevCustomIcon, 
				iconSize: iconSizeAttempt,
				iconAnchor: iconAnchorAttempt,
				className: 'icon'+vizState.point
			}));
		}else{
			markers[vizState.point].setIcon(  L.icon({ iconUrl: prevCustomIcon, className: 'icon'+ vizState.point}) );
		}
		$('#map .leaflet-marker-pane .icon'+vizState.point).css('z-index','200');
	}
	
	// Set selected the clicked point
	var currentCustomIcon='img/' + (  pointsData[ind].attempt ? 'attempt_selected' : 'icon_selected'   ) + '.png' ;
	if( pointsData[ind].attempt ){
		markers[ind].setIcon(  L.icon({ 
			iconUrl: currentCustomIcon, 
			iconSize: iconSizeAttempt,
			iconAnchor: iconAnchorAttempt,
			className: 'icon'+ind
		}));
	}else{
		markers[ind].setIcon( L.icon({ iconUrl: currentCustomIcon, className: 'icon'+ind }) );
	}
	$('#map .leaflet-marker-pane .icon'+ind).css('z-index','2000');
	
	vizState.point=ind;
}

function sinSS(cad){
	return cad.replace(/\s{2,}/g,' ').trim();
}
