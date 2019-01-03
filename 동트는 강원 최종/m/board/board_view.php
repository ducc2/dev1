<?
$sh["rPath"]	= "../..";
include_once($sh["rPath"]."/_common.php");
$referer			= prevpage();
$sh["title"]		= $sh["stie_title"]."-".$board_info[name]." 게시판";
$sh_title			= $board_info[name];
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$table04			= MEM_TABLE;
$table05			= SHOP_POINT_USE_TABLE;
$refer				= getLink();
$updir				= DATA_PATH."board/".$board_id;
$thumb_dir			= DATA_PATH."board/".$board_id;
$upUrl				= "../data/board/".$board_id;

if(!$board_id){
	js_alert_back("게시판 아이디가 없습니다. 다시 확인해 주세요.");
}

// 권한 체크
if($member[mem_level] < $board_info[read_grant] and $board_info[read_grant] > 0){
	js_alert_back("게시물 내용 읽기 권한이 없습니다.");
	exit;
}

$sh["rPath"]	= "..";

include_once($sh["rPath"]."/_head.php");
if(is_file($board_info[top_include])){
	include_once($board_info[top_include]);
}else{
	include_once($sh["rPath"]."/_top.php");
}

$user_skin		= $board_info[skin];
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

$state			= "update";
$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");
$cur_comment	= $row[comment];

$row[content]	= str_replace("../../", "/", $row[content]);

if(!$_SESSION["admin_id_session"]){
	if($row[options]=="secret" and ($_SESSION["mem_id_session"]<>$row[mem_id] OR !$_SESSION["mem_id_session"])){
		$session_name	= 'board_'.$board_id.'_'.$no;
		$go_ul			= "./password_check.php?board_id=".$board_id."&no=".$no."&sch_key=".$sch_key."&sch_text=".$sch_text."&cate=".$cate."&this_page=".$this_page."";
		if(!get_session($session_name)){
			js_alert_go_url("비밀글로 등록된 게시물입니다. 비밀번호 체크 페이지로 이동합니다.", $go_ul);
			exit;
		}
	}
}

// 삭제, 수정 버튼 숨기기/노출 체크
if($_SESSION["mem_id_session"]){
	if($_SESSION["mem_id_session"]==$row[mem_id] OR $_SESSION["admin_id_session"]){
		$delete_btn_script	= "board_drop_proc();";

	}else if(!$_SESSION["mem_id_session"] OR $_SESSION["mem_id_session"]<>$row[mem_id]){
		$delete_btn_script	= "document.location.href='./password_check.php?smode=delete&no=".$no."&board_id=".$board_id."&sch_key=".$sch_key."&sch_text=".$sch_text."&cate=".$cate."&this_page=".$this_page."'";
	}
}else{
	$delete_btn_script	= "document.location.href='./password_check.php?smode=delete&no=".$no."&board_id=".$board_id."&sch_key=".$sch_key."&sch_text=".$sch_text."&cate=".$cate."&this_page=".$this_page."'";
}

$row_file		= $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$no."'");

for($i=0; $i < count($row_file); $i++){
	$row_files		= $row_file[$i];
	$file_ext		= strtolower(get_file_ext($row_files[filename]));

	if($file_ext=="jpg" or $file_ext=="png" or $file_ext=="gif"){
		$file_img		.= "<img src='/data/board/".$board_id."/".$row_files[filename]."'><p></p>"; 
	}else{
		$file_img_no	.= "
							<img src='".$board_skin."/img/icon_file.gif'> 
							<a href='./__download.php?path=".DATA_PATH."board/".$board_id."/".$row_files[filename]."&name=".$row_files[filename_original]."&board_id=".$board_id."&no=".$row_files[no]."'>
							".$row_files[filename_original]."</a>
							(".size_hum_read($row_files[file_size]).") <span class='board_sub_text'>".number_format($row_files[download])."회 다운로드</span>
							<br>";
		$file_img_no_cnt++;
	}
}
if($row[link1]){
	$link_01		= "<img src='".$board_skin."/img/icon_link.gif'> <a href='./__link.php?linkurl1=$row[link1]&board_id=".$board_id."&no=".$no."' target='_blank'>".$row[link1]."</a> 
						<span class='board_sub_text'>".number_format($row[link1_hit])."회 링크연결</span><br>";
}

if($row[link2]){
	$link_02		= "<img src='".$board_skin."/img/icon_link.gif'> <a href='./__link.php?linkurl2=$row[link2]&board_id=".$board_id."&no=".$no."' target='_blank'>".$row[link2]."</a> 
						<span class='board_sub_text'>".number_format($row[link2_hit])."회 링크연결</span><br>";
}

// 조회 업데이트
$data[hit]		= $row[hit] + 1;
$DB->updateTable($table01, $data, "WHERE no='".$no."'");
$prev			= $DB->get_prev_next_content($table01, $no, "prev");
$next			= $DB->get_prev_next_content($table01, $no, "next");
extract($row);

// 댓글 가져오기 시작
$row_category = $row['category'];
$row_list		= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE category='".$row_category."' and no!='".$no."' ORDER BY no DESC");


$thumb_url			= "../../data/board/".$board_id."/thumb/";
$upUrl				= "../../data/board/".$board_id;


include_once($board_skin."/view.php");


if ($board_id!="notice") { 


?>

<iframe src="./comment.php?board_id=<?=$board_id?>&no=<?=$no?>" id="ifr" name="ifr" onload="javascript:resizeIframe(this);" style="width:100%; height:400px" scrolling="no" border="no" allowTransparency="true" frameborder="0" framespacing="0" marginheight="0" marginwidth="0" ></iframe>
<? }?>

<? if ($board_id=="contents") { 
?>
<!-- con_list-->
			<div class="con_list">
				<div class="list_tit">
					<span class="point">‘<?=$cate?>’</span> 카테고리의 다른 글 
					<span class="list_all"><a href="/m/board/board.php?board_id=<?=$_GET['board_id']?>&cate=<?=$cate?>" >전체목록보기</a></span>
				</div>
				<ul>
<?

for($i=0;$i<sizeof($row_list);$i++){
			$rows_list					= $row_list[$i];

			$rows_list[subject]			= text_cut_kr($rows_list[subject], 30);

			$extra_2					= $rows_list['extra_2'];
			$extra_3					= $rows_list['extra_3'];
			
			?>
					<li class="clearfix">
						<a href="/m/board/board_view.php?board_id=<?=$_GET['board_id']?>&no=<?=$rows_list['no']?>">
						<span class="month"><?=$extra_2?>년 <?=$extra_3?>월호</span>
						<p class="tit"><?=$rows_list[subject]?></p>
						<span class="date"><?=substr($rows_list['datetime'],0,10)?></span>
						</a>
					</li>
			<? } ?>
				</ul>
			</div>
<?
}
			?>

<? if ($board_id!="contents") { 
?>
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
				</div>
<?
}
			?>
</div>


<?


if(is_file($board_info[bottom_include])){
	include_once($board_info[bottom_include]);
}else{
	include_once($sh["rPath"]."/_bottom2.php");
}
?>


<script type="text/javascript">
 function resizeIframe(obj) {
	 //alert(obj.contentWindow.document.body.scrollHeight);
		var heightee = parseInt(obj.contentWindow.document.body.scrollHeight);
        obj.style.height = heightee + 'px';
    }

document.oncontextmenu = function(){ // 컨텍스트 메뉴금지

return false;

};
</script>

