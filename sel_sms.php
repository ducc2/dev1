<?
		include $_SERVER['DOCUMENT_ROOT']."/inc/common.php"; 
		
		if ($_POST['check']) {
			
			$temp = explode(",",$_POST['check']);


			for($i=0;$i<count($temp);$i++){ 
			
				$query2 = "SELECT * from ".$tbname['apply']." where apply_idx=".$temp[$i];
				$result2 = mysqli_query($mysqli, $query2);
				$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

				$query3 = "insert into ".$tbname['tel']." set tel_content='".addslashes($_POST['msg'])."',tel_from='".$_POST['user_phone']."',tel_to='".$row2['apply_tel']."',tel_reg=NOW(),user_idx='".$_SESSION['ss_user_idx']."',apply_idx='".$temp[$i]."' ";

				if ($temp[$i]) { 
					$result3 = mysqli_query($mysqli, $query3);
				}
			}




       /******************** 인증정보 ********************/
        $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // 전송요청 URL
        // $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS 전송요청 URL
        $sms['user_id'] = base64_encode("proudurology"); //SMS 아이디.
        $sms['secure'] = base64_encode("44a90b3108577fcbe591ebf319d856a3") ;//인증키
        $sms['msg'] = base64_encode(stripslashes($_POST['msg']));
        if( $_POST['smsType'] == "L"){
              $sms['subject'] =  base64_encode($_POST['subject']);
        }

		$tem = explode("-",$_POST['user_phone']);	

        $sms['rphone'] = base64_encode($_POST['rphone']);
        $sms['sphone1'] = base64_encode($tem[0]);
        $sms['sphone2'] = base64_encode($tem[1]);
        $sms['sphone3'] = base64_encode($tem[2]);
        $sms['rdate'] = base64_encode($_POST['rdate']);
        $sms['rtime'] = base64_encode($_POST['rtime']);
        $sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
        $sms['returnurl'] = base64_encode("/sms.html");
        $sms['testflag'] = base64_encode($_POST['testflag']);
        $sms['destination'] = strtr(base64_encode($POST['destination']), '+/=', '-,');
        $returnurl = $_POST['returnurl'];
        $sms['repeatFlag'] = base64_encode($_POST['repeatFlag']);
        $sms['repeatNum'] = base64_encode($_POST['repeatNum']);
        $sms['repeatTime'] = base64_encode($_POST['repeatTime']);
        $sms['smsType'] = base64_encode($_POST['smsType']); // LMS일경우 L
        $nointeractive = $_POST['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

        $host_info = explode("/", $sms_url);
        $host = $host_info[2];
        $path = $host_info[3]."/".$host_info[4];

        srand((double)microtime()*1000000);
        $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
        //print_r($sms);

        // 헤더 생성
        $header = "POST /".$path ." HTTP/1.0\r\n";
        $header .= "Host: ".$host."\r\n";
        $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

        // 본문 생성
        foreach($sms AS $index => $value){
            $data .="--$boundary\r\n";
            $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
            $data .= "\r\n".$value."\r\n";
            $data .="--$boundary\r\n";
        }
        $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

        $fp = fsockopen($host, 80);

        if ($fp) {
            fputs($fp, $header.$data);
            $rsp = '';
            while(!feof($fp)) {
                $rsp .= fgets($fp,8192);
            }
            fclose($fp);
            $msg = explode("\r\n\r\n",trim($rsp));
            $rMsg = explode(",", $msg[1]);
            $Result= $rMsg[0]; //발송결과
            $Count= $rMsg[1]; //잔여건수

            //발송결과 알림
            if($Result=="success") {
                $alert = "성공";
                $alert .= " 잔여건수는 ".$Count."건 입니다.";
            }
            else if($Result=="reserved") {
                $alert = "성공적으로 예약되었습니다.";
                $alert .= " 잔여건수는 ".$Count."건 입니다.";
            }
            else if($Result=="3205") {
                $alert = "잘못된 번호형식입니다.";
            }

            else if($Result=="0044") {
                $alert = "스팸문자는발송되지 않습니다.";
            }

            else {
                $alert = "[Error]".$Result;
            }
        }
        else {
            $alert = "Connection Failed";
        }
		

		}


        echo "<script>opener.window.location.reload(); window.close();</script>";
?>   