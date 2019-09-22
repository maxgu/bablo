<?php

declare(strict_types=1);

namespace Domain\Query\ReadEvent;

use Domain\Repository\EventRepositoryInterface;
use Psr\Container\ContainerInterface;

class ReadEventQueryFactory
{
    public function __invoke(ContainerInterface $container) : ReadEventQuery
    {
        return new ReadEventQuery(
            $container->get(EventRepositoryInterface::class),
            $container->get(ReadEventValidator::class)
        );
    }
}
