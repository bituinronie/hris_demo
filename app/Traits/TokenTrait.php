<?php

namespace App\Traits;

use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Token;

/**
 * Token traits
 * 
 * generateToken
 * revokeToken
 * getTokenModel
 * 
 * getToken
 */
trait TokenTrait
{
    /**
     * Generate Token
     * 
     * @param $permissionId
     * @param $modelId
     * @param $modelName
     * 
     * @return string
     */
    public function generateToken(int $permissionId, int $modelId, array $modelName = null){

        // Validation
        $permission = Permission::find($permissionId);
        if($permission == null)
            response()->json(['message' => 'No permission found (TokenTrait: generateToken)'], 400)->send();

        $user = User::find($modelId);
        if($user == null)
            response()->json(['message' => 'No User found (TokenTrait: generateToken)'], 400)->send();

        // Process
        $token = $this->getToken();

        // Saving Record
        Token::create([
            'permission_id' => $permissionId,
            'token' => $token,
            'model_id' => $modelId,
            'model_name' => $modelName
        ]);

        return $token;
    }

    /**
     * Revoking Token
     * 
     * @param $token
     * 
     * @return null
     */
    public function revokeToken(string $token){
        Token::revokeByToken($token);
        return null;
    }

    /**
     * Get Token Model
     * 
     * @param $token
     * 
     * @return array (camelcase)
     */
    public function getTokenModel(string $token){
        // init variables
        $tokenEntity = Token::findByToken($token);
        if($tokenEntity == null) // catch error
            response()->json(['message' => 'Token not found. (TokenTrait:getTokenModel)'], 400)->send();

        $permission = Permission::find($tokenEntity->permission_id);
        if($permission == null) // catch error
            response()->json(['message' => 'Permission not found. (TokenTrait:getTokenModel)'], 400)->send();

        return [
            'modelId' => $tokenEntity->model_id,
            'modelName' => $tokenEntity->model_name,
            'permission' => $permission->name,
        ];
    }

    /**
     * get token (for generating token to use)
     * 
     * @param $token
     * 
     * @return string
     */
    private function getToken(){
        $token = Str::random(35);
        if(Token::where('token', $token)->first() != null)
            $token = $this->getToken();

        return $token;
    }
}


