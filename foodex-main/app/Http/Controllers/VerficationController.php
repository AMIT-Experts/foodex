<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\users;
use App\Models\verfication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;


class VerficationController extends Controller
{
   public function generate(Request $request){
    $request->validate([
        'mobile'=>'required|exists:users,mobile'
    ]);
    $user=users::where('mobile',$request->mobile)->first();
    $verfication= verfication::where('user_id',$user->id)->latest()->first();
    $now= Carbon::now();
    if($verfication&&$now->isBefore($verfication->expire_at)){
       return response()->json(['status'=>'false','massage'=>'the otp is already genrated']);
    }
$otpver=new verfication;
$otpver->user_id=$user->id;
$otpver->otp=rand(123456,999999);
$otpver->expire_at=Carbon::now()->addMinutes(15);
$otpver->save;
return response()->json(['status'=>'sucsess','massage'=>'the otp is generate and will be send to your email']);


   }
   public function generateotp($mobile){
    $user=users::where('mobile',$mobile)->first();
    $verfication= verfication::where('user_id',$user->id)->latest()->first();
    $now= Carbon::now();
    if($verfication&&$now->isBefore($verfication->expire_at)){

    }
$otpver=new verfication;
$otpver->user_id=$user->id;
$otpver->otp=rand(123456,999999);
$otpver->expire_at=Carbon::now()->addMinutes(15);
$otpver->save();

   }

}

