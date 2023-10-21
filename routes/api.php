<?php


use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Emailcontroller;
use App\Http\Controllers\StoreController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// post   ບັນທຶກ
// put   ອັບເດດແກ້ໄຂຂໍ້ມູນ
// delect  ລຶບຂໍ້ມູນ
// get  ດຶງຂໍ້ມູນ


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'setlocale'

], function ($router) {

    Route::post('login',  [AuthController::class,'login']);
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');


});

Route::group([

    'middleware' => 
[
    'auth.jwt',
    'role:super-admin|admin ',
    'setlocale'
],
    'prefix' => 'admin'

], function ($router) {
    Route::get('list-user', [UserController::class, 'getUser'])->middleware('permission:create-store|update-store,require_all');

    Route::post('add-store',[StoreController::class,'addStore'])->name('add.store');

    Route::get('list-store',[StoreController::class,'listStores'])->name('list.store');
     
    Route::put('edit-store/{id}',[StoreController::class,'editStore'])->name('edit.store');

    Route::delete('delete-store/{id}',[StoreController::class,'deleteStore'])->name('delete.store');

});

Route::post('send-email-otp',[Emailcontroller::class,'sendEmailOTP']);