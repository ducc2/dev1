<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();
$table01	= SHOP_POPUP_TABLE;

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');

if($_POST["state"]=="insert" or $_POST["state"]=="update"){
	$check_data		= array("pop_name"=>"팝업명 ", "pop_sdate"=>"노출기간", "pop_edate"=>"노출기간", "pop_use"=>"사용여부", "pop_width"=>"팝업크기", 
							"pop_height"=>"팝업크기", "pop_left"=>"팝업위치", "pop_top"=>"팝업위치");

}else if($_POST["state"]=="update_multi"){
	$check_data		= array("pop_name"=>"팝업명 ", "pop_use"=>"사용여부", "pop_width"=>"팝업크기", "pop_height"=>"팝업크기", "pop_left"=>"팝업위치", "pop_top"=>"팝업위치");

}

//널체크
$check_result	= null_check($data, $check_data);
if($check_result){
	js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
}
$referer	= prevpage();

if($_POST["state"]=="insert"){

	// 첨부파일 처리로직
	for($i=0; $i<count($_FILES[upfiles][name]); $i++){
		if($_FILES[upfiles][error][$i] == ""){
			$del		= @unlink($updir."/".$data["del_name".$i]);
			$data[fn1]	= renamefile($_FILES[upfiles][name][$i],$updir,"1");
			uploadfile($_FILES[upfiles][tmp_name][$i],$data[fn1],$updir);
			$data[$upfilesname[$i]] = $_FILES[upfiles][name][$i]."|".$data[fn1];
		}
	}
	$db_id	= $DB->insertTable($table01, $data);
	
	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
}else if($_POST["state"]=="update"){


	// 첨부파일 삭제로직
	for($j=0; $j<count($file_del_check); $j++){
		$del_temp			= explode("|@@|", $file_del_check[$j]);
		if($del_temp[1])	@unlink($updir."/".$del_temp[1]);
		$data[$del_temp[0]]	= "";
	}

	// 첨부파일 처리로직
	for($i=0; $i<count($_FILES[upfiles][name]); $i++){
		if($_FILES[upfiles][error][$i] == ""){
			
			if(!${$upfilesname[$i]."_old"}){
				$data[fn1]	= renamefile($_FILES[upfiles][name][$i],$updir,"1");
			}else{
				$data[fn1]	= ${$upfilesname[$i]."_old"};
			}

			uploadfile($_FILES[upfiles][tmp_name][$i], $data[fn1], $updir);
			$data[$upfilesname[$i]] = $_FILES[upfiles][name][$i]."|".$data[fn1];
		}
	}

	//print_r($upfilesname);exit;
	$DB->updateTable($table01, $data, "WHERE no='$data[no]'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}

	for ($i=0; $i<$count; $i++){		
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];
		$data2[pop_name]		= $_POST['pop_name'][$k];
		$data2[pop_use]			= $_POST['pop_use'][$k];
		$data2[pop_width]		= $_POST['pop_width'][$k];
		$data2[pop_height]		= $_POST['pop_height'][$k];
		$data2[pop_left]		= $_POST['pop_left'][$k];
		$data2[pop_top]			= $_POST['pop_top'][$k];
		
		$DB->updateTable($table01, $data2, "WHERE no='".$data[no]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];

		if($data[no]){
			//이미지/디비 삭제
			$row_files  = $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$data[no]."' ORDER BY no ASC");
			
			if($row_files[pop_img]){
				$filename_exp	= explode("|", $row_files[pop_img]);
				@unlink($updir."/".$filename_exp[1]);		
			}

			if($data[no]){
				$DB->query("DELETE FROM ".$table01." WHERE no = '".$data[no]."'");	
			}
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
