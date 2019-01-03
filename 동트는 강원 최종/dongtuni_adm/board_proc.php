<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$data				= $_POST;
$referer			= prevpage();
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$table04			= MEM_TABLE;
$table05			= SHOP_POINT_USE_TABLE;


//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');
if($_POST["state"]=="insert" or $_POST["state"]=="update"){
	if($_POST["state"]=="insert"){
		$check_data		= array("name"=>"이름", "subject"=>"제목");
	}else if($_POST["state"]=="update" or $_POST["state"]=="update_multi"){
		$check_data		= array("name"=>"이름", "subject"=>"제목");
	}

	//널체크
	$check_result	= null_check($data, $check_data);
	if($check_result){
		js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
	}
}


//
// 인서트
if($_POST["state"]=="insert"){
	unset($data[no]);
	
	if($reply){
		// 권한 체크
		if($member[mem_level] < $board_info[replay_grant] and $board_info[replay_grant] > 0){
			js_alert_back("게시물 답글 등록 권한이 없습니다."); exit;
		}
		$data[num]			= $data[num];
	}else{
		// 권한 체크
		if($member[mem_level] < $board_info[write_grant] and $board_info[write_grant] > 0){
			js_alert_back("게시물 등록 권한이 없습니다."); exit;
		}
		$sql				= "SELECT MAX(num) FROM ".$table01." a";
		$data[num]			= $DB->result($sql)+1;
	}

	$data[password]		= $DB->get_mysql_password($data[password]);
	$data[mem_id]		= $_SESSION["mem_id_session"];
	$data[datetime]		= date("Y-m-d H:i:s");	
	$data[last]			= date("Y-m-d H:i:s");	
	$data[ip]			= $_SERVER['REMOTE_ADDR'];	
	$fileup_cnt			= 0;
	
	
	//print_r($data);exit;
	$db_id		= $DB->insertTable($table01, $data);
	$board_no	= mysql_insert_id();
	$updir = $updir."/";

	
	if ($_POST['extra_4']) {
		$temp = explode(",",$_POST['extra_4']);
		$temp_c = count($temp);

		for($i=0;$i<$temp_c;$i++ ) {
						
						$exrow			= $DB->fetcharr("SELECT * FROM sh_board_set WHERE tag_content='".$data2[tag_content]."'");
						if (!$exrow['tag_id']) {	
							$data2[tag_content]					= $temp[$i];
							$data2[board_id]						= $board_no;
							$data2[tag_reg]							= date("Y-m-d H:i:s");
							$DB->insertTable("sh_board_tag", $data2);
						}
		}
	}

	// 첨부파일 업로드 권한 체크
		// 첨부파일 처리로직
		for($i=0; $i<count($_FILES[upfiles][name]); $i++){

				$data_file[fn1]	= renamefile($_FILES[upfiles][name][$i],$updir,"1");
				uploadfile($_FILES[upfiles][tmp_name][$i], $data_file[fn1], $updir);	
				$thumb_dir			= $updir."/thumb/";
				$new_name			= $data_file[fn1];

				//make_thumb( $updir."/".$data_file[fn1], $thumb_dir."/thumb".$new_name, 277, 178 );


				$thumncheck = makeThumbnails($updir, $thumb_dir, $data_file[fn1], $new_name, $board_info[gallery_width], $board_info[gallery_height]);



				$data_file[board_no]			= $board_no;
				$data_file[board_id]			= $board_id;
				$data_file[file_size]			= $_FILES[upfiles][size][$i];
				$data_file[filename]			= $data_file[fn1];
				$data_file[filename_original]	= $_FILES[upfiles][name][$i];
				$data_file[file_sort]			= $i;
				$DB->insertTable($table02, $data_file);
				$fileup_cnt++;
		}

	$dataup[parent]			= (!$data[parent]) ? $board_no:$data[parent];
	$dataup[file]			= $fileup_cnt;
	$DB->updateTable($table01, $dataup, "WHERE no='".$board_no."'");
	
	$row			= $DB->fetcharr("SELECT * FROM sh_board_set WHERE ename='".$board_id."'");
	$new_count = $row['list_cnt']+1;
	
	$data_['list_cnt'] = $new_count;

	$DB->updateTable("sh_board_set", $data_, "WHERE ename='".$board_id."'");


	// 포인트 지급
	if($_SESSION["mem_id_session"] and $board_info[write_point] > 0){
							
		$data[mem_id]		= $member[mem_id];
		$data[mem_name]		= $member[mem_name];
		$data[contents]		= "게시물 등록 포인트";
		$data[point]		= $board_info[write_point];
		$data[point_type]	= "+";
		$data[point_state]	= "1";
		$data[datetime]		= date("Y-m-d H:i:s");
		$DB->insertTable($table05, $data);

		$data_mem[mem_point]	= $member[mem_point] + $board_info[write_point];
		$DB->updateTable($table04, $data_mem, "WHERE mem_no='".$member[mem_no]."'");
	}

	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}


