<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Repository\BaseRepository;
use Doctrine\ORM\EntityManager;

class UserRepository implements UserRepositoryInterface
{
    
    /**
     * @var EntityManager
     */
    protected $entityManager;
    
    /**
     * BaseRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }
    
    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    
    /**
     * @return string
     */
    protected function getEntityName()
    {
        return User::class;
    }
}