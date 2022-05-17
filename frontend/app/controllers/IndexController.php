<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use MongoDB\InsertOneResult;

class IndexController extends Controller
{ 
    public function indexAction()
    {
        $result = $this->guzzle->allProducts();
        
        print_r($result);
        echo "<br>";
        echo "<br>";
        $this->view->result=$result;   
        
    }
 
}