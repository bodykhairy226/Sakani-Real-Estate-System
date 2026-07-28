<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // الـ key بقى على أساس الـ IP بس، مش اليوزرنيم + الـ IP
        // عشان لو حد جرب يوزرنيمات مختلفة من نفس الجهاز يتقفل برضو
        $key = 'login_attempts_' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {

            $seconds = RateLimiter::availableIn($key);

            $minutes = ceil($seconds / 60);

            return response()->json([
                'message' => "تم تجاوز عدد المحاولات. حاول مرة أخرى بعد {$minutes} دقيقة.",
                'seconds' => $seconds,
            ], 429);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            RateLimiter::hit($key, 600);

            return response()->json([
                'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'
            ], 401);
        }

        // هنا فقط بعد نجاح تسجيل الدخول
        RateLimiter::clear($key);

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',

            'token' => $token,

            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]
        ]);
    }

    public function loginStatus(Request $request)
    {
        // مفيش حاجة اسمها username هنا خالص، الفحص بقى على أساس الـ IP بس
        $key = 'login_attempts_' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {

            $seconds = RateLimiter::availableIn($key);

            $minutes = ceil($seconds / 60);

            return response()->json([
                'locked' => true,
                'seconds' => $seconds,
                'message' => "تم تجاوز عدد المحاولات. حاول مرة أخرى بعد {$minutes} دقيقة."
            ]);
        }

        return response()->json([
            'locked' => false
        ]);
    }
    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'تم تسجيل الخروج بنجاح'
    ]);
}
public function updateCredentials(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username,' . $request->user()->id,
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = $request->user();

    $user->update([
        'username' => $validated['username'],
        'password' => Hash::make($validated['password']),
    ]);

    return response()->json([
        'message' => 'تم تحديث بيانات تسجيل الدخول بنجاح.',
    ]);
}
}