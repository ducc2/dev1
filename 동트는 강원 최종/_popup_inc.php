<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>
<?

// 상단 고정 팝업 열기
$pup_sql	= "SELECT *, SUBSTRING_INDEX( pop_img, '|', -1 ) pop_img FROM ".SHOP_POPUP_TABLE." WHERE '".date("Y-m-d")."' BETWEEN pop_sdate AND pop_edate AND pop_use='2' AND pop_type='2'"; 
$popupTop	= $DB->dfetcharr($pup_sql. " ORDER BY no DESC LIMIT 0, 1 ");
?>
<!-- 스티일시트(디지인) 시작 (여기서 수정하시면 됩니다.) -->
<style>
#popup_top_contents {width: <?=$shop_width?>; border: 0px; background: #ffffff; margin: 0 auto; padding: 5px 0px; color:#000000;}
#popup_top_bottom_area {width: 100%; border: 1px solid #808080; background: #b6b6b6; margin: 0; padding: 5px 0px; color:#ffffff;}
#popup_top_bottom {width: <?=$shop_width?>; border: 0px; background: #b6b6b6;  margin: 0 auto; padding: 5px 0px; color:#ffffff; text-align:right; }
</style>
<!-- 스티일시트(디지인) 끝 -->




<!-- 팝업 시작 -->

<?for($i=0; $i<sizeof($popupTop); $i++){
	$popupTops	= $popupTop[$i];
	?>
	
	<div id="popup_top_Layer_<?=$i?>" style="position:relative; display:none; top:0px; left:0px; width:100%; min-height:100px;">
		<div id="popup_top_contents">
			<?if($popupTops[pop_img]){?>
				<?if($popupTops[pop_img_link]){?>
					<a href="<?=$popupTops[pop_img_link]?>" target="_blank">
				<?}?>
				<img src="./data/popup/<?=$popupTops[pop_img]?>">
				<?if($popupTops[pop_img_link]){?>
					</a>
				<?}?>
			<?}?>
			<?=$popupTops[contents]?>
		</div>
		<div id="popup_top_bottom_area">
			<div id="popup_top_bottom">
				<a href="javascript:close_popup_top_<?=$i?>();"><font color="#ffffff">오늘열지 않기Ⅹ</font></a>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
	var now    = new Date();
	var Todays = now.getDate();
	if (getCookie("popup_top_Layer_<?=$i?>") != Todays){
		var flashLayer = document.getElementById("popup_top_Layer_<?=$i?>").style.display = "block";
	}

	function close_popup_top_<?=$i?>(){
		var now    = new Date();
		var Todays = now.getDate();
		setCookie("popup_top_Layer_<?=$i?>", Todays, 1);		 
		var flashLayer = document.getElementById("popup_top_Layer_<?=$i?>").style.display = "none";
	}
	</script>

<?}


// 레이어 팝업창 열기
$popupRow  = $DB->dfetcharr("SELECT *, SUBSTRING_INDEX( pop_img, '|', -1 ) pop_img FROM ".SHOP_POPUP_TABLE." WHERE '".date("Y-m-d")."' BETWEEN pop_sdate AND pop_edate AND pop_use='2' AND pop_type<>'2'");

?>

<!-- 스티일시트(디지인) 시작 (여기서 수정하시면 됩니다.) -->
<style>
#popup_top {width: 100%; border: 1px solid #2f2f2f; background: #2f2f2f; margin: 0; padding: 5px 0px; color:#ffffff; font-weight:bold; }
#popup_img {width: 100%; border: 1px solid #c0c0c0; background: #ffffff; margin: 0; padding: 5px 0px; color:#000000;}
#popup_contents {width: 100%; border: 1px solid #c0c0c0; background: #ffffff; margin: 0; padding: 5px 0px; color:#000000;}
#popup_bottom {width: 100%; border: 1px solid #808080; background: #b6b6b6; margin: 0; padding: 5px 0px; color:#ffffff; text-align:right; }

</style>
<!-- 스티일시트(디지인) 끝 -->




<!-- 팝업 시작 -->

<?for($i=0; $i<sizeof($popupRow); $i++){
	$popupRows	= $popupRow[$i];
	?>
	<div id="popupLayer_<?=$i?>" style="position:absolute; z-index:5000;display:none;">
	<div style="position:absolute; display:block; top:<?=$popupRows[pop_top]?>; left:<?=$popupRows[pop_left]?>px; z-index:400; width:<?=$popupRows[pop_width]?>px;min-height:<?=$popupRows[pop_height]?>px;">
		<div id="popup_top">
			&nbsp; <?=$popupRows[pop_name]?>
		</div>
		<div id="popup_contents">
			<?if($popupRows[pop_img]){?>
				<?if($popupRows[pop_img_link]){?>
					<a href="<?=$popupRows[pop_img_link]?>" target="_blank">
				<?}?>
				<img src="./data/popup/<?=$popupRows[pop_img]?>"><br>
				<?if($popupRows[pop_img_link]){?>
					</a>
				<?}?>
			<?}?>
			<?=$popupRows[contents]?>
		</div>
		<div id="popup_bottom">
			<a href="javascript:close_popup_<?=$i?>();"><font color="#ffffff">오늘열지 않기Ⅹ</font></a>
		</div>
	</div>
	</div>


	<script type="text/javascript">
	var now    = new Date();
	var Todays = now.getDate();
	if (getCookie("popupLayer_<?=$i?>") != Todays){
		document.getElementById("popupLayer_<?=$i?>").style.display = "";
	}

	function close_popup_<?=$i?>(){
		var now    = new Date();
		var Todays = now.getDate();
		setCookie("popupLayer_<?=$i?>", Todays, 1);		 
		document.getElementById("popupLayer_<?=$i?>").style.display = "none";
	}
	</script>

<?}?>
