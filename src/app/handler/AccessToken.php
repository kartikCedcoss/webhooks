<?php
namespace App\Handler;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AccessToken{
    
    public function getAccesstoken($name,$token){
        $key = "example_key";

        $payload = array(
            "iss" => "http://localhost:8080",
            "aud" => "http://localhost:8080",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "name"=>$name,
            "role"=>$token, 
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
    public function decoded($jwt){
        try{
            $key = "example_key";
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            $role = $decoded->role;
               
             }
            catch(\Exception $e){
            echo $e->getMessage();
            die;
           }
    }

}