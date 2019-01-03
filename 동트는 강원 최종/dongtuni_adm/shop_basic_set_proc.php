<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();
$table01	= SHOP_BASIC_SET_TABLE;

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');

				
//널체크
$check_data		= array("site_subject"=>"홈페이지 제목");
$check_result	= null_check($data, $check_data);
if($check_result){
	js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
}


for($i=0; $i<count($_FILES[upfiles][name]); $i++){
	if($_FILES[upfiles][error][$i] == ""){
		$del		= @unlink($updir."/".$data["del_name".$i]);
		$data[fn1]	= renamefile($_FILES[upfiles][name][$i],$updir,"1");
		uploadfile($_FILES[upfiles][tmp_name][$i],$data[fn1],$updir);
		$data[$upfilesname[$i]] = $_FILES[upfiles][name][$i]."|".$data[fn1];
	}
}


$DB->updateTable($table01, $data, "WHERE no='1'");
goto_url($referer);

?>
