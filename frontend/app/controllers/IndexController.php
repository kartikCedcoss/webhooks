<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
use MongoDB\InsertOneResult;

class IndexController extends Controller
{ 
    public function indexAction()
    {    
        $collection = $this->mongo->frontend->products;
        
        $result = $collection->find();
        
        print_r($result);
        echo "<br>";
        echo "<br>";
        $this->view->result=$result;   
        
    }
 
}