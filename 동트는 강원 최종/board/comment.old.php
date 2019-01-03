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
		var k_url = "https://kauth.kakao.com/oauth/authorize?client_id=c6931b8908de2e0768fff383b251a5f5&redirect_uri=<?=urlencode('http://rcorp.co.kr/sns/kakaotalk')?>&response_type=code";
	</script>
	<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
</head>
<body>


<!-- 댓글 쓰기 시작 -->

<BODY STYLE="background-color:transparent">
<!-- comment-->
<form id="fregisterform" name="fregisterform" action="./board_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" target="ifm_proc">
    <input type="hidden" name="state" value="comment">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="board_id" value="<?=$board_id?>">
    <input type="hidden" name="board_no" value="<?=$no?>">
    <input type="hidden" name="cur_comment" value="<?=$cur_comment?>">
			<div class="comment">
				<fieldset class="write clearfix">

					<?php
					if(!isset($_SESSION['SNS_LOGIN']['name']) || !$_SESSION['SNS_LOGIN']['name']){
						?>
					<!-- 로그인 하기전 -->
					<div class="login_inner clearfix">
						<input type="text" name="name" placeholder="이름"><input type="password" placeholder="비밀번호" name="password">
						<div class="sns_login">
							<div class="alert_sns">소셜로그인 하시면 편리하게 댓글을 쓰실 수 있습니다.<span class="triangle"></span></div>
							<a href="#" class="sns_f">페이스북</a>
							<a href="#" class="sns_t">트위터</a>
							<a href="#" class="sns_k">카카오톡</a>
						</div><!--//sns_login -->
					</div><!--//로그인 하기전 -->
					<?php
						}else{
							if($_SESSION['SNS_LOGIN']['sns'] == 'FACEBOOK') $add_class = 'sns_f';
							else if($_SESSION['SNS_LOGIN']['sns'] == 'TWITTER') $add_class = 'sns_t';
							else if($_SESSION['SNS_LOGIN']['sns'] == 'KAKAOTALK') $add_class = 'sns_k';
					?>
					<!-- 로그인 하면 -->
					<div class="login_inner">
					<input type="hidden" name="name" value="<?=$_SESSION['SNS_LOGIN']['name']?>">
					<input type="hidden" name="sns" value="<?=$_SESSION['SNS_LOGIN']['sns']?>">
						<!--
						이름,비밀번호 넣었을경우 : <span class="icon_set sns_c"></span>
						-->
						<span class="icon_set <?=$add_class?>"></span> <span class="name"><?=$_SESSION['SNS_LOGIN']['name']?></span>
						<a href="#" class="sns_off" style="display:block; float:right;">SNS 로그아웃</a>
					</div><!--//로그인 하면 -->
					<?php } ?>


					<textarea id="inquiryText" placeholder="내용을 입력하세요" name="content"></textarea>
					<a href="#none" onclick="document.fregisterform.submit();" title="등록"class="btn_write">등록</a>
				</fieldset>
</form>


