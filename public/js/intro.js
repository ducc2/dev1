/**
 * Intro Img Changer
*/
function introChange(image, imagename,bgbodyImage="bg_market.jpg") {
	//변수 선언
	var baseBg = ["bg_market.jpg","over_market.png"]; //bbg
	var path = "/img/intro/"; //이미지 경로
	var bgBodyImg = document.getElementsByClassName("bgbody")[0]; //Background Class

	//초기화
	bgBodyImg.style.backgroundRepeat = "no-repeat";
	bgBodyImg.style.backgroundImage = "url(" + path  + baseBg[0] + ")";
	$('#activeImg').attr('src', path + baseBg[1] );
	
	bgBodyImg.style.backgroundImage = "url(" + path + bgbodyImage + ")";
	image.src = path+imagename;
}


