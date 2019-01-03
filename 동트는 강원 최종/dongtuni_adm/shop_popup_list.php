<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 팝업관리 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>

	<div class="area_search2">
		<form name="fsearch" id="fsearch" method="get">
			<input type="hidden" name="search_type" id="search_type" value='1'>

			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="sch_key" id="sch_key" class="selectbox" style="width:140px;">
				<option value="a.pop_name">팝업명</option>
			</select>
			<label for="sch_text" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="sch_text" value="<?=$sch_text?>" required class="input_box" style="width:138px;">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
			<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'">	
		</form>
	</div>
	<div class="area_add">
		<input type="button" value=" 팝업 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
	</div>
	<div>
		<span class="frm_info"><?=$help_img?><br>
		- 상단팝업은 최근 등록한 1개만 노출됩니다. <p></p>
		</span>
	</div>
	<div id="content_line"></div>

	<form name="flist" id="flist" action="./shop_<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
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
			<th scope="col">팝업명</th>
			<th scope="col">사용여부</th>
			<th scope="col">팝업크기</th>
			<th scope="col">팝업위치</th>
			<th scope="col">수정</th>
			<th scope="col">삭제</th>
		</tr>
		</thead>
		<tbody>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			$rows[idx]		= $idx;
			$bg				= 'bg'.($i%2);

			$buyNum =$tot-($rowslimit*($this_page-1));
			$Num = $buyNum - $i;

			extract($rows);
			?>

			<tr class="<?=$bg?>">
				<td class="td_chk">
					<label for="chk_<?=$i?>" class="sound_only"><?=$bankname?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="nos[]" value="<?=$no?>">
				</td>
				<td class="td_no"><?=$Num?></td>
				<td class="td_large">
					<label for="pop_name" class="sound_only">팝업명</label>
					<input type="text" id="pop_name" name="pop_name[]" value="<?=$pop_name?>" required class="input_box">
				</td>
				<td class="td_small">
					<label for="pop_use" class="sound_only">사용여부</label>
					<select name="pop_use[]" id="pop_use" class="selectbox">
						<option value="1" <?=($pop_use=="1")?"selected":"";?>>사용안함</option>
						<option value="2" <?=($pop_use=="2")?"selected":"";?>>사용</option>
					</select>
				</td>
				<td class="td_small2">
					<label for="pop_width" class="sound_only">팝업크기</label>
					<input type="text" id="pop_width" name="pop_width[]" value="<?=$pop_width?>" required class="input_box_num_small">
					<input type="text" id="pop_height" name="pop_height[]" value="<?=$pop_height?>" required class="input_box_num_small">
				</td>
				<td class="td_small2">
					<label for="pop_left" class="sound_only">팝업위치</label>
					<input type="text" id="pop_left" name="pop_left[]" value="<?=$pop_left?>" required class="input_box_num_small">
					<input type="text" id="pop_top" name="pop_top[]" value="<?=$pop_top?>" required class="input_box_num_small">
				</td>
				<td class="td_upd"><a href="<?=$PHP_SELF?>?mode=update&no=<?=$no?>&refer=<?=$refer?>">수정</a></td>
				<td class="td_del"><a href="javascript:one_delete('<?=$no?>')">삭제</a></td>
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
		<input type="button" value=" 팝업 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
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

	function one_delete(no){
		if(confirm("선택하신 항목을 삭제 하겠습니다.")==false){
			return;			
		}
		document.location.href = "<?=$PHP_SELF?>?mode=drop&no="+no+"&refer=<?=$refer?>";

	}

	
    </script>

</div>
<!-- 팝업관리 끝 -->