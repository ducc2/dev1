<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RewardController extends Controller
{
    private $db;
    private $sec;
    private $user;
    private $viewMsg;
    public function __construct( SessionController $sec)
    {
        $this->sec = $sec;
        $this->db = DB::connection('aws'); 
        $this->viewMsg = $this->msgBox("kr");
        date_default_timezone_set('Asia/Seoul');

		/* 유효성검사 */
        if(!$this->checkSec()) {
            return response()->json(  $this->msgJson("로그인 하세요",false) );
            exit;
        }
        
    }

	private function msgJson($msg,$err) {
        return array("err"=> $err ,"result"=> $msg );
    }

	private function msgBox($language)
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

	private function checkSec()
    {
        $check = $this->sec->sessionChk();

        if ($check ) {
            $this->user = $check;
            $this->userId = preg_replace('@"@', "", $check['login_chk_uid']); //유저아이디
            return true;
        }else {
            return false;
        }
    }

	public function rewardcent($tbl) {

			switch ($tbl) {
				case 'channel_contents_video':

					return "200";
				case 'channel_contents':

					return "30";

				case 'pet_comment_add_video':
					return "14";

				case 'pet_comment_add':
					return "7";

				case 'pet_like_video':
					return "6";

				case 'pet_like':
					return "3";

				case 'pet_share_video':
					return "20";
				case 'pet_share':
					return "10";
				
				case 'pet_comment_reply_video':
					return "14";
				case 'pet_comment_reply':
					return "7";

				case 'pet_follower':
					return "20";

				default:

				return "0";
			}

	}


	
	public function reward_daycent($tbl) {

			switch ($tbl) {
				case 'channel_contents_video':			//영상up

					return "2000";
				case 'channel_contents':

					return "1500";

				case 'pet_comment_add_video':			//댓글
					return "2800";

				case 'pet_comment_add':
					return "1400";

				case 'pet_like_video':					//좋아요
					return "1200";

				case 'pet_like':			
					return "600";

				case 'pet_share_video':					//구독
					return "4000";
				case 'pet_share':
					return "2000";
				
				case 'pet_comment_reply_video':			//대댓글
					return "2800";
				case 'pet_comment_reply':
					return "1400";

				case 'pet_follower':						//구독신청
					return "4000";

				default:

				return "0";
			}

	}
	

	public function levelup()
    {
		$user_id = $this->userId; //유저 번호
		$mypoint_commentsum = $this->db->table('sys_reward_history')->where('user_id',$user_id)
									->where("his_type","like" ,"pet_comment%")
									->sum('rhis_point');
		$mypoint_likesum = $this->db->table('sys_reward_history')->where('user_id',$user_id)
									->where("his_type","like" ,"pet_like%")
									->sum('rhis_point');
		$mypoint_sharesum = $this->db->table('sys_reward_history')->where('user_id',$user_id)
									->where("his_type","like" ,"pet_share%")
									->sum('rhis_point');
		$mypoint_followersum = $this->db->table('sys_reward_history')->where('user_id',$user_id)
									->where("his_type","like" ,"pet_follower%")
									->sum('rhis_point');

		$total_mypoint = $mypoint_commentsum+$mypoint_likesum+$mypoint_sharesum+$mypoint_followersum;
		
		if ($total_mypoint>=0 && $total_mypoint<340) {
			$levelup_num = 0;
		} else if ($total_mypoint>=340 && $total_mypoint<680) {
			$levelup_num = 1;			
		} else if ($total_mypoint>=680 && $total_mypoint<1360) {
			$levelup_num = 2;
		} else if ($total_mypoint>=1360 && $total_mypoint<2720) {
			$levelup_num = 3;
		} else if ($total_mypoint>=2720 && $total_mypoint<5440) {
			$levelup_num = 4;
		} else if ($total_mypoint>=5440 && $total_mypoint<10880) {
			$levelup_num = 5;
		} else if ($total_mypoint>=10880 && $total_mypoint<21760) {
			$levelup_num = 6;
		} else if ($total_mypoint>=21760 && $total_mypoint<43520) {
			$levelup_num = 7;
		} else if ($total_mypoint>=43520 && $total_mypoint<87040) {
			$levelup_num = 8;
		} else if ($total_mypoint>=87040 && $total_mypoint<174080) {
			$levelup_num = 9;
		} else if ($total_mypoint>=174080) {
			$levelup_num = 10;
		}
		

		$updateData = array(
            "m_level" => $levelup_num
        );

        $result = $this->db->table("om_test_ohwe.op_member_add")
            ->where('user_id', $user_id)
            ->update($updateData);

	}


	public function gradeup()
    {



	}

	public function reward_content_Prc($tbl,$his_home,$his_flag)
    {
		$user_id = $this->userId; //유저 번호
		$created_date = Carbon::now()->toDateTimeString(); 

		//레벨업
		$this->levelup();

		//grade업
		$this->gradeup();


		//1일 보상 CENT
		$his_day_point = $this->reward_daycent($tbl);

		//1회 보상 CENT
		$his_point = $this->rewardcent($tbl);

		$mypoint = $this->db->table('sys_reward_history')->where('user_id',$user_id)
						->where("his_type",$tbl)
						->where('created_date', '>=', Carbon::today()->toDateString())
						->sum('rhis_point');

		//1일 보상 >= 현재 cent
		if ($his_day_point >= $mypoint) {


			$awsDb = DB::connection('aws');
			$awsDb->beginTransaction();

			try {

				$data = array(
					"his_type" => $tbl,
					"his_user" => $user_id,
					"his_home" => $his_home,
					"his_point" => $his_point,
					"created_dates" => $created_date,
					"his_flag" => $his_flag
				);
				$this->add("pet_history",$data);
				
				$result = $this->db->table('sys_reward_history')
								->where("his_type",$tbl)
								->where("content_id",$his_home)
								->where('user_id',$user_id)
								->orderBy('rhis_idx', 'desc')
								->offset(0)
								->limit(1)
								->first();
				if (empty($result)) {
					
					$data_ward = array(
							"user_id" => $user_id,
							"content_id" => $his_home,
							"his_type" => $tbl,
							"rhis_point" => $his_point,
							"created_date" => $created_date
						);
					
						$awsDb->table("sys_reward_history")->insert($data_ward);
						$awsDb->table('om_test_ohwe.op_member_add')->where('user_id',$user_id)->update([
									'm_cent'=> DB::raw('m_cent+'.(int)$his_point)
						]);
						$awsDb->commit();

						return $his_point;
					
				} else {
					return "0";
				}

			} catch ( Exception $e ){
					
					$awsDb->rollBack();
					return "0";
					throw new \Exception('Some new exception');
					
				}
		}
    }
    
    
    public function reward_Prc($tbl,$his_home,$his_flag=1)
    {
		$user_id = $this->userId; //유저 번호
		$created_date = Carbon::now()->toDateTimeString(); 
		
		//레벨업
		$this->levelup();

		//grade업
		$this->gradeup();

		//1일 보상 CENT
		$his_day_point = $this->reward_daycent($tbl);
		
		//1회 보상 CENT
		$his_point = $this->rewardcent($tbl);
					
		$mypoint = $this->db->table('sys_reward_history')->where('user_id',$user_id)
						->where("his_type",$tbl)
						->where('created_date', '>=', Carbon::today()->toDateString())
						->sum('rhis_point');

	
		//1일 보상 >= 현재 cent
		if ($his_day_point >= $mypoint) {

			$data = array(
				"his_type" => $tbl,
				"his_user" => $user_id,
				"his_home" => $his_home,
				"his_point" => $his_point,
				"created_dates" => $created_date,
				"his_flag" => $his_flag
			);
			$this->add("pet_history",$data);
			
			//1회 보상처리
			if ($his_flag==1)	{			
				
				if ($tbl =='pet_follower') { 
					//보상처리
					$awsDb = DB::connection('aws');
					$awsDb->beginTransaction();

					try {
						//같은 컨텐츠 중복보상방지 
						$result = $this->db->table('sys_reward_history')
									->where("his_type",$tbl)
									->where("channel_id",$his_home)
									->where('user_id',$user_id)
									->orderBy('rhis_idx', 'desc')
									->offset(0)
									->limit(1)
									->first();

						if (empty($result)) {
							
							$data_ward = array(
								"user_id" => $user_id,
								"channel_id" => $his_home,
								"his_type" => $tbl,
								"rhis_point" => $his_point,
								"created_date" => $created_date
							);



							$awsDb->table("sys_reward_history")->insert($data_ward);
							$awsDb->table('om_test_ohwe.op_member_add')->where('user_id',$user_id)->update([
										'm_cent'=> DB::raw('m_cent+'.(int)$his_point)
							]);
							$awsDb->commit();

							return $his_point;
						}

					} catch ( Exception $e ){
						
						$awsDb->rollBack();
						return "0";
						throw new \Exception('Some new exception');
						
					}


				} else {
					
				//보상처리
				$awsDb = DB::connection('aws');
				$awsDb->beginTransaction();

				try {

					//같은 컨텐츠 중복보상방지 
					$result = $this->db->table('sys_reward_history')
								->where("his_type",$tbl)
								->where("content_id",$his_home)
								->where('user_id',$user_id)
								->orderBy('rhis_idx', 'desc')
								->offset(0)
								->limit(1)
								->first();

					if (empty($result)) {
						
						$data_ward = array(
							"user_id" => $user_id,
							"content_id" => $his_home,
							"his_type" => $tbl,
							"rhis_point" => $his_point,
							"created_date" => $created_date
						);

							$awsDb->table("sys_reward_history")->insert($data_ward);
							$awsDb->table('om_test_ohwe.op_member_add')->where('user_id',$user_id)->update([
										'm_cent'=> DB::raw('m_cent+'.(int)$his_point)
							]);
							$awsDb->commit();

							return $his_point;

					} 
				} catch ( Exception $e ){
						
						$awsDb->ollBack();
						return "0";
						throw new \Exception('Some new exception');
						
				}

				}
				

			} else {

				return "0";

			}
			
			
		}

    } 
    

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

    private function modify($tbl,$data,$where)
    {
        $result = $this->db->table($tbl)->where($where[0],$where[1])->update($data); //댓글 등록
        
        if ($result || $result > 0 ) {
            return true;    
        }else {
            return false;
        }
    }
    private function first($tbl,$where)
    {
        $result = $this->db->table($tbl)->where($where[0],$where[1])->first();

        if( empty($result) ){
            return false;
        }
        return $result;
        
    }




}
