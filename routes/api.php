<?php

$router = new \Klein\Klein();
$router->with('/api/', function () use ($router) {
    $router->get('contacts', 'App\Controllers\ContactController@index');
    $router->post('contacts', 'App\Controllers\ContactController@store');
    $router->get('contacts/[:id]', 'App\Controllers\ContactController@get');
    $router->delete('contacts/[:id]', 'App\Controllers\ContactController@delete');
    $router->patch('contacts/[:id]', 'App\Controllers\ContactController@update');

    $router->post('login', 'App\Controllers\AuthController@login');
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