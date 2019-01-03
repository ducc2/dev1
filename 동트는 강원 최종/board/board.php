<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");

$cate_title = ucfirst($cate);
$referer			= prevpage();
$sh["title"]		= $sh["stie_title"]."-".$board_info[name]." 게시판";
$sh_title			= $board_info[name];
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/thumb/";
$thumb_url			= "../data/board/".$board_id."/thumb/";
$upUrl				= "../data/board/".$board_id;

if(!$board_id){
	js_alert_back("게시판 아이디가 없습니다. 다시 확인해 주세요.");
	exit;
}

// 권한 체크
if($member[mem_level] < $board_info[list_grant] and $board_info[list_grant] > 0){
	js_alert_back("게시물 목록 읽기 권한이 없습니다.");
	exit;
}


if(is_file($board_info[top_include])){
	include_once($board_info[top_include]);
}else{
	include_once($sh["rPath"]."/_head.php");
}

$user_skin		= $board_info[skin];
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

$rowslimit		= 9;

$pagelimit		= 5;
if(!$this_page) $this_page = 1;

$start			= $rowslimit*($this_page-1);
$limit			= $rowslimit;
$refer			= getLink();

				$where[] = "a.notice = '0'";
if($cate)		$where[] = "a.category = '$cate'";
if($sch_key){
	if($sch_key == "a.subject+content"){
		$where[] = "(a.subject LIKE '%$sch_text%' OR a.content LIKE '%$sch_text%')";
	}else{
		$where[] = "$sch_key LIKE '%$sch_text%'";
	}
}
if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	

$sql			= "SELECT a.* FROM ".$table01." a $swhere ORDER BY a.num DESC, a.reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT $start , $limit");
$tot			= $DB->rows_count($sql);
$idx			= $tot-$rowslimit*($this_page-1);
$linkpage		= page($tot,$rowslimit,$pagelimit);

if($this_page==1){ 
	$noticeSql		= "SELECT a.* FROM ".$table01." a WHERE a.notice='1'";
	$noticeRow		= $DB->dfetcharr($noticeSql);
	if($noticeRow){
		$row		= @array_merge($noticeRow, $row);
		$idx		= $idx + sizeof($noticeRow);
	}
}


include_once($board_skin."/list.php");




if(is_file($board_info[bottom_include])){
	include_once($board_info[bottom_include]);
}else{
	include_once($sh["rPath"]."/_bottom.php");
}
?>
