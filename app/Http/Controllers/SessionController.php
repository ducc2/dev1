<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Cookie;

class SessionController extends Controller
{
    

     /**
     * Construct
     * @param null
     */
    public function __construct()
    {
        
    }
    

    public function sessionChk()
    {
        
        $redis = Redis::connection('default');
        if (empty($_COOKIE['PHPSESSID']) ) {
            //$this->data['getUser'] = false;
            return false;
        }else {
            $data = $redis->get("PHPREDIS_SESSION:" . $_COOKIE['PHPSESSID'] );

            $tmp = explode(";",$data);


            foreach($tmp as $k=>$v) {
                $ex[$k] = explode("|s:",$v);
                if(!empty($ex[$k][1]) ) {
                    $tmpEx = explode(":",$ex[$k][1]);
                    if (empty($tmpEx[2]) ) {
                        $tmpEx[2] = "";
                        $tmpStr = "";
                    }else {
                        $tmpStr = ":";
                    }
                    $arrEx[$ex[$k][0]] = $tmpEx[1] . $tmpStr . $tmpEx[2];
                }
                
            }
            if (!empty($arrEx['p2p_log_uid']) ) {
                $tmpCheckLog = preg_replace('@"@', "", $arrEx['p2p_log_uid']); //유저아이디
            }

            if (!empty($arrEx['p2p_log_id']) ) {
                $tmpCheckLogId = preg_replace('@"@', "", $arrEx['p2p_log_id']); //유저아이디
            }
            
            if( !empty($tmpCheckLogId) ) {
                $arrEx['p2p_log_id'] = $tmpCheckLogId;
            }
            
            if( empty($tmpCheckLog) ) {
                return false;
            }else {
                $arrEx['p2p_log_uid'] = $tmpCheckLog;
                return $arrEx;
            }
        }
        
    }

    public function hitSession($seg,$getDate,$req)
    {
        if (empty($_COOKIE['content'][$seg]) ) {
            setcookie("content[" . $seg ."]", $req->ip(),strtotime($getDate . ' 24:00:00') );
            return false;
        }
        return true;
    }
    
    public function index()
    {
 
    }







}
