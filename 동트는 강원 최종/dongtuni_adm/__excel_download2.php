<?
$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$table01		= BOARD_FILE_TABLE;

## 헤더설정

if($stype=="news")			$filename	= "DM_newsletter_".date("Y-m-d-H-i-s"); 
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
			<TD>우편번호</TD>
			<TD>주소</TD>
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
				<td align="center"><?=$rows[zipcode]?></td>
				<td align="center"> <?=$rows[addr1]?> <?=$rows[addr2]?></td>
			</tr>
		<?
			$idx--;
		}// 루프 끝?>
	</tbody>
	</table>
<?}?>