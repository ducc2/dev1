<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
include_once("./admin_auth_check.php");
$DB			= new database;
$data		= $_POST;
$referer	= prevpage();

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD], "POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');

$check_data		= array(
	"company"=>"회사명", 
	"company_num"=>"사업자등록번호 ", 
	"shop_name"=>"쇼핑몰명", 
	"company_num2"=>"통신판매신고번호", 
	"tel1"=>"전화번호 ",  
	"tel2"=>"전화번호 ", 
	"tel3"=>"전화번호 ", 
	"zip1"=>"주소", 
	"addr1"=>"주소", 
	"addr2"=>"주소", 
	"addr3"=>"", 
	"ceo_name"=>"대표자명", 
	"email"=>"대표메일", 
	"privacy_manager"=>"개인정보책임자 ", 
	"privacy_manager_email"=>"개인정보책임자메일 ", 
	"base_delivery"=>"기본배송료 ", 
	"free_delivery"=>"무료배송조건 ", 
	"receive_auto"=>"자동상품 수령기간", 
	"cart_save"=>"장바구니 보관기간", 
	"point_use"=>"적립금 사용조건"
);
				
//널체크
$check_result	= null_check($data, $check_data);
if($check_result){
	js_alert_back("[$check_result]공백입니다. 다시입력해주세요.");
}

removeComma($data[base_delivery]);
removeComma($data[free_delivery]);
removeComma($data[point_use]);

$DB->updateTable(SHOP_INFO_TABLE, $data, "WHERE no='1'");
goto_url($referer);

?>
