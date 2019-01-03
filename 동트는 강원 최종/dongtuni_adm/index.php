<script>
location.href='/dongtuni_adm/board.php?board_id=contents';
</script>

<?
$sh["rPath"]	= "..";
include_once("../_common.php");
include_once("./admin_auth_check.php");
include_once("./_head.php");
include_once("./_top.php");

$table01			= SHOP_ORDER_TABLE;
$table02			= SHOP_ORDER_GOODS_TABLE;
$table03			= SHOP_GOODS_FILS_TABLE;
$table08			= SHOP_GOODS_QANDA_TABLE;
$table09			= MEM_TABLE;
$table10			= SHOP_VISIT_TABLE;


// 주문 상품
$sql				= "SELECT a.*, b.goods_no, b.goods_name, b.goods_code, b.order_options FROM ".$table01." a 
					   LEFT OUTER JOIN ".$table02." b ON b.order_code=a.order_code
					   GROUP BY b.order_code ORDER BY a.no DESC LIMIT 0 ,2";
$order_row			= $DB->dfetcharr($sql);

$order_state_2		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table01." WHERE tot_state='2' AND payment_ok_date > DATE_ADD(NOW(),INTERVAL -7 DAY)");
$order_state_5		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table01." WHERE tot_state='5' AND refund_date > DATE_ADD(NOW(),INTERVAL -7 DAY)");
$order_state_7		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table01." WHERE tot_state='7' AND exchange_date > DATE_ADD(NOW(),INTERVAL -7 DAY)");

$mem_cnt			= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table09."");
$mem_cnt_yester		= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table09." WHERE SUBSTRING(mem_datetime, 1, 10) = SUBSTRING(DATE_ADD(NOW(),INTERVAL -1 DAY), 1, 10)");

$visit_cnt_today	= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table10." WHERE SUBSTRING(datetime, 1, 10) = SUBSTRING(NOW(), 1, 10)");
$visit_cnt_yester	= $DB->fetcharr("SELECT COUNT(*) cnt FROM ".$table10." WHERE SUBSTRING(datetime, 1, 10) = SUBSTRING(DATE_ADD(NOW(),INTERVAL -1 DAY), 1, 10)");

$sale_cnt_today		= $DB->fetcharr("SELECT SUM(payment_money) money FROM ".$table01." WHERE SUBSTRING(datetime, 1, 10) = SUBSTRING(NOW(), 1, 10)");
$sale_cnt_yester	= $DB->fetcharr("SELECT SUM(payment_money) money FROM ".$table01." WHERE SUBSTRING(datetime, 1, 10) = SUBSTRING(DATE_ADD(NOW(),INTERVAL -1 DAY), 1, 10)");

addComma($visit_cnt_today);
addComma($visit_cnt_yester);
addComma($sale_cnt_today);
addComma($sale_cnt_yester);

if(!$sale_cnt_today[money])		$sale_cnt_today[money]	= 0;
if(!$sale_cnt_yester[money])	$sale_cnt_yester[money]	= 0;


// 1:1문의
$sql				= "SELECT a.* FROM ".$table08." a 
					   WHERE qna_type<>'goods' AND reply='' ORDER BY a.no DESC LIMIT 0 , 5";
$qanda_row			= $DB->dfetcharr($sql);


// 상품문의
$sql				= "SELECT a.* FROM ".$table08." a 
					   WHERE qna_type='goods' AND reply='' ORDER BY a.no DESC LIMIT 0 , 5";
$goods_qna_row		= $DB->dfetcharr($sql);



include_once("./_main.php");


include_once("./_bottom.php");
?>
