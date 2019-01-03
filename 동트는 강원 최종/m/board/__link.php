<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$table01			= BOARD_WRITE_TABLE.$board_id;

if($linkurl1){
	$DB->query("UPDATE ".$table01." set link1_hit=link1_hit+1 WHERE no='".$no."'");
	$linkurl1		= str_replace("http://", "",  $linkurl1);
	$linkurl		= "http://".$linkurl1;
}

if($linkurl2){
	$DB->query("UPDATE ".$table01." set link2_hit=link2_hit+1 WHERE no='".$no."'");
	$linkurl2		= str_replace("http://", "",  $linkurl2);
	$linkurl		= "http://".$linkurl2;
}

header('Location: '.$linkurl);

?>