<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



<!-- 배너관리 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>
	<div>* 메인 디스플레이 이미지는 1200*520 입니다. 위의 사이즈를 참고하셔서 등록하시기 바랍니다</div>

	<div class="area_search2">
		<form name="fsearch" id="fsearch" method="get">
			<input type="hidden" name="search_type" id="search_type" value='1'>

			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="sch_key" id="sch_key" class="selectbox" style="width:140px;">
				<option value="a.ban_name">배너명</option>
			</select>
			<label for="sch_text" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="sch_text" value="<?=$sch_text?>" required class="input_box" style="width:138px;">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
			<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'">	
		</form>
	</div>
	<div class="area_add">
		<input type="button" value=" 배너 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
	</div>
	<div id="content_line"></div>

	<form name="flist" id="flist" action="./shop_<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="updir" value="<?=$updir?>">
		<table class="list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<colgroup>
			<col width="5%">
			<col width="8%">
			<col width="57%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
		</colgroup>
		<thead>
		<tr>
			<th scope="col" width=50>
				<label for="checkAll" class="sound_only">전체 선택</label>
				<input type="checkbox" name="checkAll" value="1" id="checkAll">
			</th>
			<th scope="col" >No</th>
			<th scope="col">배너명</th>
			<th scope="col">순서</th>
			<th scope="col">사용여부</th>
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
			if($rows[ban_img]){
				$filename_exp	= explode("|", $rows[ban_img]);
				$ban_img_tmp	= "<img src='$upUrl/$filename_exp[1]' height='60'>";
			}else{
				$ban_img_tmp	= "";
			}

			$buyNum =$tot-($rowslimit*($this_page-1));
			$Num = $buyNum - $i;
			extract($rows);
			?>

			<tr class="<?=$bg?>">
				<td >
					<label for="chk_<?=$i?>" class="sound_only"><?=$bankname?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="nos[]" value="<?=$no?>">
				</td>
				<td ><?=$Num?></td>
				<td >
					<?=$ban_img_tmp?><br>
					<input type="text" id="ban_name" name="ban_name[]" value="<?=$ban_name?>" style="width:90%">
				</td>
				<td >
					<?=$rows[sequence]?>
				</td>
				<td >
					<label for="ban_use" class="sound_only">사용여부</label>
					<select name="ban_use[]" id="ban_use" class="selectbox">
						<option value="1" <?=($ban_use=="1")?"selected":"";?>>사용안함</option>
						<option value="2" <?=($ban_use=="2")?"selected":"";?>>사용</option>
					</select>
				</td>
				<td ><a href="<?=$PHP_SELF?>?mode=update&no=<?=$no?>&refer=<?=$refer?>">수정</a></td>
				<td ><a href="javascript:one_delete('<?=$no?>')">삭제</a></td>
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
		<input type="button" value=" 배너 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
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
<!-- 배너관리 끝 -->