<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class NavbarHelper
{
    /**
     * Clear navbar cache for a specific user
     */
    public static function clearCache(?int $userId = null): void
    {
        $userId = $userId ?? auth()->id();
        
        if ($userId) {
            Cache::forget("navbar_counts_{$userId}");
        }
    }
}
