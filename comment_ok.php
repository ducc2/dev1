<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page - Ace Admin</title>

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
	
	$_POST['com_idx'] = strip_tags(addslashes($_POST['com_idx']));
	if (is_int($_POST['com_idx'])) exit;

	$_POST['com_apply'] = strip_tags(addslashes($_POST['com_apply']));


if ($_REQUEST['mode']=="del") {
	
	$query = "delete FROM ".$tbname['comments']." where com_idx='".$_GET['com_idx']."'";
	$result = mysqli_query($mysqli, $query);

		
		echo "<script>alert('삭제가 완료되었습니다.'); location.href='crm_detail.php?apply_idx=".$_GET[com_apply]."';</script>";
		exit;

} else if ($_REQUEST['mode']=="new") {
	

$query = "SELECT max(com_seq) as seqq from ".$tbname['comments'];
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);


$seqq_num = $row['seqq']+1;

	$_POST['com_content'] = strip_tags(addslashes($_POST['com_content']));
	$_POST['com_apply'] = strip_tags(addslashes($_POST['com_apply']));

	$query = "insert into ".$tbname['comments']." set com_apply='".$_POST['com_apply']."',com_content='".$_POST['com_content']."',com_seq='".$seqq_num."',com_users='".$_SESSION['ss_user_idx']."',com_reg=NOW() ";
	$result = mysqli_query($mysqli, $query);

	echo "<script>location.href='/crm_detail.php?apply_idx=".$_POST['com_apply']."&page=".$_GET[page]."';</script>";
	exit;



} 



?>

