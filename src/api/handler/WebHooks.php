<?php
namespace Api\Handler;

class WebHooks{

    public function createWebhooks($key,$name,$event){
        $client =  $mongo = new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->webhooks;
        $insertOneResult = $collection->insertOne([
            'key'=>$key,
            'name' => $name,
            'event'=>$event,
            'url' => 'http://localhost:8000/', 
        ]);

    }

}