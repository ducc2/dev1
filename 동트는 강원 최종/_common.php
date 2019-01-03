<?
// 공통 변수, 상수, 코드
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );


// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
@set_time_limit(0);


if ($_SERVER["SERVER_NAME"]=="localhost" or $_SERVER["SERVER_NAME"]=="127.0.0.1"){
	define("TEMP_PATH",						"/shshop/");
}else{
	define("TEMP_PATH",						"/");
}

//경로 상수 설정
define("_SHSHOP_",						"SHSHOP");
define("SHOP_ROOT",						$_SERVER["DOCUMENT_ROOT"]);
define("SHOP_DOMAIN",					$_SERVER["SERVER_NAME"].TEMP_PATH);
define("COOKIE_DOMAIN",					"");
//define("COOKIE_DOMAIN",					".".str_replace("www.", "", $_SERVER["SERVER_NAME"]));
define("HTTPS_DOMAIN",					$_SERVER["SERVER_NAME"].TEMP_PATH.":443");
define("SKIN_ROOT_PATH",				"skin");
define("MEM_SKIN_PATH",					SKIN_ROOT_PATH."/member/");
define("BOARD_SKIN_PATH",				SKIN_ROOT_PATH."/board/");
define("MEM_COMFIRM_URL",				"member");
/*
define("MAIN_SKIN_PATH",				SKIN_ROOT_PATH."/main/");
define("TOP_SKIN_PATH",					SKIN_ROOT_PATH."/_top/");
define("MENU_SKIN_PATH",				SKIN_ROOT_PATH."/_menu/");
define("VISUAL_SKIN_PATH",				SKIN_ROOT_PATH."/_visual/");
define("BANNER_SKIN_PATH",				SKIN_ROOT_PATH."/_banner/");
define("CENTER_SKIN_PATH",				SKIN_ROOT_PATH."/_center/");
define("BOTTOM_SKIN_PATH",				SKIN_ROOT_PATH."/_bottom/");
define("CATEGORY_SKIN_PATH",			SKIN_ROOT_PATH."/category/");
define("GOODS_DETAIL_SKIN_PATH",		SKIN_ROOT_PATH."/detail/");
define("GOODS_CART_SKIN_PATH",			SKIN_ROOT_PATH."/cart/");
define("GOODS_ORDER_SKIN_PATH",			SKIN_ROOT_PATH."/order/");
define("GOODS_COUPON_SKIN_PATH",		SKIN_ROOT_PATH."/coupon_list/");
define("GOODS_BEST_SALE_SKIN_PATH",		SKIN_ROOT_PATH."/best_sale/");
define("GOODS_EVENT_SALE_SKIN_PATH",	SKIN_ROOT_PATH."/event_sale/");
define("GOODS_ORDER_LIST_SKIN_PATH",	SKIN_ROOT_PATH."/order_list/");
define("GOODS_MYPAGE_SKIN_PATH",		SKIN_ROOT_PATH."/mypage/");
define("GOODS_WISH_SKIN_PATH",			SKIN_ROOT_PATH."/wish_list/");
define("GOODS_REVIEW_SKIN_PATH",		SKIN_ROOT_PATH."/review/");
define("POINT_SKIN_PATH",				SKIN_ROOT_PATH."/point_list/");
define("COUPON_SKIN_PATH",				SKIN_ROOT_PATH."/coupon_list/");
define("MY_QANDA_SKIN_PATH",			SKIN_ROOT_PATH."/my_qanda/");
define("ADDRESS_SKIN_PATH",				SKIN_ROOT_PATH."/address_list/");
define("QUICK_SKIN_PATH",				SKIN_ROOT_PATH."/quick/");
define("POPUP_SKIN_PATH",				SKIN_ROOT_PATH."/popup/");
define("MOBILE_SKIN_PATH",				SKIN_ROOT_PATH."/mobile/");
define("WEBPAGE_SKIN_PATH",				SKIN_ROOT_PATH."/webpage/");
define("ETC_SKIN_PATH",					SKIN_ROOT_PATH."/etc/");
*/


