<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\RpcController;
use Illuminate\Support\Facades\DB;
use Cookie;
use Carbon\Carbon;

class OhweController extends Controller
{
    private $data;
    private $db;
    private $rpc;
    private $viewPath;

     /**
     * Construct
     * @param null
     */

    public function __construct(SessionController $sec,RpcController $rpc)
    {
        
        $this->data = array();
        $this->sec = $sec;
        $this->rpc = $rpc;
        $this->db = DB::connection('aws');
        $this->checkSec();
        $this->menu();
        $this->data['myChannelChk'] = false;
        date_default_timezone_set('Asia/Seoul');
        //$this->chkIp();
        $this->userOhc();

        // if (!) {
        //     return view("pet/petstar/commingSoon");
        //     exit;
        // }



    }
    private function checkEmail($email) {
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
    }
    private function userOhc() {
        $userCoin = 0;
        if($this->userId ) {
            
            $userInfo = $this->db->table('om_test_ohwe.op_member')->where('uid',$this->userId)->first();
            
            if( $this->checkEmail($userInfo->user_id ) ) {

            }else {
                if( $this->checkEmail($userInfo->email ) ) {
                    $userCoin = $this->rpc->getBalance($userInfo->email);    
                }
                
            }
        }
        $this->data['userBalance'] = number_format($userCoin,2);
    }
    /**
     * IP check
     * @return view;
    */
    private function chkIp() {
        $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

        if($userIp == "112.216.235.40" || $userIp == "114.199.159.57" || $userIp == "58.77.196.210") {
            return true;
        }
        $confirmIp = "112.169.82";
        if(strstr($userIp, $confirmIp) == "") {
            $this->viewPath = 'pet/petstar/commingSoon';
            return false;
        }
        return true;
    }

    private function checkSec()
    {

        $check = $this->sec->sessionChk();

        if ($check['p2p_log_uid']) {
            $userId = $check['p2p_log_uid']; //유저아이디
			$this->data['userId'] = $userId;

			$data_add = $this->db->table('om_test_ohwe.op_member_add')->where('user_id',$userId)->first();

			if (empty($data_add)) {

				$op_member_add_data = array(
					'user_id' => (int)$userId,
					'm_level' => 1,
					'm_grade' => 1,
					'm_cent' => 0
				);
				$this->db->table('om_test_ohwe.op_member_add')->insert($op_member_add_data);
				$data_add = $this->db->table('om_test_ohwe.op_member_add')->where('user_id',$userId)->first();

				$this->data['m_cent']	= $data_add->m_cent;
				$this->data['m_level']	= $data_add->m_level;
				$this->data['m_grade']	= $data_add->m_grade;

			} else {
				$this->data['m_cent']	= $data_add->m_cent;
				$this->data['m_level']	= $data_add->m_level;
				$this->data['m_grade']	= $data_add->m_grade;
			}
			$this->data['getUser']		= true;
			$this->data['name']			= str_replace("\"","",$check['p2p_log_name']);
            $this->user					= $check;
            $this->userId				= $userId;

			//OHC 가져오면 됨.. hambuger메뉴에 표시는 부분
			$this->data['userBalance']	= 0;
        }else {
            $this->userId = false;
			$this->data['userId']		= "";
			$this->data['user_id']		= "";
            $this->data['getUser']		= false;
			$this->data['m_cent']		= 0;
			$this->data['m_level']		= 0;
			$this->data['m_grade']		= 0;
			$this->data['name']			= "";
			$this->data['userBalance']	= 0;
        }

	}
    public function userChk()
    {
        if (!$this->userId ) {
            $result = array(
                "login" => false
            );

        }else {
            $data = $this->db->table('pet_channel')->where('user_id',$this->userId)->first();
            if(empty($data) ) {
                $result = array(
                    "login" => true,
                    "channel" => false
                );
            }else {
                $result = array(
                    "login" => true,
                    "channel" => true
                );
            }
        }

        return response()->json($result);
    }
    private function menu()
    {
        $this->data['hMenu'] = array(
            0 => (object)array("menu" => "ABOUT 오위펫","url" => "/aboutpet"),
            1 => (object)array("menu" => "펫스타","url" => "/petstar"),
            2 => (object)array("menu" => "펫시터","url" => "/petsitter")
        );
    }
    /**
     * Index => Intro
     * @return view;
     */
    public function index(Request $request)
    {
        //$this->data['myChannelChk'] = false;
        if($this->userId) {
            $this->data['myChannelChk'] = true;
        }
        // if(!$this->chkIp() ) {
        //     return view($this->viewPath);
        // }
        return view('pet/index',$this->data);
    }

