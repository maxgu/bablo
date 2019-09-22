<?php

declare(strict_types=1);

namespace Domain\Command\AddExpense;

use Domain\Repository\EventRepositoryInterface;
use Domain\Repository\ExpenseRepositoryInterface;
use Psr\Container\ContainerInterface;

class AddExpenseCommandFactory
{
    public function __invoke(ContainerInterface $container) : AddExpenseCommand
    {
        return new AddExpenseCommand(
            $container->get(ExpenseRepositoryInterface::class),
            $container->get(EventRepositoryInterface::class),
            $container->get(AddExpenseValidator::class)
        );
    }
}
