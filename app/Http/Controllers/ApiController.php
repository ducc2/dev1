<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RpcController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\RewardController as RewardC;
use Mail;

class ApiController extends Controller
{
    private $rpc; //RPC Method
    private $clientId;
    private $secretKey;
    private $redirectUri;
    private $errors;

     /**
     * Construct
     * @param RpcController 
     */
    public function __construct(RpcController $rpc,RewardC $RewardC)
    {
        $this->rpc = $rpc;
		$this->RewardCont = $RewardC;
        $this->db = DB::connection('aws'); //DB 커넥션 
            
        date_default_timezone_set('Asia/Seoul');

    }
    private function instarCode()
    {
        $authRequestUrl = 'https://api.instagram.com/oauth/authorize/?client_id='.$this->clientId.'&redirect_uri='.$this->redirectUri .'&response_type=token';
        echo $authRequestUrl;
        //$this->getCurl($authRequestUrl);
    }
    private function getCurl($url)
    {
        $ch = curl_init();  
 
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //  curl_setopt($ch,CURLOPT_HEADER, false); 
 
        $json=curl_exec($ch);
        
        curl_close($ch);
        $objData = json_decode($json);
        return $objData;
    }
    //DB에 저장한 평균 코인 금액 가져오기 
    public function getTicker(Request $req)
    {
        $symbol = "ohc";
        $reqParam = $req->type; //어디서 요청했는지 .. 마켓 or 펫
        switch ($reqParam ) {
            case 'coingecko':
                $api = $reqParam;
                break;
            default:
                $api = "coingecko";
                break;
        }
        //$getDate = date("Y-m-d H:i:s");
        $getDate = date("Y-m-d H");

        $start = $getDate . ":00:00";
        $last = $getDate . ":59:00";
        
        $ticker = $this->db->table("sys_ticker")
            ->where("api",$api)
            ->where("symbol",$symbol)
            ->whereBetween("created_date",[$start,$last])
            ->orderBy("idx","desc")
            ->first(); //채널 조회
        

        $returnData = array(
            "name" => $ticker->name,
            "current_price" => $ticker->current_price,
            "created_date" => $ticker->created_date
        );
        return response()->json($returnData);
        //print_r($returnData);
    }
    public function checkConfirm(Request $req)
    {

        //메일 부분 처리
        //$mail['toEmail'] = "leekwanmo1@gmail.com";
        $mail['toEmail'][0] = "xuemei0227@naver.com";
        $mail['toEmail'][1] = "ymdev1218@gmail.com";
        $mail['fromEmail'] = 'support@ohwecoin.io';
        $mail['fromName'] = 'Ohwe';
        $mail['subject']= '오위 코인 입금완료 처리 ';


        $payTx = $this->db->table('om_test_ohwe.ohwe_paytx')
            //->whereNotNull("to_address")
            ->whereNotNull("txid")
            ->where("confirm",'<',10)
            ->get();
        
        
        foreach($payTx as $k=>$v){
            $this->rpc->method = "gettransaction";
            $this->rpc->params = array($v->txid);
        
            $tmpTx = $this->rpc->getCurl();
            $updateData = array(
                "confirm" => $tmpTx['confirmations'],
                "updated_at" => Carbon::now()->toDateTimeString()
            );
            $result = $this->db->table('om_test_ohwe.ohwe_paytx')->where('uid', $v->uid)->update($updateData);
        }
        $result= $this->db->table('om_test_ohwe.ohwe_paytx')
            ->whereNotNull("txid")
            ->where("confirm",'>=',10)
            ->where("flag",0)
            ->get();
      
      

        //$body .= "결제정보 : ";

        
        // 주문자:주문자,연락처
        // 받으시는분:
        // 이름,연락처,주소

        // 배송메세지:

        // 상품정보:주문번호,주문일자,제품사진,상품명,운송장에 남길 상품명,옵션,수량,합계

        // 결제정보:
        // 총 주문금액,주문금액,배송비,총 할인금액,총 결제금액,결제방식(신용카드/현금/계좌이체,오위코인 등)

        // *교환/반품/환불 유의사항
        // *이용약관 및 개인정보처리방침
        // *소비자피해보상,분쟁 처리에 관한 사항
        // (이부분은 추후에 넣어도 됨)

        
        
        foreach($result as $k=>$v) {
            $stats = array("modifytime"=>time(),"stats"=>20 );

            $marketData = $this->db->table('om_test_ohwe.int_market_order_product')->where('ordercode', $v->order_code)->first();
            
            if (!empty($marketData) ){
                if($marketData->stats < 20  ) {

                    $updateStats = $this->db->table('om_test_ohwe.int_market_order_product')->where('ordercode', $v->order_code)->update($stats);

                    $addData = array(
                        "market_uid" => $marketData->market_uid,
                        "order_uid" => $marketData->uid,
                        "seller_id" => $marketData->seller_id, //'hqseller',
                        "stats" => 20,
                        "exec_member_uid" => 11,
                        "reg_ip" => $req->ip(),
                        "exec_action" => "실행자 : ohwecoin confirm",
                        "dlvcom_method"=>0,
                        "delivery_ship_date" => "",
                        "delivery_pay_side" => 0,
                        "delivery_send_msg" => "",
                        "debug"=>"",
                        "regdate"=>Carbon::now()->toDateTimeString(),
                        "regtime"=>time()
                    );

                    $addResult = $this->db->table('om_test_ohwe.int_market_order_detail_log')->insertGetId($addData);

                    $user = $this->db->table('om_test_ohwe.op_member')->where('user_id', $v->user_id)->first();//회원정보

                    $exImg = explode("/goodsImage",$marketData->imgfile);

                    $body = "";
                    $body .= "주문자 : " . $user->name . "<br>";
                    $body .= "받으시는분 : " . $marketData->recive_name . ",연락처 : " . $marketData->recive_phone . ",주소 : " . $marketData->recive_addr . $marketData->recive_addr_detail . "<br>";
                    $body .= "배송메세지 : " . $marketData->delivery_memo . "<br>";
                    if (!empty($exImg[1])) {
                        $body .= "주문번호 : " . $v->order_code . ",주문일자 : " . Carbon::createFromTimestamp($marketData->regtime)->toDateTimeString()  . ",<img src='https://test.ohwe.net/goodsImage" . $exImg[1] . "'>," ;
                    }else {
                        $body .= "주문번호 : " . $v->order_code . ",주문일자 : " . Carbon::createFromTimestamp($marketData->regtime)->toDateTimeString()  . ",";
                    }
                    $body .= "상품명 : " . $marketData->name . "<br>";
                    $body .= "링크 : <a href='https://test.ohwe.net/admin/order/order_info_win_popup_order.php?ordercode=" . $v->order_code . "&order_detail_uid=" . $marketData->uid . "'>";
                    $body .= $v->order_code . "</a><br>";

                    $data = array("body" => $body,"title" => $mail['subject']);

                    $this->mailSend($mail,$data);

                    if($this->errors) {
                        $updateData = array(
                            "flag" => 1,
                            "updated_at" => Carbon::now()->toDateTimeString()
                        );
                        $result = $this->db->table('om_test_ohwe.ohwe_paytx')->where('order_code', $v->order_code)->update($updateData);
                    }
                
                }
            }
            

            

            
            

            
            
            
            

            
            

        }  
            
        
        //$body .= "코인 수량 : " . $v->amount . " OHC <br>";
        //$body .= "API 금액 : " . $v->ex_ticker . "<br>";
        //$body .= "TXID : " . $v->txid . "<br>";

      
        //select * from int_market_order_product where ordercode = 'C0000000534' or ordercode = 'C0000000522';


        // insert into 
        //     int_market_order_detail_log 
        // set
            // market_uid = 1,
            // order_uid = 590,
            // seller_id = 'hqseller',
            // stats = 20,
            // exec_member_uid = 11,
            // exec_action = "실행자 : ohwe"
        
       
    }
    private function walletnotifyAdd($txninfo,$ip)
    {
        foreach($txninfo['details'] as $id => $details) {
            if (empty($details['fee']) ){
                $details['fee'] = 0;
            }
            if (empty($txninfo['comment']) ){
                $txninfo['comment'] = "";
            }
            $tx = array(
                'txid'     => $txninfo['txid'],
                'account'  => $details['account'],
                'address'  => $details['address'],
                'category' => $details['category'],
                'amount'   => $details['amount'],
                'fee'      => $details['fee'],
                'confirmations'=> $txninfo['confirmations'],
                'comment'  => $txninfo['comment'],
                'ip' => $ip,
                'blocktime'=> $txninfo['blocktime'] ? $txninfo['blocktime']:$txninfo['time']
                
            );
          
            $this->db->table('com_walletnotify')->insert($tx);
        }
    }
    public function navHeaderMenu() {
        $marketHeaderMenu = $this->db->table('sys_navmenu')->where('use_yn', true)->get();
        return response()->json($marketHeaderMenu);
    }
    
