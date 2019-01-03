<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
if($mode<>"option_preview")	include_once("./_top.php");

$leftcode			= 8;
$include_file		= "statistic_contents";
if($mode<>"option_preview")	include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "게시물 통계";
$table01			= SHOP_VISIT_TABLE;

$updir				= DATA_PATH."goods/img/";
$thumb_dir			= DATA_PATH."goods/thumb/admin/";
$upUrl				= "../data/goods/img/";


include_once("./shop_".$include_file."_chart.php");

if($mode<>"option_preview")	include_once("./_bottom.php");
?>
