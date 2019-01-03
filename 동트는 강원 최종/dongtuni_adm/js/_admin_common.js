
// 블럭 div 팝업 닫기버튼으로 클릭시 닫기
$(document).ready(function() { 
	$('#div_popup_close').click(function() {
		$('#div_popup_box').css("display", "none");
	});
});

// 블럭 div 팝업 닫기
function div_block_popup_close(){
	$('#div_popup_box').css("display", "none");
}

// 블럭 div 팝업 열기
function div_block_popup(width, height, src){

	$('#div_popup_box').css("display", "block");
	
	$('#div_popup').css({ 
		top:  ($(window).height() - height) /2 + 'px', 
		left: ($(window).width() - width) /2 + 'px', 
		width: width+'px',
		height: height+'px'
	});

}


// *************************************************************
// 숫자 체크
// *************************************************************
function checkMoneyUpdate(el){
	key = event.keyCode;
	if(event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 109 || event.keyCode == 110 || event.keyCode == 189 || event.keyCode == 190 || (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105))
		return el.value = addComma_new(el.value);
	else
		//alert("숫자 형태로 입력하세요!");
		//el.value = el.value;
		return;
}

// ---------------------------------------------------------
// 콤마 처리가 가능한 금액포멧 스크립트 (문자열은 필터링 되지 않음)
// ---------------------------------------------------------
function addComma_new(txt){
	var min,tmp,str,v;
	txt = removeComma(txt);
	min = txt.substring(0,1) == "-" ? txt.substring(0,1) : "";
	txt = txt.replace(min,'');
	tmp = txt.split('.');
	str = new Array();
	v = tmp[0].replace(/,/gi,'');
	for(var i=0;i<=v.length;i++){
		str[str.length] = v.charAt(v.length-i);
		if(i%3==0 && i!=0 && i!=v.length){
			str[str.length]='.';
		}
	}
	str = min+str.reverse().join('').replace(/\./gi,',');
	return(tmp.length == 2) ? str+'.'+tmp[1] : str;
}

// ---------------------------------------------------------
// 콤마 제거
// ---------------------------------------------------------
function removeComma(str) {
	str = str + "";
	str = $.trim(str);
	var len = str.length;
	var retval = "";
	for(var i = 0; i < len ; i++) {
		if (str.charAt(i) != ",") {
			retval += str.charAt(i);
		}
	}
	return retval;
}



function checked_check(obj){
	var checked = []
	$("input[name='"+obj+"']:checked").each(function () {
		checked.push(parseInt($(this).val()));
	});
	return checked;
}

// ---------------------------------------------------------
// 사이드바
// ---------------------------------------------------------

$(document).ready(function(){
	var lnbHeight = $(document).height();
	$('.sideBar').attr('style',"height:"+lnbHeight+"px");
	var lnbMenu = $('.lnb > ul > li');
	var lnbMenuLink = $('.lnb > ul > li > a');
	lnbMenu.click(function(){
		var num = lnbMenu.index(this);
		lnbMenu.each(function(i){
			if(num == i){
				lnbMenu.removeClass("on");
				lnbMenu.find('li').removeClass("on");
				lnbMenu.eq(i).addClass("on");
			};
		});
	});
});