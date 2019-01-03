<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once($sh["rPath"]."/_head.php");

$leftcode			= 3;
$include_file		= "board_copy_move";

$referer			= prevpage();
$sh_title			= "게시물 복사/이동 관리";
$table01			= BOARD_SET_TABLE;
$table02			= BOARD_WRITE_TABLE.$board_id;

$btn_name			= ($mode=="move")	? "이동" : "복사";
$rowslimit			= 50;
if(!$this_page) $this_page = 1;


$count				= count($_POST['chk']);
for ($i=0; $i<$count; $i++){		
	$k						= $_POST['chk'][$i];
	$tmp_no[]				= $_POST['nos'][$k];
}

if(is_array($tmp_no)){
	$board_nos	= @implode(",", $tmp_no);
}else{
	$board_nos	= $no;
}

$sql		= "SELECT a.* FROM ".$table01." a WHERE ename<>'$board_id' ORDER BY a.no DESC";
$row		= $DB->dfetcharr($sql);
$tot		= $DB->rows_count($sql);
$idx		= $tot-$rowslimit*($this_page-1);

include_once("./".$include_file."_list.php");

?>
