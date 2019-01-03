<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$table01			= BOARD_FILE_TABLE;


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