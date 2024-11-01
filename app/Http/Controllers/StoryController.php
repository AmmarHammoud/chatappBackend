<?php

namespace App\Http\Controllers;

use App\Events\StoryCreated;
use App\Http\Requests\StoreStoryRequest;
use App\Services\StoryService;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $storyService;

    public function __construct(StoryService $storyService)
    {
        $this->storyService = $storyService;
    }


    
    public function create(StoreStoryRequest $request)
    {
        $story = $this->storyService->createStory($request->validated());
        broadcast(new StoryCreated($story))->toOthers();

        return response()->json(['message' => 'Story created successfully', 'story' => $story], 201);
    }


    public function delete( int $storyId)
    {
        $deleted = $this->storyService->deleteStory($storyId);

        if (!$deleted) {
            return response()->json(['message' => 'Story not found or unauthorized access.'], 403);
        }

        return response()->json(['message' => 'Story deleted successfully.'], 200);
    }



    public function getActiveStories()
    {
        $stories = $this->storyService->getActiveStories();
        return response()->json(['stories' => $stories], 200);
    }

}
