<? include "./inc/header.php"; ?>
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>
							<li class="active">CRM 달력</li>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								일정표
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									전체 상담일정을 보여줍니다.
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
<?php
/* 빈칸을 출력한다.
* @param $count : 출력할 빈칸(<td> tag) 의 갯수
*/
function tdN($count){
for ($i=0; $i<$count; $i++) {
echo '<td>  </td>';
}
}

/* 달력 출력함수
* @param $month : 해당 월
* @param $year        : 해당 년
*/
function calendar($month, $year, $mode=0,$mysqli){ 

// 기본 설정값으로 현재 달을 설정
if ($month=="" and $year =="") {
$month=date('m');
$year=date('Y');
}

// 여기서 달과 년도를 바꾼다. 꽁수죠..^^
if ($mode == 1) $month= $month-1;
else if ($mode == 2) $month = $month+1;
else if ($mode == 3) $year = $year-1;
else if ($mode == 4) $year = $year+1;

// 한계치 설정
if ($month == 0) {
$month = 12;
$year = $year-1;
} else if ($month == 13) {
$month = 1;
$year = $year+1;
}

// 변수
$date=01; 
$day=01; 
$off=0; 
$td_end = "</td>";
$td_normal = "<td> ";
$td_head = "<td align=center height='50' width='12%' bgcolor='#FFEBCA'>";
$td_show = "<td align=left height='75' width='12%' onMouseOut=this.style.backgroundColor='' onMouseOver=this.style.backgroundColor='#F6F0F3' style='word-break:break-all;padding:0px; vertical-align:top' align='center'>";

// header
echo "<style type=\"text/css\">";
echo "<!--";
echo "td { font-weight:600; font-family: \"굴림\", \"굴림체\", \"바탕\"; font-size: 9pt; line-height: 22px}";
echo "a:link {font-size:10pt; font-family:굴림; text-decoration:none; color:000000;}";
echo "a:visited {font-size:10pt; font-family:굴림; text-decoration:none; color:000000;}";
echo "a:hover {font-size:10pt; font-family:굴림; text-decoration:none; color:0000ff;}";
echo "a:active {font-size:10pt; font-family:굴림; text-decoration:none; color:0000ff;}";
echo "-->";
echo "</style>";

// 전월, 이월 링크
echo "<table border=0 align=center cellpadding=3 width=100%>";
echo "<tr><td>";

if ($_SESSION['ss_user_grade']>1) {
	echo "<a href='#none' onclick=\"openWin('vacation.html?year=".$year."&month=".$month."&vac_date=".$year."-".sprintf('%02d',$month)."-".sprintf('%02d',$day)."',500,360)\"><button class=\"btn btn-info\" type=\"button\">직원 휴가</button>";
}

echo "</td></tr>";
echo "<tr bgcolor='#ffffff' ><td align=center>";
echo "<a href='$PHP_SELF?year=$year&month=$month&mode=3'>▼</a> ";
echo "<a href='$PHP_SELF?year=$year&month=$month&mode=1'>◀</a> ";
echo "<span style='font-size:25px'>".$year.'년 '.$month.'월</span> ';
echo "<a href='$PHP_SELF?year=$year&month=$month&mode=2'>▶</a> ";
echo "<a href='$PHP_SELF?year=$year&month=$month&mode=4'>▲</a> ";
echo "</td></tr></table>";

// table 
echo "<table bgcolor='#ffffff' cellspacing=0 cellpadding=1 bordercolorlight='#c0c0c0' bordercolordark='#ffffff' width='100%' border=1 align='center'>";
echo "<tr>";

// 제목 줄 출력
echo "$td_head<font class=ver9 color='red'><b>일<b></font>$td_end";
echo "$td_head<b>월</b></font>$td_end";
echo "$td_head<font class=ver9 color='black'><b>화</b></font>$td_end";
echo "$td_head<font class=ver9 color='black'><b>수</b></font>$td_end";
echo "$td_head<font class=ver9 color='black'><b>목</b></font>$td_end";
echo "$td_head<font class=ver9 color='black'><b>금</b></font>$td_end";
echo "$td_head<font class=ver9 color='#a6a6a9'><b>토</b></font>$td_end";
echo "<tr>"; 

// 이번달의 마지막 날을 $date에 저장한다.
while (checkdate($month,$date,$year)): 
$date++; 
endwhile; 

// $day 를 $date(이번달의 마지막날)까지 증가하면서 출력한다.
while ($day<$date): 
// 첫번째 날이 무슨요일인지 확인하여 앞의 빈칸과 같이 출력한다.
if ($day == '01') {
$temp = date("w", mktime(0,0,0,$month,$day,$year));

echo tdN($temp);

echo $td_show.$day;

if ($day<10) { 
	$temp_date = date("Y-m")."-0".$day;
} else {
	$temp_date = date("Y-m")."-".$day;
}

$query = "SELECT * from crm_apply where apply_date='".$temp_date."' ".$mycrm_sql." order by	trim(REPLACE(apply_3, ':', '')) asc";
$result = mysqli_query($mysqli, $query);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	
	$apply_4="";
	if ($row['apply_4']=='황인성원장') { 
		$apply_4= "H";
	} else if ($row['apply_4']=='구진모원장') { 
		$apply_4= "K";
	} else if ($row['apply_4']=='이지용원장') { 
		$apply_4= "L";
	} else { 
		$apply_4= "없음";
	} 



	$query2 = "SELECT * FROM crm_terms where terms_idx='".$row['apply_9']."'";
	$rest = $mysqli->query($query2);
	$row2 =  mysqli_fetch_array($rest, MYSQLI_ASSOC);
	
	$class="";
	if ($row[apply_status]=="63") {
		$class="class='green'";
	} else if ($row[apply_status]=="62") {
		$class="class='black2'";
	} else if ($row[apply_status]=="65") {
		$class="class='black'";
	} else if ($row[apply_status]=="66") {
		$class="class='purple'";
	} else if ($row[apply_status]=="58") {
		$class="class='blue'";
	} else if ($row[apply_status]=="67") {
		$class="class='brown'";
	} else if ($row[apply_status]=="68") {
		$class="class='bgreen'";
	} else if ($row[apply_status]=="69") {
		$class="class='pink'";
	} else if ($row[apply_status]=="64") {
		$class="class='bred'";
	} else if ($row[apply_status]=="55") {
		$class="class='purple'";
	} 

	$query3 = "SELECT * FROM crm_users where user_idx=".$row['apply_teacher'];
	$rst = $mysqli->query($query3);
	$rrow = mysqli_fetch_array($rst, MYSQLI_ASSOC);
	
	$apply_teacher="";
	if ($rrow['user_name']=='이희원') { 
		$apply_teacher= "C";
	} else if ($rrow['user_name']=='안덕화') { 
		$apply_teacher= "A";
	} else if ($rrow['user_name']=='김경민') { 
		$apply_teacher= "K";
	} else { 
		$apply_teacher= "없음";
	} 
	
	if ($_SESSION['ss_user_grade']==3 && $_SESSION['ss_user_idx']==$row['apply_teacher']) { 
	?>
	<span <?=$class?> onclick="location.href='/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=1'"><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } else if ($_SESSION['ss_user_grade']==3 && $_SESSION['ss_user_idx']!=$row['apply_teacher']) { ?>
	<span <?=$class?> ><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } else if ($_SESSION['ss_user_grade']>0) { ?>
	<span <?=$class?> onclick="location.href='/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=1'"><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } else if ($_SESSION['ss_user_grade']==0) { ?>
	<span <?=$class?> ><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } 

}



echo "<br>";

$off = $temp+1;


} else // 그외 경우는 날짜만 출력한다.

