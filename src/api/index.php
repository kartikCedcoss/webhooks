<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Url;

$loader = new Loader();
$container = new FactoryDefault();

define('BASE_PATH', dirname(__DIR__));

require   './vendor/autoload.php';

$loader->registerDirs(
    [
         './controllers/',
    
    ]
);
$loader ->registerNamespaces(
    [
        'Api\Handler'=>'./handler'
    ]
);
$loader->register();

$container->set('response',function(){
    return  new Response();
   
});
$container->set('mongo',function(){
    $mongo = new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
    return $mongo;
    
    },true);
    $container->set(
        'view',
        function () {
            $view = new View();
            $view->setViewsDir('./views/');
            return $view;
        }
    );

    $container->set(
        'url',
        function () {
            $url = new Url();
            $url->setBaseUri('/');
            return $url;
        }
    );

$prod= new Api\Handler\Product();

$app = new Micro($container);



$app->before(
    function () use ($app) {
        $controller = explode('/', $_SERVER["REQUEST_URI"])[1];
        if ((strpos($controller, 'user?')) == 0 || $controller == 'acl') {
            return true;      
    }else{

    }

        return false;
    }
);




$product = new MicroCollection();
$product
    ->setHandler(new ProductController())
    ->setPrefix('/product')
    ->get('/get', 'index')
    ->get('/create/{name}/{category}/{price}/{stock}', 'productCreate')
    ->get('/update/{id}','productUpdate')
    ->get('/get/{per_page}/{page}', 'page')
    
    ->get('/search/{keyword}', 'search');

$app->mount($product);

$acl = new MicroCollection();
$acl
    ->setHandler(new AclController())
    ->setPrefix('/acl')
    ->get('/', 'index');
$app->mount($acl);

$user = new MicroCollection();
$user
    ->setHandler(new UserController())
    ->setPrefix('/user')
    ->get('/', 'index')
    ->get('/register', 'register')
    ->get('/getaccesstoken/{name}', 'getAccessToken')
    ->get('/webhook/create/{key}/{name}/{event}','createWebhooks')
    ->get('/getwebhook/{event}','getwebhook')
    ->post('/auth', 'auth')
    ->post('/adminAuth', 'adminAuth');
$app->mount($user);

$order = new MicroCollection();

$order
    ->setHandler(new OrderController())
    ->setPrefix('/order')
    ->get('/create/{product_name}/{quantity}/{token}','create')
    ->get('/update/{id}/{status}','update');
    
$app->mount($order);

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('./views/');

    return $view;
};
$app->get(
    '/user/signup',
    function () use ($app) {
        echo $app['view']->render('/user/signup',[]);
    }
);
$app->get(
    '/user/adminLogin',
    function () use ($app) {
        echo $app['view']->render('user/adminLogin',[]);
    }
);
$app->get(
    '/user/login',
    function () use ($app) {
        echo $app['view']->render('user/login',[]);
    }
);
$app->get(
    '/user/auth/{email}',
    function ($email) use ($app) {
        echo $app['view']->render('user/auth',['email' => $email,]);
    }
);
$app->get(
    '/user/adminAuth/{orders}',
    function ($orders) use ($app) {
        echo $app['view']->render('user/adminAuth',['email' => $orders,]);
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);

