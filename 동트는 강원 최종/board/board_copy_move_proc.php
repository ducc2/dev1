<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$DB					= new database;
$data				= $_POST;
$referer			= prevpage();
$table01			= BOARD_WRITE_TABLE;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$referer			= prevpage();
$updir				= DATA_PATH."board/";
$upUrl				= "../data/board/";


//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//게시물 필드
$in_fields			= array("reply", "category", "options", "subject", "content", "link1", "link2", "link1_hit", "link2_hit", "hit",
							"good", "comment", "mem_id", "password", "name", "email", "homepage", "file", "ip", 
							"extra_1", "extra_2", "extra_3", "extra_4", "extra_5", "extra_6", "extra_7", "extra_8", "extra_9", "extra_10");
$in_fields_txt		= implode(",", $in_fields);

//게시물 댓글 필드
$reply_fields		= array("comment_reply", "options", "content", "mem_id", "password", "name", "datetime", "ip");
$reply_fields_txt	= implode(",", $reply_fields);

$posting_nos		= explode(",", $board_nos);
$origin_table		= $table01.$board_id;
$origin_dir			= $updir.$board_id;

$post_row			= $DB->dfetcharr("SELECT DISTINCT num FROM ".$origin_table." WHERE no IN ($board_nos) ORDER BY no ASC");

for ($i=0; $i<count($post_row); $i++){
	$post_rows		= $post_row[$i];

	for($j=0; $j < count($_POST['chk']); $j++){
		$kk					= $_POST['chk'][$j];
		$data[enames]		= $_POST['enames'][$kk];
		
		$target_table		= $table01.$data[enames];
		$target_dir			= $updir.$data[enames];
		$sql				= "SELECT MAX(num) FROM ".$target_table." a ";
		$data[num]			= $DB->result($sql)+1;

		$origin_row			= $DB->dfetcharr("SELECT * FROM ".$origin_table." WHERE num='".$post_rows[num]."' ORDER BY reply ASC"); 

		//echo "SELECT * FROM ".$origin_table." WHERE num='".$post_rows[num]."'  ORDER BY reply ASC";exit;
		//echo "<pre>";print_r($origin_row);echo "</pre>";
		//exit;

		for($k=0; $k < count($origin_row); $k++){
			$origin_rows		= $origin_row[$k];
			// 게시물 복사
			$cp_sql				= "INSERT INTO ".$target_table." ( $in_fields_txt ) SELECT $in_fields_txt FROM ".$origin_table." WHERE no='".$origin_rows[no]."'";
			$db_id				= $DB->query($cp_sql);
			$board_no			= mysql_insert_id();
			$dataup[num]		= $data[num]; 
			$dataup[parent]		= $data[num];

			// 게시물 고유값 업데이트
			$dataup[datetime]	= date("Y-m-d H:i:s");	
			$dataup[last]		= date("Y-m-d H:i:s");
			$DB->updateTable($target_table, $dataup, "WHERE no='".$board_no."'");
			
			
			
			// 게시물 댓글 복사
			$rp_sql				= "INSERT INTO ".$table03." ( $reply_fields_txt, board_no, board_id ) 
								   SELECT $reply_fields_txt, '$board_no', '$data[enames]' FROM ".$table03." WHERE board_no='".$origin_rows[no]."' AND board_id='".$board_id."' ";
			$db_id				= $DB->query($rp_sql);

			// 게시물 이미지 복사
			$row_file  = $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_no='".$origin_rows[no]."' AND board_id='".$board_id."' ORDER BY file_sort ASC");
			for($l=0; $l<sizeof($row_file); $l++){
				$row_files		= $row_file[$l];
				$old_file		= $origin_dir."/".$row_files[filename];

				$data_file[fn1]	= renamefile($old_file, $target_dir, "1");
				uploadfile($old_file, $data_file[fn1], $target_dir);


				$data_file[board_no]			= $board_no;
				$data_file[board_id]			= $data[enames];
				$data_file[file_size]			= $row_files[file_size];
				$data_file[filename]			= $data_file[fn1];
				$data_file[filename_original]	= $row_files[filename_original];
				$data_file[file_sort]			= $row_files[file_sort];
				$DB->insertTable($table02, $data_file);
			}
		}
	}

	
	// 게시물 이동시 원본 삭제
	if($_POST["state"]=="move"){
		$origin_del			= $DB->dfetcharr("SELECT * FROM ".$origin_table." WHERE num='".$post_rows[num]."' ORDER BY reply ASC");
		for($m=0; $m < count($origin_del); $m++){
			$origin_dels		= $origin_del[$m];

			//게시물 파일/디비 삭제
			$row_file  = $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$origin_dels[no]."' ORDER BY file_sort ASC");
			for($mm=0;$mm<sizeof($row_file);$mm++){
				$row_files	= $row_file[$mm];
				$del		= @unlink($origin_dir."/".$row_files[filename]);					
				$DB->query("DELETE FROM ".$table02." WHERE no = '".$row_files[no]."'");
			}
					
			// 게시물 댓글 삭제
			$DB->query("DELETE FROM ".$table03." WHERE board_no = '".$origin_dels[no]."' AND board_id = '".$board_id."'");	
			// 게시물 삭제
			$DB->query("DELETE FROM ".$origin_table." WHERE no = '".$origin_dels[no]."'");
		}
	}
}


if($db_id){
	// 성공
}else{
	js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
}

js_alert_close_reload("게시물 ".$mode_str."를 완료 하였습니다.");

?>
