<?
if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가
   
function chk_file($tmpfile, $file) {
    if (!is_uploaded_file($tmpfile)) {
        return false;
    }
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, array('pdf'))) {
        echo 'pdf 확장자인 것만 올려주세요'; 
        return false;
    }

    return true;
}

/***************************************************************************
*  패스워드 변경
****************************************************************************/
function new_password_random($len){
	
	$new_pass	= substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", $len)), 0, $len);
    return $new_pass;
}


/***************************************************************************
*  접속자 검색 키워드 정보 얻어오기
****************************************************************************/
function get_referer_keyword($referer){

    if (!$referer) return false;
	$parsed = parse_url( $referer, PHP_URL_QUERY );
	parse_str( $parsed, $query );

	if ($query['q']) {
		return $query['q'];
	} elseif ($query['query'])  {
		return $query['query'];
	}
}


/***************************************************************************
*  접속자 호스트 정보 얻어오기
****************************************************************************/
function get_referer_host($referer){

    if (!$referer) return false;
	$host_name		= preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $referer, $match);
	$host_name		= trim($match[1]);

	if ($host_name) {
		return $host_name;
	} else {
		return false;
	}
}


/***************************************************************************
*  접속자 운영체제 정보 얻어오기
****************************************************************************/
function get_os_info(){
	$OSList		= array(
						'/windows nt 6.2/i'     =>  'Windows 8',
						'/windows nt 6.1/i'     =>  'Windows 7',
						'/windows nt 6.0/i'     =>  'Windows Vista',
						'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
						'/windows nt 5.1/i'     =>  'Windows XP',
						'/windows xp/i'         =>  'Windows XP',
						'/windows nt 5.0/i'     =>  'Windows 2000',
						'/windows me/i'         =>  'Windows ME',
						'/win98/i'              =>  'Windows 98',
						'/win95/i'              =>  'Windows 95',
						'/win16/i'              =>  'Windows 3.11',
						'/macintosh|mac os x/i' =>  'Mac OS X',
						'/mac_powerpc/i'        =>  'Mac OS 9',
						'/linux/i'              =>  'Linux',
						'/ubuntu/i'             =>  'Ubuntu',
						'/iphone/i'             =>  'iPhone',
						'/ipod/i'               =>  'iPod',
						'/ipad/i'               =>  'iPad',
						'/android/i'            =>  'Android',
						'/blackberry/i'         =>  'BlackBerry',
						'/webos/i'              =>  'Mobile'
					);
	
	foreach($OSList as $Match=>$CurrOS){
		if (preg_match($Match, $_SERVER['HTTP_USER_AGENT'])){
			break;
		}
	}
	return $CurrOS;
}


/***************************************************************************
*  접속자 브라우저 정보 얻어오기
****************************************************************************/
function get_browser_info(){
	$browser	= array('version'=> '0.0.0', 'majorver'=> 0, 'minorver'=> 0, 'build'=> 0, 'name'=> 'unknown', 'useragent'=> '');

	$browsers	= array('firefox', 'msie', 'opera', 'chrome', 'safari', 'mozilla', 'seamonkey', 'konqueror', 'netscape',
						'gecko', 'navigator', 'mosaic', 'lynx', 'amaya', 'omniweb', 'avant', 'camino', 'flock', 'aol'
						);

	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$browser['useragent'] = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = strtolower($browser['useragent']);
		foreach($browsers as $_browser) {
			if (preg_match("/($_browser)[\/ ]?([0-9.]*)/", $user_agent, $match)) {
				$browser['name'] = $match[1];
				$browser['version'] = $match[2];
				@list($browser['majorver'], $browser['minorver'], $browser['build']) = explode('.', $browser['version']);
				break;
			}
		}
	}
	return $browser;
}

/***************************************************************************
*  날짜 받아서 요일 구하기
****************************************************************************/
function get_week_str($date , $type="1"){
	if($type=="1")	$arr_week	= array("0"=>" (일)", "1"=>" (월)", "2"=>" (화)", "3"=>" (수)", "4"=>" (목)", "5"=>" (금)", "6"=>" (토)");	
	if($type=="2")	$arr_week	= array("0"=>"월", "1"=>"화", "2"=>"수", "3"=>"목", "4"=>"금", "5"=>"토", "6"=>"일");	
	return $arr_week[$date];
}


/***************************************************************************
* 디비 날짜 0000-00-00 공백 만들기 
****************************************************************************/
function data_date_null_change(&$data, $patten) {
	if (is_array($data) && $data) {
	    foreach ($data as $key=>$value ) {
			if ($value == $patten) $data[$key] = '';
	    }
	}else{
		if (!$row) $row = '';
	}
}


/***************************************************************************
* 결제방법 가져오기 ( 여기 수정시 주문 관리, 주문서 에서도 수정해야함. )
****************************************************************************/
/*
function get_payment_type($state, $type="1"){
	$arr_state	= array("1"=>"무통장입금", "2"=>"신용카드", "3"=>"실시간계좌이체", "4"=>"휴대폰결제", "5"=>"가상계좌");	
	if($type=="1"){
		return $arr_state[$state];
	}else if ($type=="2"){
		return arrToption("sc", $arr_state, $state, "");
	}
}*/

