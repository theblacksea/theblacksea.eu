/*
 * @author Adrian Nitu <adrian.nitu at gmail.com>
 * @version 0.1 - mar.2014
 */
window.FPS = 25;

function Bubble(data) {
	b2ratio = 30;

	var world = null,
		run = true;

	var w = 740, h = 650;
	var bubble = {min:50, max:80, spacer:3};
	var radius = 48;
	var currType, currPeriod;
	var svg = d3.select("#bubbles").append("svg:svg")
			.attr("width", w)
			.attr("height", h)
		.append("svg:g")
			.attr("transform", "translate(" + (w/2) + "," + (h/2) + ")");
	var selected = d3.select("#bubbles > svg").append("svg:defs")
						.append("svg:circle").attr("id", "country-select").attr("r", 60)
							.attr("fill", "none").attr("stroke", "black")
							.attr("stroke-width",2).attr("stroke-dasharray", "2,2");
	var rollover = d3.select("#bubbles > svg > defs")
						.append("svg:circle").attr("id", "country-over").attr("r", 60)
							.attr("fill", "none").attr("stroke", "black")
							.attr("stroke-width",2).attr("stroke-dasharray", "10,2");
	d3.select("#bubbles > svg > defs")
				.append("svg:circle")
					.attr("id", "country-count-bg").attr("r", 48)
					.attr('style', 'fill: rgba(255,255,255, 0.5)')
					;
	d3.select("#bubbles > svg > defs")
				.append("svg:circle")
					.attr("id", "status-outline").attr("r", radius-7)
					.attr("stroke-width", 9)
//					.attr("stroke", 'red')
					.attr("fill", 'none');

	var nodes = [], treemap;
	var period ={start: new Date('1-Jan-2014'), end: new Date('30-Sep-2015')};
	var businessTypes = ["All", "Heavy Industry", "HoReCa", "Finance", "Food manufacture", "Media",
			"Transport", "Energy", "Football", "Farming", "Telecom", "Transport", "Mining"];

	var icons = [];

	var statusColor = {	"Operational": 'green',
						"Taken over": 'black',
						"Closed": 'red',
						"Reopened": 'green',
						"Liquidated": 'red',
						"Damaged": 'grey',
						"Destroyed": 'grey',
						"Moved to Kyiv": 'darkorange',
						"Moved to Zaporizhya": 'darkorange',
						"Moved to west Ukraine": 'darkorange',
						"N/A": "none"
					};

	var flags = {	"French": "FR",
					"Russian": "RU",
					"Russian/Norweigian": "RN",
					"Ukrainian": "UA",
					"American": "US",
					"German": "DE",
					"Austrian": "AT",
					"Italian": "IT"
				};
	typeNames = {	total: "Total",
					murder: "Murder",
					rape: "Rape",
					theft: "Theft",
					traffic: "Human Trafficking",
					drugs: "Drug Trafficking",
					financial: "Financial Crimes"
				};

	this.setNodesType = setNodesType;

	this.reset = reset;
	function reset() {
		if(!data.companies) return;

		//convert all dates to Date object
		for(var c in data.companies) {
			data.companies[c].date = data.companies[c].date == "" ? new Date() : parseDate(data.companies[c].date);
			data.companies[c].date2 = data.companies[c].date2 == "" ? new Date() : parseDate(data.companies[c].date2);
		}

//		var types =[];
//		for(var c in data.companies) {
//			if(types.indexOf(data.companies[c].status) < 0)
//				types.push(data.companies[c].status);
//			if(types.indexOf(data.companies[c].status2) < 0)
//				types.push(data.companies[c].status2);
//
//		}
//		console.log(types);

/*		for(var i in data.companies) {
			for(var c in data.companies[i]){
				if(c == "status" || c == "status2")
					for(var t in data.companies[i][c])
						data.companies[i][c][t] = parseInt(data.companies[i][c][t]);
				else if(["country", "iso"].indexOf(c) < 0)
					data.companies[i][c] = parseInt(data.companies[i][c]);
			}
		}*/

		using(Box2D, "b2.+");
		createWorld();
		currType = filterSelect;
		setNodesType(); //console.log(nodes);

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
							.on("click", selectCompany);
			//				.style("fill", "red")

		bule.append("svg:title").text(function(d) { return d.name; });
		bule.each(function(d,i) {
			d.node = this;
			if(icons.indexOf("flag_" + d.flag) < 0)
				icons.push("flag_" + d.flag);
			Icon.load(icons.indexOf("flag_" + d.flag), Icon.place, d, ((d.radius || bubble.spacer) - bubble.spacer) * 2, false, "flag_", "flag");

			d.type = getIconName(d.info.type);
			if(icons.indexOf("icon_" + d.type) < 0)
				icons.push("icon_" + d.type);
			Icon.load(icons.indexOf("icon_" + d.type), Icon.place, d, ((d.radius || bubble.spacer) - bubble.spacer) *0.8 , true, "icon_", "type");
			d.body = addBubble(d.radius, null, -800 - Math.random()*500, -200 + Math.random() * 400);
			console.log(icons);

			d3.select(this).append("svg:use")
				.attr("xlink:href", "#country-count-bg")
				.attr('class', "over");
			d3.select(this).append("svg:use")
				.attr("xlink:href", "#status-outline")
				.attr('stroke', statusColor[d.status])
				.attr('class', "status");
			//add type icon here
		});
//		setNodesType(filterSelect); //console.log(nodes);
		//$("a#btn-total").addClass("selected");
//		menuOver($("a#btn-total").get(0), true);

		treemap = d3.layout.treemap()
			.size([710, 225])
			.sticky(false)
			.value(function(d) { return d.size; });

//		$("#filters .button").on("click", changePeriod);
		$("#filters")
			.delegate("div.button:not(.selected)", "click touchstart", changePeriod);
		$(".business-types a:not(.selected").on('click', changeType);
//			.delegate("a.button:not(.selected)", "mouseover mouseout", function(e){
//				menuOver(this, e.type == "mouseover");
//			});
		$(document).on("scroll", onWindowResize);
		$(window).on("resize", onWindowResize).resize();

		animate();
	};

	function getIconName(n) {
		return n.split(" ")[0].toLowerCase();
	}
	function changeType(e){
		e.preventDefault();
		//$(this).addClass("selected").siblings().removeClass('selected');
		if ($(this).attr('data-type') == 'heavy') {
			setNodesType(filter1);
		} else {
			setNodesType(filter2);
		}
		svg.selectAll("g.bubble")
			.each(function(d){
				var r = ((d.radius || bubble.spacer) - bubble.spacer) * 2 || 0.1;
//					console.log(d.country, r, d.flag);
//				if(!d.flag) return;
//				d.body = addBubble(d.radius, d.body);
				addBubble(d.radius, d.body);
				d3.select(this)
					.transition().duration(400)
						.attr("opacity", d.value ? 1:0);
//						.classed('hidden', d.value);
//						.attr("opacity", parseFloat(toFixed(d.value, 1)) ? 1:0);
				d3.select(d.flag_svg)
					.transition().duration(500)
						.attr("width", r).attr("height", r)
						.attr("x", -r/2).attr("y", -r/2);
				r *= 0.35;
				d3.select(d.type_svg)
					.transition().duration(700)
						.attr("width", r).attr("height", r)
						.attr("x", -r/2).attr("y", -r/2);
				if(d3.select(this).select("use#show-selected-node")[0][0])
					selected.transition().duration(600)
						.attr("r", d.radius);

			});
		svg.selectAll("g.bubble use.status")
			.transition().duration(600)
				.attr('stroke', function(d){ return statusColor[d.status]; });
		animate();
	}

	function onWindowResize() {
		$("#header .title").css("margin-left", $(document).scrollLeft());
		$("#header .logo").css("margin-right", $(document).width() - window.innerWidth - $(document).scrollLeft());
	}
/*	var menuOver = menuOver;
	function menuOver(node, value){
		d3.select(node).select("img.icon:not(.over)")
			.classed("hidden", value);
		d3.select(node).select("svg.icon.over")
			.classed("hidden", !value);
	}*/

	this.selectCompany = selectCompany;
	function selectCompany(d){
		var rec = _.find(data.companies, function(c){ return c.iso == d.code;});
//		console.log(d, rec);
		selected.attr("r", d.radius);
		svg.selectAll("use#show-selected-node").remove();
		d3.select(this).append("svg:use")
			.attr("xlink:href", "#country-select").attr("id", "show-selected-node");

		$("#details").empty();
		$("#details").append(
					$('<p class="business-name">').html(d.info["name"])
				);
		$("#details").append(
					$('<p>').html("<b>Origin:</b>"+d.info["nationality"])
				);
		$("#details").append(
					$('<p>').html("<b>Owned by:</b>"+d.info["owner"])
				);
		/*for(var i in d.info) {
			$("#details").append(
					$('<p>').html(i+" "+d.info[i])
				);
		}*/

		$("#details").removeClass("hidden");

//		$("html,body").animate({
//				scrollLeft: $("#details").offset().left + Math.min(0, $("#details").width() - (window.innerWidth || $(window).width()))
//			}, 500);

	}

	function setNodesType(type, dateStart) {
		currType = type || currType;
		if(dateStart)
			dateStart = new Date(dateStart);
		else
			dateStart = currPeriod || new Date(period.start.getTime()) ;
		dateEnd = new Date(dateStart.getTime());
		dateEnd.setMonth(dateEnd.getMonth() + 3); //quarter
		currPeriod = dateStart;

		for (i = data.companies.length - 1; i >= 0; i--) {
			var c = data.companies[i]; //current company
			var node = nodes[i] || { name: c.name, flag: flags[c.nationality], info:c };
			if(currType != "All" && currType.indexOf(c.type) == -1 ) {
				node.status = "N/A";
				node.value = 0;
			} else {
				if(c.date >= dateEnd)
					node.status = 'Operational';
				else if(c.date < dateEnd)
					node.status = c.status;
				if(c.date2) { //secondary status
					if(c.date2 < dateEnd)
						node.status = c.status2;
				}
				node.value = 1;
			}
			node.radius = radius * node.value;
			nodes[i] = node;
//			d3.select(nodes[i].node).select("text.country_count .number")
//					.text(toFixed(node.value, node.value < 0.1 ? 2:1));
//			d3.select(nodes[i].node).select("text.country_count .percent")
//					.classed("hidden", type == "total");
			d3.select(nodes[i].node).classed("hidden", !node.value);
		}
//		svg.selectAll("g.bubble")
	}

	this.changePeriod = changePeriod;
	function changePeriod(e) {
		e.preventDefault();

		$(this).addClass("selected").siblings().removeClass('selected');
		setNodesType(null, $(this).attr('data-start'));
		svg.selectAll("g.bubble use.status")
			.transition().duration(600)
				.attr('stroke', function(d){ return statusColor[d.status]; });

		/*svg.selectAll("g.bubble use.over")
			.transition().duration(600)
				.attr('fill', function(d){ return statusColor[d.status]; })
				.attr('opacity', 0.5)
				.attr('r', 12);
			*/	
		

//		$("html,body").animate({ scrollLeft: 0}, 500);
		animate();
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
//		console.log("det", this);

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
		body.GetFixtureList().SetRestitution(0.55);
		body.GetFixtureList().SetFriction(1.4);
		return body;
	}

//		var cnt = 0;
	function animate() {
		world.Step(1/(window.FPS), 10, 10);
		world.ClearForces();
		var gravity = 20;
		/*for (var b = world.GetBodyList(); b.a; b = b.GetNext()) {
			console.log(b, cnt++);
			if(cnt>50)
				break;
		}*/
		for (var b = world.GetBodyList(); b.a; b = b.GetNext()) {
			var dist = new b2Vec2(-300/b2ratio, 0); //distance from center
			dist.op_add(b.GetWorldCenter()); //console.log(dist.get_x(), dist.get_y());
			var finalDistance = dist.Length(); //console.log(finalDistance);

			dist = new b2Vec2(-dist.get_x() *.8, -dist.get_y() *.8);
			var vecSum = Math.abs(dist.get_x()) + Math.abs(dist.get_y());
			dist.op_mul((b.GetMass() * vecSum / 80) * gravity / finalDistance);

			b.ApplyForce(dist, b.GetWorldCenter());
			/*cnt++;
			if(cnt>100) {
				cnt=0;
				console.log(dist.get_x(), b.GetWorldCenter().get_x());
			}*/
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




	this.reset();
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

function parseDate(s) { //MM/DD/YYYY
	var da = s.match(/(^\d+)\/(\d+)\/(\d+$)/);
//	console.log("parse", s, da);
	return new Date(	da[3], //year
						da[1]-1, //0-based month
						da[2]   //day
					);
}

function digit_grouping(nStr) {
	nStr += '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr)) {
		nStr = nStr.replace(rgx, '$1' + ',' + '$2');
	}
	return nStr;
}
