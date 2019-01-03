<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



<!-- 배너관리 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>

	<div class="area_search2">
		<form name="fsearch" id="fsearch" method="get">
			<input type="hidden" name="search_type" id="search_type" value='1'>

			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="sch_key" id="sch_key" class="selectbox" style="width:140px;">
				<option value="a.mem_id">아이디</option>
				<option value="a.mem_name">이름</option>
			</select>
			<label for="sch_text" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="sch_text" value="<?=$sch_text?>" required class="input_box" style="width:138px;">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
			<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'">	
		</form>
	</div>
	<div class="area_add">
		<input type="button" value=" 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
	</div>
	<div id="content_line"></div>

	<form name="flist" id="flist" action="./<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="updir" value="<?=$updir?>">
		<table class="list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<colgroup>
			<col width="5%">
			<col width="6%">
			<col width="22%">
			<col width="22%">
			<col width="5%">
			<col width="5%">
		</colgroup>
		<thead>
		<tr>
			<th scope="col" >
				<label for="checkAll" class="sound_only">전체 선택</label>
				<input type="checkbox" name="checkAll" value="1" id="checkAll">
			</th>
			<th scope="col" >No</th>
			<th scope="col">태그</th>
			<th scope="col">등록일</th>
			<th scope="col">수정</th>
			<th scope="col">삭제</th>
		</tr>
		</thead>
		<tbody>
		<?if (sizeof($row)==0)  { ?>
		<tr><td colspan=5 align="center" height=150>등록된 자료가 없습니다.</td></tr>
		<? } ?>

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
				<td class="td_chk" >
					<label for="chk_<?=$i?>" class="sound_only"><?=$bankname?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="nos[]" value="<?=$rows[mtag_id]?>">
				</td>
				<td class="td_no"><?=$Num?></td>
				<td >
					<?=$rows[mtag_content]?>
				</td>
				<td ><?=$rows[mtag_reg]?></td>

				<td ><a href="<?=$PHP_SELF?>?mode=update&mtag_id=<?=$mtag_id?>&refer=<?=$refer?>">수정</a></td>
				<td ><a href="javascript:one_delete('<?=$mtag_id?>')">삭제</a></td>
			</tr>
		<?
			$idx--;
		}// 루프 끝?>



		</tbody>
		</table>
		<div class="list_bottom_left">
			<!-- <input type="submit" value=" 선택 수정 " id="btn_submit" class="button_small_white30" onclick="flist_submit('update');"> -->
			<input type="button" value=" 선택 삭제 " id="btn_submit" class="button_small_white30" onclick="drop_multi();">		
		</div>
		<div class="list_bottom_right">
		<input type="button" value=" 추가 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
		</div>
		<div class="list_bottom_center">
			<nav class="pg_wrap"><span class="pg">
			<div class="paging"><?=$linkpage?></div>
			</span></nav>			
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
		document.location.href = "<?=$PHP_SELF?>?mode=drop&mtag_id="+no+"&refer=<?=$refer?>";

	}

	
    </script>

</div>
<!-- 배너관리 끝 -->