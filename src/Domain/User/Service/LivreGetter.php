<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\LivreRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class LivreGetter
{
    /**
     * @var LivreRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param LivreRepository $repository The repository
     */
    public function __construct(LivreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all the books.
     *
     * @return array The books.
     */
    public function getLivres()
    {
        $livreData = $this->repository->getLivres();

        return $livreData;
    }

    public function getLivreDescription($id) {
        return $this->repository->getLivreDescription($id);
    }
}
