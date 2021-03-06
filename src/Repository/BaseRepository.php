<?php

namespace App\Repository;

/*
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\DBAL\Connection;
*/
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\Persistence\Mapping\MappingException;




abstract class BaseRepository
{
    private ManagerRegistry $managerRegistry;
    private Connection $connection;
    protected ObjectRepository $objectRepository;

    public function __construct(ManagerRegistry $managerRegistry, Connection $connection)
    {
        $this->managerRegistry = $managerRegistry;
        $this->connection = $connection;
        $this->objectRepository = $this->getEntityManager()->getRepository($this->entityClass());
    }


    abstract protected static function entityClass(): string;

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function persistEntity(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */  
    public function flushData(): void
    {
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */  
    public function saveEntity(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */  
    public function removeEntity(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }


    /**
     * @throws \Doctrine\DBAL\DBALException
     */ 
    protected function executeFetchQuery(string $query, array $params = []): array
    {
        return $this->connection->executeQuery($query, $params)->fetchAll();
    }

    
    /**
     * @throws \Doctrine\DBAL\DBALException
     */ 
    protected function executeQuery(string $query, array $params = []): array
    {
        return $this->connection->executeQuery($query, $params)->fetchAll();
    }


    /**
     * @return ObjectManager|EntityManager
     */
    private function getEntityManager()
    {
        $entityManager = $this->managerRegistry->getManager();

        if ($entityManager->isOpen()) {
            return $entityManager;
        }

        return $this->managerRegistry->resetManager();
    }
}

?>