<?php

include_once 'Request.php';
include_once 'Routeur.php';
$router = new Router(new Request);

$router->get('/portfolio', function () {
    return <<<HTML
  <h1>Hello world</h1>
HTML;
});


$router->get('/portfolio/profile', function () {
    return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/portfolio/data', function ($request) {

    return json_encode($request->getBody());
});

$router->get('/portfolio/administration', function (){
    echo "chui là";
    include_once("../../../Admin/admin.php");
});