    public function platformWalletnotify(Request $req)
    {
        $ip = "52.79.113.112";
        $this->rpc->method = "gettransaction";
        $this->rpc->params = array( $req["txhash"]);
        $txninfo = $this->rpc->getCurl();

        $this->walletnotifyAdd($txninfo,$ip);
    }
    //주문 메일 
    public function orderMail(Request $req)
    {
        $mail['toEmail'] = "leekwanmo1@gmail.com";
        //$mail['toEmail'] = "ymdev1218@gmail.com";
        $mail['fromEmail'] = 'support@ohwecoin.io';
        $mail['fromName'] = 'Ohwe';
        $mail['subject']= '오위 코인 주문내역 ';

        $body = "";
            
        $body .= "회원 아이디 : " . $req->user_id . "<br>";
        $body .= "회원 이메일 : " . $req->user_email . "<br>";
        $body .= "받는 주소 : " . $req->to_address . "<br>";
        $body .= "주문 코드 : " . $req->order_code . "<br>";
        $body .= "코인 수량 : " . $req->amount . " OHC <br>";
        $body .= "API 금액 : " . $req->ex_ticker . "<br>";
        $body .= "TXID : " . $req->txid . "<br>";
        

        $data = array("body" => $body,"title" => $mail['subject']);

        $this->mailSend($mail,$data);

    }
    //메일 보내기
    private function mailSend($mail,$data)
    {
        $toEmail = $mail['toEmail'] ;
        $fromEmail = $mail['fromEmail'];
        $fromName = $mail['fromName'];
        $subject = $mail['subject'];
        //$data = array("body" => $body,"title" => $mail['subject']);

        Mail::send('email.orderMail', $data, function($message) use ($toEmail,$fromEmail,$fromName,$subject) {
            if(is_array($toEmail) ) {
                $message->to($toEmail[0])->cc($toEmail[1])->subject($subject);
            }else {
                $message->to($toEmail)->subject($subject);    
            }
            
            $message->from($fromEmail,$fromName);
        });

        if(count(Mail::failures()) > 0){
            $this->errors = false;
        }else {
            $this->errors = true;
        }
    }

