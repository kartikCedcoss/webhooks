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
        $webhook = $this->request->getPost('name');
        $event = $this->request->getPost('category');
        $key = $this->request->getPost('price');
        $url = $this->request->getPost('stock');
        $result = $this->guzzle->createwebhook($webhook,$event,$key,$url);
    }
   
}