/***************************************************************************
* 주문 상태 가져오기 
****************************************************************************/
/*
function goods_order_state($state, $type="1"){
	$arr_state	= array("1"=>"결제대기", "2"=>"결제완료", "3"=>"배송중", "4"=>"배송완료", "5"=>"반품신청", "6"=>"반품완료", "7"=>"교환신청", 
						"8"=>"교환완료", "9"=>"주문취소<br>(결제전)", "10"=>"주문취소<br>(결제후)", "11"=>"거래완료" );
	if($type=="1"){
		return $arr_state[$state];
	}else if ($type=="2"){
		return arrToption("sc", $arr_state, $state, "");
	}
}

/***************************************************************************
* 택배 업체 가져오기 ( 여기 수정시 택배사 관리도 같이 수정해야함. )
****************************************************************************/
/*
function delivery_company($state, $type="1"){
	$arr_state		= array("1"=>"우체국 택배", "2"=>"대한통운", "3"=>"CJ GLS", "4"=>"한진 택배", "5"=>"KGB 택배", "6"=>"현대 택배", "7"=>"로젠 택배", 
							"8"=>"KG 옐로우캡", "9"=>"KT로지스", "10"=>"동부익스프레스", "11"=>"하나로택배", "12"=>"아주택배",  "13"=>"트라넷",  "14"=>"사가와익스프레스",  
							"15"=>"SEDEX",  "16"=>"삼성HTH", "17"=>"우편등기", "18"=>"기타택배", "19"=>"자가배송" );

	$arr_pg_code	= array("1"=>"EPOST", "2"=>"korex", "3"=>"cjgls", "4"=>"hanjin", "5"=>"kgbls", "6"=>"hyundai", "7"=>"kgb", "8"=>"yellow", "9"=>"ktlogistics", 
							"10"=>"dongbu", "11"=>"Hanaro", "12"=>"ajutb", "13"=>"tranet", "14"=>"Sagawa", "15"=>"sedex", "16"=>"hth", "17"=>"registpost", "18"=>"9999", "19"=>"자가배송"
							);

	if($type=="1"){
		return $arr_state[$state];

	}else if ($type=="2"){
		return arrToption("sc", $arr_state, $state, "");

	}else if ($type=="3"){
		return $arr_pg_code[$state];

	}
}

/***************************************************************************
* TEXT ", ', <, > 특수문자 문자 삭제 
****************************************************************************/
function text_special_delete($data){
	$data = preg_replace ("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $data);
	return $data;
}


/***************************************************************************
* TEXT ", ', <, > 특수문자 문자 변환 
****************************************************************************/
function text_special_replace(&$data){

    $source[] = "/</";
    $target[] = "&lt;";
    $source[] = "/>/";
    $target[] = "&gt;";
    $source[] = "/\"/";
    $target[] = "&quot;";
    $source[] = "/\'/";
    $target[] = "&#039;";

	if (is_array($data) && $data) {
	    foreach ($data as $key=>$value ) {
			$data[$key] = preg_replace($source, $target, $value);
	    }
	}else{
		return preg_replace($source, $target, $data);
	}
}


/***************************************************************************
* 이미지 썸네일 폴더 리셋 
****************************************************************************/
function thumbnail_dir_reset($reset_dir){
	array_map('unlink', glob("$reset_dir/*.*"));
	rmdir($reset_dir);
	mkdir($reset_dir);
	chmod($reset_dir, 0777);
}


/***************************************************************************
* 이미지 썸네일
****************************************************************************/
function makeThumbnails($updir, $thumb_dir, $img, $id, $thumbnail_width, $thumbnail_height){

    $arr_image_details	= getimagesize($updir . $img); // pass id to thumb name
    $original_width		= $arr_image_details[0];
    $original_height	= $arr_image_details[1];

    if ($arr_image_details[2] == 1) {
        $imgt			= "ImageGIF";
        $imgcreatefrom	= "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt			= "ImageJPEG";
        $imgcreatefrom	= "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt			= "ImagePNG";
        $imgcreatefrom	= "ImageCreateFromPNG";
    }

    if ($original_width > $original_height) {
        $new_width		= $thumbnail_width;
        $new_height		= intval($original_height * $new_width / $original_width);
    } else {
        $new_height		= $thumbnail_height;
        $new_width		= intval($original_width * $new_height / $original_height);
    }

	// 가로 비율을 구한다
	$rate		= $thumbnail_height / $original_height;
	$width		= intval($original_width * $rate);

	// 세로 비율을 구한다
	$rate		= $thumbnail_width / $original_width;
	$height		= intval($thumbnail_height * $rate);

	// 원본이 썸네일보다 작을 때 (가로 세로 작다)
	if ($original_width <= $thumbnail_width && $original_height <= $thumbnail_height) {
		$new_width			= $original_width; 
		$new_height			= $original_height; 
		$original_width		= $original_width;  
		$original_height	= $original_height; 
	
	// 가로가 크다
	}else if ($original_width > $original_height) {

    
		// 원본 가로가 썸네일보다 작다면
		if ($original_width < $thumbnail_width) {
			$thumbnail_width = $original_width;
		}

		// 원본 세로가 썸네일보다 작다면
		if ($original_height < $thumbnail_height) {
			$thumbnail_height = $original_height;
		}

		// 가로비율이 썸네일보다 작다면
		if ($width < $thumbnail_width) {
			$new_width = $thumbnail_width;
		} else {
			$new_width = $width;
		}

		// 세로비율이 썸네일보다 작다면
		if ($height < $thumbnail_height) {
			$new_height = $thumbnail_height;
		} else {
			$new_height = $height;
		}

	// 세로가 크다
	}else if ($original_width < $original_height) {

    
		// 원본 가로가 썸네일보다 작다면
		if ($original_width < $thumbnail_width) {
			$thumbnail_width = $original_width;
		}

		// 원본 세로가 썸네일보다 작다면
		if ($original_height < $thumbnail_height) {
			$thumbnail_height = $original_height;
		}

		// 가로비율이 썸네일보다 작다면
		if ($width < $thumbnail_width) {
			$new_width = $thumbnail_width;
		} else {
			$new_width = $width;
		}

		// 세로비율이 썸네일보다 작다면
		if ($height < $thumbnail_height) {
			$new_height = $thumbnail_height;
		} else {
			$new_height = $height;
		}

    // 가로세로 같을 때 비율처리
	} else {
    
		// 가로 비율이 썸네일을 초과
		if ($width > $thumbnail_width) {
			$new_width = $thumbnail_width;
		} else {
			$new_width = $width;
		}

		// 세로 비율이 썸네일을 초과
		if ($height > $thumbnail_height) {
			$new_height = $thumbnail_height;
		} else {
			$new_height = $height;
		}
	}

	$crop_left	= 0;
	$crop_top	= 0;
    $dest_x		= 0;
    $dest_y		= 0;




    if ($imgt) {
        $old_image		= $imgcreatefrom("$updir" . "$img");
        $new_image		= @imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		
		imagesavealpha($new_image, true);
		$trans_colour	= imagecolorallocatealpha($new_image, 0, 0, 0, 127);
		imagefill($new_image, 0, 0, $trans_colour);

        @imagecopyresized($new_image, $old_image, $dest_x, $dest_y, $crop_left, $crop_top, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, "$thumb_dir" . "thumb" . "$img");
    }
	return true;
}


/***************************************************************************
* 폼태그
****************************************************************************/
function setform($type,$name,$opt,$txt=""){
	$text = "<input type='$type' name='$name' $opt> $txt";
	return $text;
}

/***************************************************************************
* 스킨경로를 얻는다
****************************************************************************/
function get_skin_dir($skin, $skin_path=SKIN_ROOT_PATH){

    $result_array = array();

    $dirname = "../".$skin_path.'/'.$skin.'/'; 
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;

        if (is_dir($dirname.$file)) $result_array[$file] = $file;
    }
    closedir($handle);
    //sort($result_array);
    return $result_array;
}

