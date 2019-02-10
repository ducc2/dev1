<?php
namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RpcController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Cookie;
use Carbon\Carbon;
class AdminController extends Controller
{

    private $db;
    private $data;
    private $rpc;

    public function __construct(RpcController $rpc)
    {
        $this->rpc = $rpc;
        $this->db = DB::connection('aws');
        $this->data = array();
        date_default_timezone_set('Asia/Seoul');
    }

    public function poolStat(Request $req)
    {
        $method = $req['method'];
        $ip = $req['ip'];
        // if ($ip == "54.180.14.179") {

        // }
        $url = "http://" . $ip . ":8080/api/" . $method;

        $result = $this->getCurl($url);
        $tmpArr = json_decode($result);
        return response()->json($tmpArr);
    }
    private function getCurl($url,$postData = "")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function index(Request $req)
    {
        if(!$this->sessionChk($req) ) {
            return view('admin/signIn');
        }
        $this->petReport();
        $this->data['reportContetnCnt'] = number_format( count($this->data['contentLists']) );

        return view('admin/main',$this->data);
    }
    public function views(Request $req)
    {

        if(!$this->sessionChk($req) ) {
            return view('admin/signIn');
        }
        $viewPath = "";

        $seq = request()->segment(count(request()->segments()) );

        if ( request()->segment(2) == "pool" ) {
            switch ($seq) {
                case "dashboard":
                    $viewPath = "admin/pool/dashboard";
                    break;
            }
        }else if (request()->segment(2) == "mem") {
            switch ($seq) {
                case "lists": // 회원 리스트(최근 가입한 회원 순)
                        $this->data['memberList']= $this->db->table('om_test_ohwe.op_member')
                                    ->orderBy("uid","desc")
                                    //->paginate(50);
                                    ->get();
                        $viewPath = "admin/mem/member";
                    break;
                case "lists_search": // 회원 리스트 검색
                        $sex = $req->sex; // 성별
                        $serchObj = (object)[]; // 이름, 아이디, 전화번호, 핸드폰 옵션

                        if($req->options) $serchObj->options = $req->options;
                        if($req->content) $serchObj->content = $req->content;
                        if(!$req->options || !$req->content) $serchObj = NULL;

                        $this->data['memberList']= $this->db->table('om_test_ohwe.op_member')
                                    ->when($sex, function ($query, $sex) {
                                        return $query->where('sex', $sex);
                                    })
                                    ->when($serchObj, function ($query, $serchObj) {
                                        return $query->where($serchObj->options, 'like', "%".$serchObj->content."%");
                                    })
                                    ->orderBy("uid","desc")
                                    ->get();

                        $viewPath = "admin/mem/member";
                    break;
                case "lists_detail": // 회원 상세보기
                        $this->data["member"] = $this->db->table('om_test_ohwe.op_member')
                                    ->where("uid", $req->edit_uid)
                                    ->get();
                        $viewPath = "admin/mem/member_detail";
                    break;
                default:
                        $viewPath = "admin/main";
                    break;
            }

        }else {
            switch ($seq) {
                case "video":
                    $this->petVideo();
                    $viewPath = "admin/pet/video";
                    break;
                case 'reward':
					$this->petReward();
                    $viewPath = "admin/pet/reward";
                    break;
				case 'reward_add':
                    $viewPath = "admin/pet/reward_add";
                    break;
                case "report":
                    $this->petReport();
                    $viewPath = "admin/pet/report";
                    break;
                case "reportmenu":
                    $this->data['reportLists']= $this->db->table('sys_code_detail')
                        ->where("code_group_id","pet_report_0001")
                        ->orderBy("display_order","asc")
                        ->get();
                    $viewPath = "admin/sys/report";
                    break;
                case 'navmenu':
                    $viewPath = "admin/sys/menu";
                    break;
                default:
                    $viewPath = "admin/main";
                    break;
            }
        }
        return view($viewPath,$this->data);
    }