//
// 업데이트
}else if($_POST["state"]=="update"){


	if(empty($data[options]))	$data[options]	= "";
	if(empty($data[notice]))	$data[notice]	= "";

	$data[extra_1]				= $_POST['extra_1'];
	$data[extra_2]				= $_POST['extra_2'];
	$data[extra_3]				= $_POST['extra_3'];
	$data[extra_4]				= $_POST['extra_4'];
	$data[extra_5]				= $_POST['extra_5'];
	//print_r($data);exit;

	
	$DB->updateTable($table01, $data, "WHERE no='$data[no]'");

	// 첨부파일 삭제로직
	for($j=0; $j<count($file_del_check); $j++){
		$del_temp	= explode("|@@|", $file_del_check[$j]);
		$del		= @unlink($updir."/".$del_temp[1]);					
		$DB->query("DELETE FROM ".$table02." WHERE no = '".$del_temp[0]."' ");
	}
	
	$board_no		= $data[no];
	$updir = $updir."/";
	// 첨부파일 업로드 권한 체크
	if($member[mem_level] >= $board_info[upload_grant] and $board_info[upload_grant] >= 0){
		 //print_r($_FILES);exit;
		// 첨부파일 처리로직
		for($i=0; $i<count($_FILES[upfiles][name]); $i++){	//print_r($_FILES[upfiles][name]);echo "<br>";print_r($file_no);exit;
			if($_FILES[upfiles][error][$i] == ""){
				$data_file[fn1]	= renamefile($_FILES[upfiles][name][$i],$updir,"1");
				uploadfile($_FILES[upfiles][tmp_name][$i], $data_file[fn1], $updir);	
				$thumb_dir			= $updir."/thumb/";
				$new_name			= $data_file[fn1];

				//make_thumb( $updir."/".$data_file[fn1], $thumb_dir."/thumb".$new_name, 277, 178 );


				$thumncheck = makeThumbnails($updir, $thumb_dir, $data_file[fn1], $new_name, $board_info[gallery_width], $board_info[gallery_height]);

				$data_file[board_no]			= $board_no;
				$data_file[board_id]			= $board_id;
				$data_file[file_size]			= $_FILES[upfiles][size][$i];
				$data_file[filename]			= $data_file[fn1];
				$data_file[filename_original]	= $_FILES[upfiles][name][$i];
				$data_file[file_sort]			= $i;

				if($file_no[$i]){
					$DB->updateTable($table02, $data_file, "WHERE no='".$file_no[$i]."'");
				}else{
					$DB->insertTable($table02, $data_file);
					$data[file]++;
				}
			}
		}
	}

	$data[last]			= date("Y-m-d H:i:s");
	$DB->updateTable($table01, $data, "WHERE no='$data[no]'");

//
// 추천 인서트
}elseif($_POST["state"]=="recommend_insert"){	
	//널체크
	$check_data		= array("no"=>"게시물 번호", "board_id"=>"게시판 아이디");
	$check_result	= null_check($data, $check_data);
	if($check_result){
		js_alert("[$check_result]공백입니다. 다시입력해주세요.");
		exit;
	}

	$db_id		= $DB->query("UPDATE ".$table01." SET good = good+1  WHERE no = '".$no."'");

	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
	js_alert_parent_reload("");

//
// 댓글 등록
}elseif($_POST["state"]=="comment"){	

	// 권한 체크
	if($member[mem_level] < $board_info[comment_grant] and $board_info[comment_grant] > 0){
		js_alert("게시물 댓글 등록 권한이 없습니다."); exit;
	}

	//널체크
	$check_data		= array("name"=>"이름", "content"=>"내용");
	$check_result	= null_check($data, $check_data);
	if($check_result){
		js_alert("[$check_result]공백입니다. 다시입력해주세요.");
		exit;
	}

	$data[password]		= $DB->get_mysql_password($data[password]);
	$data[mem_id]		= $_SESSION["mem_id_session"];
	$data[datetime]		= date("Y-m-d H:i:s");	
	$data[ip]			= $_SERVER['REMOTE_ADDR'];		
	
	//print_r($data);exit;
	$db_id		= $DB->insertTable($table03, $data);
	
	$dataup[comment]	= $cur_comment+1;
	$DB->updateTable($table01, $dataup, "WHERE no='".$board_no."'");


	// 포인트 지급
	if($_SESSION["mem_id_session"] and $board_info[comment_point] > 0){
							
		$data[mem_id]		= $member[mem_id];
		$data[mem_name]		= $member[mem_name];
		$data[contents]		= "게시물 댓글 포인트";
		$data[point]		= $board_info[comment_point];
		$data[point_type]	= "+";
		$data[point_state]	= "1";
		$data[datetime]		= date("Y-m-d H:i:s");
		$DB->insertTable($table05, $data);

		$data_mem[mem_point]	= $member[mem_point] + $board_info[comment_point];
		$DB->updateTable($table04, $data_mem, "WHERE mem_no='".$member[mem_no]."'");;
	}


	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
	js_alert_parent_reload("");

//
// 게시물 삭제
}else if($_POST["state"]=="drop"){

	if($no){

		//원글 정보 가져와 답글 수량 체크
		$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$data[no]."'");
		$reply_row		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table01." WHERE reply<>'' AND parent='".$row[no]."' AND num='".$row[num]."'");
		if($reply_row[cnt] > 0 ){
			js_alert('답글이 있는 게시물 입니다. 삭제할 수 없습니다.\\n답글 먼저 삭제해 주세요.');
			exit;
		}

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
	?>
	<script>
	alert("삭제가 완료되었습니다.");
	top.location.href='<?=$parent_referer?>';
	</script>
	<?
