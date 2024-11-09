<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\ChatService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Carbon\Carbon;

class UpdateUserOnlineStatus


{ protected $userStatusService;

    public function __construct(ChatService $userStatusService)
    {
        $this->userStatusService = $userStatusService;
    }

    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $this->userStatusService->updateUserStatus(true);
        }

        return $next($request);
    }
}
