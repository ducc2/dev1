<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">

.board_view_top_left { float: left; padding: 7px 0 7px; }
.board_view_top_right { float: right; padding: 7px 0 7px; }
.board_view_top_center { overflow: hidden; padding: 7px 0 7px; text-align:center;}

.board_view_subject {width:100%; height:35px; font-weight:bold; font-size:1.6em;}
.board_view_content {width:100%; min-height:300px;}
.board_view_content_extra {width:100%; min-height:50px; padding-top:10px;}
.board_button_left { width:20%; float: left;  padding: 7px 0 7px; }
.board_button_right { width:80%; float: right; overflow: hidden; padding: 7px 0 7px; text-align:right;}

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




<div id="cont_right">

	<div class="location_title"><? if($board_id == 'contents') {echo '컨텐츠관리';}else if($board_id == 'writer') {echo '여행작가 게시물';}else if($board_id == 'notice') {echo '이벤트/공지';}else if($board_id == 'news') {echo '뉴스레터';}else{echo '게시 컨텐츠';} ?></div>

	<div class="board_view_subject"><?=$subject?></div>
	<div class="board_view_top_left">작성자 : <?=$name?></div>
	<div class="board_view_top_right">조회 : <?=$hit?></div>
	
	<div class="board_view_top_center">
		등록일 : <?=substr($datetime, 0, 10)?> 
		<?if($board_info[ip_view]=="2")	echo "(".$ip.")"; ?>
	</div>
	<div class="board_view_top_left">저작권  :   <? if ($extra_1==1) { ?>강원도<? } ?> <? if ($extra_1==2) { ?>외부<? } ?><br>호수  :   <?=$extra_2?>년 <?=$extra_3?>월호<br>주소 : <?=$extra_5?></div>

	<div id="content_line"></div>



	
	<div class="board_button_left">
		<?if($prev){?>
			<input type="submit" value=" 이전글 " id="btn_submit" class="button_white60x30" onclick="document.location.href='<?=$PHP_SELF?>?no=<?=$prev?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>'">
		<?}?>

		<?if($next){?>
			<input type="button" value=" 다음글 " id="btn_submit" class="button_white60x30" onclick="document.location.href='<?=$PHP_SELF?>?no=<?=$next?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>'">	
		<?}?>
	</div>
	<div class="board_button_right">
		<form id="board_hidden_form" name="board_hidden_form"  method="post" method="post" target="ifm_proc">
			<!-- 폼 내에 있은 인풋은 삭제하시면 안되요 -->
			<input type="hidden" name="state" id="state" value="drop">
			<input type="hidden" name="no" value="<?=$no?>">
			<input type="hidden" name="board_id" value="<?=$board_id?>">	
			<input type="hidden" name="mem_id" value="<?=$mem_id?>">	
			<input type="hidden" name="parent_referer" value="<?=$referer?>">
			<input type="hidden" name="updir" value="<?=$updir?>">		
		</form>

		<input type="submit" value=" 수정 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>&no=<?=$no?>'">
		<input type="button" value=" 삭제 " id="btn_submit" class="button_white60x30" onclick="<?=$delete_btn_script?>">
		<input type="button" value=" 목록 " id="btn_submit" class="button_white60x30" onclick="document.location.href='./board.php?board_id=<?=$board_id?>'">
		<input type="button" value=" 글쓰기 " id="btn_submit" class="button_image60x30" onclick="document.location.href='./board_write.php?board_id=<?=$board_id?>'">			
	</div>
	<?if($file_img_no_cnt> 0 or $link1 or $link2){?>
		<div class="upfile_link_area">
			<?=$file_img_no?>
			<?=$link_01?>
			<?=$link_02?>
		</div>
	<?}?>
	

</div>


<script>

	function board_copy_move_proc(mode){
		document.getElementById("state").value		= "board_move";
		var form		= document.getElementById("board_hidden_form");
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


	// submit 폼체크
	function recomment_proc(){		
		var form		= document.getElementById("recommentform");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();
		return true;
	}


	// submit 폼체크
	function board_drop_proc(){		
		
		if(confirm("선택하신 게시물을 삭제 하겠습니다.\n(주의:삭제되면 복구 할 수 없습니다.)")==false){
			return false;			
		}

		var form		= document.getElementById("board_hidden_form");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();
		return true;
	}
</script>


<!-- 게시물 보기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>