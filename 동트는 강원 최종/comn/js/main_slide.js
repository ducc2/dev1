(function(){

	var mvisual = function(){
		return {
			parentElement:$("#mainVisual"),
			parentControl:$("#mainVisual .parentControl button"),
			parentGround:$("#mainVisual .obj"),
			parentItem:$("#mainVisual .item"),
			childControl:$("#mainVisual .control button"),
			childGround:$("#mainVisual .child"),
			childWrapNode:".objChildren",
			childCtrlNode:".control",
			childPageNode:".control span",
			childItemNode:".childItem",
			parentIndex:0,
			childIndex:0
		}
	}

	var setMovement,setTime=5000;

	var parentIndex = mvisual().parentIndex;
	var childIndex = mvisual().childIndex;

	mvisual().parentItem.css({opacity:0});

	var scene1 = function(){
		mvisual().parentItem.eq(parentIndex)
			.stop(true,false).show()
				.animate({opacity:1},1000,'easeInOutCubic')

			.find(mvisual().childWrapNode)
				.css({top:20,opacity:0})
					.stop(true,false).delay(300)
						.animate({top:0,opacity:1},800,'easeInOutCubic')

			.find(mvisual().childCtrlNode)
				.css({marginLeft:-20,opacity:0})
					.stop(true,false).delay(700)
						.animate({marginLeft:0,opacity:1},1300,'easeInOutCubic')

			.parent().find(mvisual().childItemNode)
				.css({top:-20,opacity:0})
					.stop(true,false).delay(700)
						.animate({top:0,opacity:1},800,'easeInOutCubic');
	}

	var scene2 = function(){
		mvisual().parentItem.not(parentIndex)
			.stop(true,false)
				.animate({opacity:0},1000,'easeInOutCubic',function(){
					$(this).hide();
				})

			.find(mvisual().childWrapNode)
				.stop(true,false)
					.animate({opacity:0},800,'easeInOutCubic');
	}

	//------------

	var pageContext = [];

	$.each(mvisual().parentItem,function(index){
		if(index === 0){
			pageContext[index] = '<button type="button" class="ov go-button go-ir">'+(index+1)+'</button>';
		}else{
			pageContext[index] = '<button type="button" class="go-button go-ir">'+(index+1)+'</button>';
		}
		mvisual().parentElement.find(mvisual().childPageNode).html(pageContext);
	});

	mvisual().parentItem.not(mvisual().parentItem.eq(parentIndex)).css({opacity:0})
		.not(mvisual().parentItem.eq(parentIndex).find(mvisual().childItemNode).eq(childIndex)).css({opacity:0});

	scene1();

	mvisual().parentElement.find(".l,.r").css({opacity:0.3});

	//------------

	function setParentMovement(){
		//if(mvisual().parentElement.find(":animated").size() > 0){ return false; }

		switch(arguments[0]){

			case "prev" :
				if(parentIndex > 0){
					parentIndex--;
				}else{
					parentIndex = mvisual().parentItem.size()-1;
				}
			break;

			case "next" :
				if(parentIndex < mvisual().parentItem.size()-1){
					parentIndex++;
				}else{
					parentIndex = 0;
				}
			break;

			default:
				parentIndex = arguments[0];
			break;
		}

		mvisual().parentElement.find(mvisual().childPageNode).children().removeClass("ov")
			.eq(parentIndex).addClass("ov");
		$(document).queue(scene2).dequeue().queue(scene1).dequeue();
	}

	function parentController(){
		clearInterval(setMovement);
		setParentMovement($(this).attr("data-type"));
		mvisual().parentElement.find("[data-type='stop']").hide();
		mvisual().parentElement.find("[data-type='play']").show();
	}

	function childController(){
		clearInterval(setMovement);
		if($(this).attr("data-type") === undefined){
			
			if($(this).parent().find(".ov").index() !== $(this).index()){
				mvisual().parentElement.find("[data-type='stop']").hide();
				mvisual().parentElement.find("[data-type='play']").show();
				setParentMovement($(this).index());
			}

		}else{

			if($(this).attr("data-type") == "play"){
				autoPlay();
				mvisual().parentElement.find("[data-type='play']").hide();
				mvisual().parentElement.find("[data-type='stop']").show();
			}

			if($(this).attr("data-type") == "stop"){
				mvisual().parentElement.find("[data-type='stop']").hide();
				mvisual().parentElement.find("[data-type='play']").show();
			}

		}
	}

	function autoPlay(){
		setMovement = setInterval(function(){
			setParentMovement("next");
		},setTime);
	}

	//------------

	mvisual().parentControl.on("click",parentController);
	mvisual().childControl.on("click",childController);

	//------------

	autoPlay();

}());
