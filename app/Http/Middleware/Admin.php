<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Admin
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // ✅ User not logged in
        // if (!Auth::check()) {
        //     if ($request->ajax() || $request->wantsJson()) {
        //         return response()->json(['message' => 'Unauthorized'], 401);
        //     }
        //     return redirect()->route('admin.login'); // Redirect to login page
        // }

              if (!Auth::check()) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['message' => 'Unauthorized'], 401);
                    }
                return redirect()->route('admin.login'); // <-- Route name must exist
              }

        // ✅ Role check
        if ($role && Auth::user()->role !== $role) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Forbidden: Access denied'], 403);
            }
            return redirect()->route('admin.login'); // Redirect if role mismatch
        }

        return $next($request);
    }
}
