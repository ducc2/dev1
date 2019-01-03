<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



<!-- 배너관리 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>

	<div class="area_search3">
		<form name="fsearch" id="fsearch" method="get">
			<input type="hidden" name="search_type" id="search_type" value='1'>

			<label for="sch_key" class="sound_only">검색대상</label>
			<select name="subscribeType" id="subscribeType" class="selectbox" style="width:90px;  height:30px">
				<option value="">구독형태</option>
				<option value="both" <? if ( $_GET['subscribeType']=="both") { echo "selected"; } ?>>전체구독</option>
				<option value="online" <? if ( $_GET['subscribeType']=="online") { echo "selected"; } ?>>온라인</option>
				<option value="offline" <? if ( $_GET['subscribeType']=="offline") { echo "selected"; } ?>>오프라인</option>
			</select>
			<select name="ggr" id="search2" class="selectbox" style="width:160px;  height:30px">
				<option value="">그    룹</option>
				<?
					$sql2		= "SELECT * FROM sh_group ORDER BY no ASC";
					$row2		= $DB->dfetcharr($sql2);
			
				for($i=0;$i<sizeof($row2);$i++){
					$rows2			= $row2[$i];
					?>
				<option value="<?=$rows2['no']?>" <? if ( $_GET['ggr']==$rows2['no']) { echo "selected"; } ?>><?=$rows2['name']?></option>
				<? } ?>
			</select>
			<select name="stype" id="search3" class="selectbox" style="width:90px;  height:30px">
				<option value="">발송형태</option>
				<option value="택배" <? if ( $_GET['stype']=="택배") { echo "selected"; } ?>>택배</option>
				<option value="우편" <? if ( $_GET['stype']=="우편") { echo "selected"; } ?>>우편</option>
			</select>
			<select name="cancel" id="sch_key" class="selectbox" style="width:90px; height:30px">
				<option value="">구독상태</option>
				<option value="N" <? if ( $_GET['cancel']=="N") { echo "selected"; } ?>>구독중</option>
				<option value="Y" <? if ( $_GET['cancel']=="Y") { echo "selected"; } ?>>해지</option>
				
			</select>
			<select name="sch_key" id="sch_key" class="selectbox" style="width:90px; height:30px">
				<option value="a.userNm" <? if ( $_GET['sch_key']=="a.userNm") { echo "selected"; } ?>>이름</option>
				<option value="a.tel" <? if ( $_GET['sch_key']=="a.tel") { echo "selected"; } ?>>전화번호</option>
				<option value="a.email" <? if ( $_GET['sch_key']=="a.email") { echo "selected"; } ?>>이메일</option>
			</select>
			<label for="sch_text" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="sch_text" id="sch_text" value="<?=$sch_text?>" class="input_box" style="width:120px; height:24px">
			<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
			<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'">	
		</form>
	</div>
	<div class="area_add">
		<input type="button" value=" 엑셀생성 " class="btn_excel" onclick="document.location.href='./__excel_download.php?where=<?=base64_encode($swhere)?>&stype=news'">
		<input type="button" value=" DM발송용 " class="btn_excel" onclick="document.location.href='./__excel_download2.php?where=<?=base64_encode($swhere)?>&stype=news'">
	</div>
	<div id="content_line"></div>

	<form name="flist" id="flist" action="./<?=$include_file?>_proc.php" onsubmit="return flist_submit(this);" method="post">
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="updir" value="<?=$updir?>">
		<table class="list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<colgroup>
			<col width="5%">
			<col width="8%">
			<col width="18%">
			<col width="18%">
			<col width="14%">
			<col width="8%">
			<col width="20%">
			<col width="8%">
			<col width="7%">
		</colgroup>
		<thead>
		<tr>
			<th scope="col">
				<label for="checkAll" class="sound_only">전체 선택</label>
				<input type="checkbox" name="checkAll" value="1" id="checkAll">
			</th>
			<th scope="col" >No</th>
			<th scope="col">이름</th>
			<th scope="col">전화번호</th>
			<th scope="col">E-mail</th>
			<th scope="col">구독형태</th>
			<th scope="col">그룹</th>
			<th scope="col">구독상태</th>
			<th scope="col">등록일</th>
		</tr>
		</thead>
		<tbody>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			
			$bg				= 'bg'.($i%2);
			
			$buyNum =$tot-($rowslimit*($this_page-1));
			$Num = $buyNum - $i;

			extract($rows);
			?>

			<tr class="<?=$bg?>">
				<td class="td_chk" >
					<label for="chk_<?=$i?>" class="sound_only"><?=$rows[userNm]?></label>
					<input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
					<input type="hidden" name="idx[]" value="<?=$rows[idx]?>">
				</td>
				<td class="td_no"><?=$Num?></td>
				<td class="td_opt">
					<a href="<?=$PHP_SELF?>?mode=update&idx=<?=$rows[idx]?>&refer=<?=$refer?>"><?=$rows[userNm]?></a>
				</td>
				<td class="td_opt">
					<?=$rows[tel]?>
				</td>
				<td class="td_small">
					<?=$rows[email]?>
				</td>
				<td class="td_small">
					<select name="subscribeType[]" id="ban_use" class="selectbox" style="width:90px;  height:30px">
						<option value="" <?=($rows[subscribeType]=="")?"selected":"";?>>전체</option>
						<option value="both" <?=($rows[subscribeType]=="both")?"selected":"";?>>전체구독</option>
						<option value="offline" <?=($rows[subscribeType]=="offline")?"selected":"";?>>오프라인</option>
						<option value="online" <?=($rows[subscribeType]=="online")?"selected":"";?>>온라인</option>
					</select>
				</td>
				<td class="td_small">
				<select name="ggr[]" id="ggr" class="selectbox" style="width:190px;  height:30px">
				<option value="">그    룹</option>
				<?
					$sql3		= "SELECT * FROM sh_group ORDER BY no ASC";
					$row3		= $DB->dfetcharr($sql3);
			
				for($a=0;$a<sizeof($row3);$a++){
					$rows3			= $row3[$a];
					?>
				<option value="<?=$rows3['no']?>" <? if ( $rows['ggr']==$rows3['no']) { echo "selected"; } ?>><?=$rows3['name']?></option>
				<? } ?>
			</select>
				</td>
				<td class="td_small">
				<select name="cancelYn[]" id="ggr" class="selectbox" style="width:90px;  height:30px">
					<option value="Y" <? if ($rows[cancelYn]=="Y") echo "selected"; ?>>해지</option>
					<option value="N" <? if ($rows[cancelYn]=="N") echo "selected"; ?>>구독중</option>
				</select>
				</td>
				<td class="td_small">
					<? if ($rows['cancelYn']=='Y') { ?>
					<?=substr($rows[cancelDttm],0,10)?>
					<? } else { ?>
					<?=substr($rows[insertDttm],0,10)?>
					<? } ?>
				</td>
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
		<input type="button" value=" 추가하기 " id="btn_submit" class="button_small" onclick="document.location.href='<?=$PHP_SELF?>?mode=form'">
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
			if(confirm("선택하신 항목을 수정 하시겠습니까?")==false){
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