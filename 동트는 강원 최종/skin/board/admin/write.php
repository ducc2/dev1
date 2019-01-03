<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 스킨별 CSS 시작 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->
<style type="text/css">


</style>
<!-- 스킨별 CSS 끝 ( 디자인 변경시 여기서 수정하시면 됩니다. ) -->


<?=$board_info[top_contents];// 설정된 상단내용 출력?>

<!-- 게시물 글쓰기 시작 -->
<div id="cont_right">
    <form id="fregisterform" name="fregisterform" action="./board_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="<?=$state?>">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="no" value="<?=$no?>">
    <input type="hidden" name="num" value="<?=$num?>">
    <input type="hidden" name="board_id" value="<?=$board_id?>">
    <input type="hidden" name="parent" value="<?=$no?>">
	<input type="hidden" name="updir" value="<?=$updir?>">
	<input type="hidden" name="reply" value="<?=$reply?>">
	<input type="hidden" name="file" value="<?=$file?>">
	<div class="form_div">
	<div class="location_title"><? if($board_id == 'contents') {echo '컨텐츠관리';}else if($board_id == 'writer') {echo '여행작가 게시물';}else if($board_id == 'notice') {echo '이벤트/공지';}else if($board_id == 'news') {echo '뉴스레터';}else{echo '게시 컨텐츠';} ?></div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="name">이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="name" name="name" value="<?=$name?>" required class="input_box"> 
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="password">비밀번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="password" id="password" name="password" value="<?=$password?>" required class="input_box"> 
            </td>
        </tr>  -->

		<?if($board_info[category]){?>
			<!-- 게시판 분류 시작 -->
			<tr>
				<th scope="row"><label for="category">분류</label></th>
				<td>
					<?
					$cate_tmp	= explode("|", $board_info[category]);
					for($i=0; $i < count($cate_tmp); $i++)	$cate_options	.= "<option value='".$cate_tmp[$i]."'>".$cate_tmp[$i]."</option>";
					?>
					<select name="category" id="category" class="selectbox">
						<option value="">선택</option>
						<?=$cate_options?>
					</select>
					<script type="text/javascript">
					document.getElementById("category").value = "<?=$category?>";
					</script>
				</td>
			</tr>
			<!-- 게시판 분류 끝 -->
		<?}?>


		
		<? if ($board_id=='contents') { ?>
		<tr>
            <th scope="row"><label for="email">호수 설정</label></th>
            <td>
			<select name="extra_2">
			<? for ($i=2016;$i<2026;$i++) { ?>
			<option value="<?=$i?>" <? if ($extra_2==$i) { ?>selected<? } ?>><?=$i?></option>
			<? } ?>
			</select>년

                <select name="extra_3">
			<? for ($i=1;$i<13;$i++) { ?>
			<option value="<?=$i?>" <? if ($extra_3==$i) { ?>selected<? } ?>><?=$i?></option>
			<? } ?>월 호
			</select>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="email">저작권</label></th>
            <td>
                <input type="radio" id="extra_1" name="extra_1" value="1" <? if ($extra_1==1) { ?>checked<? } ?>>강원도
				<input type="radio" id="extra_1" name="extra_1" value="2" <? if ($extra_1==2) { ?>checked<? } ?>>외부
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="homepage">해시테그</label></th>
            <td>
                <input type="text" id="extra_4" name="extra_4" value="<?=$extra_4?>" class="input_box400"> 
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="homepage">주소</label></th>
            <td>
                <input type="text" id="extra_4" name="extra_5" value="<?=$extra_5?>" class="input_box400"> 
            </td>
        </tr>
        <? } ?>
            <th scope="row"><label for="leader_bank_use">제목</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="subject" name="subject" value="<?=$subject?>" required class="input_box500"> 
            </td>
        </tr>

		<tr>
			<th scope="row"><label for="content">내용</label><span style="color: #FF3366;"> * </span></th>
			<td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="content" id="content" class="smarteditor2" style="width:99%;height:350px;"><?=$content?></TEXTAREA>
			</td>
		</tr>

        <!-- <tr>
            <th scope="row"><label for="link1">링크 1</label></th>
            <td>
                <input type="text" id="link1" name="link1" value="<?=$link1?>" class="input_box500"> 
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="link2">링크 2</label></th>
            <td>
                <input type="text" id="link2" name="link2" value="<?=$link2?>" class="input_box500"> 
            </td>
        </tr> -->
		<?// 권한 체크
		if($member[mem_level] >= $board_info[upload_grant]){?>
			<?for($i=0; $i<$board_info[upload_cnt]; $i++){?>
				<tr>
					<th scope="row"><label for="leader_bank_use"><?if($i==0) {echo "썸네일";}else{?>파일<?}?></label></th>
					<td>                
						<input type="file" name="upfiles[]" id="bottom_img" class="input_box"><p></p> 
						<?=$upload_del[$i]?>
					</td>
				</tr>
			<?}?>
		<?}?>
		<!--  게시판 추가 필드 시작 - 10개까지 사용가능  (주석 제거 후 변경해서 사용하시면 됩니다.)
		
        <tr>
            <th scope="row"><label for="extra_1"><?=$board_info[extra_subject_1]?></label></th>
            <td>
                <input type="text" id="extra_1" name="extra_1" value="<?=$extra_1?>" class="input_box100"> 
            </td>
        </tr>
		
        <tr>
            <th scope="row"><label for="extra_2"><?=$board_info[extra_subject_2]?></label></th>
            <td>
                <input type="text" id="extra_2" name="extra_2" value="<?=$extra_2?>" class="input_box100"> 
            </td>
        </tr>
		
        <tr>
            <th scope="row"><label for="extra_3"><?=$board_info[extra_subject_3]?></label></th>
            <td>
                <input type="text" id="extra_3" name="extra_3" value="<?=$extra_3?>" class="input_box100"> 
            </td>
        </tr>

			게시판 추가 필드 시작 (주석 제거 후 변경해서 사용하시면 됩니다.)
		-->
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">
        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
        <input type="submit" value="글등록" id="btn_submit" class="button">
    </div>
    </form>


	<?if($board_info[editer_use]=="2"){?>
		<!-- 스마트 에디터 자바스크립트 시작 -->
		<script type="text/javascript">
		var oEditors	= [];
		var rPath		= "<?=$sh["rPath"]?>"
		</script>	
		<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/smarteditor.js"></script>
		<!-- 스마트 에디터 자바스크립트 끝 -->

	<?}?>


    <script>
    // submit 폼체크
    function fregisterform_submit(f){

		<?if($board_info[editer_use]=="2"){?>
			// 에디터의 내용이 textarea에 적용된다.
			oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
		<?}?>
       
		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//} 

        return true;
    }
    </script>




</div>
<!-- 게시물 글쓰기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
