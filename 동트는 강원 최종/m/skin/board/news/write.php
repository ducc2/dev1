<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="/board/board.php?board_id=writer">Community</a> &gt;
			<span>뉴스레터</span>
		</div>
	</div><!--//locationwrap -->

<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>뉴스레터</h2>


				<fieldset>
				<legend>글쓰기</legend>
<script type="text/javascript" src="/module/SmartEditor/js/HuskyEZCreator.js" charset="utf-8"></script>

<!-- 게시물 글쓰기 시작 -->
<div class="bbsInfo right"><em class="require">*</em> 표시는 필수입력항목입니다.</div>

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
	<!-- <input type="hidden" name="extra_1" value="<?=$_POST['pphone']?>"> -->
<? //print_r($_POST); ?>

<?
if ($_GET['no']) { 
	$name_t = $row['name'];
	$phone_t = $row['extra_1'];
} else {

	$name_t = $_POST['pname'];
	$phone_t = $_POST['pphone'];
}
?>

	<div class="form_div">
		
		<table summary="글쓰기:작성자, 제목, " class="tblBbs">
				<caption>글쓰기</caption>
				<colgroup>
					<col style="width:12%;">
					<col style="width:88%;">
				</colgroup>
				<tbody>
					<tr>
						<th><em class="require">*</em> 작성자</th>
						<td class="left">
							<input type="text" style="width:200px;" name="name" title="이름" value="<?=$name_t?>">
							<!-- 강원도서포터즈면 -->
							<span class="tag_sup"><!-- 강원도서포터즈 --></span>
							<!-- //강원도서포터즈면 -->
						</td>
					</tr>
					<tr>
						<th><em class="require">*</em> 전화번호</th>
						<td class="left">
							<input type="text" style="width:200px;" name="extra_1" title="전화번호" value="<?=$phone_t?>">
							<!-- 강원도서포터즈면 -->
							<span class="tag_sup"><!-- 강원도서포터즈 --></span>
							<!-- //강원도서포터즈면 -->
						</td>
					</tr>
      
				<tr>
						<th><em class="require">*</em> 제목</th>
						<td class="left"><input type="text" style="width:95%;" name="subject" title="제목" value="<?=$row['subject']?>"></td>
					</tr>
				<tr>
						<td class="left" colspan="2">
						<TEXTAREA name="content" id="content" class="smarteditor2" style="width:99%;height:350px;"><?=$content?></TEXTAREA>
						</td>
				</tr>
				<tr>
						<th>해시태그</th>
						<td class="left">
							<input type="text" style="width:95%;" name="extra_4" title="해시태그" value="<?=$row['extra_4']?>"><br>
							<em>※ 해시태그는 ','로 구분해서 등록해주십시오.</em><!-- 해시태그 등록방법은 예시로 써넣은것입니다. 다른방법으로 등록하신다면 설명문도 바꿔주시기바랍니다. -->
						</td>
					</tr>
					<tr>
						<th><em class="require">*</em> 비밀번호</th>
						<td class="left">
							<input type="password" style="width:100px;" name="password" title="비밀번호" value="<?=$password?>">
							<em>※ 글 수정 및 삭제 시 필요하오니 반드시 기억해주시기 바랍니다.</em>
						</td>
					</tr>
					<tr>
				<?for($i=0; $i<$board_info[upload_cnt]; $i++){?>
						<tr>
							<th>업로드 <?=($i+1)?></th>
							<td class="left">                
								<input type="file" name="upfiles[]" id="bottom_img" class="input_box"><p></p> 
								<?=$upload_del[$i]?>
							</td>
						</tr>
				<?}?>
				</tbody>
				</table>

				<div class="btnArea center">
					<a href="#none" onclick="document.fregisterform.submit();" class="btnBig orange">등록하기</a>
					<!-- 수정 시 <a href="#" class="btnBig orange">수정하기</a>-->
					<a href="#" class="btnBig glay" onclick="history.back(-1);">취소하기</a>
				</div><!-- //btnArea -->
    </form>
	</div>


		<!-- 스마트 에디터 자바스크립트 시작 -->
		<script type="text/javascript">
		var oEditors	= [];
		var rPath		= "<?=$sh["rPath"]?>"
		</script>	
		<script type="text/javascript" src="/js/smarteditor.js"></script>
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




<!-- 게시물 글쓰기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>
