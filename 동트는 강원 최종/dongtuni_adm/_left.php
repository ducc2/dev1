<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


	<div class="lnb">
		<ul>
			<li class="<?if($leftcode==5){ echo 'on'; $focus1="color:#ffffff;";}?>"><a href="./shop_popup.php" style="<?=$focus1?>">홈페이지 관리</a>
				<ul>
					<li><a href="/dongtuni_adm/adminID.php">관리자관리</a></li>
					<li><a href="./shop_popup.php">팝업관리</a></li>
					<li><a href="./shop_banner.php">메인디스플레이관리</a></li>
					<li><a href="/dongtuni_adm/mainTag.php">메인해시태그관리</a></li>
				</ul>
			</li>
			<li class="<?if($leftcode==2){ echo 'on'; $focus2="color:#ffffff;";}?>"><a href="/dongtuni_adm/board.php?board_id=contents" style="<?=$focus2?>">컨텐츠관리</a>
				<ul>
					<li><a href="/dongtuni_adm/board.php?board_id=contents">컨텐츠관리</a></li>
					<li><a href="/dongtuni_adm/board.php?board_id=writer">여행작가 게시물</a></li>
					<li><a href="/dongtuni_adm/support.php">서포터즈관리</a></li>
					<li><a href="/dongtuni_adm/board.php?board_id=news">뉴스레터</a></li>
					<li><a href="/dongtuni_adm/board.php?board_id=notice">이벤트/공지</a></li>
					<li><a href="./old.php">지난호관리</a></li>
				</ul>
			</li>
			<li class="<?if($leftcode==3){ echo 'on'; $focus3="color:#ffffff;";}?>"><a href="./newsletter.php" style="<?=$focus3?>">구독관리</a>
				<ul>
					<li><a href="./newsletter.php">구독신청관리</a></li>
					<li><a href="./newsgroup.php">구독그룹관리</a></li>
				</ul>
			</li>
			<li class="<?if($leftcode==8){ echo 'on'; $focus4="color:#ffffff;";}?>"><a href="./shop_statistic_visit.php" style="<?=$focus4?>">통계</a>
				<ul>
					<li><a href="./shop_statistic_visit.php">방문통계</a></li>
					<!-- <li><a href="./shop_statistic_goods.php">게시물통계</a></li> -->
				</ul>
			</li>
		</ul>
	</div><!-- //lnb -->
	
</div><!-- //sideBar -->

<div class="container">


