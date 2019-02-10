<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SingUpRequest;
use DB, Hash, Validator, Mail;

class MailController extends Controller {
    private $db;
    private $key;
    private $req_email;
//    private $req_name;
    private $codeLength = 15;
    private $codeSendFlag = 0;


	public function __construct()
    {
        date_default_timezone_set('Asia/Seoul');
    }
    public function index(Request $request){
        $this->key = $request->post('key');
        $this->req_email = $request->post('req_email');
//        $this->req_name = $request->post('req_name');

        return $this->isKey($this->key);
	}

    private function isKey($key)
    {
       if($key == 'ksykey') {
           return $this->isMail($this->req_email);
        }else{
            exit;
       }
    }
	private function isMail($chk_email)
    {
        if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $chk_email)) || (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/', $chk_email)) ) {
            $this->req_email = $chk_email;
            return $this->setRandomCode($this->codeLength);
//            return $chk_email;
        }else{
            return false;
        }
    }
    private function setRandomCode($codeLength)
    {
        $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $text .= 'abcdefghijklmnopqrstuvwxyz';
        $text .= '0123456789';

        $textLength = strlen($text) - 1;
        $randCode = '';
        for($i = 1; $i <= $codeLength; $i++) {
            $randCode .= $text[mt_rand(0, $textLength)];
        }

        return $this->sendEmail($this->req_email,$randCode);
    }

// 	private function sendEmail($req_email,$randCode)
//     {

// //        $toName =$req_name;
//         $toEmail = $req_email;
//         $fromEmail = 'support@ohwecoin.io';
//         $fromName = 'Ohwe';
//         $subject= '테스트메일입니다';
//         $data = array("body" => $randCode,"title" => $subject);

//         Mail::send('email.testMail', $data, function($message) use ($toEmail,$fromEmail,$fromName,$subject) {
//             $message->to($toEmail)->subject($subject);
//             $message->from($fromEmail,$fromName);
//         });
//         return $this->insertCode($toEmail,$randCode);
//     }

    private function sendEmail($req_email,$randCode)
    {

//        $toName =$req_name;
        $toEmail = $req_email;
        $fromEmail = 'support@ohwecoin.io';
        $fromName = 'Ohwe';
        $subject= '[오위] 오위 서비스 계정 이메일 등록 인증 번호';
        $data = array("body" => $randCode,"title" => $subject);

        Mail::send('email.signUpMail', $data, function($message) use ($toEmail,$fromEmail,$fromName,$subject) {
            $message->to($toEmail)->subject($subject);
            $message->from($fromEmail,$fromName);
        });
        return $this->insertCode($toEmail,$randCode);
    }

    private function insertCode($req_email,$randCode){
	    $regtime = time();
        $this->db = DB::connection('aws');
        //테이블에서 검색하고 있으면 flag 1 변경
        $cnt = $this->db->table("com_user_auth")->where("email",$req_email)->count();
        if($cnt > 0){
            $this->codeSendFlag = 1; // 재발송
        }
        $this->db->table("com_user_auth")->insert([
            'email' => $req_email,
            'code' => $randCode,
            'flag' => $this->codeSendFlag,
            'regtime' => $regtime
        ]);
    }

}

?>
