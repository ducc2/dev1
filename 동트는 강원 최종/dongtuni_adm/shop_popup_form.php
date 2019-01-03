<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
	//******************************************************************************
	// 상세검색 달력 스크립트
	//******************************************************************************
	var clareCalendar = {
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd', //형식(20120303)
		autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
		changeMonth: true, //월변경가능
		changeYear: true, //년변경가능
		showMonthAfterYear: true, //년 뒤에 월 표시
		buttonImageOnly: true, //이미지표시
		buttonText: '달력선택', //버튼 텍스트 표시
		buttonImage: './images/icon_carender.gif', //이미지주소
		showOn: "both", //엘리먼트와 이미지 동시 사용(both,button)
		yearRange: '1990:2020' //1990년부터 2020년까지
	};
	$("#pop_sdate").datepicker(clareCalendar);
	$("#pop_edate").datepicker(clareCalendar);

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:middle; cursor:pointer;"); //이미지버튼 style적용
	$("#ui-datepicker-div").hide(); //자동으로 생성되는 div객체 숨김  
});
</script>

<!-- 팝업 관리 시작  -->
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
            <th scope="row"><label for="pop_name">팝업명</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="pop_name" name="pop_name" value="<?=$pop_name?>" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 팝업명을 적어주세요. 예) 가전</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_sdate">노출기간</label></th>
            <td>
                <input type="text" id="pop_sdate" name="pop_sdate" value="<?=$pop_sdate?>" required class="input_box"> ~    
                <input type="text" id="pop_edate" name="pop_edate" value="<?=$pop_edate?>" required class="input_box">  
                <span class="frm_info"><?=$help_img?> 팝업 노출 시작일과 종료일을 선택해 주세요. 예) 2015-01-01</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_use">사용여부</label></th>
            <td>
				<span class="radiobox_span"><input type="radio" name="pop_use" id="pop_use" value="1" <?=($pop_use=="1")?"checked":"";?>> 사용안함</span>
				<span class="radiobox_span"><input type="radio" name="pop_use" id="pop_use" value="2" <?=($pop_use=="2")?"checked":"";?>> 사용</span>
                <span class="frm_info"><?=$help_img?> 사용여부를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_use">사용여부</label></th>
            <td>
				<span class="radiobox_span"><input type="radio" name="pop_type" id="pop_type" value="1" <?=($pop_type=="1")?"checked":"";?>> 일반팝업</span>
				<span class="radiobox_span"><input type="radio" name="pop_type" id="pop_type" value="2" <?=($pop_type=="2")?"checked":"";?>> 상단팝업</span><p></p>
                <span class="frm_info"><?=$help_img?><br>
				- 일반팝업 : 레이어형, 상단팝업 : 상단에 가로형.<br>
				- 상단 팝업은 팝업크기, 팝업위치 값과 상관없이 사이트 상단에 고정 노출됩니다.<br>
				</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_width">팝업크기</label></th>
            <td>
                <input type="text" id="pop_width" name="pop_width" value="<?=$pop_width?>" required class="input_box_num_small"> px <label for="pop_width">가로</label> ,   
                <input type="text" id="pop_height" name="pop_height" value="<?=$pop_height?>" required class="input_box_num_small"> px <label for="pop_height">세로</label>  
                <span class="frm_info"><?=$help_img?> 팝업 가로, 세로 크기를 입력해 주세요. 예) 400 X 500 정수로 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_left">팝업위치</label></th>
            <td>
                <input type="text" id="pop_left" name="pop_left" value="<?=$pop_left?>" required class="input_box_num_small"> px <label for="pop_left">가로</label> ,   
                <input type="text" id="pop_top" name="pop_top" value="<?=$pop_top?>" required class="input_box_num_small"> px <label for="pop_top">세로</label>  
                <span class="frm_info"><?=$help_img?> 팝업 가로, 세로 위치를 입력해 주세요. 예) 100 X 200 정수로 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_img">이미지</label></th>
            <td>
				<?=$pop_img_tmp?>
				<input type="file" name="upfiles[]" id="pop_img" class="input_box"> <?=$pop_img_del?><p></p>
                <span class="frm_info"><?=$help_img?><br>
				- 이미지를 선택해 주세요.<span class="text_emphasis2n">( jpg, gif, png 확장자만 등록 )</span><br>
				- 상단팝업용 이미지는 <span class="text_emphasis2n">가로 사이즈는</span> 사이트 가로폭 이하 사이즈로 올려주세요.<br>
				- 사이트 전체 가로 폭이 <span class="text_emphasis"><?=$shshop_main[width]?></span>px입니다.
				
				</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pop_img_link">이미지링크</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="pop_img_link" name="pop_img_link" value="<?=$pop_img_link?>" class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 이미지링크 주소를 입력해 주세요. 예) http://www.mysite.com/</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="contents">내용</label></th>
            <td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="contents" id="contents" class="smarteditor2" style="width:100%;height:350px;"><?=$contents?></TEXTAREA>
                <span class="frm_info"><?=$help_img?> 내용을 입력해 주세요.</span>
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

	<!-- 스마트 에디터 자바스크립트 시작 -->
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
		oEditors.getById["contents"].exec("UPDATE_CONTENTS_FIELD", []);

		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//}    

        return true;
    }
    </script>

</div>
<!-- 팝업 관리 끝 -->