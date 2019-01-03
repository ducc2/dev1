<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
if($mode<>"option_preview")	include_once("./_top.php");

$leftcode			= 8;
$include_file		= "statistic_visit";
if($mode<>"option_preview")	include_once("./_left.php");

$DB					= new database;
$referer			= prevpage();
$sh_title			= "방문 통계";
$table01			= SHOP_VISIT_TABLE;

$updir				= DATA_PATH."goods/img/";
$thumb_dir			= DATA_PATH."goods/thumb/admin/";
$upUrl				= "../data/goods/img/";

if(!$mode){
	if(!$sdate)				$sdate			= date("Y-m-d", strtotime('-1 month'));
	if(!$edate)				$edate			= date("Y-m-d");
	if(!$chart_type)		$chart_type		= "day";
	if(!$chart_state)		$chart_state	= "visit";
	
	
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

	if($chart_state=="ip")		$table_th_title	= "아이피";
	if($chart_state=="host")	$table_th_title	= "도메인";
	if($chart_state=="keyword")	$table_th_title	= "키워드";
	if($chart_state=="browser")	$table_th_title	= "브라우저";
	if($chart_state=="visit")	$table_th_title	= "방문자";

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

		$excel_whe	= base64_encode($swhere." ".$sub_where);


		// 
		// 차트 데이터 생성 시작
		// 
		for($i=0;$i<sizeof($chart);$i++){
			$charts				= $chart[$i];
			$chart_x_axis		.= ", '".text_cut_kr($charts[chart_state_name], 16)."'";
		}
		
		if($chart_type=="hour"){
			// 차트 데이터 생성
			for($j=0;$j<24;$j++){
				$sql_month		= sprintf("%02d", ($j+1));
				$chart_data		.= "['".$sql_month."'";
				for($i=0;$i<sizeof($chart);$i++){
					$charts				= $chart[$i];

					$sql		= "SELECT COUNT(*) sum_total, SUM(IF(SUBSTRING(a.datetime, 12, 2)='".$sql_month."', 1,0)) sum_qty FROM ".$table01." a $swhere $sub_where AND a.".$chart_state."='".$charts[chart_state_name]."'";
					$goods_row	= $DB->fetcharr($sql);

					if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
					if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
					$chart_data			.= ", ".$goods_row[sum_qty]."";
				}		
				$chart_data			.= "],\n";
			}
		}
		
		if($chart_type=="day"){
			// 차트 데이터 생성
			for($j=0;$j<31;$j++){
				$sql_month		= sprintf("%02d", ($j+1));
				$chart_data		.= "['".$sql_month."'";
				for($i=0;$i<sizeof($chart);$i++){
					$charts				= $chart[$i];

					$sql		= "SELECT COUNT(*) sum_total, SUM(IF(SUBSTRING(a.datetime, 9, 2)='".$sql_month."', 1,0)) sum_qty FROM ".$table01." a $swhere $sub_where AND a.".$chart_state."='".$charts[chart_state_name]."'";
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

					$sql		= "SELECT COUNT(*) sum_total, SUM(IF(SUBSTRING(a.datetime, 6, 2)='".$sql_month."', 1,0)) sum_qty FROM ".$table01." a $swhere $sub_where AND a.".$chart_state."='".$charts[chart_state_name]."'";
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

					$sql		= "SELECT COUNT(*) sum_total, SUM(IF(SUBSTRING(a.datetime, 1, 4)='".$j."', 1,0)) sum_qty FROM ".$table01." a $swhere $sub_where AND a.".$chart_state."='".$charts[chart_state_name]."'";
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

					$sql		= "SELECT COUNT(*) sum_total, SUM(IF(WEEKDAY(datetime)='".$j."', 1,0)) sum_qty FROM ".$table01." a $swhere $sub_where AND a.".$chart_state."='".$charts[chart_state_name]."'";
					$goods_row	= $DB->fetcharr($sql);

					if(!$goods_row[sum_total])		$goods_row[sum_total]	= 0;
					if(!$goods_row[sum_qty1])		$goods_row[sum_qty1]	= 0;
					$chart_data			.= ", ".$goods_row[sum_qty]."";
				}		
				$chart_data			.= "],\n";
			}
		}



		$chart_data		= substr($chart_data, 0, strlen($chart_data)-2);



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

		$excel_whe	= base64_encode($swhere);

		// 차트 데이터 생성
		for($i=0;$i<sizeof($chart);$i++){
			$charts			= $chart[$i];
			if(!$charts[sum_visit1])	$charts[sum_visit1]	= 0;
			if(!$charts[percent])		$charts[percent]	= 0;
			$chart_data		.= "['".$charts[date]."',  ".$charts[sum_visit1]."],";

		}
		$chart_data		= substr($chart_data, 0, strlen($chart_data)-1);

	}

	include_once("./shop_".$include_file."_chart.php");
}

if($mode<>"option_preview")	include_once("./_bottom.php");
?>
