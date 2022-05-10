<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;

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