<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

 $CLIENT_ID     = "006c1d32c53a68ed82261404f80f7ba8";
 $REDIRECT_URI  = "http://test.dongtuni.com/sns/kakaotalk/index.php";
 $TOKEN_API_URL = "https://kauth.kakao.com/oauth/token";

 $code   = $_GET["code"];
 $params = sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', $CLIENT_ID, $REDIRECT_URI, $code);

 $opts = array(
   CURLOPT_URL => $TOKEN_API_URL,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSLVERSION => 1, // TLS
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $params,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_HEADER => false
 );

 $curlSession = curl_init();
 curl_setopt_array($curlSession, $opts);
 $accessTokenJson = curl_exec($curlSession);
 curl_close($curlSession);

$at = json_decode($accessTokenJson);

$TOKEN_API_URL = "https://kapi.kakao.com/v1/user/me";

 $opts = array(
   CURLOPT_URL => $TOKEN_API_URL,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSLVERSION => 1,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => false,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_HTTPHEADER => array(
 "Authorization: Bearer " . $at->access_token
 )
 );

 $curlSession = curl_init();
 curl_setopt_array($curlSession, $opts);
 $accessTokenJson = curl_exec($curlSession);
 curl_close($curlSession);
 $user = json_decode($accessTokenJson);

$_SESSION['SNS_LOGIN']['name'] = $user->properties->nickname;
$_SESSION['SNS_LOGIN']['id'] = $user->id;
$_SESSION['SNS_LOGIN']['sns'] = 'KAKAOTALK';
?>
<script>
window.opener.location.reload();
	alert('로그인되었습니다.');
window.close();
</script>

