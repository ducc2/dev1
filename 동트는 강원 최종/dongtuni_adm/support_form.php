<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 배너 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./support_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="<?=$state?>">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="no" value="<?=$no?>">
	<input type="hidden" name="updir" value="<?=$updir?>">
	<?=$upfile_field?>
	<?=$uploadfile_old?>
	<div class="form_div">
		<div class="location_title"><?=$sh_title?></div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="ban_name">이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="name" name="name" value="<?=$name?>" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 이름명을 적어주세요.</span>
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="position">노출위치</label></th>
            <td>
                <select name="position" id="position" required class="selectbox">
					<option value="">선택</option>
					<option value="main_visual" <?=($position=="main_visual")?"selected":"";?>>main_visual</option>
					<option value="main_bottom" <?=($position=="main_bottom")?"selected":"";?>>main_bottom</option>
                </select>
                <span class="frm_info"><?=$help_img?> 노출 위치를 선택해 주세요. 보기 : main_visual, main_bottom, login</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="sequence">진열순서</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="sequence" name="sequence" value="<?=$sequence?>" required class="input_box_num_small"> 
                <span class="frm_info"><?=$help_img?> 진열 순서를 선택해 주세요. 예) 1 ~ 9 숫자가 적은 순으로 진열됩니다.</span>
            </td>
        </tr> -->
        
        <tr>
            <th scope="row"><label for="ban_img_link">전화번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="phone" name="phone" value="<?=$phone?>" class="input_box400">
                <span class="frm_info"><?=$help_img?> 010-2222-1111</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_link_type">메모</label></th>
            <td>
                <TEXTAREA name="content" id="content" class="smarteditor2" style="width:100%;height:350px;"><?=$row['content']?></TEXTAREA>
            </td>
        </tr>

		
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">
        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
        <input type="submit" value="정보저장" id="btn_submit" class="button">
    </div>
    </form>

  <script type="text/javascript">
	var oEditors	= [];
	var rPath		= "<?=$sh["rPath"]?>"
	</script>	
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/smarteditor.js"></script>
	<!-- 스마트 에디터 자바스크립트 끝 -->

    <script>
    // submit 폼체크
    function fregisterform_submit(f){
       
		// 에디터의 내용이 textarea에 적용된다.
		oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);

		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//}    

        return true;
    }
    </script>

</div>
<!-- 배너 관리 끝 -->