exit;

//
// 멀티 삭제(목록에서)
}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);

	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];

		if($data[no]){

			//원글 정보 가져와 답글 수량 체크
			$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$data[no]."'");
			$reply_row		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table01." WHERE reply<>'' AND parent='".$row[no]."' AND num='".$row[num]."'");
			if($reply_row[cnt] > 0 ){
				js_alert_back('답글이 있는 게시물 입니다. 삭제할 수 없습니다.\\n[답글 먼저 삭제해 주세요.]'); 
			}

			//게시물 파일/디비 삭제
			$row_file  = $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$data[no]."' ORDER BY file_sort ASC");
			for($j=0;$j<sizeof($row_file);$j++){
				$row_files	= $row_file[$j];
				$del		= @unlink($updir."/".$row_files[filename]);					
				$DB->query("DELETE FROM ".$table02." WHERE no = '".$row_files[no]."'");
			}
					
			// 게시물 댓글 삭제
			$DB->query("DELETE FROM ".$table03." WHERE board_no = '".$data[no]."' AND board_id = '".$board_id."'");	
			// 게시물 삭제
			$DB->query("DELETE FROM ".$table01." WHERE no = '".$data[no]."'");
		}
	}
}

//echo $data[referer]; exit;

//페이지 이동
if($data[referer]){
	goto_url($data[referer]);
}
if($referer){
	goto_url($referer);
}


?>
