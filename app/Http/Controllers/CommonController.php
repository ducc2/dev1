<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


/**
 * @2019 01.15
 * @PHP upload Data Size
**/

ini_set('memory_limit','1024M');
ini_set('max_execution_time', 1000); //300->1000
ini_set('max_input_time',-1); //300->1000
ini_set('post_max_size','1100M');
ini_set('upload_max_filesize','1000M');

class CommonController extends Controller
{
	public function __construct()
    {
        $this->db = DB::connection('aws');
    }
    public function index()
    {

    }
    //GNB Menu
    public function gnbMenu(Request $req)
    {
        $gnbType = $req->nav;
        $gnbMenu = $this->db->table('sys_navmenu')->where('use_yn', true)->where('gnbType',$gnbType)->get();
        return response()->json($gnbMenu);
    }
    //AWS S3 Upload Prc
    public function s3UploadPrc($fileName,$file)
    {
        $s3 = \Storage::disk('s3');

        $result = $s3->put($fileName, file_get_contents($file), 'public'); //s3 upload
        if ($result){
            return true;
        }
        return false;

    }
    //공통 등록
    public function add($tbl,$data,$insertType = null)
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

    public function modify($tbl,$data,$modifyType = null)
    {
        $result = $this->db->table($tbl)
        ->where("pet_profile_id", $data['pet_profile_id'])
        ->update($data);

        return $result;
    }
    //메세지 박스
    public function msgBox($language)
    {
        switch ($language) {
            case 'kr':
                $msg = (object) array(
                    "loginFail" => "로그인 히세요",
                    "pathFail" => "잘못된 경로입니다.",
                    "emptyChannel" => "채널이 없습니다.",
                    "emptyComment" => "댓글을 작성해주세요.",
                    "likeFail" => "본인 콘텐츠에는 좋아요를 할 수 없습니다.",
                    "followerFail" => "본인 채널에는 구독 할 수 없습니다."
                );
                break;

            default:
                $msg = (object) array(
                    "loginFail" => "로그인 히세요",
                    "pathFail" => "잘못된 경로입니다.",
                    "emptyChannel" => "채널이 없습니다.",
                    "emptyComment" => "댓글을 작성해주세요.",
                    "likeFail" => "본인 콘텐츠에는 좋아요를 할 수 없습니다.",
                    "followerFail" => "본인 채널에는 구독 할 수 없습니다."
                );
                break;
        }


        return $msg;

    }
}
