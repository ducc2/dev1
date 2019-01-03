<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
$table01			= SHOP_GOODS_TABLE;
$table02			= SHOP_GOODS_FILS_TABLE;
$table03			= SHOP_GOODS_OPT_TABLE;
$table04			= SHOP_CATEGORY_TABLE;
$table05			= SHOP_GOODS_ICON_TABLE;
// 1차 상품분류 가져오기
$row				= $DB->dfetcharr("SELECT depth1, cate_name FROM ".$table04." WHERE depth2='' AND depth3='' ORDER BY position ASC");
$rows				= key_value($row);

	$state		= "update";
	$row		= $DB->fetcharr("SELECT * FROM ".$table01." WHERE no='".$no."'");
	
	extract($row);

?>


				<table class="list-tb">
				<caption><?=$sh_title?></caption>
				<thead>
				<tr>
					<th scope="col">1차 상품분류</th>
					<th scope="col">2차 상품분류</th>
					<th scope="col">3차 상품분류</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<select name="select1" id="select1" size="12" style="width:200px;height:300px;" onclick="get_cate_style2_depth2()" class="input_box">
							<?=arrToption("sc", $rows, "", "");?>
						</select>
					</td>
					<td>
						<select name="select2" id="select2" size="12" style="width:200px;height:300px;" onclick="get_cate_style2_depth3()" class="input_box"></select>
					</td>
					<td>
						<select name="select3" id="select3" size="12" style="width:200px;height:300px;"></select>
					</td>
				</tr>	
				</tbody>
				</table>
					<script type="text/javascript">
						document.getElementById("select1").value = "<?=$cate_depth1?>";
						get_cate_style2_depth2();
						document.getElementById("select2").value = "<?=$cate_depth2?>";
						get_cate_style2_depth3();
						document.getElementById("select3").value = "<?=$cate_depth3?>";
					</script>

					</body>
</html>