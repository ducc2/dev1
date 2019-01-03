<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$leftcode			= 7;
$include_file		= "board_register";
include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "게시판 관리";
$table01			= BOARD_SET_TABLE;
$table02			= SHOP_MEM_RATING_TABLE;

$upfilesname		= array("top_img", "bottom_img");
$updir				= DATA_PATH."board/";
$thumb_dir			= DATA_PATH."board/";
$upUrl				= "../data/board/";


// 회원 등급 가져오기
$row				= $DB->dfetcharr("SELECT rating_num, rating_name FROM ".$table02." ORDER BY rating_num ASC");
$mem_rating			= key_value($row);


// 업로드 파일 필드 input 만들기
for($i=0; $i<count($upfilesname); $i++){
	$upfile_field	.= setform("hidden", "upfilesname[]", "value='".$upfilesname[$i]."'", "")."\n";
}


if(!$mode){
	$rowslimit	= 20;
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

	text_special_replace($row);
	include_once("./".$include_file."_list.php");

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
