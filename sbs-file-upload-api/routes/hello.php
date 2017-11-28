<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withStatus(200)->write('SBS File Upload API.');
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    return $response->withStatus(200)->withJson('Hello '.$name.'!');
});