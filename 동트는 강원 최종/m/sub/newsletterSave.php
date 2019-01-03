<?
$sh["rPath"]	= "../..";
include_once($sh["rPath"]."/_common.php");
$DB					= new database;
//echo 'bbbb<br/>';


$idx = isset($_POST['idx']) ? $_POST['idx'] : '';
$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$agreeChk = isset($_POST['agreeChk']) ? $_POST['agreeChk'] : 'Y';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$phone1 = isset($_POST['pphone1']) ? $_POST['pphone1'] : '';
$phone2 = isset($_POST['pphone2']) ? $_POST['pphone2'] : '';
$phone3 = isset($_POST['pphone3']) ? $_POST['pphone3'] : '';
$tel = $phone1."-".$phone2."-".$phone3;
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';
$addr1 = isset($_POST['addr1']) ? $_POST['addr1'] : '';
$addr2 = isset($_POST['addr2']) ? $_POST['addr2'] : '';
$etc = isset($_POST['etc']) ? strEncode($_POST['etc']) : '';
$motive = isset($_POST['motive']) ? $_POST['motive'] : '';
$division = isset($_POST['division']) ? $_POST['division'] : '';
$position = isset($_POST['position']) ? $_POST['position'] : '';
$snum = isset($_POST['snum']) ? $_POST['snum'] : '1';
//부수가 5부 이상이면 택배로 5부이하면 우편으로 발송함.
if ($snum>4) {
	$stype="택배";
} else {
	$stype="우편";
}
/*
echo '
	agreeChk : '. $agreeChk .'<br/>
	name : '. $name .'<br/>
	tel : '. $tel .'<br/>
	mail : '. $mail .'<br/>
	zipcode : '. $zipcode .'<br/>
	addr1 : '. $addr1 .'<br/>
	addr2 : '. $addr2 .'<br/>
	etc : '. $etc .'<br/>
	motive : '. $motive .'<br/>
	division : '. $division .'<br/>
';
*/
$newsletterTB = "newsletter_req";
$msg = "";

if($mode == "insert") {		//등록
	/*
	$set = "userNm = '". $name ."'";
	$set .= ", tel = '". $tel ."'";
	$set .= ", email = '". $mail ."'";
	$set .= ", zipcode = '". $zipcode ."'";
	$set .= ", addr1 = '". $addr1 ."'";
	$set .= ", addr2 = '". $addr2 ."'";
	$set .= ", etc = '". $etc ."'";
	$set .= ", req_motive = '". $motive ."'";
	$set .= ", subscribeType = '". $division ."'";
	$set .= ", agreeYn = '". $agreeChk ."'";
	$set .= ", insertDttm = now()";
	$set .= ", wrkIP = '". getClientIP() ."'";

	$idx	= $DB->insertSet($newsletterTB, $set);
	*/
	$datains[userNm] = $name;
	$datains[tel] = $tel;
	$datains[email] = $mail;
	$datains[zipcode] = $zipcode;
	$datains[addr1] = $addr1;
	$datains[addr2] = $addr2;
	$datains[etc] = $etc;
	$datains[req_motive] = $motive;
	$datains[subscribeType] = $division;
	$datains[agreeYn] = $agreeChk;
	$datains[insertDttm] = date("Y-m-d H:i:s");
	$datains[wrkIP] = getClientIP();
	$datains[snum] = $snum;
	$datains[stype] = $stype;
	$datains[position] = $position;

	$idx	= $DB->insertTable($newsletterTB, $datains);

	if($idx > 0) {
		//$msg = "신청되었습니다.";
		$formAction = "./newsletter_apply03.html";
	}else{
		$msg = "신청이 실패하였습니다.";
		$formAction = "./newsletter_apply01.html";
	}

}else if($mode == "modify") {		//수정
	if($idx != ""){

		$dataup[tel] = $tel;
		$dataup[email] = $mail;
		$dataup[zipcode] = $zipcode;
		$dataup[addr1] = $addr1;
		$dataup[addr2] = $addr2;
		$dataup[etc] = $etc;
		$dataup[req_motive] = $motive;
		$dataup[subscribeType] = $division;
		$dataup[updateDttm] = date("Y-m-d H:i:s");
		$dataup[wrkIP] = getClientIP();
		$dataup[snum] = $snum;
		$dataup[stype] = $stype;
		$dataup[position] = $position;


		$DB->updateTable($newsletterTB, $dataup, "WHERE idx='".$idx."'");

		//$msg = "변경되었습니다.";
		$formAction = "./newsletter_confirm04.html";
	}else{
		$msg = "잘못된 접근입니다.";
		$formAction = "/";
	}

}else if($mode == "cancel") {		//해지
	if($idx != ""){
		$datacc[cancelYn] = "Y";
		$datacc[cancelDttm] = date("Y-m-d H:i:s");
		$datacc[wrkIP] = getClientIP();

		$DB->updateTable($newsletterTB, $datacc, "WHERE idx='".$idx."'");

		$msg = "해지되었습니다.";
		$formAction = "./newsletter_apply01.html";
	}else{
		$msg = "잘못된 접근입니다.";
		$formAction = "/";
	}
}else{		//잘못된 접근
	$msg = "잘못된 접근입니다.";
	$formAction = "/";
}

/* 문자열 변환
// $str : 문자열(html, text)
// 반환 : trim() + text 형태 + <br> 처리
//참고> str_replace("\n","<br>",$str); 대신 nl2br()을 사용해도 된다.
*/
function strEncode($str)
{
	$str = trim($str);
	//$str = str_replace("'","''",$str);
	$str = str_replace("\n","<br/>", $str);
	$str = str_replace(" ","&nbsp;",$str);
	return $str;
}

function getClientIP() {

	if (isset($_SERVER)) {

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			return $_SERVER["HTTP_X_FORWARDED_FOR"];

		if (isset($_SERVER["HTTP_CLIENT_IP"]))
			return $_SERVER["HTTP_CLIENT_IP"];

		return $_SERVER["REMOTE_ADDR"];
	}

	if (getenv('HTTP_X_FORWARDED_FOR'))
		return getenv('HTTP_X_FORWARDED_FOR');

	if (getenv('HTTP_CLIENT_IP'))
		return getenv('HTTP_CLIENT_IP');

	return getenv('REMOTE_ADDR');
}
?>
<form name="saveForm" id="saveForm" method="post" action="<?=$formAction?>">
<input type="hidden" name="idx" id="idx" value="<?=$idx?>"/>
</form>

<script>
	var msg = '<?=$msg?>';

	if(msg != ""){
		alert(msg);
	}
	document.saveForm.submit();
</script>