<?php

require 'src/Repositories/UserRepository.php';
require 'src/Exceptions/UserDoesNotExistException.php';
require 'src/Models/User.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $userRepository = new UserRepository();

        $newUser = new User('John Doe', 'john@example.com', 'password');
        $userId = $userRepository->save($newUser);

        $this->assertNotNull($userId);
        $this->assertEquals($newUser, $userRepository->getById($userId));
    }

    public function testUpdateUser()
    {
        $userRepository = new UserRepository();

        $newUser = new User('John Doe', 'john@example.com', 'password');
        $userId = $userRepository->save($newUser);

        $updatedUser = $userRepository->getById($userId);
        $updatedUser->setName('John Smith');
        $userRepository->update($updatedUser);

        $this->assertEquals('John Smith', $userRepository->getById($userId)->getName());
    }

    public function testDeleteUser()
    {
        $userRepository = new UserRepository();

        $newUser = new User('John Doe', 'john@example.com', 'password');
        $userId = $userRepository->save($newUser);

        $this->assertTrue($userRepository->delete($newUser));
        $this->assertNull($userRepository->getById($userId));

        $this->expectException(UserDoesNotExistException::class);
    }

    public function testWhenUserIsNotFoundByIdErrorIsThrown()
    {
        $userRepository = new UserRepository();
        $userRepository->getById('bad-id');

        $this->expectException(UserDoesNotExistException::class);
    }

    public function testGetAllUsers()
    {
        $userRepository = new UserRepository();

        $newUser1 = new User('John Doe', 'john@example.com', 'password');
        $userRepository->save($newUser1);

        $newUser2 = new User('Jane Smith', 'jane@example.com', 'password');
        $userRepository->save($newUser2);

        $users = $userRepository->getAllUsers();

        $this->assertCount(2, $users);
        $this->assertContains($newUser1, $users);
        $this->assertContains($newUser2, $users);
    }

    public function testFindByEmail()
    {
        $userRepository = new UserRepository();

        $newUser1 = new User('John Doe', 'john@example.com', 'password');
        $userRepository->save($newUser1);

        $newUser2 = new User('Jane Smith', 'jane@example.com', 'password');
        $userRepository->save($newUser2);

        $foundUser = $userRepository->findByEmail('john@example.com');

        $this->assertEquals($newUser1, $foundUser);
    }
}
