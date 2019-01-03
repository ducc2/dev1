<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>

<?
$browser_info			= get_browser_info();
$visit_data[ip]			= $_SERVER['REMOTE_ADDR'];
$visit_data[visit]		= 1;
$visit_data[browser]	= $browser_info[name];
$visit_data[os]			= get_os_info();
$visit_data[agent]		= $_SERVER['HTTP_USER_AGENT'];
$visit_data[referer]	= $_SERVER['HTTP_REFERER'];
$visit_data[keyword]	= get_referer_keyword($_SERVER['HTTP_REFERER']);
$visit_data[host]		= get_referer_host($_SERVER['HTTP_REFERER']);
$visit_data[url]		= $_SERVER['REQUEST_URI'];
$visit_data[datetime]	= date("Y-m-d H:i:s");

//30분전 로그가 있는지 체크 
$sql		= "SELECT *	FROM ".SHOP_VISIT_TABLE." WHERE datetime > DATE_ADD(now(),INTERVAL -30 MINUTE) AND ip='".$_SERVER['REMOTE_ADDR']."'";

$row		= $DB->fetcharr($sql);
if(!$row){
	$DB->insertTable(SHOP_VISIT_TABLE, $visit_data);
}

?>
