<!-- 일반페이지용 bottom -->
<?
$board_id			="contents";
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/";
$thumb_url			= "../data/board/".$board_id."/thumb/";
$upUrl				= "../data/board/".$board_id;
?>
		<!-- right_menu -->
		<div class="right_menu">
			<!-- hash_news-->
			<div class="hash_news">
				<div class="hash_tit">해시<span class="point_g">기사</span></div>
				<div class="news_list">
					
					<div class="hash_tag_wrap clearfix">

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



					<span class="hash_tag"><a href="/sub/tagArchives_list.html?board_id=contents&tag=<?=urlencode(trim($temp[$i]));?>">#<?=trim($temp[$i])?></a></span>
					<?  } ?>

					</div>
						<ul>
<?
$sql			= "SELECT category,subject,no FROM sh_board_wr_contents where ".$where_sql." ORDER BY num DESC, reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 5");
$tot			= $DB->rows_count($sql);


		$brcnt		= 1; 
		for($i=0;$i<sizeof($row);$i++){ 
			
			$rows					= $row[$i];
			$rows[idx]				= $idx;
			$rows[subject]			= text_cut_kr($rows[subject], 26);
			extract($rows);

			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='".$thumb_url."thumb".$row_file[filename]."' alt='사진'>";
			}else{
				$board_img	= "<img src='".$updir."".$row_file[filename]."' alt='사진'>";
			}
			
			?>
							<li class="clearfix">
								<a href="../board/board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$rows[category]?>&refer=<?=$refer?>">
									<div class="news_pic"><?=$board_img?></div>
									<div class="txt"><h4><?=$rows[category]?></h4><?=$rows[subject]?></div>
								</a>
							</li>
	<? } ?>
						</ul>

				</div>
			</div><!-- //hash_news-->
			<div class="facebook_news">
				<!-- 페이스북영역 -->
							<script  src="http://cornfestival.co.kr/comn/js/facebook.js"></script>
					<div class="fb-like-box" data-href="https://www.facebook.com/dongtuni" data-width="246" data-height="390" data-show-faces="false" data-stream="true" data-show-border="true" data-header="false"></div>
				<!-- //페이스북영역 -->
			</div>
			<div class="blog_link"><a href="http://post.naver.com/my.nhn?memberNo=265597" target="_blank" title="새창열림"><img src="../comn/img/img_blog.png" alt="동트는강원 네이버 포스트 바로가기"></a></div>
		 </div><!-- //right_menu -->

		 <!-- footwrap-->
		 <div class="footwrap">
			<div class="foot clearfix">
				<span><a href="/sub/privacy.html">개인정보 취급방침</a></span><span class="non"><a href="/sub/copyright.html">저작권보호방침</a></span>
				<div class="tab_sns">
					<a href="https://www.facebook.com/dongtuni" target="_blank"><img src="../comn/img/icon_f.png" alt="페이스북"></a>
					<a href="http://blog.naver.com/dongtuni" target="_blank"><img src="../comn/img/icon_b.png" alt="블로그"></a>
					<a href="#"><img src="../comn/img/icon_top.png" alt="위로"></a>
				</div>
			</div>
			<p>(우 24266) 강원도 춘천시 중앙로 1 (봉의동) 강원도청 대변인실 TEL : 033-249-2034<br>
			Copyright 2011 © Gangwon-do. All Rights Reserved.</p>
		 </div><!--// footwrap-->
	 </div><!-- //con_wrap -->
</body>

</html>


<?
include_once($sh["rPath"]."/_visit.php");
?>