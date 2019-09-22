<?php

namespace Domain\Command\AddExpense;

use Domain\Command\Exception\ValidationException;
use Domain\Entity\Expense;
use Domain\Repository\EventRepositoryInterface;
use Domain\Repository\ExpenseRepositoryInterface;

class AddExpenseCommand
{
    /**
     * @var ExpenseRepositoryInterface
     */
    private $expenseRepository;
    private $eventRepository;

    /**
     * @var AddExpenseValidator
     */
    private $validator;

    /**
     * @param ExpenseRepositoryInterface $expenseRepository
     * @param EventRepositoryInterface $eventRepository
     * @param AddExpenseValidator $validator
     */
    public function __construct(
        ExpenseRepositoryInterface $expenseRepository,
        EventRepositoryInterface $eventRepository,
        AddExpenseValidator $validator
    ){
        $this->expenseRepository = $expenseRepository;
        $this->eventRepository = $eventRepository;
        $this->validator = $validator;
    }

    public function execute(AddExpenseContext $context): void
    {
        if (!$this->validator->isValid($context)) {
            throw new ValidationException($this->validator->getMessagesAsString());
        }

        $eventDTO = $this->eventRepository->findBySlug($context->getSlug());

        $event = Expense::fromUserInput(
            $eventDTO->getId(),
            $context->getDescription(),
            $context->getAmount(),
            $context->getPaidBy()
        );

        $this->expenseRepository->add($event);
    }
}