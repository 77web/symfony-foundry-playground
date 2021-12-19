<?php

namespace App\Repository;

use App\Domain\CompletedTasksFetcherInterface;
use App\Domain\IncompleteTasksFetcherInterface;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository implements IncompleteTasksFetcherInterface, CompletedTasksFetcherInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function fetchCompletedTasks(): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where($qb->expr()->isNotNull('t.completedAt'));

        return $qb->getQuery()->getArrayResult();
    }

    public function fetchIncompleteTasks(): array
    {
        return $this->findBy(['completedAt' => null]);
    }
}
