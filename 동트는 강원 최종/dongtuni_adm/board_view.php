<?
$sh["rPath"]		= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$leftcode			= 2;
$include_file		= "board";
include_once("./_left.php");

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

if ($board_id=='writer' || $board_id=='contents' || $board_id=='news') {
	$user_skin		= "admin_gallery";
} else if ($board_id=='notice') {
	$user_skin		= "admin2";
} else {
	$user_skin		= "admin";
}

$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;


$state			= "update";
$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");
$cur_comment	= $row[comment];

$row[content]	= str_replace("../../", "../", $row[content]);

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
		$file_img		.= "<img src='../data/board/".$board_id."/".$row_files[filename]."' style='max-width: 100%; height: auto;'><p></p>"; 
		$share_img ="http://".$_SERVER['HTTP_HOST']."/data/board/".$board_id."/".$row_files[filename];
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

// 포인트 지급
if($_SESSION["mem_id_session"] and $board_info[read_point] > 0){
						
	$data[mem_id]		= $member[mem_id];
	$data[mem_name]		= $member[mem_name];
	$data[contents]		= "게시물 읽기 포인트";
	$data[point]		= $board_info[read_point];
	$data[point_type]	= "+";
	$data[point_state]	= "1";
	$data[datetime]		= date("Y-m-d H:i:s");
	$DB->insertTable($table05, $data);

	$data_mem[mem_point]	= $member[mem_point] + $board_info[read_point];
	$DB->updateTable($table04, $data_mem, "WHERE mem_no='".$member[mem_no]."'");
}

// 조회 업데이트
$data[hit]		= $row[hit] + 1;
$DB->updateTable($table01, $data, "WHERE no='".$no."'");
$prev			= $DB->get_prev_next_content($table01, $no, "prev");
$next			= $DB->get_prev_next_content($table01, $no, "next");
extract($row);

// 댓글 가져오기 시작
$row_category = $row['category'];
$row_list		= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE category='".$row_category."' and no!='".$no."'");

include_once($board_skin."/view.php");


if ($board_id!="notice") { 
?>

<iframe src="./comment.php?board_id=<?=$board_id?>&no=<?=$no?>" id="ifr" name="ifr" onload="javascript:resizeIframe(this);" style="width:100%; height:160px; margin:30px 0;" scrolling="no" border="no" allowTransparency="true" frameborder="0" framespacing="0" marginheight="0" marginwidth="0" ></iframe>
<? }?>


<? if ($board_id=="writer") { 
?>
<!--
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
				</div>-->
<?
}
			?>
</div><!--// contents-->

<?


if(is_file($board_info[bottom_include])){
	include_once($board_info[bottom_include]);
}else{
	include_once($sh["rPath"]."/_bottom.php");
}
?>


<script type="text/javascript">
 function resizeIframe(obj) {
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }

document.oncontextmenu = function(){ // 컨텍스트 메뉴금지

return false;

};
</script>

