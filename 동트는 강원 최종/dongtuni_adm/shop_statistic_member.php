<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
if($mode<>"option_preview")	include_once("./_top.php");

$leftcode			= 8;
$include_file		= "statistic_member";
if($mode<>"option_preview")	include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "회원 통계";
$table01			= MEM_TABLE;

if(!$mode){
	if(!$sdate)				$sdate		= date("Y-m-d", strtotime('-1 month'));
	if(!$edate)				$edate		= date("Y-m-d");
	if(!$chart_type)		$chart_type	= "day";
	
	
	if($sdate and $edate)	$where[]	= "a.mem_datetime >= '$sdate' AND a.mem_datetime <= '$edate' ";
	if($tot_state){
		$where[]			= "a.tot_state = '$tot_state'";
		$tot_state_str		= " [ ".goods_order_state($tot_state, 1) . " ] ";
	}else{
		//$where[]			= "a.tot_state IN(11)";
	}
	if($payment_type){
		$where[]			= "a.payment_type = '$payment_type'";
		$payment_type_str	= " [ ".get_payment_type($payment_type, 1) . " ] ";
	}

	if($where)				$swhere  = " WHERE ".implode(" AND ", $where);	

	
	$day_1		= date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d"))));
	$day_7		= date("Y-m-d", strtotime("-7 day", strtotime(date("Y-m-d"))));
	$day_31		= date("Y-m-d", strtotime("-1 month", strtotime(date("Y-m-d"))));
	$day_90		= date("Y-m-d", strtotime("-3 month", strtotime(date("Y-m-d"))));
	$day_180	= date("Y-m-d", strtotime("-6 month", strtotime(date("Y-m-d"))));
	$day_365	= date("Y-m-d", strtotime("-1 year", strtotime(date("Y-m-d"))));
	$today		= date("Y-m-d");
	$i			= 0;

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

	if($chart_type=="hour" or $chart_type=="week"){

		// 매출 합계
		while ($loop_start <= $loop_end) {
			if($chart_type=="hour")		{
				$date_where	= "SUBSTRING(a.mem_datetime, 12, 2)"; $where_value = sprintf("%02d", $loop_start); $chart_title	= "시간";
			}
			if($chart_type=="week")		{
				$date_where	= "WEEKDAY(mem_datetime)"; $where_value = $loop_start; $chart_title	= "요일";
			}			

			$sql		= "SELECT 
							".$date_where." date,  
							COUNT(*) sum_total, 
							SUM(IF(a.gender='1', 1, 0)) sum_mem1, 
							SUM(IF(a.gender='2', 1, 0)) sum_mem2, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '10' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '20', 1, 0)) sum_mem_age1,
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '20' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '30', 1, 0)) sum_mem_age2, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '30' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '40', 1, 0)) sum_mem_age3, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '40' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '50', 1, 0)) sum_mem_age4, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '50' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '60', 1, 0)) sum_mem_age5, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '60' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '70', 1, 0)) sum_mem_age6, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '70', 1, 0)) sum_mem_age7
							FROM ".$table01." a $swhere AND ".$date_where."= '".$where_value."' GROUP BY date ";

			$row[]				= $DB->fetcharr($sql."ORDER BY date DESC");	
			$chart[]			= $DB->fetcharr($sql."ORDER BY date ASC");		
			$where_value		= ($chart_type=="week")	? get_week_str($loop_start, 2) : $where_value;
			$row[$i][date]		= $where_value;
			$chart[$i][date]	= $where_value;
			$loop_start++;
			$i++;
		}
	}else{

		// 매출 합계
		while (strtotime($loop_start) <= strtotime($loop_end)) {
			if($chart_type=="day"){
				$date_where	= "SUBSTRING(a.mem_datetime, 1, 10)"; $where_value = substr($loop_start, 0, 10);	$week_str	= get_week_str(date('w', strtotime($loop_start)));  $chart_title	= "날짜";
			}
			if($chart_type=="month"){
				$date_where	= "SUBSTRING(a.mem_datetime, 1, 7)";  $where_value = substr($loop_start, 0, 7); $chart_title	= "월";
			}
			if($chart_type=="year"){
				$date_where	= "SUBSTRING(a.mem_datetime, 1, 4)";  $where_value = substr($loop_start, 0, 4); $chart_title	= "년";
			}
			$sql		= "SELECT 
							".$date_where." date, 
							COUNT(*) sum_total, 
							SUM(IF(a.gender='1', 1, 0)) sum_mem1, 
							SUM(IF(a.gender='2', 1, 0)) sum_mem2, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '10' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '20', 1, 0)) sum_mem_age1,
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '20' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '30', 1, 0)) sum_mem_age2, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '30' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '40', 1, 0)) sum_mem_age3, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '40' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '50', 1, 0)) sum_mem_age4, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '50' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '60', 1, 0)) sum_mem_age5, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '60' AND DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y < '70', 1, 0)) sum_mem_age6, 
							SUM(IF(DATE_FORMAT(CURDATE(), '%Y') - a.mem_birth_y >= '70', 1, 0)) sum_mem_age7
							FROM ".$table01." a $swhere AND ".$date_where."= '".$where_value."' GROUP BY date ";

			$row[]				= $DB->fetcharr($sql."ORDER BY date DESC");	
			$chart[]			= $DB->fetcharr($sql."ORDER BY date ASC");		
			$row[$i][date]		= $where_value.$week_str;
			$chart[$i][date]	= $where_value;
			$loop_start			= date ("Y-m-d", strtotime("+1 ".$chart_type."", strtotime($loop_start)));
			$i++;
		}

	}

	$excel_whe	= base64_encode($swhere);

	// 차트 데이터 생성
	for($i=0;$i<sizeof($chart);$i++){
		$charts			= $chart[$i];
		if(!$charts[sum_total])		$charts[sum_total]	= 0;
		if(!$charts[sum_mem1])		$charts[sum_mem1]	= 0;
		if(!$charts[sum_mem2])		$charts[sum_mem2]	= 0;
		if(!$charts[sum_mem_age1])	$charts[sum_mem_age1]	= 0;
		if(!$charts[sum_mem_age2])	$charts[sum_mem_age2]	= 0;
		if(!$charts[sum_mem_age3])	$charts[sum_mem_age3]	= 0;
		if(!$charts[sum_mem_age4])	$charts[sum_mem_age4]	= 0;
		if(!$charts[sum_mem_age5])	$charts[sum_mem_age5]	= 0;
		if(!$charts[sum_mem_age6])	$charts[sum_mem_age6]	= 0;
		if(!$charts[sum_mem_age7])	$charts[sum_mem_age7]	= 0;

		$chart_data		.= "['".$charts[date]."',  ".$charts[sum_total].",   ".$charts[sum_mem1].",  ".$charts[sum_mem2].",  ".$charts[sum_mem_age1].",  ".$charts[sum_mem_age2].",  ".$charts[sum_mem_age3].",  ".$charts[sum_mem_age4].",  ".$charts[sum_mem_age5].",  ".$charts[sum_mem_age6].",  ".$charts[sum_mem_age7]."],";

	}
	$chart_data		= substr($chart_data, 0, strlen($chart_data)-1);

	include_once("./shop_".$include_file."_chart.php");
}

if($mode<>"option_preview")	include_once("./_bottom.php");
?>
