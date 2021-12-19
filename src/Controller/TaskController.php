<?php

namespace App\Controller;

use App\Domain\CompletedTasksFetcherInterface;
use App\Domain\IncompleteTasksFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private CompletedTasksFetcherInterface $completedTasksFetcher,
        private IncompleteTasksFetcherInterface $incompleteTasksFetcher,
    ) {
    }

    #[Route('/task', name: 'tasks')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->incompleteTasksFetcher->fetchIncompleteTasks(),
        ]);
    }

    #[Route('/task/completed', name: 'completed_tasks')]
    public function completed(): Response
    {
        return $this->render('task/completed.html.twig', [
            'tasks' => $this->completedTasksFetcher->fetchCompletedTasks(),
        ]);
    }
}
