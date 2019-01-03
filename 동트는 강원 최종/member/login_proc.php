<?
$sh["rPath"]	= "..";
include_once($sh["rPath"]."/_common.php");
$DB		= new database;
$data	= $_POST;

//post가 아니면 차단.
if(strcmp($_SERVER[REQUEST_METHOD],"POST")){
	js_alert_back('잘못된 접근입니다. 다시 시도해 주세요.');
	exit;
}

//공백제거
array_walk($data, 'array_trim');

//널체크
$check_data		= array("mem_id"=>"아이디", "mem_password"=>"비밀번호");
$check_result	= null_check($data, $check_data);
$member			= $DB->get_member_info($data[mem_id]);

if (!$member[mem_id] || ($DB->get_mysql_password($data[mem_password]) != $member[mem_password])) {
    js_alert_back('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n다시 확인해 보세요.');
}

if ($member[mem_leave_date]) {
    js_alert_back('탈퇴 회원입니다. 접근 할 수 없습니다.');
}

//세션 저장
$mem_id_session	= $member[mem_id];
set_session("mem_id_session", $member[mem_id]);

//관리자 세션 저장
if($member[mem_level] > 8){
	$admin_id_session		= $member[mem_id];
	$admin_member_session	= $member[mem_level];
	set_session("admin_id_session", $member[mem_id]);
	set_session("admin_member_session", $member[mem_level]);
}

// 아이디 쿠키에 한달간 저장
if ($auto_login) {
    // 자동로그인 (쿠키 한달간 저장)
    $key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $member[mem_password]);
    set_cookie('ck_mem_id', $member['mem_id'], 86400 * 31);
    set_cookie('ck_auto', $key, 86400 * 31);
    // 자동로그인 end ---------------------------
} else {
    set_cookie('ck_mem_id', '', 0);
    set_cookie('ck_auto', '', 0);
}

$up_data[mem_today_login]	= date("Y-m-d H:i:s");
$up_data[mem_login_ip]		= $_SERVER['REMOTE_ADDR'];
$DB->updateTable(MEM_TABLE, $up_data, "WHERE mem_no='$member[mem_no]'");

if ($referer) {
	if($cartnos){
		goto_url($sh["rPath"]."/shop/goods_order.php?cartnos=".$cartnos);
	}else{
		goto_url($referer);
	}
} else  {
	goto_url("/dongtuni_adm");
}
?>
