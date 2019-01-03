$(document).ready(function(){

	var winHeight = $(window).height();
	var sidebarWidth = $(".sideBar").width() +100;
	//alert(winHeight);

	$(".btnMenu").click(function(){
		$(".blackBg").show();
		$(".blackBg").animate({opacity:0.8}, 500);
		$(".sideBar").animate({left:0}, 500);
		$(".con_wrap").addClass('fixed');
	});
	$(".sideBar_close").click(function(){
		$(".blackBg").animate({opacity:0}, 500, function(){
			$(".blackBg").hide();
		});
		$(".sideBar").animate({left:-sidebarWidth}, 500);
		$(".con_wrap").removeClass('fixed');
	});
	$(".blackBg").click(function(){
		$(".blackBg").animate({opacity:0}, 500, function(){
			$(".blackBg").hide();
		});
		$(".sideBar").animate({left:-sidebarWidth}, 500);
		$(".con_wrap").removeClass('fixed');
	});

	//top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.scrollTop').fadeIn();
		} else {
			$('.scrollTop').fadeOut();
		}
	});
	$('.scrollTop').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	//imgView
	$('.imgView').click(function () {
		var imgUrl = this.src;
		location.href=imgUrl;
	});

	$('.contents img').each(function () {
		if (this.complete) {

			var bbsImg = $('.contents img');
			bbsImg.each(function(k){
				bbsImg.eq(k).click(function () {
					var imgUrl = this.src;
					location.href=imgUrl;
				});
			});

		} else {
			$(this).one('load', imageLoaded); 
		}
	});


});

//모바일 이미지 확대보기
function imgView(val){

	var imgUrl = val;
	var winWidth = $(document).width();
	if (winWidth < 800){
		location.href=imgUrl;
	}

}

/*
	2016.03.31
	SNS login
*/
$(document).on('click', '.comment a.sns_f', function(e){
	e.preventDefault();

	var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
		screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
		outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
		outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
		width    = 800,
		height   = 500,
		left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
		top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
		features = (
			'width=' + width +
			',height=' + height +
			',left=' + left +
			',top=' + top
		);

	newwindow=window.open(f_url,'Login_by_facebook',features);

	if (window.focus) {newwindow.focus();}
});

// twitter
$(document).on('click', '.comment a.sns_t', function(e){
	e.preventDefault();

	var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
		screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
		outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
		outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
		width    = 800,
		height   = 400,
		left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
		top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
		features = (
			'width=' + width +
			',height=' + height +
			',left=' + left +
			',top=' + top
		);

	newwindow=window.open('/sns/twitter/redirect.php','Login_by_facebook',features);

});

// kakaotalk
$(document).on('click', '.comment a.sns_k', function(e){
	e.preventDefault();

	var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
		screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
		outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
		outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
		width    = 500,
		height   = 270,
		left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
		top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
		features = (
			'width=' + width +
			',height=' + height +
			',left=' + left +
			',top=' + top
		);

	newwindow=window.open(k_url,'Login_by_facebook',features);

	if (window.focus) {newwindow.focus();}


});

$(document).on('click', '.comment a.sns_off', function(e){
	e.preventDefault();
	$.post('/sns/logout.php',null, function(data){
		location.reload();
	});
});


function popup(u, n, w, h, s, r, m) {
    var o;
    var lP = screen.availWidth;
    var tP = screen.availHeight;
    var p  = "";

	if(s==undefined) s = "no";
	if(m==undefined) m = 1;

    if(m==2) //- 위쪽모서리
        p = ",left=0,top=0";
    else if(m==3) //- 정중앙
        p = ",left=" + ((lP - w) / 2) + ",top=" + ((tP - h) / 2);

    o = window.open(u,n,"status=yes,toolbar=no,location=no,scrollbars=" + s + ",resizable="+r+",width="+w+",height="+h + p);
    o.focus();
}