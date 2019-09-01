<?php

namespace App\Http\Controllers;
use App\Order;
use App\Order_Rest_Food;
use DB;

use Illuminate\Http\Request;

class Order_controller extends Controller
{
    public function searchOrders(Request $r)
    {
        $res = array();

        $area = strtoupper($r->input('area'));
        $order= null;
        if(DB::table('orders')
        ->Join('restaurants', 'orders.restaurant_id', '=', 'restaurants.id')
        ->where(DB::raw('upper(restaurants.area)'),'=',$area)
        ->where('rider_status',0)
        ->exists())
        {
            $order = DB::table('orders')
                ->Join('restaurants', 'orders.restaurant_id', '=', 'restaurants.id')
                ->select('orders.id','orders.user_id','orders.restaurant_id','orders.user_lati','orders.user_longi','orders.restaurant_lati','orders.restaurant_longi','restaurants.name','restaurants.House_no','restaurants.House_name','restaurants.Road_no','restaurants.Road_name','restaurants.area','restaurants.district','restaurants.Level','restaurants.phone')
                ->where(DB::raw('upper(restaurants.area)'),'=',$area)
                ->where('rider_status',0)
                ->first();

            $order1 = json_decode(json_encode($order), True);

            $usr = DB::table('users')->select('name','phone')->where('id','=',$order1['user_id'])->first();

            $oitems = DB::table('order__rest__foods')
                ->Join('restaurant__food_items','order__rest__foods.restaurantfood_id','=','restaurant__food_items.id')
                ->Join('food_items','restaurant__food_items.foodItem_id','=','food_items.id')
                ->select('food_items.name','order__rest__foods.amount','restaurant__food_items.unit_price')
                ->where('order__rest__foods.order_id','=',$order1['id'])->get();

            DB::table('orders')->where('id', '=',$order1['id'])->update(['rider_status' => 1]);
            
            $res['ostat'] = true;
            $res['odesc'] = $order;
            $res['udesc'] = $usr;
            $res['idesc'] = $oitems;
        }
        else
        {
            $res['ostat'] = false;
        }
        
        return response()->json($res);
    }

    public function acceptOrder(Request $r)
    {
        $rider_id = $r->input('rid');
        $order_id = $r->input('oid');

        DB::table('orders')->where('id', '=',$order_id)->update(['rider_status' => 2,'order_status' => "Accepted by Rider",'rider_id' => $rider_id]);
        $res = array();

        $res['info'] = "Acepted successfully"; 
        return response()->json($res);
    }

    public function rejectOrder(Request $r)
    {
        $order_id = $r->input('oid');

        DB::table('orders')->where('id', '=',$order_id)->update(['rider_status' => 0]);
        $res = array();

        $res['info'] = "Order Rejected"; 
        return response()->json($res);
    }

    public function updateOrderStatus(Request $r)
    {
        $order_id = $r->input('oid');
        $order_stat = $r->input('order_stat');

        DB::table('orders')->where('id', '=',$order_id)->update(['order_status' => $order_stat]);
        $res = array();

        $res['info'] = "Order Status Updated"; 
        return response()->json($res);
    }
}
