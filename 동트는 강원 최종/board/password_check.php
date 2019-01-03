<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$referer			= prevpage();
$sh["title"]		= $sh["stie_title"]."-".$board_info[name]." 게시판";
$sh_title			= $board_info[name];
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id;
$thumb_dir			= DATA_PATH."board/".$board_id;
$upUrl				= "../data/board/".$board_id;
$state				= "insert";


if(!$board_id){
	js_alert_back("게시판 아이디가 없습니다. 다시 확인해 주세요.");
}


include_once($sh["rPath"]."/_head.php");
include_once($sh["rPath"]."/_top.php");;

$user_skin		= $board_info[skin];
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;




include_once($board_skin."/password_check.php");

include_once($sh["rPath"]."/_bottom.php");
?>
