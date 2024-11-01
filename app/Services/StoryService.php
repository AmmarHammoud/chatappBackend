<?php

namespace App\Services;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoryService
{
    public function createStory($validatedData)
    {
        $story = new Story();
        $story->user_id = Auth::id();
        $story->type = $validatedData['type'];
        $story->content = $validatedData['type'] === 'text' ? $validatedData['content'] : null;
        $story->expire_at = now()->addDay(); // 24 ساعة

        if ($story->type !== 'text' && isset($validatedData['media'])) {
            $destinationPath = 'story/media/';
            $media = $validatedData['media'];
            $fileName = time() . '_' . $media->getClientOriginalName();

            switch ($story->type) {
                case 'image':
                    $destinationPath .= 'images';
                    break;
                case 'video':
                    $destinationPath .= 'videos';
                    break;
                default:
                    $destinationPath .= 'others';
            }

            $media->move(public_path($destinationPath), $fileName);
            $story->media_path = $destinationPath . '/' . $fileName;
        }

        $story->save();

        return $story;
    }

    public function deleteStory(int $storyId): bool
    {
        $story = Story::where('id', $storyId)->where('user_id', Auth::id())->first();

        if (!$story) {
            return false;
        }

        
        return $story->delete();
    }

    public function getActiveStories()
    {
        return Story::where('expire_at', '>', Carbon::now())
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}

