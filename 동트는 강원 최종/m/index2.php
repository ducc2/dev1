<?
$sh["rPath"]	= "..";
$sh["main"]		= true;
include_once($sh["rPath"]."/_common.php");



$sh["title"] = $sh["stie_title"]."";

$board_id			="contents";
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/";
$thumb_url			= "./data/board/".$board_id."/thumb/";
$upUrl				= "./data/board/".$board_id;
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


	<div class="gnbwrap">
		<div class="header">
			<a href="#" class="btnMenu">메뉴보기</a>
			<h1><a href="<?=$mobile_path?>index.php"><img src="<?=$mobile_path?>comn/img/logo.png" alt="동트는강원"></a></h1>
			<div class="request"><a href="<?=$mobile_path?>sub/newsletter_apply01.html">구독신청</a></div>
		</div><!-- //header -->
		<div class="blackBg"></div>
		<aside class="sideBar">
			<div class="unb">
				<div class="before"><a href="<?=$mobile_path?>sub/back_issue.html"><span class="icon_set icon_before"></span>지난호보기</a></div>
				<div class="searchbox">
					<input type="text" placeholder="검색어를 입력해주세요." class="search_back" title="검색어 입력">
					<div class="search_back_icon"><a href="#"></a></div>
				</div>
			</div><!-- //unb -->
			<ul class="menu">
				<li><a href="<?=$mobile_path?>index.html" class="home">HOME</a></li>
				<li><a href="<?=$mobile_path?>sub/contents_list.html">Tour</a></li>
				<li><a href="<?=$mobile_path?>sub/contents_list.html">Food</a></li>
				<li><a href="<?=$mobile_path?>sub/contents_list.html">Culture</a></li>
				<li><a href="<?=$mobile_path?>sub/contents_list.html">Economy</a></li>
				<li><a href="<?=$mobile_path?>sub/photographer_list.html">Community</a>
					<ul class="submenu">
						<li><a href="<?=$mobile_path?>sub/photographer_list.html" >나도 여행작가</a></li>
						<li><a href="<?=$mobile_path?>sub/newsletter_apply01.html" >뉴스레터</a></li>
						<li><a href="<?=$mobile_path?>sub/bbs_list.html" >이벤트/공지</a></li>
					</ul>
				</li>
			</ul> <!-- //menu -->
			<div class="request"><a href="<?=$mobile_path?>sub/newsletter_apply01.html"><span class="icon_set icon_request"></span>구독신청</a></div>
			<div class="sns_s">
				<a href="https://www.facebook.com/dongtuni"><span class="icon_set icon_facebook_s"></span>페이스북</a>
				<a href="http://m.post.naver.com/tag/overView.nhn?tag=동트는강원"><span class="icon_set icon_blog_s"></span>네이버 포스트</a>
			</div>
			<a href="#" class="sideBar_close">메뉴닫기</a>
		</aside>
	</div> <!-- //gnbwrap -->

	<!-- mainVisual -->
	<section id="mainVisual">

		<div class="parentControl">
			<button type="button" class="go-button go-ir" data-type="prev">이전 비주얼</button>
			<button type="button" class="go-button go-ir" data-type="next">다음 비주얼</button>
		</div>

		<div class="grap go-layout">
			<div class="obj">
