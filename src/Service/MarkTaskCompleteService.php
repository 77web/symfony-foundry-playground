<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Task;
use App\Service\Exception\AlreadyCompletedException;
use Doctrine\ORM\EntityManagerInterface;

class MarkTaskCompleteService
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function markComplete(Task $task): void
    {
        if ($task->getCompletedAt() !== null) {
            throw new AlreadyCompletedException($task->getId().'は既に完了しています');
        }

        $task->setCompletedAt(new \DateTimeImmutable());

        $this->em->persist($task);
        $this->em->flush();
    }
}
