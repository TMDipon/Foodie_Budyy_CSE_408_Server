<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use DB;

class Restaurant_controller extends Controller
{
    public function createRestaurant(Request $r)
    {
        $name = strtoupper($r->input('name'));
        $res = array();
        if(DB::table('restaurants')->where(DB::raw('upper(name)'), '=', $name)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Name of the restaurant already exists';
        }
        else if(strtotime($r->input('closes_at')) < strtotime($r->input('starts_at')))
        {
            $res['estat'] = true;
            $res['info'] = 'Invalid start and end time combination';
        }
        else if(DB::table('restaurants')->where('phone', '=', $r->input('phone'))->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Phone number exists already';
        }
        else
        {
            $rest = new Restaurant();
            $stt1 = trim($r->input('starts_at'), ":");
            $ent1 = trim($r->input('closes_at'), ":");

            $rest->name = $r->input('name');
            $rest->type = $r->input('type');
            $rest->owner_id = $r->input('owner_id');
            $rest->starts_at = $stt1;
            $rest->closes_at = $ent1;
            $rest->district = $r->input('district');
            $rest->area = $r->input('area');
            $rest->Road_name = $r->input('Road_name');
            $rest->Road_no = $r->input('Road_no');
            $rest->House_name = $r->input('House_name');
            $rest->House_no = $r->input('House_no');
            $rest->Level = $r->input('Level');
            $rest->phone = $r->input('phone');

            $rest->save();
            $rid = DB::table('restaurants')->select('id','type')->where('name',$r->input('name'))->get();

            $res['estat'] = false;
            $res['info'] = 'Restaurant successfully created';
            $rid1 = json_decode(json_encode($rid), True);
            $res['record'] = $rid1; 
        }

        return response()->json($res);
    }
}
