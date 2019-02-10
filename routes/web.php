<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$ctr = "Controller";
Route::get('wallet/', 'Rpc' . $ctr . '@index');
Route::get('wallet/{view?}','Rpc'.$ctr.'@views');
Route::post('wallet/rpc/{method?}','Rpc'.$ctr.'@rpc');

/** Cho
 * Coin Json-RPC Controller Routers
 * ctr = Controller
 * @param $method,$param
 * @return $data
*/
Route::match(['get', 'post'],'v1/api/rpc/{method?}/{param?}/{account?}','Api'.$ctr.'@api');

Route::post('v1/api/pool', 'Api' . $ctr . '@poolCheck');
Route::match(['get', 'post'],'v1/api/ticker', 'Api' . $ctr . '@addTicker');

Route::match(['get', 'post'],'v1/api/getticker', 'Api' . $ctr . '@getTicker');
Route::post('v1/api/ordermail', 'Api' . $ctr . '@orderMail');

Route::post('v1/api/confirm', 'Api' . $ctr . '@checkConfirm');
//Route::match(['get', 'post'],'v1/api/confirm','Api'.$ctr.'@checkConfirm');

Route::get('v1/api/nav','Api' . $ctr . '@navHeaderMenu');

Route::get('gnb/{nav}','Common' . $ctr . '@gnbMenu'); //GNB Menu

/*
	Admin Controller
 */

Route::get('admin', 'Admin' . $ctr . '@index');

Route::post('admin/signin', 'Admin' . $ctr . '@signIn');

Route::get('admin/pet/video', 'Admin' . $ctr . '@views');
Route::get('admin/pet/report', 'Admin' . $ctr . '@views'); //관리자 신고
Route::get('admin/sys/reportmenu', 'Admin' . $ctr . '@views'); //관리자 신고 메뉴 등록
Route::get('admin/sys/navmenu', 'Admin' . $ctr . '@views'); //펫,마켓 모바일 메뉴

Route::get('admin/mem/lists','Admin' . $ctr . '@views'); // 관리자 회원 리스트
Route::post('admin/mem/lists_search','Admin' . $ctr . '@views'); // 관리자 회원 검색
Route::post('admin/mem/lists_detail','Admin' . $ctr . '@views');  // 관리자 회원 상세보기



Route::post('admin/sys/report/add','Admin' . $ctr . '@sysPrc');
Route::post('admin/sys/report/modify','Admin' . $ctr . '@sysPrc');
Route::post('admin/sys/report/del','Admin' . $ctr . '@sysPrc');

Route::post('admin/sys/menu/add','Admin' . $ctr . '@sysPrc');

Route::get('admin/pet/reward', 'Admin' . $ctr . '@views'); //관리자 보상
Route::get('admin/pet/reward_add', 'Admin' . $ctr . '@views'); //관리자 보상등록
Route::post('admin/pet/reward_edit', 'Admin' . $ctr . '@reward_prc'); //관리자 보상처리
Route::post('admin/pet/reward_prc', 'Admin' . $ctr . '@reward_prc'); //관리자 보상처리


Route::post('admin/report/list','Admin' . $ctr . '@reportPrc');
Route::post('admin/report/modify','Admin' . $ctr . '@reportPrc');
Route::post('admin/report/getcontent','Admin' . $ctr . '@getContent');

Route::get('admin/pool/dashboard', 'Admin' . $ctr . '@views'); //관리자 Pool
Route::post('admin/pool/stat', 'Admin' . $ctr . '@poolStat'); //관리자 Pool



Route::get('admin/market/{method?}', 'Admin' . $ctr . '@market');
//Route::get('admin/pet/{method?}', 'Admin' . $ctr . '@pet');
Route::get('admin/sys/menu', 'Admin' . $ctr . '@idnex');

Route::get('admin/cent/exchangeList', 'Admin' . $ctr . '@exchangeList'); // 2019-02-01관리자 cent정산 신청 목록
Route::post('admin/cent/exchange', 'Admin' . $ctr . '@exchange'); // 2019-02-01관리자 cent정산 신청 목록



/*
	Pet Controller
*/
// Route::get('pet/','Pet' . $ctr . "@index");
// Route::get('pet/{view?}','Pet' . $ctr . "@index"); //View Route
// Route::get('petstar','Pet' . $ctr . "@petstar"); //View Route
// Route::get('petsitter','Pet' . $ctr . "@petsitter"); //View Route
// Route::get('pet/{method?}/{view?}/','Pet' . $ctr . "@index"); //View Route

/* Ohwe platform [ Pet ]*/
Route::get('/','Ohwe' . $ctr . '@index');

Route::get('/petstar','Ohwe' . $ctr . "@views"); //View petstar
Route::get('/petstar/align/{type}','Content' . $ctr . "@alignList"); // 2019-01-21 박지연 펫스타 메인 업데이트순|인기순|조회순 route
Route::get('/petstar/more/{type}/{cnt}','Content' . $ctr . "@moreList"); // 2019-01-21 박지연 펫스타 메인 썸네일 게시물 더보기 route


//콘텐츠
Route::get('/petstar/contentadd','Ohwe' . $ctr . "@views"); //콘텐츠 등록 View petstar
Route::get('/petstar/contentmod/{param?}','Ohwe' . $ctr . "@views"); //콘텐츠 등록 View petstar
Route::get('/petstar/like/list/{contentId}','Content' . $ctr . "@likeList"); // 2019-01-29 박지연 좋아요 리스트
Route::get('/petstar/follow/list/{channelId}','Content' . $ctr . "@followList"); // 2019-01-29 박지연 좋아요 리스트

Route::get('/terms','Ohwe' . $ctr . "@views"); // 이용약관
Route::get('/private','Ohwe' . $ctr . "@views"); // 개인정보처리방침

