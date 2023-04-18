<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\food;
use App\Models\restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class FoodController extends Controller
{
    
    
   

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {try{
        
       $food=new food;
       $food->name=$request->name;
       $food->description=$request->description;
       $food->price=$request->price;
       $food->restaurent_id=$request->restaurent_id;
       $food->cat_id=$request->cat_id;
       if(isset($request['pic'])){
        $filename=time().'.'.$request->pic->getClientOriginalName();
        $request->pic->move(public_path('food'),$filename);
        $path="public/food/$filename";
        $food->pic=$path;
    }
       $food->save();
      return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }

    /**
     * Display the specified resource.
     */
    public function showone($id)
    {try{
        $food=food::where('id',$id)->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }

    
    public function showall(food $food)
    {try{
        
        $food=food::orderBy('created_at', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }


    public function searchname($name)
    {try{
        $food=food::where('name','like',"%".$name."%")->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }

    public function search_by_rest($name)
    {
try{
         $rest=restaurant::where('name',$name)->get();
        $food=food::where('name',$rest->id)->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }

    public function search_by_cat($name)
    {try{
        $cat=category::where('name',$name)->get();
        $food=food::where('name',$cat->id)->get();
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
      try{
        $food=food::where('id',$id)->get();
        $food->name=$request->name;
        $food->update();
        return response()->json(['status'=>true, 'data'=>$food->name]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {try{
        $food= food::find($id) ;
        $food->delete(); 
        return response()->json(['status'=>true, 'data'=>$food]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
    
         
      ],500);       }
    }
}
