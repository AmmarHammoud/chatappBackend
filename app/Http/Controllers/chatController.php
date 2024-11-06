<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CreateConversationRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\GetMessagesRequest;
use App\Http\Requests\GetUserConversationsRequest;
use App\Http\Requests\SendMessageRequest;
use App\Http\Requests\UpdateMessageStatusRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class chatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }


    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        $message = $this->chatService->sendMessageWithMedia($request->validated());

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }


    public function createConversation(CreateConversationRequest $request): JsonResponse
    {
        // محاولة إنشاء المحادثة
        $conversation = $this->chatService->createConversation($request->validated());

        // إذا كانت المحادثة موجودة بالفعل، أرسل رسالة توضح ذلك
        if (is_null($conversation)) {
            return response()->json([
                'message' => 'Conversation already exists between these users. Cannot create a new one.'
            ], 400);
        }

        // إذا تم إنشاء المحادثة بنجاح
        return response()->json([
            'message' => 'Conversation created successfully.',
            'conversation' => $conversation
        ], 201);
    }


public function updateMessageStatus(UpdateMessageStatusRequest $request): JsonResponse
{
    $messageId = $request->message_id;
    $status = $request->status;

    $updated = $this->chatService->updateMessageStatus($messageId, $status);

    if (!$updated) {
        return response()->json(['message' => 'Invalid status or message ID'], 400);
    }

    return response()->json(['message' => 'Message status updated successfully'], 200);

}
public function deleteMessage(Request $request, int $messageId): JsonResponse
{
    $deleted = $this->chatService->deleteMessage($messageId);

    if (!$deleted) {
        return response()->json(['message' => 'You are not authorized to delete this message or message not found'], 403);
    }

    return response()->json(['message' => 'Message deleted successfully'], 200);
}
public function getUserConversations(): JsonResponse
{
    // جلب المحادثات من الخدمة
    $conversations = $this->chatService->getUserConversations();

    // تهيئة الاستجابة مع تفاصيل المحادثات وآخر رسالة
    return response()->json([
        'message' => 'Conversations retrieved successfully.',
        'conversations' => $conversations->map(function ($conversation) {
            return [
                'conversation_id' => $conversation->id,
                'created_at' => $conversation->created_at,
                'updated_at' => $conversation->updated_at,
                'users' => [
                    [
                        'id' => $conversation->user1->id,
                        'name' => $conversation->user1->name,
                        'email' => $conversation->user1->email,
                        'profile_image' => $conversation->user1->profile_image,
                    ],
                    [
                        'id' => $conversation->user2->id,
                        'name' => $conversation->user2->name,
                        'email' => $conversation->user2->email,
                        'profile_image' => $conversation->user2->profile_image,
                    ]
                ],
                'last_message' => $conversation->lastMessage ? [
                    'id' => $conversation->lastMessage->id,
                    'message' => $conversation->lastMessage->message,
                    'media_path' => $conversation->lastMessage->media_path,
                    'media_type' => $conversation->lastMessage->media_type,
                    'created_at' => $conversation->lastMessage->created_at,
                    'status'=>$conversation->lastMessage->status
                ] : null
            ];
        })
    ], 200);
}


public function getMessages(Request $request, int $conversationId): JsonResponse
{
    $offset = $request->get('offset', 0); // استرجاع قيمة offset من الطلب
    $messages = $this->chatService->getMessagesByConversationId($conversationId, $offset);

    if ($messages instanceof JsonResponse) {
        return $messages;
    }

    return response()->json($messages, 200);
}




}
