<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">

.board_list-tb th { border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; text-align:center;}
.board_list-tb th {display: table-cell; height: 40px; letter-spacing: -1px; vertical-align: middle; border-bottom: 2px solid #dddddd; padding:2px 2px 2px 2px;}
.board_list-tb td { border-bottom: 1px solid #dddddd; padding:5px 5px 5px 5px;}
.board_list-tb td { height: 30px; letter-spacing: -1px; vertical-align: middle; text-align: center;}
.board_list-tb {width:100%;}
.board_list-tb caption {font-weight: bold; text-align: left;}

.area_search { width:400px; float: left; padding: 7px 0 7px;}
.area_search2 { width:660px; float: left; padding: 7px 0 7px;}
.area_add { padding: 7px 0 7px; overflow: hidden; text-align:right;}
.area_bottom { width:360px; float: left; padding: 7px 0 7px;}
.recomment_area { width:160px; margin: 0 auto; padding: 7px 0 7px; }
.btn_button_area { width:160px; margin: 0 auto; padding: 7px 0 7px; }
.board_category {width:100%; height:35px; padding-top:10px;}

</style>
<!-- 스킨별 CSS 끝 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->



<!-- 게시물 목록 시작 -->
<div id="cont_right">
	<div class="location_title">게시 컨텐츠</div>


	<!-- <div class="area_add">
		<input type="button" value=" 글쓰기 " id="btn_submit" class="button_small" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">
	</div> -->
	<div id="content_line"></div>

	<?if($board_info[category]){?>
		<div class="board_category">
		<!-- 게시판 분류 시작 -->
		<?
		$cate_tmp	= explode("|", $board_info[category]);
		for($i=0; $i < count($cate_tmp); $i++)	 {
		?>
			<a href="./board.php?board_id=<?=$_GET['board_id']?>&catge=<?=$cate_tmp[$i]?>"><?=$cate_tmp[$i]?></a>
		<? }?>
		</div>
	<?}?>

	<form name="flist" id="flist" action="./board_proc.php" onsubmit="return flist_submit(this);" method="post" >
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="board_id" value="<?=$board_id?>">
		<input type="hidden" name="updir" value="<?=$updir?>">
		<table class="board_list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<thead>
		<tr>
			<th scope="col">
				<label for="checkAll" class="sound_only">전체 선택</label>
				<input type="checkbox" name="checkAll" value="1" id="checkAll">
			</th>
			<th scope="col">번호</th>
			
			<?if($board_info[category]){?>
				<th scope="col">분류</th>
			<?}?>

			<th scope="col">제목</th>
			<th scope="col">이름</th>
			<th scope="col">등록일</th>
			<th scope="col">조회</th>	
			
			<?if($board_info[recommender_use]=="2"){?>
				<th scope="col">추천</th>
			<?}?>
		</tr>
		</thead>
		<tbody>
		
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
			extract($rows);
			?>

		<tr class="<?=$bg?><?=$noticecss?>">
			<td class="td_chk">
				<label for="chk_<?=$i?>" class="sound_only"><?=$subject?></label>
				<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
				<input type="hidden" name="nos[]" value="<?=$no?>">
			</td>
			<td class="td_no"><?=$idx2?></td>
			
			<?if($board_info[category]){?>
				<td  class="td_small"><?=$category?></td>
			<?}?>

			<td class="td_large">
				<div class="large_content" style="<?=$reply_padding?>">
					<a href="./board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&this_page=<?=$this_page?>&refer=<?=$refer?>">
					<?=$reply_image?><?=$subject?></a>  <?=$comment?> <?=$options_image?> <?=$file_image?> <?=$new_image?> <?=$best_image?>
				<div>
			</td>
			<td class="td_small"><?=$name?></td>
			<td class="td_small"><?=substr($datetime, 0, 10)?></td>
			<td class="td_no"><?=$hit?></td>	
			
			<?if($board_info[recommender_use]=="2"){?>
				<td  class="td_no"><?=$good?></td>
			<?}?>
		</tr>		
		<?
			$idx--;
		}?>
		<!-- 리스트 루프 끝 -->

		<?if (sizeof($row)==0) { ?>
				<tr><td  colspan=10 >등록된 자료가 없습니다.</td></tr>
		<? } ?>
		</tbody>
		</table>
		
		<div class="list_bottom_left2">
			<input type="button" value=" 목 록 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board.php?board_id=<?=$board_id?>'">	
			<?// 관리자만 노출
			if($_SESSION["admin_id_session"]){?>
				<input type="button" value=" 선택삭제 " id="btn_submit" class="button_small_white30" onclick="drop_multi();">	
				<input type="button" value=" 선택복사 " id="btn_submit" class="button_small_white30" onclick="board_copy_move_proc('copy');">
				<input type="button" value=" 선택이동 " id="btn_submit" class="button_small_white30" onclick="board_copy_move_proc('move');">		
			<?}?>
		</div>
		<div class="list_bottom_right2">
			<input type="button" value=" 글쓰기 " id="btn_submit" class="button_small" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">
		</div>

		<div class="list_bottom_page">
			<nav class="pg_wrap"><span class="pg"><?=$linkpage?></span></nav>			
		</div>	
	</form>
		
	<div class="area_search">
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
