<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
if($mode<>"option_preview")	include_once("./_top.php");

$leftcode			= 8;
$include_file		= "statistic_goods";
if($mode<>"option_preview")	include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "게시물 통계";
$table01			= SHOP_ORDER_TABLE;
$table02			= SHOP_ORDER_GOODS_TABLE;
$table03			= SHOP_GOODS_FILS_TABLE;
$table04			= SHOP_ORDER_PG_TABLE;

$updir				= DATA_PATH."goods/img/";
$thumb_dir			= DATA_PATH."goods/thumb/admin/";
$upUrl				= "../data/goods/img/";

if(!$mode){
	if(!$sdate)				$sdate		= date("Y")."-01-01";
	if(!$edate)				$edate		= date("Y-m-d");
	if(!$chart_type)		$chart_type	= "month";
	
	
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

			
	if($chart_type=="week"){
		$where_value = substr($loop_start, 0, 7);
		
		$sql		= "SELECT 
					a.goods_name, a.goods_no,
					SUM(a.order_qty) sum_total, 
					SUM(IF(WEEKDAY(datetime)='0', a.order_qty,0)) sum_qty1, 
					SUM(IF(WEEKDAY(datetime)='1', a.order_qty,0)) sum_qty2, 
					SUM(IF(WEEKDAY(datetime)='2', a.order_qty,0)) sum_qty3, 
					SUM(IF(WEEKDAY(datetime)='3', a.order_qty,0)) sum_qty4, 
					SUM(IF(WEEKDAY(datetime)='4', a.order_qty,0)) sum_qty5, 
					SUM(IF(WEEKDAY(datetime)='5', a.order_qty,0)) sum_qty6, 
					SUM(IF(WEEKDAY(datetime)='6', a.order_qty,0)) sum_qty7
					FROM ".$table02." a $swhere GROUP BY a.goods_no "; //echo $sql."<br>";
	}
	if($chart_type=="day"){
		$where_value = substr($loop_start, 0, 10); 
		$sql		= "SELECT 
					a.goods_name, a.goods_no,
					SUM(a.order_qty) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='01', a.order_qty,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='02', a.order_qty,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='03', a.order_qty,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='04', a.order_qty,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='05', a.order_qty,0)) sum_qty5, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='06', a.order_qty,0)) sum_qty6, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='07', a.order_qty,0)) sum_qty7, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='08', a.order_qty,0)) sum_qty8, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='09', a.order_qty,0)) sum_qty9, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='10', a.order_qty,0)) sum_qty10, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='11', a.order_qty,0)) sum_qty11, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='12', a.order_qty,0)) sum_qty12, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='13', a.order_qty,0)) sum_qty13, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='14', a.order_qty,0)) sum_qty14, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='15', a.order_qty,0)) sum_qty15, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='16', a.order_qty,0)) sum_qty16, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='17', a.order_qty,0)) sum_qty17, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='18', a.order_qty,0)) sum_qty18, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='19', a.order_qty,0)) sum_qty19, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='20', a.order_qty,0)) sum_qty20, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='21', a.order_qty,0)) sum_qty21, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='22', a.order_qty,0)) sum_qty22, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='23', a.order_qty,0)) sum_qty23, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='24', a.order_qty,0)) sum_qty24, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='25', a.order_qty,0)) sum_qty25, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='26', a.order_qty,0)) sum_qty26, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='27', a.order_qty,0)) sum_qty27, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='28', a.order_qty,0)) sum_qty28, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='29', a.order_qty,0)) sum_qty29, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='30', a.order_qty,0)) sum_qty30, 
					SUM(IF(SUBSTRING(a.datetime, 9, 2)='31', a.order_qty,0)) sum_qty31
					FROM ".$table02." a $swhere GROUP BY a.goods_no "; //echo $sql."<br>";
	}
	if($chart_type=="month"){
		$where_value = substr($loop_start, 0, 7);
		
		$sql		= "SELECT 
					a.goods_name, a.goods_no,
					SUM(a.order_qty) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='01', a.order_qty,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='02', a.order_qty,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='03', a.order_qty,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='04', a.order_qty,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='05', a.order_qty,0)) sum_qty5, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='06', a.order_qty,0)) sum_qty6, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='07', a.order_qty,0)) sum_qty7, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='08', a.order_qty,0)) sum_qty8, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='09', a.order_qty,0)) sum_qty9, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='10', a.order_qty,0)) sum_qty10, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='11', a.order_qty,0)) sum_qty11, 
					SUM(IF(SUBSTRING(a.datetime, 6, 2)='12', a.order_qty,0)) sum_qty12  
					FROM ".$table02." a $swhere GROUP BY a.goods_no "; //echo $sql."<br>";
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
					a.goods_name, a.goods_no,
					SUM(a.order_qty) sum_total, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$curr_year."', a.order_qty,0)) sum_qty, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year1."', a.order_qty,0)) sum_qty1, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year2."', a.order_qty,0)) sum_qty2, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year3."', a.order_qty,0)) sum_qty3, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year4."', a.order_qty,0)) sum_qty4, 
					SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$prev_year5."', a.order_qty,0)) sum_qty5   
					FROM ".$table02." a $swhere GROUP BY a.goods_no "; //echo $sql."<br>";
	}

	$row				= $DB->dfetcharr($sql."ORDER BY sum_total DESC LIMIT 0, 50");	
	$chart				= $DB->dfetcharr($sql."ORDER BY sum_total DESC LIMIT 0, 10");
	$chart[$i][date]	= $where_value;
	$i++;

	$excel_whe	= base64_encode($swhere);

	for($i=0;$i<sizeof($chart);$i++){
		$charts				= $chart[$i];
		$chart_x_axis		.= ", '".text_cut_kr($charts[goods_name], 16)."'";
	}
	
	if($chart_type=="day"){
		// 차트 데이터 생성
		for($j=0;$j<31;$j++){
			$sql_month		= sprintf("%02d", ($j+1));
			$chart_data		.= "['".$sql_month."'";
			for($i=0;$i<sizeof($chart);$i++){
				$charts				= $chart[$i];

				$sql		= "SELECT SUM(a.order_qty) sum_total, SUM(IF(SUBSTRING(a.datetime, 9, 2)='".$sql_month."', a.order_qty,0)) sum_qty FROM ".$table02." a $swhere AND a.goods_no='".$charts[goods_no]."'";
				$goods_row	= $DB->fetcharr($sql);

				if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
				if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
				$chart_data			.= ", ".$goods_row[sum_qty]."";
			}		
			$chart_data			.= "],\n";
		}
	}

	if($chart_type=="month"){
		// 차트 데이터 생성
		for($j=0;$j<12;$j++){
			$sql_month		= sprintf("%02d", ($j+1));
			$chart_data		.= "['".$sql_month."'";
			for($i=0;$i<sizeof($chart);$i++){
				$charts				= $chart[$i];

				$sql		= "SELECT SUM(a.order_qty) sum_total, SUM(IF(SUBSTRING(a.datetime, 6, 2)='".$sql_month."', a.order_qty,0)) sum_qty FROM ".$table02." a $swhere AND a.goods_no='".$charts[goods_no]."'";
				$goods_row	= $DB->fetcharr($sql);

				if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
				if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
				$chart_data			.= ", ".$goods_row[sum_qty]."";
			}		
			$chart_data			.= "],\n";
		}
	}

	if($chart_type=="year"){
		// 차트 데이터 생성
		for($j=$prev_year5;$j<$curr_year+1;$j++){
			$chart_data		.= "['".$j."'";
			for($i=0;$i<sizeof($chart);$i++){
				$charts				= $chart[$i];

				$sql		= "SELECT SUM(a.order_qty) sum_total, SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$j."', a.order_qty,0)) sum_qty FROM ".$table02." a $swhere AND a.goods_no='".$charts[goods_no]."'";
				$goods_row	= $DB->fetcharr($sql);

				if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
				if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
				$chart_data			.= ", ".$goods_row[sum_qty]."";
			}		
			$chart_data			.= "],\n";
		}
	}

	if($chart_type=="week"){
		// 차트 데이터 생성
		for($j=0;$j<7;$j++){
			$week_str		= get_week_str($j, 2);
			$chart_data		.= "['".$week_str."'";
			for($i=0;$i<sizeof($chart);$i++){
				$charts				= $chart[$i];

				$sql		= "SELECT SUM(a.order_qty) sum_total, SUM(IF(WEEKDAY(datetime)='".$j."', a.order_qty,0)) sum_qty FROM ".$table02." a $swhere AND a.goods_no='".$charts[goods_no]."'";
				$goods_row	= $DB->fetcharr($sql);

				if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
				if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
				$chart_data			.= ", ".$goods_row[sum_qty]."";
			}		
			$chart_data			.= "],\n";
		}
	}



	$chart_data		= substr($chart_data, 0, strlen($chart_data)-2);

	include_once("./shop_".$include_file."_chart.php");
}

if($mode<>"option_preview")	include_once("./_bottom.php");
?>
