<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<?
if (!$no) {
$yy = date("Y");
} else {
$yy	= $row['ban_yy'];
}
?>
<!-- 배너 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./<?=$include_file?>_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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
            <th scope="row"><label for="ban_name">제목</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="ban_name" name="ban_name" value="<?=$row[ban_name]?>" required class="input_box400"> 
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_use">연도</label></th>
            <td>
			<select name="ban_yy" id="ban_yy" class="selectbox" style="width:140px;" >
			<? for($a=1996;$a<date("Y")+1;$a++) { ?>
				<option value="<?=$a?>" <? if ($a==$yy) { echo "selected"; }?>><?=$a?></option>
			<? } ?>
			</select>
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="ban_width">배너크기</label></th>
            <td>
                <input type="text" id="ban_width" name="ban_width" value="<?=$ban_width?>" required class="input_box_num_small"> px <label for="ban_width">가로</label> ,   
                <input type="text" id="ban_height" name="ban_height" value="<?=$ban_height?>" required class="input_box_num_small"> px <label for="ban_height">세로</label>  
                <span class="frm_info"><?=$help_img?> 배너 가로, 세로 크기를 입력해 주세요. 예) 275 X 200 정수로 입력해 주세요.</span>
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="ban_img">파일</label></th>
            <td>
				<?=$ban_img_tmp?>
				<input type="file" name="upfiles[]" id="ban_img" class="input_box"> <?=$ban_img_del?>
                <span class="frm_info"><?=$help_img?> PDF만 업로드 가능합니다.</span>
            </td>
        </tr>
		
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">

        <?if ($_GET['idx']) { ?>
        <input type="submit" value="수정하기" id="btn_submit" class="button">
		<? }else { ?>
        <input type="submit" value="등록하기" id="btn_submit" class="button">
		<? } ?>
		        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
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
		//oEditors.getById["ban_text"].exec("UPDATE_CONTENTS_FIELD", []);

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