<?php


namespace App\Console\Commands;

use App\Models\Story;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteExpiredStories extends Command
{
    protected $signature = 'stories:delete-expired';
    protected $description = 'Delete expired stories from the database';

    public function handle()
    {
        $deleted = Story::where('expires_at', '<', Carbon::now())->delete();
        $this->info("$deleted expired stories deleted.");
    }
}
