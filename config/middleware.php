<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(TwigMiddleware::class);

    // Permettre les CORS
    $app->add(\App\Middleware\CorsMiddleware::class);
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Add app base path
    $app->add(BasePathMiddleware::class);

    // Catch exceptions and errors
    $loggerFactory = $app->getContainer()->get(\App\Factory\LoggerFactory::class);
    // Le nom du fichier où les erreurs seront inscrites
    $logger = $loggerFactory->addFileHandler('errors.log')->createLogger();
    $app->addErrorMiddleware(true, true, true, $logger);

};
