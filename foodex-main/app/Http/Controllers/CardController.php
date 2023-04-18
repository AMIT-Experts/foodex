<?php

namespace App\Http\Controllers;

use App\Models\card;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class CardController extends Controller
{



    public function create(Request $request)
    {
      try{
        /*$card=new card;
        $card->food_id=$request->food_id;
        $card->quantity=$request->quantity;

        $card->save();*/

       foreach($request as $item){
            $card=new card;
            $card->food_id=$item->food_id;
            $card->quantity=$item->quantity;

            $card->save();

          }
      return response()->json(['status'=>true]);
    }catch(\Exception $e){return response([
        'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }

    /**
     * Display the specified resource.
     */
    public function showall(card $card)
    {try{
         $card=card::orderBy('created_at', 'desc')->get();
        return response()->json(['$status'=>true, 'data'=>$card]);
    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),
      ],500);       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{$card= card::find($id) ;
        $card->delete();
        return response([
          'status'=>true ]);

    }catch(\Exception $e){return response([
      'status'=>false,
        'massege'=>$e->getMessage(),


      ],500);       }
    }
}
