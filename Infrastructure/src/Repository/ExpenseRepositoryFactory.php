<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Psr\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;

class ExpenseRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : ExpenseRepository
    {
        return new ExpenseRepository(
            new TableGateway('db_expenses', $container->get('Zend\Db\Adapter\Adapter'))
        );
    }
}
