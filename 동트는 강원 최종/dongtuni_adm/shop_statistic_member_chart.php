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

	$("input:text[name='sdate']").datepicker(clareCalendar);
	$("input:text[name='edate']").datepicker(clareCalendar);

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:middle; cursor:pointer;"); //이미지버튼 style적용
	$("#ui-datepicker-div").hide(); //자동으로 생성되는 div객체 숨김  
});
</script>


<!-- 매출 통계 시작  -->
<div id="cont_right">
	<div class="location_title"><?=$sh_title?></div>
	<div>
		<form name="fsearch" id="fsearch" method="get" onsubmit="return fsearch_submit(this);">

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>        <tr>
            <th scope="row"><label for="goods_name">통계선택</label></th>
            <td>
				<input type='button' value=' 년간 ' id='chart_year' class='button_white40x24' onclick="chart_choice('year');">
				<input type='button' value=' 월간 ' id='chart_month' class='button_white40x24' onclick="chart_choice('month');">
				<input type='button' value=' 일간 ' id='chart_day' class='button_white40x24' onclick="chart_choice('day');">
				<input type='button' value=' 시간 ' id='chart_hour' class='button_white40x24' onclick="chart_choice('hour');">
				<input type='button' value=' 요일 ' id='chart_week' class='button_white40x24' onclick="chart_choice('week');">
				<input type="hidden" name="chart_type" id="chart_type" value="<?=$chart_type?>">
            </td>
        </tr>


        <tr>
            <th scope="row"><label for="goods_name">검색 기간</label></th>
            <td>
				<label for="sdate" class="sound_only">검색 시작일</label>
				<input type="text" id="sdate" name="sdate" value="<?=$sdate?>" required class="datepicker">
				<label for="edate" class="sound_only">검색 종료일</label>
				<input type="text" id="edate" name="edate" value="<?=$edate?>" required class="datepicker">

				<input type='button' value=' 1주일 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=$day_7?>','<?=$today?>');">
				<input type='button' value=' 1개월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=$day_31?>','<?=$today?>');">
				<input type='button' value=' 3개월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=$day_90?>','<?=$today?>');">
				<input type='button' value=' 6개월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=$day_180?>','<?=$today?>');">
				<input type='button' value=' 1년 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=$day_365?>','<?=$today?>');">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="goods_feature">월별검색</label></th>
            <td>
				<input type='button' value=' ◁ ' id='btn_submit' class='button_white40x24' onclick="month_move('<?=substr($sdate,5,2)?>-<?=substr($sdate,-2)?>-<?=substr($sdate,0,4)?>', 'last');">
				<input type='button' value=' ▷ ' id='btn_submit' class='button_white40x24' onclick="month_move('<?=substr($sdate,5,2)?>-<?=substr($sdate,-2)?>-<?=substr($sdate,0,4)?>', 'next');">

				<input type='button' value=' 1월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>01-01', '<?=date("Y-")?>01-31');">
				<input type='button' value=' 2월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>02-01', '<?=date("Y-")?>02-31');">
				<input type='button' value=' 3월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>03-01', '<?=date("Y-")?>03-31');">
				<input type='button' value=' 4월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>04-01', '<?=date("Y-")?>04-31');">
				<input type='button' value=' 5월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>05-01', '<?=date("Y-")?>05-31');">
				<input type='button' value=' 6월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>06-01', '<?=date("Y-")?>06-31');">
				<input type='button' value=' 7월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>07-01', '<?=date("Y-")?>07-31');">
				<input type='button' value=' 8월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>08-01', '<?=date("Y-")?>08-31');">
				<input type='button' value=' 9월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>09-01', '<?=date("Y-")?>09-31');">
				<input type='button' value=' 10월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>10-01', '<?=date("Y-")?>10-31');">
				<input type='button' value=' 11월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>11-01', '<?=date("Y-")?>11-31');">
				<input type='button' value=' 12월 ' id='btn_submit' class='button_white40x24' onclick="last_month('<?=date("Y-")?>12-01', '<?=date("Y-")?>12-31');">
				<input type="submit" value=" 검 색 " id="btn_submit" class="button_small">	
				<input type="button" value=" 취 소 " class="button_small_white" onclick="document.location.href='<?=$PHP_SELF?>'">	
				<input type="button" value=" 엑셀생성 " class="btn_excel" onclick="document.location.href='__excel_download_member.php?where=<?=$excel_whe?>&chart_type=<?=$chart_type?>&sdate=<?=$sdate?>&edate=<?=$edate?>&stype=statistic1'">
            </td>
        </tr>
		
        </tbody>
        </table>
		</form>
	</div>
	<div class="area_add"></div>
					
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load('visualization', '1.1', {packages: ['corechart']});
		google.setOnLoadCallback(drawChart);

		function drawChart() {
		var data = google.visualization.arrayToDataTable([
				['<?=$chart_title?>', '회원수', '남', '여', '10대', '20대', '30대', '40대', '50대', '60대', '기타'],
				<?=$chart_data?>
		]);

		var options = {
			title: '회원 통계<?=$tot_state_str?><?=$payment_type_str?>',
			curveType: 'function',
			fontSize: 12,
			pointSize : 3,
			legend: { position: 'right'}
		};

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
		
		<?if($chart_data){?>
	        chart.draw(data, options);
		<?}?>
      }
    </script>

    <div id="curve_chart" style="width: 100%; height: 500px"></div>

	<div>
		<table class="list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<thead>
		<tr>
			<th scope="col"><?=$chart_title?></th>
			<th scope="col">회원수</th> 
			<th scope="col">남</th> 
			<th scope="col">여</th> 
			<th scope="col">10대</th>
			<th scope="col">20대</th>
			<th scope="col">30대</th>
			<th scope="col">40대</th>
			<th scope="col">50대</th>
			<th scope="col">60대</th>
			<th scope="col">기타</th>
		</tr>
		</thead>
		<tbody>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			unset($rows);
			$rows			= $row[$i];
			$rows[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			
			addComma($rows);
			zeroToEmpty($rows);
			extract($rows);
			?>

			<tr class="<?=$bg?>">
				<td class="td_50"><?=$date?></td>	
				<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
				<td class="td_50_right"><?=$rows[sum_mem1]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem2]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age1]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age2]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age3]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age4]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age5]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age6]?></td>	
				<td class="td_50_right"><?=$rows[sum_mem_age7]?></td>	
			</tr>
		<?	unset($rows);
			$idx--;
		}// 루프 끝?>

		</tbody>
		</table>
	</div>