<!-- 아래 메뉴는 이전것입니다. -->
<div id="cont_left" style="display:none;">
	

	<?if(!$leftcode){?>
		<div class="left_title">기본설정</div>
		<ul>
			<li class="left_menu"> - <a href="./shop_info.php">SHOP정보</a></li>
			<li class="left_menu"> - <a href="./shop_basic_set.php">기본설정</a></li>
			<li class="left_menu"> - <a href="./shop_stipulation.php">약관관리</a></li>
			<li class="left_menu"> - <a href="./shop_bank.php">은행관리</a></li>
			<li class="left_menu"> - <a href="./shop_pg.php">전자결제(PG)</a></li>
			<li class="left_menu"> - <a href="./shop_sms_set.php">문자설정(SMS)</a></li>
			<li class="left_menu"> - <a href="./shop_realname.php">본인/실명인증 설정</a></li>
			<li class="left_menu"> - <a href="./shop_delivery.php">택배사관리</a></li>
		</ul>
	<?}?>

	<?if($leftcode==2){?>
		<div class="left_title"> 컨텐츠관리 </div>
		<ul>
			<li class="left_menu"> - <a href="/dongtuni_adm/board.php?board_id=contents">컨텐츠관리</a></li>
			<li class="left_menu"> - <a href="/dongtuni_adm/board.php?board_id=writer">여행작가 게시물</a></li>
			<li class="left_menu"> - <a href="/dongtuni_adm/support.php">서포터즈관리</a></li>
			<li class="left_menu"> - <a href="/dongtuni_adm/board.php?board_id=news">뉴스레터</a></li>
			<li class="left_menu"> - <a href="/dongtuni_adm/board.php?board_id=notice">이벤트/공지</a></li>
		</ul>
	<?}?>

	<?if($leftcode==3){?>
		<div class="left_title"> 상품관리 </div>
		<ul>
			<!-- <li class="left_menu"> - <a href="./shop_category.php">상품분류관리</a></li>
			<li class="left_menu"> - <a href="./shop_category_sort.php">상품분류정렬</a></li>
			<li class="left_menu"> - <a href="./shop_goods.php?mode=form">상품등록</a></li>
			<li class="left_menu"> - <a href="./shop_goods_excel_up.php">상품다량등록</a></li>
			<li class="left_menu"> - <a href="./shop_goods.php">상품복사/이동/수정</a></li>
			<li class="left_menu"> - <a href="./shop_best_sale.php">베스트셀러관리</a></li>
			<li class="left_menu"> - <a href="./shop_event_sale.php">이벤트셀러관리</a></li>
			<li class="left_menu"> - <a href="./shop_goods_icon.php">상품아이콘관리</a></li> -->
					<li class="left_menu"><a href="./shop_banner.php">구독신청관리</a></li>
					<li class="left_menu"><a href="./shop_schedule.php">구독그룹관리</a></li>

		</ul>
	<?}?>

	<?if($leftcode==4){?>
		<!-- <div class="left_title"> 주문관리 </div>
		<ul>
			<li class="left_menu"> - <a href="./shop_order.php">전체주문</a></li>
			<li class="left_menu"> - <a href="./shop_order.php?tot_state=2">결제완료</a></li>
			<li class="left_menu"> - <a href="./shop_order.php?payment_type=1">무통장입금</a></li>
			<li class="left_menu"> - <a href="./shop_order.php?tot_state=7">교환접수</a></li>
			<li class="left_menu"> - <a href="./shop_order.php?tot_state=5">반품접수</a></li>
			<li class="left_menu"> - <a href="./shop_order.php?tot_state=10">취소접수</a></li>
		</ul> -->
	<?}?>

	<?if($leftcode==5){?>
		<div class="left_title"> 홈페이지관리 </div>
		<ul>
			<li class="left_menu"> - <a href="./shop_popup.php">팝업관리</a></li>
			<li class="left_menu"> - <a href="./shop_banner.php">메인디스플레이관리</a></li>
			<!-- <li class="left_menu"> - <a href="./shop_schedule.php">일정관리</a></li>
			<li class="left_menu"> - <a href="./shop_coupon.php">쿠폰관리</a></li>
			<li class="left_menu"> - <a href="./shop_coupon_publish.php">쿠폰발행관리</a></li>
			<li class="left_menu"> - <a href="./shop_webpage.php">웹페이지관리</a></li>
			<li class="left_menu"> - <a href="./shop_sms_contents.php">문자관리</a></li>
			<li class="left_menu"> - <a href="./shop_sms_send.php?mode=form">즉시문자발송</a></li>
			<li class="left_menu"> - <a href="./shop_sms_send.php">문자발송내역</a></li> -->
		</ul>
	<?}?>



	<?if($leftcode==6){?>
		<div class="left_title"> 회원관리 </div>
		<ul>     
			<li class="left_menu"> - <a href="./shop_member.php">회원관리</a></li>
			<li class="left_menu"> - <a href="./shop_members_rating.php">회원등급관리</a></li>
			<li class="left_menu"> - <a href="./shop_member__rating_name.php">등급명칭관리</a></li>
			<!-- <li class="left_menu"> - <a href="./shop_member_set_reg.php">회원가입설정</a></li> -->
			<li class="left_menu"> - <a href="./shop_member_email_send.php">회원메일링</a></li>
			<li class="left_menu"> - <a href="./shop_point_use.php">적립금사용목록</a></li>
			<li class="left_menu"> - <a href="./shop_point_adjustment.php">적립금지급/차감</a></li>
			<li class="left_menu"> - <a href="./shop_points_provide.php">적립금자동지급</a></li>
		</ul>	
	<?}?>



	<?if($leftcode==7){?>
		<div class="left_title"> 고객센터 </div>
		<ul>     
			<li class="left_menu"> - <a href="./board_register.php">게시판관리</a></li>
			<li class="left_menu"> - <a href="./shop_qanda.php?qna_type=">1:1상담관리</a></li>
			<li class="left_menu"> - <a href="./shop_qanda.php?qna_type=goods">상품문의관리</a></li>
			<li class="left_menu"> - <a href="./shop_review.php">상품평관리</a></li>
		</ul>	
	<?}?>



	<?if($leftcode==8){?>
		<div class="left_title"> 통계 </div>
		<ul>     
			<!-- <li class="left_menu"> - <a href="./shop_statistic_order.php">매출통계</a></li>
			<li class="left_menu"> - <a href="./shop_statistic_goods.php">상품별통계</a></li>
			<li class="left_menu"> - <a href="./shop_statistic_goods.php">회원통계</a></li> -->
			<li class="left_menu"> - <a href="./shop_statistic_visit.php">방문통계</a></li>
			<li class="left_menu"> - <a href="./shop_statistic_goods.php">게시물통계</a></li>
		</ul>	
	<?}?>



	
</div>