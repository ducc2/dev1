<?
 //에러확인
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("memory_limit",-1);

 header("Content-Type:text/html; charset=utf-8");
 
 ////데이터베이스 연결 계정 정의
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");

	include_once '../module/PHPExcel/Classes/PHPExcel.php';
    include '../module/PHPExcel/Classes/PHPExcel/IOFactory.php';

$filename ="./test.xls";

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);
        // 읽기전용으로 설정
        $objReader->setReadDataOnly(true);
        // 엑셀파일을 읽는다
        $objExcel = $objReader->load($filename);
        // 첫번째 시트를 선택
        $objExcel->setActiveSheetIndex(0);
        $objWorksheet = $objExcel->getActiveSheet();


        $rowIterator = $objWorksheet->getRowIterator();
         foreach ($rowIterator as $row) : // 모든 행에 대해서

			$cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); 
            foreach ($cellIterator as $cell): // 해당 열의 모든 셀에 대해서


				echo $cell->getValue();
			
			endforeach;
		endforeach;
    
  	/*$datains[userNm] = $data->val($i,2);
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
 }*/
?>