//채널
Route::get('/petstar/channelnew','Ohwe' . $ctr . "@views"); //채널 생성 View petstar
Route::get('/petstar/channelmod','Ohwe' . $ctr . "@views"); //채널 수정 View petstar
Route::post('/petstar/channelnew','Pet' . $ctr . "@channelnew"); //채널 생성
Route::post('/petstar/channelmod','Pet' . $ctr . "@channelMod"); //채널 수정

//펫 프로필
Route::get('/petstar/petprofileadd','Ohwe' . $ctr . "@views");
Route::get('/petstar/petprofilemodify/{petProfileId}','Ohwe' . $ctr . "@views");// 2019-01-21 박지연 펫 프로필 수정


Route::get('/channel/mychannel/{param?}','Ohwe' . $ctr . "@views"); //View channel

Route::post('/channel/upload','Pet' . $ctr . "@uploadFile"); //영상,이미지 등록
Route::post('/channel/list','Content' . $ctr . "@contentList"); //채널 목록 가져오기
Route::post('/channel/modify','Content' . $ctr . "@contentSubmit"); //게시하기 및 수정
Route::post('/channel/delContent','Content' . $ctr . "@contentDel"); //컨텐츠 삭제

Route::post('/channel/follower','Pet' . $ctr . "@follower"); //팔로우
Route::post('/channel/like','Pet' . $ctr . "@like"); //좋아요
Route::post('/channel/comment','Pet' . $ctr . "@comment"); //댓글

Route::post('/channel/report','Pet' . $ctr . '@reportPrc'); //신고

Route::post('/pet/channel/modify','Pet' . $ctr . '@channelPrc'); //채널 수정 /*20190115 추가 */
Route::post('/pet/channel/add','Pet' . $ctr . '@channelPrc'); //채널 등록 /*20190115 추가 */

Route::post('/content/show','Content' . $ctr . "@contentShow"); //콘텐츠 공개 비공개

Route::post('/pet/profile/add','Profile' . $ctr . '@petProfilePrc'); //펫 프로필 등록 /*20190118 추가 */
Route::post('/pet/profile/modify','Profile' . $ctr . '@petProfilePrc'); // 2019-01-21 박지연 펫 프로필 수정

/*
    Pet API
*/
Route::get('/v1/pet/api/instar','Api' . $ctr . "@instar"); //인스타그램 API
Route::post('/v1/pet/api/kakao/callback','Api' . $ctr . "@share"); //카카오 콜백 API
Route::get('/v1/pet/api/facebook/callback','Api' . $ctr . "@share"); //페이스북 콜백 API


Route::post('/channel/content','Content' . $ctr . "@getContent"); //채널 목록 가져오기

Route::get('/channel/content/{param?}','Ohwe' . $ctr . "@views"); //채널 1개 가져오기

Route::get('/petstar/tag/{param?}','Ohwe' . $ctr . "@views"); //채널 1개 가져오기


Route::post('/pet/userChk','Ohwe' . $ctr . "@userChk"); //회원 로그인 체크


Route::get('/aboutpet','Ohwe' . $ctr . "@views"); //View aboutpet
Route::get('/petsitter','Ohwe' . $ctr . "@views"); //View petsitter




//Route::get('/signin','Ohwe'.$ctr.'@signIn');
//Route::view('user/signup', 'user.signUp');
Route::get('content', 'ContentController@video_list'); //video 전체 list
Route::get('content/score', 'ContentController@video_score_list'); //점수 video list
Route::get('content/{id}', 'ContentController@detail');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/verify/{verification_code}', 'ContentController@verifyUser');

/* Ohwe shop */
Route::prefix('shop')->group(function () {
    $s_ctr = 'ShopController';
    Route::get('', $s_ctr.'@index');
    Route::get('detail/{id}', $s_ctr.'@shop_detail_list');
    Route::get('aboutshop/about', $s_ctr.'@list')->name('about');
    Route::get('whatsnew', $s_ctr.'@list')->name('whatsnew');
    Route::get('best', $s_ctr.'@list')->name('best');
    Route::get('ohweonly', $s_ctr.'@list')->name('ohweonly');
    Route::get('event', $s_ctr.'@shop_event_list')->name('event');
    Route::get('event/item/{id}', $s_ctr.'@shop_event_item_list');
    Route::view('cart', 'shop.cart');
    // Route::get('cart/detail/{id}', 'cart');
    Route::view('cart/detail', 'shop.cart.detail'); //-- test
    // Route::get('support/notice', $s_ctr.'@shop_support_notice_list');
    // Route::get('support/notice/detail/{id}', $s_ctr.'@shop_support_notice_detail');
    // Route::get('support/faq', $s_ctr.'@shop_support_faq_list');
    // Route::get('support/faq/detail/{id}', $s_ctr.'@shop_support_faq_detail');
    Route::view('support/notice', 'shop.support.notice.list'); //view test
    Route::view('support/faq', 'shop.support.faq.list'); //view test
    Route::view('support/qna', 'shop.support.qna.list'); //view test

});

/* Ohwe pet */
// Route::get('pet/','Pet' . $ctr . "@index");
Route::view('pet', 'pet.index'); //view test
Route::get('pet/{view?}','Pet' . $ctr . "@index"); //View Route
//Route::get('pet/{method?}/{view?}/','Pet' . $ctr . "@index"); //View Route
Route::get('pet/about','Pet' . $ctr . "@views");

/*
	Walletnotify
*/
Route::post('rpc/walletnotify','Api'.$ctr.'@walletnotify');

Route::post('v1/api/walletnotify','Api'.$ctr.'@platformWalletnotify');


/*
    mail API
    2018.01.08 강소윤
*/
Route::post('/mail/api','Mail'.$ctr.'@index');
