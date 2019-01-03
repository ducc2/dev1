<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$data				= $_POST;
$referer			= prevpage();
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;


//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');

//널체크
$check_data		= array("password"=>"비밀번호");
$check_result	= null_check($data, $check_data);
if($check_result){
	js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
}

$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");

if ($DB->get_mysql_password($data[password]) != $row[password]) {
    js_alert_back('입력하신 비밀번호가 틀립니다.\\n다시 확인해 보세요.'); 
	exit;
}

if($_POST[smode]=="delete"){
	if($data[no]){
		//게시물 파일/디비 삭제
		$row_file  = $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$no."' ORDER BY file_sort ASC");
		for($i=0;$i<sizeof($row_file);$i++){
			$row_files	= $row_file[$i];
			$del		= @unlink($updir."/".$row_files[filename]);					
			$DB->query("DELETE FROM ".$table02." WHERE no = '".$row_files[no]."'");
		}
				
		// 게시물 댓글 삭제
		$DB->query("DELETE FROM ".$table03." WHERE board_no = '".$no."' AND board_id = '".$board_id."'");	
		// 게시물 삭제
		$DB->query("DELETE FROM ".$table01." WHERE no = '".$no."'");
	}

	$go_ul			= "./board.php?board_id=".$board_id."&sch_key=".$sch_key."&sch_text=".$sch_text."&cate=".$cate."&this_page=".$this_page."";
	?>
	<script>
	alert("삭제가 완료되었습니다.");
	window.close();
	opener.window.location='<?=$go_ul?>';
	</script>
	<?

}else{
	$board_session = 'board_'.$board_id.'_'.$no;
	set_session($board_session, TRUE);

	$go_ul			= "./board_write.php?board_id=".$board_id."&no=".$no."&sch_key=".$sch_key."&sch_text=".$sch_text."&cate=".$cate."&this_page=".$this_page."";
	?>
	<script>
	window.close();
	opener.window.location='<?=$go_ul?>';
	</script>
	<?
}


?>