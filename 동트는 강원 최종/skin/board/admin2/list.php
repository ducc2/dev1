<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">

.con_wrap .container .contents .title {margin-bottom: 14px;}
.con_wrap .container .contents .title h2 {color:#10BA00; font-size:34px; margin-bottom: 10px; height: auto; padding:0;}
.con_wrap .container .contents .title h2 .tit_date {font-weight: normal; border-radius: 3px; color:#cfcece; background:#666; width:39px; height:39px; line-height:17px; font-size:9px; margin-right:15px; display:inline-block; text-align:center;}
.con_wrap .container .contents .title h2 .tit_date span {font-size:21px; display:inline-block; color:#fff; font-weight:bold; font-family: gotham;}
.con_wrap .container .contents .title h2 span.tit_date span.year {font-size:9px;}
.con_wrap .container .contents .title span.sub_date {color:#989898; float:left; margin-right: 20px;}
.con_wrap .container .contents .title span.writer {color:#989898; float:left; margin-right: 20px;}
.con_wrap .container .contents .title button {color:#989898; float:right; font-size: 12px; cursor: pointer; outline: 0; background: none; border: 0;}
.con_wrap .container .contents .title button span.add  {display:inline-block; color:#fff; width:58px; height:20px; line-height:20px; margin-left: 10px; text-align:center; border-radius:3px; border:1px solid #b4b4b4; font-size: 11px; background:#b4b4b4;}

.con_wrap .container .contents h2 {font-size:30px; font-weight:600; padding-bottom:20px;}
.con_wrap .container .contents .represent {display:block; text-align:center; margin-bottom:30px;}
.con_wrap .container .contents .represent img {width:100%;}
.con_wrap .container .contents ul.contents_list {margin-right:-20px}
.con_wrap .container .contents ul.contents_list li {float:left; width: 33.33%; position: relative; overflow:hidden; }
.con_wrap .container .contents ul.contents_list li a {display:block; margin:0 30px 30px 0; height:335px; border:1px solid #ddd;}
.con_wrap .container .contents ul.contents_list li a .thumb {height:208px; overflow:hidden; box-sizing: border-box; background:#043200 url(../img/noImg.png) no-repeat center center;}
.con_wrap .container .contents ul.contents_list li a .thumb > img {width:100%; height:100%;}
.con_wrap .container .contents ul.contents_list li a .thumb .dark {border: 3px solid #f64b00; box-sizing: border-box; position:absolute; left:0; right:0; top:0; bottom:0; display:none; margin:0 30px 30px 0; z-index:2;}
.con_wrap .container .contents ul.contents_list li a .thumb .dark > img {position:absolute; left:50%; margin-left:-29px; top:56px; border: 0; width:auto; height:auto;}
.con_wrap .container .contents ul.contents_list li a:hover {background:#ff763a;}
.con_wrap .container .contents ul.contents_list li a:hover .thumb {background:#000;}
.con_wrap .container .contents ul.contents_list li a:hover .dark {display:block;}
.con_wrap .container .contents ul.contents_list li a:hover .def{ -webkit-transform: scale(1.1); transform: scale(1.1); transition-duration: 0.6s; opacity:0.6;}
.con_wrap .container .contents ul.contents_list li:nth-child(3n) {padding-right:0;}
.con_wrap .container .contents ul.contents_list li .txt {position:relative; z-index:3;}
.con_wrap .container .contents ul.contents_list li h4.tit_con { font-weight:bold; color:#333;  text-align: center; font-size:14px; line-height: 24px; margin: 7px 20px;  display: -webkit-box;  text-overflow: ellipsis; -webkit-box-orient: vertical; -webkit-line-clamp: 1; overflow: hidden;}
.con_wrap .container .contents ul.contents_list li h4.tit_con  span {color:#10ba00; border-bottom: 1px solid #10ba00; display: block; font-size: 13px; width: 44px; margin: 0 auto 5px;}
.con_wrap .container .contents ul.contents_list li p {margin:5px 20px; padding-top:10px; border-top:1px dashed #ddd}
.con_wrap .container .contents ul.contents_list li p.writer {border:0; font-size:11px; font-weight:600; color:#999;}

.con_wrap .container .contents ul.contents_list li a:hover h4,
.con_wrap .container .contents ul.contents_list li a:hover p {color:#fff;}
.con_wrap .container .contents ul.contents_list li a:hover h4.tit_con  span {color:#fff; border-bottom:1px solid #fff;}

.con_wrap .container .contents .mapArea {margin:30px 0;}
.con_wrap .container .contents .mapArea #map {height:350px; border:1px solid #ddd;}
.con_wrap .container .contents .mapArea .mapInfo {background:url('../img/icon_map.png') no-repeat 0 2px; font-weight:600; padding-left:18px; margin-bottom:10px;}

.con_wrap .container .contents .photo_copy {border:1px solid #ddd; padding:10px; overflow:hidden; margin:30px 0;}
.con_wrap .container .contents .photo_copy .info {color:#666;}
.con_wrap .container .contents .photo_copy .info span {display:inline-block; font-weight:800; color:#10ba00;}

/*.con_wrap .container .contents p {padding-top: 20px; letter-spacing:-0.1px;}*/
.con_wrap .container p.bold {font-size:16px; font-weight:bold; letter-spacing:-0.1px;}
/*
.con_wrap .container .contents .hash_tag_wrap {padding: 20px 0 0; }
.con_wrap .container .contents .hash_tag_wrap span.hash_tag { margin-bottom: 7px; margin-right: 7px; float: left; width:54px; text-align:center; height:23px; line-height:23px; background:#10ba00; border-radius:2px;}
.con_wrap .container .contents .hash_tag_wrap span.hash_tag a {color:#fff; font-size:12px;}
*/
.con_wrap .container .share_area {background:#eee; width:100%; height:40px; margin:30px 0 40px; position:relative;}
.con_wrap .container .share_area .share_icon {float:right; position:relative; margin-right:10px;}
.con_wrap .container .share_area .share_icon a span {float:left; margin-top: 10px; cursor: pointer;}
.con_wrap .container .share_area p.share_alert { border: 3px solid #ccc; position: absolute; top: -45px; margin-left:-50px; background: #fff; padding: 8px 5px; }
.con_wrap .container .share_area p.share_alert span {margin-top:0;}
.con_wrap .container .share_area p.share_alert span.triangle {display: inline-block; z-index: 50; background: url(../img/triangle.png) no-repeat; position: absolute; top: 37px; width: 18px; height: 15px;  left: 50%; margin-left: -9px;}

</style>
<!-- 스킨별 CSS 끝 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->



<!-- 게시물 목록 시작 -->

	<!-- <div class="area_add">
		<input type="button" value=" 글쓰기 " id="btn_submit" class="button_small" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">
	</div> -->

	<?if($board_info[category]){?>
		<div class="board_category">
		<a href="./board.php?board_id=<?=$_GET['board_id']?>&cate=<?=$cate_tmp[$i]?>">전체</a>
		<!-- 게시판 분류 시작 -->
		<?
		$cate_tmp	= explode("|", $board_info[category]);
		for($i=0; $i < count($cate_tmp); $i++)	 {
		?>
			<a href="./board.php?board_id=<?=$_GET['board_id']?>&cate=<?=$cate_tmp[$i]?>"><?=$cate_tmp[$i]?></a>
		<? }?>
		</div>
	<?}?>

	<form name="flist" id="flist" action="./board_proc.php" onsubmit="return flist_submit(this);" method="post" >
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="board_id" value="<?=$board_id?>">
		<input type="hidden" name="updir" value="<?=$updir?>">
			<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">
			<div class="contents">

				<h2><?=$cate?></h2>

					<ul class="contents_list clearfix">
		
		<!-- 리스트 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
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
			$rows[idx2]				= ($rows[notice] == 1)						? "공지" : $rows[idx];			
			$rows[noticecss]		= ($rows[notice] == 1)						? "_notice" : "";
			
			$rows[subject]			= text_cut_kr($rows[subject], $board_info[subject_length]);
			$rows[content]			= text_cut_kr(strip_tags($rows[content]), 84);
			extract($rows);

				$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='/data/board/".$board_id."/thumb/thumb".$row_file[filename]."' >";
			}else{
				$board_img	= "";
			}

			?>

		<li>
							<a href="./board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>">
								<div class="thumb">
									<?=$board_img?>
									<div class="dark"><img src="../comn/img/icon_thumb.png"></div>
								</div>
								<h4 class="tit_con"><span><?=$rows[category]?></span>
								<?=$subject?></h4>
								<p><?=$rows[content]?></p>
							</a>
						</li>
		<?
			$idx--;
		}?>
		<!-- 리스트 루프 끝 -->

		</ul>

		<?if (sizeof($row)==0) { ?>
				<div class="paging">등록된 자료가 없습니다.</div>
		<? } ?>

					<div class="paging">
						<?=$linkpage?>
					</div>
		</div>

		</div>

		<div class="list_bottom_page">
			<nav class="pg_wrap"><span class="pg"><input type="button" value=" 목 록 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board.php?board_id=<?=$board_id?>'"><input type="button" value=" 글쓰기 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">	</span></nav>			
		</div>	
	</form>
		
	<div class="list_bottom_page">
		<nav class="pg_wrap"><span class="pg">
		<form name="fsearch" id="fsearch" method="get">
			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="sch_key" id="sch_key" class="selectbox">
				<option value="a.subject">제목</option>
				<option value="a.subject+content">제목 + 내용</option>
				<option value="a.name">이름</option>
				<option value="a.mem_id">아이디</option>
			</select>
			<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="search_text" value="<?=$sch_text?>" required class="input_box">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">
			<input type="hidden" name="cate" value="<?=$cate?>">
			<input type="hidden" name="board_id" value="<?=$board_id?>">
		</form>
		</span></nav>
	</div>	
	<iframe name="ifm_proc" id="ifm_proc" src="" frameborder="0" scrolling="no" style="display:none;"></iframe>

	
	<div id="pass_check" class="board_pass_check" style="display:none;">
		<iframe name="ifm2_proc" id="ifm2_proc" src="" frameborder="0" scrolling="no" style="display:block;width:100%;height:100%;"></iframe>
	</div>

    <script>
	$(document).ready(function() {

		// 체크 박스 모두 체크
		$("#checkAll").click(function() {
			if($(this).is(":checked")){
				$("input[name='chk[]']:checkbox").each(function() {
					$(this).attr("checked", true);
				});
			}else{
				$("input[name='chk[]']:checkbox").each(function() {
					$(this).attr("checked", false);
				});
			}
		});
	});

	function drop_multi(){
		checked		= checked_check();
		if(checked==""){
			alert("선택 항목이 없습니다.");
			return;
		}

		if(confirm("선택하신 항목을 삭제 하겠습니다.")==false){
			return;			
		}
		document.getElementById("state").value		= "drop_multi";
		document.flist.submit();
	}

	// submit 폼체크
	function flist_submit(){
		checked		= checked_check();
		if(checked==""){
			alert("선택 항목이 없습니다.");
			return false;
		}

		if(confirm("선택하신 항목을 일괄 수정 하시겠습니다.")==false){
			return false;			
		}
		return true;
	}

	function checked_check(){
		var checked = []
		$("input[name='chk[]']:checked").each(function () {
			checked.push(parseInt($(this).val()));
		});
		return checked;
	}

	function one_delete(no){
		if(confirm("선택하신 항목을 삭제 하겠습니다.")==false){
			return;			
		}
		document.location.href = "<?=$PHP_SELF?>?mode=drop&no="+no+"&refer=<?=$refer?>";

	}


	function board_copy_move_proc(mode){
		checked		= checked_check();
		if(checked==""){
			alert("선택 항목이 없습니다.");
			return false;
		}

		document.getElementById("state").value		= "board_move";
		var form		= document.getElementById("flist");
		nWidth			= 600;
		nHeight			= 500; 					
		nLeft			= (window.screen.width - nWidth ) / 2; 
		nTop			= (window.screen.height- nHeight) / 2; 
		var upwin		= window.open("", "board_copy_move", "width="+nWidth+", height="+nHeight+", top="+nTop+", left="+nLeft+", scrollbars=yes");
		form.action		= './board_copy_move.php?mode='+mode;
		form.target		= "board_copy_move";
		form.method		= 'post';
		form.submit();
		upwin.focus();
		return false;	
	}

	
    </script>

</div>
<!-- 게시물 목록 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
