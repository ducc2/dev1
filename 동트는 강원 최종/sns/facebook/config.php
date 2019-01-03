<?php

define('FACEBOOK_APP_ID', '262593500740353');
define('FACEBOOK_APP_SECRET', 'e17400c3eda8c61b7d0a63bb82f22c14');
define('FACEBOOK_APP_CALLBACK', 'http://test.dongtuni.com/sns/facebook/_callback.php');

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ .'/');
require_once __DIR__ . '/autoload.php';


$fb = new Facebook\Facebook([
  'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
  'app_secret' => FACEBOOK_APP_SECRET,
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();