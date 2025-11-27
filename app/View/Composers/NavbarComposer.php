<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Wishlist;

class NavbarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (!auth()->check()) {
            return;
        }

        $userId = auth()->id();
        $cacheKey = "navbar_counts_{$userId}";

        // Cache for 30 seconds to reduce database queries
        $data = Cache::remember($cacheKey, 30, function () use ($userId) {
            $cart = Cart::where('user_id', $userId)->first();
            
            return [
                'unreadNotificationsCount' => auth()->user()->unreadNotifications->count(),
                'activeOrdersCount' => Order::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'processing', 'shipped'])
                    ->count(),
                'cartCount' => $cart ? $cart->items()->count() : 0,
                'wishlistCount' => Wishlist::where('user_id', $userId)->count(),
            ];
        });

        $view->with($data);
    }
}
