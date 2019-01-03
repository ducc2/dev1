<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



<!-- 게시판 관리 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>

	<div class="area_search2">
		<form name="fsearch" id="fsearch" method="get">
			<input type="hidden" name="search_type" id="search_type" value='1'>

			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="sch_key" id="sch_key" class="selectbox" style="width:140px;">
				<option value="a.name">게시판 이름</option>
				<option value="a.ename">게시판 영문 이름</option>
			</select>
			<label for="sch_text" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="sch_text" value="<?=$sch_text?>" required class="input_box" style="width:138px;">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
			<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'"><br>
            <span class="frm_info"><?=$help_img?> <span class="text_emphasis">Q & A, 공지사항</span> 게시판은 샵에서 사용하는 게시판 이어서 <span class="text_emphasis">삭제 할 수 없습니다</span>. 강제로 삭제시 문제가 발생 할 수 있습니다. </span>
		</form>
	</div>
	<div class="area_add">
		<input type="button" value=" 게시판  추가 " id="btn_submit" class="button_small_140" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
	</div>
	<div id="content_line"></div>

	<form name="flist" id="flist" action="./<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="updir" value="<?=$updir?>">
		<table class="list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<thead>
		<tr>
			<th scope="col">
				<label for="checkAll" class="sound_only">전체 선택</label>
				<input type="checkbox" name="checkAll" value="1" id="checkAll">
			</th>
			<th scope="col">No</th>
			<th scope="col">게시판 이름</th>
			<th scope="col">게시판 영문 이름</th>
			<th scope="col">스킨</th>
			<th scope="col">목록권한</th>
			<th scope="col">글읽기</th>
			<th scope="col">글쓰기</th>
			<th scope="col">글답변</th>
			<th scope="col">댓글쓰기</th>
			<th scope="col">수정</th>
			<th scope="col">복사</th>
		</tr>
		</thead>
		<tbody>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			$rows[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			extract($rows);
			?>

			<tr class="<?=$bg?>">
				<td class="td_chk">
					<label for="chk_<?=$i?>" class="sound_only"><?=$name?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="nos[]" value="<?=$no?>">
				</td>
				<td class="td_no"><?=$idx?></td>
				<td class="td_middle3">
					<label for="webpage_name" class="sound_only">게시판  이름</label>
					<input type="text" id="name" name="name[]" value="<?=$name?>" required class="input_box">
				</td>
				<td class="td_small">
					<label for="pop_width" class="sound_only">게시판  영문 이름</label>
					<a href="../board/board.php?board_id=<?=$ename?>" target="_blank"><?=$ename?></a>
				</td>
				<td class="td_small">
					<label for="skin" class="sound_only">피일업로드</label>
					<select name="skin[]" id="skin" class="selectbox">
						<option value=""> 스킨</option>
						<?=arrToption("s", get_skin_dir('board'), $skin, "");?>
					</select>
				</td>
				<td class="td_small">
					<label for="list_grant" class="sound_only">목록권한</label>
					<select name="list_grant[]" id="list_grant" class="selectbox">
						<option value=""> 비회원</option>
						<?=arrToption("sc", $mem_rating, $list_grant, "");?>
					</select>
				</td>
				<td class="td_small">
					<label for="read_grant" class="sound_only">글읽기</label>
					<select name="read_grant[]" id="read_grant" class="selectbox">
						<option value=""> 비회원</option>
						<?=arrToption("sc", $mem_rating, $read_grant, "");?>
					</select>
				</td>
				<td class="td_small">
					<label for="write_grant" class="sound_only">글쓰기</label>
					<select name="write_grant[]" id="write_grant" class="selectbox">
						<option value=""> 비회원</option>
						<?=arrToption("sc", $mem_rating, $write_grant, "");?>
					</select>
				</td>
				<td class="td_small">
					<label for="replay_grant" class="sound_only">글답변</label>
					<select name="replay_grant[]" id="replay_grant" class="selectbox">
						<option value=""> 비회원</option>
						<?=arrToption("sc", $mem_rating, $replay_grant, "");?>
					</select>
				</td>
				<td class="td_small">
					<label for="comment_grant" class="sound_only">댓글쓰기</label>
					<select name="comment_grant[]" id="comment_grant" class="selectbox">
						<option value=""> 비회원</option>
						<?=arrToption("sc", $mem_rating, $comment_grant, "");?>
					</select>
				</td>
				<td class="td_upd"><a href="<?=$PHP_SELF?>?mode=update&no=<?=$no?>&refer=<?=$refer?>">수정</a></td>
				<td class="td_del"><a href="javascript:board_copy_window('<?=$no?>')">복사</a></td>
			</tr>
		<?
			$idx--;
		}// 루프 끝?>



		</tbody>
		</table>
		<div class="list_bottom_left">
			<input type="submit" value=" 선택 수정 " id="btn_submit" class="button_small_white30" onclick="flist_submit('update');">
			<input type="button" value=" 선택 삭제 " id="btn_submit" class="button_small_white30" onclick="drop_multi();">		
		</div>
		<div class="list_bottom_right">
		<input type="button" value=" 게시판  추가 " id="btn_submit" class="button_small_140" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
		</div>
		<div class="list_bottom_center">
			<nav class="pg_wrap"><span class="pg"><?=$linkpage?></span></nav>			
		</div>

	</form>
	<iframe name="ifm_proc" id="ifm_proc" src="" frameborder="0" scrolling="no" style="display:none;"></iframe>

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

		if(confirm("선택하신 항목을 일괄 삭제 하겠습니다.(주의:복구 할 수 없습니다.")==false){
			return;			
		}
		document.getElementById("state").value		= "drop_multi";
		document.flist.submit();
	}

	// submit 폼체크
	function flist_submit(state){
		checked		= checked_check();
		if(checked==""){
			alert("선택 항목이 없습니다.");
			return false;
		}
		if(state=="update"){
			if(confirm("선택하신 항목을 일괄 수정 하시겠습니다.")==false){
				return false;			
			}
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

	function board_copy_window(no){	
		nWidth			= 900;
		nHeight			= 400; 					
		nLeft			= (window.screen.width - nWidth ) / 2; 
		nTop			= (window.screen.height- nHeight) / 2; 
		var upwin		= window.open("./board_copy.php?no="+no, "board_copy", "width="+nWidth+", height="+nHeight+", top="+nTop+", left="+nLeft+", scrollbars=yes");
		upwin.focus();
	}

	

	
    </script>

</div>
<!-- 게시판 관리 끝 -->