define("SHOP_JS",						"js");
define("SHOP_DATA",						"data");
define("SHOP_MODULE",					"module");
define("SHOP_MODULE_MAILER",			"../".SHOP_MODULE."/PHPMailer_5.2.4/");
define("SHOP_MODULE_SMS",				"../".SHOP_MODULE."/sms_module/");
define("SHOP_MODULE_PG_INIPAY",			"../".SHOP_MODULE."/INIpay50/");


define("SESSION_PATH",					SHOP_ROOT.TEMP_PATH.SHOP_DATA."/session/");
define("DATA_PATH",						SHOP_ROOT.TEMP_PATH.SHOP_DATA."/");
/*
define("DATA_PG_LOG_PATH",				SHOP_ROOT.TEMP_PATH.SHOP_DATA."/pg/log/");
define("DATA_KCB_LOG_PATH",				SHOP_ROOT.TEMP_PATH.SHOP_DATA."/kcb/log/");
define("DATA_KCB_KEY_PATH",				SHOP_ROOT.TEMP_PATH.SHOP_DATA."/kcb/key/");
define("SHOP_MODULE_KCB",				SHOP_ROOT.TEMP_PATH.SHOP_MODULE."/kcb/");
*/

/*
define("DESIGN_TOP_PATH",				TEMP_PATH."data/design/top/");
define("DESIGN_BOTTOM_PATH",			TEMP_PATH."data/design/bottom/");
define("DESIGN_CATEGORY_PATH",			TEMP_PATH."data/design/category/");
define("DESIGN_CATEGORY_PATH",			TEMP_PATH."data/design/category/");
define("DESIGN_BEST_SALE_PATH",			TEMP_PATH."data/design/best_sale/");
define("DESIGN_EVENT_SALE_PATH",		TEMP_PATH."data/design/event_sale/");
define("DESIGN_WEBPAGE_PATH",			TEMP_PATH."data/webpage/");
*/

// 디비 테이블 설정
define("MEM_TABLE",						"sh_member");
define("SHOP_INFO_TABLE",				"sh_shop_info");
define("SHOP_BASIC_SET_TABLE",			"sh_shop_basic_set");
/*
define("SHOP_PG_TABLE",					"sh_shop_pg");
define("SHOP_BANK_TABLE",				"sh_shop_bank");
define("SHOP_STIPULATION_TABLE",		"sh_shop_stipulation");
define("SHOP_SMS_SET_TABLE",			"sh_shop_sms_set");
define("SHOP_REALNAME_TABLE",			"sh_shop_realname");
define("SHOP_DELIVERY_TABLE",			"sh_shop_delivery");
define("SHOP_DESIGN_MAIN_TABLE",		"sh_shop_design_main");
define("SHOP_DESIGN_SUB_TABLE",			"sh_shop_design_sub");
define("SHOP_DESIGN_TOP_TABLE",			"sh_shop_design_top");
define("SHOP_DESIGN_VISUAL_TABLE",		"sh_shop_design_visual");
define("SHOP_DESIGN_MENU_TABLE",		"sh_shop_design_menu");
define("SHOP_DESIGN_LEFT_TABLE",		"sh_shop_design_left");
define("SHOP_DESIGN_CATE_TABLE",		"sh_shop_design_cate");
define("SHOP_DESIGN_DETAIL_TABLE",		"sh_shop_design_detail");
define("SHOP_DESIGN_BOTTOM_TABLE",		"sh_shop_design_bottom");
*/
define("SHOP_DESIGN_SKINS_TABLE",		"sh_shop_design_skins");

