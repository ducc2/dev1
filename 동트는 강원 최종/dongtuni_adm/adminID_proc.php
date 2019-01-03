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
	$data[mem_id]					= $_POST['mem_id'];
	$data[mem_password]		= $DB->get_mysql_password($_POST['mem_password']);
	$data[mem_name]			= $_POST['mem_name'];
	$data[mem_level]				= "10";
	

	$db_id = $DB->insertTable("sh_member", $data);
	
	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
}else if($_POST["state"]=="update"){
	

	$data[mem_no]				= $_POST['mem_no'];
	$data[mem_id]					= $_POST['mem_id'];
	$data[mem_password]		= $DB->get_mysql_password($_POST['mem_password']);
	$data[mem_name]			= $_POST['mem_name'];

	//print_r($upfilesname);exit;
	$DB->updateTable("sh_member", $data, "WHERE mem_no='$data[mem_no]'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}

	for ($i=0; $i<$count; $i++){		
		$k										= $_POST['chk'][$i];
		$data[mem_no]				= $_POST['nos'][$k];
		$data[mem_id]					= $_POST['mem_id'];
		$data[mem_password]		= $DB->get_mysql_password($_POST['mem_password']);
		$data[mem_name]			= $_POST['mem_name'];


		$DB->updateTable($table01, $data2, "WHERE mem_no='".$data[mem_no]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[mem_no]				= $_POST['nos'][$k];

		if($data[mem_no]){
				$DB->query("DELETE FROM sh_member WHERE mem_no = '".$data[mem_no]."'");	
		}
	}
}else if($_GET["state"]=="extra_1"){

		$data2[extra_1]	= $_GET['extra_1'];

		$DB->updateTable("sh_member", $data2, "WHERE mem_no='".$_GET[mem_no]."'");
}



//페이지 이동
if($data[referer]){
	goto_url($data[referer]);
}
if($referer){
	goto_url($referer);
}


?>
