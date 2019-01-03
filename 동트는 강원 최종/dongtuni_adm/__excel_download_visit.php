<?
$sh["rPath"]	= "..";
include_once("../_common.php");
$table01		= SHOP_VISIT_TABLE;
$swhere			= base64_decode($where);
$i				= 0;

## 헤더설정

if($chart_state=="ip")		$table_th_title	= "아이피";
if($chart_state=="host")	$table_th_title	= "도메인";
if($chart_state=="keyword")	$table_th_title	= "키워드";
if($chart_state=="browser")	$table_th_title	= "브라우저";
if($chart_state=="visit")	$table_th_title	= "방문자";

if($stype=="visit")	$filename	= "visit_".date("Y-m-d-H-i-s"); 
excel_header($filename);





if($chart_type=="hour"){
	$loop_start	= 1;
	$loop_end	= 24;
}else if($chart_type=="week"){
	$loop_start	= 0;
	$loop_end	= 6;
}else{
	$loop_start	= $sdate;
	$loop_end	= $edate;
}


if($chart_state=="ip" or $chart_state=="host" or $chart_state=="keyword" or $chart_state=="browser"){

	if($chart_state=="host" or $chart_state=="keyword" ){
		$sub_where	= " AND a.".$chart_state."<>''";	
	}
	//
	// 도메인, 키워드, 브라우저 통계
	//
	if($chart_type=="week"){
		$where_value = substr($loop_start, 0, 7);
		
		$sql		= "SELECT 
					a.".$chart_state." chart_state_name, 
					COUNT(*) sum_total, 
					SUM(IF(WEEKDAY(datetime)='0', 1,0)) sum_qty1, 
					SUM(IF(WEEKDAY(datetime)='1', 1,0)) sum_qty2, 
					SUM(IF(WEEKDAY(datetime)='2', 1,0)) sum_qty3, 
					SUM(IF(WEEKDAY(datetime)='3', 1,0)) sum_qty4, 
					SUM(IF(WEEKDAY(datetime)='4', 1,0)) sum_qty5, 
					SUM(IF(WEEKDAY(datetime)='5', 1,0)) sum_qty6, 
					SUM(IF(WEEKDAY(datetime)='6', 1,0)) sum_qty7
					FROM ".$table01." a $swhere $sub_where GROUP BY a.".$chart_state." "; //echo $sql."<br>";
	}
	
	if($chart_type=="hour"){
		$where_value = sprintf("%02d", $loop_start); 
		$sql		= "SELECT 
					a.".$chart_state." chart_state_name, 
					COUNT(*) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='01', 1,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='02', 1,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='03', 1,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='04', 1,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='05', 1,0)) sum_qty5, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='06', 1,0)) sum_qty6, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='07', 1,0)) sum_qty7, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='08', 1,0)) sum_qty8, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='09', 1,0)) sum_qty9, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='10', 1,0)) sum_qty10, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='11', 1,0)) sum_qty11, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='12', 1,0)) sum_qty12, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='13', 1,0)) sum_qty13, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='14', 1,0)) sum_qty14, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='15', 1,0)) sum_qty15, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='16', 1,0)) sum_qty16, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='17', 1,0)) sum_qty17, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='18', 1,0)) sum_qty18, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='19', 1,0)) sum_qty19, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='20', 1,0)) sum_qty20, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='21', 1,0)) sum_qty21, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='22', 1,0)) sum_qty22, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='23', 1,0)) sum_qty23, 
					SUM(IF(SUBSTRING(a.datetime, 12, 2)='24', 1,0)) sum_qty24
					FROM ".$table01." a $swhere $sub_where GROUP BY a.".$chart_state." "; //echo $sql."<br>";
	}

	if($chart_type=="day"){
		$where_value = substr($loop_start, 0, 10); 
		$sql		= "SELECT 
					a.".$chart_state." chart_state_name, 
					COUNT(*) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='01', 1,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='02', 1,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='03', 1,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='04', 1,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='05', 1,0)) sum_qty5, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='06', 1,0)) sum_qty6, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='07', 1,0)) sum_qty7, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='08', 1,0)) sum_qty8, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='09', 1,0)) sum_qty9, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='10', 1,0)) sum_qty10, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='11', 1,0)) sum_qty11, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='12', 1,0)) sum_qty12, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='13', 1,0)) sum_qty13, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='14', 1,0)) sum_qty14, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='15', 1,0)) sum_qty15, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='16', 1,0)) sum_qty16, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='17', 1,0)) sum_qty17, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='18', 1,0)) sum_qty18, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='19', 1,0)) sum_qty19, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='20', 1,0)) sum_qty20, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='21', 1,0)) sum_qty21, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='22', 1,0)) sum_qty22, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='23', 1,0)) sum_qty23, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='24', 1,0)) sum_qty24, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='25', 1,0)) sum_qty25, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='26', 1,0)) sum_qty26, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='27', 1,0)) sum_qty27, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='28', 1,0)) sum_qty28, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='29', 1,0)) sum_qty29, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='30', 1,0)) sum_qty30, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='31', 1,0)) sum_qty31
					FROM ".$table01." a $swhere $sub_where GROUP BY a.".$chart_state." "; //echo $sql."<br>";
	}
	if($chart_type=="month"){
		$where_value = substr($loop_start, 0, 7);
		
		$sql		= "SELECT 
					a.".$chart_state." chart_state_name, 
					COUNT(*) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='01', 1,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='02', 1,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='03', 1,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='04', 1,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='05', 1,0)) sum_qty5, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='06', 1,0)) sum_qty6, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='07', 1,0)) sum_qty7, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='08', 1,0)) sum_qty8, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='09', 1,0)) sum_qty9, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='10', 1,0)) sum_qty10, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='11', 1,0)) sum_qty11, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='12', 1,0)) sum_qty12  
					FROM ".$table01." a $swhere $sub_where GROUP BY a.".$chart_state." "; //echo $sql."<br>";
	}
	if($chart_type=="year"){
		$where_value = substr($loop_start, 0, 4);
		$curr_year	 = date("Y");
		$prev_year1	 = date("Y", strtotime("-1 year", strtotime(date("Y-m-d")))); 
		$prev_year2	 = date("Y", strtotime("-2 year", strtotime(date("Y-m-d"))));
		$prev_year3	 = date("Y", strtotime("-3 year", strtotime(date("Y-m-d"))));
		$prev_year4	 = date("Y", strtotime("-4 year", strtotime(date("Y-m-d"))));
		$prev_year5	 = date("Y", strtotime("-5 year", strtotime(date("Y-m-d"))));
		
		$sql		= "SELECT 
					a.".$chart_state." chart_state_name, 
					COUNT(*) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$curr_year."', 1,0)) sum_qty, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year1."', 1,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year2."', 1,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year3."', 1,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year4."', 1,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year5."', 1,0)) sum_qty5   
					FROM ".$table01." a $swhere $sub_where GROUP BY a.".$chart_state." "; //echo $sql."<br>";
	}

	$row				= $DB->dfetcharr($sql."ORDER BY sum_total DESC LIMIT 0, 50");	
	$chart				= $DB->dfetcharr($sql."ORDER BY sum_total DESC LIMIT 0, 10");
	$chart[$i][date]	= $where_value;
	$i++;

}else{

	//
	// 방문자 통계
	//
	if($chart_type=="hour" or $chart_type=="week"){

		// 방문 합계
		while ($loop_start <= $loop_end) {
			if($chart_type=="hour")		{
				$date_where	= "SUBSTRING(a.datetime, 12, 2)"; $where_value = sprintf("%02d", $loop_start); $chart_title	= "시간";
			}
			if($chart_type=="week")		{
				$date_where	= "WEEKDAY(datetime)"; $where_value = $loop_start; $chart_title	= "요일";
			}			

			$sql		= "SELECT 
							".$date_where." date, 
							(SELECT COUNT(*) FROM ".$table01." a $swhere) sum_total, 
							SUM(IF(".$date_where."='".$where_value."', 1, 0)) sum_visit1,
							ROUND((SUM(IF(".$date_where."='".$where_value."', 1, 0)) / (SELECT COUNT(*) FROM ".$table01." a $swhere) * 100), 0) percent
							FROM ".$table01." a $swhere AND ".$date_where."= '".$where_value."' GROUP BY date "; //ECHO $sql;exit;

			$row[]				= $DB->fetcharr($sql."ORDER BY date DESC");	
			$chart[]			= $DB->fetcharr($sql."ORDER BY date ASC");		
			$where_value		= ($chart_type=="week")	? get_week_str($loop_start, 2) : $where_value;
			$row[$i][date]		= $where_value;
			$chart[$i][date]	= $where_value;
			$loop_start++;
			$i++;
		}
	}else{

		// 방문 합계
		while (strtotime($loop_start) <= strtotime($loop_end)) {
			if($chart_type=="day"){
				$date_where	= "SUBSTRING(a.datetime, 1, 10)"; $where_value = substr($loop_start, 0, 10);	$week_str	= get_week_str(date('w', strtotime($loop_start)));  $chart_title	= "날짜";
			}
			if($chart_type=="month"){
				$date_where	= "SUBSTRING(a.datetime, 1, 7)";  $where_value = substr($loop_start, 0, 7); $chart_title	= "월";
			}
			if($chart_type=="year"){
				$date_where	= "SUBSTRING(a.datetime, 1, 4)";  $where_value = substr($loop_start, 0, 4); $chart_title	= "년";
			}
			$sql		= "SELECT 
							".$date_where." date, 
							(SELECT COUNT(*) FROM ".$table01." a $swhere) sum_total, 
							SUM(IF(".$date_where."='".$where_value."', 1, 0)) sum_visit1,
							ROUND((SUM(IF(".$date_where."='".$where_value."', 1, 0)) / (SELECT COUNT(*) FROM ".$table01." a $swhere) * 100), 0) percent
							FROM ".$table01." a $swhere AND ".$date_where."= '".$where_value."' GROUP BY date "; //ECHO $sql."<br>";exit;

			$row[]				= $DB->fetcharr($sql."ORDER BY date DESC");	
			$chart[]			= $DB->fetcharr($sql."ORDER BY date ASC");		
			$row[$i][date]		= $where_value.$week_str;
			$chart[$i][date]	= $where_value;
			$loop_start			= date ("Y-m-d", strtotime("+1 ".$chart_type."", strtotime($loop_start)));
			$i++;
		}

	}
}

?>


<?if($chart_state=="ip" or $chart_state=="host" or $chart_state=="keyword" or $chart_state=="browser"){?>	
	<style>
	table tr td { mso-number-format:"\@"; }
	</style>
	<table border="1" style="font-size:12px">
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

	</table>
<?}else{?>	
	<style>
	table tr td { mso-number-format:"\@"; }
	</style>
	<table border="1" style="font-size:12px">
	<thead>
	<tr>
		<th scope="col"><?=$chart_title?></th>
		<th scope="col">방문자수</th> 
		<th scope="col">퍼센트</th> 
	</tr>
	</thead>

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
			<td class="td_50_right"><?=$rows[percent]?></td>	
		</tr>
	<?	unset($rows);
		$idx--;
	}// 루프 끝?>

	</table>
<?}?>
