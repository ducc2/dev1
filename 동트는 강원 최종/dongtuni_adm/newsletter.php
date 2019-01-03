<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$leftcode			= 3;
$include_file		= "newsletter";
include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "구독신청관리";
$table01			= "newsletter_req";

$upfilesname		= array("ban_img");
$updir				= DATA_PATH."banner/";
$thumb_dir			= DATA_PATH."banner/";
$upUrl				= "../data/banner/";
$idx				= $_GET['idx'];

if(!$mode){
	$rowslimit	= 20;
	$pagelimit	= 5;
	if(!$this_page) $this_page = 1;
	
	$start		= $rowslimit*($this_page-1);
	$limit		= $rowslimit;
	$refer		= getLink();
	
	if($sch_text)	$where[] = "$sch_key LIKE '%$sch_text%'";
	if($_GET['ggr']) $where[] = "ggr = ".$_GET['ggr'];
	if($_GET['subscribeType']) $where[] = "subscribeType = '".$_GET['subscribeType']."'";
	if($_GET['stype']) $where[] = "stype = '".$_GET['stype']."'";
	if($_GET['cancel']) $where[] = "cancelYn = '".$_GET['cancel']."'";
	
	if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	
	

	$sql		= "SELECT * FROM ".$table01." $swhere ORDER BY idx DESC";
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
	$row		= $DB->fetcharr("SELECT * FROM ".$table01." WHERE idx='".$idx."'");

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
