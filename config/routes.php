<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->post('/users', \App\Action\UserCreateAction::class);
    $app->get('/users[/{id:[0-9]+}]', \App\Action\UserGetAction::class);
    $app->delete('/users/{id:[0-9]+}', \App\Action\UserDeleteAction::class);
    $app->put('/users/{id:[0-9]+}', \App\Action\UserUpdateAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

};

