<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserCreator
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertUser($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

    /**
     * Get all the users.
     *
     * @param int $id The id of the user you want or zero
     * @return array The users
     */
    public function getUsers($id = 0)
    {
        // Insert user
        $usersData = $this->repository->getUsers($id);

        return $usersData;
    }

    public function deleteUsers($id)
    {
        $hasWorked = $this->repository->deleteUsers($id);
        return $hasWorked;
    }

    public function updateUsers($data, $id) {
        $userId = $this->repository->updateUsers($data, $id);
        return $userId;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    /**
     * Create the api key.
     * 
     * @param auth The authentification header.
     * 
     * @return string The api key.
     */
    public function createUserKey($auth) {
        // get the user name and password from the header
        $auth = explode(" ", $auth);
        $auth = base64_decode($auth[1]);
        $auth = explode(":", $auth);
        $username = $auth[0];
        $password_auth = $auth[1];


        // get the user from the database
        $user = $this->repository->getUserByUsername($username);

        // check if the password is correct
        if (password_verify($password_auth, $user['password'])) {
            return array("cle_api" => $this->repository->generateKey($user['id']));
        } else {
            return array("error" => "Invalid credentials");
        }
    }
}
