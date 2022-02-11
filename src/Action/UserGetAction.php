<?php


namespace App\Action;


use App\Domain\User\Service\UserCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserGetAction
{
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        if (isset($args['id'])) {
            $usersData = $this->userCreator->getUsers($args['id']);
        }
        else {
            $usersData = $this->userCreator->getUsers();
            $queryParams = $request->getQueryParams() ?? [];
            $sort = $queryParams['sort'] ?? '';

            if ($sort != '') {
                usort($usersData, function($a, $b) use ($sort) {
                    return $a[$sort] <=> $b[$sort];
                });
            }
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($usersData));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}