// 샵 테이블 상수
/*
define("SHOP_CATEGORY_TABLE",			"sh_shop_category");
define("SHOP_CATEGORY_SHOPUP_TABLE",	"sh_shopup_category");
define("SHOP_GOODS_TABLE",				"sh_shop_goods");
define("SHOP_GOODS_FILS_TABLE",			"sh_shop_goods_file");
define("SHOP_GOODS_OPT_TABLE",			"sh_shop_goods_option");
define("SHOP_GOODS_REVIEW_TABLE",		"sh_shop_goods_review");
define("SHOP_GOODS_QANDA_TABLE",		"sh_shop_goods_qna");
define("SHOP_GOODS_ICON_TABLE",			"sh_shop_goods_icon");

define("SHOP_BEST_SALE_TABLE",			"sh_shop_best_sale");
define("SHOP_BEST_EVENT_GOODS_TABLE",	"sh_shop_best_event_goods");
define("SHOP_EVENT_SALE_TABLE",			"sh_shop_event_sale");
define("SHOP_BANNER_TABLE",				"sh_shop_banner");
define("SHOP_SCHEDULE_TABLE",			"sh_shop_schedule");
define("SHOP_COUPON_TABLE",				"sh_shop_coupon");
define("SHOP_COUPON_PUBLISH_TABLE",		"sh_shop_coupon_publish");
define("SHOP_WEBPAGE_TABLE",			"sh_shop_webpage");
define("SHOP_SMS_CONTENTS_TABLE",		"sh_shop_sms_contents");
define("SHOP_SMS_SEND_TABLE",			"sh_shop_sms_send");
define("SHOP_MEM_RATING_TABLE",			"sh_member_rating");
define("SHOP_POINT_USE_TABLE",			"sh_shop_point_use");
define("SHOP_POINT_SET_TABLE",			"sh_shop_point_set");
*/
define("SHOP_BANNER_TABLE",				"sh_shop_banner");
define("SHOP_POPUP_TABLE",				"sh_shop_popup");
define("BOARD_SET_TABLE",				"sh_board_set");
define("BOARD_FILE_TABLE",				"sh_board_file");
define("BOARD_NEW_TABLE",				"sh_board_new");
//define("BOARD_GOOD_TABLE",				"sh_board_good");
define("BOARD_WRITE_TABLE",				"sh_board_wr_");
define("BOARD_COMMENT_TABLE",			"sh_board_comment");
/*
define("SHOP_CART_TABLE",				"sh_shop_cart");
define("SHOP_WISH_TABLE",				"sh_shop_wish");
define("SHOP_ORDER_TABLE",				"sh_shop_order");
define("SHOP_ORDER_GOODS_TABLE",		"sh_shop_order_goods");
define("SHOP_ORDER_PG_TABLE",			"sh_shop_order_pg");
define("SHOP_ORDER_PG_CASH_RECEIPT",	"sh_shop_order_pg_cash_receipt");
define("SHOP_ADDRESS_TABLE",			"sh_shop_address");
*/
define("SHOP_VISIT_TABLE",				"sh_shop_visit");
//define("SHOP_MAILING_TABLE",			"sh_shop_mailing");
//define("SHOP_REALNAME_TABLE",			"sh_shop_realname");


//오후 4:06
// PHP 4.1.0 부터 지원됨
@extract($_GET);
@extract($_POST);
@extract($_SERVER);


// SESSION 설정
ini_set("session.use_trans_sid", 0);
ini_set("url_rewriter.tags", "");

session_save_path(SESSION_PATH);

if(isset($SESSION_CACHE_LIMITER))
    session_cache_limiter($SESSION_CACHE_LIMITER);
else
    session_cache_limiter("no-cache, must-revalidate");

ini_set("session.cache_expire", 180);
ini_set("session.gc_maxlifetime", 10800);
ini_set("session.gc_probability", 1);
ini_set("session.gc_divisor", 100);

session_set_cookie_params(0, "/");
ini_set("session.cookie_domain", COOKIE_DOMAIN);
@session_start();
//==============================================================================

header("Content-type: text/html; charset= utf-8 ");
$gmnow = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0

if ($_REQUEST['PHPSESSID'] && $_REQUEST['PHPSESSID'] != session_id()) { goto_url($sh["rPath"]."/member/logout.php"); }

include_once($sh["rPath"]."/data/dbconnect.php");
//include_once($sh["rPath"]."/lib/auth_process.php");
include_once($sh["rPath"]."/lib/database.php");
include_once($sh["rPath"]."/lib/functions.php");

// 설치여부 체크
$dblink		= @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
if (!$dblink) {
	echo "<div>
				<center><p>SHshop 설치가 안되었습니다.</p>
				<div><a href='./install/'>설치하러가기</a></div></center>
		  </div>
		 ";
	exit;
}


