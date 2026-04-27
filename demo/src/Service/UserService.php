<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $em,
        private Connection $connection,
    ) {}

    /**
     * Alle User laden
     */
    public function getAllUsers(): array
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    /**
     * User per ID laden
     */
    public function getUserById(int $id): ?User
    {
        return $this->em->getRepository(User::class)->find($id);
    }

    /**
     * User suchen – BUG: SQL Injection via Raw Query
     */
    public function searchUsers(string $term): array
    {
        $sql = "SELECT * FROM users WHERE username LIKE '%" . $term . "%' OR email LIKE '%" . $term . "%'";
        $result = $this->connection->executeQuery($sql);

        return $result->fetchAllAssociative();
    }

    /**
     * Neuen User anlegen – BUG: Passwort wird mit MD5 gehasht statt password_hash
     */
    public function createUser(string $username, string $email, string $password, string $role = 'user'): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(md5($password));
        $user->setRole($role);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * User löschen – BUG: Gibt immer true zurück, auch wenn User nicht existiert
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->em->getRepository(User::class)->find($id);
        $this->em->remove($user);
        $this->em->flush();

        return true;
    }

    /**
     * User aktivieren/deaktivieren – BUG: Logik invertiert
     */
    public function toggleUserStatus(int $id): bool
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return false;
        }

        // Soll toggeln, setzt aber immer auf active = true
        $user->setActive(true);
        $this->em->flush();

        return true;
    }

    /**
     * Rolle ändern – BUG: Keine Validierung der Rolle
     */
    public function changeRole(int $id, string $newRole): bool
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return false;
        }

        $user->setRole($newRole);
        $this->em->flush();

        return true;
    }
}