    private function channelLists()
    {
        $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->orderBy('content_id', 'desc')
            ->get();

        $this->db->table('pet_channel')
            ->leftJoin('pet_channel', 'pet_channel.user_id', '=', 'pet_channel.user_id')
            ->join('om_test_ohwe.op_member', 'om_test_ohwe.op_member.uid', '=', 'pet_comment.user_id')
            ->where("pet_comment.flag",1)
            ->select('pet_comment.*', 'pet_channel.channel_img',"om_test_ohwe.op_member.name")
            ->orderByRaw('parent,seq')
            ->offset($data['offset'])
            ->limit($data['limit'])
            ->get();
        /*
        select
            channel_contents.*
        from
            pet_channel
        join
            channel_contents
        on
            pet_channel.user_id = channel_contents.user_id
        where
            pet_channel.`use_yn`= true
        and
            channel_contents.use_yn = true
        */
    }
    //Petstar DB
    private function petstarPrc()
    {
        $toDay = date('Y-m-d'); //금일 날짜
        $week = date('w'); //금일 주

        $start = date('Y-m-d', strtotime($toDay . " -" . $week . "days")); //시작일
        $last = date('Y-m-d', strtotime($start . " +" . "7days")); //종료일

        $this->data['contentLists'] = $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->where('show_flag',1)
            ->limit(100) // 2019-01-21 박지연 최초 썸네일 게시물 100개 제한
            ->orderBy('viewCnt', 'desc')
            ->get();
        //$this->data['getChannel'][0] = $this->db->table('pet_channel')->where('use_yn',true)->offset(0)->limit(5)->get();
        $this->data['getChannel'][0] = $this->db->table('channel_contents')
            ->leftJoin("pet_like","pet_like.content_id","channel_contents.content_id")
            ->leftJoin("om_test_ohwe.op_member","channel_contents.user_id","op_member.uid")
            ->select( $this->db->raw('count(pet_like.content_id) as cnt'), "op_member.user_id as member_id", "channel_contents.*")
            ->whereNotNull("pet_like.content_id")
            ->where("pet_like.flag",1)
            ->where("channel_contents.use_yn",true)
            ->where("channel_contents.flag",1)
            ->where("pet_like.like_type",0)
            ->where('channel_contents.show_flag',1)
            ->whereBetween("channel_contents.created_date",[$start,$last])
            ->groupBy("pet_like.content_id")
            ->orderBy("cnt","desc")
            ->orderBy("viewCnt","desc")
            ->offset(0)
            ->limit(5)
            ->get();

        $this->data['getChannel'][1] = $this->db->table('channel_contents')
            ->leftJoin("pet_like","pet_like.content_id","channel_contents.content_id")
            ->select("pet_like.user_id","pet_like.content_id")
            ->where("pet_like.flag",1)
            ->where("pet_like.like_type",0)
            ->where("channel_contents.use_yn",true)
            ->where("channel_contents.flag",1)
            ->where('channel_contents.show_flag',1)
            ->get();

        // select
        //     count(pet_like.content_id) as cnt,
        //     channel_contents.*
        // from
        //     channel_contents
        // left join
        //     pet_like
        // on
        //     pet_like.content_id = channel_contents.content_id
        // where
        //     channel_contents.use_yn = true
        // and
        //     channel_contents.flag = 1
        // and
        //     pet_like.content_id is not null
        // group by
        //     `pet_like`.`content_id`
        // order by cnt desc

        $this->data['likeCnt'] = $this->db->table('pet_like')->where('flag',1)->where('like_type',0)->get(); //좋아요 수량
        $this->data['myChannelChk'] = "null"; //로그인 안하면
        $this->data['userChk'] = false;
        //로그인하면
        if($this->userId) {
            $this->channelCheck();
        }

    }
    private function channelCheck()
    {
        $this->data['userChk'] = $this->userId;
        $myChannel = $this->db->table('pet_channel')->where('user_id',$this->userId)->where('use_yn',true)->first();
        $this->data['myChannel'] = $myChannel;

        //없는 채널이면
        if ( empty($myChannel) ) {
            $this->data['myChannelChk'] = false;
        //채널이 있으면
        }else {
            $this->data['myChannelChk'] = $this->userId;
        }
    }
    private function getTagList($tag)
    {
        $tmpTag = [];
        //like로 검색
        $result = $this->db->table('channel_contents')
            ->where("use_yn",true)
            ->where('content_tag', 'like', '%'. $tag . '%')
            ->where("flag",1)
            ->get();
        //검색한 태그중에 입력한 태그 값이 있는지 체크
        foreach($result as $k => $v) {
            $exTag = explode(',',$v->content_tag);
            //있으면 배열에 담자!
            if(in_array($tag, $exTag)) {
                $tmpTag[] = $v;
            }
        }

        //print_r($tmpTag);
        // if ($result->isEmpty() ) {
        //     //return false;
        // }
        return $tmpTag;
    }

