<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Loader;
use Phalcon\Events\Manager as EventsManager;
use \Phalcon\Debug;


define('BASE_PATH', dirname(__DIR__));

define('APP_PATH', BASE_PATH . '/app');



 require BASE_PATH . '/vendor/autoload.php';
  


$container = new FactoryDefault();


include APP_PATH . '/config/services.php';
include APP_PATH . '/config/loader.php';

$loader = new Loader();

$loader->registerNamespaces(
    [
        'App\Handler' => APP_PATH . '/handler/'
        
    ]
);

$loader->register();


$application=new Application($container);
$eventsManager=new EventsManager();

$container->set('debug',function(){
return new Debug();
});

$container->set('prophiler',function(){
return new \Fabfuel\Prophiler\Profiler();
});

$container->set('guzzle',function(){
    return new \App\Handler\GuzzleHelper();
});

$container->set('mongo',function(){
  $mongo =  new MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
  return $mongo;
});

$container->set(
    'EventsManager',
    $eventsManager
);

$application->setEventsManager($eventsManager);
try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}