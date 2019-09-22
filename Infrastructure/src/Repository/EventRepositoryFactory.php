<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Psr\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;

class EventRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : EventRepository
    {
        return new EventRepository(
            new TableGateway('db_events', $container->get('Zend\Db\Adapter\Adapter'))
        );
    }
}
