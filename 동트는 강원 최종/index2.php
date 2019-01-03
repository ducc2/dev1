<?
$sh["rPath"]	= ".";
$sh["main"]		= true;
include_once($sh["rPath"]."/_common.php");

if(preg_match('/(iPhone|Android|Opera Mini|SymbianOS|Windows CE|BlackBerry|Nokia|SonyEricsson|webOS|PalmOS|iPod|iPad|XT720|LG-KU3700|NexusOne|SKY|IM-A710K|HTCDesire|X10i|HTCHD2)/i', $_SERVER['HTTP_USER_AGENT'])) {
		js_alert_parent_href('', "/m/");

} else {
	$mobile_con=false;
}


$sh["title"] = $sh["stie_title"]."";

$board_id			="contents";
$table01			= BOARD_WRITE_TABLE.$board_id;
$table02			= BOARD_FILE_TABLE;
$updir				= DATA_PATH."board/".$board_id."/";
$thumb_dir			= DATA_PATH."board/".$board_id."/";
$thumb_url			= "./data/board/".$board_id."/thumb/";
$upUrl				= "./data/board/".$board_id;



?>


<!DOCTYPE html>
<html lang="ko">
<head>
	<title>동트는 강원</title>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- 마크업 전달 속성 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="comn/css/style.css">
	<link rel="stylesheet" type="text/css" href="comn/css/main_slide.css">

	<!--[if lt IE 9]>
	<script src="comn/js/html5.js"></script>
	<script src="comn/js/css3-mediaqueries.js"></script>
	<![endif]-->
		
	<script src="comn/js/jquery-1.11.2.min.js"></script>
	<script src="comn/js/common.js"></script>
	<script src="comn/js/jquery-ui.min.js"></script>
	<script src="comn/js/mighty.slide.4.2.2.min.js"></script>

	<script>
// 팝업	u - 주소, n - 이름, w - 넓이, h - 높이, s - 스크롤여부(yes, no), r - 창크기조절여부(yes, no), m - (1:일반, 2:위쪽모서리, 3:정중앙)
function popup(u, n, w, h, s, r, m) {
    var o;
    var lP = screen.availWidth;
    var tP = screen.availHeight;
    var p  = "";
	
	if(s==undefined) s = "no";
	if(m==undefined) m = 1;
	
    if(m==2) //- 위쪽모서리
        p = ",left=0,top=0";
    else if(m==3) //- 정중앙
        p = ",left=" + ((lP - w) / 2) + ",top=" + ((tP - h) / 2);
    
    o = window.open(u,n,"status=yes,toolbar=no,location=no,scrollbars=" + s + ",resizable="+r+",width="+w+",height="+h + p);
    o.focus();
}
	</script>

</head>
<body>
<?
// 메인일때 팝업 가져오기
if($sh["main"] == true AND $mobile_con==false)	include_once($sh["rPath"]."/_popup_inc.php");

// 샵 설정 서버 프로그램 끝   (삭제 금지)


?>

<div id="div_popup_box" style="display:none;">
	<div id="div_popup_close">X</div>
	<div id="div_popup"><iframe name="div_popup_ifm" id="div_popup_ifm" src="" frameborder="0" scrolling="no" style="width:100%;height:100%;"></iframe></div>
</div>


<ul id="accessibility-link">
	<li><a href="#gnbMenu">메뉴 바로가기</a></li>
	<li><a href="#container">컨텐츠 바로가기</a></li>
