<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;

class WebhookController extends Controller
{ 
    public function indexAction()
    {

        
    }
    public function createAction(){
        $webhook = $this->request->getPost('hookname');
        $event = $this->request->getPost('event');
        $key = $this->request->getPost('key');
        $url = $this->request->getPost('url');
        $result = $this->guzzle->createwebhook($webhook,$event,$key,$url);
        if($result){
            $this->view->message="webhook Sent";
        }
        else{
            $this->view->message="webhook Failed";
        }
    }
    public function getAction(){
        $event = $this->request->get('event');
          if($event == 'insert'){
            $collection = $this->mongo->frontend->products;
            $result = $collection->insertOne([
          "id"=>$this->request->getPost('id'),
          "name"=>$this->request->getPost('name'),
          "category"=>$this->request->getPost('category'),
          "stock" =>$this->request->getPost('stock'),
          "price"=>$this->request->getPost('price')
            ]);
        }
        elseif($event == 'update'){
            $id = $this->request->getPost('id');
            $name = $this->request->getPost('name');
            $category = $this->request->getPost('category');
            $price = $this->request->getPost('price');
            $stock = $this->request->getPost('stock');
    
                $newdata = array('$set'=>array(
                "name"=>$name,
                "category"=>$category,
                "price"=>$price,
                "stock"=>$stock,));
            $collection = $this->mongo->frontend->products;
            $result = $collection->updateOne(["id" => $id],$newdata);
        }

    }
   
}