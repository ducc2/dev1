<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();
$table01	= "newsletter_req";

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
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

		$data[snum]			=	$_POST['stype'];

		if ($_POST['snum']>4) { 
			$data[stype]			=	"택배";
		} else {
			$data[stype]			=	"우편";
		}
		$data[group]			=	$_POST['group'];

	$db_id	= $DB->insertTable($table01, $data);
	
	if($db_id){
		// 성공
	}else{
		js_alert_back("정상적으로 안되었습니다. 다시 시도해 보세요.");
	}
}else if($_POST["state"]=="update"){
		
		$dataup[userNm] = $_POST['userNm'];	
		$dataup[tel] = $_POST['tel'];
		$dataup[email] = $_POST['email'];
		$dataup[zipcode] = $_POST['zipcode'];
		$dataup[addr1] = $_POST['addr1'];
		$dataup[addr2] = $_POST['addr2'];
		$dataup[etc] = $_POST['etc'];
		$dataup[req_motive] = $_POST['motive'];
		$dataup[subscribeType] = $_POST['division'];
		$dataup[snum]			=	$_POST['snum'];

		if ($_POST['snum']>4) { 
			$dataup[stype]			=	"택배";
		} else {
			$dataup[stype]			=	"우편";
		}
			
		$dataup[ggr]			=	$_POST['ggr'];
		$dataup[updateDttm]		=	date("Y-m-d H:i:s");

		$DB->updateTable($table01, $dataup, "WHERE idx='".$_POST[idx]."'");

}else if($_POST["state"]=="update_multi"){
	$count = count($_POST['chk']);
	if(!$count){
		js_alert_back("1개이상 선택해 주세요.");
		exit;
	}


	for ($i=0; $i<$count; $i++){		
		$k						= $_POST['chk'][$i];
		
		$data2[subscribeType]	= $_POST['subscribeType'][$k];
		$data2[ggr]				= $_POST['ggr'][$k];
		$data2[stype]			= $_POST['stype'][$k];
		$data2[cancelYn]		= $_POST['cancelYn'][$k];
		
		

		$DB->updateTable($table01, $data2, "WHERE idx='".$_POST[idx][$k]."'");
	}

}else if($_POST["state"]=="drop_multi"){
	$count = count($_POST['chk']);
	
	for ($i=0; $i<$count; $i++){	
		$k						= $_POST['chk'][$i];
		$data[idx]				= $_POST['idx'][$k];

		if($data[idx]){
			$DB->query("DELETE FROM ".$table01." WHERE idx = '".$data[idx]."'");	
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
