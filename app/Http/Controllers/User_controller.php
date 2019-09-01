<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class User_controller extends Controller
{
    //
    public function createUser(Request $r)
    {
        $mail = $r->input('email_id');
        $phn = $r->input('phone');
        $res = array();
        if(DB::table('users')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Email id already exists';
        }
        elseif(DB::table('users')->where('phone', $phn)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Phone number already exists';
        }
        elseif(DB::table('users')->where('phone', $phn)->exists() and DB::table('users')->where('email_id', $mail)->exists())
        {
            $res['estat'] = true;
            $res['info'] = 'Email id and Phone number both already exist';
        }
        else
        {
            $usr = new User();

            $usr->name = $r->input('name');
            $usr->email_id = $r->input('email_id');
            $usr->phone = $r->input('phone');
            $usr->password = md5($r->input('password'));
            $usr->save();

            $res['estat'] = false;
            $res['info'] = 'Successfully registered';
        }
        return response()->json($res);

    }


    public function loginUser(Request $r)
    {
        $mail = $r->input('email_id');
        $pass = md5($r->input('password'));
        $matchFields = ['email_id' => $mail, 'password' => $pass];

        $res = array();

        if(DB::table('users')->where($matchFields)->exists())
        {
            $userInfo = DB::table('users')->select('id','name','email_id')->where($matchFields)->get();
            $usr = json_decode(json_encode($userInfo), True);
            $res['estat'] = false;
            $res['info'] = 'Login successful';
            $res['record'] = $usr;
        }
        else
        {
            $res['estat'] = true;
            $res['info'] = 'Login unsuccessful, try again with correct information';
        }

        return response()->json($res);
    }
}
