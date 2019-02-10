<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\RewardController as RewardC;
use App\Http\Controllers\UploadController;
use Carbon\Carbon;

class ContentController extends Controller {

	private $db;
    private $sec;
    private $user;
    private $viewMsg;
    public function __construct( SessionController $sec,RewardC $RewardC,CommonController $common,UploadController $uploadCtr)
    {
        $this->sec = $sec;
		$this->RewardCont = $RewardC;
        $this->uploadCtr = $uploadCtr;
        $this->db = DB::connection('aws');
        $this->viewMsg = $common->msgBox("kr");
        date_default_timezone_set('Asia/Seoul');

    }
    //Msg JSON
    private function msgJson($msg,$err) {
        return array("err"=> $err ,"result"=> $msg );
    }


	public function video_list() {

		$content = DB::table('boomclap.content_vlist')->select('*')->get();
		return $content;
	}

	public function detail($no) {
		$content = DB::table('boomclap.content_vlist')->where('no',$no)->get();
		return $content;
    }

    public function video_score_list() {
        // $content = DB::table('boomclap.user_vlist')->select('*')->get();
        $content = DB::table('boomclap.user_vlist as a')->leftJoin('boomclap.content_vlist as b', 'a.content_no', '=', 'b.no')->select('*')->get();
        return $content;
    }

