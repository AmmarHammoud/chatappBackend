<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\StoryController;

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


Route::middleware('auth:sanctum')->group(function () {
    //for chat
    Route::post('conversation', [ChatController::class, 'createConversation']);
    Route::post('message', [chatController::class, 'sendMessageWithMedia']);
    Route::post('messages/update-status', [chatController::class, 'updateMessageStatus']);
    Route::post('deletemessage/{messageId}', [ChatController::class, 'deleteMessage']);
    Route::get('user/conversations', [ChatController::class, 'getUserConversations']);

    //for story
    Route::post('addstory', [StoryController::class, 'create']);
    Route::get('stories', [StoryController::class, 'getActiveStories']);
    Route::post('delete/{storyid}', [StoryController::class, 'delete']);

    Route::post('profile/image', [AuthController::class, 'updateProfileImage']);



});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify', [AuthController::class, 'verifyCodeOnly']);
Route::post('user/forgetpass',[AuthController::class,'userforgetpassword']);
Route::post('user/checkpass',[AuthController::class,'usercheckpassword']);
Route::post('user/reset',[AuthController::class,'userResetpassword']);
