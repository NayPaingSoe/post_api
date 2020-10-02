<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FeedController;
use App\Http\Controllers\api\LikeController;
use App\Http\Controllers\api\CommentController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware' => 'auth:api'], function () {
   //logout
Route::get('/logout', [AuthController::class, 'logout']);
 //feed
Route::get('/feed', [FeedController::class, 'feed']);
Route::post('/feed/create', [FeedController::class, 'create']);
Route::delete('/feed/delete', [FeedController::class, 'delete']);

    //comment
Route::post('/comment/create', [CommentController::class, 'createcomment']);
Route::get('/comment/allcomment', [CommentController::class, 'comments']);
Route::delete('/comment/delete', [CommentController::class, 'delete']);

//like
Route::post('/like', [LikeController::class, 'like']);
});
