<?
$sh["rPath"]		= "..";
$board_id = "subscribe";
include_once($sh["rPath"]."/_common.php");
$DB					= new database;

$idx = isset($_POST['idx']) ? $_POST['idx'] : '';

if($idx == "") {
	echo '
		<script type="text/javascript">
		alert("잘못된 접근입니다.");
		window.location.href="/";
		</script>
	';
	exit;
}

$sql = "SELECT * FROM newsletter_req WHERE idx = ". $idx;
$row = $DB->fetcharr($sql);

include_once($sh["rPath"]."/_head.php");
?>


	<script type="text/javascript">
	$(document).ready(function(){
		$('.goMain').click(function(){
			window.location.href="/newsletter/newsletter_confirm01.php";
		});
	});
	</script>

	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="#">Community</a> &gt;
			<span>정기구독신청</span>
		</div>
	</div><!--//locationwrap -->


	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>정기구독신청</h2>

				<ul class="tabMenu">
					<li><a href="/newsletter/newsletter_apply01.php" class="on">정기구독신청</a></li>
					<li><a href="/newsletter/newsletter_confirm01.php">구독정보 확인 및 변경</a></li>
				</ul>

				<div class="stepBox">
					<ul>
						<li>
							<span class="icon step1"></span>
							<p>01 개인정보 동의</p>
							<span class="step_arrow">&gt;</span>
						</li>
						<li>
							<span class="icon step2"></span>
							<p>02 개인정보 입력</p>
							<span class="step_arrow">&gt;</span>
						</li>
						<li class="on">
							<span class="icon step3"></span>
							<p>03 완료</p>
						</li>
					</ul>
				</div>

				<div class="newsletter_fin">
					<div class="finTxt">
						<p><strong><?=$row['userNm'];?></strong> 고객님,</p>
						동트는강원 구독을 신청해 주셔서 감사합니다.<br>
						고객님께서 신청하신 구독정보는 다음과 같습니다.
					</div>
					<div class="finInfo">
						<dl>
						<?
							if($row['subscribeType'] == "online"){
						?>
							<dt>온라인(e-mail) 구독</dt>
							<dd>:&nbsp;&nbsp;<?=$row['email'];?></dd>
						<?
							}else if($row['subscribeType'] == "offline") {
						?>
							<dt>오프라인(우편물) 구독</dt>
							<dd>:&nbsp;&nbsp; <?=$row['addr1'] ." ". $row['addr2'];?></dd>
						<?
							}else if($row['subscribeType'] == "both") {
						?>
							<dt>온라인(e-mail) 구독</dt>
							<dd>:&nbsp;&nbsp;<?=$row['email'];?></dd>
							<dt>오프라인(우편물) 구독</dt>
							<dd>:&nbsp;&nbsp; <?=$row['addr1'] ." ". $row['addr2'];?></dd>
						<?
							}
						?>
							<dt>구독신청일</dt>
							<dd>:&nbsp;&nbsp; <?=$row['insertDttm'];?></dd>
						</dl>
					</div>
				</div>


				<div class="btnArea center">
					<a href="javascript:;" class="btnBig orange goMain">확인</a>
				</div><!-- //btnArea -->





			</div><!--// contents-->
		<!-- ============================ 내용종료 ============================ -->

		</div><!--// container -->
				<?
		include_once($sh["rPath"]."/_bottom.php");
		?>