</ul>

	<div class="gnbwrap">
		<div class="gnb">
			<form name="se_fo" action="/sub/search_list.html" method="POST">
			<h1><a href="/"><img src="../comn/img/logo.png" alt="동트는강원"></a></h1>
			<div class="unb">
				<div class="before"><a href="/sub/ebook_view.html" onclick="popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;"><span class="icon_set icon_before"></span>전자책보기</a></div>
				<div class="request"><a href="/newsletter/newsletter_apply01.php"><span class="icon_set icon_request"></span>구독신청</a></div>
				<div class="searchbox">
				   <input type="text" name="search_txt" placeholder="검색어를 입력해주세요." class="search_back" title="검색어 입력" style="ime-mode:active">
				   <div class="search_back_icon"><a href="#none" onclick="document.se_fo.submit()"></a></div>
				</div>
			</div><!-- //unb -->
			</form>
			<!-- menu -->
			<ul class="menu" id="gnbMenu">
				<li><a href="/board/board.php?board_id=contents&cate=tour">Tour</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=food">Food</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=culture">Culture</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=contents&cate=economy">Economy</a><span class="bar"></span></li>
				<li><a href="/board/board.php?board_id=writer">Community</a>
					 <ul class="submenu">
						 <li><a href="/board/board.php?board_id=writer" >나도 여행작가</a></li>
						 <li><a href="/board/board.php?board_id=news" >뉴스레터</a></li>
						 <li><a href="/board/board.php?board_id=notice" >이벤트/공지</a></li>
					 </ul>
				</li>
			</ul> <!-- //menu -->
			<div class="sns_s">
				<a href="https://www.facebook.com/dongtuni" target="_blank"><span class="icon_set icon_facebook_s"></span></a>
				<a href="http://blog.naver.com/dongtuni" target="_blank"><span class="icon_set icon_blog_s"></span></a>
			</div>
		</div><!-- //gnb -->
	</div> <!-- //gnbwrap -->

	<!-- mainVisual -->
	<section id="mainVisual">

		<div class="parentControl">
			<button type="button" class="go-button go-ir" data-type="prev">이전 비주얼</button>
			<button type="button" class="go-button go-ir" data-type="next">다음 비주얼</button>
		</div>

		<div class="grap go-layout">
			<div class="obj">
		<?
		$table01			= SHOP_BANNER_TABLE;
		$upUrl				= "./data/banner/";
		
		if($sch_text)	$where[] = "$sch_key LIKE '%$sch_text%'";
		if($where)		$swhere  = " WHERE ".implode(" AND ", $where);	


		$sql		= "SELECT a.* FROM sh_shop_banner a where a.ban_use=2 ORDER BY a.sequence asc";

		$row		= $DB->dfetcharr($sql);
		$tot		= $DB->rows_count($sql);

		
		for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			$rows[idx]		= $idx;

			if($rows[ban_img]){
				$filename_exp	= explode("|", $rows[ban_img]);
				$ban_img_tmp	= "<img src='$upUrl/$filename_exp[1]' alt='사진'>";
			}else{
				$ban_img_tmp	= "";
			}
			extract($rows);

			$next_sql = "select ban_img from sh_shop_banner where ban_use=2 and sequence > ".$rows['sequence']." order by sequence asc limit 0,1";
			$next_row			= $DB->fetcharr($next_sql);
			
			
			if($next_row[ban_img]){
				$filename_exp2	= explode("|", $next_row[ban_img]);
				$ban_img_tmp2	= "<img src='$upUrl/$filename_exp2[1]' alt='사진'>";
			}else{
				$next_sql2 = "select ban_img from sh_shop_banner where ban_use=2 order by sequence asc limit 0,1";
				$next_row2			= $DB->fetcharr($next_sql2);
				$filename_exp2	= explode("|", $next_row2[ban_img]);
				$ban_img_tmp2	= "<img src='$upUrl/$filename_exp2[1]' alt='사진'>";
			}


			$prev_sql = "select ban_img from sh_shop_banner where ban_use=2 and sequence < ".$rows['sequence']."  order by sequence desc limit 0,1";
			$prev_row			= $DB->fetcharr($prev_sql);
			
			if($prev_row[ban_img]){
				$filename_exp3	= explode("|", $prev_row[ban_img]);
				$ban_img_tmp3	= "<img src='$upUrl/$filename_exp3[1]' alt='사진'>";
			}else{
				$prev_sql2 = "select ban_img from sh_shop_banner where ban_use=2 order by sequence desc limit 0,1";
				$prev_row2			= $DB->fetcharr($prev_sql2);
				$filename_exp3	= explode("|", $prev_row2[ban_img]);
				$ban_img_tmp3	= "<img src='$upUrl/$filename_exp3[1]' alt='사진'>";
			}

			?>
				<div class="item">
					<figure><?=$ban_img_tmp?></figure>
					<div class="objChildren">
						<div class="child">
							<div class="childItem">
								<span class="childTit"><span><?=strip_tags($rows['ban_category'])?></span></span>
								<a href="<?=$rows[ban_img_link]?>">
									<i><?=$rows['ban_name']?></i>
									<p><?=strip_tags($rows['ban_text'])?></p>
								</a>
							</div>
						</div>
						<div class="childMore">
							<!-- <p class="hit"><span>VIEW</span> 235</p> -->
							<a class="more go-ir" href="<?=$rows[ban_img_link]?>">내용 상세보기</a>
						</div>
					</div>
					<div class="l"><?=$ban_img_tmp2?></div>
					<div class="r"><?=$ban_img_tmp3?></div>
				</div><!-- //item -->

				<? } ?>

				<div class="control">
					<span class="controlspan"></span>
					<button type="button" class="go-button go-ir" data-type="stop">비주얼 멈춤</button>
					<button type="button" class="go-button go-ir" data-type="play">비주얼 시작</button>
				</div>

			</div><!-- //grap -->
		</div>

		<!-- 메인슬라이드 js -->
		<script type="text/javascript" src="comn/js/main_slide.js"></script>

	</section><!-- //mainVisual -->
<?
$row_big			= $DB->fetcharr("SELECT * FROM sh_board_wr_contents ORDER BY extra_2 desc, extra_3 desc");

if (!$_GET['yy']) {
$yy = $row_big["extra_2"];
} else { 
$yy = $_GET['yy'];
}

