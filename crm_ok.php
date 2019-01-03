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


	$_POST['apply_name'] = strip_tags(addslashes($_POST['apply_name']));
	$_POST['apply_tel'] = strip_tags(addslashes($_POST['apply_tel']));
	$_POST['apply_email'] = strip_tags(addslashes($_POST['apply_email']));
	$_POST['apply_var'] = strip_tags(addslashes($_POST['apply_var']));
	$_POST['apply_enter'] = strip_tags(addslashes($_POST['apply_enter']));
	$_POST['apply_status'] = strip_tags(addslashes($_POST['apply_status']));
	$_POST['apply_1'] = strip_tags(addslashes($_POST['apply_1']));
	$_POST['apply_2'] = strip_tags(addslashes($_POST['apply_2']));
	$_POST['apply_3'] = strip_tags(addslashes($_POST['apply_3']));
	$_POST['apply_4'] = strip_tags(addslashes($_POST['apply_4']));
	$_POST['apply_5'] = strip_tags(addslashes($_POST['apply_5']));
	$_POST['apply_6'] = strip_tags(addslashes($_POST['apply_6']));
	$_POST['apply_7'] = strip_tags(addslashes($_POST['apply_7']));
	$_POST['apply_8'] = strip_tags(addslashes($_POST['apply_8']));
	$_POST['apply_9'] = strip_tags(addslashes($_POST['apply_9']));
	$_POST['apply_10'] = strip_tags(addslashes($_POST['apply_10']));
	$_POST['apply_date'] = strip_tags(addslashes($_POST['apply_date']));
	$_POST['apply_memo'] = strip_tags(addslashes($_POST['apply_memo']));
	$_POST['apply_content'] = strip_tags(addslashes($_POST['apply_content']));
	
$_GET['apply_idx'] = strip_tags(addslashes($_GET['apply_idx']));
if (is_int($_GET['apply_idx'])) exit;

$_GET['page'] = strip_tags(addslashes($_GET['page']));
if (is_int($_GET['page'])) exit;

