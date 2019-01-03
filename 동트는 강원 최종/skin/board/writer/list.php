<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>
<?
$cate = ucfirst($_GET['cate']);
?>

	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="/board/board.php?board_id=writer">Community</a> &gt;
			<span>나도 여행작가</span>
		</div>
	</div><!--//locationwrap -->

	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>나도 여행작가</h2>

					<div class="btnArea top">
						<a href="/sub/photographer_pass.html?board_id=writer" class="btnBig">포스트 작성하기</a>
					</div>

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
			
						$rows[subject]			= text_cut_kr($rows[subject], 14);
			$rows[content]			= text_cut_kr(strip_tags($rows[content]), 42);
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
									<div class="dark"><img src="../comn/img/icon_thumb.png"></div>
								</div>
								<h4 class="tit_con">
								<? if ($_SESSION['admin_member_session']==10) { ?>
								<!-- <input type="checkbox" name="chk[]" value="<?=$i?>" id="chk_<?=$i?>">
								<input type="hidden" name="nos[]" value="<?=$no?>"> --><? } ?>
								<?=$subject?></h4>
								<p><?=$rows[content]?></p>
								<p class="writer">POST BY <?=$rows[name]?> <span class="tag_sup">
								<?
						$phone_t = $rows[extra_1]."-".$rows[extra_2]."-".$rows[extra_3];

						$row_support  = $DB->fetcharr("SELECT * FROM sh_supporter WHERE phone='".$phone_t."'");

						if ($row_support[no]) { echo "강원도서포터즈"; }
						?></span></p>
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
				</div>
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