<form id="fregisterlist" name="fregisterlist" action="./comment_proc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="state" value="comment_edit">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="board_id" value="<?=$board_id?>">
    <input type="hidden" name="board_no" value="<?=$no?>">
    <input type="hidden" name="cur_comment" >
				<div class="comment_list">
					<p>총 <span class="comment_num"><?=$tot?>개</span>의 댓글이 있습니다.</p>
					<ul>
		<!-- 리스트 루프 시작 -->
		<?
		for($i=0;$i<sizeof($comment);$i++){
			$comments			= $comment[$i];
			$comments[idx]		= $idx;
			$bg				= 'bg'.($i%2);

							if($comments['sns'] == 'FACEBOOK') $add_class_list = 'icon_set sns_f';
							else if($comments['sns'] == 'TWITTER') $add_class_list = 'icon_set sns_t';
							else if($comments['sns'] == 'KAKAOTALK') $add_class_list = 'icon_set sns_k';
							else $add_class_list = 'icon_set sns_c';

			?>
			<!--수정용 폼 -->
						<fieldset class="write clearfix" style="display:none" id="con_<?=$comments[no]?>">
								<!-- 로그인 하기전 -->
								<div class="login_inner clearfix">
									<input type=hidden name=sns_array[<?=$comments[no]?>] value="<?=$comments['sns']?>">
									<input type="text" name="name_array[<?=$comments[no]?>]" placeholder="이름" value="<?=$comments[name]?>" readonly>
									<? if(!$comments['sns']) { ?>
									<input type="password" placeholder="비밀번호" name="password_array[<?=$comments[no]?>]" >
									<? } ?>
								</div><!--//로그인 하기전 -->

								<!-- 로그인 하면 -->
								<div class="login_inner" style="display:none;">
									<!--
									이름,비밀번호 넣었을경우 : <span class="icon_set sns_c"></span>
									페이스북 로그인했을경우 : <span class="icon_set sns_f"></span>
									트위터 로그인했을경우 : <span class="icon_set sns_t"></span>
									카카오톡 로그인했을경우 : <span class="icon_set sns_k"></span>
									-->
									<span class="icon_set sns_f"></span> <span class="name">홍길동</span>
								</div><!--//로그인 하면 -->

								<textarea id="inquiryText" placeholder="내용을 입력하세요" name="content_array[<?=$comments[no]?>]"><?=nl2br($comments[content])?></textarea>
								<a href="#none" onclick="editok('<?=$comments[no]?>');" title="등록"class="btn_write">등록</a>
						</fieldset>

						<li>
							<span class="<?=$add_class_list?>"></span>
							<!--
							이름,비밀번호 넣었을경우 : <span class="icon_set sns_c"></span>
							페이스북 로그인했을경우 : <span class="icon_set sns_f"></span>
							트위터 로그인했을경우 : <span class="icon_set sns_t"></span>
							카카오톡 로그인했을경우 : <span class="icon_set sns_k"></span>
							-->
							<div class="comment_view">
								<span class="name"><?=$comments[name]?></span>
								<span class="date"><?=substr($comments[datetime], 0, 16)?></span>
								<span class="txt"><?=nl2br($comments[content])?></span>
								<p class="editBtn">
									<!--<a href="#none" onclick="editcon('<?=$comments[no]?>')" class="btnSmall">수정</a>-->
									<? if ($_SESSION['SNS_LOGIN']['name']==$comments['name']) { ?>
									<a href="./comment_del.php?board_id=<?=$board_id?>&cno=<?=$comments[no]?>&no=<?=$no?>&name=<?=$comments[name]?>" class="btnSmall">삭제</a>
									<? } else {?>
									<a href="#none" onclick="delcon('<?=$comments[no]?>','<?=$comments['sns']?>')" class="btnSmall">삭제</a>
									<? } ?>
								</p>
							</div>
						</li>


<? } ?>
					</ul>
					<div class="paging">
						<?=$linkpage?>
					</div>
				</div>
				</form>
			</div><!-- //comment-->

<iframe name="ifm_proc" id="ifm_proc" src="" frameborder="0" scrolling="no" style="display:none;"></iframe>



    <script>
    // submit 폼체크
    function fregisterform_submit(f){
		if (f.name.value.length < 1) {
			alert("이름을 입력해 주세요.");
			f.name.focus();
			return false;
		}

		var form		= document.getElementById("fregisterform");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();

        return true;
    }

	function delcon(nn,snser) {
		window.open('board_pass.html?mode=comment_delete&no='+nn+'&sns='+snser, 'twitter', 'width=400, height=270');
	}

	function editcon(nn) {
		$("#con_"+nn).toggle();
	}

	function editok(nn) {
		document.fregisterlist.cur_comment.value=nn;
		document.fregisterlist.submit();
	}
    </script>

<!-- 댓글 쓰기 끝