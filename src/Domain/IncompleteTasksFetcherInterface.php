<?php

namespace App\Domain;

use App\Entity\Task;

interface IncompleteTasksFetcherInterface
{
    /**
     * @return Task[]
     */
    public function fetchIncompleteTasks(): array;
}
