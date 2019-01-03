<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">

.form_div {width:360px; margin: 0 auto;padding-top:20px;}
.input_row {width:100%; padding-bottom: 20px; text-align:center;}
.input_box { width: 360px; height:40px; padding: 2px 0 0 2px; line-height: 17px; }
.error{color:#ff0000; margin:0 0 0 0px; padding:0 0 0 0px;}
.button_login{width:364px; height:40px; margin:0 0 0 0px; padding:2px 0 0 2px; border:1px solid #999; background: url(../images/common/btn_bg.gif) repeat-x 0px 0px; font-size: 12px; font-weight:bold; color:#000; vertical-align:bottom; cursor:pointer;  }
.person-tb {width:100%;}
.person-tb caption {padding: 10px 0; font-weight: bold; text-align: left;}
#btn_confirm  {width:100%; height:70px;text-align:center; padding-top:30px;}

</style>
<!-- 스킨별 CSS 끝 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->



<!-- 게시판 비밀번호 체크 시작  -->
<div class="form_div">
	<ul>
		<li class="location_title">PASSWORD CHECK</li><P><P>
	</ul>

    <form name="flogin" action="./password_check_proc.php" onsubmit="return form_submit(this);" method="post">
	<input type="hidden" name="board_id" value="<?=$board_id?>">
	<input type="hidden" name="no" value="<?=$no?>">
	<input type="hidden" name="sch_key" value="<?=$sch_key?>">
	<input type="hidden" name="sch_text" value="<?=$sch_text?>">
	<input type="hidden" name="cate" value="<?=$cate?>">
	<input type="hidden" name="this_page" value="<?=$this_page?>">
	<input type="hidden" name="smode" value="<?=$smode?>">

    <fieldset id="login">

		<div class="input_row_pw">
			<span><label for="password"><?=$sh_title?> 게시물 비밀번호 확인</label></span><P>
			<span><input type="password" name="password" id="password" class="input_box" size="20" maxLength="30" placeholder="비밀번호" required ></span><P>
			<?if($smode=="delete"){?>
				<span class="frm_info"><?=$help_img2?><br> 작성자라면 비밀번호를 입력하세요.<br> 작성자와 관리자만 삭제 가능합니다.<br></span>
			<?}else{?>
				<span class="frm_info"><?=$help_img2?><br> 비밀 게시물입니다. 작성자라면 비밀번호를 입력하세요.<br> 작성자와 관리자만 열람하실 수 있습니다.<br></span>
			<?}?>
		</div>
		

		<div class="input_row">
			<input type="submit" class="button_login" value=" 확 인 ">
		</div>
    </fieldset>
    </form>

</div>

<script>
function form_submit(f){
	if(!f.password.value){
		alert("비밀번호를 입력해 주세요.");
		return false;
	}
    return true;
}
</script>



<!-- 게시판 비밀번호 체크 끝 -->