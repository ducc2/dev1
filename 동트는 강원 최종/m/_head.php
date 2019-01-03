<?
$sh["rPath"]	= "..";
$sh["main"]		= true;
include_once($sh["rPath"]."/_common.php");



$sh["title"] = $sh["stie_title"]."";

if ($_GET['board_id']){ 
$board_id = $_GET['board_id'];
} else { 
$board_id = "contents";
}


$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/";
$thumb_url			= "../data/board/".$board_id."/thumb/";
$upUrl				= "../data/board/".$board_id;
$mobile_path		= "/m/";

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<title>동트는 강원</title>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- 마크업 전달 속성 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="<?=$mobile_path?>comn/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?=$mobile_path?>comn/css/main_slide.css">

	<!--[if lt IE 9]>
	<script src="comn/js/html5.js"></script>
	<script src="comn/js/css3-mediaqueries.js"></script>
	<![endif]-->

	<script src="<?=$mobile_path?>comn/js/jquery-1.11.2.min.js"></script>
	<script src="<?=$mobile_path?>comn/js/jquery-ui.min.js"></script>
	<script src="<?=$mobile_path?>comn/js/mighty.slide.4.2.2.min.js"></script>
	<script src="<?=$mobile_path?>comn/js/autocomplete.js"></script>
	<script src="<?=$mobile_path?>comn/js/common.js"></script>
	
</head>
<body>

<script>
function copy_trackback2(trb) {
var IE=(document.all)?true:false;
if (IE) {
if(confirm("이 글 주소를 복사하시겠습니까?"))
window.clipboardData.setData("Text", trb);
} else {
temp = prompt("아래의 URL을 길게 누르면 복사할 수 있습니다.", trb);
}
}
</script>

	<div class="gnbwrap">
		<div class="header">
			<a href="#" class="btnMenu">메뉴보기</a>
			<h1><a href="<?=$mobile_path?>index.php">동트는 강원<!--<img src="<?=$mobile_path?>comn/img/logo.png" alt="동트는강원">--></a></h1>
			<div class="request"><a href="<?=$mobile_path?>sub/newsletter_apply01.html">구독신청</a></div>
		</div><!-- //header -->
		<div class="blackBg"></div>
		<aside class="sideBar">
			
			<form name="se_fo2" action="<?=$mobile_path?>sub/search_list.html" method="POST">
			<div class="unb">
				<!--<div class="before"><a href="<?=$mobile_path?>sub/back_issue.html"><span class="icon_set icon_before"></span>지난호보기</a></div>-->
				<div class="before"><a href="<?=$mobile_path?>sub/ebook_view.html" target="_blank"><span class="icon_set icon_before"></span>전자책보기</a></div>
				<div class="searchbox">
				   <input type="text" name="search_txt" placeholder="검색어를 입력해주세요." class="search_back" title="검색어 입력">
				   <div class="search_back_icon"><a href="#none" onclick="document.se_fo2.submit()"></a></div>
				</div>
			</div><!-- //unb -->
			</form>

			
			<ul class="menu">
				<li><a href="<?=$mobile_path?>index.php" class="home">HOME</a></li>
				<li><a href="<?=$mobile_path?>board/board.php?board_id=contents&cate=tour">Tour</a></li>
				<li><a href="<?=$mobile_path?>board/board.php?board_id=contents&cate=Food">Food</a></li>
				<li><a href="<?=$mobile_path?>board/board.php?board_id=contents&cate=Culture">Culture</a></li>
				<li><a href="<?=$mobile_path?>board/board.php?board_id=contents&cate=Economy">Economy</a></li>
				<li><a href="<?=$mobile_path?>board/board.php?board_id=writer">Community</a>
					<ul class="submenu">
						<li><a href="<?=$mobile_path?>board/board.php?board_id=writer" >나도 여행작가</a></li>
						<li><a href="<?=$mobile_path?>board/board.php?board_id=news" >뉴스레터</a></li>
						<li><a href="<?=$mobile_path?>board/board.php?board_id=notice" >이벤트/공지</a></li>
					</ul>
				</li>
			</ul> <!-- //menu -->
			<div class="request"><a href="<?=$mobile_path?>sub/newsletter_apply01.html"><span class="icon_set icon_request"></span>구독신청</a></div>
			<div class="sns_s">
				<a href="https://www.facebook.com/dongtuni"><span class="icon_set icon_facebook_s"></span>페이스북</a>
				<a href="http://blog.naver.com/dongtuni"><span class="icon_set icon_blog_s"></span>블로그</a>
			</div>
			<a href="#" class="sideBar_close">메뉴닫기</a>
		</aside>
	</div> <!-- //gnbwrap -->