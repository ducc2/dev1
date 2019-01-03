<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 기본설정 설정 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./shop_basic_set_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="update">
	<input type="hidden" name="updir" value="<?=$updir?>">
	<?=$shop_basic[upfile_field]?>
	<div class="form_div">
		<div class="location_title"><?=$sh_title?></div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="site_subject">홈페이지 제목</label></th>
            <td>
                <input type="text" id="site_subject" name="site_subject" value="<?=$shop_basic[site_subject]?>" required class="input_box600"> 
                <span class="frm_info"><?=$help_img?> 웹브라우저 제목 표시줄에 누출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="favicon_img">파비콘</label></th>
            <td>
				<?=$shop_basic[favicon_img_temp]?>
				<input type="file" name="upfiles[]" id="bg_img" class="input_box"> <?=$shop_basic[del_favicon_img]?>
                <span class="frm_info"><?=$help_img?> 웹 브라우저의 주소창에 표시되는 웹사이트나 웹페이지를 대표하는 아이콘입니다. 확장자가 .ico 파일을 등록하세요. 사이즈 : 16 x 16px</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="block_ip">샵소개</label></th>
            <td>
				<textarea name="introduce" id="introduce" class="smarteditor2" style="width:99%;height:500px;"><?=$shop_basic[introduce]?></textarea>
                <span class="frm_info"><?=$help_img?> 샵소개 페이지에 노출됩니다. </span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="block_ip">접근차단 아이디</label></th>
            <td>
				<textarea name="block_ip" id="block_ip" style="width:99%;height:200px;"><?=$shop_basic[block_ip]?></textarea>
                <span class="frm_info"><?=$help_img?> 엔터(줄바꿈)를 기준을 하나의 차단 아이피로 차단합니다.  예) 단일 : 127.127.127.1, 그룹:127.127.127 </span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="outside_script">외부로그분석 스크립트</label></th>
            <td>
				<textarea name="outside_script" id="outside_script" style="width:99%;height:200px;"><?=$shop_basic[outside_script]?></textarea>
                <span class="frm_info"><?=$help_img?> 야후, 네이버 등의 외부 로그분석 스크립트를 입력해주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="add_meta">추가 메타태그</label></th>
            <td>
				<textarea name="add_meta" id="add_meta" style="width:99%;height:200px;"><?=$shop_basic[add_meta]?></textarea>
                <span class="frm_info"><?=$help_img?> 추가로 사이트에 적용한 메타태그를 입력해주세요.</span>
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
		oEditors.getById["introduce"].exec("UPDATE_CONTENTS_FIELD", []);

        return true;
    }
    </script>

</div>
<!-- 기본설정 설정 끝 -->