<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'V1' ,  'name' => 'V1' , 'as' => 'V1.' , 'middleware' => ['api' , 'CORS']  ] ,function (){
    Route::group([ 'prefix' => 'Auth' , 'name' => 'Auth' , 'as' => 'Auth.' ] ,function (){
        Route::post('CheckUsername' , [\App\Http\Controllers\AuthController::class , 'CheckUsername'])->name('CheckUsername');
        Route::post('register' , [\App\Http\Controllers\AuthController::class , 'register'])->name('register');
        Route::post('login', [\App\Http\Controllers\AuthController::class ,'login'])->name('login');
        Route::post('refresh', [\App\Http\Controllers\AuthController::class ,'refresh'])->name('refresh');
        Route::post('logout', [\App\Http\Controllers\AuthController::class ,'logout'])->name('logout');
    });
    Route::group([ 'prefix' => 'User' , 'name' => 'User' , 'as' => 'User.' , 'middleware' => 'jwt.verify' ] ,function (){
        Route::group([ 'prefix' => 'profile' , 'name' => 'profile' , 'as' => 'profile.' , 'middleware' => 'jwt.verify' ] ,function (){
            Route::get('/', [\App\Http\Controllers\UserController::class ,'profile'])->name('profile');
            Route::post('UpdateDetails', [\App\Http\Controllers\UserController::class ,'UpdateDetails'])->name('UpdateDetails');
            Route::post('UpdatePassword', [\App\Http\Controllers\UserController::class ,'UpdatePassword'])->name('UpdatePassword');
            Route::post('UpdateUserName', [\App\Http\Controllers\UserController::class ,'UpdateUserName'])->name('UpdateUserName');
            Route::post('UpdateEmail', [\App\Http\Controllers\UserController::class ,'UpdateEmail'])->name('UpdateEmail');
        });

        Route::group([ 'prefix' => 'Friends' , 'name' => 'Friends' , 'as' => 'Friends.' , 'middleware' => 'jwt.verify' ] ,function (){
            Route::post('Add', [\App\Http\Controllers\UserFriendsController::class ,'Add'])->name('Add');
            Route::post('Remove', [\App\Http\Controllers\UserFriendsController::class ,'Remove'])->name('Remove');
            Route::get('FriendsOfList', [\App\Http\Controllers\UserFriendsController::class ,'FriendsOfList'])->name('FriendsOfList');
            Route::get('FriendsList', [\App\Http\Controllers\UserFriendsController::class ,'FriendsList'])->name('FriendsList');
            Route::get('FriendsCount/{UserName}', [\App\Http\Controllers\UserFriendsController::class ,'FriendsCount'])->name('FriendsCount');
        });

        Route::get('CoinHistory', [\App\Http\Controllers\UserController::class ,'CoinHistory'])->name('CoinHistory');
        Route::post('search', [\App\Http\Controllers\UserController::class ,'search'])->name('search');
        Route::post('details', [\App\Http\Controllers\UserController::class ,'details'])->name('details');
        Route::post('details/{ID}', [\App\Http\Controllers\UserController::class ,'detailsbyid'])->name('detailsbyid');
    });
    Route::group([ 'prefix' => 'Game' , 'name' => 'Game' , 'as' => 'Game.' , 'middleware' => 'jwt.verify' ] ,function (){

        Route::group([ 'prefix' => 'Room' , 'name' => 'Room' , 'as' => 'Room.' , 'middleware' => 'jwt.verify' ] ,function (){
            Route::get('Get/{ID}', [\App\Http\Controllers\GameRoomsController::class ,'Get'])->name('Get');
            Route::post('Create', [\App\Http\Controllers\GameRoomsController::class ,'Create'])->name('Create');
            Route::post('Close', [\App\Http\Controllers\GameRoomsController::class ,'Close'])->name('Close');
        });

        Route::group([ 'prefix' => 'History' , 'name' => 'History' , 'as' => 'History.' , 'middleware' => 'jwt.verify' ] ,function (){
            Route::get('Get', [\App\Http\Controllers\GameHistoryController::class ,'Get'])->name('Get');
        });


    });

    Route::group([ 'prefix' => 'Chat' , 'name' => 'Chat' , 'as' => 'Chat.' , 'middleware' => 'jwt.verify' ] ,function (){
        Route::get('List', [\App\Http\Controllers\UserChatsController::class ,'List'])->name('List');
        Route::get('Get/{ChatID}', [\App\Http\Controllers\UserChatsController::class ,'Get'])->name('Get');
        Route::get('NewMessageCount/{ChatID}', [\App\Http\Controllers\UserChatsController::class ,'NewMessageCount'])->name('NewMessageCount');
        Route::post('Send', [\App\Http\Controllers\UserChatsController::class ,'Send'])->name('Send');
        Route::post('Read', [\App\Http\Controllers\UserChatsController::class ,'Read'])->name('Read');
    });


});
