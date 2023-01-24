<?php
namespace App\Traits\Scopes;

use App\Models\Token;

/**
 * Token Model Scope
 * 
 * findByToken
 */
trait TokenScope
{

    /**
     * Find Active Token by token
     * 
     * @param $token
     * 
     * @return object
     */
    public static function findByToken(string $token){
        $query = Token::where('token', $token)
                    ->where('is_revoke', false)
                    ->where('expired_at', '>', date('Y-m-d H:i:s'))
                    ->first();

        return $query;
    }

    /**
     * Revoke Token
     * 
     * @param $token
     * 
     * @return null
     */
    public static function revokeByToken(string $token){
        $tokenEntity = Token::findByToken($token);
        if($tokenEntity == null)
            response()->json(['message' => 'Token not found (TokenScope:revokeByToken)'])->send();

        $tokenEntity->is_revoke = true;
        $tokenEntity->save();
    }
}
