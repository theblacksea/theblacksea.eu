<!DOCTYPE html xmlns:fb="http://ogp.me/ns/fb#">
<html>
	<head>
		<title>JailCrunch</title>
		<meta charset="UTF-8">
        <meta property="og:image" content="https://reportingproject.net/JailCrunch/icons/demo.jpg" />
		<!--<meta name="viewport" content="width=device-width">-->
		<meta name="viewport" content="width=device-width, maximum-scale=1.5, initial-scale=0.85 user-scalable=1" />
		<link type="text/css" rel="stylesheet" href="css/video.css"/>
		<script type="text/javascript" src="js/box2d.js"></script>
		<script type="text/javascript" src="js/embox2d-helpers.js"></script>
		<script type="text/javascript" src="js/d3.js"></script>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.tipsy.js" ></script>
		<script type="text/javascript" src="js/underscore-min.js"></script>
		<script type="text/javascript" src="js/icons.js"></script>
		<script type="text/javascript" src="js/b2bubble.js"></script>
         <script type="text/javascript" src="js/topojson.js"></script>
	</head>
	<body>
    <div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=496105023832253";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
		<div class="layout">
			<div id="header">
            	<div class="logo">
				<a href="//reportingproject.net/occrp/"  target="_blank" title="Organized Crime and Corruption Reporting Project">
					<img src="icons/occrp_white.png" alt="OCCRP">
				</a>
              
                </div>
				<p class="title">
					<span class="title-red">Jail</span>Crunch
					<a href="/JailCrunch/" class="button-home">
						<img src="icons/icon_home.svg" class="icon" alt="home">
						
					</a>
				</p>
			</div>
            <br>
            <div id="video"><div class="title">Interviews from the inside</div><p>OCCRP journalists conducted dozens of interviews with convicted criminals throughout Eastern Europe. The videos are an extension of the Jail Crunch visualization and provide a personal window into how crime works in the region. Every few weeks, OCCRP will release a new inmate interview shedding light on how common crimes work across Eastern Europe.</p><hr></div> 
			<div style="width:1020px; margin:0 auto; font-family:oswald_light;">
            	<?php 
				$variable = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?playlistId=PLmiP83F9_FxpADlkdOITw1aJ6q4QhK32s&key=AIzaSyBdPziYCtpimlN0rumDY2x32AQPgBcI6Js&fields=items&part=snippet,contentDetails&maxResults=50');
$decoded = json_decode($variable);
$filme = $decoded->items;
				?>
                
                 <? // }
		$idul = -1;
		if(isset( $_GET["id"])){ 
		$idul =$_GET["id"];
		$video =  $decoded->items[$idul];
	?>
    
<iframe id="ytplayer" type="text/html" width="1000px" height="500px" src="https://www.youtube.com/embed/<? echo $video->contentDetails->videoId; ?>?showinfo=0&autohide=1&color=white&theme=light&autoplay=1" frameborder="0" allowfullscreen>
    </iframe> 
     <div class='title'><h1><?php echo $video->snippet->title; ?></h1></div>
     
    <p><?php echo $video->snippet->description; ?></p>
  
         
        </div>
       <hr>
    <?php } ?>
<br />

<div class='title'><h2>All the interviews</h2></div>
<script>
function goto ( url ) {
		window.location=url;
}
</script>
<?php
	$start = 0;

 for ($i = $start;$i< count($filme);$i++) { 
	 if($i != $idul) {
	 ?>
	
	  <div class="rest_left" style="float:left; width:320px; padding:20px 20px 0 0;" onclick="goto('/JailCrunch/video.php?id=<?php echo $i; ?>');">
		<div class="restpost">
		  <div id="post-" >
	   
			<?php echo "<img src='".$decoded->items[$i]->snippet->thumbnails->medium->url."'>"; ?>
		<div><?php echo $decoded->items[$i]->snippet->title; ?></div>
			
		</div>
		</div>
	  </div>
<?php 
	  } 
  } 
?>
            
			<div id="details" class="hidden">
				<div class="map"><div id="homemap"></div>
