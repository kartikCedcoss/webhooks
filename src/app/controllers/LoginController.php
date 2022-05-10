<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{    
  
    public function indexAction()
    {  
      
    }
    public function authAction(){
       $accessToken= new \App\Handler\AccessToken();
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('pass');
        $collection = $this->mongo->test->users;
        $result = $collection->findOne([ "email" => $email,"password"=>$pass]);
        if($result){
            $this->cookies->set(
                'name',
                $result->name,
                time() + 15 * 86400
            );
            $this->cookies->send();
        $token = $accessToken->getAccesstoken($result->name,$result->role);
        $collection->updateOne(["email"=>$email],['$set'=>["token"=>$token]]);
        $this->response->redirect('../');
        }
    }
    public function logoutAction(){
        $rememberMeCookie = $this->cookies->get('name');
        $rememberMeCookie->delete();
        $this->response->redirect('../login');
    }
}