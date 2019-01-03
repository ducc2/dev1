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





<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="#">Community</a> &gt;
			<span>이벤트/공지</span>
		</div>
	</div><!--//locationwrap -->


	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>이벤트/공지</h2>

				<!--
				가지고계신 게시판 탬플릿이 있으시면 아래 내용으로 적용하지 않으셔도 됩니다.
				목록, 상세페이지, 검색 기능만 있으면 어떤 탬플릿이라도 가능하니 내용만 참고해주세요.
				-->

				<table summary="이벤트/공지 : 번호,제목,조회수,파일,날짜 정보제공" class="tblBbs">
				<caption>이벤트/공지</caption>
				<colgroup>
					<col style="width:7%">
					<col style="width:*">
					<col style="width:10%">
					<col style="width:15%">
					<col style="width:8%">
				</colgroup>
				<thead>
					<tr>
						<th>번호</th>
						<th>제목</th>
						<th>파일</th>
						<th>날짜</th>
						<th>조회수</th>
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

		<tr >
			<td ><?=$idx2?></td>
			<td class="left">
					<a href="./board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&this_page=<?=$this_page?>&refer=<?=$refer?>">
					<?=$reply_image?><?=$subject?></a>
			</td>
			<td ><?=$file_image?></td>
			<td ><?=substr($datetime, 0, 10)?></td>
			<td ><?=$hit?></td>	
		
		</tr>		
		<?
			$idx--;
		}?>
		<!-- 리스트 루프 끝 -->

		</tbody>
		</table>

						<?if (sizeof($row)==0) { ?>
								<div class="paging">등록된 자료가 없습니다.</div>
						<? } ?>

					<div class="paging">
						<?=$linkpage?>
					</div>
	</form>
	
	<div class="srhBox">
					<form name="fsearch" id="fsearch" method="get">
					<input type=hidden name=board_id value="<?=$board_id?>">
					<fieldset>
					<legend>검색</legend>
						<select name="sch_key">
							<option value="0" >전체</option>
							<option value="a.subject" selected="selected">제목</option>
							<option value="a.content" >내용</option>
						</select>
						<input type="text" name="sch_text" value="<?=$sch_text?>">
						<input type="submit" class="btnBig" value="검색">
					</fieldset>
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

<!-- 게시물 목록 끝 -->
</div>
</div>

<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
