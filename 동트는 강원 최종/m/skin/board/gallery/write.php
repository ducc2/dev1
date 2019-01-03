<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>나도 여행작가</h2>

				<form action="#">
				<fieldset>
				<legend>글쓰기</legend>

<!-- 게시물 글쓰기 시작 -->
<div id="content_area" style="<?=$board_info[all_width]?>">
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
		<div class="location_title"><?=$sh_title?></div>
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
        <tr>
            <th scope="row"><label for="password">비밀번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="password" id="password" name="password" value="<?=$password?>" required class="input_box"> 
            </td>
        </tr> 

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


		<?if($board_info[secret_use]=="2" or $_SESSION["admin_id_session"]){?>
			<tr>
				<th scope="row"><label for="options">옵션</label></th>
				<td>
					<input type="checkbox" name="options" id="options" value="secret"> 비밀글 
					<script type="text/javascript">
					if(document.getElementById("options").value == "<?=$options?>") document.getElementById("options").checked = true;
					</script>
					<?if($_SESSION["admin_id_session"]){// 관리자면 공지 체크박스 노출?>
						<span id="notice_span"><input type="checkbox" name="notice" id="notice" value="1"> 공지</span>
						<script type="text/javascript">
						if(document.getElementById("notice").value == "<?=$notice?>") document.getElementById("notice").checked = true;
						</script>
					<?}?>
					
					<?if($reply){// 답변글이면 공지 숨기기?>
						<script type="text/javascript">
						document.getElementById("notice_span").style.display = "none";
						</script>
					<?}?>
				</td>
			</tr>
		<?}?>

        <tr>
            <th scope="row"><label for="email">이메일</label></th>
            <td>
                <input type="text" id="email" name="email" value="<?=$email?>" class="input_box400"> 
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="homepage">홈페이지</label></th>
            <td>
                <input type="text" id="homepage" name="homepage" value="<?=$homepage?>" class="input_box400"> 
            </td>
        </tr>
        <tr>
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

        <tr>
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
        </tr>
		<?// 권한 체크
		if($member[mem_level] >= $board_info[upload_grant]){?>
			<?for($i=0; $i<$board_info[upload_cnt]; $i++){?>
				<tr>
					<th scope="row"><label for="leader_bank_use">파일 <?=($i+1)?></label></th>
					<td>                
						<input type="file" name="upfiles[]" id="bottom_img" class="input_box"><p></p> 
						<?=$upload_del[$i]?>
					</td>
				</tr>
			<?}?>
		<?}?>
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">
        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
        <input type="submit" value="글등록" id="btn_submit" class="button">
    </div>
    </form>
	</div>


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




<!-- 게시물 글쓰기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
