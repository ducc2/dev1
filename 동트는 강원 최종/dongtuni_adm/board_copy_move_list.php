<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 게리물 복사/이동 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>

	<form name="flist" id="flist" action="./<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
		<input type="hidden" name="state" id="state" value="<?=$mode?>">
		<input type="hidden" name="mode_str" id="mode_str" value="<?=$btn_name?>">
		<input type="hidden" name="board_nos" value="<?=$board_nos?>">
		<input type="hidden" name="board_id" value="<?=$board_id?>">
		<input type="hidden" name="origin_table" value="<?=$board_id?>">
		<div id="content_line"></div>
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
					<label for="chk_<?=$i?>" class="sound_only"><?=$bankname?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="enames[]" value="<?=$ename?>">
				</td>
				<td class="td_no"><?=$idx?></td>
				<td class="td_large"><div style="text-align:left;"><?=$name?></div></td>
				<td class="td_small"><div style="text-align:left;"><?=$ename?></div></td>
			</tr>
		<?
			$idx--;
		}// 루프 끝?>



		</tbody>
		</table>
		<p>
		<div id="content_line"></div>
		
		<div class="btn_button_area">
			<input type="submit" value=" 게시물 <?=$btn_name?> " id="btn_submit" class="button_small_white30x160">		
		</div>	
	</form>
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

	// submit 폼체크
	function flist_submit(state){

		checked		= checked_check();
		var obj		= document.flist;
		if(checked==""){
			alert("선택 항목이 없습니다.");
			return false;
		}


		if(confirm("선택하신 게시물을 <?=$btn_name?> 하시겠습니다.")==false){
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
    </script>

</div>
<!-- 상품복사/이동 끝 -->