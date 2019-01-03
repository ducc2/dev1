<?
session_start();
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");

$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$table04			= MEM_TABLE;
$table05			= SHOP_POINT_USE_TABLE;
	
	//print_r($_GET);


	if ($_GET['name']!=$_SESSION['SNS_LOGIN']['name']) { 
		js_alert_back("정보가 일치하지 않습니다. 다시 시도해 보세요.");
	}

	//echo ("DELETE FROM sh_board_comment WHERE no = '".$_POST[no]."'";
	$DB->query("DELETE FROM sh_board_comment WHERE no = '".$_GET[cno]."'");	

	?>
	<script>
	alert("삭제가 완료되었습니다.");
	location.href='./comment.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>'
	</script>
	<?
exit;
?>
