<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");

$leftcode			= 7;
$include_file		= "board_copy";

$DB					= new database;
$referer			= prevpage();
$sh_title			= "게시판 복사 관리";
$table01			= BOARD_SET_TABLE;

$upfilesname		= array("");
$updir				= DATA_PATH."board/";
$thumb_dir			= DATA_PATH."board/";
$upUrl				= "../data/board/";

if(!$mode){

	$state		= "copy";
	$row		= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");

	text_special_replace($row);
	extract($row);
	include_once("./".$include_file."_form.php");
}

?>
