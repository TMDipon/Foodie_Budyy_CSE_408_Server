<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rider;
use DB;

class Rider_controller extends Controller
{
    public function createRider(Request $r)
    {
        $mail = $r->input('email_id');
        $phn = $r->input('phone');
        $nid = $r->input('NID');
        $res = array();
        if(DB::table('riders')->where('NID', $nid)->exists() and DB::table('riders')->where('phone', $phn)->exists() and DB::table('riders')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'NID, phone number and Email id already exists';
        }
        elseif(DB::table('riders')->where('NID', $nid)->exists() and DB::table('riders')->where('phone', $phn)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'NID and phone number already exists';
        }
        elseif(DB::table('riders')->where('NID', $nid)->exists() and DB::table('riders')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'NID and Email id already exists';
        }
        elseif(DB::table('riders')->where('email_id', $mail)->exists() and DB::table('riders')->where('phone', $phn)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Email id and phone number already exists';
        }
        elseif(DB::table('riders')->where('NID', $nid)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'NID already exists';
        }
        elseif(DB::table('riders')->where('phone', $phn)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Phone number already exists';
        }
        elseif(DB::table('riders')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Email id both already exist';
        }
        else
        {
            $rider = new Rider();

            $rider->name = $r->input('name');
            $rider->email_id = $r->input('email_id');
            $rider->phone = $r->input('phone');
            $rider->NID = $r->input('NID');
            $rider->district = $r->input('district');
            $rider->area = $r->input('area');
            $rider->password = md5($r->input('password'));
            $rider->save();

            $res['estat'] = false;
            $res['info'] = 'Successfully registered';
        }

        return response()->json($res);
    }

    public function loginRider(Request $r)
    {
        $mail = $r->input('email_id');
        $pass = md5($r->input('password'));
        $matchFields = ['email_id' => $mail, 'password' => $pass];

        $res = array();

        if(DB::table('riders')->where($matchFields)->exists())
        {
            $riderInfo = DB::table('riders')->select('id','name','email_id','district','area')->where($matchFields)->get();
            $rider = json_decode(json_encode($riderInfo), True);
            $res['estat'] = false;
            $res['info'] = 'Login successful';
            $res['record'] = $rider;
        }
        else
        {
            $res['estat'] = true;
            $res['info'] = 'Login as a rider unsuccessful, try again with correct information';
        }

        return response()->json($res);
    }
}
