<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<?
$cate = ucfirst($row['category']);

$extra_3 = str_pad($extra_3, 1, "0", STR_PAD_LEFT);
?>
	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="/board/board.php?board_id=writer">Community</a> &gt;
			<span>나도 여행작가</span>
		</div>
	</div><!--//locationwrap -->

	<!-- con_wrap -->
	<div class="con_wrap clearfix" oncontextmenu="return false" onselectstart="return false" ondragstart="return false">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">


					<!-- 게시물 제목영역 -->
					<div class="title clearfix">
						<h2><?=$subject?></h2>
						<span class="writer"><?=$row[name]?> <span class="tag_sup">
						<?
						$phone_t = $row[extra_1]."-".$row[extra_2]."-".$row[extra_3];

						$row_support  = $DB->fetcharr("SELECT * FROM sh_supporter WHERE phone='".$phone_t."'");

						if ($row_support[no]) { echo "강원도서포터즈"; }
						?>
						<!-- 강원도서포터즈 --></span></span>
						<span class="sub_date"><?=substr($datetime, 0, 10)?></span>
						<span class="sub_date">View <?=$hit?></span>
						<button class="#" onclick="copy_trackback('http://<?=$_SERVER['HTTP_HOST']?>/board/board_view.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>')">http://<?=$_SERVER['HTTP_HOST']?>/board/board_view.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?><span class="add">주소복사</span></button>
					</div>

					<p class="represent"><?=$file_img?></p>

					<?=$content?>

					<!-- //게시물 내용 -->

					<!-- 0303 추가 -->
					<!-- 저작권 -->
					<div class="photo_copy">
						<!-- 강원도 저작물이면, 공공누리 4유형 -->
						<? if ($row[extra_1]==1) { ?>
						<div>
							<a href='http://www.kogl.or.kr/info/licenseType4.do' style="float:left; padding-right:10px;"><img alt='제4유형' src='http://www.kogl.or.kr/open/web/images/images_2014/codetype/new_img_opentype04.png' /></a>
							<p class="info"><span>ⓒ</span> 본 저작물은 "공공누리" <a href='http://www.kogl.or.kr/info/licenseType4.do' target='_blank'>제4유형:출처표시+상업적 이용금지+변경금지</a> 조건에 따라 이용 할 수 있습니다.</p>
						</div>
						<? } else { ?>

						<!-- 외부저작물이면 -->
						<p class="info"><span>ⓒ</span> 본 게시물의 글 및 사진은 저작권 법에 따라 보호됩니다.</p>
						<? } ?>
					</div>
					<!-- //저작권 -->
					<!-- //0303 추가 -->

					<!-- 해시태그 -->
					<div class="hash_tag_wrap clearfix">
						<? 					
					 $temp = explode(",",$row['extra_4']);
					 $temp_c = count($temp);

					 for($i=0;$i<$temp_c;$i++ ) {
					 ?>
					<span class="hash_tag"><a href="/sub/tagArchives_list.html?board_id=<?=$board_id?>&tag=<?=urlencode($temp[$i])?>">#<?=$temp[$i]?></a></span>
					<?  } ?>
				   </div><!-- hash_tag_wrap -->

					<div class="btnArea right">
						<a href="popup_pass.html?mode=edit&no=<?=$_GET[no]?>" onclick="popup(this.href, 'new', '400', '300', 'no', 'no', '3'); return false;" class="btnBig glay">수정</a>
						<a href="popup_pass.html?mode=delete&no=<?=$_GET[no]?>" onclick="popup(this.href, 'new', '400', '300', 'no', 'no', '3'); return false;" class="btnBig glay">삭제</a>
						<a href="/board/board.php?board_id=<?=$_GET['board_id']?>" class="btnBig glay">목록</a>
					</div>

			 </div><!--// contents-->

			<div class="share_area clearfix">
				<div class="share_icon clearfix">
					<a href="#share"><span class="icon_set share_sns" title="공유"></span></a>
					<a href="/board/board_view_print.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>" onclick="popup(this.href, 'pdf', '910', '700', 'yes', 'yes', '3'); return false;"><span class="icon_set print" title="인쇄"></span></a>
					<!--<a href="/board/board.php?board_id=<?=$_GET['board_id']?>"><span class="icon_set list" title="목록"></span></a>-->
					<!-- share alert-->
					<p class="share_alert clearfix" style="display:none;" >
						<a href="#none" onclick="pstFaceBook('http://<?=$_SERVER['HTTP_HOST']?>/board/board_view.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>')"><span class="icon_set alert_sns_f">페이스북</span></a>
						<a href="#none" onclick="pstTwitter('http://<?=$_SERVER['HTTP_HOST']?>/board/board_view.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>')"><span class="icon_set alert_sns_t">트위터</span></a>
						<a href="#none" onclick="pststory('http://<?=$_SERVER['HTTP_HOST']?>/board/board_view.php?board_id=<?=$_GET[board_id]?>&no=<?=$_GET[no]?>')"><span class="icon_set alert_sns_k">카카오톡</span></a>
						<span class="triangle"></span>
						<span class="triangle"></span>
					</p>
				</div>
				<script>
					$(".share_sns").click(function(){
						$(".share_alert").slideToggle(200);
					});
				</script><!--// share alert-->
			</div>
	

			

<script>

	function board_copy_move_proc(mode){
		document.getElementById("state").value		= "board_move";
		var form		= document.getElementById("board_hidden_form");
		nWidth			= 600;
		nHeight			= 500; 					
		nLeft			= (window.screen.width - nWidth ) / 2; 
		nTop			= (window.screen.height- nHeight) / 2; 
		var upwin		= window.open("", "board_copy_move", "width="+nWidth+", height="+nHeight+", top="+nTop+", left="+nLeft+", scrollbars=yes");
		form.action		= './board_copy_move.php?mode='+mode;
		form.target		= "board_copy_move";
		form.method		= 'post';
		form.submit();
		upwin.focus();
		return false;	
	}


	// submit 폼체크
	function recomment_proc(){		
		var form		= document.getElementById("recommentform");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();
		return true;
	}


	// submit 폼체크
	function board_drop_proc(){		
		
		if(confirm("선택하신 게시물을 삭제 하겠습니다.\n(주의:삭제되면 복구 할 수 없습니다.)")==false){
			return false;			
		}

		var form		= document.getElementById("board_hidden_form");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();
		return true;
	}

	function pststory(url) {
    var href = url;
    var a = window.open('https://story.kakao.com/share?url='+url, 'cacao', 'width=800, height=500');
    if ( a ) {
     a.focus();
    }
   }

function pstTwitter(msg,url) {
    var href = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(msg) + "&url=" + encodeURIComponent(url);
    var a = window.open(href, 'twitter', 'width=800, height=500');
    if ( a ) {
     a.focus();
    }
   }

function pstFaceBook(url) {
	var pageTitle = "<?=$subject?>"; //HTML page title
	var href = "http://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url)+"&amp;title=" + encodeURIComponent(pageTitle);
	var a = window.open(href, 'facebook', 'width=800, height=500');
	if ( a ) {
		a.focus();
	}
}
</script>


<!-- 게시물 보기 끝 -->


<?=$board_info[	bottom_contents];// 설정된 하단내용 출력?>