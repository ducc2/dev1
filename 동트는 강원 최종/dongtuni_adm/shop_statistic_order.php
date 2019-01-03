<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
if($mode<>"option_preview")	include_once("./_top.php");

$leftcode			= 8;
$include_file		= "statistic_order";
if($mode<>"option_preview")	include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "매출 통계";
$table01			= SHOP_ORDER_TABLE;
$table02			= SHOP_ORDER_GOODS_TABLE;
$table03			= SHOP_GOODS_FILS_TABLE;
$table04			= SHOP_ORDER_PG_TABLE;

$updir				= DATA_PATH."goods/img/";
$thumb_dir			= DATA_PATH."goods/thumb/admin/";
$upUrl				= "../data/goods/img/";

if(!$mode){
	if(!$sdate)				$sdate		= date("Y-m-d", strtotime('-1 month'));
	if(!$edate)				$edate		= date("Y-m-d");
	if(!$chart_type)		$chart_type	= "day";
	
	
	if($sdate and $edate)	$where[]	= "a.datetime >= '$sdate' AND a.datetime <= '$edate 23:59:59' ";
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
				$date_where	= "SUBSTRING(a.datetime, 12, 2)"; $where_value = sprintf("%02d", $loop_start); $chart_title	= "시간";
			}
			if($chart_type=="week")		{
				$date_where	= "WEEKDAY(datetime)"; $where_value = $loop_start; $chart_title	= "요일";
			}			

			$sql		= "SELECT 
							".$date_where." date, 
							SUM(a.payment_money) sum_total, 
							SUM(IF(a.payment_type='1', a.payment_money,0)) sum_pay1, 
							SUM(IF(a.payment_type='2', a.payment_money,0)) sum_pay2, 
							SUM(IF(a.payment_type='3', a.payment_money,0)) sum_pay3, 
							SUM(IF(a.payment_type='4', a.payment_money,0)) sum_pay4, 
							SUM(IF(a.payment_type='5', a.payment_money,0)) sum_pay5 
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
							SUM(a.payment_money) sum_total, 
							SUM(IF(a.payment_type='1', a.payment_money,0)) sum_pay1, 
							SUM(IF(a.payment_type='2', a.payment_money,0)) sum_pay2, 
							SUM(IF(a.payment_type='3', a.payment_money,0)) sum_pay3, 
							SUM(IF(a.payment_type='4', a.payment_money,0)) sum_pay4, 
							SUM(IF(a.payment_type='5', a.payment_money,0)) sum_pay5 
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
		if(!$charts[sum_pay1])		$charts[sum_pay1]	= 0;
		if(!$charts[sum_pay2])		$charts[sum_pay2]	= 0;
		if(!$charts[sum_pay3])		$charts[sum_pay3]	= 0;
		if(!$charts[sum_pay4])		$charts[sum_pay4]	= 0;
		if(!$charts[sum_pay5])		$charts[sum_pay5]	= 0;
		$chart_data		.= "['".$charts[date]."',  ".$charts[sum_total].",   ".$charts[sum_pay1].",  ".$charts[sum_pay2].",  ".$charts[sum_pay3].",  ".$charts[sum_pay4].",  ".$charts[sum_pay5]."],";

	}
	$chart_data		= substr($chart_data, 0, strlen($chart_data)-1);

	include_once("./shop_".$include_file."_chart.php");
}

if($mode<>"option_preview")	include_once("./_bottom.php");
?>
