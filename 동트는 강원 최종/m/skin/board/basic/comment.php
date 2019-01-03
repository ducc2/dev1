<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



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
							<div class="alert_sns">소셜로그인<span class="triangle"></span></div>
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
						<!--
						이름,비밀번호 넣었을경우 : <span class="icon_set sns_c"></span>
						-->
						<span class="icon_set <?=$add_class?>"></span> <span class="name"><?=$_SESSION['SNS_LOGIN']['name']?></span> <input type="password" placeholder="비밀번호" name="password" style="float:none; vertical-align:top; margin-top:6px;">
						<a href="#" class="sns_off" style="display:block; float:right;">로그아웃</a>
					</div><!--//로그인 하면 -->
					<?php } ?>

					<textarea id="inquiryText" placeholder="내용을 입력하세요" name="content"></textarea>
					<a href="#none" onclick="document.fregisterform.submit();" title="등록"class="btn_write">등록</a>
				</fieldset>
</form>



				<div class="comment_list">
					<p>총 <span class="comment_num"><?=$tot?>개</span>의 댓글이 있습니다.</p>
					<ul>
		<!-- 리스트 루프 시작 -->
		<?
		for($i=0;$i<sizeof($comment);$i++){
			$comments			= $comment[$i];
			$comments[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			?>
						<li>
							<span class="icon_set sns_c"></span>
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
									<!--<a href="#none" class="btnSmall">수정</a>-->
									<a href="#none" onclick="delcon('<?=$comments[no]?>')" class="btnSmall">삭제</a>

									<!-- <a href="#none" class="btnSmall">수정</a>
									<a href="#none" class="btnSmall">삭제</a> -->
								</p>
							</div>
						</li>
<? } ?>
					</ul>
					<div class="paging">
						<?=$linkpage?>
					</div>
				</div>
			</div><!-- //comment-->

	<!-- <div id="comment_list">

		<table class="board_list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<thead>
		<tr>
			<th scope="col">이름</th>
			<th scope="col">내용</th>
			<th scope="col">등록일</th>
		</tr>
		</thead>
		<tbody>

		<!-- 리스트 루프 시작
		<?
		for($i=0;$i<sizeof($comment);$i++){
			$comments			= $comment[$i];
			$comments[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			?>

		<tr class="<?=$bg?>">
			<td class="td_small"><?=$comments[name]?></td>
			<td class="td_large80"><div class="comment_content"><?=nl2br($comments[content])?></div></td>
			<td class="td_middle_"><?=substr($comments[datetime], 0, 16)?></td>
		</tr>
		<?
			$idx--;
		}?>
		<!-- 리스트 루프 끝

		</tbody>
		</table>
		<div class="list_bottom_center">
			<nav class="pg_wrap"><span class="pg"><?=$linkpage?></span></nav>
		</div>
	</div> -->


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

	function delcon(nn) {
		window.open('board_pass.html?mode=comment_delete&no='+nn, 'twitter', 'width=400, height=270');
	}

	function editcon(nn) {
		window.open('board_pass.html?mode=comment_update&no='+nn, 'twitter', 'width=400, height=270');
	}
    </script>

<!-- 댓글 쓰기 끝
			<div class="prevNext">
				<ul>
					<?if($prev){
				$prow			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$prev."'");
				?>
					<li><span class="prev"><span class="icon"></span>이전글</span> <a href="<?=$PHP_SELF?>?no=<?=$prev?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>"><?=$prow[subject]?></a></li>

				<? } ?>

				<?if($next){
				$nrow			= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$next."'");
				?>
					<li><span class="next"><span class="icon"></span>다음글</span> <a href="<?=$PHP_SELF?>?no=<?=$next?>&board_id=<?=$board_id?>&sch_key=<?=$sch_key?>&sch_text=<?=$sch_text?>&cate=<?=$cate?>"><?=$nrow[subject]?></a></li>
				<? } ?>
				</ul>
			</div> --><!-- //prevNext -->



		<!-- ============================ 내용종료 ============================ -->