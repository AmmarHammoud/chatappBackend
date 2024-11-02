<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConversationRequest;
use App\Http\Requests\GetUserConversationsRequest;
use App\Http\Requests\SendMessageRequest;
use App\Http\Requests\UpdateMessageStatusRequest;
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

    public function sendMessageWithMedia(SendMessageRequest $request): JsonResponse
    {
        $message = $this->chatService->sendMessage($request->validated());

        return response()->json($message, 201);
    }

    public function createConversation(CreateConversationRequest $request): JsonResponse
    {
        $conversationId = $this->chatService->createConversation($request->validated());

        return response()->json(['conversation_id' => $conversationId], 201);
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
   public function getUserConversations(GetUserConversationsRequest $request): JsonResponse
{
    $conversations = $this->chatService->getUserConversations();

    return response()->json($conversations, 200);
}
}




