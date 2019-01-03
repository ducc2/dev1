<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>
<?
$cate = ucfirst($_GET['cate']);
?>
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">

<h2><?=$cate?></h2>

<? if ($_SESSION['admin_member_session']==10) { ?>
	<!-- <form name="flist" id="flist" action="./board_proc.php" onsubmit="return flist_submit(this);" method="post" >
		<input type="hidden" name="state" id="state" value="update_multi">
		<input type="hidden" name="board_id" value="<?=$board_id?>">
		<input type="hidden" name="updir" value="<?=$updir?>">
		
		<div>
		<label for="checkAll" class="sound_only">전체 선택</label>
		<input type="checkbox" name="checkAll" value="1" id="checkAll">
		</div> -->
<? } ?>
					<ul class="contents_list clearfix">
<!-- 리스트 루프 시작 -->
		<?
		$brcnt		= 1; 
		for($i=0;$i<sizeof($row);$i++){
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
			$rows[content]			= text_cut_kr(strip_tags($rows[content]), 88);
			extract($rows);

			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='".$thumb_url."thumb".$row_file[filename]."?>' class='def'>";
			}else{
				$board_img	= "";
			}

			?>
						<li>
							<a href="./board_view.php?board_id=<?=$board_id?>&no=<?=$no?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>&refer=<?=$refer?>">
								<div class="thumb">
									<?=$board_img?>
									<div class="dark"><img src="/comn/img/icon_thumb.png"></div>
								</div>
								<h4 class="tit_con"><!--<span>Culture</span>--><?=$rows[subject]?></h4>
								<!--<p><?=$rows[content]?></p>-->
							</a>
						</li>
					<?	   
			$brcnt++;
			$idx--;
		}?>
					</ul>

						<?if (sizeof($row)==0) { ?>
								<div class="paging">등록된 자료가 없습니다.</div>
						<? } ?>

					<div class="paging">
						<?=$linkpage?>
					</div>
<? if ($_SESSION['admin_member_session']==10) { ?>
				<!-- <div class="area_add">
		<input type="button" value=" 글쓰기 " id="btn_submit" class="button_small" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">
	</div>

	<div class="list_bottom_left2">
			<input type="button" value=" 목 록 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board.php?board_id=<?=$board_id?>'">
			
			<input type="button" value=" 선택삭제 " id="btn_submit" class="button_small_white30" onclick="drop_multi();">	
			<input type="button" value=" 선택복사 " id="btn_submit" class="button_small_white30" onclick="board_copy_move_proc('copy');">
			<input type="button" value=" 선택이동 " id="btn_submit" class="button_small_white30" onclick="board_copy_move_proc('move');">
			
		</div> -->
		<? } ?>
		<!-- 리스트 루프 끝 -->

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


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
