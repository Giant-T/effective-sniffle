<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserRepository
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

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        $sql = "INSERT INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function getUsers($id) : array
    {
        if ($id) {
            $sql = "SELECT * FROM users WHERE id = $id;";
        }
        else {
            $sql = "SELECT * FROM users;";
        }
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteUsers($id)
    {
        $stmt = $this->connection->prepare( "DELETE FROM users WHERE id =:id" );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUsers($data, $id) {
        if ($data['username']) {
            $stmt = $this->connection->prepare( "UPDATE users SET username =:username WHERE id =:id" );
            $stmt->execute(['id' => $id, 'username' => $data['username']]);
        }
        if ($data['first_name']) {
            $stmt = $this->connection->prepare( "UPDATE users SET first_name =:first_name WHERE id =:id" );
            $stmt->execute(['id' => $id, 'first_name' => $data['first_name']]);
        }
        if ($data['last_name']) {
            $stmt = $this->connection->prepare( "UPDATE users SET last_name =:last_name WHERE id =:id" );
            $stmt->execute(['id' => $id, 'last_name' => $data['last_name']]);
        }
        if ($data['email']) {
            $stmt = $this->connection->prepare( "UPDATE users SET email =:email WHERE id =:id" );
            $stmt->execute(['id' => $id, 'email' => $data['email']]);
        }
        return $id;
    }
}
