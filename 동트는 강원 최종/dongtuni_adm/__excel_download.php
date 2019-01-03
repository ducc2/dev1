<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$table01		= BOARD_FILE_TABLE;

## 헤더설정

if($stype=="news")			$filename	= "newsletter_".date("Y-m-d-H-i-s"); 
if($stype=="statistic1")	$filename	= "매출통계-".date("Y-m-d-H-i-s"); 
excel_header($filename);
?>


<?
if($stype=="news"){
	$table01			= "newsletter_req";
	$swhere		= base64_decode($_GET[where]);

	$sql		= "SELECT a.* FROM ".$table01." a $swhere ORDER BY a.idx DESC";
	$row		= $DB->dfetcharr($sql);
	?>
	<style>
	table tr td { mso-number-format:"\@"; }
	</style>
	<table border="1" style="font-size:12px">
		<tr align="center" height="30" bgcolor="#ECF5FF">  
			<TD>NO</TD>
			<TD>이름</TD>
			<TD>직책</TD>
			<TD>전화번호</TD>
			<TD>이메일</TD>
			<TD>부수</TD>
			<TD>주소</TD>
			<TD>내용</TD>	
			<TD>신청동기</TD>
			<TD>해지여부</TD>
			<TD>등록일</TD>
			<TD>수정일</TD>
			<TD>구독내용</TD>
		</tr>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			$rows			= $row[$i];
			$order_goods	= "";
			$nen++;

			extract($rows);
			?>
			<tr>
				<td  align="center"><?=$nen?></td>
				<td align="center"><?=$rows[userNm]?></td>
				<td align="center"><?=$rows[position]?></td>
				<td align="center"><?=$rows[tel]?></td>
				<td align="center"><?=$rows[email]?></td>
				<td align="center"><?=$rows[snum]?></td>
				<td align="left">[<?=$rows[zipcode]?>] <?=$rows[addr1]?> <?=$rows[addr2]?></td>
				<td align="center"><?=$rows['etc']?></td>
				<td align="left"><?=$rows['req_motive']?></td>
				<td align="center"><?=$rows['cancelYn']?></td>
				<td align="left"><?=$rows['insertDttm']?></td>
				<td align="left"><?=$rows['updateDttm']?></td>
				<td align="center">
				<? if ( $rows['subscribeType']=='both') { ?>
				전체
				<? } else if ( $rows['subscribeType']=='online') { ?>
				온라인
				<? } else if ( $rows['subscribeType']=='offline') { ?>
				오프라인
				<? } ?>
				</td>
			</tr>
		<?
			$idx--;
		}// 루프 끝?>
	</tbody>
	</table>
<?}?>


<?
if($stype=="statistic1"){
	$table01		= SHOP_ORDER_TABLE;
	$table02		= SHOP_ORDER_GOODS_TABLE;
	$swhere			= base64_decode($where);
	$i				= 0;

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
		while ($loop_start <= $loop_end){
			if($chart_type=="hour"){
				$date_where	= "SUBSTRING(a.datetime, 12, 2)"; $where_value = sprintf("%02d", $loop_start); $chart_title	= "시간";
			}
			if($chart_type=="week"){
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
			$where_value		= ($chart_type=="week")	? get_week_str($loop_start, 2) : $where_value;
			$row[$i][date]		= $where_value;
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
			$row[$i][date]		= $where_value.$week_str;
			$loop_start			= date ("Y-m-d", strtotime("+1 ".$chart_type."", strtotime($loop_start)));
			$i++;
		}

	}
	?>
	<style>
	table tr td { mso-number-format:"\@"; }
	</style>
	<table border="1" style="font-size:12px">
		<tr align="center" height="30" bgcolor="#ECF5FF">
			<th><?=$chart_title?></th>
			<th>합계</th> 
			<th>무통장입금</th> 
			<th>신용카드</th> 
			<th>실시간계좌이체</th>
			<th>휴대폰결제</th>
			<th>가상계좌</th>
		</tr>

		<!-- 루프 시작 -->
		<?for($i=0;$i<sizeof($row);$i++){
			unset($rows);
			$rows			= $row[$i];
			$rows[idx]		= $idx;
			zeroToEmpty($rows);
			extract($rows);
			?>

			<tr>
				<td><?=$date?></td>	
				<td><?=$rows[sum_total]?></td>	
				<td><?=$rows[sum_pay1]?></td>	
				<td><?=$rows[sum_pay2]?></td>	
				<td><?=$rows[sum_pay3]?></td>	
				<td><?=$rows[sum_pay4]?></td>	
				<td><?=$rows[sum_pay5]?></td>	
			</tr>
		<?
			$idx--;
		}// 루프 끝?>
	</tbody>
	</table>
<?}?>