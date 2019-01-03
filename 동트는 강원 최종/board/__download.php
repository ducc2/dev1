<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$table01			= BOARD_FILE_TABLE;

// 권한 체크
if($member[mem_level] < $board_info[download_grant] and $board_info[download_grant] > 0){
	js_alert_back("파일 다운로드 권한이 없습니다."); exit;
}

$DB->query("UPDATE ".$table01." set download=download+1 WHERE no='".$no."'");

global $HTTP_USER_AGENT;
$d = ($d) ? "attachment" : "inline";

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$path"));
    header("content-disposition: attachment; filename=\"$name\"");
    header("content-transfer-encoding: binary");
}else{
    header("content-type: file/unknown");
    header("content-length: ".filesize("$path"));
    header("content-disposition: attachment; filename=\"$name\"");
    header("content-description: php generated data");
}
if(is_file($path)){
	$fp = fopen($path, "r");
	if(!fpassthru($fp)) fclose($fp);
}
?>