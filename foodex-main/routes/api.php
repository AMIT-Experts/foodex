<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\OrderdController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Auth;


// Route::post('auth/email_verification',[EmailVerificationController::class, 'email_verfication']);
   // Route::get('auth/email_verification',[EmailVerificationController::class, 'send_email_verfication']);
    //Route::get('request_otp', [AuthController::class,'requestOtp']);
    //Route::post('verify_otp', [AuthController::class,'verifyOtp']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/* middleware */
Route::group(['middleware'=>['auth:sanctum']],function(){



    //user
    /* auth */
    Route::get('auth/profile/{id}',[UsersController::class, 'user']);
    Route::get('auth/logout',[UsersController::class, 'logout']);
    Route::get('auth/otp/{email}', [UsersController::class,'show']);
    Route::post('auth/user/update/{id}',[UsersController::class, 'update']);
/* auth */






/* category */
Route::post('category/creae',[CategoryController::class, 'create']);
Route::get('category',[CategoryController::class, 'showall']);
Route::get('category/{id}',[CategoryController::class, 'showone']);
Route::delete('category/{id}',[CategoryController::class, 'destroy']);

/* category */






/* restaurent */
Route::post('restaurent/create',[RestaurantController::class, 'create']);
Route::get('restaurent',[RestaurantController::class, 'showall']);
Route::get('restaurent/{id}',[RestaurantController::class, 'showone']);
Route::get('filter/restaurent/{name}',[RestaurantController::class, 'searchname']);
Route::put('restaurent/{id}',[RestaurantController::class, 'update']);
Route::get('restaurent/food/{rest_id}',[FoodController::class, 'showfood']);
Route::delete('restaurent/{id}',[RestaurantController::class, 'destroy']);
/* restaurent */


/* food */
Route::post('food/create',[FoodController::class, 'create']);
Route::put('food/{id}',[RestaurantController::class, 'update']);
Route::get('food',[FoodController::class, 'showall']);
Route::get('food/{id}',[FoodController::class, 'showone']);
Route::get('filter/food/{name}',[FoodController::class, 'searchname']);
Route::get('filter/food/restaurent/{name}',[FoodController::class, 'search_by_rest']);
Route::get('filter/food/category/{name}',[FoodController::class, 'search_by_cat']);
Route::delete('food/{id}',[FoodController::class, 'destroy']);
/* food */




/* card */
Route::post('card/create',[CardController::class, 'create']);
Route::get('card',[CardController::class, 'showall']);
Route::delete('card/{id}',[CardController::class, 'destroy']);
/* card */




/* orderd */
Route::post('order/create',[OrderdController::class, 'create']);
Route::get('order',[OrderdController::class, 'showall']);
/* orderd */


});
/* middleware */




/* auth */
Route::post('auth/register/user',[UsersController::class, 'register']);
Route::post('auth/login',[UsersController::class, 'login']);
/* auth */














