<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\RewardController as RewardC;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * @2019 01.15
 * @PHP upload Data Size
**/

ini_set('memory_limit','1024M');
ini_set('max_execution_time', 300);
ini_set('max_input_time',300);
ini_set('post_max_size','1100M');
ini_set('upload_max_filesize','1000M');

class ProfileController extends Controller
{
    private $db;
    private $sec;
    private $user;
    private $viewMsg;
    public function __construct( SessionController $sec,CommonController $common)
    {
        $this->sec = $sec;
        $this->common = $common;
        $this->db = DB::connection('aws');
        date_default_timezone_set('Asia/Seoul');

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
    public function index()
    {

    }
    private function fileCheck($file,$fileType)
    {
        $exMinmeType = explode("/",$file->getMimeType()); //이미지인지 체크
        switch ($exMinmeType[0]) {
            case 'image': break; //이미지인지 체크
            case 'video': break; //영상인지 체크
            default: return array("err"=>false,"msg"=>"이미지 파일이 아닙니다." ); break;
        }
        
        $ext = $file->getClientOriginalExtension(); //확장자
        $fileName = "/pet/profile/" . md5($file->getClientOriginalName() ) . "_" . (int) round(microtime(true) * 1000) . "." . $ext; //사진

        return  array("err"=>true,"msg"=>$fileName);

    }

    public function petProfilePrc(Request $req) {
        //유효성 검사 로그인 
        if(!$this->checkSec()) {
            return response()->json( array("err"=>false,"msg"=>"로그인 하세요." ) );
        }
        //변수 정리
        $mode = $req->mode; //등록 & 수정 & 삭제
        $channel_id = ($mode=="add")?$req->channel_id[0]:$req->channel_id; //채널 고유번호
        $data = $req->all(); //모든 Request Value
        $use_yn = true; //사용여부
        $created_by = $this->userId; //생성자
        $created_date = Carbon::now()->toDateTimeString(); //Datetime Ex) 2018-12-15 12:00:00
        $tbl = "pet_profile";

        //필요하지 않는 부분 배열 삭제
        unset($data['channel_id']); 
        unset($data['mode']);

        $channel = $this->db->table("pet_channel")
            ->where('user_id',$this->userId)
            ->where('channel_id',$channel_id)
            ->where('use_yn',true)
            ->first(); //채널 조회
        
        //해당 채널이 없으면 ..
        if(empty($channel) ) {
            return response()->json( array("err"=>false,"msg"=>"잘못된 경로" ) );
        }
        
        //배열이면 등록 
        if (is_array($data['pet_name']) ) {

            $successMsg =  "등록 성공";
            //만약 펫 프로필이 아닌 다른곳에서 접근한다면 ?
            if($mode != "add") {
                return response()->json(array("err"=>false,"msg"=>"잘못된 경로입니다." ));
            }
            //DB 등록하기 전에 유효성 체크 .
            for($i=0; $i< count($data['pet_name']); $i++ ) {
                
                
                /* 유효성 검사 */

                //펫 이미지가 없으면 
                if (empty($data['pet_img'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 프로필 이미지를 입력해주세요." ) );
                }
                //펫 이름이 없으면 
                if (empty($data['pet_name'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 이름을 입력해주세요." ) );
                }
                //펫 종류가 없으면 
                if (empty($data['pet_kind'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 종류를 입력해세요." ) );
                }
                //펫 생일이 없으면 
                if (empty($data['pet_birthY'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요.[년]" ) );
                }
                //펫 생일이 없으면 
                if (empty($data['pet_birthM'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요.[월]" ) );
                }
                //펫 생일이 없으면 
                if (empty($data['pet_birthD'][$i]) ) {
                    return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요. [일]" ) );
                }
                
            }

            //유효성 체크 이후에 DB 저장
            for($i=0; $i< count($data['pet_name']); $i++ ) {
                $fileName = $this->fileCheck($data['pet_img'][$i],"image") ; //파일 체크 
                //이미지 파일이 아니면
                if(!$fileName['err']) { 
                    return response()->json($fileName);
                }
                $dbData = array(
                    "channel_id" => $channel_id,
                    "user_id" => $this->userId,
                    "pet_name" => $data['pet_name'][$i],
                    "pet_kind" => $data['pet_kind'][$i],
                    "pet_birth" => $data['pet_birthY'][$i] . "." .$data['pet_birthM'][$i]  . "." . $data['pet_birthD'][$i],
                    "pet_img" => $fileName["msg"],
                    "pet_sex" => $data['pet_sex'][$i],
                    "pet_remark" => $data['pet_remark'][$i],
                    "use_yn" => $use_yn,
                    "created_by" => $created_by,
                    "created_date" => $created_date
                );
                
                $result = $this->common->add($tbl,$dbData);
                if (!$result || $result == 0){
                    return response()->json(array("err"=>false,"msg"=>"네트워크 에러 ( 실패 )" ));
                }
                $fileUpload = $this->common->s3UploadPrc($fileName["msg"],$data['pet_img'][$i]); //파일 업로드
            }
            

        //배열이 아닌 경우는 .. 수정 & 삭제
        }else {
            $pet_name = $req->pet_name; //펫 이름
            $pet_kind = $req->pet_kind; //펫 종류
            $pet_birthY = $req->pet_birthY; //펫 생일
            $pet_birthM = $req->pet_birthM; //펫 생일
            $pet_birthD = $req->pet_birthD; //펫 생일
            $pet_img = $req->file('pet_img'); //펫 이미지
            $pet_sex = $req->pet_sex; //펫 성별
            $pet_remark = $req->pet_remark; //펫 특징
            $imgCheck = false;
            $fileName = null;

            if (empty($pet_name) ) {
                return response()->json( array("err"=>false,"msg"=>"펫 이름을 입력해주세요." ) );
            }
            if (empty($pet_kind) ) {
                return response()->json( array("err"=>false,"msg"=>"펫 종류를 입력해세요." ) );
            }
            if (empty($pet_birthY) ) {
                return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요." ) );
            }
            if (empty($pet_birthM) ) {
                return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요." ) );
            }
            if (empty($pet_birthD) ) {
                return response()->json( array("err"=>false,"msg"=>"펫 생일을 입력해주세요." ) );
            }
            if (!empty($pet_img) ) {
                $imgCheck = true;
                $fileName = $this->fileCheck($pet_img,"image") ; //파일 체크 
                //이미지 파일이 아니면
                if(!$fileName['err']) { 
                    return response()->json($fileName);
                }
                //return response()->json( array("err"=>false,"msg"=>"펫 프로필 이미지를 입력해주세요." ) );
            }
            
            

            switch ($mode) {
                case 'modify':
                    $successMsg =  "수정 성공";
                    $data = array(
                        "pet_profile_id" =>$req->pet_profile_id,
                        "channel_id" => $channel_id,
                        "user_id" => $this->userId,
                        "pet_name" => $pet_name,
                        "pet_kind" => $pet_kind,
                        "pet_birth" => $pet_birthY . "." .$pet_birthM  . "." . $pet_birthD,
                        "pet_img" => $fileName["msg"],
                        "pet_sex" => $pet_sex,
                        "pet_remark" => $pet_remark,
                        "use_yn" => true,
                        "updated_by" => $created_by,
                        "updated_date" => $created_date
                    );
                    //이미지가 없다면 배열에서 삭제 ..
                    if(!$imgCheck) {
                        unset($data['pet_img']);
                    }else {
                        $fileUpload = $this->common->s3UploadPrc($fileName["msg"],$pet_img); //파일 업로드
                    }
                    
                    $result = $this->common->modify($tbl,$data);
                    break;
                
                default: return response()->json(array("err"=>false,"msg"=>"잘못된 경로입니다." )); break;
            }
        }
        //결과 값 리턴..
        if ($result){
            return response()->json(array("err"=>true,"msg"=>$successMsg ));
        }

    }
}
