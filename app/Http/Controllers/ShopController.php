<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ShopController extends Controller
{
    /**
     * Construct
     * @param null
     */
    public function __construct()
    {

    }
    /**
     * Index => Shop
     * @return view;
     */
    public function index()
    {  
        // $users = DB::table('com_user')->select('*')->get();
        // return $users;
        return view('shop.index', compact('users'));
    }

    public function list() 
    {
        $routeName = Route::current()->getName();

        if ($routeName == 'about') {
            return view('shop.list');
        } else if ($routeName == 'best') {
            return view('shop.list');
        } else {
            return view('shop.list');
        }
    }

    public function shop_detail_list($id)
    {
        return view('shop.detail');
    }
   
    public function shop_event_list() 
    {
        return view('shop.event.list');
    }

    public function shop_event_item_list($id) 
    {
        return view('shop.event.item.list');
    }

    // public function test() {

    //     $result = DB::table('om_ohwe.int_promotion_product')->select('*')->get();
    //     $length = count($result);
        
    //     for($k = 0; $k < $length; $k++) {
    //         /**
    //          * 상품이미지
    //          */
    //         $image_list 		= $img_path."/list/".$result[$k]['image_list'];
    //         $image_detail 		= $img_path."/detail/".$result[$k]['image_detail'];

    //         // 이미지 체크
    //         $image_list 		= returnPrdImg($image_list, "" , $noimg="");
    //         $image_detail 		= returnPrdImg($image_detail, "" , $noimg="");

    //         // $result 배열에 이미지 등록
    //         $result[$k]['image_list'] = $image_list;
    //         $result[$k]['image_detail'] = $image_detail;

    //         //쿠폰여부
    //         if($result[$k]['coupon_uid'] > 0 && $result[$k]['coupon_stime'] <= $nowTime && $result[$k]['coupon_etime'] >= $nowTime)
    //             $result[$k]['is_coupon'] = "1";
    //         else
    //             $result[$k]['is_coupon'] = "";

    //         $result[$k]['is_delv_icon'] = "";

    //         /**** 배송조건 ****/
    //         if($result[$k]['delivery_type'] == "1")	//무료배송
    //             $result[$k]['is_delv_icon'] = "3";
    //         else if($result[$k]['delivery_type'] == "3" && $result[$k]['delivery_free_use'] == "0")	//조건부무료
    //             $result[$k]['is_delv_icon'] = "4";
    //     }


    //     // return view('shop.list', $result);
        
    // }
    

    
 

}