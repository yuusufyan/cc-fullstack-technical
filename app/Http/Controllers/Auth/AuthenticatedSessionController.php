<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            \Log::info('Start login');

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            \Log::info('Validated: ', $credentials);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Login gagal, email/password salah',
                ], 401);
            }

            $user = Auth::user();
            \Log::info('User: ', [$user]);

            $token = $user->createToken('auth_token')->plainTextToken;
            \Log::info('Token created');

            $roles = $user->getRoleNames();
            \Log::info('Roles: ', [$roles]);

            return response()->json([
                'message' => 'Login sukses',
                'token' => $token,
                'user' => $user,
                'roles' => $user->getRoleNames()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Exception',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
