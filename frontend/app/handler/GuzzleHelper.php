<?php
namespace App\Handler;
use GuzzleHttp\Client;

class GuzzleHelper{

    public $client; 

    public function __construct()
    {
        $this->client = new Client(['base_uri' =>'http://192.168.1.243:5000/']);
    }

    public function allProducts(){
      
        $url = "/product/get";
        $response = $this->client->request("GET",$url);
        $response = ($response->getBody()); 
        $response_arr = json_decode($response,true);
        return $response_arr;
         
    }
    public function searchProduct($product){
        $url="/product/search/{$product}";
        $response = $this->client->request("GET",$url);
        $response = ($response->getBody()); 
        $response_arr = json_decode($response,true);
        return $response_arr;
    }
    
}