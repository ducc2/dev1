<?
 //에러확인
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
ini_set("memory_limit",-1);

 header("Content-Type:text/html; charset=utf-8");
 
 ////데이터베이스 연결 계정 정의
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");

require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("./test.xls");

$rowcount = $data->rowcount($sheet_index=0);

 $k = 0;
 for($i=2;$i<=$rowcount;$i++) {
    
  	$datains[userNm] = $data->val($i,2);
	$datains[position] = $data->val($i,3);
	$datains[tel] = $data->val($i,4);
	$datains[email] = $data->val($i,5);
	$datains[zipcode] = $data->val($i,6);
	$datains[addr1] = $data->val($i,7);
	$datains[addr2] = $data->val($i,8);
	$datains[etc] = $data->val($i,9);
	$datains[req_motive] = $data->val($i,10);
	$datains[subscribeType] = $data->val($i,11);
	$datains[agreeYn] = $data->val($i,12);
	$datains[cancelYn] = $data->val($i,15);
	$datains[stype] = $data->val($i,19);
	$datains[snum] = $data->val($i,20);


	
 $DB->insertTable("newsletter_req", $datains);
  $k++;
 }
?>