    //코인게코 평균 코인가 가져오기
    public function addTicker(Request $req)
    {
        $apiUrl = null;

        switch ($req->api) {
            case 'coingecko':
                $apiUrl = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=krw&ids=ohwe&order=market_cap_desc&per_page=100&page=1&sparkline=false";   
                break;
            default:
                
                $apiUrl = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=krw&ids=ohwe&order=market_cap_desc&per_page=100&page=1&sparkline=false";   
                break;
        }

        $datas = $this->getCurl($apiUrl);
        $created_date = Carbon::now()->toDateTimeString();

        $coinData = array(
            "id" => $datas[0]->id,
            "api" => $req->api,
            "symbol" => $datas[0]->symbol,
            "name" => $datas[0]->name,
            "current_price" => $datas[0]->current_price,
            "total_volume" => $datas[0]->total_volume,
            "high_24h" => $datas[0]->high_24h,
            "low_24h" => $datas[0]->low_24h,
            //"ath_date" => $result[0]->ath_date,
            "api_date" => $datas[0]->last_updated,
            "created_date" => $created_date
        );

        $result = $this->db->table('sys_ticker')->insert($coinData);

        // CREATE TABLE `sys_ticker` (
        //     `idx` int(11) NOT NULL AUTO_INCREMENT COMMENT '고유번호',
        //     `api` varchar(50) NOT NULL DEFAULT '' COMMENT 'API종류',
        //     `id` varchar(50) NOT NULL DEFAULT '' COMMENT '코인아이디',
        //     `symbol` varchar(50) NOT NULL DEFAULT '' COMMENT '코인심볼',
        //     `name` varchar(50) NOT NULL DEFAULT '' COMMENT '코인이름',
        //     `current_price` varchar(255) NOT NULL DEFAULT '' COMMENT '코인평균금액',
        //     `high_24h` varchar(255) NOT NULL DEFAULT '' COMMENT '24시간 기준 최고가',
        //     `low_24h` varchar(255) NOT NULL DEFAULT '' COMMENT '24시간 기준 최저가',
        //     `total_volume` varchar(255) NOT NULL DEFAULT '' COMMENT '전체 거래량',
        //     `api_date` varchar(255) NOT NULL DEFAULT '' COMMENT 'api 등록일',
        //     `created_date` timestamp NOT NULL COMMENT '생성일',
        //     PRIMARY KEY (`idx`)
        // ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        //Crontab

        //0 * * * * /usr/bin/php /var/www/html/apiTicker.php >> /home/daemon/log/date +%Y%m%d%H%M.log
     

        
    }
    public function share(Request $req)
    {

        $channel_id = $req->input('channel_id');
        $content_id = $req['content_id'];
        $user_id = $req['user_id'];
        $share_type = $req['share_type'];
        $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

        $shareData = array(
            "channel_id" => $channel_id,
            "content_id" => $content_id,
            "user_id" => $user_id,
            "share_type" => $share_type,
            "created_date" => $created_date
        );
        $this->apiAdd($shareData,"add");

		$this->RewardCont->reward_Prc('pet_share',$content_id);
    }
    //DB 처리
    private function apiAdd($data,$dbType)
    {
        switch($dbType) {
            case "add":
                $result = $this->db->table('pet_share')->insert($data);
            break;
            case "modify":
            break;
            case "del":
            break;
        }
        

        return $result;
    }
    //인스타 API
    public function instar()
    {
        $this->clientId = 'e5221f6637614971ab41747bb9bd3973';
        $this->secretKey ='6a1040143abb4d9d954e2287518a3467';
        $this->redirectUri = 'https://pet.ohwe.net';

        //$this->instarCode();
        
        // header("Location: ".$authRequestUrl);

        // $code ='03e67fece686440a806b2058f2fade5b';

        //$url = "https://api.instagram.com/oauth/access_token";
        $url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=8635831518.e5221f6.9ce32983b99c43b5b9dd7e1c56a37198";

        $result = $this->getCurl($url);

        return response()->json($result);

        // $accessTokenParam = array(
        //     'client_id' => $clientId,
        //     'client_secret' => $secretKey,
        //     'grant_type' => 'authorization_code',
        //     'redirect_uri' => $redirectUri,
        //     'code' => $code
        // );

        
    }