if ($_REQUEST['mode']=="del") {
	
	$query = "delete FROM ".$tbname['apply']." where apply_idx='".$_GET['apply_idx']."'";
	$result = mysqli_query($mysqli, $query);

	$query = "delete FROM ".$tbname['comments']." where com_apply='".$_GET['apply_idx']."'";
	$result = mysqli_query($mysqli, $query);

	$query = "delete FROM ".$tbname['tel']." where apply_idx='".$_GET['apply_idx']."'";
	$result = mysqli_query($mysqli, $query);

		
		echo "<script>alert('삭제가 완료되었습니다.'); location.href='crm_list.php?page=".$_GET[page]."';</script>";
		exit;





} else if ($_REQUEST['mode']=="edit") {

	if ($_FILES['upload']['size'] > 0) {
   $filetype = $_FILES['upload']['type'];
   if ($filetype == "image/jpeg" || $filetype == "image/png" || $filetype == "image/gif" || $filetype == "image/bmp") {
    $imgdir = $_SERVER['DOCUMENT_ROOT']."/upload/";     // 이미지 저장할 경로
    $filename = $_FILES['upload']['name'];       // 원래 파일명
    $path_parts = pathinfo($_FILES['upload']['name']);    // 확장자 추출
    $filerename =  uniqid("").".".$path_parts['extension'];   // 파일명 변경한 파일
   
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $imgdir.$filerename)) {
     echo "저장 성공!";
    }
    else {
     echo "저장 실패!";
    }
   }
   else {
    echo "jpg, png, gif, bmp 파일만 첨부가능합니다.";
   }
  }


  if ($_FILES['upload2']['size'] > 0) {
   $filetype = $_FILES['upload2']['type'];
   if ($filetype == "image/jpeg" || $filetype == "image/png" || $filetype == "image/gif" || $filetype == "image/bmp") {
    $imgdir = $_SERVER['DOCUMENT_ROOT']."/upload/";     // 이미지 저장할 경로
    $filename2 = $_FILES['upload2']['name'];       // 원래 파일명
    $path_parts2 = pathinfo($_FILES['upload2']['name']);    // 확장자 추출
    $filerename2 =  uniqid("").".".$path_parts['extension'];   // 파일명 변경한 파일
   
    if (move_uploaded_file($_FILES['upload2']['tmp_name'], $imgdir.$filerename2)) {
     echo "저장 성공!";
    }
    else {
     echo "저장 실패!";
    }
   }
   else {
    echo "jpg, png, gif, bmp 파일만 첨부가능합니다.";
   }
  }
	
	$query = "update ".$tbname['apply']." set apply_name='".$_POST['apply_name']."',apply_tel='".$_POST['apply_tel']."',apply_email='".$_POST['apply_email']."',apply_var='".$_POST['apply_var']."',apply_enter='".$_POST['apply_enter']."',apply_status='".$_POST['apply_status']."',apply_teacher='".$_POST['apply_teacher']."',apply_1='".$_POST['apply_1']."',apply_2='".$_POST['apply_2']."',apply_3='".$_POST['apply_3']."',apply_4='".$_POST['apply_4']."',apply_5='".$_POST['apply_5']."',apply_6='".$filerename."',apply_7='".$filerename2."',apply_8='".$_POST['apply_8']."',apply_9='".$_POST['apply_9']."',apply_10='".$_SESSION['ss_user_idx']."',apply_date='".$_POST['apply_date']."' ,apply_memo='".$_POST['apply_memo']."',apply_content='".$_POST['apply_content']."' where apply_idx='".$_POST['apply_idx']."'";

	$result = mysqli_query($mysqli, $query);

	/* numeric array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<script>alert('수정이 완료되었습니다.'); location.href='/crm_detail.php?apply_idx=".$_POST['apply_idx']."&page=".$_POST[page]."';</script>";
		exit;



}  else if ($_REQUEST['mode']=="seledit") {
	
	


	for($i=0;$i<count($_POST[check]);$i++){ 
			
	$query = "update ".$tbname['apply']." set apply_teacher='".$_POST['apply_teacher'][$i]."' where apply_idx='".$_POST['check'][$i]."'";
	$result = mysqli_query($mysqli, $query);
	
	}

	echo "<script>alert('수정이 완료되었습니다.'); location.href='/crm_list.php?page=".$_GET[page]."';</script>";
		exit;



} else if ($_REQUEST['mode']=="new") {
	

	if ($_FILES['upload']['size'] > 0) {
   $filetype = $_FILES['upload']['type'];
   if ($filetype == "image/jpeg" || $filetype == "image/png" || $filetype == "image/gif" || $filetype == "image/bmp") {
    $imgdir = $_SERVER['DOCUMENT_ROOT']."/upload/";     // 이미지 저장할 경로
    $filename = $_FILES['upload']['name'];       // 원래 파일명
    $path_parts = pathinfo($_FILES['upload']['name']);    // 확장자 추출
    $filerename =  uniqid("").".".$path_parts['extension'];   // 파일명 변경한 파일
   
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $imgdir.$filerename)) {
     echo "저장 성공!";
    }
    else {
     echo "저장 실패!";
    }
   }
   else {
    echo "jpg, png, gif, bmp 파일만 첨부가능합니다.";
   }
  }


  if ($_FILES['upload2']['size'] > 0) {
   $filetype = $_FILES['upload2']['type'];
   if ($filetype == "image/jpeg" || $filetype == "image/png" || $filetype == "image/gif" || $filetype == "image/bmp") {
    $imgdir = $_SERVER['DOCUMENT_ROOT']."/upload/";     // 이미지 저장할 경로
    $filename2 = $_FILES['upload2']['name'];       // 원래 파일명
    $path_parts2 = pathinfo($_FILES['upload2']['name']);    // 확장자 추출
    $filerename2 =  uniqid("").".".$path_parts['extension'];   // 파일명 변경한 파일
   
    if (move_uploaded_file($_FILES['upload2']['tmp_name'], $imgdir.$filerename2)) {
     echo "저장 성공!";
    }
    else {
     echo "저장 실패!";
    }
   }
   else {
    echo "jpg, png, gif, bmp 파일만 첨부가능합니다.";
   }
  }


	$query = "insert into ".$tbname['apply']." set apply_name='".$_POST['apply_name']."',apply_tel='".$_POST['apply_tel']."',apply_email='".$_POST['apply_email']."',apply_var='".$_POST['apply_var']."',apply_enter='".$_POST['apply_enter']."',apply_status='".$_POST['apply_status']."',apply_teacher='".$_POST['apply_teacher']."',apply_1='".$_POST['apply_1']."',apply_2='".$_POST['apply_2']."',apply_3='".$_POST['apply_3']."',apply_4='".$_POST['apply_4']."',apply_5='".$_POST['apply_5']."',apply_6='".$filerename."',apply_7='".$filerename2."',apply_8='".$_POST['apply_8']."',apply_9='".$_POST['apply_9']."',apply_10='".$_SESSION['ss_user_idx']."',apply_reg=NOW(),apply_memo='".$_POST['apply_memo']."',apply_content='".$_POST['apply_content']."' ";
	$result = mysqli_query($mysqli, $query);

	/* numeric array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	echo "<script>alert('추가가 완료되었습니다.'); location.href='/crm_list.php?page=".$_GET[page]."';</script>";
		exit;



} 



?>