// 샵 설정값 가져오기
$DB						= new database;
/*
$shshop_info			= $DB->get_shop_set_info(SHOP_INFO_TABLE);
$shshop_basic			= $DB->get_shop_set_info(SHOP_BASIC_SET_TABLE);
$shshop_main			= $DB->get_shop_set_info(SHOP_DESIGN_MAIN_TABLE);
$shshop_sub				= $DB->get_shop_set_info(SHOP_DESIGN_SUB_TABLE);
$shshop_top				= $DB->get_shop_set_info(SHOP_DESIGN_TOP_TABLE);
$shshop_bottom			= $DB->get_shop_set_info(SHOP_DESIGN_BOTTOM_TABLE);
$shshop_skins			= $DB->get_shop_set_info(SHOP_DESIGN_SKINS_TABLE);
$shshop_goods_detail	= $DB->get_shop_set_info(SHOP_DESIGN_DETAIL_TABLE);
$shshop_stipulation		= $DB->get_shop_set_info(SHOP_STIPULATION_TABLE);
$shshop_pg				= $DB->get_shop_set_info(SHOP_PG_TABLE);
$shshop_best			= $DB->get_shop_set_info(SHOP_BEST_SALE_TABLE);
$shshop_event			= $DB->get_shop_set_info(SHOP_EVENT_SALE_TABLE);
$shshop_delivery		= $DB->get_shop_set_info(SHOP_DELIVERY_TABLE);
$shshop_sms				= $DB->get_shop_set_info(SHOP_SMS_SET_TABLE);
$shshop_real_name		= $DB->get_shop_set_info(SHOP_REALNAME_TABLE);
$shshop_category		= $DB->get_shshop_category();
$shshop_visual			= $DB->get_shshop_visual();
$shshop_bank			= $DB->get_shshop_bank();
*/

// 보안서버(SSL) 사용 1: 사용, 0: 사용안함
if($shshop_info[ssl_use]=="1"){
	define("SHOP_HTTPS_DOMAIN",		"https://".$_SERVER["SERVER_NAME"].":".$shshop_info[ssl_use_port]);
	define("SHOP_PROTOCOL",			SHOP_HTTPS_DOMAIN);

	// HTTPS(보안서버) 적용 접속
	if(!isset($_SERVER["HTTPS"])){
		header ( "Location: ".SHOP_HTTPS_DOMAIN );
	}
}else{
	define("SHOP_PROTOCOL",			"http://".$_SERVER["SERVER_NAME"]);

	// HTTP 적용 접속
	if(isset($_SERVER["HTTPS"])){
		set_session("shop_https", true);
		header ( "Location: "."http://".$_SERVER["SERVER_NAME"] );
	}
}


$sh["company"]			= $shshop_info[company];
$sh["stie_title"]		= $shshop_basic[site_subject];

/*
// 사용자에게 보내는 문자 발신번호
if($shshop_sms[send_tel1] and $shshop_sms[send_tel2] and $shshop_sms[send_tel3]){
	$shshop_sms[send_tel]	= $shshop_sms[send_tel1]."-".$shshop_sms[send_tel2]."-".$shshop_sms[send_tel3];
}

// 관리자에게 보내는 문자 수신번호
if($shshop_sms[receive_tel1] and $shshop_sms[receive_tel2] and $shshop_sms[receive_tel3]){
	$shshop_sms[receive_tel]	= $shshop_sms[receive_tel1]."-".$shshop_sms[receive_tel2]."-".$shshop_sms[receive_tel3];
}
*/

// 회원정보 초기화
if($_SESSION["mem_id_session"]){
	$member				= $DB->get_member_info($_SESSION["mem_id_session"]);
	$member[mem_email]	= ($member[mem_email1]) ? $member[mem_email1]."@".$member[mem_email2] : "";
	$member[mem_phone]	= ($member[mem_hp1]) ? $member[mem_email1]."@".$member[mem_email2] : "";
	$point_use			= ($member[mem_point] >= $shshop_info[point_use] ) ? true : false;
	addComma($member[mem_point]);

	// 멤버 핸드폰번호
	/*
	if($member[mem_hp1] and $member[mem_hp2] and $member[mem_hp3]){
		$member[mem_phone]	= $member[mem_hp1]."-".$member[mem_hp2]."-".$member[mem_hp3];
	}
	*/
	// 쿠폰정보
	/*$today				= date("Y-m-d");
	$sql				= "SELECT count(*) cnt FROM ".SHOP_COUPON_PUBLISH_TABLE." a WHERE mem_id='".$_SESSION["mem_id_session"]."' AND order_no='' AND order_code=''
						   AND cou_use_sdate <= '".$today."' AND cou_use_edate >= '".$today."'";
	$coupon_cnt			= $DB->fetcharr($sql);
	*/	
	// 주문상태 정보
	//$order_state_info	= $DB->order_state_info($_SESSION["mem_id_session"]);
}else{
	$member[mem_level]	= 0; // 비회원 멤버등급 설정
}

