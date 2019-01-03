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

if ($board_id=='writer' || $board_id=='contents' || $board_id=='news') {
	$user_skin		= "admin_gallery";
} else {
	$user_skin		= "admin";
}

$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

$rowslimit		= $board_info[list_cnt];
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


if(!$mode){
	$rowslimit	=9;
	$pagelimit	= 5;
	if(!$this_page) $this_page = 1;
	
	$start		= $rowslimit*($this_page-1);
	$limit		= $rowslimit;
	$refer		= getLink();
	
	if($sch_text)	$where[] = "$sch_key LIKE '%$sch_text%'";
	if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	

	$sql		= "SELECT a.* FROM ".$table01." a $swhere ORDER BY a.no DESC";
	$row		= $DB->dfetcharr($sql." LIMIT $start , $limit");
	$tot		= $DB->rows_count($sql);
	$idx		= $tot-$rowslimit*($this_page-1);
	$linkpage	= page($tot,$rowslimit, $pagelimit);

	//text_special_replace($row);
	include_once($board_skin."/list.php");

}elseif($mode=="form"){
	
	$state		= "insert";
	include_once("./".$include_file."_form.php");

}elseif($mode=="update"){

	$state		= "update";
	$row		= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");

	text_special_replace($row);
	extract($row);
	include_once("./".$include_file."_form.php");

}elseif($mode=="drop"){
	if($no){

		// 이미지/디비 삭제 생성게시판 삭제, 파일 삭제, 게시물 삭제 댓글 삭제
		$row_file	= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE no='".$no."' ORDER BY no ASC");
		for($j=0; $j<sizeof($row_file); $j++){
			$row_files	= $row_file[$j];
			
			// 생성 디렉토리 및 파일 삭제
			if(is_dir($updir.$row_files[ename])){
				$del_dir	= $updir.$row_files[ename];
				array_map('unlink', glob("$del_dir/*.*"));
				rmdir($del_dir);
			}
			

			// 게시판 설정 삭제
			$DB->query("DELETE FROM ".$table01." WHERE no = '".$row_files[no]."'");	

			// 게시판 테이블 삭제	
			if($DB->table_exist("sh_board_wr_".$row_files[ename])){
				$DB->query("DROP TABLE sh_board_wr_".$row_files[ename]."");
			}
		}	
	}
	goto_url($refer);

}

include_once("./_bottom.php");
?>