    //뷰 페이지 설정
    private function viewPathList($seq,$loginChk,$data = null)
    {
        $path = null;
        if ($loginChk) {
            //로그인 안했으면
            if (!$this->userId ) {
                return "redirect";
            }
        }
        switch ($seq) {
            //1차 메뉴
            case 'petstar': //메인 페이지
                $this->petstarPrc();
                $path = "pet/petstar/index";
                break;
            case "aboutpet": //오위펫소개
                $path = "pet/about";
                break;
            case "petsitter": //펫시터
                $path = "pet/petsitter/index";
                break;
            case "terms": //이용약관
                $this->data['doc'] = "terms";
                $path = "pet/document/doc";
                break;
            case 'private': //개인정보처리방침
                $this->data['doc'] = "private";
                $path = "pet/document/doc";
                break;
            //2차 메뉴
            case "channelnew": //채널 생성
                $data = $this->db->table('pet_channel')->where('user_id',$this->userId)->first();

                if(!empty($data) ) { //채널이 있으면
                    return "redirect";
                }
                $this->data['user'] = $this->userId ;
                $path = "pet/petstar/channelNew";
                break;
            case "channelmod": //채널 수정
                $datas = $this->db->table('pet_channel')->where('user_id',$this->userId)->first();
                $this->data['channel'] = $datas;
                $this->data['user'] = $this->userId ;
                $path = "pet/petstar/channelModify";
                break;
            case "contentadd": //게시물 올리기

                if($this->userId){
                    $this->data['myChannelChk'] = true;
					$path = "pet/petstar/contentAdd";
                }

				$data = $this->db->table('pet_channel')->where('user_id',$this->userId)->first();
				 if(empty($data) ) { //채널이 없으면
					$path = "pet/petstar/channelNew";
				}

                break;
            case "contentmod":
                $datas = $this->db->table('channel_contents')->where('content_id',$data)->first();
                $this->data['contents'] = $datas;
                $path = "pet/petstar/contentMod";
                break;
            case "petprofileadd": //펫 프로필 등록
                $datas = $this->db->table('pet_channel')->where('user_id',$this->userId)->first();
                $this->data['channel_id'] = $datas->channel_id;
                $path = "pet/petstar/petProfileNew";
                break;
            case "petprofilemodify": //펫 프로필 수정
                $this->data['pet_profile'] = $this->db->table('pet_profile')->where('user_id',$this->userId)->first();
				$this->data['myChannelChk'] = $this->userId;
                $path = "pet/petstar/petProfileModify";
                break;
            case "tag":
                //로그인하면
                if($this->userId) {
                    $this->channelCheck();
                }
                $tagList = $this->getTagList($data);
                //만약 태그가 없다면 ..
                if(empty($tagList) ) {
                    return "redirect";
                }
                $this->data['tagLists'] = $tagList;
                $this->data['getTag'] = $data;

                $path = "pet/petstar/tagList";
                break;
            default:
                $path = "pet/index";
                break;
        }

        return $path;
    }
    /**
     * View Page
     * @return view;
    */

