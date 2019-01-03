<?
if (!$cate_title) { 
	if ($row[subject]) { 
		$cate_title = $row[subject];
	} else{
		$cate_title = $board_info[name];

		if($board_id == "subscribe"){
			$cate_title = "정기구독신청";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<title>동트는 강원 : <?=$cate_title?></title>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- 마크업 전달 속성 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="../comn/css/style.css">

	<!--[if lt IE 9]>
	<script src="../comn/js/html5.js"></script>
	<script src="../comn/js/css3-mediaqueries.js"></script>
	<![endif]-->

	<script src="../comn/js/jquery-1.11.2.min.js"></script>
	<script src="../comn/js/jquery-ui.min.js"></script>
	<script src="../comn/js/common.js"></script><!-- 메인페이지엔 없어야함 -->
</head>
<body>

<ul id="accessibility-link">
	<li><a href="#gnbMenu">메뉴 바로가기</a></li>
	<li><a href="#container">컨텐츠 바로가기</a></li>
</ul>

	<div class="gnbwrap">
		<div class="gnb">
			<form name="se_fo2" action="/sub/search_list.html" method="POST">
			<h1><a href="/"><img src="../comn/img/logo.png" alt="동트는강원"></a></h1>
			<div class="unb">
				<div class="before"><a href="/sub/ebook_view.html" onclick="popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;"><span class="icon_set icon_before"></span>전자책보기</a></div>
				<div class="request"><a href="/newsletter/newsletter_apply01.php"><span class="icon_set icon_request"></span>구독신청</a></div>
				<div class="searchbox">
				   <input type="text" name="search_txt" placeholder="검색어를 입력해주세요." class="search_back" title="검색어 입력" style="ime-mode:active">
				   <div class="search_back_icon"><a href="#none" onclick="document.se_fo2.submit()"></a></div>
				</div>
			</div><!-- //unb -->
			</form>
			<!-- menu -->
			<ul class="menu" id="gnbMenu">
				<li><a href="/board/board.php?board_id=contents&cate=tour">Tour</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=food">Food</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=culture">Culture</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=economy">Economy</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=writer">Community</a>
					 <ul class="submenu">
						 <li><a href="/board/board.php?board_id=writer" >나도 여행작가</a></li>
						 <li><a href="/board/board.php?board_id=news" >뉴스레터</a></li>
						 <li><a href="/board/board.php?board_id=notice" >이벤트/공지</a></li>
					 </ul>
				</li>
			</ul> <!-- //menu -->
			<div class="sns_s">
				<a href="https://www.facebook.com/dongtuni" target="_blank"><span class="icon_set icon_facebook_s"></span></a>
				<a href="http://blog.naver.com/dongtuni" target="_blank"><span class="icon_set icon_blog_s"></span></a>
			</div>
		</div><!-- //gnb -->
	</div> <!-- //gnbwrap -->