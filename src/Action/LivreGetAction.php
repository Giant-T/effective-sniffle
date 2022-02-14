<?php


namespace App\Action;


use App\Domain\User\Service\LivreGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LivreGetAction
{
    private $livreGetter;

    public function __construct(LivreGetter $livreGetter)
    {
        $this->livreGetter = $livreGetter;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $livreData = $this->livreGetter->getLivres();

        $queryParams = $request->getQueryParams() ?? [];
        $tri = $queryParams['tri'] ?? 'asc';

        $page = $queryParams['page'] ?? 1;

        $page = is_numeric($page) ? (int)$page : 1;

        $livres = array_slice($livreData, (($page - 1) * 20), 20);

        if ($tri == 'asc') {
            usort($livres, function($a, $b) {
                return $a['title']>$b['title'];
            });
        }
        else {
            usort($livres, function($a, $b) {
                return $a['title']<$b['title'];
            });
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode(array('livres'=>$livres, 'page'=>$page, 'page_total'=>ceil(sizeof($livreData) / 20))));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}