    public function poolCheck(Request $req)
    {
        $method = $req->method;
        $ip = $req->ip;
        $port = $req->port;

        // if ($ip == "54.180.14.179") {

        // }
        switch ($port) {
            case 'pool':
                $getPort = "8080";
                break;
            default:
                $getPort = "80";
                break;
        }
        $url = "http://" . $ip . ":" . $getPort ."/api/" . $method;
        
        
        $result = $this->getCurl($url);
        // print_r($result);
        // $tmpArr = json_decode($result);
        return response()->json($result);
    }

     /**
     * API
     * Method
        Ex : /v1/api/rpc/createaddress/test //주소 생성
        Ex : /v1/api/rpc/userbalance/test 잔액조회
        Ex : /v1/api/rpc/getaddressesbyaccount/test //주소 조회
        Ex : /v1/api/rpc/userlist/test //거래내역 조회
        Ex : /v1/api/rpc/getdetail/test //해시로 조회
        
     * @param $method,$param
     * @return JSON
    */
    public function api($method=null,$param=null)
    {   

        switch ($method) {
            case 'userbalance':
                $method = "getbalance";
                break;
            case 'createaddress':
                $method = "getaccountaddress";
                break;
            case 'useraddress':
                $method = "getaddressesbyaccount";
                break;
            case 'listTransactions':
                $method = "listtransactions";
                break;
            case 'transactionDetail':
                $method = "gettransaction";
                break;
            default:
                $method = false;
                break;
        }
        $this->rpc->method = $method;
        $this->rpc->params = array($param);
        
        $result = $this->rpc->getCurl();
        
        return response()->json($result);
    }

    public function walletnotify(Request $req,$ip = null)
    {
        if($ip == null) {
            $ip = "54.180.14.179";
        }
        $this->rpc->method = "gettransaction";
        $this->rpc->params = array( $req["txhash"]);
        $txninfo = $this->rpc->getCurl();

        foreach($txninfo['details'] as $id => $details) {
            if (empty($details['fee']) ){
                $details['fee'] = 0;
            }
            if (empty($txninfo['comment']) ){
                $txninfo['comment'] = "";
            }
            $tx = array(
                'txid'     => $txninfo['txid'],
                'account'  => $details['account'],
                'address'  => $details['address'],
                'category' => $details['category'],
                'amount'   => $details['amount'],
                'fee'      => $details['fee'],
                'confirmations'=> $txninfo['confirmations'],
                'comment'  => $txninfo['comment'],
                'ip' => $ip,
                'blocktime'=> $txninfo['blocktime'] ? $txninfo['blocktime']:$txninfo['time']
                
            );
            /*
            $tx = array(
                'txid'     => $txninfo['txid'],
                'tot_amt'  => $txninfo['amount'],
                'tot_fee'  => $txninfo['fee'],
                'confirmations'=> $txninfo['confirmations'],
                'comment'  => $txninfo['comment'],
                'blocktime'=> $txninfo['blocktime'] ? $txninfo['blocktime']:$txninfo['time'],
                'account'  => $details['account'],
                'address'  => $details['address'],
                'category' => $details['category'],
                'amount'   => $details['amount'],
                'fee'      => $details['fee']
            );
            */
            $this->db = DB::connection('aws'); 
            $this->db->table('com_walletnotify')->insert($tx);
        }
        
    }
    

    
 

}