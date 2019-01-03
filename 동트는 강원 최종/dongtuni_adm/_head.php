<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="Author" content="">
	<meta name="Keywords" content="">
	<meta name="Description" content="">
	<title>동트는강원 : 홈페이지관리자</title>
	<!--[if lte IE 8]>
	<script src="<?=$sh["rPath"]?>/js/html5.js"></script>
	<![endif]-->

	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/common.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/common.ajax.js"></script>
	<!--
	<script type="text/javascript" src="<?=$sh["rPath"]?>/admin/js/_admin.ajax.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]?>/admin/js/_admin_common.js"></script>
	-->
	<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script type="text/javascript" src="<?=$sh["rPath"]?>/module/SmartEditor/js/HuskyEZCreator.js" charset="utf-8"></script>
	<!--
	<script type="text/javascript" src="<?=$sh["rPath"]?>/module/sms_module/js/msg.js"></script>-->
	<?if(isset($_SERVER["HTTPS"])){?>
		<style>
			@import url(https://fonts.googleapis.com/earlyaccess/jejugothic.css);
			@import url(https://fonts.googleapis.com/earlyaccess/nanumgothic.css);
		</style>
	<?}?>
	<link type="text/css" rel="stylesheet" href="<?=$sh["rPath"]?>/css/common.admin.css">	
	<link type="text/css" rel="stylesheet" href="<?=$sh["rPath"]."/".SHOP_JS?>/jquery-ui.css"/>
</head>
<body>
