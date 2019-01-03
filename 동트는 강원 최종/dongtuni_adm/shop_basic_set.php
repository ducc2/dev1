<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");
include_once("./_left.php");


$leftcode			= 1;
include_once("./_left.php");

$sh_title			= "기본설정";
$upfilesname		= array("favicon_img");
$updir				= DATA_PATH."design/favicon/";
$upUrl				= "../data/design/favicon/";
$DB					= new database;
$shop_basic			= $DB->get_shop_set_info(SHOP_BASIC_SET_TABLE);
text_special_replace($shop_basic);

// 업로드 파일 필드 input 만들기
for($i=0; $i<count($upfilesname); $i++){
	//if($shop_basic[$upfilesname[$i]]){
	$shop_basic[upfile_field]	.= setform("hidden", "upfilesname[]", "value='".$upfilesname[$i]."'", "");
	//}
}

// 
for($i=0; $i<count($upfilesname); $i++){
	if($shop_basic[$upfilesname[$i]]){
		$filename_exp	= explode("|",$shop_basic[$upfilesname[$i]]);
		$filename_real	= $filename_exp[1];
		$shop_basic["del_".$upfilesname[$i]]	= setform("checkbox","del_file".$i,"value='$filename_real'","<input type='hidden' name='del_name".$i."' value='$filename_real'>(삭제 시 체크)");
		$shop_basic[$upfilesname[$i]."_temp"]	= "<img src='$upUrl/$filename_real' width='16' height='16'><p>";
	}
}




include_once("./shop_basic_set_form.php");


include_once("./_bottom.php");

?>