<?
		$table01			= SHOP_BANNER_TABLE;
		$upUrl				= "../data/banner/";
		
		if($sch_text)	$where[] = "$sch_key LIKE '%$sch_text%'";
		if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	


		$sql		= "SELECT a.* FROM sh_shop_banner a where a.ban_use=2 ORDER BY a.no asc";

		$row		= $DB->dfetcharr($sql);
		$tot		= $DB->rows_count($sql);

		
		for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			$rows[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			if($rows[ban_img]){
				$filename_exp	= explode("|", $rows[ban_img]);
				$ban_img_tmp	= "<img src='$upUrl/$filename_exp[1]'>";
			}else{
				$ban_img_tmp	= "";
			}
			extract($rows);

			$next_sql = "select ban_img from sh_shop_banner where no > ".$rows['no']." order by no asc limit 0,1";
			$next_row			= $DB->fetcharr($next_sql);

			if($next_row[ban_img]){
				$filename_exp2	= explode("|", $next_row[ban_img]);
				$ban_img_tmp2	= "<img src='$upUrl/$filename_exp2[1]'>";
			}else{
				$ban_img_tmp2	= "";
			}


			$prev_sql = "select ban_img from sh_shop_banner where no < ".$rows['no']."  order by no desc limit 0,1";
			$prev_row			= $DB->fetcharr($prev_sql);

			if($prev_row[ban_img]){
				$filename_exp3	= explode("|", $prev_row[ban_img]);
				$ban_img_tmp3	= "<img src='$upUrl/$filename_exp3[1]'>";
			}else{
				$ban_img_tmp3	= "";
			}

			?>
				<div class="item">
					<figure><?=$ban_img_tmp?></figure>
					<div class="objChildren">
						<div class="child">
							<p class="childItem">
								<span class="childTit"><span><?=strip_tags($rows['ban_category'])?></span></span>
								<a href="#">
									<i>영월 새해 여행지</i>
									sss숨 고르기를 할 시간입니다. 자신에게 채찍질을 하며 숨 가쁘게 달려온 해를 방금 떠나 보냈습니다.잠시 한 박자 쉬어 갈 때입니다. ‘돌아봄’과 ‘내다봄’이 필요한 순간입니다. 그래야만 새해에는 더 알차고, 가치 있는 삶의 힘이 생길 것입니다. 여행을 떠나봅니다. 목적지를 정했거나, 무작정 발길 닿는 대로 떠나거나...
								</a>
							</p>
						</div>
						<div class="childMore">
							<!-- <p class="hit"><span>VIEW</span> 235</p> -->
							<a class="more go-ir" href="#">내용 상세보기</a>
						</div>
					</div>
					<div class="l"><?=$ban_img_tmp2?></div>
					<div class="r"><?=$ban_img_tmp3?></div>
				</div><!-- //item -->
<? } ?>
				<div class="control">
					<span class="controlspan"></span>
					<button type="button" class="go-button go-ir" data-type="stop">비주얼 멈춤</button>
					<button type="button" class="go-button go-ir" data-type="play">비주얼 시작</button>
				</div>

			</div><!-- //grap -->
		</div>

		<!-- 메인슬라이드 js -->
		<script type="text/javascript" src="<?=$mobile_path?>comn/js/main_slide.js"></script>

	</section><!-- //mainVisual -->

	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container main" id="container"><!--메인페이지에서만 class main 추가-->
			 <div class="contents">
					<div class="title clearfix">
						<h2 class="tit_main">Contents</h2>
						<span class="main_date">2016년 1월호</span><div class="last_view"><a href="#">+ 지난호 보기</a></div>
					</div>
					<ul class="clearfix">
						<li>
							<a href="#">
								<div class="thumb">
									<img src="<?=$mobile_path?>comn/img/img_con01.jpg" alt="사진" class="def">
									<div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div>
								</div>
								<h4 class="tit_con"><span>Tour</span>명태에 스민겨울 황태</h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con02.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Culture</span>명태에 스민겨울 황태</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con03.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Food</span>크루주타고 떠나볼까?</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con04.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Tour</span>명태에 스민겨울 황태</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con05.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Culture</span>올림픽 특선 메뉴 10선</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con06.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Tour</span>평창올림픽 리허설 막 오르다!</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con07.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Food</span>또 하나의 대한민국, 홍천, 금학산을</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con08.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Tour</span>명태에 스민겨울 황태</span></h4></a>
						</li>
						<li>
							<a href="#"><div class="thumb"><img src="<?=$mobile_path?>comn/img/img_con09.jpg" alt="사진" class="def"><div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div></div><h4 class="tit_con"><span>Food</span>영월 새해 여행지</span></h4></a>
						</li>
						<!-- 게시물이 홀수로 끝나면 아래 지난호보기 노출, 짝수로 끝나면 노출안함. -->
						<li>
							<a href="#" class="beforeLink">+ 지난호보기<strong>2015년 12월호</strong><span class="arrow"></span></a>
						</li>
						
					</ul>
			  </div><!--// contents-->
		</div><!--// container -->
		<!-- right_menu -->
		<div class="main_rig_menu">
			<div class="ranking_wrap">
				
				<ul class="ranking"> <div class="bb">인기 <span class="bb_orange">글</span></div>
					<li><a href="#"><span class="num_ranking">1</span><strong>명태에 스민 겨울, 황태</strong></a></li>
					<li><a href="#"><span class="num_ranking">2</span><strong>영월 새해 여행지</strong></a></li>
					<li><a href="#"><span class="num_ranking">3</span><strong>올림픽 특선 메뉴 10선</strong></a></li>
					<li><a href="#"><span class="num_ranking rank_gr">4</span>크루즈 타고 여행 떠나 볼까?</a></li>
					<li><a href="#"><span class="num_ranking rank_gr">5</span>권진규 미술관 춘천에 들어서다!!!!!</a></li>
				</ul>
			</div>
			<div class="best_tag clearfix">
				<div class="bb">인기 <span class="bb_green">태그</span></div>
				<span class="hash_tag"><a href="#">#영월</a></span>
				<span class="hash_tag"><a href="#">#새해</a></span>
				<span class="hash_tag"><a href="#">#1월</a></span>
				<span class="hash_tag"><a href="#">#1월</a></span>
				<span class="hash_tag"><a href="#">#1월</a></span>
			</div>
		 </div><!-- //right_menu -->
		 <!-- footwrap-->
		 <div class="footwrap">
			<div class="foot clearfix">
				<span><a href="<?=$mobile_path?>sub/privacy.html">개인정보 취급방침</a></span><span class="non"><a href="<?=$mobile_path?>sub/copyright.html">저작권보호방침</a></span>
				<div class="tab_sns">
					<a href="https://www.facebook.com/dongtuni"><img src="comn/img/icon_f.png" alt="페이스북"></a>
					<a href="http://m.post.naver.com/tag/overView.nhn?tag=동트는강원"><img src="comn/img/icon_b.png" alt="블로그"></a>
				</div>
			</div>
			<p>2011 ©  Copyright Powered by Provin Gangwon.</p>
		 </div><!--// footwrap-->
		 <a href="#" class="scrollTop">위로</a>
	 </div><!-- //con_wrap -->
</body>
</html>
