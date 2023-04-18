<?php

namespace App\Http\Controllers;

use App\Models\food;
use App\Models\restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class RestaurantController extends Controller
{





    public function create(Request $request)
    {try{

      $validate=Validator::make($request->all(),[
        'name'=>'required',
        'delivery_time'=>'required',
        'tags1'=>'required',
        'tags2'=>'required',
        'verified'=>'required',
        'lat'=>'required',
        'long'=>'required',
       ]);


        $restaurant=new restaurant;
        if(is_file($request['pic'])){
            $filename=time().'.'.$request->pic->getClientOriginalName();
            $request->pic->move(public_path('restaurent'),$filename);
            $path="public/restaurent/$filename";
            $restaurant->pic=$path;
        }
        if(isset($request['cover_photo'])){
            $filename=time().'.'.$request->cover_photo->getClientOriginalName();
            $request->cover_photo->move(public_path('c_restaurent'),$filename);
            $path="public/c_restaurent/$filename";
            $restaurant->cover_photo=$path;
        }
       $restaurant->name=$request->name;
       $restaurant->delivery_time=$request->delivery_time;
       $restaurant->tags1=$request->tags1;
       $restaurant->tags2=$request->tags2;
       $restaurant->verified=$request->verified;
       $restaurant->lat=$request->lat;
       $restaurant->long=$request->long;
       $restaurant->save();


       return response()->json(['status'=>true, 'data'=>$restaurant]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),


      ],200);       }
    }

    /**
     * Display the specified resource.
     */
    public function showall(restaurant $restaurant)
    {try{
        $restaurant=restaurant::orderBy('created_at', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$restaurant]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    public function showone($id)
    {try{
        $restaurant=restaurant::where('id',$id)->get();
        return response()->json(['status'=>true, 'data'=>$restaurant]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    public function searchname($name)
    {try{
        $rest=restaurant::where('name','like',"%".$name."%")->get();
        return response()->json(['status'=>true, 'data'=>$rest]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }



    public function showfood($rest_id)
    {try{
        $food=food::where('restaurent_id',$rest_id)->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {try{

      $validate=Validator::make($request->all(),[
        'name'=>'required',

       ]);
        $restaurant=restaurant::where('id',$id)->get();
        $restaurant->name=$request->name;
        $restaurant->update();
        return response()->json(['status'=>true, 'data'=>$restaurant]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$validate->errors(),


      ],401);       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {try{
        $restaurant= restaurant::find($id) ;
        $restaurant->delete();
        return response()->json(['status'=>true, 'data'=>$restaurant]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }
}