/***************************************************************************
* 1차원배열 값으로 select,radiobox,checkbox 를 만드는 함수
****************************************************************************/
function arrToption($kind,$arr,$curr,$name,$etc=false){
	$icnt=0;
	if(!$arr) return;
	foreach($arr as $key=>$value){
		$pre = "";
		if($kind == "c" or $kind == "cc"){
			if(@in_array($key,$curr)) $pre = " checked";
		}else{
			if(strlen($curr) && $curr == $key){
				$pre = ($kind == "s" or  $kind == "sc") ?  " selected" : " checked";
			}
		}
		if($icnt%10==0 and $icnt > 0){ $tempBR	= "<BR>";  $tempTR	= "<TR>"; }else{ $tempBR	= "";  $tempTR	= ""; }
		switch($kind){
			case "s"  :  $options .= "<option value='".$value."'".$pre." ".$etc.">".$value."</option>"; break;
			case "sc" :  $options .= "<option value='".$key."'".$pre." ".$etc.">".$value."</option>"; break;
			case "r"  :  $options .= "<input type='radio' name='".$name."' value='".$key."'".$pre." ".$etc."> $value";	break;
			case "c"  :  $options .= "<input type='checkbox' name='".$name."' value='".$key."'".$pre." ".$etc."> $value $tempBR";	break; 
			case "cc" : $options .= $tempTR."<TD><input type='checkbox' name='".$name."' value='".$key."'".$pre." ".$etc."> $value $tempBR </TD>";	break;
		}
		$icnt++;
	}
	return $options;
}

/***************************************************************************
* 이메일 발송 폼 가져오기
****************************************************************************/
/*
function email_sender_html_get($state, $fname, $fmail, $to, $subject, $content="", $data_arr=""){

	if($state=="mamberjoin")	$email_from_get	= "../".MEM_SKIN_PATH."/basic/email_form_register_join.php";
	if($state=="idpw_find")		$email_from_get	= "../".MEM_SKIN_PATH."/basic/email_form_id_pw_find.php";
	if($state=="qanda")			$email_from_get	= "../".MEM_SKIN_PATH."/basic/email_form_qanda.php";
	if($state=="order")			$email_from_get	= "../".MEM_SKIN_PATH."/basic/email_form_order.php";
	
	if($state<>"admin"){
		ob_start();
		include_once($email_from_get);
		$content = ob_get_contents();
		ob_end_clean();
	}
	email_sender_proc($fname, $fmail, $to, $subject, $content, "");
}


/***************************************************************************
* 이메일 발송하기
****************************************************************************/
/*
function email_sender_proc($fname, $fmail, $to, $subject, $content, $file="", $cc="", $bcc=""){

	$from		= $fmail;				// 보내는 사람 멜 주소
	$email		= $to;					// 받는사람 멜 주소
	$subject	= "$subject";			// 멜 제목
	$header		.= "From: $fname <$from>\r\n"; 
	$header		.= "Reply-To: $from\r\n"; 
	$header		.= "X-Sender: <$from>\r\n"; 
	$header		.= "X-Mailer: PHP ".phpversion()."\r\n"; 
	$header		.= "X-Priority: 3\r\n"; 
	$header		.= "MIME-Version: 1.0\r\n"; 
	$header		.= "Content-type: text/html; charset=euc-kr";  //echo "$email, $subject, $content, $header";
	mail($email, $subject, $content, $header);//exit;
}

/***************************************************************************
* 널 체크
****************************************************************************/
function null_check($data, $check_data){	
	foreach($check_data as $key=>$value ){
		if(!$data[$key])	return $check_data[$key];
	}
}

