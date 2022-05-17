<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;

class ProductController extends Controller
{ 
    public function indexAction()
    {
     $temp=0;
     if($this->request->isPost('addField')){
      if($this->request->getPost('addField') == 0){
          $temp = 1;
      }
      elseif($this->request->getPost('addField')==1){
          $temp=2;
      }
      if($this->request->getPost('decField')== 1 ){
        $temp=0;
      }
      elseif($this->request->getPost('decField') == 2){
           $temp=1;
       }
      }
     $this->view->temp=$temp;
    }
    public function addAction(){
            $name = $this->request->getPost('pName');
            $category = $this->request->getPost('catName');
            $price = $this->request->getPost('pPrice');
            $stock = $this->request->getPost('pStock');  
            $result= $this->guzzle->createproduct($name,$category,$price,$stock);
            $v     = $this->guzzle->createwebhook($name,"create_product","private_key");
            $this->view->message = "product added succesfully";
    }
    public function searchAction(){
        $flag = 0;
        if($this->request->getPost('search') != "" ){
        $product = $this->request->getPost('search');
        $result = $this->guzzle->searchProduct($product);
        $this->view->result=$result;
        $flag =1;
        }
        $this->view->flag = $flag;
    }
    public function deleteAction(){
        $id = $this->request->getPost('delete');
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->products;
        $result = $collection->deleteOne([ "_id" => new MongoDB\BSON\ObjectId($id)]);
        if($result){
           $this->response->redirect('../index');
        }
    }
    public function editAction(){
        $id = $this->request->getPost('view');
       
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->products;
        $result = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId($id)]);
        $this->view->result=$result;
    }
    public function UpdateAction(){
        $client = new Client();
          $id = $this->request->getPost('id');
          
          $name=$this->request->getPost('upName');
          $category = $this->request->getPost('ucatName');
          $price = $this->request->getPost('upPrice');
          $stock =$this->request->getPost('upStock');
          $result = $this->guzzle->updateproduct($id,$name,$category,$price,$stock);
          $args = [
           "id"=>$id,
           "name"=>$name,
           "category"=>$category,
           "price"=>$price,
           "stock"=>$stock,
             ];
          $v = $this->guzzle->getWebhook("update");
          foreach($v as $k){
          $url = $k['url'];
          $response = $client->request("POST",$url,["form_params" => $args]); 
          }
          
          if($result){
            $this->response->redirect('../index');
        }

    }

}