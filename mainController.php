<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\RewardController as RewardC;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use FFMpeg;



/**
 * @2019 01.15
 * @PHP upload Data Size
**/

ini_set('memory_limit','1024M');
ini_set('max_execution_time', 1000); //300->1000
ini_set('max_input_time',-1); //300->1000
ini_set('post_max_size','1100M');
ini_set('upload_max_filesize','1000M');

class mainController extends Controller
{
    private $db;
    private $sec;
    private $user;
    private $viewMsg;
    public function __construct( SessionController $sec,RewardC $RewardC,CommonController $common,UploadController $uploadCtr)
    {
        $this->sec = $sec;
		$this->RewardCont = $RewardC;
        $this->uploadCtr = $uploadCtr;
        $this->common = $common;
        $this->db = DB::connection('aws');
        $this->viewMsg = $common->msgBox("kr");
        date_default_timezone_set('Asia/Seoul');

    }
    //Msg JSON
    private function msgJson($msg,$err) {
        return array("err"=> $err ,"result"=> $msg );
    }
    //AWS S3 Upload Prc
    // private function s3UploadPrc($fileName,$file)
    // {
    //     $s3 = \Storage::disk('s3');
    //     $result = $s3->put($fileName, file_get_contents($file), 'public'); //s3 upload
    //     if ($result){
    //         return true;
    //     }
    //     return false;

    // }
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

    public function index()
    {

    }



