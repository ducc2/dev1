<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<?
if(!$_SESSION["admin_id_session"]){
    goto_url($sh["rPath"]."/member/login.php");
}
?>