echo $td_show.$day."<br>";

$temp_date = $year."-".sprintf('%02d',$month)."-".sprintf('%02d',$day);

$query_ = "SELECT * from crm_vacation where vac_date='".$temp_date."'";
//echo $month;
$result_ = mysqli_query($mysqli, $query_);

while($row_ = mysqli_fetch_array($result_, MYSQLI_ASSOC)) {
	
	$font_color="<font color='#FF8000'>";
	
	if ($_SESSION['ss_user_grade']>1) {
		echo "&#60;<a href='#none' onclick=\"openWin('vacation_detail.php?year=".$year."&month=".$month."&vac_idx=".$row_['vac_idx']."','500','360')\">$font_color ".$row_[vac_name]." ".$row_[vac_type]."</font></a> &#62;<br>";
	} else {
		echo "&#60;<a href='#none' onclick=\"openWin('vacation_detail.php?year=".$year."&month=".$month."&vac_idx=".$row_['vac_idx']."','500','360')\">$font_color ".$row_[vac_name]." ".$row_[vac_type]."</font></a> &#62;<br>";
	}
}

$query = "SELECT * from crm_apply where apply_date='".$temp_date."' ".$mycrm_sql." order by	trim(REPLACE(apply_3, ':', '')) asc";
$result = mysqli_query($mysqli, $query);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	
	$apply_4="";
	if ($row['apply_4']=='황인성원장') { 
		$apply_4= "H";
	} else if ($row['apply_4']=='구진모원장') { 
		$apply_4= "K";
	} else if ($row['apply_4']=='이지용원장') { 
		$apply_4= "L";
	} else { 
		$apply_4= "없음";
	} 

	$query2 = "SELECT * FROM crm_terms where terms_idx='".$row['apply_9']."'";
	$rest = $mysqli->query($query2);
	$row2 =  mysqli_fetch_array($rest, MYSQLI_ASSOC);
	
	$class="";
	if ($row[apply_status]=="63") {
		$class="class='green'";
	} else if ($row[apply_status]=="62") {
		$class="class='black2'";
	} else if ($row[apply_status]=="65") {
		$class="class='black'";
	} else if ($row[apply_status]=="66") {
		$class="class='purple'";
	} else if ($row[apply_status]=="58") {
		$class="class='blue'";
	} else if ($row[apply_status]=="67") {
		$class="class='brown'";
	} else if ($row[apply_status]=="68") {
		$class="class='bgreen'";
	} else if ($row[apply_status]=="69") {
		$class="class='pink'";
	} else if ($row[apply_status]=="64") {
		$class="class='bred'";
	} else if ($row[apply_status]=="55") {
		$class="class='purple'";
	} 

	$query3 = "SELECT * FROM crm_users where user_idx=".$row['apply_teacher'];
	$rst = $mysqli->query($query3);
	$rrow = mysqli_fetch_array($rst, MYSQLI_ASSOC);
	
	$apply_teacher="";
	if ($rrow['user_name']=='이희원') { 
		$apply_teacher= "C";
	} else if ($rrow['user_name']=='안덕화') { 
		$apply_teacher= "A";
	} else if ($rrow['user_name']=='김경민') { 
		$apply_teacher= "K";
	} else { 
		$apply_teacher= "없음";
	} 

	if ($_SESSION['ss_user_grade']==3 && $_SESSION['ss_user_idx']==$row['apply_teacher']) { 
	?>
	<span <?=$class?> onclick="location.href='/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=1'" style="cursor:pointer"><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } else if ($_SESSION['ss_user_grade']==3 && $_SESSION['ss_user_idx']!=$row['apply_teacher']) { ?>
	<span <?=$class?>  style="cursor:pointer"><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } else if ($_SESSION['ss_user_grade']!=3) { ?>
	<span <?=$class?>  style="cursor:pointer" onclick="location.href='/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=1'"><?=$row['apply_name']?>-<?=$apply_teacher?>-<?=$apply_4?>-<?=$row2['terms_title']?>-<?=$row[apply_3]?></span><br>
	<? } 
	//echo $row[apply_status];
}



echo "<br>".$td_end;

// $day와 $off 증가
$day++; 
$off++; 

// 요일($off)가 토요일(7)까지 가면 줄을 바꾼다.
if ($off>7) { 
echo "</tr><tr>"; 
$off='01'; 
} 
endwhile; 

// 마지막 남은 빈칸들 출력
while($off<8 && $off!='01'):
$off++;
echo "$td_normal$td_end";
endwhile;

// tailer
echo "</tr></table>"; 
} 
?> 
<? echo calendar($_GET[month],$_GET[year],$_GET[mode],$mysqli); ?>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

<? include "./inc/tail.php"; ?>

<style>
.bred{color:red}
</style>


