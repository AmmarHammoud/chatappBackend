<?php

use App\Models\conversation;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    // تحقق إذا كان المستخدم جزءاً من هذه المحادثة
    return \App\Models\Conversation::where('id', $conversationId)
                                   ->where(function ($query) use ($user) {
                                       $query->where('user1_id', $user->id)
                                             ->orWhere('user2_id', $user->id);
                                   })->exists();
});
