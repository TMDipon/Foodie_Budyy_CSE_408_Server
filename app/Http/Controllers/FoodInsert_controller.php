<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use App\Restaurant_FoodItem;
use DB;

class FoodInsert_controller extends Controller
{
    public function insertFood(Request $r)
    {
        $res = array();//response array

        $nm = strtoupper($r->input('name'));
        $fid;
        if(DB::table('food_items')->where(DB::raw('upper(name)'), '=', $nm)->where('type','=',$r->input('type'))->exists())
        {
            $fid = DB::table('food_items')->select('id')->where(DB::raw('upper(name)'), '=', $nm)->where('type','=',$r->input('type'))->get();
        }
        else
        {
            $fitem = new FoodItem();
            $fitem->name = $r->input('name');
            $fitem->type = $r->input('type');
            $fitem->save();
            $fid = DB::table('food_items')->select('id')->where(DB::raw('upper(name)'), '=', $nm)->where('type','=',$r->input('type'))->get();    
        }

        $ar = json_decode(json_encode($fid), True);
        if(DB::table('restaurant__food_items')->where('restaurant_id', '=', $r->input('rid'))->where('foodItem_id','=',$ar[0]['id'])->exists())
        {
            $res['estat'] = true ;
            $res['info'] = 'This food item already exists';
        }
        else
        {
            $resf = new Restaurant_FoodItem();
            $resf->restaurant_id = $r->input('rid');
            $resf->foodItem_id = $ar[0]['id'];
            $resf->description = $r->input('desc');
            $resf->unit_price = $r->input('uprice');

            $resf->save();

            $res['estat'] = false;
            $res['info'] = 'Food item added';
        }

        return response()->json($res);
    }
}