    public function views(Request $req)
    {
        //IP제한 .. 향후 삭제 ...
        // if(!$this->chkIp() ) {
        //     return view($this->viewPath);
        // }
        //$viewPath = null;
        $seq = request()->segment(count(request()->segments()) );
        $cnt = count(request()->segments());

        switch( $cnt ) {
            //펫 탑 메뉴
            case 1:
                $viewPath = $this->viewPathList($seq,false);
                break;
            //펫 2차 메뉴
            case 2:
                $viewPath = $this->viewPathList($seq,true);
                break;
            //펫 3차 메뉴
            case 3:
                switch (request()->segment(2)) {
                    //태그 리스트
                    case "tag":

                        $viewPath = $this->viewPathList(request()->segment(2),false,$seq);
                        break;
                    //게시물 수정
                    case "contentmod":
                        $viewPath = $this->viewPathList(request()->segment(2),true,$seq);
                        break;

					case "petprofilemodify": //펫 프로필 수정
                        $this->data['pet_profile'] = $this->db->table('pet_profile')
                        ->where('pet_profile_id',request()->segment(3))
                        ->first();

                        $viewPath = "pet/petstar/petProfileModify";
                        break;

                    //펫스타 내채널
                    case "mychannel":
                        //펫 프로필 정보
                        $this->data['petProfileLists'] = $petProfileLists = $this->db->table('pet_profile')
                            ->where("use_yn",1)
                            ->where('user_id',$seq)
                            ->get();
                        $this->data['myChannelChk'] = false;

                        $myChannel = $this->db->table('pet_channel')->where('user_id',$seq)->first(); //채널 프로필 이미지

						//없는 채널이면
                        if ( empty($myChannel) ) {
                            return redirect('/petstar/channelnew');
                        }

                        $contentInfo = $this->db->table("om_test_ohwe.op_member")->select("name","nickname")->where("uid",$myChannel->user_id)->first();
                        $this->data['contentInfo'] = $contentInfo;
                        $this->data['followerCheck'] = "구독";

                        $this->data['myChannel'] = $myChannel;
                        $this->data['followerCnt'] = $this->getCnt($myChannel->channel_id,"follower");
                        //로그인하면
                        if($this->userId) {

                            //로그인한 회원이 채널 생성자와 동일하면
                            if($this->userId == $seq) {

                                $this->data['myChannelChk'] = true;
                            //로그인한 회원이 채널 생성자와 동일하지 읺으면
                            }else {
                                $this->data['myChannelChk'] = false;
                                //구독 했는지 안했는지 체크
                                $followerCheck = $this->db->table('pet_follower')
                                    ->where("channel_id",$myChannel->channel_id)
                                    ->where("user_id",$this->userId)
                                    ->where("flag",1)
                                    ->first();

                                if(!empty($followerCheck) ) {
                                    $this->data['followerCheck'] = "구독중";
                                }
                            }
                        }

						$mem_grade =array("NEW","NORMAL","BRONZE","SILVER","GOLD","PLATINUM");
						$this->data['mem_grade'] = $mem_grade;

                        $viewPath = "pet/channel/myChannel";
                        break;
                    //펫스타 상세내용
                    case "content":

                        //변수 정리
                        $randImg = rand(1,6); //랜덤 난수 생성
                        $segment = request()->segment(3); //컨텐츠 번호
                        //$setTime = time(); //timestamp
                        $getDate = Carbon::now()->toDateString(); //Date Ex) 2018-12-15
                        $user_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

                        //조회수 업데이트 함수
                        $contentModify = array(
                            "updated_date" => $user_date
                        );
                        //로그인을 안하면
                        $this->data['userId'] = '';
                        $this->data['myChannelChk'] = false;
                        $this->data['userLike'] = false;
                        $this->data['profileImg'] = env('AWS_PATH') . "/image/pet/reply_g0" . $randImg . ".png";

                        if( !$this->contentPrc($segment) ){
                            return redirect('/petstar');
                        }

                        $this->data['followerCheck'] = "구독";

                        /*
                            #-- 20190125 --
                            #-- Cho --
                            #-- 펫 프로필 컨텐츠에서 사용안함 --
                        */
                        //펫 프로필 정보
                        // $this->data['petProfileLists'] = $petProfileLists = $this->db->table('pet_profile')
                        //     ->where("use_yn",1)
                        //     ->where('user_id',$this->channel['contentDetail']->user_id)
                        //     ->get();
                        /*
                            -----
                        */


                        // if($petProfileLists->isEmpty() ) {

                        // }else {
                        //     $this->data['petProfileLists'] = $petProfileLists;
                        // }

                        //로그인
                        if($this->userId) {
                            // $userEmail = preg_replace('@"@', "", $this->user['p2p_log_id']);
                            // 2019-01-29 박지연 수정
                            $userEmail =  $this->db->table("om_test_ohwe.op_member")->where("uid",$this->userId)->select("user_id")->first();
                            //조회수 체크 DB
                            $hitData = $this->db->table('pet_hit')
                                ->where('user_id',$this->userId)->where('content_id',$segment)
                                ->where('user_ip',$req->ip())
                                ->whereDate("created_date",">=",$getDate)
                                ->orderByRaw("hit_id desc")->get(); //채널상세
                            //조회수 Insert Data
                            $hit = array(
                                'user_id' => (int)$this->userId,
                                'content_id' => (int)$segment,
                                'user_ip' => $req->ip(),
                                'created_by' => $this->userId,
                                'created_date' => $user_date
                            );

                            $this->data['userId'] = $this->userId;

                            $likeChk = $this->db->table("pet_like")->where("user_id",$this->userId)->where("flag",1)->where("content_id",$segment)->where("comment_id",0)->first();
                            if( !empty($likeChk) ) {
                                $this->data['userLike'] = true;
                            }


                            //로그인한 회원이 채널 생성자와 동일하면
                            if($this->userId == $this->channel['contentDetail']->user_id) {
                                //$this->data['balance'] = $this->rpc->getBalance($userEmail) ;
                                $this->data['myChannelChk'] = true;

                            //로그인한 회원이 채널 생성자와 동일하지 읺으면
                            }else {
                                //$this->data['myChannelChk'] = false;

                                //채널 데이터
                                $getChannelData = $this->db->table("pet_channel")
                                    ->select("channel_id")
                                    ->where("user_id",$this->channel['contentDetail']->user_id)
                                    ->where("use_yn",true)
                                    ->first();
                                //구독 했는지 안했는지 체크
                                $followerCheck = $this->db->table('pet_follower')
                                    ->where("channel_id",$getChannelData->channel_id)
                                    ->where("user_id",$this->userId)
                                    ->where("flag",1)
                                    ->first();

                                if(!empty($followerCheck) ) {
                                    $this->data['followerCheck'] = "구독중";
                                }

                            }

                            $userProfile = $this->db->table('pet_channel')
                                ->where('user_id',$this->userId)
                                ->where('use_yn',true)
                                ->first();

                            if(!empty($userProfile) ) {
                                $this->data['profileImg'] = env('AWS_PATH') . $userProfile->channel_img;
                            }


                        }

                        //setcookie("content[" . $segment ."]", $req->ip(),time()-3300); //쿠키 초기화
                        //쿠키가 없으면
                        if (!$this->sec->hitSession($segment,$getDate,$req) ) {
                            //로그인 했으면
                            if($this->userId) {
                                //값이 있는지 체크
                                if($hitData->isEmpty() ) {
                                    $result = $this->db->table('pet_hit')->insert($hit);//조회수(보상) 테이블 저장
                                    //조회수(컨텐츠) 테이블 업데이트
                                    $this->db->table('channel_contents')
                                        ->where('content_id', $segment)
                                        ->increment('viewCnt',1,$contentModify);
                                }
                            //로그인 안하면
                            }else {
                                //조회수(컨텐츠) 테이블 업데이트
                                $result = $this->db->table('channel_contents')
                                    ->where('content_id', $segment)
                                    ->increment('viewCnt',1,$contentModify);
                            }
                        //쿠키가 있으면
                        }else {
                            //로그인 했으면
                            if($this->userId) {
                                //값이 있는지 체크
                                if($hitData->isEmpty() ) {
                                    $result = $this->db->table('pet_hit')->insert($hit);//조회수(보상) 테이블 저장
                                }
                            }
                        }

                        $viewPath = "pet/channel/content";
                        break;
                    default:
                        //return redirect('/petstar');
                        break;
                }
            default:
                //return redirect('/');
                break;
        }

        if ($viewPath == "redirect") {
            return redirect("/petstar");
        }


        return view($viewPath , $this->data);

    }
    //상세 컨텐츠
    private function contentPrc($segment)
    {
        //컨텐츠 상세 조회
        $contentDetail = $this->db->table('channel_contents')
            ->where('use_yn',1)
            ->where('flag',1)
            ->where('content_id',$segment)
            ->first(); //채널 상세
        //없는 채널컨텐츠면 ..
        if (empty($contentDetail) ){
            return false;
        }
        $this->channel['contentDetail'] = $contentDetail;

        $this->data['getContent'] = $this->channel['contentDetail'];
        //채널 조회
        $getChannel = $this->db->table('pet_channel')
            ->where('user_id',$this->channel['contentDetail']->user_id)
            ->where('use_yn',true)
            ->first();

        //없는 채널이면 ..
        if (empty($getChannel) ){
            return false;
        }

        $contentInfo = $this->db->table("om_test_ohwe.op_member")->select("name","nickname")->where("uid",$contentDetail->user_id)->first();
        if (empty($contentInfo) ) {
            return false;
        }
        $this->data['contentInfo'] = $contentInfo;



        //채널 정보
        $this->data['getChannel'] = $getChannel;
        //팔로우 개수
        $this->data['followerCnt'] = $this->getCnt($getChannel->channel_id,"follower");
        //좋아요 개수
        $this->data['like'] = $this->getCnt($segment,"contentLike");
        //댓글 좋아요 개수
        $this->data['likeReCnt'] = "";
        $commentLike = $this->getCnt($segment,"commentLike");

        if (!$commentLike->isEmpty() ) {
            foreach($commentLike as $k=>$v) {
                if ( empty($tmp[$v->comment_id] ) ) {
                    $tmp[$v->comment_id]= 1;
                }else {
                    $tmp[$v->comment_id]= $tmp[$v->comment_id] +=1;
                }
            }
            $this->data['likeReCnt'] = $tmp;
        }
        //댓글 목록
        $this->data['commentLists'] = $this->commentLists($segment,"commentLists");
        $this->data['commentReLists'] = $this->commentLists($segment,"commentReLists");
        //신고 목록
        $this->data['reportGroup'] = $this->reportLists();

        return true;
    }
    //신고 목록
    private function reportLists()
    {
        $reportGroup = $this->db->table('sys_code_detail')
            ->where("code_group_id","pet_report_0001")
            ->where("use_yn",true)
            ->orderBy("display_order","asc")
            ->get();
        return $reportGroup;
    }
    //댓글 목록
    private function commentLists($segment,$commentType)
    {
        $result = null;
        $jsonarray = array();
        switch ($commentType) {
            case 'commentLists':
                $jsonarray['comList'] = $this->db->table("pet_comment")
                    ->leftJoin('ohwedb.pet_channel', 'ohwedb.pet_comment.user_id', '=', 'ohwedb.pet_channel.user_id')
                    ->join('om_test_ohwe.op_member', 'om_test_ohwe.op_member.uid', '=', 'ohwedb.pet_comment.user_id')
                    //->where("ohwedb.pet_comment.flag",1)
                    ->where("ohwedb.pet_comment.seq",1)
                    ->where("ohwedb.pet_comment.content_id",$segment)
                    ->select('ohwedb.pet_comment.*', 'ohwedb.pet_channel.channel_img',"om_test_ohwe.op_member.name")
                    ->orderByRaw('parent,seq')
                    ->get();

                // 2019-01-30 박지연 댓글 좋아요 리스트
                $commentId = array();
                $i = 0;

                foreach ($jsonarray['comList'] as $row) {
                    $commentId[$i] = $row->comment_id;
                    $i++;
                }

                $jsonarray['comLikeList'] = $this->db->table("pet_like")
                    ->leftJoin('ohwedb.pet_comment', 'ohwedb.pet_comment.comment_id', '=', 'ohwedb.pet_like.comment_id')
                    ->where("ohwedb.pet_like.flag",1)
                    ->whereIn("ohwedb.pet_comment.comment_id",$commentId)
                    ->select('ohwedb.pet_like.*')
                    ->get();

                $result = json_encode($jsonarray);
                break;

            case 'commentReLists':
                $result = $this->db->table("pet_comment")
                    ->leftJoin('ohwedb.pet_channel', 'ohwedb.pet_comment.user_id', '=', 'ohwedb.pet_channel.user_id')
                    ->join('om_test_ohwe.op_member', 'om_test_ohwe.op_member.uid', '=', 'ohwedb.pet_comment.user_id')
                    //->where("ohwedb.pet_comment.flag",1)
                    ->where("ohwedb.pet_comment.seq",">",1)
                    ->where("ohwedb.pet_comment.content_id",$segment)
                    ->select('ohwedb.pet_comment.*', 'ohwedb.pet_channel.channel_img',"om_test_ohwe.op_member.name")
                    ->orderByRaw('parent,seq')
                    //->offset(0)
                    //->limit(30)
                    ->get();
                break;
            default:
                # code...
                break;
        }
        return $result;


    }
    private function getCnt($param,$getType)
    {
        switch ($getType) {
            case 'channelLike':
                //좋아요 개수
                $result = $this->db->table('pet_like')->where('flag',1)
                    ->where('like_type',0)
                    ->where('channel_id',$param)
                    ->count();
                break;
            case 'contentLike':
                $result = $this->db->table('pet_like')
                    ->where('flag',1)
                    ->where('like_type',0)
                    ->where('content_id',$param)
                    ->count(); //좋아요 개수
                break;
            case 'commentLike':
                $result = $this->db->table('pet_like')
                    ->where('flag',1)
                    ->where('like_type',">",0)
                    ->where("content_id",$param)
                    ->get();
                break;
            case "follower":
                $result = $this->db->table('pet_follower')
                    ->where('channel_id',$param)
                    ->where('flag',1)
                    ->count(); //팔로우 개
                break;
            default:
                # code...
                break;
        }


        if(empty($result) ) {
            return 0;
        }
        return $result;
    }






}
