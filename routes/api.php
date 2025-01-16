<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FavouriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/LoginWithSocial' , [AuthController::class , 'authUserViaProvider']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});



Route::group(['middleware' => ['auth:api']], function () {

//Profile Page APIs
    Route::get('/profile', [\App\Http\Controllers\API\ProfileController::class, 'index']);
    Route::post('/edite-profile' , [\App\Http\Controllers\API\ProfileController::class , 'profileupdate']);

    Route::post('/update-shipping' , [\App\Http\Controllers\API\ProfileController::class , 'shippingupdate']);
    Route::post('/update-billing' , [\App\Http\Controllers\API\ProfileController::class , 'billingupdate']);

//Get Categories API
    Route::post('/getCategories', [\App\Http\Controllers\API\CategoryController::class, 'getCategories']);

//Get Coupons API
    Route::get('/getCoupons', [\App\Http\Controllers\API\CouponController::class, 'getCoupons']);

//Check Coupon API
    Route::post('/check-coupon' , [\App\Http\Controllers\API\CouponController::class , 'coupon']);

//Get Offers API
    Route::post('/getOffers', [\App\Http\Controllers\API\OfferContoller::class, 'getOffers']);

//Get Favourite API
    Route::get('/getFavourites' , [FavouriteController::class , 'getFavourites']);

//Check Favourite API
    Route::post('/products/favourites', [FavouriteController::class, 'checkFavourite']);


//Add To Cart API
    Route::post('/addToCart' , [\App\Http\Controllers\API\CartController::class , 'addToCart']);
//Remove From Cart API
    Route::post('/removeFromCart' , [\App\Http\Controllers\API\CartController::class , 'removeFromCart']);
//Get Cart Api
    Route::get('/getCart' ,  [\App\Http\Controllers\API\CartController::class , 'getCart']);


//Products Page API
    Route::post('/items-mobile', [\App\Http\Controllers\API\ProductController::class, 'items']);

//Product Details Page API
    Route::get('/ProductDetails/{id}', [\App\Http\Controllers\API\ProductController::class, 'show']);

//Offer Details Page API
    Route::get('/offerDetails/{id}', [\App\Http\Controllers\API\OfferContoller::class, 'offer_details']);

//Get Orders API
    Route::get('/my-orders' , [\App\Http\Controllers\API\OrderController::class, 'MyOrders']);

//Get Shipping API
    Route::post('/shipping-charge' , [\App\Http\Controllers\API\OrderController::class , 'GetshippingCharge']);

//Place Order
    Route::post('place-order' , [\App\Http\Controllers\API\OrderController::class , 'store']);

//un active account
    Route::get('/unactive-account' , [AuthController::class , 'unactive']);
});
