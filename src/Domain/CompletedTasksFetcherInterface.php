<?php

namespace App\Domain;

use App\Entity\Task;

interface CompletedTasksFetcherInterface
{
    /**
     * @return Task[]
     */
    public function fetchCompletedTasks(): array;
}
