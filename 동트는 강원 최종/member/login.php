<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
$DB	= new database;

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($_SESSION["mem_id_session"]) {
    goto_url($sh["rPath"]."/member/member_confirm.php");
}
if($_GET[referer]){
	$referer		= base64_decode($_GET[referer]);
}else{
	$referer		= prevpage();
}
$sh["title"]	= $sh["stie_title"]."-로그인";
//include_once($sh["rPath"]."/_head.php");

?>
<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">
/* HTML Reset --------------------------------------------------------------------------------------- */
html, body, div, ul, ol, li, dl, dt, dd, h1, h2, h3, h4, h5, h6, pre, form, p, blockquote, fieldset, input, 
abbr, article, aside, command, details, figcaption, figure, footer, header, hgroup, mark, meter, nav, 
output, progress, section, summary, time, table, th, td {margin: 0;padding: 0;font-size: 13px;font-family: 'Nanum Gothic', sans-serif;line-height:1.5em;color:#3c3c3d;-webkit-text-size-adjust:none;}
body {min-width:320px;}
table {border-collapse: collapse;border-spacing: 0;}
img {border:0;vertical-align:middle;}
a {color: #333;text-decoration: none;}
a:link, a:visited, a:active {text-decoration: none;}
a:hover {text-decoration: none;}
nav, ul {list-style: none outside none;}
hr{display:none}
form {margin:0;padding:0;border:none;}
fieldset {margin:0;padding:0;border:none;}
caption {position:absolute;top:0;left:-1000em;width:0;height:0;line-height:0; display:none;}
legend {position:absolute;top:0;left:-1000em;width:0;height:0;line-height:0; display:none;}

input {vertical-align:middle; border:none; font-size:12px;}
input.radio { width:13px; height:13px; vertical-align:middle}
select {vertical-align:middle; font-size:12px; border:1px solid #b6b6b6; padding:4px 10px;}
textarea {border-color: #b6b6b6 #ddd #ddd #b6b6b6; border-style: solid; border-width: 1px; background-color:#fff; font-size:12px;}
input[type=text] {border:1px solid #b6b6b6; background-color:#fff; padding:2px; height:20px;}
input[type=password] {border:1px solid #b6b6b6; background-color:#fff; padding:2px; height:20px;}
input.none {border:none !important; border-color:#fff; padding:2px;}
input.bg {background:#f2f8ff;}

/*로그인*/
body {background:#efefef;}
.loginBox {width:350px; margin:150px auto 0; padding:50px 50px 0; border:3px solid #222; background:#fff url('/comn/img/login_bg.png') no-repeat 340px 60px;}
.loginBox h1 {font-size:18px; color:#5e4b34; margin-bottom:20px;}
.loginBox h1 img {margin-bottom:10px;}
.loginBox p {margin-bottom:7px; line-height:18px;}
.loginBox .loginForm {position:relative; background:#fdfaf3; padding:20px 50px; margin: 10px -50px;}
.loginBox .loginForm ul li {padding:2px 0;}
.loginBox .loginForm ul li span {display:inline-block; width:70px; text-align:right; margin-right:10px;}
.loginBtn {position:absolute; right:80px; top:20px; background:#cc3a3a; color:#fff; padding:0 15px; line-height:58px; height:58px;}
.linkBtn {display:inline-block; padding-left:12px; background:url('../img/link_icon.png') no-repeat 0 5px;}
.loginBox .auto {display:block; border-top:1px dotted #ddd; margin-top:10px; padding-top:10px; padding-left:25px;}

</style>
<!-- 스킨별 CSS 끝 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->

<!-- 로그인 -->
<div class="loginBox">
	<h1>
		<img src="/comn/img/logo.png" alt="동트는강원"><br>
		홈페이지 관리자 로그인
	</h1>
	<p><strong>동트는강원의 홈페이지 관리자 화면입니다.</strong></p>
	<p>관리자 아이디/비밀번호를 입력해주십시오.</p>

    <form name="flogin" action="./login_proc.php" onsubmit="return flogin_submit(this);" method="post">
	<input type="hidden" name="referer" value="<?=$referer?>">
	<input type="hidden" name="cartnos" value="<?=$cartnos?>">

	<fieldset>
	<legend>로그인</legend>

	<div class="loginForm">
		<ul>
			<li><span>아이디</span><input type="text" name="mem_id" id="mem_id" maxLength="30" placeholder="아이디" required ></li>
			<li><span>비밀번호</span><input type="password" name="mem_password" id="mem_password" size="20" maxLength="30" placeholder="비밀번호" required ></li>
		</ul>
		<p class="auto"><input type="checkbox" name="auto_login" id="auto_login"> <label for="auto_login">로그인 상태 유지</label></p>
		<input type="submit" class="loginBtn" value="로그인">
	</div>

	</fieldset>
	</form>

</div>
<!-- //로그인 -->



<script>
$(function(){
    $("#auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("로그인 상태 유지를 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function geust_order(){
	document.location.href	= "<?=$sh['rPath']?>/shop/goods_order.php?cartnos=<?=$cartnos?>&guest_order=true";

}

function flogin_submit(f){
	if(!f.mem_id.value){
		alert("아이디를 입력해 주세요.");
		return false;
	}
	if(!f.mem_password.value){
		alert("비밀번호를 입력해 주세요.");
		return false;
	}
    return true;
}
</script>
<!-- 로그인 끝 -->
<?

// 현재 스킨
$current_skin	= $member_skin."/login.php";

//include_once($sh["rPath"]."/_bottom2.php");
?>
