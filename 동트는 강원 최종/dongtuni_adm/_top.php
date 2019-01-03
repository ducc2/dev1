<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<div id="div_popup_box" style="display:none;">
	<div id="div_popup_close">X</div>
	<div id="div_popup"><iframe name="div_popup_ifm" id="div_popup_ifm" src="" frameborder="0" scrolling="no" style="width:100%;height:100%;"></iframe></div>
</div>


<div id="shop_wrap"><!-- shop_wrap start -->


<div class="sideBar">
	<h1><a href="#">
	<img src="/dongtuni_adm/images/logo.png" alt="동트는강원">
	<span>홈페이지 관리</span>
	</a></h1>

	<div class="memberInfo">
	<span>관리자님</span> 반갑습니다.<br>
	<a href="/" class="btn" target="_blank">홈페이지</a>
	<a href="../member/logout.php" class="btn">로그아웃</a>
	</div><!-- //memberInfo -->




 
<header id="header" style="display:none;">
    <div id="header_wrap">
		<div id="logo"> ADMINISTRATOR </div>

		<div id="top_menu">
			<ul>
				<li><a href="./">관리자메인</a> | </li>
				<li><a href="../" target="_blank">홈페이지</a> | </li>
				<li id="tnb_logout"><a href="../member/logout.php" style="color:#ff0000">로그아웃</a></li>
			</ul>
		</div>
	</div> 
    <div id="header_gnb">
		<nav id="gnb" class="section">
			<ul id="navi_menu">
				<li><a href="./shop_popup.php" style="color:#ffffff;">홈페이지 관리</a> <div class='menu_line'> | </div></li>
				<li><a href="/admin/board.php?board_id=contents">컨텐츠관리</a> <div class='menu_line'> | </div></li>
				<!-- <li><a href="./shop_goods.php">상품관리</a><div class='menu_line'> | </div></li>
				<li><a href="./shop_order.php">주문관리</a><div class='menu_line'> | </div></li> -->
				<li><a href="./shop_banner.php">구독관리</a><div class='menu_line'> | </div></li>
				<!-- <li><a href="./shop_member.php">회원관리</a><div class='menu_line'> | </div></li> -->
				<!-- <li><a href="./board_register.php">고객센터</a><div class='menu_line'> | </div></li> -->
				<li><a href="./shop_statistic_visit.php">통계</a></li>
				<!-- <li><a href="javascript:category_all_show();">전체메뉴</a></li> -->
			</ul>       
		</nav>
	</div>
	
    <div class="sub_menu22" id="sub_menu" style="display:none;">
		<div class="menu_section">
		<nav>
		<ul>
			<li>
				<ul>
					<li><a href="./shop_popup.php">팝업관리</a></li>
					<li><a href="./shop_banner.php">메인디스플레이관리</a></li>
					<!-- <li><a href="./shop_basic_set.php">기본설정</a></li>
					<li><a href="./shop_stipulation.php">약관관리</a></li>
					<li><a href="./shop_bank.php">은행관리</a></li>
					<li><a href="./shop_pg.php">전자결제(PG)</a></li>
					<li><a href="./shop_sms_set.php">문자설정(SMS)</a></li>
					<li><a href="./shop_realname.php">본인/실명인증 설정</a></li>
					<li><a href="./shop_delivery.php">택배사관리</a></li> -->
				</ul>    
			</li>
			<li>
				<ul>
					<li><a href="/dongtuni_adm/board.php?board_id=contents">컨텐츠관리</a></li>
					<li><a href="/dongtuni_adm/board.php?board_id=writer">여행작가 게시물</a></li>
					<li><a href="/dongtuni_adm/board.php?board_id=notice">이벤트/공지</a></li>
				</ul>   
			</li>
			<!-- <li>     
				<ul>
					<li><a href="./shop_category.php">상품분류관리</a></li>
					<li><a href="./shop_category_sort.php">상품분류정렬</a></li>
					<li><a href="./shop_goods.php?mode=form">상품등록</a></li>
					<li><a href="./shop_goods_excel_up.php">상품다량등록</a></li>
					<li><a href="./shop_goods.php">상품복사/이동/수정</a></li>
					<li><a href="./shop_best_sale.php">베스트셀러관리</a></li>
					<li><a href="./shop_event_sale.php">이벤트셀러관리</a></li>
					<li><a href="./shop_goods_icon.php">상품아이콘관리</a></li>
				</ul>  
			</li>
			<li>   
				<ul>
					<li><a href="./shop_order.php">전체주문</a></li>
					<li><a href="./shop_order.php?tot_state=2">결제완료</a></li>
					<li><a href="./shop_order.php?payment_type=1">무통장입금</a></li>
					<li><a href="./shop_order.php?tot_state=7">교환접수</a></li>
					<li><a href="./shop_order.php?tot_state=5">반품접수</a></li>
					<li><a href="./shop_order.php?tot_state=10">취소접수</a></li>
				</ul>  
			</li>
			<li>    
				<ul>
					<li><a href="./shop_popup.php">팝업관리</a></li>
					<li><a href="./shop_banner.php">배너관리</a></li>
					<li><a href="./shop_schedule.php">일정관리</a></li>
					<li><a href="./shop_coupon.php">쿠폰관리</a></li>
					<li><a href="./shop_coupon_publish.php">쿠폰발행관리</a></li>
					<li><a href="./shop_webpage.php">웹페이지관리</a></li>
					<li><a href="./shop_sms_contents.php">문자관리</a></li>
					<li><a href="./shop_sms_send.php?mode=form">즉시문자발송</a></li>
					<li><a href="./shop_sms_send.php">문자발송내역</a></li>
				</ul>  
			</li> -->
			<li>    
				<ul>
					
					<li><a href="./shop_banner.php">구독신청관리</a></li>
					<li><a href="./shop_schedule.php">구독그룹관리</a></li>
					<!-- <li><a href="./shop_coupon.php">쿠폰관리</a></li>
					<li><a href="./shop_coupon_publish.php">쿠폰발행관리</a></li>
					<li><a href="./shop_webpage.php">웹페이지관리</a></li>
					<li><a href="./shop_sms_contents.php">문자관리</a></li>
					<li><a href="./shop_sms_send.php?mode=form">즉시문자발송</a></li>
					<li><a href="./shop_sms_send.php">문자발송내역</a></li> -->
				</ul>  
			</li>
			<!-- <li>     
				<ul>
					<li><a href="./board_register.php">게시판관리</a></li>
					<li><a href="./shop_qanda.php?qna_type=">1:1문의관리</a></li>
					<!-- <li><a href="./shop_qanda.php?qna_type=goods">상품문의관리</a></li>
					<li><a href="./shop_review.php">상품평관리</a></li>
				</ul>    
			</li> -->
			<li>     
				<ul>
					<!-- <li><a href="./shop_statistic_order.php">매출통계</a></li>
					<li><a href="./shop_statistic_goods.php">상품별통계</a></li>
					<li><a href="./shop_statistic_member.php">회원통계</a></li> -->
					<li><a href="./shop_statistic_visit.php">방문통계</a></li>
					<li><a href="./shop_statistic_goods.php">게시물통계</a></li>
				</ul>
			</li>
		</ul>
		</nav>
		</div>
	</div>
</header>
<!--<div id="top_line"></div>	

<script type="text/javascript">
	function category_all_show(){
		if($(".sub_menu").css("height") == '0px'){
			$(".sub_menu").show("slide", { direction: "down" }, 1);
			$( ".sub_menu" ).animate({ "height": "240px" }, "slow" );
		}
	}
	
	function category_all_hide(){
		$( ".sub_menu" ).animate({ "height": "0px" }, "normal" );
		$(".sub_menu").hide("slide", { direction: "up" }, 1);
	}

	$( "#header_gnb" ).mouseover(function() {
		category_all_show();
	});

	$( "#gnb" ).mouseover(function() {
		category_all_show();
	});

	$('body').click(function() {
		category_all_hide();
	});


</script>-->