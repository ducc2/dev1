<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 게시판 복사  관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="<?=$include_file?>_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="<?=$state?>">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="no" value="<?=$no?>">
	<input type="hidden" name="updir" value="<?=$updir?>">
	<?=$upfile_field?>
	<div class="form_div">
		<div class="location_title"><?=$sh_title?></div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="original_ename">원본 게시판 영문이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
				<?=$ename?>
                <input type="hidden" id="original_ename" name="original_ename" value="<?=$ename?>"> 
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ename">복사 게시판 영문이름</label></th>
            <td>
                <input type="text" id="ename" name="ename" value="copy_<?=$ename?>" class="input_box300"> <p></p> 
                <span class="frm_info"><?=$help_img?> 게시판 영문 이름은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내) 예) event, gallery</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="name">복사 게시판 이름</label></th>
            <td>
                <input type="text" id="name" name="name" value="copy_<?=$name?>" class="input_box300">  
                <span class="frm_info"><?=$help_img?> 게시판 이름 적어주세요. 예) 이벤트, 갤러리</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="copy_type">복사 형태</label></th>
            <td>
				<input type="radio" name="copy_type" id="copy_type" value="1" <?=($copy_type=="1")?"checked":"";?> checked> 구조만
				<input type="radio" name="copy_type" id="copy_type" value="2" <?=($copy_type=="2")?"checked":"";?>> 구조와 데이터
                <span class="frm_info"><?=$help_img?> 복사 형태를 선택해 주세요.</span>
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

    <script>
    // submit 폼체크
    function fregisterform_submit(f){
       

		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//}    

        return true;
    }
    </script>

</div>
<!-- 게시판 복사  관리 끝 -->