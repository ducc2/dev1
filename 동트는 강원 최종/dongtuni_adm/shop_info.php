<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");
include_once("./_left.php");

$DB			= new database;
$shop_info	= $DB->get_shop_set_info(SHOP_INFO_TABLE);

if($shop_info[base_delivery]>0)	addComma($shop_info[base_delivery]);
if($shop_info[free_delivery]>0)	addComma($shop_info[free_delivery]);
if($shop_info[point_use]>0)		addComma($shop_info[point_use]);

text_special_replace($shop_info);
include_once("./shop_info_form.php");


include_once("./_bottom.php");
?>
