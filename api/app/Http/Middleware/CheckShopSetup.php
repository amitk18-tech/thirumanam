<?php

// app/Http/Middleware/CheckShopSetup.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckShopSetup
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
    
        if ($user) {
            // User-ku shop irukka check
            $shop = $user->shop;
    
            // Shop irunthalum setup complete-a illa irunthalum same message
            if (!$shop || !$shop->is_setup_complete) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shop setup required. Please complete the setup.',
                    'data' => null,
                    'error' => 'Shop setup incomplete',
                ], 401);
            }
        }
    
        return $next($request);
    }
    
}
