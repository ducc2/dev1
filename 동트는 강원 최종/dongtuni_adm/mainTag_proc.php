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
	$data[mtag_content]			= $_POST['mtag_content'];
	$data[mtag_reg]			= date("Y-m-d H:i:s");
	

	$db_id = $DB->insertTable("sh_board_tag_main", $data);
	
	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
}else if($_POST["state"]=="update"){
	

	$data[mtag_content]			= $_POST['mtag_content'];

	//print_r($upfilesname);exit;
	$DB->updateTable("sh_board_tag_main", $data, "WHERE mtag_id='$data[mtag_id]'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}

	for ($i=0; $i<$count; $i++){		
		$k										= $_POST['chk'][$i];
		$data[mtag_id]				= $_POST['nos'][$k];
		$data[mtag_content]			= $_POST['mtag_content'];


		$DB->updateTable($table01, $data2, "WHERE mtag_id='".$data[mtag_id]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[mtag_id]				= $_POST['nos'][$k];

		if($data[mtag_id]){
				$DB->query("DELETE FROM sh_board_tag_main WHERE mtag_id = '".$data[mtag_id]."'");	
		}
	}
}else if($_GET["state"]=="extra_1"){

		$data2[extra_1]	= $_GET['extra_1'];

		$DB->updateTable("sh_board_tag_main", $data2, "WHERE mtag_id='".$_GET[mtag_id]."'");
}



//페이지 이동
if($data[referer]){
	goto_url($data[referer]);
}
if($referer){
	goto_url($referer);
}


?>
