<?php


namespace Domain\Query\Expense;


use Domain\Entity\Expense;
use Domain\Repository\ExpenseRepositoryInterface;

class ExpenseQuery
{
    /**
     * @var ExpenseRepositoryInterface
     */
    private $expenseRepository;

    /**
     * @param ExpenseRepositoryInterface $expenseRepository
     */
    public function __construct(
        ExpenseRepositoryInterface $expenseRepository
    ) {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * @param int $eventId
     * @return Expense[]
     */
    public function execute($eventId): array
    {
        return $this->expenseRepository->findEventId($eventId);
    }
}