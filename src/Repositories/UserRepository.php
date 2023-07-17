<?php

class UserRepository
{
    private $users = [];

    public function save(User $user)
    {
        $userId = uniqid();

        $user->setId($userId);

        $this->users[$userId] = $user;

        return $userId;
    }

    public function update(User $user)
    {
        // Verifica si el usuario existe en el repositorio
        if (isset($this->users[$user->getId()])) {
            // Actualiza el usuario en el repositorio
            $this->users[$user->getId()] = $user;

            return true; // Actualización exitosa
        }

        return false; // Usuario no encontrado
    }

    public function delete(User $user)
    {
        // Verifica si el usuario existe en el repositorio
        if (isset($this->users[$user->getId()])) {
            // Elimina el usuario del repositorio
            unset($this->users[$user->getId()]);

            throw new UserDoesNotExistException("User has been removed");
            return true; // Eliminación exitosa

        }
    }

    public function getAllUsers()
    {
        return $this->users;
    }

    public function getById($userId)
    {
        // Verifica si el usuario existe en el repositorio
        if (isset($this->users[$userId])) {
            // Retorna el usuario correspondiente al ID proporcionado
            return $this->users[$userId];
        }

        throw new UserDoesNotExistException("User does not exist with ID: $userId");
    }

    public function findByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null; // User not found
    }
}
