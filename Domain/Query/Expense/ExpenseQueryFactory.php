<?php

declare(strict_types=1);

namespace Domain\Query\Expense;

use Domain\Repository\ExpenseRepositoryInterface;
use Psr\Container\ContainerInterface;

class ExpenseQueryFactory
{
    public function __invoke(ContainerInterface $container) : ExpenseQuery
    {
        return new ExpenseQuery(
            $container->get(ExpenseRepositoryInterface::class)
        );
    }
}
