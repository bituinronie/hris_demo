<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Setting;

use Illuminate\Http\Request;
use App\Models\ServiceRecord;
use App\Rules\isPasswordAllowed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     */
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials['isActive'] = true;

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if(env('IS_DEV'))
            $token = auth()->setTTL(2147483647)->attempt($credentials);

        $user = User::where('username', $credentials['username'])->first();
        if($user->role == 'Kiosk')
            return response()->json(['message' => 'Kiosk cannot access this site.'], 401);

        if($user->employee) {
            if(!ServiceRecord::getRecord($user->employee->id, null, true))
                return response()->json(['message' => 'No active service record found.'], 401);
        }

        activity('User')
            ->causedBy($user)
            ->log('login');

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     */
    public function user(){
        $user = auth()->user();

        return response()->json([
            'user_id' => $user->id,
            'employee_id' => $user->employee?->id,
            'username' => $user->username,
            'shouldChange' => $user->shouldChange,
            'email' => $user->email,
            'fullName' => $user->employee->name ?? null,
            'role' => $user->roles()->first()->name,
            'permissions' => $user->permissions()->pluck('name'),
            'settings' => [
                'isUpdateEmployee' => Setting::isUpdateEmployee(),
                'isOkToRequest' => $user?->employee?->isOkToRequest ?? false,
                'hasApproverList' => $user?->employee?->hasApproverList ?? false,
            ],
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     */
    public function logout(){
        auth()->logout();

        return response()->json(null, 204);
    }

    /**
     * Refresh a token.
     *
     */
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    public function changePassword(Request $request){
        $body = $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', 'confirmed', new isPasswordAllowed],
        ]);

        $user = auth()->user();

        if (!Hash::check($body['old_password'], $user->password))
            return response()->json(['message' => 'wrong password.'], 400);

        $user->password = Hash::make($body['new_password']);
        $user->shouldChange = false;
        $user->isForgotPassword = false;

        $user->save();

        return response()->json(['message' => 'password successfully changed.'], 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     */
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
