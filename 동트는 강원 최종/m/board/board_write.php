<?
$sh["rPath"]	= "../..";
include_once($sh["rPath"]."/_common.php");

$referer			= prevpage();
$sh["title"]		= $sh["stie_title"]."-".$board_info[name]." 게시판";
$sh_title			= $board_info[name];
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/thumb/";
$thumb_url			= "../../data/board/".$board_id."/thumb/";
$upUrl				= "../../data/board/".$board_id;
$state				= "insert";


if(!$board_id){
	js_alert_back("게시판 아이디가 없습니다. 다시 확인해 주세요.");
	exit;
}

// 권한 체크
if($member[mem_level] < $board_info[list_grant] and $board_info[list_grant] > 0){
	js_alert_back("게시물 목록 읽기 권한이 없습니다.");
	exit;
}

$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_head.php");
if(is_file($board_info[top_include])){
	include_once($board_info[top_include]);
}else{
	include_once($sh["rPath"]."/_top.php");
}

$user_skin		= $board_info[skin];
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

// 권한 체크
if($member[mem_level] < $board_info[write_grant] and $board_info[write_grant] > 0){
	js_alert_back("게시물 등록 권한이 없습니다.");
	exit;
}
if(!$no)	$name	= $member[mem_name];

// 게시글 수정
if($no and !$reply){

	$state			= "update";
	$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");
	$row_file		= $DB->dfetcharr("SELECT * FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$no."'");
	
	for($i=0; $i < count($row_file); $i++){
		$row_files	= $row_file[$i];

		${"upload_del"}[]	= " 
									<input type='checkbox' name='file_del_check[]' id='file_del_$i' value='$row_files[no]|@@|$row_files[filename]'>
									<label for='file_del_$i'>$row_files[filename_original] (삭제 시 체크)</label>
									<input type='hidden' name='file_no[]' value='$row_files[no]'>";
	}

	// 패스워드 초기화 체크
	if(!$_SESSION["mem_id_session"] OR $_SESSION["mem_id_session"]<>$row[mem_id]){
		$row[password]	= "";
	}

	text_special_replace($row);
	extract($row);
}

// 답변 글 
if($no and $reply){
	// 권한 체크
	if($member[mem_level] < $board_info[replay_grant] and $board_info[replay_grant] > 0){
		js_alert_back("게시물 답변 권한이 없습니다.");
		exit;
	}

	$parent			= $no;
	$row			= $DB->fetcharr("SELECT num, reply, category, subject, content FROM ".$table01." WHERE no='".$no."'");
	if(!$row[reply]){
		$row[reply]		= $DB->result("SELECT MAX(reply) FROM ".$table01." a WHERE num='".$row[num]."'")+1;
	}else{
		$row[reply]		= $row[reply]."1";
	}
	$row[subject]		= "[ 답글 ]".$row[subject];

	text_special_replace($row);
	extract($row);
}

include_once($board_skin."/write.php");


include_once($sh["rPath"]."/_bottom_sub.php");
?>
