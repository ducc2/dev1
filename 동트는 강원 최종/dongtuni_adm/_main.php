<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<div id="cont_left">	

	<div class="left_title">샵관리</div>
	<ul>
		<li class="left_menu"> - <a href="./shop_order.php">전체주문</a></li>
		<li class="left_menu"> - <a href="./shop_order.php?tot_state=2">결제완료</a></li>
		<li class="left_menu"> - <a href="./shop_order.php?tot_state=7">교환접수</a></li>
		<li class="left_menu"> - <a href="./shop_order.php?tot_state=5">반품접수</a></li>
		<li class="left_menu"> - <a href="./shop_goods.php?mode=form">상품등록</a></li>
		<li class="left_menu"> - <a href="./shop_goods.php">상품복사/이동/수정</a></li>
		<li class="left_menu"> - <a href="./shop_info.php">SHOP정보</a></li>
		<li class="left_menu"> - <a href="./shop_basic_set.php">기본설정</a></li>
		<li class="left_menu"> - <a href="./shop_member.php">회원관리</a></li>
		<li class="left_menu"> - <a href="./shop_qanda.php?qna_type=">1:1상담관리</a></li>
		<li class="left_menu"> - <a href="./shop_qanda.php?qna_type=goods">상품문의관리</a></li>
		<li class="left_menu"> - <a href="./shop_statistic_order.php">매출통계</a></li>
		<li class="left_menu"> - <a href="./shop_schedule.php">일정관리</a></li>
	</ul>

</div>

<div id="cont_right_main">
	<div class="main_content_area">				
		<div class="title_left">주문관리</div>
		<div class="title_right"><a href="./shop_order.php">MORE</a></div>
		<div class="line_1px"></div>	
				
		<div class="box_125x105">
			<a href="./shop_order.php?tot_state=2"><span class="number_30px"><?=$order_state_2[cnt]?></span></a><p></p>
			<span class="left_text">결제완료</span>
		</div>
		<div class="box_125x105">
			<a href="./shop_order.php?tot_state=5"><span class="number_30px"><?=$order_state_5[cnt]?></span></a><p></p>
			<span class="left_text">반품신청</span>
		</div>
		<div class="box_125x105">
			<a href="./shop_order.php?tot_state=7"><span class="number_30px"><?=$order_state_7[cnt]?></span></a><p></p>
			<span class="left_text">교환신청</span>
		</div>


		<table class="_list-tb">
			<caption>상품주문 목록</caption>
			<thead>
			<tr>
				<th scope="col">상품정보</th>
				<th scope="col">결제금액</th>
			</tr>
			</thead>
			<tbody>

			<!-- 리스트 루프 시작 -->
			<?
			$mypage_img_path		= "order";
			for($i=0;$i<sizeof($order_row);$i++){
				$order_rows			= $order_row[$i];
				$bg					= 'bg'.($i%2);
				if($order_rows[order_options]){
					$order_options_arr	= explode("^@@^", $order_rows[order_options]);
				}

				if($order_rows[payment_money]>0)	addComma($order_rows[payment_money]); 
				extract($order_rows);
				?>

			<tr class="<?=$bg?>">
				<td class="td_large70">
					<?=$datetime?>( <span class="text_emphasis2"><?=$order_code?></span> )<br>
					<div class="goods_name"><a href="./shop_order.php?mode=update&no=<?=$no?>"><?=text_cut_kr($goods_name, 24)?></a></div>
				</td>
				<td class="td_60_right"><span class="text_emphasis"><?=$payment_money?></span></td>
			</tr>		
			<?
			}
			?>
			<!-- 리스트 루프 끝 -->

			</tbody>
		</table>	
	</div>
	<div class="main_content_area">				
		<div class="title_left">회원/방문자</div>
		<div class="title_right"><a href="./shop_member.php">MORE</a></div>
		<div class="line_1px"></div>	
				
		<div class="box_90x80">
			<a href="./shop_member.php"><span class="number_20px"><?=$mem_cnt[cnt]?></span></a><p></p>
			<span class="left_text">전체회원</span>
		</div> 
		<div class="box_90x80">
			<a href="./shop_member.php"><span class="number_20px"><?=$mem_cnt_yester[cnt]?></span></a><p></p>
			<span class="left_text">어제가입회원</span>
		</div>
		<div class="box_90x80">
			<a href="./shop_statistic_visit.php"><span class="number_20px"><?=$visit_cnt_today[cnt]?></span></a><p></p>
			<span class="left_text">오늘방문자</span>
		</div>
		<div class="box_90x80">
			<a href="./shop_statistic_visit.php"><span class="number_20px"><?=$visit_cnt_yester[cnt]?></span></a><p></p>
			<span class="left_text">어제방문자</span>
		</div>	
				
		<div class="box_180x160">
			<a href="./shop_order.php"><span class="number_30px_blue"><?=$sale_cnt_today[money]?></span></a><p></p>
			<span class="left_text">오늘 매출</span>
		</div> 				
		<div class="box_180x160">
			<a href="./shop_order.php"><span class="number_30px_blue"><?=$sale_cnt_yester[money]?></span></a><p></p>
			<span class="left_text">어제 매출</span>
		</div> 
	</div>



	<div class="main_content_area">				
		<div class="title_left">1:1상담관리</div>
		<div class="title_right"><a href="./shop_qanda.php?qna_type=">MORE</a></div>
		<div class="line_1px"></div>


		<table class="_list-tb">
		<caption>1:1상담관리 목록</caption>
		<thead>
		<tr>
			<th scope="col">제목</th>
			<th scope="col">날짜</th>
		</tr>
		</thead>
		<tbody>

			<!-- 리스트 루프 시작 -->
			<?
			for($i=0;$i<sizeof($qanda_row);$i++){
				$qanda_rows			= $qanda_row[$i];
				$bg					= 'bg'.($i%2);

				extract($qanda_rows);
				?>

			<tr class="<?=$bg?>">
				<td class="td_large80">
					<div class="_name"><?=text_cut_kr($subject, 38)?></a></div>
				</td>
				<td class="td_60_right"><?=substr($datetime, 0, 10)?></td>
			</tr>		
			<?
			}
			?>
			<!-- 리스트 루프 끝 -->

			</tbody>
		</table>	
	
	
	</div>
	<div class="main_content_area">				
		<div class="title_left">상품문의관리</div>
		<div class="title_right"><a href="./shop_qanda.php?qna_type=goods">MORE</a></div>
		<div class="line_1px"></div>

		<table class="_list-tb">
			<caption>상품문의 목록</caption>
			<thead>
			<tr>
				<th scope="col">제목</th>
				<th scope="col">날짜</th>
			</tr>
			</thead>
			<tbody>

			<!-- 리스트 루프 시작 -->
			<?
			for($i=0;$i<sizeof($goods_qna_row);$i++){
				$goods_qna_rows		= $goods_qna_row[$i];
				$bg					= 'bg'.($i%2);
				extract($goods_qna_rows);
				?>

			<tr class="<?=$bg?>">
				<td class="td_large80">
					<div class="_name"><?=text_cut_kr($subject, 38)?></a></div>
					<div class="goods_option"><?=text_cut_kr($goods_name, 34)?></div>
				</td>
				<td class="td_60_right"><?=substr($datetime, 0, 10)?></td>
			</tr>		
			<?
			}
			?>
			<!-- 리스트 루프 끝 -->

			</tbody>
		</table>	
	</div>
</div>