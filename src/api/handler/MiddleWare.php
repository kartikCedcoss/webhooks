<?php
namespace Api\Handler;
use Phalcon\Mvc\Dispatcher;
use Firebase\JWT\JWT;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class MiddleWare{
    public function getCustomer($jwt){
        if($jwt){
            try{
                $parser = new Parser();
                $tokenObject = $parser->parse($jwt);
                $now = new \DateTimeImmutable();
                $expires = $now->getTimestamp();
                $validator = new Validator($tokenObject,100);
                $validator->validateExpiration($expires);
                
                $claims = $tokenObject->getClaims()->getPayload();
                $role=$claims['sub'];
                return $role;
              }
             catch(\Exception $e){
             echo $e->getMessage();
             die;
            }
        }
    }
    public function accessToken($name){
        $key = "example_key";

        $payload = array(
            "iss" => "http://localhost:8080",
            "aud" => "http://localhost:8080",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "name"=>$name,
            "role"=>"admin", 
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
       
    }
}