/***************************************************************************
* 페이지 이동
****************************************************************************/
function goto_url($url){
    $url = str_replace("&amp;", "&", $url); 

    if (!headers_sent()){
        header('Location: '.$url);
	}else {
        echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}

/***************************************************************************
* 세션변수 생성
****************************************************************************/
function set_session($session_name, $value){
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);

    // PHP 버전별 방법
    $$session_name = $_SESSION[$session_name] = $value;
}

/***************************************************************************
* 세션변수 값 얻음
****************************************************************************/
function get_session($session_name){
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}

/***************************************************************************
* 쿠키변수 생성
****************************************************************************/
function set_cookie($cookie_name, $value, $expire){
    setcookie(md5($cookie_name), base64_encode($value), time() + $expire, '/', COOKIE_DOMAIN);
}

/***************************************************************************
* 쿠키변수값 얻음
****************************************************************************/
function get_cookie($cookie_name){
    $cookie	= md5($cookie_name);
    if (array_key_exists($cookie, $_COOKIE))
        return base64_decode($_COOKIE[$cookie]);
    else
        return "";
}

/***************************************************************************
* 배열 trim
****************************************************************************/
function array_trim(&$value){ 
	if(is_array($value)) {
		return array_map('array_trim', $value);
	}else{
		$value = trim($value); 
	}
}


/***************************************************************************
* 한글만 제거
****************************************************************************/
function kr_str_remove($str){
	for ($i=0; $i<strlen($str); $i++) { 
	  $char_ord = ord($str[$i]); 
	  if ($char_ord >= 65 && $char_ord <= 122) $string .= $str[$i]; 
	}
	return $string;
}

/***************************************************************************
* 텍스트 색상적용
****************************************************************************/
function text_color_set($txt,$clr,$type=""){
	$text = "<font color='".$clr."'>".$txt."</font>";
	if($type) $text = "<".$type.">".$text."</".$type.">";
	return $text;
}  


/***************************************************************************
* 한글 문자열을 잘라서 ... 으로 처리
****************************************************************************/
function text_cut_kr($str, $length) {
	if(mb_strlen($str,"utf-8") > $length) {
		$count = 0;
		for($i = 0; $i < $length ; $i++) { 
			$cut = ord(substr($str, $i, 1)); 
			if($cut > 127) { 
				$count++; 
			} 
		}
		$mod = $count % 2; 
		if($mod == 0) {		
			$str = mb_substr($str, 0, $length, "utf-8"); 
			$str = $str . "..."; 
		} else { 
			$length = $length + 1; 
			$str = mb_substr($str, 0, $length, "utf-8"); 
			$str = $str . "..."; 
		} 
	}
	return $str;
}


/***************************************************************************
* 문자열을 잘라서 ... 으로 처리
****************************************************************************/
function text_cut_str($str, $length) {
	if(strlen($str) > $length) {
		$count = 0;
		for($i = 0; $i < $length ; $i++) { 
			$cut = ord(substr($str, $i, 1)); 
			if($cut > 127) { 
				$count++; 
			} 
		}
		$mod = $count % 2; 
		if($mod == 0) {		
			$str = substr($str, 0, $length); 
			$str = $str . "..."; 
		} else { 
			$length = $length + 1; 
			$str = substr($str, 0, $length); 
			$str = $str . "..."; 
		} 
	} 
return $str;
}


/***************************************************************************
* 자바스크립트 경고창
****************************************************************************/
function js_alert($msg) {
	echo ("<script>window.alert('$msg');</script>");
}

