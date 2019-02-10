<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommonController;
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
ini_set('post_max_size','2200M');
ini_set('upload_max_filesize','2100M');

class UploadController extends Controller
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
        $this->viewMsg = $common->msgBox("kr");
        date_default_timezone_set('Asia/Seoul');

    }
    private function checkSec()
    {
        $check = $this->sec->sessionChk();

        if ($check ) {
            //$this->userId = preg_replace('@"@', "", $check['p2p_log_uid']); //유저아이디
            $this->userId = $check['p2p_log_uid']; //유저아이디
            return true;
        }else {
            return false;
        }
    }

    public function petContentUpload($file,$fileName)
    {	
    	if(!$this->checkSec()) {
            return array("err"=>false,"msg"=>"로그인 히세요." );
        }
        

    	$dir = "/pet/channel/contents/";
    	$thumnailsDir = "/pet/channel/thumnails/";
    	//$ext = $file->getClientOriginalExtension(); //확장자
    	

        $exMinmeType = explode("/",$file->getMimeType());

        switch ($exMinmeType[0]) {
        	case 'video':
        		//220200960 210MB 
        		//용량 체크
        		if ( $file->getClientSize() > 220200960) {
        			return array("err"=>false,"msg"=>"업로드 용량은 200mb 입니다. 현재 파일 용량 " . $file->getClientSize() . "mb" );
        		}
        		//확장자 체크
        		if($exMinmeType[1] != "mp4") {
    				return array("err"=>false,"msg"=>"mp4 확장자만 사용할 수 있습니다. 현재 확장자 " . $exMinmeType[1] );
    			}
    			$this->ffmpegFile("thumbnailAdd",$file,$fileName); //썸네일 생성

        		$thumn = asset('thumnails/' . $fileName .'.jpg');
        		$result = $this->common->s3UploadPrc($thumnailsDir . $fileName .  '.jpg', $thumn); //썸네일 이미지 업로드 

				$this->ffmpegFile("thumbnailDel",$file,$fileName); //썸네일 삭제
        		break;

        	case 'images': break;
        	default: break;
        }
    	
    	$result = $this->common->s3UploadPrc($dir . $fileName . '.' . $exMinmeType[1], $file); //영상 업로드

    	return array("err"=>$result ,"msg"=>"");
    }
   
    	// $ext = "mp4";
     //    $s3->put("/pet/channel/tmp/" . $content .  '.' . $ext, file_get_contents($postFile), 'public'); //s3 upload
     //    $ffmpeg = FFMpeg\FFMpeg::create();
     //    $video = $ffmpeg->open( $postFile );
     //    $format = new FFMpeg\Format\Video\X264();
     //    $tmpVideo = $video->save($format->setAudioCodec("libmp3lame") ,'video/'.$content.'.mp4');

        //$s3->put("/pet/channel/tmp/" . $content .  '.' . $ext, file_get_contents($postFile), 'public'); //s3 upload
        //$tmpExec = shell_exec("/usr/bin/ffmpeg -i " . $ohweS3Dir . "/pet/channel/tmp/" . $content .  '.' . $ext . " " . $ohweVideoDir . $content .  '.mp4' ); //mp4변환

    

    private function ffmpegFile($mpegType,$file,$fileName)
    {
    	switch ($mpegType) {
    		case 'thumbnailAdd':
    			shell_exec("/usr/bin/ffmpeg -i $file -ss 00:00:03 -vframes 1 -q:v 2 /var/www/html/ohwe/public/thumnails/$fileName.jpg"); //썸네일 생성
    			break;
    		case 'thumbnailDel':
    			shell_exec("rm -rf /var/www/html/ohwe/public/thumnails/$fileName.jpg");
    			break;		
    		default:

    			break;
    	}
    }
}