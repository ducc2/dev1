<!-- right_menu -->
		<div class="main_rig_menu">
			<div class="ranking_wrap">
				
				<ul class="ranking"> <div class="bb">인기 <span class="bb_orange">글</span></div>
<?


$sql			= "SELECT subject,no FROM sh_board_wr_contents ORDER BY hit DESC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 5");


		$brcnt		= 1; 
		for($i=0;$i<sizeof($row);$i++){ 
			
			$rows					= $row[$i];
			$rows[idx]				= $idx;
			$rows[subject]			= text_cut_kr($rows[subject], $board_info[subject_length]);

			extract($rows);
	
			$rank++;

			if ($rank>3) $rank_class="rank_gr";
			?>
					<li><a href="<?=$mobile_path?>board/board_view.php?board_id=<?=$board_id?>&no=<?=$rows[no]?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>"><span class="num_ranking <?=$rank_class?>"><?=$rank?></span><strong><?=$rows[subject]?></strong></a></li>
			<? } ?>
					<!-- <li><a href="#"><span class="num_ranking">2</span><strong>영월 새해 여행지</strong></a></li>
					<li><a href="#"><span class="num_ranking">3</span><strong>올림픽 특선 메뉴 10선</strong></a></li>
					<li><a href="#"><span class="num_ranking rank_gr">4</span>크루즈 타고 여행 떠나 볼까?</a></li>
					<li><a href="#"><span class="num_ranking rank_gr">5</span>권진규 미술관 춘천에 들어서다!!!!!</a></li> -->
				</ul>
			</div>
			<div class="best_tag clearfix">
				<div class="bb">인기 <span class="bb_green">태그</span></div>
				<? 					
					 $sql			= "SELECT * FROM sh_board_tag_main limit 0,1";
					 $row			= $DB->fetcharr($sql);
					
					 $temp = explode(",",$row['mtag_content']);
					 $temp_c = count($temp);

					 for($i=0;$i<$temp_c;$i++){
					 
					 
						 $final_num =$temp_c-1;
						 if ($i==$final_num) {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%'";
						 } else {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%' or";
						 }

					 ?>
					<span class="hash_tag"><a href="<?=$mobile_path?>sub/tagArchives_list.html?board_id=contents&tag=<?=urlencode(trim($temp[$i]));?>">#<?=trim($temp[$i])?></a></span>
					<?  } ?>
			</div>
			<div class="blog_link"><a href="http://m.post.naver.com/my.nhn?memberNo=265597" target="_blank" title="새창열림"><img src="<?=$mobile_path?>comn/img/img_blog.png" alt="동트는강원 네이버 포스트 바로가기"></a></div>
		 </div><!-- //right_menu -->
		 <!-- footwrap-->
		 <div class="footwrap">
			<div class="foot clearfix">
				<span><a href="<?=$mobile_path?>sub/privacy.html">개인정보 취급방침</a></span><span class="non"><a href="<?=$mobile_path?>sub/copyright.html">저작권보호방침</a></span>
				<div class="tab_sns">
					<a href="https://www.facebook.com/dongtuni"><img src="<?=$mobile_path?>comn/img/icon_f.png" alt="페이스북"></a>
					<a href="http://blog.naver.com/dongtuni"><img src="<?=$mobile_path?>comn/img/icon_b.png" alt="블로그"></a>
				</div>
			</div>
			<p>(우 24266) 강원도 춘천시 중앙로 1 (봉의동) 강원도청 대변인실 <br>
			TEL : 033-249-2034<br>
			Copyright 2011 © Gangwon-do. All Rights Reserved.</p>
		 </div><!--// footwrap-->
		 <a href="#" class="scrollTop">위로</a>
	 </div><!-- //con_wrap -->
</body>
</html>
