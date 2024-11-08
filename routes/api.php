<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\StoryController;
use App\Http\Middleware\UpdateUserOnlineStatus;

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
    Route::post('pusher_auth', [AuthController::class, 'pusherAuth']);

    //for chat
    Route::post('conversation', [ChatController::class, 'createConversation']);
    Route::post('message', [chatController::class, 'sendMessage']);
    Route::post('messages/update-status', [chatController::class, 'updateMessageStatus']);
    Route::post('deletemessage/{messageId}', [ChatController::class, 'deleteMessage']);
    Route::get('user/conversations', [ChatController::class, 'getUserConversations']);
    Route::get('conversations/{conversationId}', [ChatController::class, 'getMessages']);

    //for reaction
    Route::post('reaction', [ReactionController::class, 'addReaction']);
    Route::post('deletereaction', [ReactionController::class, 'removeReaction']);
    Route::get('reactions', [ReactionController::class, 'getReactions']);
    //for group

    //for story
    Route::post('addstory', [StoryController::class, 'create']);
    Route::get('stories', [StoryController::class, 'getActiveStories']);
    Route::post('delete/{storyid}', [StoryController::class, 'delete']);

    Route::post('profile/image', [AuthController::class, 'updateProfileImage']);
//for status
    Route::middleware(['auth:sanctum', UpdateUserOnlineStatus::class])->group(function () {
        Route::get('user/status', [chatController::class, 'checkAndUpdateStatus']);

     
    });
//2|qhejh3roeLaJEF8RVl6TNgpuPXOWAfOrQEhEhpJo56de2233

//1|7tkdaYuawEqY2KH5VTchKmnPBZiU4YSBXMNbnGni1f0c174d
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify', [AuthController::class, 'verifyCodeOnly']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('user/forgetpass',[AuthController::class,'userforgetpassword']);
Route::post('user/checkpass',[AuthController::class,'usercheckpassword']);
Route::post('user/reset',[AuthController::class,'userResetpassword']);
