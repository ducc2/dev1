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
        <tbody>        
		<tr>
            <th scope="row"><label for="goods_name">통계구분</label></th>
            <td>
				<input type='button' value='방문자' id='chart_visit' class='button_white60x24' onclick="chart_state_choice('visit');"> 
				<input type='button' value='아이피' id='chart_ip' class='button_white60x24' onclick="chart_state_choice('ip');">
				<input type='button' value='도메인' id='chart_host' class='button_white60x24' onclick="chart_state_choice('host');">
				<input type='button' value='키워드' id='chart_keyword' class='button_white60x24' onclick="chart_state_choice('keyword');">
				<input type='button' value='브라우저' id='chart_browser' class='button_white60x24' onclick="chart_state_choice('browser');">
				<input type="hidden" name="chart_state" id="chart_state" value="<?=$chart_state?>">
            </td>
        </tr>        
		<tr>
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
				<input type="button" value=" 엑셀생성 " class="btn_excel" onclick="document.location.href='__excel_download_visit.php?where=<?=$excel_whe?>&chart_state=<?=$chart_state?>&chart_type=<?=$chart_type?>&sdate=<?=$sdate?>&edate=<?=$edate?>&stype=visit'">
            </td>
        </tr>
		
        </tbody>
        </table>
		</form>
	</div>
	<div class="area_add"></div>
	<?if($chart_state=="ip" or $chart_state=="host" or $chart_state=="keyword" or $chart_state=="browser"){?>				
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
			var data = google.visualization.arrayToDataTable([
					['<?=$table_th_title?>' <?=$chart_x_axis?>],
					<?=$chart_data?>
			]);

			var options = {
				title: '<?=$table_th_title?> 통계<?=$tot_state_str?><?=$payment_type_str?>',
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
				<?if($chart_type=="week"){?>
					<tr>
						<th scope="col"><?=$table_th_title?></th>
						<th scope="col">합계</th> 
						<th scope="col">월요일</th> 
						<th scope="col">화요일</th> 
						<th scope="col">수요일</th> 
						<th scope="col">목요일</th> 
						<th scope="col">금요일</th> 
						<th scope="col">토요일</th> 
						<th scope="col">일요일</th> 
					</tr>
				<?}?> 
				<?if($chart_type=="hour"){?>
					<tr>
						<th scope="col"><?=$table_th_title?></th>
						<th scope="col">합계</th> 
						<th scope="col">1시</th> 
						<th scope="col">2시</th> 
						<th scope="col">3시</th> 
						<th scope="col">4시</th> 
						<th scope="col">5시</th> 
						<th scope="col">6시</th> 
						<th scope="col">7시</th> 
						<th scope="col">8시</th> 
						<th scope="col">9시</th> 
						<th scope="col">10시</th> 
						<th scope="col">11시</th> 
						<th scope="col">12시</th> 
						<th scope="col">13시</th> 
						<th scope="col">14시</th> 
						<th scope="col">15시</th> 
						<th scope="col">16시</th> 
						<th scope="col">17시</th> 
						<th scope="col">18시</th> 
						<th scope="col">19시</th> 
						<th scope="col">20시</th>
						<th scope="col">21시</th> 
						<th scope="col">22시</th> 
						<th scope="col">23시</th> 
						<th scope="col">24시</th>
					</tr>
				<?}?>
				<?if($chart_type=="day"){?>
					<tr>
						<th scope="col"><?=$table_th_title?></th>
						<th scope="col">합계</th> 
						<th scope="col">1일</th> 
						<th scope="col">2일</th> 
						<th scope="col">3일</th> 
						<th scope="col">4일</th> 
						<th scope="col">5일</th> 
						<th scope="col">6일</th> 
						<th scope="col">7일</th> 
						<th scope="col">8일</th> 
						<th scope="col">9일</th> 
						<th scope="col">10일</th> 
						<th scope="col">11일</th> 
						<th scope="col">12일</th> 
						<th scope="col">13일</th> 
						<th scope="col">14일</th> 
						<th scope="col">15일</th> 
						<th scope="col">16일</th> 
						<th scope="col">17일</th> 
						<th scope="col">18일</th> 
						<th scope="col">19일</th> 
						<th scope="col">20일</th>
						<th scope="col">21일</th> 
						<th scope="col">22일</th> 
						<th scope="col">23일</th> 
						<th scope="col">24일</th> 
						<th scope="col">25일</th> 
						<th scope="col">26일</th> 
						<th scope="col">27일</th> 
						<th scope="col">28일</th> 
						<th scope="col">29일</th> 
						<th scope="col">30일</th>  
						<th scope="col">31일</th> 
					</tr>
				<?}?>
				<?if($chart_type=="month"){?>
					<tr>
						<th scope="col"><?=$table_th_title?></th>
						<th scope="col">합계</th> 
						<th scope="col">1월</th> 
						<th scope="col">2월</th> 
						<th scope="col">3월</th> 
						<th scope="col">4월</th> 
						<th scope="col">5월</th> 
						<th scope="col">6월</th> 
						<th scope="col">7월</th> 
						<th scope="col">8월</th> 
						<th scope="col">9월</th> 
						<th scope="col">10월</th> 
						<th scope="col">11월</th> 
						<th scope="col">12월</th>  
					</tr>
				<?}?>
				<?if($chart_type=="year"){?>
					<tr>
						<th scope="col"><?=$table_th_title?></th>
						<th scope="col">합계</th> 
						<th scope="col"><?=$curr_year?>년</th> 
						<th scope="col"><?=$prev_year1?>년</th> 
						<th scope="col"><?=$prev_year2?>년</th> 
						<th scope="col"><?=$prev_year3?>년</th> 
						<th scope="col"><?=$prev_year4?>년</th> 
						<th scope="col"><?=$prev_year5?>년</th> 
					</tr>
				<?}?>
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
				
					<?if($chart_type=="week"){?>
						<td class="td_large20"><?=$chart_state_name?></td>	
						<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
						<td class="td_50_right"><?=$rows[sum_qty1]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty2]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty3]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty4]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty5]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty6]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty7]?></td>	
					<?}?> 

					<?if($chart_type=="hour"){?>
						<td class="td_large20"><?=$chart_state_name?></td>	
						<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
						<td class="td_50_right"><?=$rows[sum_qty1]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty2]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty3]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty4]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty5]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty6]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty7]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty8]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty9]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty10]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty11]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty12]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty13]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty14]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty15]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty16]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty17]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty18]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty19]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty20]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty21]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty22]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty23]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty24]?></td>

					<?}?>

					<?if($chart_type=="day"){?>
						<td class="td_large20"><?=$chart_state_name?></td>	
						<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
						<td class="td_50_right"><?=$rows[sum_qty1]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty2]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty3]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty4]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty5]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty6]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty7]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty8]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty9]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty10]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty11]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty12]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty13]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty14]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty15]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty16]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty17]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty18]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty19]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty20]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty21]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty22]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty23]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty24]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty25]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty26]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty27]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty28]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty29]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty30]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty31]?></td>	

					<?}?>

					
					<?if($chart_type=="month"){?>
						<td class="td_large20"><?=$chart_state_name?></td>	
						<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
						<td class="td_50_right"><?=$rows[sum_qty1]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty2]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty3]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty4]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty5]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty6]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty7]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty8]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty9]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty10]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty11]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty12]?></td>
					<?}?>
					
					<?if($chart_type=="year"){?>
						<td class="td_large20"><?=$chart_state_name?></td>	
						<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_total]?></span></td>
						<td class="td_50_right"><?=$rows[sum_qty]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty1]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty2]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty3]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty4]?></td>	
						<td class="td_50_right"><?=$rows[sum_qty5]?></td>	
					<?}?>
				</tr>
			<?	unset($rows);
				$idx--;
			}// 루프 끝?>

			</tbody>
			</table>
		</div>
	<?}else{?>				
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load('visualization', '1.1', {packages: ['corechart']});
			google.setOnLoadCallback(drawChart);

			function drawChart() {
			var data = google.visualization.arrayToDataTable([
					['<?=$chart_title?>', '방문자수'],
					<?=$chart_data?>
			]);

			var options = {
				title: '<?=$chart_title?> 통계<?=$tot_state_str?><?=$payment_type_str?>',
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
				<th scope="col">방문자수</th> 
				<th scope="col">퍼센트</th> 
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
					<td class="td_50_right"><span class="text_emphasis"><?=$rows[sum_visit1]?></span></td>
					<td class="td_50_right"><?=$rows[percent]?>%</td>	
				</tr>
			<?	unset($rows);
				$idx--;
			}// 루프 끝?>

			</tbody>
			</table>
		</div>

	<?}?>


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
	 

function chart_state_choice(state){
	document.getElementById("chart_state").value		= state;
	document.fsearch.submit();
}

function chart_choice(state){
	document.getElementById("chart_type").value		= state;
	document.fsearch.submit();
}
document.getElementById("chart_<?=$chart_type?>").className = "button_image40x24";
document.getElementById("chart_<?=$chart_state?>").className = "button_image60x24";
//-->
</script>
<!-- 매출 통계 끝  -->