    public function getContent(Request $req)
    {

        $where = array("content_id",$req['content_id']);
        $content = $this->first("channel_contents",$where);
        return response()->json($content);

    }
    public function reportPrc(Request $req)
    {

        switch ($req->setType) {
            case 'contents':
                $tbl = "channel_contents";
                $where = array("content_id",$req['content_id'] );
                $use_yn = ($req->use_yn == 1)?true:false;
                $data = array(
                    "use_yn" => $use_yn,
                    "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                );
                break;
            case 'contentsFlag':
                $tbl = "channel_contents";
                $where = array("content_id",$req['content_id'] );
                $use_yn = ($req->use_yn == 1)?true:false;
                $data = array(
                    "flag" => $req->flag,
                    "use_yn" => $use_yn,
                    "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                );
                break;
            case 'comment':
                $tbl = "pet_comment";
                $where = array("comment_id",$req->comment_id );

                $data = array(
                    "flag" => $req->flag,
                    "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                );
                break;
            case 'list':

                //신고 콘텐츠&앳글
                $result = $this->db->table('pet_report')
                    ->leftJoin('sys_code_detail', 'pet_report.code_id', '=', 'sys_code_detail.code_id')
                    ->join("om_test_ohwe.op_member",'om_test_ohwe.op_member.uid','=','pet_report.user_id')
                    ->select('pet_report.*', 'sys_code_detail.code_name','om_test_ohwe.op_member.email','om_test_ohwe.op_member.name')
                    ->where('pet_id',$req->pet_id)
                    ->where('pet_report.flag',$req->flag)
                    ->orderBy('pet_report.created_date', 'asc')
                    ->get();
                if($result->isEmpty() ) {
                    $result = false;
                }
                return response()->json($result);
                break;
            case 'banContent':
                $tbl = "channel_contents";
                $where = array("content_id",$req->content_id );
                $use_yn = ($req->use_yn == 1)?true:false;
                $data = array(
                    "flag" => $req->flag,
                    "use_yn" => $use_yn,
                    "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                );
                break;
            case 'banComment':
                $tbl = "pet_comment";
                $where = array("comment_id",$req->comment_id );
                $data = array(
                    "flag" => $req->flag,
                    "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                );
                break;
            default:
                # code...
                break;
        }


        $result = $this->modify($tbl,$data,$where);

        return response()->json($result);

    }
    public function sysPrc(Request $req)
    {
        $seq = request()->segment(count(request()->segments()) );
        $sys = request()->segment(3);
        switch ($sys) {
            case 'report':
                switch ($seq) {
                    case 'add':
                        $cnt = $this->db->table('sys_code_detail')
                            ->where('code_group_id',"pet_report_0001")
                            ->count();
                        $code_id = ($cnt == 0)?"opt_1":"opt_" . ($cnt + 1);

                        $flag = ($req->flag == 1)?true:false;

                        $data = array(
                            "code_group_id" => "pet_report_0001",
                            "code_id" => $code_id,
                            "code_name" => $req->menu,
                            "display_order" => $req->display_order,
                            "use_yn" => $flag,
                            "created_date" => Carbon::now()->toDateTimeString(), //Datetime Ex) 2018-12-15 12:00:00
                        );

                        $result = $this->add("sys_code_detail",$data);

                        if( empty($result) ) {
                            $result = false;
                        }
                        break;
                    case 'modify':
                        $where = array("code_id",$req->code_id );

                        if ( !empty($req->flag || $req->flag == 0 || $req->flag == 1 ) ) {
                            $flag = ($req->flag == 1)?true:false;
                            $data = array(
                                "use_yn" => $flag,
                                "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                            );
                        }
                        if ( !empty($req->display_order) ) {
                            $data = array(
                                "display_order" => $req->display_order,
                                "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                            );
                        }
                        if ( !empty($req->code_name) ) {
                            $data = array(
                                "code_name" => $req->code_name,
                                "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
                            );
                        }
                        if (empty($data) ) {
                            return response()->json(false);
                        }
                        $result = $this->modify("sys_code_detail",$data,$where);

                        break;
                    case 'del':
                        $code_id = $req->code_id;
                        if (empty($code_id) ) {
                            return response()->json(false);
                        }
                        $where = array("code_id",$code_id);
                        $result = $this->remove("sys_code_detail",$where);
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'video':
                break;
            case 'menu':
                $menu = $req->navMenu;
                $url = $req->menuUrl;
                $class = $req->mClass;
                $flag = ($req->flag == "on")?true:false;
                $data = array(
                    "menu" => $menu,
                    "url" => $url,
                    "mClass" => $class,
                    "use_yn" => $flag,
                    "created_date" => Carbon::now()->toDateTimeString()
                );


                $result = $this->add("sys_navmenu",$data);
                if( empty($result) ) {
                    $result = false;
                }
                // CREATE TABLE `sys_navmenu` (
                //   `idx` int(11) NOT NULL AUTO_INCREMENT,
                //   `menu` varchar(100) DEFAULT NULL,
                //   `use_yn` bit(1) DEFAULT b'0',
                //   `created_dates` timestamp NULL DEFAULT NULL,
                //   `updated_dates` timestamp NULL DEFAULT NULL,
                //   PRIMARY KEY (`rew_idx`)
                // ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
                break;
            default:
                exit;
                break;
        }

        return response()->json($result);

    }


    private function petReport()
    {
        $this->data['comment'] = "";
        $comment = $this->db->table('pet_comment')->get();
        if(!$comment->isEmpty() ){
            $this->data['comment'] = $comment;
        }
        $this->data['contents'] = "";
        //$contents = $this->db->table('channel_contents')->where("flag",1)->where("use_yn",true)->get();
        $contents = $this->db->table('channel_contents')->get();
        if(!$contents->isEmpty() ){
            $this->data['contents'] = $contents;
        }
        $reportGroup = $this->db->table('sys_code_detail')
            ->where("code_group_id","pet_report_0001")
            ->where("use_yn",true)
            ->orderBy("display_order","asc")
            ->get();
        $this->data['reportTxt'] = $reportGroup;

        $reportLists = $this->db->table('pet_report')
            ->leftJoin('sys_code_detail', 'pet_report.code_id', '=', 'sys_code_detail.code_id')
            ->join("om_test_ohwe.op_member",'om_test_ohwe.op_member.uid','=','pet_report.user_id')
            ->select('pet_report.*', 'sys_code_detail.code_name','om_test_ohwe.op_member.email','om_test_ohwe.op_member.name')
            ->orderBy("pet_report.created_date","desc")
            ->get();

        foreach($reportLists as $k=>$v) {
            $contentIn[$v->pet_id] = $v->pet_id;
        }

        sort($contentIn);

        $this->data['reportLists'] = $reportLists;
        $tmpLists = $this->db->table('channel_contents')
            ->join("pet_report",'pet_report.pet_id','=','channel_contents.content_id')
            ->select('channel_contents.*','pet_report.updated_date as report_date')
            ->where("pet_report.flag",0)
            ->whereIn('content_id',$contentIn)
            ->orderBy("pet_report.updated_date","desc")
            ->get();

        foreach($tmpLists as $k => $v) {
            if ( empty($tmpArr[$v->content_id]) ) {
                $tmpArr[$v->content_id] = $v;
            }
        }

        $tmpComment = $this->db->table('pet_comment')
            ->join("pet_report",'pet_report.pet_id','=','pet_comment.comment_id')
            ->select('pet_comment.*','pet_report.updated_date as report_date')
            ->where("pet_report.flag",1)
            ->whereIn('comment_id',$contentIn)
            ->orderBy("pet_report.updated_date","desc")
            ->get();

        $this->data['contentLists'] = $tmpArr;
        $this->data['commentLists'] = $tmpComment;

        $this->data['flagArray'] = array("게시안함","게시","신고","관리자 삭제");
        $this->data['commentFlag'] = array("삭제","정상","신고","관리자 삭제");



    }
    private function petVideo()
    {
        $this->db->table('channel_contents')
            ->where("use_yn",1)
            ->where('flag',1)
            ->orderBy('content_id', 'desc')
            ->get();
        return true;
    }

	private function petReward()
    {
		//보상목록 등록한 시간 역순으로~~(최신순)
        $tmpArr = $this->db->table('sys_reward')
            ->orderBy('created_dates', 'desc')
            ->get();
		$this->data['contentLists'] = $tmpArr;

        return true;
    }

	public function reward_prc(Request $req) {

		if (!$this->sessionChk($req) ) {
            return view('admin/signIn');
        }

		//보상등록
		if ($req->mode=='add') {
			$data = array(
				"rew_title" => $req->rew_title,
				"rew_one" => $req->rew_one,
				"rew_day" => $req->rew_day,
				"rew_year" => $req->rew_day*365,
				"rew_fyear" => ($req->rew_day*365)*5,
				"created_dates" => Carbon::now()->toDateTimeString(), //Datetime Ex) 2018-12-15 12:00:00
			);

			if( empty($result) ) {
			  $result = false;
			}

			$result = $this->add("sys_reward",$data);
			return redirect('admin/pet/reward');

		//보상삭제
		}	else if ($req->mode=='del') {

			$rew_idx = $req->rew_idx;
			if (empty($rew_idx) ) {
				return response()->json(false);
			}
			$where = array("rew_idx",$rew_idx);
			$result = $this->remove("sys_reward",$where);

			return redirect('admin/pet/reward');

		//보상수정
		}	else if ($req->mode=='mod') {

			$rew_idx = $req->rew_idx;
			if (empty($rew_idx) ) {
				return response()->json(false);
			}

			$where = array("rew_idx", $rew_idx);

			$data = array(
				"rew_title" => $req->rew_title,
				"rew_one" => $req->rew_one,
				"rew_day" => $req->rew_day,
				"rew_year" => $req->rew_day*365,
				"rew_fyear" => ($req->rew_day*365)*5,
				"updated_dates" => Carbon::now()->toDateTimeString(), //Datetime Ex) 2018-12-15 12:00:00
			);

			$result = $this->modify("sys_reward",$data,$where);
			return redirect('admin/pet/reward');


		//보상수정 불러오기
		}	else  if ($req->mode=='edit') {

			$rew_idx = $req->rew_idx;
			if (empty($rew_idx) ) {
				return response()->json(false);
			}

			$where = array("rew_idx", $rew_idx);

			$tmpArr = $this->first('sys_reward',$where);
			$this->data['contentLists'] = $tmpArr;

			return view('admin/pet/reward_edit',$this->data);


		}





	}

    public function market($method=null,Request $req)
    {
        if (!$this->sessionChk($req) ) {
            return view('admin/signIn');
        }
        switch($method){
            case "product":
                break;
        }

        // category에서 "BEST", "OHWE ONLY", "WHAT'S NEW"의 code 추출
        $code = $this->db->table('om_test_ohwe.int_category')
                    ->select('code', 'name')
                    ->whereIn("name", ["BEST", "OHWE ONLY", "WHAT'S NEW"])
                    ->get();
        $this->data['categoryList']= $code;

        // code를 list 변환
        $category = [];
        foreach ($code as $k => $v) {
            array_push($category, $v->code);
        }

        // 카테고리가 "BEST", "OHWE ONLY", "WHAT'S NEW"인 상품 추출
        $this->data['productList']= $this->db->table('om_test_ohwe.int_product')
                                    ->whereIn("category", $category)
                                    ->get();

        return view('admin/market/product',$this->data);

    }
    private function sessionChk($req)
    {

        if ( $req->session()->get('user') != "cho" ) {
            return false;
        }
        $this->data['user'] = $req->session()->get('user') ;
        return true;

    }
    public function signIn(Request $req)
    {
        if ($req->input('email') == "cho") {
            if ( Hash::check($req->input('password'),'$2y$10$dLpyazIYbTKfkrKHF3.om.rn2/y8ROSCuAZvOWkB5U2zknm6cwkFi' ) ) {
                $req->session()->put('user', $req->input('email') );
            }
            return response()->json( $req->session()->get('user') );
        }
    }
    public function signOut(Request $req)
    {
        $req->session()->forget('user');
    }

	private function first($tbl,$where)
    {
        $result = $this->db->table($tbl)
            ->where($where[0],$where[1])
            ->first();

        if( empty($result) ){
            return false;
        }
        return $result;

    }
    private function add($tbl,$data)
    {
        $result = $this->db->table($tbl)->insert($data); //댓글 등록

        if ($result  ) {
            return true;
        }else {
            return false;
        }
    }
    private function modify($tbl,$data,$where)
    {
        $result = $this->db->table($tbl)
            ->where($where[0],$where[1])
            ->update($data); //댓글 등록

        if ($result || $result > 0 ) {
            return true;
        }else {
            return false;
        }
    }
    private function remove($tbl,$where)
    {
        $result = $this->db->table($tbl)
            ->where($where[0], $where[1])
            ->delete();
        if ($result || $result > 0 ) {
            return true;
        }else {
            return false;
        }
    }

    public function exchangeList(Request $req) {

		if (!$this->sessionChk($req) ) {
            return view('admin/signIn');
        }

        $this->data["exchangeList"] = $this->db->table('sys_exchange')
            ->leftJoin("om_test_ohwe.op_member","op_member.uid","sys_exchange.user_uid")
            ->select("sys_exchange.*", "op_member.*")
            ->orderBy("created_date","desc")
            ->get();

        return view('admin/cent/exchangeList',$this->data);
    }

    public function exchange(Request $req) {

        // $uid = request()->segment(4);
        // $exIdx = request()->segment(5);
        // $getCent = request()->segment(6); // 전환 신청한 cent
        $uid = $req->uid;
        $exIdx = $req->exIdx;
        $getCent = $req->cent; // 전환 신청한 cent

        $msg = "exchange실패.";
        $err = false;

        $oriCent = $this->db->table('om_test_ohwe.op_member_add')
            ->where("user_id",$uid)
            ->select("m_cent")
            ->first();

        $centExUser = $this->db->table('om_test_ohwe.op_member')
            ->where("uid",$uid)
            ->first();

        //회원정보가 없으면
        if(empty($centExUser) ) {
            return response()->json(array("msg"=>$msg ,"err"=>$err ) );
        }
     
        //print_r( $oriCent->m_cent);
   

        $exchangeCent = array(
            'm_cent' => $oriCent->m_cent - $getCent
        );

        $result1 = $this->db->table('om_test_ohwe.op_member_add')
            ->where("user_id",$uid)
            ->update($exchangeCent);


        if($result1 != 1 || $result1 == false) {
            return response()->json(array("msg" => $msg ,"err "=> $err ) );
        }

        $to = $this->rpc->getAccount($centExUser->email);

        $txid = $this->rpc->adminSendfrom("ohwe_platform1",$to,$getCent * 0.01);

        $flag = array(
            'flag' => 1,
            "txid" => $txid,
            "updated_date" => Carbon::now()->toDateTimeString() //Datetime Ex) 2018-12-15 12:00:00
        );

        $result2 = $this->db->table('sys_exchange')
            ->where("ex_idx",$exIdx)
            ->update($flag);


        if($result2 == 1) {
            $msg = "승인되었습니다.";
            $err = true;
        }

        return response()->json( array("msg" => $msg ,"err" => $err ) );
	}

}
