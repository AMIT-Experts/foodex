<?php

namespace App\Http\Controllers;

use App\Models\orderd;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class OrderdController extends Controller
{
    
    public function create(Request $request)
    {
        try{
            foreach($request as $item){
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('d');
        $time = Carbon::now()->format('H:i:s');
      
        $order=new orderd;
        $order->food_id=$request->food_id;
        $order->quantity=$request->quantity;
        $order->day=$day;
        $order->month=$month;
        $order->year=$year;
        $order->time=$time;
        $order->save();
    }
        return response([
            'status'=>true,
            
          ]);  
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Display the specified resource.
     */
   
    public function showall(orderd $orderd)
    {
        try{
        $order=orderd::orderBy('created_at', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$order]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orderd $orderd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orderd $orderd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orderd $orderd)
    {
        //
    }
}
