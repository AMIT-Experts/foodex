<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Validator;
use App\Mail\MailOtp;
use App\Models\users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;





class AuthController extends Controller
{


   public function requestOtp(Request $request)
   {
          $otp = rand(1000,9999);
          //Log::info("otp = ".$otp);
          $user = users::where('email','=',$request->email)->update(['otp' => $otp]);
  
          if($user){
  
         /* $mail_details = [
              'subject' => 'Testing Application OTP',
              'body' => 'Your OTP is : '. $otp
          ];*/
         
           //Mail::to($request->email)->send(new MailOtp($mail_details));
         
           return response(["status" => 200, "message" => "OTP sent successfully"]);
          }
          else{
              return response(["status" => 401, 'message' => 'Invalid']);
          }
      }

      public function verifyOtp(Request $request){
    
         $user  = Users::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
         if($user){
             auth()->login($user, true);
             Users::where('email','=',$request->email)->update(['otp' => null]);
             
 
             return response(["status" => 200, "message" => "Success", 'user' => auth()->user()]);
         }
         else{
             return response(["status" => 401, 'message' => 'Invalid']);
         }
     }

}
