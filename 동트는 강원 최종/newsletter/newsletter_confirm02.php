<?
$sh["rPath"]="..";
$board_id = "subscribe";
include_once($sh["rPath"]."/_common.php");

include_once($sh["rPath"]."/_head.php");

$idx = isset($_POST['idx']) ? $_POST['idx'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

//print_r($_POST);

if ($_POST['pemail']) {

$sql = "SELECT * FROM newsletter_req WHERE userNm = '".$_POST['pname']."' and email = '".$_POST['pemail']."' and cancelYn='N'";
$row			= $DB->dfetcharr($sql);
} else {

	$phonee = $_POST['pphone1']."-".$_POST['pphone2']."-".$_POST['pphone3'];

$sql = "SELECT * FROM newsletter_req WHERE userNm = '".$_POST['pname']."' and tel = '".$phonee."' and cancelYn='N'";
$row			= $DB->dfetcharr($sql);
}

?>



	<script type="text/javascript">

	function goEdit(idx) { 
			$('#idx').val(idx);
			$('#viewForm').find('#mode').val('modify');
			$('#viewForm').attr('action','/newsletter/newsletter_confirm03.php');
			$('#viewForm').submit();
		}
	
	function godel(idx) {

		if(confirm("정말로 해지하시겠습니까?")) { 
				$('#idx').val(idx);
				$('#viewForm').find('#mode').val('cancel');
				$('#viewForm').attr('action','/newsletter/newsletterSave.php');
				$('#viewForm').submit();
		}


	}

	$(document).ready(function(){
		$('.goMain').click(function(){
			window.location.href="/newsletter/newsletter_confirm01.php";
		});

		

	});
	</script>

<form name="viewForm" id="viewForm" method="post">
<input type="hidden" name="mode" id="mode" />
<input type="hidden" name="idx" id="idx" value=""/>
</form>


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
					<li><a href="/newsletter/newsletter_apply01.php">정기구독신청</a></li>
					<li><a href="/newsletter/newsletter_confirm01.php" class="on">구독정보 확인 및 변경</a></li>
				</ul>


				<div class="newsletter_fin">
					<div class="finTxt">
						<p><strong><?=$_POST['pname'];?></strong> 고객님,</p>
						고객님의 구독정보는 다음과 같습니다.
					</div>
						<?for($i=0;$i<sizeof($row);$i++){
						
						$rows					= $row[$i];
						?>
					<div class="finInfo">
						<dl>
						<?
							if($rows['subscribeType'] == "online"){
						?>
							<dt>온라인(e-mail) 구독</dt>
							<dd>:&nbsp;&nbsp;<?=$rows['email'];?></dd>
						<?
							}else if($rows['subscribeType'] == "offline") {
						?>
							<dt>오프라인(우편물) 구독</dt>
							<dd>:[<?=$rows['zipcode'];?>]&nbsp;&nbsp; <?=$rows['addr1'] ." ". $rows['addr2'];?></dd>
						<?
							}else if($rows['subscribeType'] == "both") {
						?>
							<dt>온라인(e-mail) 구독</dt>
							<dd>:&nbsp;&nbsp;<?=$rows['email'];?></dd>
							<dt>오프라인(우편물) 구독</dt>
							<dd>:&nbsp;&nbsp; <?=$rows['addr1'] ." ". $rows['addr2'];?></dd>
						<?
							}
						?>
							<dt>구독신청일</dt>
							<dd>:&nbsp;&nbsp; <?=$rows['insertDttm'];?></dd>
							<!--
							<dt>온라인(e-mail) 구독</dt>
							<dd>:&nbsp;&nbsp; plz2you@naver.com</dd>
							<dt>오프라인(우편물) 구독</dt>
							<dd>:&nbsp;&nbsp; 강원도 춘천시 강원대학길1 보듬관 805호</dd>
							<dt>구독신청일</dt>
							<dd>:&nbsp;&nbsp; 2016-01-01 14:22</dd>
							-->
						</dl>
					</div>
					<div class="btnArea center">
					<a href="#none" onclick="goEdit('<?=$rows['idx']?>')" class="btnBig">구독 정보변경</a>
					<a href="#none" onclick="godel('<?=$rows['idx']?>')" class="btnBig">구독해지</a>
					<a href="javascript:;" class="btnBig orange goMain">확인</a>
					</div>
					<? } ?>
				</div>


				<!-- //btnArea -->


			</div><!--// contents-->
		<!-- ============================ 내용종료 ============================ -->

		</div><!--// container -->
				<?
		include_once($sh["rPath"]."/_bottom.php");
		?>