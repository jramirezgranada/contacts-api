<?php

$router = new \Klein\Klein();
$router->with('/api/', function () use ($router) {
    $router->get('contacts', 'Controllers\ContactController@index');
    $router->post('contacts', 'Controllers\ContactController@store');
    $router->get('contacts/[:id]', 'Controllers\ContactController@get');
    $router->delete('contacts/[:id]', 'Controllers\ContactController@delete');
    $router->patch('contacts/[:id]', 'Controllers\ContactController@update');

    $router->post('login', 'Controllers\AuthController@login');
});

$router->onHttpError(function ($code, $router) {
    return $router->response()->json(
        [
            "status" => "error",
            "code" => $code,
            "message" => "There is an error, please check the error code"
        ]
    );
});

$router->dispatch();