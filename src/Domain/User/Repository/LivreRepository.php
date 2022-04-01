<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class LivreRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getLivres() : array
    {
        $sql = "SELECT id, title, series, cover_link, author, average_rating, isbn, isbn13 FROM books;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLivreDescription($id) {
        $sql = "SELECT id, title, description FROM books WHERE id = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getApiKey($key) {
        $sql = "SELECT id, no_cle FROM cle_api WHERE no_cle=:api_key;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':api_key', $key);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