/*
// 회원등급 분류 임의 배열
$member_rating_1	= array("M_all"=>"전체회원", "M_men"=>"남자회원", "M_women"=>"여자회원", "M_birthday"=>"생일회원");
$member_rating_2	= $DB->efetcharr("SELECT CONCAT('M_',rating_num), rating_name FROM ".SHOP_MEM_RATING_TABLE);
$member_rating		= @array_merge_recursive($member_rating_1, $member_rating_2); //PRINT_R($member_rating);
*/




// 게시판 정보 가져오기
if($board_id){
	$board_info		= $DB->get_board_set_info($board_id);
}

// 상품분류 정보 가져오기
/*
if($cate_id){
	//$cate_info		= $DB->get_category_info($cate_id);
}
*/

// 게시판 설정
$board_info[new_icon]		= (!$board_info[new_icon])			? "24" : $board_info[new_icon];
$board_info[subject_length]	= (!$board_info[subject_length])	? "50" : $board_info[subject_length];
$board_info[best_icon]		= (!$board_info[best_icon])			? "100" : $board_info[best_icon];
$board_info[all_width]		= ($board_info[all_width] > 100)	? "width:".$board_info[all_width]."px;margin: 0 auto;" : "width:".$board_info[all_width]."%;";

/*
// 샵정보 설정
$shshop_info[telephone]		= $shshop_info[tel1]."-".$shshop_info[tel2]."-".$shshop_info[tel3];
$shshop_info[fax]			= $shshop_info[fax_tel1]."-".$shshop_info[fax_tel2]."-".$shshop_info[fax_tel3];
$shshop_info[cart_save]		= (!$shshop_info[cart_save])		? "30" : $shshop_info[cart_save];

// 상품분류 설정
$cate_info[page_limit]		= (!$cate_info[page_limit])	? "20" : $cate_info[page_limit];
$cate_info[width_cnt]		= (!$cate_info[width_cnt])	? "4" : $cate_info[width_cnt];
$cate_info[height_cnt]		= (!$cate_info[height_cnt])	? "5" : $cate_info[height_cnt];
*/




// 모바일 페이지 이동
if(preg_match('/(iPhone|Android|Opera Mini|SymbianOS|Windows CE|BlackBerry|Nokia|SonyEricsson|webOS|PalmOS|iPod|iPad|XT720|LG-KU3700|NexusOne|SKY|IM-A710K|HTCDesire|X10i|HTCHD2)/i', $_SERVER['HTTP_USER_AGENT'])) {
	$mobile_con				= true;
	$mobile_pay_return_url	= SHOP_PROTOCOL.TEMP_PATH."module/INIpay_mobile/";
	$mobile_body_padding	= "style='padding: 0px 3px;'";
}else{
	$mobile_con				= false;
}

//$mobile_con					= true; $mobile_pay_return_url	= SHOP_PROTOCOL.TEMP_PATH."module/INIpay_mobile/";$mobile_body_padding	= "style='padding: 0px 3px;'";
//echo $mobile_con;
// 해상도 체크
if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
	$_SESSION['screen_width']	= 100;
	$goods_img_width			= $_SESSION['screen_width'];
	$goods_img_height			= $_SESSION['screen_height'];
	$mobile_centents_width		= $_SESSION['screen_width'];

	//echo 'User resolution: ' . $_SESSION['screen_width'] . 'x' . $_SESSION['screen_height'];
}

// HELP 이미지태그
$help_img	= "<img src='./images/ico_help.gif'>";	// 관리자
$help_img2	= "<img src='../images/common/ico_help.gif'>";	// 사용자

?>