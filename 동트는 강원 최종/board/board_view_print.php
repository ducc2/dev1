<?
$sh["rPath"]		= "..";
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

//print_r($board_info);
/*
include_once($sh["rPath"]."/_head.php");
if(is_file($board_info[top_include])){
	include_once($board_info[top_include]);
}else{
	include_once($sh["rPath"]."/_top.php");
}*/
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<title>동트는 강원 : Tour</title>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- 마크업 전달 속성 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="../comn/css/style.css">
	<link rel="stylesheet" href="../comn/css/print.css">

	<!--[if lt IE 9]>
	<script src="../comn/js/html5.js"></script>
	<script src="../comn/js/css3-mediaqueries.js"></script>
	<![endif]-->

	<script src="../comn/js/jquery-1.11.2.min.js"></script>
	<script src="../comn/js/jquery-ui.min.js"></script>
	<script src="../comn/js/common.js"></script><!-- 메인페이지엔 없어야함 -->
	<script>
$(document).ready(function() { 
	print()
});


	</script>
</head>
<body>

<div class="popHead">
	<a href="#close" class="btnClose" onclick="window.close();"><span class="icon"></span>창닫기</a>
</div>
<div class="popBody">

<div id="printArea">
<?

$user_skin		= $board_info[skin];
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
		$file_img		.= "<img src='../data/board/".$board_id."/".$row_files[filename]."'><p></p>"; 
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
?>
	<!-- con_wrap -->
	<div class="con_wrap clearfix">
<?
include_once($board_skin."/view.php");



// 댓글 가져오기 시작

/*
$rowslimit			= 5;
$pagelimit		= 5;
if(!$this_page) $this_page = 1;

$start			= $rowslimit*($this_page-1);
$limit			= $rowslimit;
$refer			= getLink();
$sql			= "SELECT a.* FROM ".$table03." a WHERE a.board_no = '".$no."' AND board_id = '".$board_id."' ORDER BY a.no ASC";
$comment		= $DB->dfetcharr($sql." LIMIT $start , $limit");
$tot			= $DB->rows_count($sql);
$idx			= $tot-$rowslimit*($this_page-1);
$linkpage		= page($tot,$rowslimit,$pagelimit);
include_once($board_skin."/comment.php");
if(is_file($board_info[bottom_include])){
	include_once($board_info[bottom_include]);
}else{
	include_once($sh["rPath"]."/_bottom.php");
}
*/
?>
</div>
</div>
</div>
</div>
</div><!-- //printArea -->
</div><!-- //popBody -->
</body>

</html>
