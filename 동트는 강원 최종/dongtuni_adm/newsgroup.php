<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$leftcode			= 3;
$include_file		= "newsgroup";
include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "구독그룹관리";
$table01			= "sh_group";

$upfilesname		= array("ban_img");
$updir				= DATA_PATH."banner/";
$thumb_dir			= DATA_PATH."banner/";
$upUrl				= "../data/banner/";


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
	for($i=0; $i<count($upfilesname); $i++){
		if($row[$upfilesname[$i]]){
			$filename_exp	= explode("|",$row[$upfilesname[$i]]);
			$filename_real	= $filename_exp[1];
			${$upfilesname[$i]."_del"}	= "<input type='checkbox' name='file_del_check[]' value='$upfilesname[$i]|@@|$filename_real'>(삭제 시 체크)";
			${$upfilesname[$i]."_tmp"}	= "<img src='$upUrl/$filename_real' width='275' height='200'><p>";
			$uploadfile_old			   .= "<input type='hidden' name='".$upfilesname[$i]."_old' value='$filename_real'>\n";
		}
	}

	text_special_replace($row);
	extract($row);
	include_once("./".$include_file."_form.php");

}elseif($mode=="drop"){
	if($no){

		// 1차 상품분류 이미지/디비 삭제
		$row_file	= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE no='".$no."' ORDER BY no ASC");
		//echo "<pre>";print_r($row_file);exit;
		for($j=0;$j<sizeof($row_file);$j++){
			$row_files	= $row_file[$j];
				
			if($row_files[pop_img]){
				$filename_exp	= explode("|", $row_files[pop_img]);
				@unlink($updir."/".$filename_exp[1]);		
			}
			
			$DB->query("DELETE FROM ".$table01." WHERE no = '".$row_files[no]."'");
		}	
	}
	goto_url($refer);

}

include_once("./_bottom.php");
?>