if (!$_GET['mm']) {
$mm = $row_big["extra_3"];
} else {
$mm = $_GET['mm'];
}
?>
	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container main" id="container"><!--메인페이지에서만 class main 추가-->
			 <div class="contents">
					<div class="title clearfix">
						<h2 class="tit_main">Contents</h2>
						<span class="main_date"><?=$yy?>년 <?=$mm?>월호</span><div class="last_view2">
							지난호보기 : 
							<select name="yy" id="yy">
								<option value="2016" selected="selected">2016년</option>
							</select>
							<select name="mm" id="mm">
							<option value="">월선택</option>
							<? for($i=1;$i<13;$i++) { ?>
								<option value="<?=$i?>" <? if ($i==$mm) { ?>selected="selected"<? } ?>><?=$i?>월</option>
							<? } ?>
							</select>
							<a href="#none" onclick="last_content()" class="btn" >GO</a>
						</div>
<script>
function last_content() {
			var yy_val = $("#yy").val();
			var mm_val = $("#mm").val();

			location.href="?yy="+yy_val+"&mm="+mm_val;
			 }
</script>
					</div>
					<ul class="clearfix">
<?

$sql			= "SELECT a.* FROM sh_board_wr_contents a where a.extra_2 = ".$yy." and a.extra_3 = ".$mm." ORDER BY a.num DESC, a.reply ASC";
$row			= $DB->dfetcharr($sql." LIMIT 0 , 12");
		
		//$tot =3 ;
		$tot = sizeof($row);

		if($tot == 0){
			echo "<p class='noData'>".$yy."년 ".$mm."월호에 등록된 Contents가 없습니다.</p>";
		}

		$line_width = ceil( $tot / 3 )  * 3;

		$brcnt		= 1; 
		for($i=0;$i<$line_width;$i++){

			$rows					= $row[$i];
			$rows[idx]				= $idx;
			$tit_con				= "";
			$glass					="";

			$bg						= 'bg'.($i%2);
			$regdate				= strtotime($rows[datetime]);
			$today_time				= strtotime(date("Y-m-d H:i:s", strtotime("- ".$board_info[new_icon]." hour"))); 

			$reply_padding			= ($rows[reply])							? "padding-left:".(strlen($rows[reply]) * 20). "px;" : "";	
			$reply_image			= ($rows[reply])							? "<img src='".$board_skin."/img/icon_reply.png'>" : "";	
			$options_image			= ($rows[options]=="secret")				? "<img src='".$board_skin."/img/icon_secret.gif'>" : "";	
			$file_image				= ($rows[file] >0)							? "<img src='".$board_skin."/img/icon_file.gif'>" : "";	
			$new_image				= ($today_time < $regdate)					? "<img src='".$board_skin."/img/icon_new.gif'>" : "";	
			$best_image				= ($rows[hit] > $board_info[best_icon])		? "<img src='".$board_skin."/img/icon_best.gif'>" : "";	
			$rows[comment]			= ($rows[comment] > 0)						? "(".$rows[comment].")" : "";			
			$rows[idx2]				= ($rows[notice] == 1)						? "공지" : "";			
			$rows[noticecss]		= ($rows[notice] == 1)						? "_notice" : "";
			
			$rows[subject]			= text_cut_kr($rows[subject], 30);
			$rows[content]			= text_cut_kr(strip_tags($rows[content]), 70);
			extract($rows);

			$row_file	= $DB->fetcharr("SELECT filename FROM ".$table02." WHERE board_id='".$board_id."' AND board_no='".$rows[no]."' ORDER BY file_sort ASC");
			if($row_file[filename]){
				$board_img	= "<img src='".$thumb_url."thumb".$row_file[filename]."' class='def' alt='사진'>";
				$tit_con	="class='tit_con'";
				$ahref = '<a href="./board/board_view.php?board_id='.$board_id.'&no='.$no.'&sch_key='.$sch_key.'&sch_text='.$sch_text.'&cate='.$cate.'&refer='.$refer.'">';
				$glass= '<div class="dark"><img src="comn/img/icon_thumb.png" alt="자세히보기"></div>';
			}else{

				$aa = $line_width - $tot;
				if($aa == 1){
					if ($i%3==2) {
						$board_img	= "<img src='comn/img/banner_before.png' alt='지난호보기'>";
						$ahref = "<a href='/sub/ebook_view.html' onclick=\"popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;\">";
					}
				}else if($aa == 2){
					if ($i%3==1) {
						$board_img	= "<img src='comn/img/banner_before.png' alt='지난호보기'>";
						$ahref = "<a href='/sub/ebook_view.html' onclick=\"popup(this.href, 'pdf', '640', '750', 'yes', 'no', '3'); return false;\">";
					} else if ($i%3==2) {
						$board_img	= "<img src='comn/img/banner_happy.png' alt='행복이야기'>";
						$ahref = "<a href='http://gwiyagi.tistory.com/' target='_blank'/>";
					}
				}
			}

?>

						<li>
							<?=$ahref?>
								<div class="thumb">
									<?=$board_img?>
									<?=$glass?>
								</div>
								<h4 <?=$tit_con?>><!--<span><?=$rows[category]?></span>--><?=$rows[subject]?></h4></a>
						</li>
		<? } ?>
						
					</ul>
			  </div><!--// contents-->
		</div><!--// container -->
<?
include_once("./_bottom_main.php");
?>
