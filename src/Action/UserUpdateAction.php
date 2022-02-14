<?php

namespace App\Action;

use App\Factory\LoggerFactory;
use App\Domain\User\Service\UserCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserUpdateAction
{
    private $userCreator;
    private $logger;

    public function __construct(UserCreator $userCreator, LoggerFactory $loggerFactory)
    {
        $this->userCreator = $userCreator;
        $this->logger = $loggerFactory->addFileHandler('userLog.log')->createLogger('updateUser');
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    )
    {
        $data = (array)$request->getParsedBody();
        $firstname = $data['first_name'];
        $userId = $this->userCreator->updateUsers($data, $args['id']);
        $result = ["user_id" => $userId];
        $response->getBody()->write((string)json_encode($result));
        $this->logger->info("L'usager $firstname a été modifié : " . (string)json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
