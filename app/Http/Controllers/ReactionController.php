<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteReactionRequest;
use App\Http\Requests\ReactionRequest;
use App\Services\ReactionService; // تأكد من وجود خدمة لمعالجة التفاعلات
use Illuminate\Http\JsonResponse;

class ReactionController extends Controller
{
    protected $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    public function addReaction(ReactionRequest $request): JsonResponse
    {
        try {
            $reaction = $this->reactionService->addReaction($request->validated());
            return response()->json(['message' => 'Reaction added successfully', 'reaction' => $reaction], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }}

        public function removeReaction(DeleteReactionRequest $request)
        {
           $deleted= $this->reactionService->removeReaction($request->validated());

            return response()->json(['message' => 'Reaction removed successfully'], 200);


    if (!$deleted) {
        return response()->json(['message' => 'Reaction not found'], 404);
    }


}
public function getReactions(): JsonResponse
    {
        $reactions = $this->reactionService->getReactions();

        return response()->json([ 'message'=>'this all reactions for this message','data'=>$reactions], 200);
    }

}


