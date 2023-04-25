<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
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
    public function create(Request $request)
    {try{$validate=Validator::make($request->all(),[
        'name'=>'required',

       ]);

        $category=new category;
        $category->name=$request->name;
        if(isset($request['pic'])){
            $filename=time().'.'.$request->pic->getClientOriginalName();
            $request->pic->move(public_path('categ'),$filename);
            $path="public/categ/$filename";
            $category->pic=$path;
        }
        $category->save();

        return response(['status'=>true, 'data'=>$category]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$validate->errors(),
        'errors' => $e->getMessage(),



      ],401);       }
    }


    public function showone( $id)
    {try{
        $category=category::where('id',$id)->get();
        return response()->json(['status'=>true, 'data'=>$category]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }


    public function showall(category $category)
    {try{
        $category=category::orderBy('created_at', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$category]);
}catch(\Exception $e){return response([
    'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {try{
        $category= category::find($id) ;
        $category->delete();
        return response()->json(['status'=>true, 'data'=>$category]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    }