</div>
<script type="text/javascript">
<!--
function month_move(thisMonth, type){

	lastMonth = new Date(Date.parse(thisMonth) - (30 * 1000 * 60 * 60 * 24));
	nextMonth = new Date(Date.parse(thisMonth) + (31 * 1000 * 60 * 60 * 24));
	thisMonth = new Date(thisMonth);
	//alert(nextMonth);
	if(type=="last"){
		document.fsearch.sdate.value = lastMonth.getFullYear() +"-"+ addzero(lastMonth.getMonth()+1) + "-01";
		document.fsearch.edate.value = lastMonth.getFullYear() +"-"+ addzero(lastMonth.getMonth()+1) + "-31";
	}else{
		document.fsearch.sdate.value = nextMonth.getFullYear() +"-"+ addzero(nextMonth.getMonth()+1) + "-01";
		document.fsearch.edate.value = nextMonth.getFullYear() +"-"+ addzero(nextMonth.getMonth()+1) + "-31";
	}
	document.fsearch.submit();
}

function last_month(month, e_month){
	document.fsearch.sdate.value = month;
	if(e_month)	document.fsearch.edate.value = e_month;
	document.fsearch.submit();
}

function addzero(n) {
	return n < 10 ? "0" + n : n;
}

function chart_choice(state){
	document.getElementById("chart_type").value		= state;
	document.fsearch.submit();
}
document.getElementById("chart_<?=$chart_type?>").className = "button_image40x24";
//-->
</script>
<!-- 매출 통계 끝  -->