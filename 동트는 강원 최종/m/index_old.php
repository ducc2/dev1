<?
$sh["rPath"]	= "..";
$sh["main"]		= true;
include_once($sh["rPath"]."/_common.php");



$sh["title"] = $sh["stie_title"]."";
include_once($sh["rPath"]."/m/_head.php");
?>

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


		$sql		= "SELECT a.* FROM sh_shop_banner a where a.ban_use=2 ORDER BY a.sequence asc";

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

			$next_sql = "select ban_img from sh_shop_banner where no > ".$rows['no']." order by sequence asc limit 0,1";
			$next_row			= $DB->fetcharr($next_sql);

			if($next_row[ban_img]){
				$filename_exp2	= explode("|", $next_row[ban_img]);
				$ban_img_tmp2	= "<img src='$upUrl/$filename_exp2[1]'>";
			}else{
				$ban_img_tmp2	= "";
			}


			$prev_sql = "select ban_img from sh_shop_banner where no < ".$rows['no']."  order by sequence desc limit 0,1";
			$prev_row			= $DB->fetcharr($prev_sql);

			if($prev_row[ban_img]){
				$filename_exp3	= explode("|", $prev_row[ban_img]);
				$ban_img_tmp3	= "<img src='$upUrl/$filename_exp3[1]'>";
			}else{
				$ban_img_tmp3	= "";
			}

			$rows[ban_name]			= text_cut_kr($rows[ban_name], 12);

			?>
				<div class="item">
					<figure><?=$ban_img_tmp?></figure>
					<div class="objChildren">
						<div class="child">
							<p class="childItem">
								<span class="childTit"><span><?=strip_tags($rows['ban_category'])?></span></span>
								<a href="<?=str_replace("/board/","/m/board/",$rows[ban_img_link])?>">
									<i><?=$rows['ban_name']?></i>
									숨 고르기를 할 시간입니다. 자신에게 채찍질을 하며 숨 가쁘게 달려온 해를 방금 떠나 보냈습니다.잠시 한 박자 쉬어 갈 때입니다. ‘돌아봄’과 ‘내다봄’이 필요한 순간입니다. 그래야만 새해에는 더 알차고, 가치 있는 삶의 힘이 생길 것입니다. 여행을 떠나봅니다. 목적지를 정했거나, 무작정 발길 닿는 대로 떠나거나...
								</a>
							</p>
						</div>
						<div class="childMore">
							<!-- <p class="hit"><span>VIEW</span> 235</p> -->
							<a class="more go-ir" href="<?=$rows[ban_img_link]?>">내용 상세보기</a>
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
<?
$row_big			= $DB->fetcharr("SELECT extra_2,extra_3 FROM sh_board_wr_contents ORDER BY extra_2 desc, extra_3 desc");
$yy = $row_big["extra_2"];
$mm = $row_big["extra_3"];
?>
	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container main" id="container"><!--메인페이지에서만 class main 추가-->
			 <div class="contents">
					<div class="title clearfix">
						<h2 class="tit_main">Contents</h2>
						<span class="main_date"><?=$yy?>년 <?=$mm?>월호</span><!--<div class="last_view"><a href="/sub/ebook_view.html" onclick="popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;">+ 지난호 보기</a></div>-->
					</div>
					<ul class="clearfix">
<?

$sql			= "SELECT a.* FROM sh_board_wr_contents a where a.extra_2 = ".$yy." and a.extra_3 = ".$mm." ORDER BY a.num DESC, a.reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 9");
$tot			= $DB->rows_count($sql);
$idx			= $tot-$rowslimit*($this_page-1);
$linkpage		= page($tot,$rowslimit,$pagelimit);


		$brcnt		= 1; 
		$tot = sizeof($row);

		$line_width = ceil( $tot / 2 )  * 2;

		for($i=0;$i<$line_width;$i++){

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
			
			$rows[subject]			= text_cut_kr($rows[subject], $board_info[subject_length]);
			$rows[content]			= strip_tags(text_cut_kr($rows[content], 92));
			extract($rows);
			
			//echo $i%2;

			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='".$thumb_url."thumb".$row_file[filename]."' class='def'>";
				?>
				<li>
							<a href="<?=$mobile_path?>board/board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>">
								<div class="thumb">
									<?=$board_img?>
									<div class="dark"><img src="<?=$mobile_path?>comn/img/icon_thumb.png"></div>
								</div>
								<h4 class="tit_con"><?=$rows[subject]?></h4></a>
						</li>
				<?
			}else{
				if ($i%2==1) {
					$board_img	= "<img src='comn/img/banner_before.png' onclick=\"location.href='http://gwiyagi.tistory.com/'\">";
					$ahref = "<a href='/sub/ebook_view.html' onclick=\"popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;\">";
				} 
				?>
				<li>
							<a href="<?=$mobile_path?>sub/ebook_view.html" target="_blank" class="beforeLink">동트는강원<strong> 전자책보기</strong><span class="arrow"></span></a>
							<!--<a href="<?=$mobile_path?>sub/back_issue.html" class="beforeLink">강원도가 만들어가는 문화 종합 매거진<strong>동트는강원 전자책보기</strong><span class="arrow"></span></a>-->
				</li>
				<?

			}

?>

						<? } ?>
						<!-- 게시물이 홀수로 끝나면 아래 지난호보기 노출, 짝수로 끝나면 노출안함. -->

						
					</ul>
			  </div><!--// contents-->
		</div><!--// container -->
<? include_once($sh["rPath"]."/m/_bottom_main.php"); ?>

	<script>
// 팝업	u - 주소, n - 이름, w - 넓이, h - 높이, s - 스크롤여부(yes, no), r - 창크기조절여부(yes, no), m - (1:일반, 2:위쪽모서리, 3:정중앙)
function popup(u, n, w, h, s, r, m) {
    var o;
    var lP = screen.availWidth;
    var tP = screen.availHeight;
    var p  = "";
	
	if(s==undefined) s = "no";
	if(m==undefined) m = 1;
	
    if(m==2) //- 위쪽모서리
        p = ",left=0,top=0";
    else if(m==3) //- 정중앙
        p = ",left=" + ((lP - w) / 2) + ",top=" + ((tP - h) / 2);
    
    o = window.open(u,n,"status=yes,toolbar=no,location=no,scrollbars=" + s + ",resizable="+r+",width="+w+",height="+h + p);
    o.focus();
}
	</script>