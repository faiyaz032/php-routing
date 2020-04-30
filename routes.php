<?php

use App\Routing\Router;

require 'Router.php';

Router::get('/', function(){
    echo "Welcome Home";
});

Router::get('/hello/world', function(){
    echo "Hello World";
});