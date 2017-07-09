(function (lib, img, cjs, ss) {

var p; // shortcut to reference prototypes

// library properties:
lib.properties = {
	width: 600,
	height: 400,
	fps: 24,
	color: "#FFFFFF",
	manifest: []
};



// symbols:



(lib._1ATBMarket = function() {
	this.spriteSheet = ss["shopview_atlas_"];
	this.gotoAndStop(0);
}).prototype = p = new cjs.Sprite();



(lib._2ATBMarketdestroyedoutside = function() {
	this.spriteSheet = ss["shopview_atlas_"];
	this.gotoAndStop(1);
}).prototype = p = new cjs.Sprite();



(lib._3ATBMarketdestroyedinside = function() {
	this.spriteSheet = ss["shopview_atlas_"];
	this.gotoAndStop(2);
}).prototype = p = new cjs.Sprite();



(lib._4ATBMarketresurrected = function() {
	this.spriteSheet = ss["shopview_atlas_"];
	this.gotoAndStop(3);
}).prototype = p = new cjs.Sprite();



(lib._5ATBMarketcreditImgur = function() {
	this.spriteSheet = ss["shopview_atlas_"];
	this.gotoAndStop(4);
}).prototype = p = new cjs.Sprite();



(lib.Symbol5 = function() {
	this.initialize();

	// Layer 1
	this.instance = new lib._5ATBMarketcreditImgur();
	this.instance.setTransform(0,-556.5);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,-556.5,1979,1113);


(lib.Symbol4 = function() {
	this.initialize();

	// Layer 1
	this.instance = new lib._4ATBMarketresurrected();
	this.instance.setTransform(0,-248.5);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,-248.5,887,497);


(lib.Symbol3 = function() {
	this.initialize();

	// Layer 1
	this.instance = new lib._3ATBMarketdestroyedinside();
	this.instance.setTransform(0,-168);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,-168,600,336);


(lib.Symbol2 = function() {
	this.initialize();

	// Layer 1
	this.instance = new lib._2ATBMarketdestroyedoutside();
	this.instance.setTransform(0,-159.5);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,-159.5,568,319);


(lib.Symbol1 = function() {
	this.initialize();

	// Layer 1
	this.instance = new lib._1ATBMarket();
	this.instance.setTransform(0,-249.5);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,-249.5,827,499);


// stage content:
(lib.shopview = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// Layer 1
	this.instance = new lib.Symbol1();
	this.instance.setTransform(291.2,204.2,0.818,0.818,0,0,0,413.4,0);
	this.instance.alpha = 0;
	this.instance._off = true;
	this.instance.filters = [new cjs.ColorFilter(0, 0, 0, 1, 0, 0, 0, 0)];
	this.instance.cache(-2,-251,831,503);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(172).to({_off:false},0).to({alpha:1},13).wait(23));

	// Layer 2
	this.instance_1 = new lib.Symbol5();
	this.instance_1.setTransform(300,200,0.359,0.359,0,0,0,989.5,0);
	this.instance_1.alpha = 0;
	this.instance_1._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(127).to({_off:false},0).to({alpha:1},13).wait(68));

	// Layer 3
	this.instance_2 = new lib.Symbol4();
	this.instance_2.setTransform(300.1,200,0.805,0.805,0,0,0,443.6,0);
	this.instance_2.alpha = 0;
	this.instance_2._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_2).wait(89).to({_off:false},0).to({alpha:1},13).wait(106));

	// Layer 4
	this.instance_3 = new lib.Symbol3();
	this.instance_3.setTransform(300,200,1.19,1.19,0,0,0,300,0);
	this.instance_3.alpha = 0;
	this.instance_3._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_3).wait(57).to({_off:false},0).to({alpha:1},13).wait(138));

	// Layer 5
	this.instance_4 = new lib.Symbol2();
	this.instance_4.setTransform(300,200,1.254,1.254,0,0,0,284,0);
	this.instance_4.alpha = 0;
	this.instance_4._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance_4).wait(26).to({_off:false},0).to({alpha:1},13).wait(169));

	// Layer 6
	this.instance_5 = new lib.Symbol1();
	this.instance_5.setTransform(291.2,204.2,0.818,0.818,0,0,0,413.4,0);

	this.timeline.addTween(cjs.Tween.get(this.instance_5).wait(208));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(253,200,676.7,408.3);

})(lib = lib||{}, images = images||{}, createjs = createjs||{}, ss = ss||{});
var lib, images, createjs, ss;