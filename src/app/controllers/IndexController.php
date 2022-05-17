<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;

class IndexController extends Controller
{ 
    public function indexAction()
    {        
       
        
        if(!$this->cookies->has('name')){
        $this->response->redirect('../login');
        }
        $collection = $this->mongo->test->products;
        $result = $this->guzzle->allProducts();

        $this->view->result=$result;   
        if($this->request->getPost('view') !=""){
            $id = $this->request->getPost('view');
            $result2 = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId($id)]);
            $this->view->result2 = $result2;
        }

    }
   
}