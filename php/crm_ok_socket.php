<?
include "/home/hosting_users/prouduro/www/inc/common.php"; 
// socket 처리페이지

$_POST['apply_name'] = strip_tags(addslashes($_POST['apply_name']));
$_POST['apply_tel'] = strip_tags(addslashes($_POST['apply_tel']));
$_POST['apply_email'] = strip_tags(addslashes($_POST['apply_email']));
$_POST['apply_status'] = strip_tags(addslashes($_POST['apply_status']));
$_POST['apply_enter'] = strip_tags(addslashes($_POST['apply_enter']));
$_POST['apply_date'] = strip_tags(addslashes($_POST['apply_date']));
$_POST['apply_var'] = strip_tags(addslashes($_POST['apply_var']));
$_POST['apply_8'] = strip_tags(addslashes($_POST['apply_8']));
$_POST['admin_name'] = strip_tags(addslashes($_POST['admin_name']));
$_POST['write_day'] = strip_tags(addslashes($_POST['write_day']));

$_POST['apply_time'] = strip_tags(addslashes($_POST['apply_time'])); // 예약시간
$_POST['loyalty'] = strip_tags(addslashes($_POST['loyalty'])); 	// 상태
$_POST['doctor_code'] = strip_tags(addslashes($_POST['doctor_code'])); 	// 의사코드
$_POST['operation_code'] = strip_tags(addslashes($_POST['operation_code'])); 	// 수술코드
$_POST['content'] = strip_tags(addslashes($_POST['content'])); 	// 내용

$query = "SELECT user_idx FROM ".$tbname['users']." where user_grade in (2,3) AND user_name='".$_POST['admin_name']."'";
$result = $mysqli->query($query);

IF($row = $result->fetch_array())
{
	$user_idx=$row['user_idx'];
}

//수술코드 selet 

$query2 = "SELECT terms_idx FROM crm_terms WHERE terms_type='min' AND terms_title='".$_POST['operation_code']."'";
$result2 = $mysqli->query($query2);
IF($row2 = $result2->fetch_array())
{
	$terms_idx=$row2['terms_idx'];
}

// 상태값 select
$query3 = "SELECT terms_idx FROM crm_terms where terms_type='status' AND terms_title='".$_POST['loyalty']."'";
$result3 = $mysqli->query($query3);
IF($row3 = $result3->fetch_array())
{
	$terms_idx2=$row3['terms_idx'];
}


$query = "insert into ".$tbname['apply']." set apply_name='".$_POST['apply_name']."',apply_tel='".$_POST['apply_tel']."',apply_email='".$_POST['apply_email']."',apply_var='".$_POST['apply_var']."',apply_enter='".$_POST['apply_enter']."',apply_teacher='".$user_idx."',apply_status='".$terms_idx2."',apply_date='".$_POST['apply_date']."',apply_1='',apply_2='',apply_3='".$_POST['apply_time']."',apply_4='".$_POST['doctor_code']."',apply_5='',apply_6='',apply_7='',apply_8='".$_POST['apply_8']."',apply_9='".$terms_idx."',apply_10='',apply_reg='".$_POST['write_day']."',apply_content='".$_POST['content']."'";

$result = mysqli_query($mysqli, $query);
?>