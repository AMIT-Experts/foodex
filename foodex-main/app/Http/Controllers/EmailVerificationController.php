<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;

use App\Http\Requests\EmailVerificationRequest;
use Ichtrojan\Otp\Models\Otp;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Validator;


class EmailVerificationController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp=new Otp;
    }
    public function email_verfication(EmailVerificationRequest $request){
      $otp2= $this->otp->validate($request->email,$request->otp);
      if(!$otp2->status){
        return response()->json(['error'=> $otp2],401);
      }
      $user=users::where('email',$request->email)->first();
      $user->update(['email_verified_at'=>now()]);
      return response()->json(['status'=> 'sucsess'],200);


    }
    public function send_email_verfication(Request $request){
        
        $request->user()->notify(new SendEmailVerificationNotification());
        return response()->json(['status'=> 'sucsess'],200);
  
  
      }
}
