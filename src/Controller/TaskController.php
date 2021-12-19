<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    #[Route('/task', name: 'tasks')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->taskRepository->findBy(['completedAt' => null]),
        ]);
    }

    #[Route('/task/completed', name: 'completed_tasks')]
    public function completed(): Response
    {
        return $this->render('task/completed.html.twig', [
            'tasks' => $this->taskRepository->findBy([]),
        ]);
    }
}