<script>
function addmap(iso) {
d3.selection.prototype.moveToFront = function() {
  return this.each(function(){
    this.parentNode.appendChild(this);
  });
};

var width = 350,
    height = 350, centered;
var color = d3.scale.category10();
var projection = d3.geo.mercator()
    .translate([0, 0])
    .scale((height / 2 / Math.PI)*20);

/*var zoom = d3.behavior.zoom()
    .scaleExtent([10, 11])
    .on("zoom", move);
*/
var path = d3.geo.path()
    .projection(projection);
//var svg = d3.select("#homemap").append("svg")
 d3.select("#innermap")
       .remove();
window.harta = d3.select("#homemap").append("svg")
   .attr ("id","innermap")
   .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
	.style("margin-top", "100px");
    /*.call(zoom);*/

var g = window.harta.append("g");

/*svg.append("rect")
    .attr("class", "overlay")
    .attr("x", -width / 2)
    .attr("y", -height / 2)
    .attr("width", width)
    .attr("height", height);
*/
var maxflag= 20;
var valx, valy;
d3.json("/media/tests/world-110m2.json", function(error, world) {
  var countries = topojson.feature(world, world.objects.countries).features,
      neighbors = topojson.neighbors(world.objects.countries.geometries);
  g.selectAll("path")
    .data(countries)
    .enter().insert("path", ".graticule")
		.attr("class", "countryInner")
		.attr("d", path)
		.style("fill", function(d, i) { return iso == d.id ? "#ec1c24" : "black"; })
		.style("opacity", function(d, i) { return iso == d.id ? "0.8" : "0.3"; })
	 .style("background-image", function(d, i) {
			return "url(icons/bgmap.png)";
 		});
	g.selectAll('path').each(function(d) {
		var centroid = path.centroid(d);
			x = centroid[0];
			y = centroid[1];

		if(iso == d.id) {
			valx = -x;
			valy = -y;
			g.transition()
			  .duration(500)
			  .attr("transform", "scale(" + 1 + ")translate(" + valx + "," + valy + ")")
			  .style("stroke-width", 1.5 / 1 + "px");
		}
	});
});
}
</script></div>
				<div class="title">Bosnia and hertegovina</div>
				<div class="total">
					<div class="population">
						Population in jails <span class="count">0.05 %</span>
					</div>
					Total Inmates <span class="count">12,345</span>
				</div>
				<div class="gender">
					<div class="bar">
						<div class="male"></div>
					</div>
					<div class="female">
						<span class="count">30%</span>
						Female
					</div>
					<span class="count">70%</span>
					Male
				</div>
<!--				<div class="occupation">
					<span class="count">12%</span>
					Prison Sub-Capacity by
				</div>-->
				<div class="tree_title">MAJOR CRIME CATEGORIES</div>
				<div class="tree"></div>
				<div class="pdf">
					<p>Download raw data:</p>
					<a href="#" target="_blank">
						<img src="icons/pdf_icon.png" class="icon" alt="Download PDF">
					</a>
				</div>
			</div>
		</div>
		<script>
			var bule;
			$(".button-about")
					.on("click", function(){
						$("#about").removeClass("hidden");
						$("#details").addClass("hidden");
						$("#video").addClass("hidden");
						$(".button-home").removeClass("hidden");
						d3.selectAll("#bubbles svg use#show-selected-node").remove();
						return false;
					});
			/*$("#header .button-home")
					.on("click", function(){
						$("#video").removeClass("hidden");
						$("#details").addClass("hidden");
						$("#about").addClass("hidden");
						$(".button-home").addClass("hidden");
						d3.selectAll("#bubbles svg use#show-selected-node").remove();
						return false;
					})
					.on("mouseover mouseout", function(e){
						var over = (e.type == "mouseover");
						d3.select(this).select("img.icon:not(.over)")
							.classed("hidden", over);
						d3.select(this).select("svg.icon.over")
							.classed("hidden", !over);
					});
					*/

			$(document).ready(function(){
				filterSelect = "total";
				$.ajax({ url: './data.json',
					success: function( data ) {
						bule = new Jailistan(data);
						if(window.location.hash.length > 1) {
							var country = window.location.hash.split("-");
							if (typeNames[country[1]]) {
								filterSelect = country[1];
								 $( "#btn-"+country[1] ).addClass("selected");
								 $("#explain")[ $( "#btn-"+country[1] ).prop("id") == "btn-total" ? "removeClass":"addClass"]("hidden");
									var name =  $( "#btn-"+country[1] +" span").html();
								$("#explain2").html("Percentage of inmates convicted of <span style='color:#ED1C24;'>"+name+"</span> out of national convict population.");
								$("#explain2")[ $( "#btn-"+country[1] ).prop("id") == "btn-total" ? "addClass":"removeClass"]("hidden");
								//bule.menuOver.call($("#btn-"+country[1]).get(0), true);
								//bule.menuOver.call($("#btn-total").get(0), false);
								$("#btn-total").removeClass("selected");
								//bule.switchType($("#btn-"+typeNames[country[1]]));
								/*$("#filters").delegate( "#btn-"+country[1] , "myCustomEvent", bule.switchType);
								 $( "#btn-"+country[1] ).trigger( "myCustomEvent" );*/
							}
							//console.log(bule.reset());
								
						} else {
							$("#video").removeClass("hidden");
							$("#details").addClass("hidden");
						}
						$("a#btn-"+filterSelect).addClass("selected");
						bule.reset();
						if(window.location.hash.length > 1) {
							console.log((window.location.hash));
							
							console.log(country[0].substr(1));
							d3.selectAll("#bubbles g.bubble").each(function(d) {
							console.log(d.country);
							if(d.country == country[0].substr(1).replace(/_/g, " "))
								
								bule.selectCountry.call(this, d);
							});
						}
					}
				});

			});
			$(window).load(function(){
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
			});

		</script>

        
        <div class="hidden"><img src="icons/demo.jpg"></div>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49759900-1', 'reportingproject.net');
  ga('send', 'pageview');

</script>
	</body>
</html>
