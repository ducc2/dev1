<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
header("Content-Type: text/html; charset=UTF-8");
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./clearsessions.php');
  
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);
/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';

  // 이부분에 디비 작업을 하시면됩니다.
  /*
  $up = mysql_query("update `member_db` set
                          oauth_token='$access_token[oauth_token]',
                          oauth_token='$access_token[oauth_token_secret]',
                          user_id='$access_token[user_id]',
                          screen_name='$access_token[screen_name]'
                     where user='$user' ");*/

  $_SESSION['SNS_LOGIN']['name'] = $access_token[screen_name];
  $_SESSION['SNS_LOGIN']['id'] = $access_token[user_id];
  $_SESSION['SNS_LOGIN']['sns'] = 'TWITTER';

  echo "<script>window.opener.location.reload();	alert('로그인되었습니다.');window.close();</script>";

  //echo "<a href='clearsessions.php'>Clear Sessions</a>";
  //header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: ./clearsessions.php');
}
?>