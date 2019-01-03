<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");

//세션 삭제
session_unset();
session_destroy();

// 자동로그인 해제 --------------------------------
set_cookie('ck_mem_id', '', 0);
set_cookie('ck_auto', '', 0);
// 자동로그인 해제 end --------------------------------

goto_url("../");
?>
