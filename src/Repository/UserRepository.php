<?php

namespace App\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\DBAL\Connection;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;

class UserRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }

    public function findOneByEmailOrFail(string $email): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email])) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }
    
    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */  
    public function save(User $user): void
    {
        $this->saveEntity($user);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */  
    public function remove(User $user): void
    {
        $this->removeEntity($user);
    }


}

?>