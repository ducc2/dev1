<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$leftcode			= 2;
$include_file		= "adminID";
include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "관리자관리";
$table01			= "sh_member";

$upfilesname		= array("ban_img");
$updir				= DATA_PATH."banner/";
$thumb_dir			= DATA_PATH."banner/";
$upUrl				= "../data/banner/";


if(!$mode){
	$rowslimit	= 20;
	$pagelimit	= 5;
	if(!$this_page) $this_page = 1;
	
	$start		= $rowslimit*($this_page-1);
	$limit		= $rowslimit;
	$refer		= getLink();
	
	if($sch_text)	$where[] = "$sch_key LIKE '%$sch_text%'";
	if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	

	$sql		= "SELECT a.* FROM ".$table01." a $swhere ORDER BY a.mem_no DESC";

	$row		= $DB->dfetcharr($sql." LIMIT $start , $limit");
	$tot		= $DB->rows_count($sql);
	$idx		= $tot-$rowslimit*($this_page-1);
	$linkpage	= page($tot,$rowslimit, $pagelimit);

	include_once("./".$include_file."_list.php");

}elseif($mode=="form"){
	
	$state		= "insert";
	include_once("./".$include_file."_form.php");

}elseif($mode=="update"){

	$state		= "update";
	$row		= $DB->fetcharr("SELECT * FROM sh_member WHERE mem_no='".$mem_no."'");

	text_special_replace($row);
	extract($row);
	$mem_password		= $DB->get_mysql_password($row['mem_password']);

	include_once("./".$include_file."_form.php");

}elseif($mode=="drop"){
	if($mem_no){
		$DB->query("DELETE FROM ".$table01." WHERE mem_no = '".$mem_no."'");
	}
	goto_url($refer);

}

include_once("./_bottom.php");
?>
