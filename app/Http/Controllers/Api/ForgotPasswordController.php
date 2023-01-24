<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ForgotPassword;

class ForgotPasswordController extends Controller
{
    public function __construct(
        public Request $REQUEST
    ){
    }

    public function send(){
        $body = $this->REQUEST->validate([
            'email' => 'required|email'
        ]);

        if(!$user = User::findByEmail($body['email']))
            return response([
                'message' => 'No email found'
            ], 400);

        if(!$user->isActive)
            return response([
                'message' => 'Employee not active.'
            ], 400);

        // if($user->isForgotPassword)
            // return response([
            //     'message' => 'New password already sent.'
            // ], 400);

        // notify
        try {
            $user->notify(new ForgotPassword($user));
        } catch (\Throwable $th) {
            return $th;
        }

        return response([
            'message' => 'Email sent.'
        ], 200);

    }
}
