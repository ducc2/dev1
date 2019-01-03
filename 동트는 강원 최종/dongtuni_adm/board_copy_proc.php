<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB					= new database;
$data				= $_POST;
$referer			= prevpage();
$table01			= BOARD_SET_TABLE;
$table02			= BOARD_FILE_TABLE;


//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

if (preg_match("/[^0-9a-z_]+/i", $ename)){
	js_alert_back('게시판 영문 이름은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)');
	exit;
}

$in_fields		= array("category", "manager_id", "list_grant", "read_grant", "write_grant", "replay_grant", "comment_grant", "upload_grant", 
						"download_grant", "secret_use", "editer_use", "recommender_use", "ip_view", "upload_cnt", "upload_bytes", "skin", "top_include", "bottom_include", 
						"top_contents", "bottom_contents", "subject_length", "list_cnt", "gallery_cnt", "gallery_width", "gallery_height", "all_width", "new_icon", 
						"best_icon", "write_point", "read_point", "comment_point", "mobile_skin", "mobile_top_contents", "mobile_bottom_contents", "mobile_subject_length", 
						"mobile_list_cnt", "mobile_gallery_cnt", "mobile_gallery_width", "mobile_gallery_height", "datetime", "extra_subject_1", "extra_subject_2", 
						"extra_subject_3", "extra_subject_4", "extra_subject_5", "extra_subject_6", "extra_subject_7", "extra_subject_8", "extra_subject_9", 
						"extra_subject_10", "extra_field_1", "extra_field_2", "extra_field_3", "extra_field_4", "extra_field_5", "extra_field_6", "extra_field_7", 
						"extra_field_8", "extra_field_9", "extra_field_10");
$in_fields_txt	= implode(",", $in_fields);


// 상품복사
if($_POST["state"]=="copy"){

	$row		= $DB->dfetcharr("SELECT * FROM ".$table01." WHERE ename='".$ename."'");
	if($row){
		js_alert_back('이미 존제하는 영문 이름입니다.');
		exit;
	}

	$cp_sql				= "INSERT INTO ".$table01." ( $in_fields_txt ) SELECT $in_fields_txt FROM ".$table01." WHERE no='".$data[no]."'";
	$db_id				= $DB->query($cp_sql);
	$insert_no			= mysql_insert_id();

	$dataup[name]		= $data[name];
	$dataup[ename]		= $data[ename];
	$dataup[datetime]	= date("Y-m-d H:i:s");
	$DB->updateTable($table01, $dataup, "WHERE no='".$insert_no."'");

	if(!$DB->table_exist("sh_board_wr_'".$ename)){
		// 게시판 테이블 생성
		$DB->query("CREATE TABLE sh_board_wr_".$ename." LIKE sh_board_wr_".$original_ename);
		if(!is_dir($updir.$ename))	makedir($updir.$ename);

		if($copy_type=="2"){
			// 게시판 테이블 생성
			$DB->query("INSERT INTO sh_board_wr_".$ename." SELECT * FROM sh_board_wr_".$original_ename);

			// 게시판 파일 복사
			$row_file  = $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$original_ename."' ORDER BY file_sort ASC");
			for($j=0;$j<sizeof($row_file);$j++){
				$row_files		= $row_file[$j];
				$old_updir		= $updir.$original_ename."/";			
				$new_updir		= $updir.$ename;
				$old_file		= $updir.$original_ename."/".$row_files[filename];	

				$data_file[fn1]	= renamefile($old_file, $updir, "1");
				uploadfile($old_file, $data_file[fn1], $new_updir);

				$data_file[board_no]			= $row_files[board_no];
				$data_file[board_id]			= $ename;
				$data_file[file_size]			= $row_files[file_size];
				$data_file[filename]			= $data_file[fn1];
				$data_file[filename_original]	= $row_files[filename_original];
				$data_file[file_sort]			= $i;
				$DB->insertTable($table02, $data_file);
			}
		}

	}else{
		js_alert_back("같은 영문이름의 테이불이 있습니다.\n 삭제후 다시 시도해 보세요.[ 테이블명 : sh_board_wr_$ename ]");
	}

	
	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
	js_alert_close_reload("게시판 복사를 완료 하였습니다.");
}

?>
