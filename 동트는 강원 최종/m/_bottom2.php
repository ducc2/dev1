<!-- right_menu -->
		<div class="right_menu">
			<!-- hash_news-->
			<div class="hash_news">
				<div class="hash_tit">해시<span class="point_g">기사</span></div>
				<? if ($_GET['no']) { ?>
				<div class="news_list">
					<div class="hash_tag_wrap clearfix">
				<? 					
					 $temp = explode(",",$row['extra_4']);
					 $temp_c = count($temp);


					 for($i=0;$i<$temp_c;$i++ ) {
						 
						 $final_num =$temp_c-1;
						 if ($i==$final_num) {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%'";
						 } else {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%' or";
						 }

					 ?>
					<span class="hash_tag"><a href="<?=$mobile_path?>sub/tagArchives_list.html?board_id=<?=$board_id?>&tag=<?=urlencode($temp[$i])?>">#<?=$temp[$i]?></a></span>
					<?  } ?>
					</div>
						<ul>

<?


$sql			= "SELECT * FROM sh_board_wr_contents where ".$where_sql." ORDER BY num DESC, reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 5");


		$brcnt		= 1; 
		for($i=0;$i<sizeof($row);$i++){ 
			
			$rows					= $row[$i];
			$rows[idx]				= $idx;
			$bg						= 'bg'.($i%2);
			$regdate				= strtotime($rows[datetime]);
			$today_time				= strtotime(date("Y-m-d H:i:s", strtotime("- ".$board_info[new_icon]." hour"))); 

			$reply_padding			= ($rows[reply])							? "padding-left:".(strlen($rows[reply]) * 20). "px;" : "";	
			$reply_image			= ($rows[reply])							? "<img src='".$board_skin."/img/icon_reply.png'>" : "";	
			$options_image			= ($rows[options]=="secret")				? "<img src='".$board_skin."/img/icon_secret.gif'>" : "";	
			$file_image				= ($rows[file] >0)							? "<img src='".$board_skin."/img/icon_file.gif'>" : "";	
			$new_image				= ($today_time < $regdate)					? "<img src='".$board_skin."/img/icon_new.gif'>" : "";	
			$best_image				= ($rows[hit] > $board_info[best_icon])		? "<img src='".$board_skin."/img/icon_best.gif'>" : "";	
			$rows[comment]			= ($rows[comment] > 0)						? "(".$rows[comment].")" : "";			
			$rows[idx2]				= ($rows[notice] == 1)						? "공지" : "";			
			$rows[noticecss]		= ($rows[notice] == 1)						? "_notice" : "";
			
			$rows[subject]			= text_cut_kr($rows[subject], 26);
			$rows[content]			= text_cut_kr(strip_tags($rows[content]),26);
			extract($rows);

			//echo $table02;
			if ($board_id == "writer"){ $board_id = "contents"; }

			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='contents' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='/data/board/contents/thumb/thumb".$row_file[filename]."' width=73 height=53>";
			}else{
				$board_img	= "<img src='/comn/img/noImg.png' width=73 height=53>";
			}
			
			?>
							<li class="clearfix">
								<a href="<?=$mobile_path?>board/board_view.php?board_id=contents&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>">
									<div class="news_pic"><?=$board_img?></div>
									<div class="txt"><h4><?=$rows[category]?></h4><?=$rows[subject]?></div>
								</a>
							</li>
	<? } ?>
							
						</ul>
				</div>
				<? } else { ?>
				<div class="news_list">
					<div class="hash_tag_wrap clearfix">
					
 					<? 					
					$sql			= "SELECT * FROM sh_board_tag ORDER BY tag_count DESC";
					$row			= $DB->dfetcharr($sql." LIMIT 0,5");

					 for($i=0;$i<sizeof($row);$i++){

						 $rows			= $row[$i];
						 $temp[]		= $rows[tag_content];

						 $final_num =sizeof($row)-1;
						 if ($i==$final_num) {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%'";
						 } else {
							$where_sql .= " extra_4 like '".trim($temp[$i])."%' or";
						 }

					 ?>
					<span class="hash_tag"><a href="<?=$mobile_path?>sub/tagArchives_list.html?board_id=<?=$board_id?>&tag=<?=urlencode($rows[tag_content]);?>">#<?=$rows[tag_content]?></a></span>
					<?  } ?>
					</div>
						<ul>
							<?
$board_id = "contents";
$thumb_url			= "../../data/board/".$board_id."/thumb/";
$sql			= "SELECT * FROM sh_board_wr_contents where ".$where_sql." ORDER BY num DESC, reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 5");


		$brcnt		= 1; 
		for($i=0;$i<sizeof($row);$i++){ 
			
			$rows					= $row[$i];
			$rows[idx]				= $idx;
			$regdate				= strtotime($rows[datetime]);
			$today_time				= strtotime(date("Y-m-d H:i:s", strtotime("- ".$board_info[new_icon]." hour"))); 

			$reply_padding			= ($rows[reply])							? "padding-left:".(strlen($rows[reply]) * 20). "px;" : "";	
			$reply_image			= ($rows[reply])							? "<img src='".$board_skin."/img/icon_reply.png'>" : "";	
			$options_image			= ($rows[options]=="secret")				? "<img src='".$board_skin."/img/icon_secret.gif'>" : "";	
			$file_image				= ($rows[file] >0)							? "<img src='".$board_skin."/img/icon_file.gif'>" : "";	
			$new_image				= ($today_time < $regdate)					? "<img src='".$board_skin."/img/icon_new.gif'>" : "";	
			$best_image				= ($rows[hit] > $board_info[best_icon])		? "<img src='".$board_skin."/img/icon_best.gif'>" : "";	
			$rows[comment]			= ($rows[comment] > 0)						? "(".$rows[comment].")" : "";			
			$rows[idx2]				= ($rows[notice] == 1)						? "공지" : "";			
			$rows[noticecss]		= ($rows[notice] == 1)						? "_notice" : "";
			
			$rows[subject]			= text_cut_kr($rows[subject], 26);
			$rows[content]			= text_cut_kr(strip_tags($rows[content]),26);
			extract($rows);
			
			//echo $thumb_url;
			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			//print_r($row_file);

			if($row_file[filename]){
				$board_img	= "<img src='".$thumb_url."thumb".$row_file[filename]."' width=73 height=53>";
			}else{
				$board_img	= "<img src='".$updir."".$row_file[filename]."' width=73 height=53>";
			}
			
			?>
							<li class="clearfix">
								<a href="<?=$mobile_path?>board/board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>">
									<div class="news_pic"><?=$board_img?></div>
									<div class="txt"><h4><?=$rows[category]?></h4><?=$rows[subject]?></div>
								</a>
							</li>
	<? } ?>
						</ul>
				</div>
				<? } ?>
			</div><!-- //hash_news-->
			<div class="blog_link"><a href="http://m.post.naver.com/my.nhn?memberNo=265597" target="_blank" title="새창열림"><img src="<?=$mobile_path?>comn/img/img_blog.png" alt="동트는강원 네이버 포스트 바로가기"></a></div>
		 </div><!-- //right_menu -->

		 <!-- footwrap-->
		 <div class="footwrap">
			<div class="foot clearfix">
				<span><a href="<?=$mobile_path?>sub/privacy.html">개인정보 취급방침</a></span><span class="non"><a href="<?=$mobile_path?>sub/copyright.html">저작권보호방침</a></span>
				<div class="tab_sns">
					<a href="https://www.facebook.com/dongtuni"><img src="../comn/img/icon_f.png" alt="페이스북"></a>
					<a href="http://blog.naver.com/dongtuni"><img src="../comn/img/icon_b.png" alt="블로그"></a>
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