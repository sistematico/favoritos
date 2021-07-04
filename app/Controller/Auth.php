<?php

namespace App\Controller;

use App\Model\User;
use \Firebase\JWT\JWT;

class Auth extends Api
{
    public static function generateToken($request): array
    {
        $postVars = $request->getPostVars();

        if (!isset($postVars['email']) || !isset($postVars['password']))
        {
            throw new \Exception("Os campos email e senha são obrigatórios.", 400);            
        }

        $obUser = User::getUserByEmail($postVars['email']);
        if (!$obUser instanceof User || !password_verify($postVars['password'], $obUser->password)) {
            throw new \Exception("Usuário e/ou senha são inválidos.", 400);
        }

        return [
            'token' => JWT::encode(['email' => $obUser->email], JWT_KEY)
        ];
    }
}