<?
//header("Content-Type: text/html; charset=UTF-8");

$sh["rPath"]		= "..";
include_once($sh["rPath"]."/_common.php");
$DB = new database;

$nm = isset($_POST['nm']) ? $_POST['nm'] : '';
$pphone1 = isset($_POST['pphone1']) ? $_POST['pphone1'] : '';
$pphone2 = isset($_POST['pphone2']) ? $_POST['pphone2'] : '';
$pphone3 = isset($_POST['pphone3']) ? $_POST['pphone3'] : '';
$tel			 = $pphone1."-".$pphone2."-".$pphone3;
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';

$msg = 0;

//$msg = "nm: ". $nm ." | tel: ". $tel ." | mail: ". $mail;

//체크
if($nm != ""){

//조회
	if($pphone2 != "" && $pphone3 != "") {
		$sql = "select idx, cancelYn from newsletter_req where userNm='". $nm ."' and tel='". $tel ."'";
		$row = $DB->fetcharr($sql);
		
		if ($row[idx]) {
			if($row['cancelYn'] == "Y") {
				$msg = -1;
			}else{
				//$msg = $row['idx'];
				$msg = $nm."++".$tel;
			}
		}
	}else if($mail != "") {
		$sql = "select idx, cancelYn from newsletter_req where userNm='". $nm ."' and email='". trim($mail) ."'";
		$row = $DB->fetcharr($sql);
		
		if ($row[idx]) {
			if($row['cancelYn'] == "Y") {
				$msg = -1;
			}else{
				$msg = $nm."++".$mail;
			}
		}
	}
}

echo $msg;
?>