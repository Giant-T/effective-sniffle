<?php


namespace App\Action;


use App\Domain\User\Service\LivreGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LivreGetDescription
{
    private $livreGetter;

    public function __construct(LivreGetter $livreGetter)
    {
        $this->livreGetter = $livreGetter;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $id = $args['id'];
        $livreData = $this->livreGetter->getLivreDescription($id);

        // Build the HTTP response
        if (sizeof($livreData) == 1) {
            $response->getBody()->write((string)json_encode($livreData));
        }
        else {
            $response->getBody()->write((string)json_encode(array('errors'=>array('code'=>404, 'message'=>"Le id $id n'existe pas."))));
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}