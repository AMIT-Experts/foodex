<?php

namespace App\Http\Controllers;

use tidy;
use App\Mail\MailOtp;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmailVerficationNotification;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function user($id)
    {
        $user=Users::where('id',$id)->first();
       return  response(['data'=> $user,'status'=>true],200);
    }

    public function login(Request $request){
        //validate fields
        try{
        $validate=Validator::make($request->all(),[
         'email'=>'required|email',
         'password'=>'required|min:8'
        ]);

        if($validate->fails()){
            return response()->jason(['status'=>false,
        'error'=>$validate->errors()
        ]);
           }


        $user=Users::where('email',$request->email)->first();
    if(!$user){
        return response(['massage'=>'invalid email','status'=>false,],200);

    }
        //if(!$user || Auth::attempt($validate))
        if(!Auth::attempt($request->only(['email','password']))){
           return response(['massage'=>' in valid password','status'=>false,],200);
        }



    $token=$user->createToken('API TOKEN')->plainTextToken;

      return response([
        'user'=>$user,
        'token'=>$token,
        'status'=>true

      ],200);

    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),


      ],401);       }
    }
    public function logout(Request $request){
        //validate fields

      try{  $this->guard()->logout();

        $request->session()->invalidate();
      // Auth::logout();


      return response([
         'massage'=>'loged out',
         'status'=>true,

      ],200);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),


      ],401);       }
    }

    public function register(Request $request)
    {try{// massages
        $validate=Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8'

           ]);


           if($validate->fails()){
            return response()->jason(['status'=>'false',
        'error'=>$validate->errors()
        ]);
           }

           $user=new users;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->mobile=$request->mobile;
        $user->password=hash::make($request['password']);
        $user->otp=rand(1234,9999);
if(isset($request['avatar'])){
    $filename=time().'.'.$request->avatar->getClientOriginalName();
    $request->avatar->move(public_path('users'),$filename);
    $path="public/users/$filename";
    $user->avatar=$path;
}
$user->save();


         return response([
            'status'=>true,
            'data'=>$user,
            'token'=>$user->createToken('API TOKEN')->plainTextToken
         ]);
        }catch(\Exception $e){return response([
            'status'=>false,
            'massege'=>$validate->errors(),


          ],401);       }
    }

    /**
     * Display the specified resource.
     */
    public function show($email)
    {
        $user=Users::where('email',$email)->first();
        return response()->json(['status'=>true,'data'=>$user->otp]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
       try{ $user=users::where('id',$id)->first();
        if(isset($request['avatar'])){
            $filename=time().'.'.$request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('users'),$filename);
            $path="public/users/$filename";
            $user->avatar=$path;
        }
        if(isset($request['name'])){
            $user->name=$request->name;
        }
        if(isset($request['mobile'])){
            $user->mobile=$request->mobile;
        }if(isset($request['password'])){
            $user->password=hash::make($request['password']);
        }
        $user->update();

        return response()->json(['status'=>true, 'data'=>$user]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>'something is not true',


      ],500);       }
    }

    /**
     * Remove the specified resource from storage.
     */






}
