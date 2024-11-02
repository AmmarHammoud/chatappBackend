<?php

namespace App\Services;

use App\Events\PrivateMessage;
use App\Events\PublicMessage;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function sendMessage($validatedData)
    {
        $message = new Message();
        $message->conversation_id = $validatedData['conversation_id'];
        $message->user_id = Auth::id();
        $message->message = $validatedData['message'] ?? null;
       // $message->type = $validatedData['type'];

        if (isset($validatedData['media'])) {
            $destinationPath = 'chat/media/';
            $media = $validatedData['media'];
            $fileName = time() . '_' . $media->getClientOriginalName();

            switch ($validatedData['media_type']) {
                case 'image':
                    $destinationPath .= 'images';
                    break;
                case 'video':
                    $destinationPath .= 'videos';
                    break;
                case 'audio':
                    $destinationPath .= 'audio';
                    break;
                case 'pdf':
                    $destinationPath .= 'pdfs';
                    break;
                default:
                    $destinationPath .= 'others';
            }

            $media->move(public_path($destinationPath), $fileName);
            $message->media_path = $destinationPath . '/' . $fileName;
            $message->media_type = $validatedData['media_type'];
        }

        $message->save();

        broadcast(new PrivateMessage($message))->toOthers();


        return $message;
    }


    public function createConversation($validatedData)
    {
        $existingConversation = Conversation::where(function ($query) use ($validatedData) {
            $query->where('user1_id', Auth::id())
                  ->where('user2_id', $validatedData['user_id']);
        })->orWhere(function ($query) use ($validatedData) {
            $query->where('user1_id', $validatedData['user_id'])
                  ->where('user2_id', Auth::id());
        })->first();

        if ($existingConversation) {
            return $existingConversation->id;
        }

        $conversation = Conversation::create([
            'user1_id' => Auth::id(),
            'user2_id' => $validatedData['user_id'],
        ]);

        return $conversation->id;
    }
    public function updateMessageStatus(int $messageId, string $status): bool
    {
        $validStatuses = ['sent', 'delivered', 'seen'];

        // التحقق من الحالة المرسلة
        if (!in_array($status, $validStatuses)) {
            return false; // الحالة غير صالحة
        }

        Message::where('id', $messageId)
            ->where('user_id', '!=', Auth::id()) // تأكد من أن المستخدم الحالي ليس هو من أرسل الرسالة
            ->whereIn('status', array_slice($validStatuses, 0, array_search($status, $validStatuses) + 1))
            ->update(['status' => $status]);

        return true;
    }
        public function deleteMessage(int $messageId): bool
{
    $message = Message::find($messageId);

    if (!$message) {
        return false; //
    }

    // التأكد من أن المستخدم الحالي هو مرسل الرسالة
    if ($message->user_id !== Auth::id()) {
        return false; // المستخدم ليس صاحب الرسالة
    }

    return $message->delete();
}
public function getUserConversations()
    {
        $userId = Auth::id();

        return Conversation::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->get();
    }
    public function getMessagesByConversationId(int $conversationId, int $offset = 0, int $limit = 30)
    {
        $userId = Auth::id();
        $conversation = Conversation::find($conversationId);

        if (!$conversation || (!$conversation->user1_id === $userId && !$conversation->user2_id === $userId)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'desc') // ترتيب الرسائل من الأحدث إلى الأقدم
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    }