	/**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser($verification_code)
    {
        $check = DB::table('ohwedb.users')->where('auth_code',$verification_code)->first();
        if(!is_null($check)){
            // $user = User::find($check->email);
            if($check->auth_yn == 'Y'){
                // return response()->json([
                //     'success'=> true,
                //     'message'=> '이미 인증되었습니다.'
				// ]);
				return  view('email/verifyok')->with('alert', '이미 인증되었습니다.');
            }
            DB::table('ohwedb.users')->where('auth_code',$verification_code)->update(['auth_yn' => 'Y','updated_at' => DB::raw('NOW()')]);
            // $user->update(['auth_yn' => 'Y']);
			// DB::table('ohwedb.users')->where('auth_code',$verification_code)->update(['auth_code'=>'']);

			return  view('email/verifyok')->with('alert', '이메일 인증이 완료되었습니다.');
            // return response()->json([
            //     'success'=> true,
            //     'message'=> '이메일 인증이 완료되었습니다.'
            // ]);
        }
		// return response()->json(['success'=> false, 'error'=> "올바르지 않은 인증코드입니다."]);

		return view('email/verifyok')->with('alert', '올바르지 않은 인증코드입니다.');
    }

	private function checkSec()
    {
        $check = $this->sec->sessionChk();

        if ($check ) {
            $this->user = $check;
            $this->userId = preg_replace('@"@', "", $check['p2p_log_uid']); //유저아이디
            return true;
        }else {
            return false;
        }
    }

	//파라미터 체크
    private function paramChk($param)
    {
        if (empty($param) ) {
            return false;
        }
        return true;
    }

	//공개 & 비공개 처리
    public function contentShow(Request $req) {
        if (!$this->checkSec() ) {
            return response()->json(false);
        }
        $content_id = $req->content_id;
        $updated_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

        $content = $this->db->table('channel_contents')
            ->where("content_id",$content_id)
            ->where('user_id',$this->userId)
            ->first(); //DB조회
        if( empty($content) ) {
            return response()->json(false);
        }
        switch ($content->show_flag) {
            case 0:
                $show_flag = 1;
                $returnData = array("err"=>true,"msg"=>"공개");
                break;
            default:
                $show_flag = 0;
                $returnData = array("err"=>true,"msg"=>"비공개");
                break;
        }
        $updateData = array(
            "show_flag" => $show_flag,
            "updated_by" => $this->userId,
            "updated_date" => $updated_date
        );

        $result = $this->db->table("channel_contents")
            ->where('user_id', $this->userId)
            ->where("content_id",$content_id)
            ->update($updateData); //수정

        if($result == 1 || $result) {
            return response()->json($returnData);
        }
        return response()->json(false);


    }
	//게시하기
    public function contentSubmit(Request $req)
    {
        if (!$this->checkSec() ) {
            return response()->json(false);
        }

        $content_id = $req->content_id; //컨텐츠아이디
        $content_title = $req->content_title; //컨텐츠제목
        $content_tag = str_replace("#","",$req->content_tag); //컨텐츠태그
        $content_desc = $req->content_desc;//컨텐츠상세
        $flag = $req->flag;

        $updated_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

        //없으면 false
        if(!$this->paramChk($content_id) ) {
            return response()->json(false);
        }
        //없으면 false
        if(!$this->paramChk($content_title) ) {
            //return response()->json(false);
        }

        $contentModify = array(
            "content_title" => $content_title,
            "content_tag" => $content_tag,
            "content_desc" => $content_desc,
            "use_yn" => true,
            "flag" => $flag,
            "updated_by" => $this->userId,
            "updated_date" => $updated_date
        );
        $result = $this->db->table('channel_contents')
            ->where('content_id', $content_id)
            ->where("user_id",$this->userId)
            ->update($contentModify);

		$content = $this->db->table('channel_contents')
            ->where("content_id",$content_id)
            ->where('user_id',$this->userId)
            ->first(); //DB조회
        if( empty($content) ) {
            return response()->json(false);
        }

		if ($content->content_flag==0) {
			$tbl = "channel_contents_video";
		} else {
			$tbl = "channel_contents";
		}

		//-------------------------------------
		//--------게시하기 히스토리기록 및 보상처리-------
		//-------------------------------------
		if ($req->reward) {
			$reward_point = $this->RewardCont->reward_content_Prc($tbl,$req->content_id,$flag);
		} else {
			$reward_point = 0;
		}
        return response()->json($reward_point);
    }
    //삭제하기
    public function contentDel(Request $req)
    {
        if (!$this->checkSec() ) {
            return response()->json(false);
        }else {
            $updated_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

            $content_id = $req->content_id; //컨텐츠아이디
            $contentModify = array(
                "flag"=>2,
                "use_yn"=>0,
                "updated_by" => $this->userId,
                "updated_date" => $updated_date
            );

            $result = $this->db->table('channel_contents')
                ->where('content_id', $content_id)
                ->where('user_id',$this->userId)
                ->update($contentModify);

            return response()->json($result);
        }

    }
    //채널 컨텐츠 목록 불러오기
    public function contentList(Request $req)
    {
        //$first = $req['first']; //시작
        //$last = $req['last']; //끝
        $channelId = $req->channelId; //채널아이디
        //로그인 안했으면 ..
        if (!$this->checkSec() ) {
            $result['data'] = $this->db->table('channel_contents')
                ->where("use_yn",1)
                ->where('user_id',$channelId)
                ->where('flag',1)
                ->orderBy('content_id', 'desc')
                ->get();
            //만약 데이터가 없다면 ?
            if($result['data']->isEmpty() ) {
                $result['data'] = false;
                $result['msg'] = "등록된 게시물이 없어요.";
            }
            $result['userChk'] = false;
        //로그인 했으면
        }else {
            //채널하고 유저가 같으면
            if ($channelId == $this->userId) {

                switch ($req->flag) {
                    case 'all': //전체
                        $result['data'] = $this->db->table('channel_contents')
                            ->where('user_id',$channelId)
                            ->where('flag',"<",2)
                            ->orderBy('content_id', 'desc')
                            ->get();
                        break;
                    case 'public': //공개
                        $result['data'] = $this->db->table('channel_contents')
                            ->where('user_id',$channelId)
                            ->where('flag',1)
                            ->where('show_flag',1)
                            ->orderBy('content_id', 'desc')
                            ->get();
                        break;
                    case 'private': //비공개
                        $result['data'] = $this->db->table('channel_contents')
                            ->where('user_id',$channelId)
                            ->where('flag',1)
                            ->where('show_flag',0)
                            ->orderBy('content_id', 'desc')
                            ->get();
                        break;
                    case 'temp': //임시
                        $result['data'] = $this->db->table('channel_contents')
                            ->where('user_id',$channelId)
                            ->where('flag',0)
                            ->orderBy('content_id', 'desc')
                            ->get();
                        break;
                }

				$result['userChk'] = true;

                //만약 데이터가 없다면 ?
                if($result['data']->isEmpty() ) {
                    $result['data'] = false;


                    // 2019-01-28 박지연 전체 등록한 게시물이 있는지 확인, 문구 수정
                    $list = $this->db->table('channel_contents')
                            ->where('user_id',$channelId)
                            ->where('flag',"<",2)
                            ->orderBy('content_id', 'desc')
                            ->get();

                    if($list->isEmpty()) {
                        $result['msg'] = "<div class='ch_title'><h4>첫 게시물을 등록하시면 cent를 받을 수 있어요.</h4></div>";
                    } else {
                        switch ($req->flag) {
                            case 'public': $result['msg'] = "공개"; break;
                            case 'private': $result['msg'] = "비공개"; break;
                            case 'temp': $result['msg'] = "임시"; break;
                        }
                        $result['msg'] = $result['msg']." 게시물이 없습니다.";
                    }
                }
            //같지 않다면
            }else {

                $result['data'] = $this->db->table('channel_contents')
                    ->where("use_yn",1)
                    ->where('user_id',$channelId)
                    ->where('flag',1)
                    ->orderBy('content_id', 'desc')
                    ->get();
                //만약 데이터가 없다면 ?
                if($result['data']->isEmpty() ) {
                    $result['data'] = false;
                    $result['msg'] = "등록된 게시물이 없어요.";
                }
                $result['userChk'] = false;
            }
        }



        return response()->json($result);

    }

    public function getContent(Request $req)
    {
        //로그인 안했으면
        if (!$this->checkSec() ) {
            return response()->json(false);
        }
        if (!$req->has('channel_id')) {
            return response()->json(false);
        }

        $channelId = $req->channelId; //채널아이디
        $result = $this->db->table('channel_contents')->where('user_id',$this->userId)->where('content_id',$channelId)->first();

        return response()->json($result);


    }

    // 2019-01-29 박지연 구독중인 리스트 가져오기
    public function followList(Request $req)
    {
        //로그인 안했으면
        if (!$this->checkSec() ) {
            return response()->json(false);
        }

        $channelId = request()->segment(4);

        $this->data['follower'] = $this->db->table('pet_channel')
        ->select("pet_channel.*","om_test_ohwe.op_member.nickname")
        ->leftJoin("pet_follower","pet_follower.user_id","pet_channel.user_id")
        ->leftJoin("om_test_ohwe.op_member","op_member.user_id","pet_channel.user_id")
        ->where("pet_follower.channel_id",$channelId)
        ->where('pet_follower.flag',1)
        ->orderBy('pet_follower.updated_date', 'desc')
        ->get();

        $this->data['follow'] = $this->db->table('pet_follower')
        ->where('user_id',$this->userId)
        ->where('flag',1)
        ->get();

        return response()->json($this->data);

    }

    // 2019-01-29 박지연 좋아요 리스트 가져오기
    public function likeList(Request $req)
    {
        //로그인 안했으면
        if (!$this->checkSec() ) {
            return response()->json(false);
        }

        $contentId = request()->segment(4);

        $this->data['channel'] = $this->db->table('pet_channel')
        ->select("pet_channel.*","om_test_ohwe.op_member.nickname")
        ->leftJoin("pet_like","pet_like.user_id","pet_channel.user_id")
        ->leftJoin("om_test_ohwe.op_member","op_member.user_id","pet_channel.user_id")
        ->where("pet_like.content_id",$contentId)
        ->where('pet_like.flag',1)
        ->where('pet_like.like_type',0)
        ->orderBy('pet_like.updated_date', 'desc')
        ->get();

        $this->data['follow'] = $this->db->table('pet_follower')
        ->where('user_id',$this->userId)
        ->where('flag',1)
        ->get();

        $this->data['myChannelChk'] = $this->userId;

        return response()->json($this->data);

    }


	// 2019-01-21 박지연 펫스타 업데이트순|인기순|조회순 함수
    public function alignList(Request $req)
    {
        $colum = "";
        $result = "";
        $limit = 100;

        switch (request()->segment(3)) {
            case 'update': // 업데이트순
                $colum = "created_date";
                break;
            case 'like': // 인기순
                $colum = "cnt";
                break;
            case 'viewCnt': // 조회순
                $colum = "viewCnt";
                break;
        }

        if($colum == 'created_date' || $colum == 'viewCnt') {
            $result = $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->where('show_flag',1)
            ->limit($limit)
            ->orderBy($colum, 'desc')
            ->get();

        } else {
            $result = $this->db->table('channel_contents')
            ->leftJoin("pet_like","pet_like.content_id","channel_contents.content_id")
            ->select( $this->db->raw('count(pet_like.content_id) as cnt'),"channel_contents.*")
            ->whereNotNull("pet_like.content_id")
            ->where("pet_like.flag",1)
            ->where("channel_contents.use_yn",true)
            ->where("channel_contents.flag",1)
            ->where("pet_like.like_type",0)
            ->where('channel_contents.show_flag',1)
            ->groupBy("pet_like.content_id")
            ->orderBy("cnt","desc")
            ->orderBy("viewCnt","desc")
            // ->offset(0)
            ->limit($limit)
            ->get();
        }

        return response()->json($result);
    }

    // 2019-01-21 박지연 펫스타 썸네일 게시물 더보기 함수
    public function moreList(Request $req)
    {
        $colum = request()->segment(3);
        $offset = request()->segment(4);
        $limit = 40;
        $result->data["more"] = false;

        switch (request()->segment(3)) {
            case 'first': // 최초
                $colum = "content_id";
                break;
            case 'update': // 업데이트순
                $colum = "content_id";
                break;
            case 'like': // 인기순 -> ?하루 or 주단위 인기순으로 할지 check
                $colum = "cnt";
                break;
            case 'viewCnt': // 조회순
                $colum = "viewCnt";
                break;
        }

        if($colum == 'content_id' || $colum == 'viewCnt' || $colum == 'first') {
            $result->data["data"] = $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->where('show_flag',1)
            ->offset($offset)
            ->limit($limit)
            ->orderBy($colum, 'desc')
            ->get();

            $cnt = $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->where('show_flag',1)
            ->count();

            if($cnt > $offset + $limit) {
                $result->data["more"] = true;
            }
        } else {
            $result->data["data"] = $this->db->table('channel_contents')
            ->leftJoin("pet_like","pet_like.content_id","channel_contents.content_id")
            ->select( $this->db->raw('count(pet_like.content_id) as cnt'),"channel_contents.*")
            ->whereNotNull("pet_like.content_id")
            ->where("pet_like.flag",1)
            ->where("channel_contents.use_yn",true)
            ->where("channel_contents.flag",1)
            ->where("pet_like.like_type",0)
            ->where('channel_contents.show_flag',1)
            ->groupBy("pet_like.content_id")
            ->orderBy("cnt","desc")
            ->orderBy($colum,"desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

            $cnt = $this->db->table('channel_contents')
            ->leftJoin("pet_like","pet_like.content_id","channel_contents.content_id")
            ->select( $this->db->raw('count(pet_like.content_id) as cnt'),"channel_contents.*")
            ->whereNotNull("pet_like.content_id")
            ->where("pet_like.flag",1)
            ->where("channel_contents.use_yn",true)
            ->where("channel_contents.flag",1)
            ->where("pet_like.like_type",0)
            ->where('channel_contents.show_flag',1)
            ->groupBy("pet_like.content_id")
            ->orderBy("cnt","desc")
            ->orderBy($colum,"desc")
            ->get();

            if(count($cnt) > $offset + $limit) {
                $result->data["more"] = true;
            }
        }

        return $result->data;

        // return response()->json($result);
    }
}
