<?php

namespace App\Http\Controllers;
use App\Order;
use App\Order_Rest_Food;
use DB;

use Illuminate\Http\Request;

class userProfile_controller extends Controller
{
    public function restaurants()//It will return all the restaurants with their id, name, start and ending time
    {
        $rest = DB::table('restaurants')->select()->get();

        $rest1 = json_decode(json_encode($rest), True);
        return response()->json($rest1);
    }

    public function foodByRestaurant(Request $r)//get the food items of the restaurant whose name is given through the request
    {
        $nm = strtoupper($r->input('name'));

        $rid = DB::table('restaurants')->where(DB::raw('upper(name)'), '=', $nm)->get();
        $rid1 = json_decode(json_encode($rid), True);

        $foodItems = DB::table('restaurant__food_items')
            ->join('food_items', 'restaurant__food_items.foodItem_id', '=', 'food_items.id')
            ->select('food_items.id','food_items.name', 'food_items.type', 'restaurant__food_items.description', 'restaurant__food_items.unit_price')
            ->where('restaurant_id','=',$rid1[0]['id'])
            ->get();

            $f1 = json_decode(json_encode($foodItems), True);
        return response()->json($f1);
    }

    public function storeOrder(Request $r)
    {
        $odr = new Order();
        $odr->user_id = $r->input('uid');
        $odr->restaurant_id = $r->input('rid');
        $odr->user_lati = $r->input('ulati');
        $odr->user_longi = $r->input('ulongi');
        $odr->restaurant_lati = $r->input('reslati');
        $odr->restaurant_longi = $r->input('reslongi');
        $odr->order_status = "Looking for rider";
        $odr->rider_status = 0;

        $odr->save();
        $odrid = DB::table('orders')->select('id')->where('user_id','=', $r->input('uid'))->where('restaurant_id','=',$r->input('rid'))->max('id');

        
        $num = $r->input('numbers');

        for ($x = 0; $x < $num; $x++)
        {
            $arr = array();
            $str = $r->input($x); 
   
            // declaring delimiters 
            $del = "_"; 
            $token = strtok($str, $del); 
            
            while ($token !== false) 
            { 
                $arr[] = $token;
                $token = strtok($del); 
            }  

            $rid = $r->input('rid');
            $fid = $arr[0];
            $rfid = DB::table('restaurant__food_items')->select('id')->where('restaurant_id', $rid)->where('foodItem_id',$fid)->get();
            $rfid1 = json_decode(json_encode($rfid), True);
            $oitem = new Order_Rest_Food();
            $oitem->order_id = $odrid;
            $oitem->restaurantfood_id = $rfid1[0]['id'];
            $oitem->amount = $arr[1];

            $oitem->save();
        } 

        return response()->json("Order Added Successfully");
    }
}
