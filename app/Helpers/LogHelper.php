<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function logAction($action, $details = null)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => $details
        ]);
    }
}
