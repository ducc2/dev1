<?
session_start();
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");

$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$table04			= MEM_TABLE;
$table05			= SHOP_POINT_USE_TABLE;

if($_POST["state"]=="comment_delete"){	
	
	$row			= $DB->fetcharr("SELECT no FROM sh_board_comment WHERE no = '".$_POST[no]."' and password=password('".$_POST[password]."')");
	if(!$row["no"]) {
		js_alert_back("정보가 일치하지 않습니다. 다시 시도해 보세요.");
	}
		
	//echo ("DELETE FROM sh_board_comment WHERE no = '".$_POST[no]."'";
	$DB->query("DELETE FROM sh_board_comment WHERE no = '".$_POST[no]."'");	

	?>
	<script>
	alert("삭제가 완료되었습니다.");
	opener.location.reload();
	window.close();
	</script>
	<?
exit;

//
// 게시물 삭제
} else {
	
	if ($_POST['sns_array'][$_POST[cur_comment]]) {
		
		if (!$_SESSION['SNS_LOGIN']['name']) {

			js_alert_back("SNS로그인해주세요.");
		}

	}

		if ($_POST['name_array'][$_POST[cur_comment]]!=$_SESSION['SNS_LOGIN']['name']) { 
			js_alert_back("해당 글을 작성하신 분만이 수정이 가능합니다.");
		}

		if (!$_POST['sns_array'][$_POST[cur_comment]]) { 
			$row			= $DB->fetcharr("SELECT no FROM sh_board_comment WHERE no = '".$_POST[cur_comment]."' and password=password('".$_POST['password_array'][$_POST[cur_comment]]."')");
			if(!$row["no"]) {
				js_alert_back("정보가 일치하지 않습니다. 다시 시도해 보세요.");
				exit;
			}
		} else {
			$row			= $DB->fetcharr("SELECT no FROM sh_board_comment WHERE no = '".$_POST[cur_comment]."' and name='".$_POST['name_array'][$_POST[cur_comment]]."'");
			if(!$row["no"]) {
				js_alert_back("정보가 일치하지 않습니다. 다시 시도해 보세요.");
				exit;
			}
		}

		//$dataup[name]				= $_POST['name_array'][$_POST[cur_comment]];
		//$dataup[password]			= $_POST['password_array'][$_POST[cur_comment]];
		$dataup[content]			= $_POST['content_array'][$_POST[cur_comment]];
		

		$DB->updateTable("sh_board_comment", $dataup, "WHERE no='".$_POST[cur_comment]."'");
		?>
	<script>
	location.href='/board/comment.php?board_id=<?=$_POST[board_id]?>&no=<?=$_POST[board_no]?>' ;
	</script>
	<?
exit;
}

?>
