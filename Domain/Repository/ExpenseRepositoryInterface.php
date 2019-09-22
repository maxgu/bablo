<?php


namespace Domain\Repository;


use Domain\Entity\Expense;

interface ExpenseRepositoryInterface
{
    public function add(Expense $expense): void;

    public function findEventId(int $eventId): array;
}