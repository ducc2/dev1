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



	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="#">Community</a> &gt;
			<span>이벤트/공지</span>
		</div>
	</div><!--//locationwrap -->


	<!-- con_wrap -->
	<div class="con_wrap clearfix" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents" >
				<h2>이벤트/공지</h2>

<!--	<div class="location_title"><?=$sh_title?></div> 제가 지웠습니다. -->
				<table summary="이벤트/공지 : 번호,제목,조회수,파일,날짜 정보제공" class="tblBbs">
				<caption>이벤트/공지</caption>
				<tbody>
					<tr>
						<td class="left">
							<div class="view_subject">
								<?=$subject?>
							</div>
							<div class="">
								<span class="view_com"><?=$name?></span>
								<span class="view_date"><?=$datetime?> </span>
								<span class="view_hit">조회 : <?=$hit?></span>
							</div>
						</td>
					</tr>
				</tbody>
				</table>

				<div class="viewBody">
					<div class="view_con">
						<!-- 게시물 내용 시작 -->

						<p><?=$content?></p>
						<!-- 게시물 내용 종료 -->
					</div>
					<!-- 첨부파일이 없으면 안보이게 해주세요. -->
					<?=$file_img?>
					<div class="view_file">
						첨부파일 : 
						<?
						$row_file		= $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$no."'");

						for($i=0; $i < count($row_file); $i++){
							
							$row_files		= $row_file[$i];
							$file_ext		= strtolower(get_file_ext($row_files[filename]));

							echo "<a href='./__download.php?path=".DATA_PATH."board/".$board_id."/".$row_files[filename]."&name=".$row_files[filename_original]."&board_id=".$board_id."&no=".$row_files[no]."'>
							".$row_files[filename_original]."</a>";
						}
						?>
					</div>
					<!-- //첨부파일이 없으면 안보이게 해주세요. -->
				</div><!-- //viewBody -->

				<div class="btnArea right">
					<a href="/board/board.php?board_id=notice" class="btnBig">목록</a>
				</div><!-- //btnArea -->

				<div class="prevNext">
					<ul>
					<?if($prev){
				$prow			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$prev."'");
				?>
					<li><span class="prev"><span class="icon"></span>이전글</span> <a href="<?=$PHP_SELF?>?no=<?=$prev?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>"><?=$prow[subject]?></a></li>

				<? } ?>

				<?if($next){
				$nrow			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$next."'");
				?>
					<li><span class="next"><span class="icon"></span>다음글</span> <a href="<?=$PHP_SELF?>?no=<?=$next?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>"><?=$nrow[subject]?></a></li>
				<? } ?>
					</ul>
				</div><!-- //prevNext -->
		<form id="board_hidden_form" name="board_hidden_form"  method="post" method="post" target="ifm_proc">
			<!-- 폼 내에 있은 인풋은 삭제하시면 안되요 -->
			<input type="hidden" name="state" id="state" value="drop">
			<input type="hidden" name="no" value="<?=$no?>">
			<input type="hidden" name="board_id" value="<?=$board_id?>">	
			<input type="hidden" name="mem_id" value="<?=$mem_id?>">	
			<input type="hidden" name="parent_referer" value="<?=$referer?>">
			<input type="hidden" name="updir" value="<?=$updir?>">		
		</form>



	
	
	
	<?if($file_img_no_cnt> 0 or $link1 or $link2){?>
		<div class="upfile_link_area">
			<?=$link_01?>
			<?=$link_02?>
		</div>
	<?}?>

	<!--   게시판 추가 필드 시작 - 10개까지 사용가능  (주석 제거 후 변경해서 사용하시면 됩니다.)
	<div class="board_view_content_extra">
		<?=$board_info[extra_subject_1]?> : <?=$extra_1?><p></p>
		<?=$board_info[extra_subject_2]?> : <?=$extra_2?><p></p>
		<?=$board_info[extra_subject_3]?> : <?=$extra_3?><p></p>
	</div>
		게시판 추가 필드 시작 (주석 제거 후 변경해서 사용하시면 됩니다.)
	-->

	
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

</div>

<!-- 게시물 보기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>