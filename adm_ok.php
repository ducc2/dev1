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

		$_POST['user_pw'] = strip_tags(addslashes($_POST['user_pw']));
	$_POST['user_id'] = strip_tags(addslashes($_POST['user_id']));
	$_POST['user_level'] = strip_tags(addslashes($_POST['user_level']));
	$_POST['user_email'] = strip_tags(addslashes($_POST['user_email']));
	$_POST['user_phone'] = strip_tags(addslashes($_POST['user_phone']));
	$_POST['user_name'] = strip_tags(addslashes($_POST['user_name']));
	$_POST['user_grade'] = strip_tags(addslashes($_POST['user_grade']));
	$_POST['user_tel'] = strip_tags(addslashes($_POST['user_tel']));
	$_POST['user_word'] = strip_tags(addslashes($_POST['user_word']));

if ($_REQUEST['mode']=="del") {
	
	$query = "delete FROM ".$tbname['users']." where user_idx='".$_GET['user_idx']."'";
	$result = mysqli_query($mysqli, $query);

		
		echo "<script>alert('삭제가 완료되었습니다.'); location.href='adm_list.php?page=".$_GET[page]."';</script>";
		exit;





} else if ($_REQUEST['mode']=="edit") {
	
	if ($_POST['user_pw']) { 
		$user_pw_sql = ",user_pw=password('".$_POST['user_pw']."')";
	}

	$query = "update ".$tbname['users']." set user_id='".$_POST['user_id']."'".$user_pw_sql.",user_email='".$_POST['user_email']."',user_phone='".$_POST['user_phone']."',user_name='".$_POST['user_name']."',user_grade='".$_POST['user_grade']."',user_tel='".$_POST['user_tel']."',user_word='".$_POST['user_word']."' where user_idx='".$_POST['user_idx']."'";

	$result = mysqli_query($mysqli, $query);

	/* numeric array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<script>alert('수정이 완료되었습니다.'); location.href='/adm_detail.php?user_idx=".$_POST['user_idx']."&page=".$_GET[page]."';</script>";
		exit;



} else if ($_REQUEST['mode']=="new") {
	
	$query = "insert into ".$tbname['users']." set user_email='".$_POST['user_email']."',user_phone='".$_POST['user_phone']."',user_name='".$_POST['user_name']."',user_reg=NOW(),user_id='".$_POST['user_id']."',user_pw=password('".$_POST['user_pw']."'),user_grade='".$_POST['user_grade']."',user_word='".$_POST['user_word']."'";

	$result = mysqli_query($mysqli, $query);

	/* numeric array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<script>alert('추가가 완료되었습니다.'); location.href='/adm_list.php?user_idx=".$_POST['user_idx']."&page=".$_GET[page]."';</script>";
		exit;



} 



?>

