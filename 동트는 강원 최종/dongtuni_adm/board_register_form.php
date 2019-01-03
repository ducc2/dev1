<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 게시판 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./<?=$include_file?>_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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
            <th scope="row"><label for="name">게시판 이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="name" name="name" value="<?=$name?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 게시판 이름 적어주세요. 예) 이벤트, 갤러리</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ename">게시판 영문 이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="ename" name="ename" value="<?=$ename?>" required class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 게시판 영문 이름은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내) 예) event, gallery</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="category">분류</label></th>
            <td>
                <input type="text" id="category" name="category" value="<?=$category?>" class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 게시판 분류를 적어주세요. 예) 배송|반품|환불 '|' 구분자로 사용됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="manager_id">관리자 아이디</label></th>
            <td>
                <input type="text" id="manager_id" name="manager_id" value="<?=$manager_id?>" class="input_box"> 
                <span class="frm_info"><?=$help_img?> 게시판을 관리 할 부관리자 아이디를 적어주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="list_grant">목록권한</label></th>
            <td>
				<select name="list_grant" id="list_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $list_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 목록을 읽을 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="read_grant">글읽기</label></th>
            <td>
				<select name="read_grant" id="read_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $read_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 글읽기 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="write_grant">글쓰기</label></th>
            <td>
				<select name="write_grant" id="write_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $write_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 글쓰기 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="replay_grant">글답변</label></th>
            <td>
				<select name="replay_grant" id="replay_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $replay_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 글답변 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="comment_grant">댓글쓰기</label></th>
            <td>
				<select name="comment_grant" id="comment_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $comment_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 댓글쓰기 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="upload_grant">피일업로드</label></th>
            <td>
				<select name="upload_grant" id="upload_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $upload_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 피일업로드 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="download_grant">다운로드</label></th>
            <td>
				<select name="download_grant" id="download_grant" style="width:130px;" class="selectbox">
					<option value=""> 비회원</option>
					<?=arrToption("sc", $mem_rating, $download_grant, "");?>
				</select>
                <span class="frm_info"><?=$help_img?> 게시판 다운로드 권한을 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="secret_use">비밀글 사용여부</label></th>
            <td>
				<span class='radiobox_span'><input type="radio" name="secret_use" id="secret_use" value="1" <?=($secret_use=="1")?"checked":"";?>>사용안함 </span>
				<span class='radiobox_span'><input type="radio" name="secret_use" id="secret_use" value="2" <?=($secret_use=="2")?"checked":"";?>>사용 </span>
                <span class="frm_info"><?=$help_img?> 비밀글 사용여부를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="editer_use">에디터 사용여부</label></th>
            <td>
				<span class='radiobox_span'><input type="radio" name="editer_use" id="editer_use" value="1" <?=($editer_use=="1")?"checked":"";?>>사용안함 </span>
				<span class='radiobox_span'><input type="radio" name="editer_use" id="editer_use" value="2" <?=($editer_use=="2")?"checked":"";?>>사용 </span>
                <span class="frm_info"><?=$help_img?> 에디터 사용여부를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="recommender_use">추천 사용여부</label></th>
            <td>
				<span class='radiobox_span'><input type="radio" name="recommender_use" id="recommender_use" value="1" <?=($recommender_use=="1")?"checked":"";?>>사용안함 </span>
				<span class='radiobox_span'><input type="radio" name="recommender_use" id="recommender_use" value="2" <?=($recommender_use=="2")?"checked":"";?>>사용 </span>
                <span class="frm_info"><?=$help_img?> 추천 사용여부를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ip_view">ip보기 사용여부</label></th>
            <td>
				<span class='radiobox_span'><input type="radio" name="ip_view" id="ip_view" value="1" <?=($ip_view=="1")?"checked":"";?>>사용안함 </span>
				<span class='radiobox_span'><input type="radio" name="ip_view" id="ip_view" value="2" <?=($ip_view=="2")?"checked":"";?>>사용 </span>
                <span class="frm_info"><?=$help_img?> ip보기 사용여부를 선택해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="upload_cnt">파일업로드 수</label></th>
            <td>
                <input type="text" id="upload_cnt" name="upload_cnt" value="<?=$upload_cnt?>" class="input_box_num_small"> 개
                <span class="frm_info"><?=$help_img?> 파일업로드 수를 적어주세요. 예) 1~10 사이의 정수</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="upload_bytes">파일업로드 용량</label></th>
            <td>
                <input type="text" id="upload_bytes" name="upload_bytes" value="<?=$upload_bytes?>" class="input_box_num"> bytes
                <span class="frm_info"><?=$help_img?> 최대 350M 이하 업로드 가능, 1 MB = 1,048,576 bytes 예) 1048576 사이의 정수</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="skin">스킨</label></th>
            <td>
                <select name="skin" id="skin" required class="selectbox">
					<?=arrToption("s", get_skin_dir('board'), $skin, "");?>
                </select>
                <span class="frm_info"><?=$help_img?> 상단 스킨을 선택해 주세요</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="top_include">상단 파일 경로</label></th>
            <td>
                <input type="text" id="top_include" name="top_include" value="<?=$top_include?>" class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 상단 파일 경로를 적어주세요. 예) ../_top.php 상단 기본 파일</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bottom_include">하단 파일 경로</label></th>
            <td>
                <input type="text" id="bottom_include" name="bottom_include" value="<?=$bottom_include?>" class="input_box400"> 
                <span class="frm_info"><?=$help_img?> 상단 하단 경로를 적어주세요. 예) ../_bottom.php 하단 기본 파일</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="top_contents">상단내용</label></th>
            <td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="top_contents" id="top_contents" class="smarteditor2" style="width:100%;height:350px;"><?=$top_contents?></TEXTAREA>
                <span class="frm_info"><?=$help_img?> 상단 내용을 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bottom_contents">하단내용</label></th>
            <td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="bottom_contents" id="bottom_contents" class="smarteditor2" style="width:100%;height:350px;"><?=$bottom_contents?></TEXTAREA>
                <span class="frm_info"><?=$help_img?> 하단 내용을 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="subject_length">제목길이</label></th>
            <td>
                <input type="text" id="subject_length" name="subject_length" value="<?=$subject_length?>" class="input_box_num_small"> 자
                <span class="frm_info"><?=$help_img?> 목록에서 제목 길이만큼 잘라서 ... 로 표시 됨. 예) 게시물내용...</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="list_cnt">페이지 목록 글 갯 수</label></th>
            <td>
                <input type="text" id="list_cnt" name="list_cnt" value="<?=$list_cnt?>" class="input_box_num_small"> 개
                <span class="frm_info"><?=$help_img?> 한페이지에 보여질 목록수 입니다. 예) 20, 30 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="gallery_cnt">갤러리 이미지 갯 수</label></th>
            <td>
                <input type="text" id="gallery_cnt" name="gallery_cnt" value="<?=$gallery_cnt?>" class="input_box_num_small"> 개
                <span class="frm_info"><?=$help_img?> 한 줄에 보여질 이미지 수 입니다. 예) 4, 5 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="gallery_width">갤러리 이미지 가로 폭</label></th>
            <td>
                <input type="text" id="gallery_width" name="gallery_width" value="<?=$gallery_width?>" class="input_box_num_small"> px
                <span class="frm_info"><?=$help_img?> 한개의 이미지 가로 폭을 입력해 주세요. 예) 160, 180 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="gallery_height">갤러리 이미지 세로 높이</label></th>
            <td>
                <input type="text" id="gallery_height" name="gallery_height" value="<?=$gallery_height?>" class="input_box_num_small"> px
                <span class="frm_info"><?=$help_img?> 한개의 이미지 세로 높이을 입력해 주세요. 예) 160, 180 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="all_width">게시판 전체 넗이</label></th>
            <td>
                <input type="text" id="all_width" name="all_width" value="<?=$all_width?>" class="input_box_num_small"> % or px
                <span class="frm_info"><?=$help_img?> 100이하면 %, 101이상이면 px로 설정됩니다. 예) 100, 800 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="new_icon">뉴 아이콘</label></th>
            <td>
                <input type="text" id="new_icon" name="new_icon" value="<?=$new_icon?>" class="input_box_num_small"> 시간
                <span class="frm_info"><?=$help_img?> 글 입력후 new 이미지를 출력하는 시간입니다. 값이 없으면 아이콘을 출력하지 않습니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="best_icon">인기글 아이콘</label></th>
            <td>
                <input type="text" id="best_icon" name="best_icon" value="<?=$best_icon?>" class="input_box_num_small"> hit
                <span class="frm_info"><?=$help_img?> 조회수가 설정값 이상이면 hot 이미지 출력합니다. 값이 없으면 아이콘을 출력하지 않습니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="write_point">글쓰기 포인트(적립금)</label></th>
            <td>
                <input type="text" id="write_point" name="write_point" value="<?=$write_point?>" class="input_box_num_small"> 원
                <span class="frm_info"><?=$help_img?> 글쓰기를 하면 자동 적립됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="read_point">글읽기 포인트(적립금)</label></th>
            <td>
                <input type="text" id="read_point" name="read_point" value="<?=$read_point?>" class="input_box_num_small"> 원
                <span class="frm_info"><?=$help_img?> 글읽기를 하면 자동 적립됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="comment_point">댓글쓰기 포인트(적립금)</label></th>
            <td>
                <input type="text" id="comment_point" name="comment_point" value="<?=$comment_point?>" class="input_box_num_small"> 원
                <span class="frm_info"><?=$help_img?> 댓글쓰기를 하면 자동 적립됩니다.</span>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="mobile_skin">모바일 스킨</label></th>
            <td>
                <select name="mobile_skin" id="mobile_skin" required class="selectbox">
					<?=arrToption("s", get_skin_dir('mobile'), $mobile_skin, "");?>
                </select>
                <span class="frm_info"><?=$help_img?> 모바일 스킨을 선택해 주세요</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="mobile_top_contents">모바일 상단내용</label></th>
            <td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="mobile_top_contents" id="mobile_top_contents" class="smarteditor2" style="width:100%;height:350px;"><?=$mobile_top_contents?></TEXTAREA>
                <span class="frm_info"><?=$help_img?>모바일 상단 내용을 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_bottom_contents">모바일하단내용</label></th>
            <td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="mobile_bottom_contents" id="mobile_bottom_contents" class="smarteditor2" style="width:100%;height:350px;"><?=$mobile_bottom_contents?></TEXTAREA>
                <span class="frm_info"><?=$help_img?> 모바일 하단 내용을 입력해 주세요.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_subject_length">모바일 제목길이</label></th>
            <td>
                <input type="text" id="mobile_subject_length" name="mobile_subject_length" value="<?=$mobile_subject_length?>" class="input_box_num_small"> 자
                <span class="frm_info"><?=$help_img?> 목록에서 제목 길이만큼 잘라서 ... 로 표시 됨. 예) 게시물내용...</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_list_cnt">모바일 페이지 목록 글 갯 수</label></th>
            <td>
                <input type="text" id="mobile_list_cnt" name="mobile_list_cnt" value="<?=$mobile_list_cnt?>" class="input_box_num_small"> 개
                <span class="frm_info"><?=$help_img?> 한페이지에 보여질 목록수 입니다. 예) 20, 30 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_gallery_cnt">모바일 갤러리 이미지 갯 수</label></th>
            <td>
                <input type="text" id="mobile_gallery_cnt" name="mobile_gallery_cnt" value="<?=$mobile_gallery_cnt?>" class="input_box_num_small"> 개
                <span class="frm_info"><?=$help_img?> 한 줄에 보여질 이미지 수 입니다. 예) 4, 5 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_gallery_width">모바일 갤러리 이미지 가로 폭</label></th>
            <td>
                <input type="text" id="mobile_gallery_width" name="mobile_gallery_width" value="<?=$mobile_gallery_width?>" class="input_box_num_small"> px
                <span class="frm_info"><?=$help_img?> 한개의 이미지 가로 폭을 입력해 주세요. 예) 160, 180 정수로 입력.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="mobile_gallery_height">모바일 갤러리 이미지 세로 높이</label></th>
            <td>
                <input type="text" id="mobile_gallery_height" name="mobile_gallery_height" value="<?=$mobile_gallery_height?>" class="input_box_num_small"> px
                <span class="frm_info"><?=$help_img?> 한개의 이미지 세로 높이을 입력해 주세요. 예) 160, 180 정수로 입력.</span>
            </td>
        </tr>

		<?for($i=1; $i < 11; $i++){?>
			<tr>
				<th><label for="mem_<?=$i?>">여분필드 <?=$i?></label></th>
				<td>
					여분필드 제목 : <input type="text" name="extra_subject_<?=$i?>" value="<?=${'extra_subject_'.$i} ?>" id="extra_subject_<?=$i?>" class="input_box200">
					<!-- 여분필드 값 : <input type="text" name="extra_field_<?=$i?>" value="<?=${'extra_field_'.$i} ?>" id="extra_field_<?=$i?>" class="input_box"> -->
				</td>
			</tr>
		<?}?>

		
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">
        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
        <input type="submit" value="정보저장" id="btn_submit" class="button">
    </div>
    </form>

	<?if($mode=="form"){?>
		<script type="text/javascript">
		document.getElementById("upload_bytes").value			= "1048576";
		document.getElementById("top_include").value			= "_top.php";
		document.getElementById("bottom_include").value			= "_bottom.php";
		document.getElementById("subject_length").value			= "30";
		document.getElementById("list_cnt").value				= "20";
		document.getElementById("gallery_cnt").value			= "4";
		document.getElementById("gallery_width").value			= "180";
		document.getElementById("gallery_height").value			= "180";
		document.getElementById("all_width").value				= "99";
		document.getElementById("new_icon").value				= "24";
		document.getElementById("best_icon").value				= "30";
		document.getElementById("mobile_subject_length").value	= "25";
		document.getElementById("mobile_list_cnt").value		= "10";
		document.getElementById("mobile_gallery_cnt").value		= "3";
		document.getElementById("mobile_gallery_width").value	= "160";
		document.getElementById("mobile_gallery_height").value	= "160";
		</script>
	<?}?>

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
		oEditors.getById["top_contents"].exec("UPDATE_CONTENTS_FIELD", []);
		oEditors.getById["middle_contents"].exec("UPDATE_CONTENTS_FIELD", []);
		oEditors.getById["bottom_contents"].exec("UPDATE_CONTENTS_FIELD", []);

		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//}    

        return true;
    }
    </script>

</div>
<!-- 게시판 관리 끝 -->