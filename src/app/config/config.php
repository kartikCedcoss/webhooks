<?php
$t=time();
return  [
    'app' => [
        'baseUri'  => 'http://192.168.1.243:5000/',
        'env'      => getenv('APP_ENV'),
        'name'     => 'APP_NAME',
        'timezone' => date("hr-m",$t),
        'url'      => getenv('APP_URL'),
        'version'  => getenv('VERSION'),
        'time'     => microtime(true),
    ],
 

];