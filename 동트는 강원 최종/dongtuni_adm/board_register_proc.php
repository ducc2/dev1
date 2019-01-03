<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();
$table01	= BOARD_SET_TABLE;
$table02	= BOARD_COMMENT_TABLE;

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}



//공백제거
array_walk($data, 'array_trim');
if($_POST["state"]=="insert"){
	$check_data		= array("name"=>"게시판 이름", "ename"=>"게시판 영문 이름");

	//널체크
	$check_result	= null_check($data, $check_data);
	if($check_result){
		js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
	}


	if (preg_match("/[^0-9a-z_]+/i", $ename)){
		js_alert_back('게시판 영문 이름은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)');
		exit;
	}
}



if($_POST["state"]=="insert"){

	$row		= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE ename='".$ename."'");
	if($row){
		js_alert_back('이미 존제하는 영문 이름입니다.');
		exit;
	}
	$data[datetime]		= date("Y-m-d H:i:s");
	$db_id		= $DB->insertTable($table01, $data);

	if(!$DB->table_exist("sh_board_wr_'".$ename)){
		// 게시판 테이블 생성
		$DB->query("CREATE TABLE sh_board_wr_".$ename." LIKE sh_board_sample");
		if(!is_dir($updir.$ename))	makedir($updir.$ename);
	}

	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
}else if($_POST["state"]=="update"){

	//print_r($upfilesname);exit;
	$DB->updateTable($table01, $data, "WHERE no='$data[no]'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}

	for ($i=0; $i<$count; $i++){		
		$k							= $_POST['chk'][$i];
		$data[no]					= $_POST['nos'][$k];

		$data2[name]				= $_POST['name'][$k];
		$data2[list_grant]			= $_POST['list_grant'][$k];
		$data2[read_grant]			= $_POST['read_grant'][$k];
		$data2[write_grant]			= $_POST['write_grant'][$k];
		$data2[replay_grant]		= $_POST['replay_grant'][$k];
		$data2[comment_grant]		= $_POST['comment_grant'][$k];
		$data2[skin]				= $_POST['skin'][$k];
		
		$DB->updateTable($table01, $data2, "WHERE no='".$data[no]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];

		if($data[no]){
			// 이미지/디비 삭제
			$row_files  = $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$data[no]."' ORDER BY no ASC");

			// 삭제 차단
			if($row_files[ename]=="notice" or $row_files[ename]=="qanda"){				
				js_alert_back('샵에서 쓰는 게시판입니다. 삭제 할 수 없습니다.');
				exit;
			}
				
			// 생성 디렉토리 및 파일 삭제
			if(is_dir($updir.$row_files[ename])){
				$del_dir	= $updir.$row_files[ename];
				array_map('unlink', glob("$del_dir/*.*"));
				rmdir($del_dir);
			}
			
			// 게시판 설정 삭제
			$DB->query("DELETE FROM ".$table01." WHERE no = '".$row_files[no]."'");	

			// 게시판 테이블 삭제	
			if($DB->table_exist("sh_board_wr_".$row_files[ename])){
				$DB->query("DROP TABLE sh_board_wr_".$row_files[ename]."");
			}
			
			// 게시판 댓글 삭제
			$DB->query("DELETE FROM ".$table02." WHERE board_id = '".$row_files[ename]."'");	

		}
	}
}


//페이지 이동
if($data[referer]){
	goto_url($data[referer]);
}
if($referer){
	goto_url($referer);
}


?>
