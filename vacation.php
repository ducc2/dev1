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



	$query = "insert into ".$tbname['vac']." set vac_name='".$_POST['vac_name']."',vac_content='".$_POST['vac_content']."',vac_type='".$_POST['vac_type']."',vac_date='".$_POST['vac_date']."',vac_reg=NOW() ";
	$result = mysqli_query($mysqli, $query);

	echo "<script>window.close(); opener.location.href='/crm_calendar.php?year=".$_POST[year]."&month=".$_POST[month]."&apply_idx=".$_POST['com_apply']."&page=".$_GET[page]."';</script>";
		exit;




?>

