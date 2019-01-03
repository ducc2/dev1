<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 배너 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./adminID_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="<?=$state?>">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="mem_no" value="<?=$mem_no?>">
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
            <th scope="row"><label for="mem_id">ID</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="mem_id" name="mem_id" value="<?=$mem_id?>" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> ID를 적어주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mem_password">비밀번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="mem_password" name="mem_password" value="" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 비밀번호를 적어주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mem_name">이름</label></th>
            <td>
                <input type="text" id="mem_name" name="mem_name" value="<?=$mem_name?>" class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 이름을 적어주세요.</span>
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