<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>프라우드 비뇨기과 CRM</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<?
include $_SERVER['DOCUMENT_ROOT']."/inc/common.php"; 

$query = "SELECT * from ".$tbname['vac']." where vac_idx=".$_GET['vac_idx'];
$result = mysqli_query($mysqli, $query);

/* numeric array */
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

?>
    <form method="post" name="smsForm" action="vacation_edit.php" >
	<input type=hidden name=vac_idx value="<?=$_GET['vac_idx']?>">
	<input type=hidden name="year" value="<?=$_GET['year']?>">
	<input type=hidden name="month" value="<?=$_GET['month']?>">
        <!-- 제목 : <input type="text" name="subject" value="제목"> 장문(LMS)인 경우(한글30자이내)<br /> -->
        휴가내용 <textarea name="vac_content" cols="30" rows="10" style="width:100%" placeholder="내용입력"><?=$row[vac_content]?></textarea> 
		<br />종류 <select name="vac_type">
		<option value="반차" <? if ($row[vac_type]=="반차") { ?>selected<? } ?>>반차</option>
		<option value="월차" <? if ($row[vac_type]=="월차") { ?>selected<? } ?>>월차</option>
		<option value="연차" <? if ($row[vac_type]=="연차") { ?>selected<? } ?>>연차</option>
		<option value="병가" <? if ($row[vac_type]=="병가") { ?>selected<? } ?>>병가</option>
		</select>
        <br />휴가자 
		<select name="vac_name">
				<option value="">선택</option>
				<?
				$query2 = "SELECT * FROM ".$tbname['users']." where user_grade<4";
				$result2 = $mysqli->query($query2);

				while($row2 = $result2->fetch_array())
				{?>
				<option value="<?=$row2['user_name']?>" <? if ($row['vac_name']==$row2['user_name']) { ?>selected<? } ?>><?=$row2['user_name']?></option>
				<? } ?>
		</select>
		<br />휴가일 <input type="text" name="vac_date" value="<?=$row['vac_date']?>" id="datepicker">
		<? if ($_SESSION['ss_user_grade']>1) { ?>
        <input type="button" value="입력" onclick="okok()">
		<input type=button value="삭제" onclick="comdel('vacation_del.php?year=<?=$year?>&month=<?=$month?>&vac_idx=<?=$row[vac_idx]?>')">
		<? } else { ?>
		<input type="button" value="닫기" onclick="window.close();">
		<? }?>

    </form>
    </body>
    </html>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
.ui-datepicker{ font-size: 12px; width: 240px; }
</style>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
  } );

  </script>

 <script>
function comdel(url) {
		if (confirm("정말로 삭제하시겠습니까?"))
		{
			location.href=url;
		} else {
			return false;
		}

  } 

  function okok() {
		opener.window.location.reload();
		document.smsForm.submit();


  }
</script>