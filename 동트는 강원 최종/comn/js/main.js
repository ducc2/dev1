

(function(ssq){
	var	struc={}, config={}, listener={};
	var starList, add= {};
	var  _mainImgs , mainListSub;
	var mainBanner;
	var mainBanner2;
	ssq(document).ready(function(){ struc.init() });
	function trace(a){ var b=""; for(var i=0;i<arguments.length;i++){if(i>0)b+=", ";b+=arguments[i];} try{console.log(b);}catch(e){}}
	struc = {
		init : function() {
			struc.regist(); 
			struc.pageMethod();
			listener.start();
		},
		regist : function() {

		},
		pageMethod : function () {
			main_Slider();
			main_Slider2();
			//setListUI();
		}
	};
	listener = {
		start : function(){
			ssq(window).bind("resize", listener.resizePage); listener.resizePage();
			ssq(window).bind("scroll", add.checkLastScroll);
		},
		resizePage : function(e) {
			//starList.refresh();
			mainBanner.refresh();
			changeSlideHg();
		}
	};
	
	function changeSlideHg() {
		var device = ssq(window).width() >750 ? "wide" : "smart";
		var optn = {};
		if (!config.device) config.device = "";
		if (config.device == device) return;
		if (device == "smart") {
			optn = {slideWidth:640, slideHeight:485};
		} else {
			optn = {slideWidth: 960, slideHeight:420};
		}
		if (mainBanner) mainBanner.changeOption(optn);
	}


	function main_Slider() {
		mainBanner = ssq("#mainSlider").mightySlide({
			maxSlides : 1,
			minSlides : 1,
			loop : true,
			slideCurrent : 0,
			speed: 800,
			autoPlay :5000,
			slideWidth : 960,
			slideHeight : 500,
			autoFit : true,
			autoControls:false
		});
	}
	function main_Slider2() {
		mainBanner2 = ssq("#mainSlider2").mightySlide({
			maxSlides : 3,
			minSlides : 1,
			loop : true,
			slideCurrent : 0,
			speed: 300,
			autoPlay :2000,
			slideWidth : 320,
			slideHeight : 420,
			autoFit : true,
			autoControls:false
		});
	}

})(jQuery);

jQuery(function(){
	jQuery.fn.extend({		
		
		hoverInfoSlide:function(options){
			var defaults={
				speed:600,
				easing:"easeOutQuart"
			};
			var op=jQuery.extend(defaults,options);
			var $t=jQuery(this);
			var move=0;
			var w=$t.width();

			$t.on({
				"mouseenter":function(e){
					move=e.pageX;
					if((move-jQuery(this).offset().left)>(w/2)){
						var set=w;
					}else{ 
						var set=-w;
					}
					jQuery(this).find("span").css({ left:set+"px" }).stop(true,false).animate({ left:0 },op.speed,op.easing);
				},
				"mousemove":function(e){
					move=e.pageX;
				},
				"mouseleave":function(){
					if((move-jQuery(this).offset().left)>(w/2)){ 
						var set=w;
					}else{ 
						var set=-w;
					}
					jQuery(this).find("span").stop(true,false).animate({ left:set },op.speed,op.easing);
				}
			});
		}
	});
	jQuery(".collection_list ul li").each(function(){ jQuery(this).hoverInfoSlide(); });
	jQuery(".collection_list ul li:nth-child(4n)").addClass("last");
});