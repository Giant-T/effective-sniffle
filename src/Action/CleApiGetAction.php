<?php

namespace App\Action;

use App\Domain\User\Service\UserCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CleApiGetAction
{
    private $userService;

    public function __construct(UserCreator $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $authHeader = $request->getHeader('Authorization');

        $cle = $this->userService->createUserKey($authHeader[0]);

        $response->getBody()->write((string)json_encode($cle));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
