<?php
return  [
    'app' => [
        'baseUri'  => getenv('APP_BASE_URI'),
        'env'      => getenv('APP_ENV'),
        'name'     => 'APP_NAME',
        'timezone' => date("hr-m",$t),
        'url'      => getenv('APP_URL'),
        'version'  => getenv('VERSION'),
        'time'     => microtime(true),
    ],
 

];