/*
 * @author Adrian Nitu <adrian.nitu at gmail.com>
 * @version 0.1 - mar.2014
 */
window.FPS = 25;

$.fn.tipsy.defaults = {
	delayIn: 80, // delay before showing tooltip (ms)
	delayOut: 0, // delay before hiding tooltip (ms)
	fade: true, // fade tooltips in/out?
	fallback: '', // fallback text to use when no tooltip text
	gravity: 'sw', // gravity
	html: false, // is tooltip content HTML?
	live: false, // use live event support?
	offset: 0, // pixel offset of tooltip from element
	opacity: 1, // opacity of tooltip
	title: 'title', // attribute/callback containing tooltip text
	trigger: 'hover' // how tooltip is triggered - hover | focus | manual
};


function Jailistan(data) {
	b2ratio = 30;

	var world = null,
		run = true;

	var w = 740, h = 650;
	var bubble = {min:50, max:80, spacer:3};
	var svg = d3.select("#bubbles").append("svg:svg")
			.attr("width", w)
			.attr("height", h)
		.append("svg:g")
			.attr("transform", "translate(" + (w/2) + "," + (h/2) + ")");
	var selected = d3.select("#bubbles > svg").append("svg:defs")
						.append("svg:circle").attr("id", "country-select").attr("r", 60)
							.attr("fill", "none").attr("stroke", "white")
							.attr("stroke-width",2).attr("stroke-dasharray", "2,2");
	var rollover = d3.select("#bubbles > svg").append("svg:defs")
						.append("svg:circle").attr("id", "country-over").attr("r", 60)
							.attr("fill", "none").attr("stroke", "white")
							.attr("stroke-width",2).attr("stroke-dasharray", "10,2");
	d3.select("#bubbles > svg > defs")
					.append("svg:circle")
					.attr("id", "country-count-bg").attr("r", 32)
					.attr("fill", "rgba(255,255,255, 0.75)");

	var nodes = [], treemap;
	var ratio = {	total: 32,
					murder: 5,
					rape: 18,
					theft: 2,
					traffic: 52,
					drugs: 5,
					financial: 6
				};
	var isos = {	"ALBANIA": 008,
					"BOSNIA AND HERZEGOVINA": 070,
					"CZECH REPUBLIC": 203,
					"HUNGARY": 348,
					"LATVIA": 428,
					"LITHUANIA": 440,
					"KOSOVO": -2,
					"MOLDOVA": 498,
					"ROMANIA": 642,
					"SERBIA": 688,
					"TURKEY": 792,
					"UKRAINE": 804
				};
	typeNames = {	total: "Total",
						murder: "Murder",
						rape: "Rape",
						theft: "Theft",
						traffic: "Human Trafficking",
						drugs: "Drug Trafficking",
						financial: "Financial Crimes"
					};

	this.reset = reset;
	function reset() {
		if(!data.countries) return;

		for(var i in data.countries) {
			for(var c in data.countries[i]){
				if(c == "type")
					for(var t in data.countries[i][c])
						data.countries[i][c][t] = parseInt(data.countries[i][c][t]);
				else if(["country", "iso"].indexOf(c) < 0)
					data.countries[i][c] = parseInt(data.countries[i][c]);
			}
		}
		using(Box2D, "b2.+");
		createWorld();
		setNodesType(filterSelect);

		var bule = svg.selectAll("g.bubble")
						.data(nodes)
						.enter().append("svg:g")
							.attr("class", "bubble")
							.attr("r", function(d) { return (d.radius || bubble.spacer) - bubble.spacer; })
							.attr("opacity", function(d) { return ( d.value ? 1:0 )} )
							.on("mouseover", function(d) {
								rollover.attr("r", d.radius);
								d3.select(this).append("svg:use")
									.attr("xlink:href", "#country-over").attr("id", "show-over-node");
							})
							.on("mouseout", function(d) {
								//d3.select(this).select("svg:use").remove();
								d3.select(this).selectAll("use#show-over-node").remove();
									//.attr("xlink:href", "#country-select").attr("id", "show-selected-node");
							})
							.on("click", selectCountry);
			//				.style("fill", "red")
		bule.append("svg:title").text(function(d) { return d.country; });
		bule.each(function(d,i) {
			d.node = this;
			Icon.load(i, Icon.place, d, ((d.radius || bubble.spacer) - bubble.spacer) * 2, false);
			d.body = addBubble(d.radius, null, -800 - Math.random()*500, -200 + Math.random() * 400);

			d3.select(this).append("svg:use")
				.attr("xlink:href", "#country-count-bg");
			var txt = d3.select(this).append("svg:text")
							.attr("text-anchor", "middle")
							.attr("class", "country_count")
							.attr("y", 11);
			txt.append("svg:tspan")
					.attr("class", "number");
//					.text("20.5");
			txt.append("svg:tspan")
					.attr("class", "percent hidden")
					.text("%");
//				.attr("font-size", 26)
//				.attr("font-family", "oswald_stencil")

		});
		setNodesType(filterSelect); //console.log(nodes);
		//$("a#btn-total").addClass("selected");
//		menuOver($("a#btn-total").get(0), true);

		treemap = d3.layout.treemap()
			.size([710, 225])
			.sticky(false)
			.value(function(d) { return d.size; });

//		$("#filters .button").on("click", switchType);
		$("#filters")
			.delegate(".button:not(.selected)", "click touchstart", switchType)
			.delegate(".button:not(.selected)", "mouseover mouseout", function(e){
				menuOver(this, e.type == "mouseover");
			});
		$(document).on("scroll", onWindowResize);
		$(window).on("resize", onWindowResize).resize();

		animate();
	};

	function onWindowResize() {
		$("#header .title").css("margin-left", $(document).scrollLeft());
		$("#header .logo").css("margin-right", $(document).width() - window.innerWidth - $(document).scrollLeft());
	}
	var menuOver = menuOver;
	function menuOver(node, value){
		d3.select(node).select("img.icon:not(.over)")
			.classed("hidden", value);
		d3.select(node).select("svg.icon.over")
			.classed("hidden", !value);
	}

	this.selectCountry = selectCountry;
	function selectCountry(d){
		var rec = _.find(data.countries, function(c){ return c.iso == d.code;});
//		console.log(d, rec);
		selected.attr("r", d.radius);
		svg.selectAll("use#show-selected-node").remove();
		d3.select(this).append("svg:use")
			.attr("xlink:href", "#country-select").attr("id", "show-selected-node");

		$("#details .title").text(d.country);
		$("#details .total .count").text(digit_grouping(rec.total));
		if(_.isNaN(parseInt(rec.female)) || _.isNaN(parseInt(rec.total))) {
			$("#details .gender .count").text("N/A");
			$("#details .gender .bar .male").animate({width: "50%"});
		} else {
			$("#details .gender .female .count").text(toFixed(100 * rec.female / rec.total, 2) + "%");
			$("#details .gender > .count").text(toFixed(100 * (1- rec.female / rec.total), 2) + "%");
			$("#details .gender .bar .male").animate({width: String(100 * (1- rec.female / rec.total)) + "%"});
		}
		if(_.isNaN(parseInt(rec.total))) {
			$("#details .occupation .count,#details .population .count").text("N/A");
			$("#details .population .bar .capacity").width("100%");
		} else {
			$("#details .population .count").text(toFixed(100 * rec.total / rec.population, 2) + " %");
			/*if(_.isNaN(parseInt(rec.capacity))) {
				$("#details .occupation .count").text("N/A");
				$("#details .population .bar .capacity").width("100%");
			} else {
				$("#details .occupation .count").text(toFixed(100 * (rec.capacity - rec.total) / rec.capacity, 2) + "%");
				$("#details .population .bar .capacity").width(String(100 * rec.total / rec.capacity) + "%");

			}*/
		}

		addmap(isos[d.country]);
		addTreemap(rec);
		$(".pdf a").prop("href", "documents/" + d.code + "_proof.pdf");
		$("#details").removeClass("hidden");
		$("#video").addClass("hidden");
		$(".button-home").removeClass("hidden");
		var theHash = window.location.hash.split("-");
		var pagina = "";
		if(theHash[1]) {
			pagina = "-"+theHash[1];
		}
		window.location.hash = '#' + String(d.country).replace(/\s/g, "_")+pagina;
		$("html,body").animate({
				scrollLeft: $("#details").offset().left + Math.min(0, $("#details").width() - $(window).width())
			}, 500);
	}

	function setNodesType(type) {
		for (i = data.countries.length - 1; i >= 0; i--) {
			var node = nodes[i] || { country: data.countries[i].country, code: data.countries[i].iso };
			if(type == "total")
				node.value = toFixed(1000 * parseInt(data.countries[i][type]) / parseInt(data.countries[i].population), 2);
			else
				node.value = 100 * parseInt(data.countries[i].type[type]) / parseInt(data.countries[i].total);
			if(_.isNaN(node.value))
				node.radius = node.value = 0;
			else
				node.radius = Math.max(48, Math.round(ratio[type] * node.value));
			nodes[i] = node;
//			console.log(nodes[i].country, node.value);
			d3.select(nodes[i].node).select("text.country_count .number")
					.text(toFixed(node.value, node.value < 0.1 ? 2:1));
			d3.select(nodes[i].node).select("text.country_count .percent")
					.classed("hidden", type == "total");
		}
//		svg.selectAll("g.bubble")
	}
	this.switchType = switchType;
	function switchType(e) {
		$(this).addClass("selected");
		menuOver($(this).get(0), true);
		$menu = $(this).siblings(".selected");
		menuOver($menu.get(0), false);
		$menu.removeClass("selected");
		$("#explain")[$(this).prop("id") == "btn-total" ? "removeClass":"addClass"]("hidden");

		var name = $("#"+e.currentTarget.id+" span").html();
		$("#explain2").html("Percentage of inmates convicted of <span style='color:#ED1C24;'>"+name+"</span> out of national convict population.");
		$("#explain2")[$(this).prop("id") == "btn-total" ? "addClass":"removeClass"]("hidden");
		setNodesType(String(e.currentTarget.id).replace("btn-", ""));
		svg.selectAll("g.bubble")
			.each(function(d){
				var r = ((d.radius || bubble.spacer) - bubble.spacer) * 2 || 0.1;
//					console.log(d.country, r, d.flag);
//				if(!d.flag) return;
				d.body = addBubble(d.radius, d.body);
				d3.select(this)
					.transition().duration(400)
						.attr("opacity", d.value ? 1:0);
//						.attr("opacity", parseFloat(toFixed(d.value, 1)) ? 1:0);
				d3.select(this)
						.select("svg")
					.transition().duration(600)
						.attr("width", r).attr("height", r)
						.attr("x", -r/2).attr("y", -r/2);
				if(d3.select(this).select("use#show-selected-node")[0][0])
					selected.transition().duration(600)
						.attr("r", d.radius);

			});
		$("html,body").animate({ scrollLeft: 0}, 500);
		animate();
//		force.start();
		var pagina = "";
		var theHash = window.location.hash.split("-");
		if(theHash[0]) {
			pagina = theHash[0];
		}
		var pagina2 = "";
		if($(this).prop("id") != "btn-total") {
			var pag = $(this).prop("id") .split("-");
			pagina2 = "-"+pag[1];
		}
		window.location.hash = pagina+pagina2;
		return false;
	};

	function addTreemap(c){
//		$("#details .tree").empty();
		var map = {name: "crimes", children:[]};
		var sum = 0;
		for(var t in c.type) {
			map.children.push({name: t, size: c.type[t]});
			sum+=c.type[t];
		}
		var other = c.total-sum;
		//map.children.push({name: "other", size: other});

		var node = d3.select("#details .tree")
					.selectAll(".node")
					.data( treemap.nodes(map) );

		var detail = node.enter().append("div")
						.attr("class", "node")
						.each(function(d){
							$(this).tipsy({html: true, offset: 0, delayOut: 250});
						})
						.call(addTreemapCell)

		var det = detail.append("div")
							.attr("class", "detail center")
							.style("opacity", 0)
							.style("background-image", function(d){
								return d.children ? false : "url(icons/icon_" + d.name + ".svg)";
							})
		det.append("div").attr("class", "value");
		det.append("div")
				.attr("class", "name")
				.text(function(d){ return typeNames[d.name]; });

		detail.append("div")
				.attr("class", "center")
				.style("background-image", function(d){
								return d.children ? false : "url(icons/icon_zoom.svg)";
							})
//			.style("background", function(d) { return d.children ? color(d.name) : null; })
//			  .text(function(d) { return d.children ? null : d.name; });

		node.transition().duration(600)
				.call(addTreemapCell)
				.select(".detail")
					.call(addDetail);
		node.attr("title", function(d){
				return d.parent  ? d.value + " " + typeNames[d.name] : "";
			});
	}

	function addDetail(){
		this.style("margin-top", function(d) { return Math.max(0, d.dy - 65)/2 + "px"; })
			.style("max-width", function(d){ return (d.dx - 4) + "px"; })
			.style("opacity", function(d){
					return Number(d.dx > 105 && d.dy > 67 && !d.children);
				});
		$('div.zoom').addClass('hidden');
		this.select(".value")
				.text(function(d){ return d.parent ?  d.value+" "  : "100%"; });

	}

	function addTreemapCell(c) {

		this.style("left", function(d) { return d.x + "px"; })
			.style("top", function(d) { return d.y + "px"; })
			.style("width", function(d) { return Math.max(0, d.dx - 1) + "px"; })
			.style("height", function(d) { return Math.max(0, d.dy - 1) + "px"; })
			.each(function(d){
				$(this).tipsy(d.dx > 105 && d.dy > 67 && !d.children ? 'disable':'enable');
			});
	}

	function createWorld() {
		if ( world != null )
			Box2D.destroy(world);

		world = new b2World( new b2Vec2(0.0, 0.0) );

		var walls = {
			top: createWall(-300, -330, 1400, 10),
			bottom: createWall(-300, 330, 1400, 10),
			right: createWall(375, 0, 10, 660)
		};

	}

	function createWall(x,y, w, h){
        var shape = new b2PolygonShape();
        shape.SetAsBox(w/b2ratio/2, h/b2ratio/2);

        var bd = new b2BodyDef();
        bd.set_type(b2_staticBody);
        bd.set_position( new b2Vec2(x/b2ratio, y/b2ratio));

        var body = world.CreateBody(bd);
        body.CreateFixture(shape, 0);
		body.GetFixtureList().SetRestitution(0.4);
		body.GetFixtureList().SetFriction(1);
		return body;
	}

	/*function createBubble(radius, x, y) {
		var shape = new b2CircleShape();
		shape.set_m_radius(radius/b2ratio);

        var bd = new b2BodyDef();
        bd.set_type(b2_dynamicBody);
		bd.set_position(new b2Vec2((x || 0) / b2ratio, (y || 0) / b2ratio));

        var body = world.CreateBody(bd);
        body.CreateFixture(shape, 0.01);
		body.GetFixtureList().SetRestitution(0.65);
		body.GetFixtureList().SetFriction(1);
		return body;
	}*/

	function addBubble(radius, body, x,y) {
		var shape = new b2CircleShape();
		shape.set_m_radius(radius/b2ratio);

		if(body)
			body.DestroyFixture(body.GetFixtureList());
		else {
			var bd = new b2BodyDef();
			bd.set_type(b2_dynamicBody);
			bd.set_position(new b2Vec2((x || 0) / b2ratio, (y || 0) / b2ratio));
			body = world.CreateBody(bd);
		}

        body.CreateFixture(shape, 0.65);
		body.GetFixtureList().SetRestitution(0.6);
		body.GetFixtureList().SetFriction(1);
		return body;
	}

//		var cnt = 0;
	function animate() {
		world.Step(1/(window.FPS), 10, 10);
		world.ClearForces();
		var gravity = 20;
		for (var b = world.GetBodyList(); b.a; b = b.GetNext()) {
			var dist = new b2Vec2(-190/b2ratio, 0); //distance from center
			dist.op_add(b.GetWorldCenter()); //console.log(dist.get_x(), dist.get_y());
			var finalDistance = dist.Length(); //console.log(finalDistance);

			dist = new b2Vec2(-dist.get_x() *.85, -dist.get_y() *.85);
			var vecSum = Math.abs(dist.get_x()) + Math.abs(dist.get_y());
			dist.op_mul((b.GetMass() * vecSum / 80) * gravity / finalDistance);

			b.ApplyForce(dist, b.GetWorldCenter());
		}
		draw();
		if (run)
			requestAnimFrame(animate);
//		else console.log("stop anim");
	}


	function draw() {
//		run = false;
		var moved = 0.0, maxDist = 0.0;
		svg.selectAll("g.bubble")
				.attr("transform", function(d){
//					run |= d.body.IsAwake();
					d.px = d.x || 0;
					d.x = d.body.GetPosition().get_x() * b2ratio;
					d.py = d.y || 0;
					d.y = d.body.GetPosition().get_y() * b2ratio;
					moved += Math.abs(d.px-d.x)+Math.abs(d.py-d.y);
					maxDist = Math.max(maxDist, Math.abs(d.px-d.x)+Math.abs(d.py-d.y));
					return "translate(" + d.x + "," + d.y + ")";
				});
		run = Boolean(moved > .6 || maxDist > .25);
	}




	//this.reset();
}

window.requestAnimFrame = (function(){
	return  window.requestAnimationFrame       ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame    ||
			window.oRequestAnimationFrame      ||
			window.msRequestAnimationFrame     ||
			function( callback ){
				window.setTimeout(callback, 1000 / window.FPS);
			};
})();


function toFixed(nr, dec) {
	return Number(nr).toFixed(dec);
}

function digit_grouping(nStr) {
	nStr += '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr)) {
		nStr = nStr.replace(rgx, '$1' + ',' + '$2');
	}
	return nStr;
}
