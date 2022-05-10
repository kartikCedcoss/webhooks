<?php

use Phalcon\Mvc\Controller;

class OrderController extends Controller
{ 
    public function indexAction()
    {   
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->orders;
        if($this->request->getPost('status')){
            $status=$this->request->getPost('status');
            $result = $collection->find(["status"=>$status],['sort' => ['date' => -1]]);
            $this->view->result=$result;
        }elseif($this->request->getPost('btnCustom')){
            $from = $this->request->getPost('from');
            $to = $this->request->getPost('to');
            
            $result = $collection->find(['date' =>['$gte' => strtotime($from), '$lte' => strtotime($to)]],['sort' => ['date' => -1]]    
            );
            $this->view->result=$result;
        }
        elseif($this->request->getPost('date')){
            $val = $this->request->getPost('date');
            switch($val){
            case "Today":
              $result = $collection->find(["date"=>strtotime(date("d-m-Y"))],['sort' => ['date' => -1]]);
              $this->view->result=$result;   
              break;

            case "This Week":
                $monday = strtotime('last monday', strtotime('tomorrow'));
                $sunday = strtotime('+6 days', $monday);
                $result = $collection->find(['date' =>['$gte' => strtotime(date('d-m-Y', $monday)), '$lte' => strtotime(date('d-m-Y', $sunday) )]],['sort' => ['date' => -1]]    
            );
            $this->view->result=$result;
             break;
            case "This Month": 
            $result = $collection->find(['date' =>['$gte' => strtotime(date('01/m/Y')), '$lte' => strtotime(date('t-m-Y') )]],['sort' => ['date' => -1]]);
            $this->view->result=$result;
            }
         }
        else{
        $result = $collection->find([],['sort' => ['date' => -1]]);
        $this->view->result=$result;
    }
    }
    public function neworderAction(){
        $id=$this->request->getPost('newOrder');
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->products;
        $result = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId($id)]);
        $this->view->result=$result;
    }

    public function placeorderAction(){
        $id=$this->request->getPost('id');
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->orders;
        $insertOneResult = $collection->insertOne([
            'customerName' => $this->request->getPost('custName'),
            'productName' => $this->request->getPost('opName'),
            'productId'=>$id,
            'category' => $this->request->getPost('ocatName'),
            'price' => $this->request->getPost('opPrice'),
            'totalPrice'=> $this->request->getPost('opPrice')*$this->request->getPost('quantity'),
            'quantity' => $this->request->getPost('quantity'),
            "status"=>"Paid",
            'variations'=> [$this->request->getPost('oattrName'),$this->request->getPost('oattrValue')],
            "date"=> strtotime(date("d-m-Y")),
        ]);
      if($insertOneResult){
          $this->view->message = $insertOneResult->getInsertedId();
      }
    }
    public function changestatusAction(){
        $id = $this->request->getPost('btnChange');
        $newdata = array('$set'=>array(
            "status"=>$this->request->getPost('status'),
        ));
        $client = new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->orders;
        $result = $collection->updateOne(["_id" => new MongoDB\BSON\ObjectId($id)],$newdata);
        if($result){
            $this->response->redirect('../order');
        }  
    }

}