/***************************************************************************
* 자바스크립트 경고창 + 뒤로가기
****************************************************************************/
function js_alert_back($msg) {
	echo "<script>\n";
	echo "window.alert ('".$msg."');\n";
	echo "history.go(-1);\n";
	echo "</script>\n";
	exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 페이지 이동
****************************************************************************/
function js_alert_go_url($msg, $url) {
	echo "<script>\n";
	echo "window.alert ('".$msg."');\n";
	echo "document.location.href='".$url."'";
	echo "</script>\n";
	exit;
}


/***************************************************************************
* 자바스크립트 경고창 + 페이지 이동
****************************************************************************/
function js_alert_comfirm_parent_parent_go_url($msg, $url) {
	echo "<script>\n";
	if($msg){
		echo "if(confirm('".$msg."')==1){";
		echo "	parent.parent.document.location.href='".$url."'";
		echo "}";
	}else{
		echo "	parent.parent.document.location.href='".$url."'";
	}
	echo "</script>\n";
	exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 페이지 이동
****************************************************************************/
function js_alert_comfirm_parent_go_url($msg, $url) {
	echo "<script>\n";
	if($msg){
		echo "if(confirm('".$msg."')==1){";
		echo "	parent.document.location.href='".$url."'";
		echo "}";
	}else{
		echo "	parent.document.location.href='".$url."'";
	}
	echo "</script>\n";
	exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 닫기
****************************************************************************/
function js_alert_close($msg) {
	echo ("
		<script>
		window.alert ('$msg');
		window.close();
		</script>
		");
		exit;
	}
	
/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 서브밋
****************************************************************************/	
function js_alert_close_submit($msg, $submit){
	if($msg)	$alert = "window.alert ('$msg');";
	echo "
		 <script>
		 $alert
		 opener.document.form1.submitBeforeView.value='true';
		 opener.document.form1.submit();
		 window.close();
		 </script>";
	exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 리플레쉬
****************************************************************************/	
function js_alert_opener_parent_close_reload($msg){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
 		parent.opener.document.location.reload();
		parent.window.close();
		</script>");
		exit;
}


/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 서브밋
****************************************************************************/	
function js_alert_opener_submit_window_close($msg, $form, $options){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
		$options
 		opener.document.".$form.".submit();
		//window.close();
		</script>");
		exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 리플레쉬
****************************************************************************/	
function js_alert_close_reload($msg){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
 		opener.document.location.reload();
		window.close();
		</script>");
		exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 부모페이지 리플레쉬
****************************************************************************/	
function js_alert_parent_reload($msg){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
 		parent.location.reload();
		</script>");
		exit;
}


/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 리플레쉬
****************************************************************************/	
function js_alert_close_parent_reload($msg){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
 		parent.location.reload();
		window.close();
		</script>");
		exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 리플레쉬
****************************************************************************/	
function js_alert_close_parent_parent_reload($msg){
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo ("
		<script>
		$alert
 		parent.opener.location.reload();
		parent.window.close();
		</script>");
		exit;
}

/***************************************************************************
* 자바스크립트 경고창 + 닫기 + 부모페이지 이동
****************************************************************************/	
function js_alert_parent_href($msg,$location) {
		if($msg) $alert = "window.alert ('$msg');";
		else $alert = "";
		echo
		("
		<script>
		$alert
		parent.document.location.href = '$location';
		</script>
		");
		exit;
}

/***************************************************************************
* 부모페이지 리플레쉬
****************************************************************************/	
function js_parent_reload(){
		echo ("
		<script>
 		opener.location.reload();
		</script>");
		exit;
}

/***************************************************************************
* 폴더생성
****************************************************************************/
function makedir($dir){
	if(!@mkdir($dir,0707)){
		js_alert_back ("[오류] ".$dir." 폴더 생성 실패!! (관리자에게 문의하세요.)");
	}
}

function attach($mode,$tmp,$name,$updir){
	if(!$tmp) return "";
	if($mode == "in"){
		$val = renamefile($name,$updir,"1");
		uploadfile($tmp,$val,$updir);
		$val = $name."|".$val;
	}else{
		unlink($updir."/".$tmp);
		$val = "";
	}
	return $val;
}

/***************************************************************************
* 지정한폴더에 파일 업로드
****************************************************************************/
function uploadfile($file,$filename,$dir,$rename=false){ 
	if(!copy($file,$dir."/".$filename)){
		//js_alert_back("파일 업로드 실패!! (관리자에게 문의하세요.)");
	}
	if($rename){
		if(!rename($dir."/".$filename,$dir."/".$rename)){
			//js_alert_back("파일 업로드 실패!! (관리자에게 문의하세요.)");
			unlink($dir."/".$filename);
		}
	}
}

/***************************************************************************
* 업로드전 중복되는 파일이 있을경우 파일명 변경
****************************************************************************/
function renamefile($fn,$dir,$flag=""){
	if(!is_dir($dir)) makedir($dir);
	$fileExt = substr(strrchr($fn, "."), 1);
	$fileName = substr($fn, 0, strlen($fn)-strlen($fileExt)-1);
	if($flag) return MD5(microtime()).".".$fileExt;
	if(file_exists($dir."/".$fn)){
		$i=1;
		while(file_exists($dir."/".$fn)){
			$filename = $fileName."(".$i.").".$fileExt;
		    if(!file_exists($dir."/".$filename)){
				break;
			}
		$i++;
	    }
		$fname = $filename;
	}else{
		$fname = $fn;
	}
	return $fname;
}


/***************************************************************************
* 파일 확장자 구하기
****************************************************************************/
function get_file_ext($file){
	$fileExt = substr(strrchr($file, "."), 1);
	$fileName = substr($file, 0, strlen($file)-strlen($fileExt)-1);

	return $fileExt;
}

/***************************************************************************
* 이메일주소체크 정규식
****************************************************************************/
function email_check($email){
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$",$email,$validated_email)) {
		js_alert_back("잘못된 전자우편을 기입했습니다.");
		exit;
	}
}

/***************************************************************************
* 메타태그를 이용한 페이지 이동
****************************************************************************/

function redirect($url){
	$goto = "<meta http-equiv='Refresh' content='0; URL=$url'>";
	print $goto;
}

/***************************************************************************
* 2015-01-01 와같은 형식의 날짜를 타임스탬프 형식으로 변환
****************************************************************************/
function strToDate($day,$f){
	if(empty($day))return false;
		$tmp = explode("-",$day);
		if($f == "s"){
			return mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
		}else{
			return mktime(23,59,59,$tmp[1],$tmp[2],$tmp[0]);
	}
}

/***************************************************************************
* 현재페이지의 full address 를 반환
****************************************************************************/
function geturl(){
	$server = getenv("SERVER_NAME");
	$file = getenv("SCRIPT_NAME");
	$querys = getenv("QUERY_STRING");
	$url = "http://".$server.$file;
	if($query) $url.="?".$querys;
	return $url;
}

/***************************************************************************
* 셀렉트박스 형식의 날짜 (년) 
****************************************************************************/	 
function select_year($ye=""){
	$toyear=date("Y");
	for($y=$toyear-5; $y<$toyear+5;$y++){
		if($y==$ye){
			$date_year.="<option value='$y' selected>$y</option>\n";
		}else{
			$date_year.="<option value='$y'>$y</option>\n";
		}
	}
	return $date_year;
}

/***************************************************************************
* 셀렉트박스 형식의 날짜 (년)
****************************************************************************/	 
function select_year_start_end($start, $end, $cur=""){
	//$toyear=date("Y");
	if(!$cur)	$cur	= "1980";
	for($start; $start<$end+1;$start++){
		if($start==$cur){
			$date_year.="<option value='$start' selected>$start</option>\n";
		}else{
			$date_year.="<option value='$start'>$start</option>\n";
		}
	}
	return $date_year;
}


/***************************************************************************
* 셀렉트박스 형식의 날짜 (월)
****************************************************************************/	 
function select_month($mo=""){	
	$tomonth = date("m");
	for($m=1;$m<=12;$m++){			
		if(strlen($m) == 1) $m = "0".$m;
		if($m == $mo){
			$date_month .= "<option value='$m' selected>$m</option>\n";
		}else{
			$date_month .= "<option value='$m'>$m</option>\n";
		}
	}			
	return $date_month;
}

/***************************************************************************
* 셀렉트박스 형식의 날짜 (일)
****************************************************************************/	
function select_day($da){
	$today = date("d");
	for($d=1;$d<=31;$d++){
		if(strlen($d) == 1) $d = "0".$d;
		if ($d == $da){
			$date_day.="<option value='$d' selected>$d</option>\n";
		}else{
			$date_day.="<option value='$d'>$d</option>\n";
		}	
	}
	return $date_day;
}

/***************************************************************************
* 셀렉트박스 형식의 날짜 (시간)
****************************************************************************/	
function select_hour($h=""){
	for($i=1;$i<=24;$i++){
		if(strlen($i) == 1) $i = "0".$i;
		if ($i == $h){
			$val.="<option value='$i' selected>$i</option>\n";
		}else{
			$val.="<option value='$i'>$i</option>\n";
		}	
	}
	return $val;
}

/***************************************************************************
* 셀렉트박스 형식의 날짜 (분)
****************************************************************************/	
function select_minute($m=""){
	for($i=1;$i<=59;$i++){
		if(strlen($i) == 1) $i = "0".$i;
		if ($i == $m){
			$val.="<option value='$i' selected>$i</option>\n";
		}else{
			$val.="<option value='$i'>$i</option>\n";
		}	
	}
	return $val;
}

/***************************************************************************
* 이전페이지를 구하는 함수
****************************************************************************/
function prevpage(){
	global $REQUEST_METHOD, $HTTP_REFERER;
	if($REQUEST_METHOD == "GET"){
		$prevpage = $HTTP_REFERER;
	}else{
		$prevpage = $HTTP_REFERER."".getenv("QUERY_STRING");
	}
	return $prevpage;
}

/***************************************************************************
* 이전페이지의 입력했던 폼 내용을 유지하는 함수
****************************************************************************/
function page_cache(){ 
	session_cache_limiter("");
	session_start();
}

/***************************************************************************
* 엑셀로 받기위해 헤더를 선언한다. 예) excel_header("파일명")
****************************************************************************/
function excel_header($fname){
	//print header("Content-Disposition: attachment; filename=".$fname.".xls");
	//print header("Content-Type: application/x-msexcel");

	//print header("Content-type: application/vnd.ms-excel");
	print header( "Content-type: application/vnd.ms-excel;charset=UTF-8" );
	print header( "Content-Disposition: attachment; filename=".$fname.".xls" );
	print header( "Content-Description: PHP4 Generated Data" );
}

/***************************************************************************
* 폼으로 전송된 HTML 을 엑셀로 변환
****************************************************************************/
function excel_page($data){
	$date = date("Y-m-d-h-i-s",time());
	$head = "<tr><td colspan=".$data[colspan]." height=50><h3>$data[title]</h2></td></tr>";
	$data[contents] = stripslashes($data[contents]);
	$data[contents] = str_replace("&nbsp;","",$data[contents]);
	$data[contents] = str_replace("border=0","border=1",$data[contents]);
	if($pos = strpos($data[contents],">")){
		$str1 = substr($data[contents],0,$pos+1);
		$str2 = substr($data[contents],$pos+1);
		$data[contents] = $str1 . $head . $str2;
	}
	excel_header($data[title]);
	print("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ks_c_5601-1987\">");
	print($data[contents]);
}

/***************************************************************************
* 간단한 로딩 이미지를 출력
****************************************************************************/
function loading($txt){
	//$msg = "<b>로딩중.....</b>";
	$msg  = "";
	$msg .= "<div id=\"loading\" style=\"position:absolute;display:none\">";
	$msg .= "<table width=\"400\" cellspacing=\"1\" cellpadding=\"4\" bgcolor=\"#000000\">";
	$msg .= "<tr>";
	$msg .= "<td bgcolor=\"#cccccc\" align=\"center\" height=\"100\"><b>".$txt."....</b></td>";
	$msg .= "</tr>";
	$msg .= "</table>";
	$msg .= "</div>";
	return $msg;
}

/***************************************************************************
* 텍스트파일을 읽어드린 후 내용을 반환한다.
****************************************************************************/
function txtfile_read($src){
	$fopen = fopen($src,"r");
	if(!$fopen) return false;
	while(!feof($fopen)){
		$row = fgetc($fopen);
		$contents .= $row;
	}
return $contents;
}


/***************************************************************************
* 2차원배열을 1차원배열로 돌려주는 함수
****************************************************************************/
function key_value($data, $dynamic=false){
	for($i=0;$i<count($data);$i++){
		$row  = $data[$i];
		$keys = array_keys($row);
		if(count($row) == 1){
			$tmp[$row[$keys[0]]] = $dynamic ? $row : $row[$keys[0]];
		}else{
			$tmp[$row[$keys[0]]] = $dynamic ? $row : $row[$keys[1]];
		}
	}
	return $tmp;
}

/***************************************************************************
* 페이지출력을 위한 변수처리 함수
****************************************************************************/
function strForpage($arr,$reject=false){
	foreach($arr as $key => $value) {
		if($key != $reject){
			if(is_array($value)){
				$val = base64_encode(serialize($value));
			}else{
				$val = stripslashes($value);
			}
			if($i!=0) $string .="&";
			$string .= $key."=".$val;
		$i++;
		}
	}
	return $string;
}

/***************************************************************************
* 페이지출력함수
****************************************************************************/
function page($total,$blucksize,$pagesize, $option=""){
	global $PHP_SELF, $_GET,$_POST, $this_page;
	if($total < $blucksize) return;
	$pgurl = $PHP_SELF;
	$icons = array(fisrt => "처음",prev => "이전",next => "다음",last => "맨끝");

	$request = $_GET;
	if(is_array($_POST) && $_POST) $request = array_merge($request,$_POST);	
	$string[] = strForpage($request,"page");
	$querystr = implode("&",$string);

	/* 전체 페이지수*/
	$total_page  = ceil($total/$blucksize);
	/* 시작 페이지 */
	$spage = intval(($this_page-1)/$pagesize)*$pagesize+1;
	/* 마감 페이지 */
	$epage = intval(((($spage-1)+$pagesize)/$pagesize)*$pagesize);
					
					/*  기본 샘플
					<div class="paging">
						<a href="#" class="arrow first">처음</a>
						<a href="#" class="arrow prev">이전</a>
						<span>1</span>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#">5</a>
						<a href="#">6</a>
						<a href="#">7</a>
						<a href="#">8</a>
						<a href="#">9</a>
						<a href="#">10</a>
						<a href="#" class="arrow next">다음</a>
						<a href="#" class="arrow last">마지막</a>
					</div>*/


	// FIRST PAGE
	//$cur_page = $this_page > 1 ? "<a href='$pgurl?$querystr&this_page=1$option' class='arrow first'>처음</a>";
	$cur_page = $this_page > 1 ? "<span class='arrow first'><a href='$pgurl?$querystr&this_page=1$option' class='arrow first'>".$icons[fisrt]."</a></span> " : "<span class='arrow first'>".$icons[fisrt]."</span> ";
	
	// PREV PAGE
	if($total_page <= $epage) $epage = $total_page;		
	if($this_page > $pagesize){
		$curpage = intval($spage-1);
		$cur_page.="<a href='$pgurl?$querystr&this_page=$curpage$option' class='arrow prev'>이전</a> ";
	}
	// PAGING
	for($direct_page = $spage; $direct_page <= $epage; $direct_page++) {	
		if($this_page == $direct_page){
			$cur_page .= '<span>'.$direct_page.'</span> ';
		}else{
			$cur_page .= "<a href='$pgurl?$querystr&this_page=$direct_page$option'>".$direct_page."</a> ";
		}
	}
	// NEXT PAGE
	if($total_page > $epage){
		$curpage = intval($epage+1);
		$cur_page .= "<a href='$pgurl?$querystr&this_page=$curpage$option' class='arrow next'>다음</a> ";
	}
	// LAST PAGE
	$cur_page .= $this_page >= $total_page ? " <span class='arrow last'>".$icons[last]."</span> " : "<span class='arrow last'><a href='$pgurl?$querystr&this_page=$total_page$option' >".$icons[last]."</a></span>";

return $cur_page;
}

/***************************************************************************
* 헤더를 이용한 첨부파일 다운로드
****************************************************************************/
function file_download_header($path,$name){
	global $HTTP_USER_AGENT;
	$d = ($d) ? "attachment" : "inline";
	if(eregi("(MSIE)", $HTTP_USER_AGENT)){
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$name");
		header("Content-Transfer-Encoding: binary");
	}else{
		header("Content-type: application/octet-stream");
		header("Content-Disposition: $d; filename=$name");
		header("Content-Description: PHP3 Generated Data");
	}
	if(is_file($path)){
		$fp = fopen($path, "r");
		if(!fpassthru($fp)) fclose($fp);
	}
}

/***************************************************************************
* " 를 &quot로 바꿔주는 함수
****************************************************************************/
function quot($str){
	return str_replace("\"","&quot",$str);
}

/***************************************************************************
* 현재 페이지의 URL을 돌려주는 함수
****************************************************************************/
function getLink(){
	global $_GET,$_POST,$PHP_SELF;
	$request = $_GET;
	if (is_array($_POST) && $_POST) $request = array_merge($request,$_POST);
	foreach ($request as $key=>$value ){
		if(gettype($value) == "array") $value = base64_encode(serialize($value));
		if ($value != "" OR strlen($value) < 20) $new_req[] = "$key=$value";
	}
	if($new_req){
	    return urlencode($PHP_SELF ."?". implode("&",$new_req));
	}else{
		return urlencode($PHP_SELF);
	}
}

/***************************************************************************
* 디렉터리를 읽어서 파일목록을 배열로 돌려주는 함수
****************************************************************************/
function read_dir($dir){
	$array = array();
	$d = dir($dir);
	while (false !== ($entry = $d->read())){
		if($entry!='.' && $entry!='..'){
			$entry = $dir.'/'.$entry;
			if(is_dir($entry)){
				$array[] = $entry;
				$array = array_merge($array,read_dir($entry));
			}else{
				$array[] = $entry;
			}
		}
	}
	$d->close();
	return $array;
}

/***************************************************************************
* 배열1의 키값과 배열2값이 같은 경우 배열1만 배열로 돌려주는 함수
****************************************************************************/
function array_keys_intersect($array,$keys) {
	if(!is_array($keys)) return false;
	foreach($keys as $value){
		if(isset($array[$value])) $aTmp[$value] = $array[$value];
	}
	return $aTmp;
}

/***************************************************************************
* 값을 홀따옴표로 묶어서 돌려주는 함수  
****************************************************************************/
function quote($value){
	if(ini_get('magic_quotes_gpc')) return $value;
	if(is_array($value)){
		foreach ($value as $xkey=>$xvalue){
			$value[$xkey] = str_replace("'","''",$xvalue);	    
		}
	}else{
		$value = str_replace("'","''",$value);
	}
	return $value;
}

/***************************************************************************
* 숫자에 컴마추가 (금액)
****************************************************************************/
function addcomma(&$v) {
	if (is_array($v)) {
		foreach ($v as $key=>$value ) {
			if (is_numeric($value)) {
				if ($value+0 != 0 && strstr($value,'.')) {
					$value .= '';
					$v[$key] = number_format(substr($value,0,strrpos($value,'.'))) . substr($value,strrpos($value,'.'));
				}else{
					$v[$key] = number_format($value);
				}
			}
		}
	}else{
		$v = number_format($v);
	}
}

/***************************************************************************
* 컴마제거
****************************************************************************/
function removecomma(&$v){
	if(is_array($v)){
		foreach($v as $key=>$value ){
			removecomma($value);
			$v[$key] = $value;
		}
	}else{
		$v = str_replace(",","",$v);
	}
}

/***************************************************************************
* 컴마제거2
****************************************************************************/
function removecomma2($v){
	$v = str_replace(",","",$v);
	return $v;
}

/***************************************************************************
* 0값제거
****************************************************************************/
function zeroToEmpty(&$row) {
	if (is_array($row) && $row) {
	    foreach ($row as $key=>$value ) {
			if (!$value) $row[$key] = '';
	    }
	}else{
		if (!$row) $row = '';
	}
}

/***************************************************************************
* 0값제거 2
****************************************************************************/
function zeroToEmpty2($row) {
	if (!$row or $row=='0') {
	    $row = '';
	}
	return $row;
}

/***************************************************************************
* 이전달 , 다음달 구하기 ($yymm 은 200604 과 같은 형식으로)
****************************************************************************/
function freeyymm($flag,$yymm){
	if(!$yymm) return date("Ym");
	return date("Ym",strtotime($flag,strtotime($yymm."01")));
}

/***************************************************************************
* 두날짜 사이의 모든날짜 배열
****************************************************************************/
function dateGap($sdate,$edate){
	$sdate = str_replace("-","",$sdate);
	$edate = str_replace("-","",$edate);
	for($i=$sdate;$i<=$edate;$i++){
		$year	= substr($i,0,4);
		$month	= substr($i,4,2);
		$day	= substr($i,6,2);
		if(checkdate($month,$day,$year)){
			$date[$year."-".$month."-".$day] = $year."-".$month."-".$day;
		}
	}
	return $date;
}

/***************************************************************************
* 두월 사이의 모든날짜 배열
****************************************************************************/
function monthGap($sm,$em){
	//$d1 = "2004-10-1"; 
	//$d2 = "2005-02-2";
	if($sm == "" || $em == "") return;
	$sm = str_replace("-","",$sm)."01";
	$em = str_replace("-","",$em)."01";
	$time1 = strtotime($sm); 
	$time2 = strtotime($em); 
	for($i=$time1; $i<=$time2; $i+=86400*date("t",$i)){ 
		$arr[date("Y-m",$i)] = date("Y-m",$i); 
	}
	return $arr;
}

/***************************************************************************
* 금액의 원단위를 절삭
****************************************************************************/
function removeWon($val){
	return @substr($val,-1) >= 1 ? substr($val,0,strlen($val)-1)."0" : $val;
}

/***************************************************************************
* 2차원배열의 지정한 필드의 합계를 구하는 함수  
****************************************************************************/
function array_key_sum($arr,$key){
	for($i=0;$i<sizeof($arr);$i++){	
		$res += $arr[$i][$key];
	}
	return $res;
}

/***************************************************************************
* Returns a human readable size 여기부터
****************************************************************************/
function size_hum_read($size){
	$i=0;
	$iec = array("B", "K", "M", "G", "T", "P", "E", "Z", "Y");
	while(($size/1024)>1){
		$size = @round($size/1024,1);
		$i++;
	}
	return substr($size,0,strpos($size,'.')+4).$iec[$i];
}

/***************************************************************************
* 요일별 칼라를 입혀서 리턴시켜주는 함수
****************************************************************************/
function daycolor($code,$color,$long=false){
	$dayarr = array("일","월","화","수","목","금","토");
	if(!$color){
		if($code == 0){
			$color = "#ff0000";
		}else if($code == 6){
			$color = "#0000ff";
		}else{
			$color = "#000000";
		}
	}
	$day = $dayarr[$code]; if($long) $day .= "요일";
	return "<font color='".$color."'>".$day."</font>";
}
?>