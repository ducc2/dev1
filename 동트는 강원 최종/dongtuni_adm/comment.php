<?
session_start();

$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$referer			= prevpage();
$sh["title"]		= $sh["stie_title"]."-".$board_info[name]." 게시판";
$sh_title			= $board_info[name];
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$table03			= BOARD_COMMENT_TABLE;
$table04			= MEM_TABLE;
$table05			= SHOP_POINT_USE_TABLE;
$refer				= getLink();
$updir				= DATA_PATH."board/".$board_id;
$thumb_dir			= DATA_PATH."board/".$board_id;
$upUrl				= "../data/board/".$board_id;

if(!$board_id){
	js_alert_back("게시판 아이디가 없습니다. 다시 확인해 주세요.");
}

// 권한 체크
if($member[mem_level] < $board_info[read_grant] and $board_info[read_grant] > 0){
	js_alert_back("게시물 내용 읽기 권한이 없습니다.");
	exit;
}

$user_skin		= $board_info[skin];
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

$state			= "update";
$row			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");
$cur_comment	= $row[comment];

$row[content]	= str_replace("../../", "../", $row[content]);

// 댓글 가져오기 시작

$rowslimit			= 5;
$pagelimit		= 5;
if(!$this_page) $this_page = 1;

$start			= $rowslimit*($this_page-1);
$limit			= $rowslimit;
$refer			= getLink();
$sql			= "SELECT a.* FROM ".$table03." a WHERE a.board_no = '".$no."' AND board_id = '".$board_id."' ORDER BY a.no desc";
$comment		= $DB->dfetcharr($sql." LIMIT $start , $limit");
$tot			= $DB->rows_count($sql);
$idx			= $tot-$rowslimit*($this_page-1);
$linkpage		= page($tot,$rowslimit,$pagelimit);

$prev			= $DB->get_prev_next_content($table01, $no, "prev");
$next			= $DB->get_prev_next_content($table01, $no, "next");

require_once $_SERVER['DOCUMENT_ROOT'].'/sns/facebook/config.php';
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl(FACEBOOK_APP_CALLBACK, $permissions);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<title>동트는 강원 : Tour</title>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- 마크업 전달 속성 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="../comn/css/style.css">

	<!--[if lt IE 9]>
	<script src="../comn/js/html5.js"></script>
	<script src="../comn/js/css3-mediaqueries.js"></script>
	<![endif]-->

	<script src="../comn/js/jquery-1.11.2.min.js"></script>
	<script src="../comn/js/jquery-ui.min.js"></script>
	<script src="../comn/js/common.js"></script><!-- 메인페이지엔 없어야함 -->
	<script>
		var f_url = '<?=$loginUrl?>';
		var k_url = "https://kauth.kakao.com/oauth/authorize?client_id=af8e288143026f0b074cf7d6bc2918b8&redirect_uri=<?=urlencode('http://rcorp.co.kr/sns/kakaotalk')?>&response_type=code";
	</script>
	<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
</head>
<body>
<?
if ($board_id=='writer' || $board_id=='contents' || $board_id=='news') {
	$user_skin		= "admin_gallery";
} else if ($board_id=='notice') {
	$user_skin		= "admin2";
} else {
	$user_skin		= "admin";
}
$board_skin		= $sh["rPath"]."/".BOARD_SKIN_PATH.$user_skin;

include_once($board_skin."/comment.php");
?>
