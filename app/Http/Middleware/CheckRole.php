<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // አካውንቱ የታገደ ከሆነ
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'ይህ አካውንት ታግዷል፤ እባክዎ አስተዳዳሪውን ያነጋግሩ።']);
        }

        // ሚናውን መፈተሽ
        if (!$user->role) {
            abort(403, 'ይህን ገጽ ለመጎብኘት የሚያስችል ፈቃድ የለዎትም።');
        }

        $userRole = strtolower($user->role->name);

        // የተፈቀደላቸው ሚናዎች ዝርዝር ውስጥ መኖሩን ማረጋገጥ
        foreach ($roles as $role) {
            if ($role && strtolower($role) === $userRole) {
                return $next($request);
            }
        }

        // ዋና አድሚን ከሆነ ሁሉንም መክፈት ይችላል
        if ($userRole === 'admin') {
            return $next($request);
        }

        abort(403, 'ይህን ገጽ የመክፈት ፈቃድ የለዎትም። (Unauthorized Action)');
    }
}
