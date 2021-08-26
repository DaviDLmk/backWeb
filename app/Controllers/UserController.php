<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Firebase\JWT\JWT;
use App\Models\utilisateur;



class UserController
{
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $login = $data["login"] ?? "";
        $password = $data["password"] ?? "";

        if($login != $_ENV["ADMIN_LOGIN"] || $password != $_ENV["ADMIN_PASSWORD"]){
            $response->getBody()->write(json_encode([
                "success" => false
            ]));
            return $response->withHeader("Content-Type", "application/json")->withStatus(401);
        }

        $issuedAt = time();

        // Creation des données JWT
        $payload = [
            "user" => [
                "id" =>$_ENV["ADMIN_ID"],
                "login" => $_ENV["ADMIN_LOGIN"]
            ],
            "iat" => $issuedAt,
            "exp" => $issuedAt + 60 // 60 secondes
        ];

        // Encodage
        $token_jwt = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");

        $response->getBody()->write(json_encode([
            "success" => true
        ]));
        return $response
            ->withHeader("Authorization", "Bearer ". $token_jwt)
            ->withHeader("Content-Type", "application/json");
    }
}