    //S3 업로드
    public function uploadFile(Request $req)
    {
        //로그인 하지 않으면
        if(!$this->checkSec()) {
            return response()->json(false);
        }

        $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

        $postFile = $req->file('channelFile'); //업로드 파일
        $exMinmeType = explode("/",$postFile->getMimeType());
        $ext = $exMinmeType[1];
        $content_flag = 1; //이미지
        //만약 파일이 없으면
        if (empty($postFile ) ) {
            return response()->json(array("err"=>false,"msg"=>"파일이 없습니다."));
        }

        //if ( in_array($ext ,$extensions) ){
        if ($exMinmeType[0] == "video" || $exMinmeType[0] == "image") {
            $content = md5("contents") . "_" . time(); //사진,영상 파일 이름

            $uploadChk = $this->uploadCtr->petContentUpload($postFile,$content); //업로드 처리

            if (!$uploadChk["err"]) {
                return response()->json($uploadChk);
            }
            //동영상일경우
            if ($exMinmeType[0] == "video") {
                $content_flag = 0; //영상
            }

            switch ($req->mode) {
                case 'add':
                    $contents = array(
                        'user_id' => (int)$this->userId,
                        'content_url' => $content,
                        'use_yn' => false,
                        'content_flag'=>$content_flag,
                        'content_ext' => $ext,
                        'created_by' => $this->userId,
                        'created_date' => $created_date,
                        'updated_by' => $this->userId,
                        'updated_date' => $created_date
                    );
                    $result = $this->db->table('channel_contents')->insertGetId($contents);

                    break;
                case 'modify':
                    $updateData = array(
                        'content_url' => $content,
                        'content_flag'=> $content_flag,
                        'content_ext' => $ext,
                        'updated_by' => $this->userId,
                        'updated_date' => $created_date
                    );
                    $result = $this->db->table('channel_contents')
                        ->where('content_id', $req->content_id)
                        ->where('flag',0)
                        ->update($updateData);
                    break;
                default:
                    break;
            }

            //DB 저장 성공
            if (!empty($result) ) {
                $thumDir = "/pet/channel/contents/" . $content . "." . $ext;
                if ($content_flag == 1) {
                    $type = "img";
                }else {
                    //썸네일 이미지로 할 경우에는
                    $thumDir = "/pet/channel/thumnails/" . $content . ".jpg";
                    $type = "video";
                }
                $getData = array(
                    "err" => true,
                    "msg" => '',
                    "thumnail" => $thumDir,
                    "type" => $type,
                    "id" => $result
                );
                return response()->json($getData);
            //DB 저장 실패
            }else {
                $getData = array(
                    "err" => false,
                    "msg" => '네트워크 문제'
                );
                return response()->json($getData);
            }

        //허용하지 않는 파일이면
        }else {
            return response()->json(array("err" => false,"msg" => '잘못된 파일입니다.') );
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

    public function reportPrc(Request $req)
    {
        /* 유효성검사 */
        if(!$this->checkSec()) {
            return response()->json(  $this->msgJson("로그인 히세요",false) );
            exit;
        }
        //$code_group_id = "pet_report_0001";
        $code_id = $req->code_id;
        $pet_id = $req->replyIdx;
        $report_desc = $req->report_desc;
        $flag = $req->replyFlag;
        $user_id = $this->userId;

        if (!$req->has('code_id')) {
            return response()->json( $this->msgJson("잘못된 경로입니다." ,false ) );
        }
        if (!$req->has('replyIdx')) {
            return response()->json( $this->msgJson("잘못된 경로입니다." ,false ) );
        }

        $data = array(
            //"code_group_id" => $code_group_id,
            "code_id" => $code_id,
            "pet_id" => $pet_id,
            "report_desc" => $report_desc,
            "flag" => $flag,
            "user_id" => $user_id
        );
        //없으면 배열 삭제
        if ( empty($report_desc) ) {
            unset($data['report_desc']);
        }

        $result = $this->add("pet_report",$data);
        if ($result) {
            return response()->json( $this->msgJson($result,true ) );
        }
        return response()->json( $this->msgJson("실패",false ) );

    }

    //댓글 처리
    public function comment(Request $req)
    {
        /* 유효성검사 */
        if(!$this->checkSec()) {
            return response()->json(  $this->msgJson("로그인 히세요",false) );
            exit;
        }

        $commentType = $req->commentType; //댓글 수정/삭제/등록
        $user_id = $this->userId;
        $content_id = $req->content_id;
        $comment = $req->comment;
        $setDateBy = $this->userId;
        $setDate = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00
        $offset = 0;
        $limit = 30;

        /* 유효성검사 */
        if (!$req->has('comment')) {
            return response()->json( $this->msgJson("댓글을 작성해주세요.",false) );
            exit;
        }
        if (!$req->has('content_id')) {
            return response()->json( $this->msgJson("잘못된 경로.",false) );
            exit;
        }
        if ($req->has('offset')) {
            $offset = $req->offset;
        }
        if (!$req->has('limit')) {
            $limit = $req->limit;
        }

        $profile = $this->db->table("pet_channel")
            ->where('user_id',$user_id)
            ->where('use_yn',true)
            ->first(); //채널 조회

        /* 유효성검사 */
        if(!$this->paramChk($profile) ) {
            $base_img = $req->baseImg;
        }else {
            $base_img = null;
        }

        switch ($commentType) {
            case 'add':
                $data = array(
                    "user_id" => $user_id,
                    "content_id" => $content_id,
                    "comment" => $comment,
                    "seq" => 1,
                    "base_img" => $base_img,
                    "created_by" => $setDateBy,
                    "created_date" => $setDate,
                    "updated_by" => $setDateBy,
                    "updated_date" => $setDate
                );

                break;
            case "reply":
                $parentChk = $this->db->table('pet_comment')
                    ->where("comment_id",$req->parent)
                    ->first(); //DB조회
                $data = array(
                    "user_id" => $user_id,
                    "content_id" => $content_id,
                    "comment" => $comment,
                    "parent" => $req->parent,
                    "seq" => $parentChk->seq + 1,
                    "base_img" => $base_img,
                    "created_by" => $setDateBy,
                    "created_date" => $setDate,
                    "updated_by" => $setDateBy,
                    "updated_date" => $setDate
                );

                break;
            case "modify":
                $data = array(
                    "comment" => $comment,
                    "flag" => 1,
                    "updated_by" => $this->userId,
                    "updated_date" => $setDate
                );

                break;
            case "del":
                $data = array(
                    //"comment" => $comment,
                    "flag" => 0,
                    "updated_by" => $this->userId,
                    "updated_date" => $setDate
                );
                break;
            case "lists":
                $data["listType"] = "all";
                $data["offset"] = $offset;
                $data["limit"] = $limit;
                break;
            default:
                return response()->json( $this->msgJson("잘못된 경로",false) );
                break;
        }

        $getResult = $this->petPrc("pet_comment",$commentType,$data,$req);
		//return $getResult['lastComment'];
        if ($getResult['lastComment'] || $getResult['lastComment'] > 0) {
            $commentLists = $this->petPrc("pet_comment","list",$getResult['lastComment'],$req);
			if ($commentType=='add' || $commentType=='reply') {
				$commentLists->reward_point=$getResult['reward_point'];
			}
            return response()->json( $this->msgJson($commentLists,true) );
        }else {
            return response()->json( $this->msgJson("실패",false) );
        }

    }

    //좋아요
    public function like(Request $req)
    {
        //로그인 체크
        if(!$this->checkSec()) {
            //로그인안했으면
            return response()->json( $this->msgJson("로그인 하세요",false) );
        }else {
            //변수 정리

            $like_type = 0;
            $comment_id = 0;
            $channel_id = $req->channel_id; //채널 번호
            $content_id = $req->content_id; //채널 컨텐츠 번호
            $user_id = $this->userId; //유저 번호

            $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00


            if($req->has("like_type") ){
                $like_type = $req->like_type;
            }
            if($req->has("comment_id") ){
               $comment_id = $req->comment_id;
            }


            $data = array(
                "channel_id" => $channel_id,
                "content_id" => $content_id,
                "comment_id" => $comment_id,
                "user_id" => $user_id,
                "like_type" => $like_type,
                "created_by" => $user_id,
                "created_date" => $created_date,
                "updated_by" => $user_id,
                "updated_date" => $created_date
            );

            switch ($comment_id) {
                //콘텐츠
                case 0:
                    $chkChannel = $this->db->table('pet_channel')
                        ->where("channel_id",$channel_id)
                        ->first(); //DB조회
                    //채널이 없으면 ..
                    if ( empty($chkChannel) ) {
                        //"채널이 없습니다."
                        return response()->json( $this->msgJson($this->viewMsg->emptyChannel,false) );
                    //자기자신좋아요
                    }else if ($chkChannel->user_id == $user_id){
                        //"본인 콘텐츠에는 좋아요를 할 수 없습니다."
                        //print_r($this->viewMsg);
                        return response()->json( $this->msgJson($this->viewMsg->likeFail,false) );
                    }
                    //좋아요 DB
                    $result = $this->db->table('pet_like')
                        ->where("content_id",$content_id)
                        ->where('user_id',$user_id)
                        ->where("like_type",0)
                        ->first(); //DB조회
                    break;
                //댓글
                default:
                    $result = $this->db->table('pet_like')
                        ->where("comment_id",$comment_id)
                        ->where('user_id',$user_id)
                        ->where("like_type",1)
                        ->first(); //DB조회
                    break;
            }

            //채널 DB
            $getResult = $this->petPrc("pet_like",$result,$data);

            if ($getResult["err"]) {
                return response()->json( $this->msgJson($getResult,true) );
            }else {
                return response()->json( $this->msgJson("Error",false) );
            }

        }
    }
    //팔로우
    public function follower(Request $req)
    {
        //로그인 체크
        if(!$this->checkSec()) {
            //로그인안했으면
            return response()->json( $this->msgJson("로그인 하세요",false) );
        }else {

            $channel_id = $req->channel_id;
            $user_id = $this->userId;
            $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

            $data = array(
                "channel_id" => $channel_id,
                "user_id" => $user_id,
                "created_by" => $user_id,
                "created_date" => $created_date,
                "updated_by" => $user_id,
                "updated_date" => $created_date
            );

            //채널 DB
            $chkChannel = $this->db->table('pet_channel')
                ->where("channel_id",$channel_id)
                ->first(); //DB조회
            //채널이 없으면 ..
            if ( empty($chkChannel) ) {
                return response()->json( $this->msgJson("채널이 없습니다.",false) );
            //자기자신팔로우
            }else if ($chkChannel->user_id == $user_id){
                return response()->json( $this->msgJson($this->viewMsg->followerFail,false) );
            }
            //팔로우 DB
            $result = $this->db->table('pet_follower')
                ->where("channel_id",$channel_id)
                ->where('user_id',$user_id)
                ->first(); //DB조회

            //return response()->json( $this->petPrc("pet_follower",$result,$data) );
            $getResult = $this->petPrc("pet_follower",$result,$data);


            if ($getResult["err"]) {
                //return response()->json( $this->msgJson($getResult["result"],true) );
                return response()->json($getResult );
            }else {
                return response()->json( $this->msgJson("Error",false) );
            }
        }
    }



    private function petPrc($tbl,$result,$data,$req = null)
    {
        $returnData = null;

        switch ($tbl) {
            //펫 팔로우
            case 'pet_follower':

				$flag = 0;
                if ( empty($result ) ) {
					$getResult = $this->db->table($tbl)->insert($data);
					$cnt = $this->db->table($tbl)
						->where('channel_id',$data['channel_id'])
						->where('flag',1)
						->count(); //팔로우 개수
					$flag = 1;
					$point_num = $this->RewardCont->reward_Prc($tbl,$data['channel_id'],$flag);

					$returnData = array("err" => true ,"result" => $cnt,"msg" => "구독중","flag" => $flag,"point_num" => $point_num) ;

                }else {
                    //팔로우 취소 했다가 다시 팔로우 ..
                    if ($result->flag == 0 ) {
                        $flag = 1;
                        $msg = "구독중";
                    //팔로우 취소
                    }else {
                        $flag = 0;
                        $msg = "구독";
                    }
                    $updateData = array(
                        "flag" => $flag,
                        "updated_by" => $data['updated_by'],
                        "updated_date" => $data['updated_date']
                    );
                    $getResult = $this->db->table($tbl)
                        ->where('follower_id', $result->follower_id)
                        ->where("user_id",$this->userId)
                        ->update($updateData);

                    if ($getResult == 1 || $getResult == true) {
                        $cnt = $this->db->table($tbl)
                            ->where('channel_id',$data['channel_id'])
                            ->where('flag',1)
                            ->count(); //팔로우 개수

                        $returnData = array("err" => true ,"result" => $cnt,"msg" => $msg,"flag" => "1") ;
                    }else { //실패
                        $returnData = array("err" => false ,"result" => "","flag" => "1") ;
                    }

					$point_num = 0;
                }


				//-------------------------------------
				//----------구독 히스토리기록 및 보상처리-------
				//-------------------------------------
				if ($this->userId) {
					$point_num = $this->RewardCont->reward_Prc($tbl,$data['channel_id'],$flag);
				}  else {
					$point_num = 0;

				}
				$returnData = array("err" => true ,"cnt" => $cnt,"flag" => $flag,"point_num" => $point_num) ;

                break;
            case 'pet_like':
                switch ($data["comment_id"]) {
                    case 0:
                        $colum = "content_id"; //콘텐츠 좋아요
                        $likeType = 0;
                        break;
                    default:
                        $colum = "comment_id"; //댓글 좋아요
                        $likeType = 1;
                        break;
                }

                if ( empty($result ) ) {

                    $getResult = $this->db->table($tbl)->insert($data);
                    if ($getResult || $getResult == 1) {
                        $cnt = $this->db->table($tbl)
                            ->where($colum,$data[$colum])
                            ->where('flag',1)
                            ->where('like_type',$likeType)
                            ->count(); //좋아요 개수

                        $err = true;
						$result = $cnt;

                    }else { //실패
                        $err = false;
						$result = "";
                    }

					$flag = 1;
                }else {

                    if ($result->flag == 0 ) { //좋아요 취소 했다가 다시 좋아요 ..
                        $flag = 1;
                    }else { //좋아요 취소
                        $flag = 0;
                    }
                    $updateData = array(
                        "flag" => $flag,
                        "updated_by" => $data['updated_by'],
                        "updated_date" => $data['updated_date']
                    );

                    $getResult = $this->db->table($tbl)->where('like_id', $result->like_id)->update($updateData);
                    if ($getResult == 1 || $getResult == true) {
                        $cnt = $this->db->table($tbl)
                            ->where($colum,$data[$colum])
                            ->where('flag',1)
                            ->where('like_type',$likeType)
                            ->count(); //좋아요 개수

                        $err = true;
						$result = $cnt;

                    }else { //실패
                        $err = false;
						$result = "";
                    }
                }


				//-------------------------------------
				//---------좋아요 히스토리기록 및 보상처리-------
				//-------------------------------------
				$point_num = $this->RewardCont->reward_Prc($tbl,$data['content_id'],$flag);

				$returnData = array("err" => true ,"cnt" => $cnt,"flag" => $flag,"point_num" => $point_num) ;

                break;
            case "pet_comment":

				$flag=0;
				$getResult = $this->db->table('channel_contents')->where('content_id', $req['content_id'])->first();

				if ($getResult->content_flag==0) {
					$reward_type = "pet_comment_".$result."_video";
				} else {
					$reward_type = "pet_comment_".$result;
				}
                switch ($result) {

                    //댓글 등록
                    case 'add':
						$flag=1;
                        $lastComment = $this->db->table($tbl)->insertGetId($data); //댓글 등록
						$reward_point = $this->RewardCont->reward_Prc($reward_type,$lastComment,$flag);
                        $updateData = $this->db->table($tbl)->where('comment_id', $lastComment)->update(array("parent"=>$lastComment) ); //댓글 등록
                        if ($updateData == 1 || $updateData) {
                            $returnData['lastComment'] = $lastComment;
							$returnData['reward_point'] = $reward_point;
                        }else {
                            $returnData = false;
                        }

						//-------------------------------------
						//---------댓글 히스토리기록 및 보상처리--------
						//-------------------------------------
						$this->RewardCont->reward_Prc($tbl."_".$result,$data['content_id'],$flag);
                        break;
                    //대댓글 등록
                    case "reply":
						$flag=1;
                        $returnData['lastComment'] = $this->db->table($tbl)->insertGetId($data); //대댓글 등록
						$reward_point = $this->RewardCont->reward_Prc($reward_type,$returnData['lastComment'],$flag);
						$returnData['reward_point'] = $reward_point;
						//-------------------------------------
						//--------대댓글 히스토리기록 및 보상처리--------
						//-------------------------------------
						$this->RewardCont->reward_Prc($tbl."_".$result,$data['content_id'],$flag);
						break;
                    //수정
                    case "modify":
                        $comment_id = $req['comment_id'];
                        $returnData['lastComment'] = $this->db->table($tbl)->where('user_id', $this->userId)->where("comment_id",$comment_id)->update($data); //댓글 수정
                        break;
                    //삭제
                    case "del":
                        $comment_id = $req['comment_id'];
                        $returnData['lastComment'] = $this->db->table($tbl)->where('user_id', $this->userId)->where("comment_id",$comment_id)->update($data); //댓글 삭제
                        break;
                    //목록
                    case "list":
                        if ($data["listType"] == "all") {
                            $returnData = $this->db->table($tbl)
                                ->leftJoin('pet_channel', 'pet_comment.user_id', '=', 'pet_channel.user_id')
                                ->join('om_test_ohwe.op_member', 'om_test_ohwe.op_member.uid', '=', 'pet_comment.user_id')
                                ->where("pet_comment.flag",1)
                                ->select('pet_comment.*', 'pet_channel.channel_img',"om_test_ohwe.op_member.name")
                                ->orderByRaw('parent,seq')
                                ->offset($data['offset'])
                                ->limit($data['limit'])
                                ->get();
                        }else {
                            $returnData = $this->db->table($tbl)
                                ->leftJoin('pet_channel', 'pet_comment.user_id', '=', 'pet_channel.user_id')
                                ->join('om_test_ohwe.op_member', 'om_test_ohwe.op_member.uid', '=', 'pet_comment.user_id')
                                ->where("pet_comment.flag",1)
                                ->where("pet_comment.comment_id",$data)
                                ->where("pet_comment.user_id",$this->userId)
                                ->select('pet_comment.*', 'pet_channel.channel_img',"om_test_ohwe.op_member.name")
                                ->first();

                        }
                        break;
                    default:
                        $returnData = false;
                    break;
                }
            default:

                break;


        }
        return $returnData;
    }

    //채널 수정 ORG 향후 삭제 예정 ..
    public function channelMod(Request $req)
    {
        if(!$this->checkSec()) {
            return response()->json(false);
        }
        if (!$req->has('mod')) {
            return response()->json(false);
        }

        switch ($req->mod) {
            case 'name':
                $channelVal = $req->channel_name; //채널명
                break;
            case 'remark':
                $channelVal = $req->channel_remark; //채널명
                break;
            default:
                # code...
                break;
        }

        if (!$req->has('channel_id')) {
            return response()->json(false);
        }

        if (empty($channelVal ) ) {
            return response()->json(false);
        }


        $petChannel = array(
            'channel_' . $req->mod => $channelVal,
            'updated_by' => $this->userId,
            'updated_date' => Carbon::now()->toDateTimeString()
        );


        $where = array("channel_id",$req->channel_id);
        $updateData = $this->modify("pet_channel",$petChannel,$where);
        $channelData = $this->first("pet_channel",$where);
        $result = array("err" => $updateData,"data" => $channelData);

        return response()->json($result);
    }

    /*
        2019 01.15
        채널 만들기 & 채널 수정
    */
    public function channelPrc(Request $req)
    {
        if(!$this->checkSec()) {
            return response()->json(false);
        }
        //변수 정리
        $filePath = '/pet/channel/profile/' ; //파일 경로
        $channelName = $req->channel_name; //채널명
        $desc = $req->desc; //채널 설명
        $getType = $req->getType; //종류
        $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00 등록일

        //채널명이 없으면 ..
        if( !$this->paramChk($channelName) ) {
            return response()->json(false);
        }
        //채널 정보가 없으면 ..
        if( !$this->paramChk($desc) ) {
            return response()->json(false);
        }

        switch ($getType) {
            //수정
            case 'modify':
                $mainFileName = null;
                //유효성 검사
                if( !$this->paramChk($req->channel_id) ) {
                    return response()->json(false);
                }
                $where = array("user_id",$this->userId);
                $chkUserChannel = $this->first("pet_channel",$where);
                //실제 채널 생성자와 같지 않다면 ..
                if($chkUserChannel->channel_id !=  $req->channel_id){
                    return response()->json(false);
                }

                //이미지 수정이면 ..
                if ( $this->paramChk($req->file("imgFile")) ) {
                    $mainImg = $req->file('imgFile'); //메인 이미지
                    $mainFileName = md5("img") . "_" . time() . '.' . $mainImg->getClientOriginalExtension(); //프로필 이미지
                    $exMinmeType = explode("/",$mainImg->getMimeType());

                    if ($exMinmeType[0] != "image") {
                        return response()->json(false);
                    }
                    $result = $this->common->s3UploadPrc($filePath . $mainFileName,$mainImg);

                    if (!$result) {
                        return response()->json(false);
                    }
                }

                $datas = array(
                    'channel_name' => $channelName,
                    'channel_remark' => $desc,
                    'channel_img' => $filePath . $mainFileName,
                    'updated_by' => $this->userId,
                    'updated_date' => $created_date
                );

                if ( !$this->paramChk($req->file("imgFile") ) ) {
                    unset($datas['channel_img']);
                }

                $where = array("channel_id",$req->channel_id);
                $updateData = $this->modify("pet_channel",$datas,$where);
                $channelData = $this->first("pet_channel",$where);
                $result = array("err"=>$updateData,"data"=>$channelData);
                break;
            //등록
            case 'add':
                $mainImg = $req->file('imgFile'); //메인 이미지
                $mainFileName = md5("img") . "_" . time() . '.' . $mainImg->getClientOriginalExtension(); //프로필 이미지
                $exMinmeType = explode("/",$mainImg->getMimeType());

                //유효성 검사
                if( !$this->paramChk($mainImg) ) {
                    return response()->json(false);
                }
                if ($exMinmeType[0] != "image") {
                    return response()->json(false);
                }
                $s3Result = $this->common->s3UploadPrc($filePath . $mainFileName,$mainImg);
                if (!$s3Result) {
                    return response()->json(false);
                }

                $datas = array(
                    'user_id' => (int)$this->userId,
                    'channel_name' => $channelName,
                    'channel_remark' => $desc,
                    'channel_bg_img' => "",
                    'channel_img' => $filePath . $mainFileName,
                    'use_yn' => true,
                    'created_by' => $this->userId,
                    'created_date' => $created_date,
                    'updated_by' => $this->userId,
                    'updated_date' => $created_date
                );

                $result = $this->add("pet_channel",$datas);
                break;
            default:
                return response()->json(false);
                break;
        }

        return response()->json($result);
    }


    //새로운 채널 만들기 ORG 향후 삭제 예정 ..
    public function channelnew(Request $req)
    {
        if(!$this->checkSec()) {
            return response()->json(false);
        }

        $s3 = \Storage::disk('s3');

        $date = date_create();
        $extensions = ["jpg","jpeg","png"];

        $channelName = $req->channelName; //채널명
        $desc = htmlspecialchars($req->desc ); //채널 설명
        $mainImg = $req->file('imgFile'); //메인 이미지
        $bgImg = $req->file('bgImgFile'); //배경 이미지
        $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00

        //프로필 이미지 없음 채널 이미지
        if (empty($mainImg ) ) {
            return response()->json(false);
        }
        if ( in_array($mainImg->getClientOriginalExtension() ,$extensions) ){
            $filePath = '/pet/channel/profile/' ; //파일 경로

            $mainFileName = md5("img") . "_" . time() . '.' . $mainImg->getClientOriginalExtension(); //프로필 이미지

            $s3->put($filePath . $mainFileName, file_get_contents($mainImg), 'public'); //s3 upload

            if (!empty($bgImg) ) {

                $bgFileName = md5("bg") . "_" . time() . '.' . $bgImg->getClientOriginalExtension(); //배경 이미지
                $s3->put($filePath . $bgFileName, file_get_contents($bgImg), 'public'); //s3 upload
                $channel_bg_img = $filePath . $bgFileName;
            }else {
                $channel_bg_img = "";
            }

            //$userId = preg_replace('@"@', "", $this->user['login_chk_uid']);
            switch ($req->getType) {
                case 'add':
                    $petChannel = array(
                        'user_id' => (int)$this->userId,
                        'channel_name' => $channelName,
                        'channel_remark' => $desc,
                        'channel_bg_img' => $channel_bg_img,
                        'channel_img' => $filePath . $mainFileName,
                        'use_yn' => true,
                        'created_by' => $this->userId,
                        'created_date' => $created_date,
                        'updated_by' => $this->userId,
                        'updated_date' => $created_date
                    );

                    $result = $this->add("pet_channel",$petChannel);
                    break;
                case 'modify':

                    switch ($req['mod']) {
                        case 'img':
                            $petChannel = array(
                                'channel_img' => $filePath . $mainFileName,
                                'updated_by' => $this->userId,
                                'updated_date' => $created_date
                            );
                            break;
                        default:
                            # code...
                            break;
                    }


                    $where = array("channel_id",$req->channel_id);
                    $updateData = $this->modify("pet_channel",$petChannel,$where);
                    $channelData = $this->first("pet_channel",$where);
                    $result = array("err"=>$updateData,"data"=>$channelData);
                    break;
                default:
                    # code...
                    break;
            }


            //$result = $this->db->table('pet_channel')->insert($petChannel);

            return response()->json($result);
        }

    }

    //펫시터 뷰
    public function petsitter()
    {
        return view('pet/petsitter/index');
    }

    //공통 등록
    private function add($tbl,$data,$insertType = null)
    {
        switch($insertType){
            case 'id':
                $result = $this->db->table($tbl)->insertGetId($data);
                break;
            default:
                $result = $this->db->table($tbl)->insert($data);
                break;
        }
        return $result;
    }
    //공통 수정
    private function modify($tbl,$data,$where)
    {
        $result = $this->db->table($tbl)->where($where[0],$where[1])->update($data); //댓글 등록

        if ($result || $result > 0 ) {
            return true;
        }else {
            return false;
        }
    }
    //공통 조회 One
    private function first($tbl,$where)
    {
        $result = $this->db->table($tbl)->where($where[0],$where[1])->first();

        if( empty($result) ){
            return false;
        }
        return $result;

    }


}
