<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<!-- 배너 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./shop_<?=$include_file?>_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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
            <th scope="row"><label for="ban_name">배너명</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="ban_name" name="ban_name" value="<?=$ban_name?>" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 배너명을 적어주세요. 예) 가전</span>
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
        </tr>-->
        <tr>
            <th scope="row"><label for="sequence">진열순서</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="radio" id="sequence" name="sequence" value="1" <? if ($row['sequence']==1) { ?>checked<? } ?> >1&nbsp;<input type="radio" id="sequence" name="sequence" value="2" <? if ($row['sequence']==2) { ?>checked<? } ?> >2&nbsp;<input type="radio" id="sequence" name="sequence" value="3" <? if ($row['sequence']==3) { ?>checked<? } ?> >3&nbsp;<input type="radio" id="sequence" name="sequence" value="4" <? if ($row['sequence']==4) { ?>checked<? } ?> >4&nbsp;<input type="radio" id="sequence" name="sequence" value="5" <? if ($row['sequence']==5) { ?>checked<? } ?> >5
                <span class="frm_info"><?=$help_img?> 진열 순서를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_use">사용여부</label></th>
            <td>
				<span class="radiobox_span"><input type="radio" name="ban_use" id="ban_use" required value="1" <?=($ban_use=="1")?"checked":"";?>> 사용안함</span>
				<span class="radiobox_span"><input type="radio" name="ban_use" id="ban_use" required value="2" <?=($ban_use=="2")?"checked":"";?>> 사용</span>
                <span class="frm_info"><?=$help_img?> 사용여부를 선택해 주세요.</span>
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
            <th scope="row"><label for="ban_img">이미지</label></th>
            <td>
				<?=$ban_img_tmp?>
				<input type="file" name="upfiles[]" id="ban_img" class="input_box"> <?=$ban_img_del?>
                <span class="frm_info"><?=$help_img?> 이미지를 선택해 주세요.</span><span class="text_emphasis2n">(용량 100 kb이하, jpg, gif, png 확장자만 등록 )</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_img_link">카테고리</label><span style="color: #FF3366;"> * </span></th>
            <td>
               <select name="ban_category" id="ban_category" class="selectbox">
						<option value="">선택</option>
						<option value='Tour' <? if ($row['ban_category']=='Tour') { ?>selected<? } ?>>Tour</option><option value='Food' <? if ($row['ban_category']=='Food') { ?>selected<? } ?>>Food</option><option value='Culture' <? if ($row['ban_category']=='Culture') { ?>selected<? } ?>>Culture</option><option value='Economy' <? if ($row['ban_category']=='Economy') { ?>selected<? } ?>>Economy</option><option value='Etc' <? if ($row['ban_category']=='Etc') { ?>selected<? } ?>>Etc</option>					</select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_img_link">링크URL</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="ban_img_link" name="ban_img_link" value="<?=$ban_img_link?>" class="input_box400"><p></p> 
                <span class="frm_info"><?=$help_img?> 이미지 링크 주소를 입력해 주세요. 예) http://www.mysite.com/</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_link_type">내용</label></th>
            <td>
                <TEXTAREA name="ban_text" id="ban_text" class="smarteditor2" style="width:100%;height:350px;"><?=$row['ban_text']?></TEXTAREA>
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
		oEditors.getById["ban_text"].exec("UPDATE_CONTENTS_FIELD", []);

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