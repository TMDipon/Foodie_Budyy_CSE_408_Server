<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use DB;

class Owner_controller extends Controller
{
    public function createOwner(Request $r)
    {
        $mail = $r->input('email_id');
        $res = array();
        if(DB::table('owners')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Email id of the owner already exists';
        }
        else
        {
            $onr = new Owner();

            $onr->name = $r->input('name');
            $onr->email_id = $r->input('email_id');
            $onr->password = md5($r->input('password'));
            $onr->save();

            $res['estat'] = false;
            $res['info'] = 'Successfully registered';
        }
        return response()->json($res);

    }


    public function loginOwner(Request $r)
    {
        $mail = $r->input('email_id');
        $pass = md5($r->input('password'));
        $matchFields = ['email_id' => $mail, 'password' => $pass];

        $res = array();

        if(DB::table('owners')->where($matchFields)->exists())
        {
            $ownerInfo = DB::table('owners')->select('id','name','email_id')->where($matchFields)->get();
            $onr = json_decode(json_encode($ownerInfo), True);
            $res['estat'] = false;
            $res['info'] = 'Login successful';
            $res['record'] = $onr;
        }
        else
        {
            $res['estat'] = true;
            $res['info'] = 'Login unsuccessful, try again with correct information';
        }

        return response()->json($res);
    }

    public function modifyRestaurant(Request $r)
    {
        $oid = $r->input('id');
        $rests = DB::table('restaurants')->select('id','name','type')->where('owner_id', '=', $oid)->get();
        $rests1 = json_decode(json_encode($rests),True);
        return response()->json($rests1);
        //return response()->json($r->path());
    }

    public function showfoodByRestaurant(Request $r)
    {
        $nm = $r->input('id');

        $rid = DB::table('restaurants')->where('id', '=', $nm)->get();
        $rid1 = json_decode(json_encode($rid), True);

        $foodItems = DB::table('restaurant__food_items')
            ->join('food_items', 'restaurant__food_items.foodItem_id', '=', 'food_items.id')
            ->select('food_items.id','food_items.name', 'food_items.type', 'restaurant__food_items.description', 'restaurant__food_items.unit_price')
            ->where('restaurant_id','=',$rid1[0]['id'])
            ->get();

            $f1 = json_decode(json_encode($foodItems), True);
        return response()->json($f1);
    }

    public function deleteFood(Request $r)
    {
        $res = array();

        $rid = $r->input('rid');
        $fid =$r->input('fid');
        DB::table('restaurant__food_items')->where('restaurant_id', '=', $rid)->where('foodItem_id','=', $fid)->delete();
        if(DB::table('restaurant__food_items')->where('foodItem_id', '=', $fid)->doesntExist())
        {
            DB::table('food_items')->where('id', '=', $fid)->delete();
        }

        $res['estat'] = false;
        $res['info'] = "Item deleted successfully";

        return response()->json($res);
    }

    public function changeFoodPrice(Request $r)
    {
        $rid = $r->input('rid');
        $fid = $r->input('fid'); 
        $price = $r->input('price');

        DB::table('restaurant__food_items')->where('restaurant_id', '=',$rid)->where('foodItem_id','=',$fid)->update(['unit_price' => $price]);
        $res = array();
        $res['estat'] = false;
        $res['info'] = "Price changed successfully";

        return response()->json($res);
    }
}
