<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();
$table01	= SHOP_BANNER_TABLE;

$referer	= prevpage();

if($_POST["state"]=="insert"){

	// 첨부파일 처리로직
	$data[name]   = $_POST['name'];
	$data[phone]   = $_POST['phone'];
	$data[content]   = $_POST['content'];

	$db_id = $DB->insertTable("sh_supporter", $data);
	
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

	$data[name]   = $_POST['name'];
	$data[phone]   = $_POST['phone'];
	$data[content]   = $_POST['content'];


	//print_r($upfilesname);exit;
	$DB->updateTable("sh_supporter", $data, "WHERE no='$data[no]'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}

	for ($i=0; $i<$count; $i++){		
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];
		$data2[ban_name]		= $_POST['ban_name'][$k];
		$data2[position]		= $_POST['position'][$k];
		$data2[sequence]		= $_POST['sequence'][$k];
		$data2[ban_use]			= $_POST['ban_use'][$k];
		$data2[ban_width]		= $_POST['ban_width'][$k];
		$data2[ban_height]		= $_POST['ban_height'][$k];
		$data2[ban_link_type]	= $_POST['ban_link_type'][$k];

		$DB->updateTable($table01, $data2, "WHERE no='".$data[no]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[no]				= $_POST['nos'][$k];

		if($data[no]){
				$DB->query("DELETE FROM sh_supporter WHERE no = '".$data[no]."'");	
		}
	}
}else if($_GET["state"]=="extra_1"){

		$data2[extra_1]	= $_GET['extra_1'];

		$DB->updateTable("sh_supporter", $data2, "WHERE no='".$_GET[no]."'");
}



//페이지 이동
if($data[referer]){
	goto_url($data[referer]);
}
if($referer){
	goto_url($referer);
}


?>
